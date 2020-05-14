<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Database;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthController extends AbstractController
{
    private $salt = "3sAxVggAfGkzxkh)zP@4.uI8Gitmi0";

    /**
     * @Route("/register", methods={"POST"});
     */
    public function registerAction(Request $request, Database $db)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        if (!is_string($username) || !is_string($password)) {
            return new Response("Error: invalid input", 400);
        }

        $password = md5($this->salt . $password);

        $query = "INSERT INTO tut_user (Username, Password) VALUES (?, ?)";
        $statement = $db->connection->prepare($query);
        $statement->bind_param("ss", $username, $password);

        if ($statement->execute() === TRUE) {
            $statement->free_result();
            $statement->close();
            return $this->redirectToRoute('/login');
        } else {
            return new Response("Error: " . $query . "<br>" . $db->connection->error);
        }
    }

    /**
     * @Route("/register", methods={"GET"});
     */
    public function registerRender(Request $request)
    {
        if ($this->checkAuth($request)) {
            $this->redirectToRoute('/list');
        }

        return $this->render('user/register.html.php');
    }


    /**
     * @Route("/login", methods={"POST"});
     */
    public function loginAction(Request $request, Database $db)
    {


        $username = $request->get('username');
        $password = $request->get('password');

        if (!is_string($username) || !is_string($password)) {
            return new Response("Error: invalid input", 400);
        }

        $password = md5($this->salt . $password);

        $query = "SELECT UserId FROM tut_user WHERE username = ? AND password = ?";
        $statement = $db->connection->prepare($query);
        $statement->bind_param("ss", $username, $password);

        if ($statement->execute() === TRUE) {
            $result = $statement->get_result();
            $userData = $result->fetch_assoc();

            $statement->free_result();
            $statement->close();

            if ($userData && $userData['UserId']) {
                $session = $request->getSession();

                $session->set('userId', $userData['UserId']);
                $session->set('username', $username);

                return $this->redirectToRoute('list');
            }
        } else {
            return new Response("Error: " . $query . "<br>" . $db->connection->error);
        }
    }


    /**
     * @Route("/login", methods={"GET"})
     */
    public function loginRender(Request $request)
    {
        if ($this->checkAuth($request)) {
            $this->redirectToRoute('/list');
        }

        return $this->render('user/login.html.php');
    }

    /**
     * @Route("/logoute")
     */
    public function logoutAction(Request $request)
    {
        $session = $request->getSession();
        $session->clear();

        return $this->redirect('/login');
    }

    private function checkAuth(Request $request)
    {
        $session = $request->getSession();

        return $session->has('userId');
    }


}
