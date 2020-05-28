<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Item;
use Doctrine\ORM\EntityManagerInterace;
use AppBundle\Database;
use DateTime;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    /**
     * @Route("/comments/{itemId}", name="comments")
     */
    public function getCommentsForItem(Request $request, Database $db)
    {
        if (!$this->checkAuth($request)) {
            return $this->redirect('/login');
        }

        $sql = "SELECT UserId, Comment, Timestamp FROM tut_comments ORDER BY Timestamp DESC";
        $comments = [];

        foreach ($db->connection->query($sql) as $row) {
            $timestamp = DateTime::createFromFormat("Y-m-d H:i:s", $row['Timestamp']);
            $row['Timestamp'] = $timestamp->format('d.m.y, H:i:s');
            array_push($comments, $row);
        }

        return $comments;
    }

    /**
     * @Route("/comments/add/{itemId}", methods={"POST"})
     */
    public function addComment(Request $request, Database $db)
    {
        if (!$this->checkAuth($request)) {
            return $this->redirect('/login');
        }

        $session = $request->getSession();

        $itemId =   $request->attributes->get('itemId');
        $comment = $request->request->get('comment');
        $userId = $session->get('userId');

        if (!is_numeric($itemId) || !$itemId || !is_string($comment)) {
            return new Response("Error: invalid input", 400);
        }

        $query = "INSERT INTO tut_comments (UserId, ItemId, Comment) VALUES (?, ?, ?)";
        $statement = $db->connection->prepare($query);
        $statement->bind_param("iis", $userId, $itemId, $comment);

        if ($statement->execute() === TRUE) {
            $statement->free_result();
            $statement->close();
            return $this->redirect('/items/detail/' . $itemId);
        } else {
            return new Response("Error: " . $query . "<br>" . $db->connection->error);
        }
    }

    /**
     * @Route("/comments/delete/{commentId}", methods={"GET"})
     */
    public function deleteComment(Request $request, Database $db)
    {
        if (!$this->checkAuth($request)) {
            return $this->redirect('/login');
        }

        $session = $request->getSession();
        $commentId =   $request->attributes->get('commentId');
        $userId = $session->get('userId');

        if (!is_numeric($commentId) || !$commentId) {
            return new Response("Error: invalid input", 400);
        }

        $queryCheck = "SELECT * FROM tut_comments WHERE CommentId = ?";
        $statementCheck = $db->connection->prepare($queryCheck);
        $statementCheck->bind_param("i", $commentId);
        $statementCheck->execute();
        $comment = $statementCheck->get_result();
        $comment = $comment->fetch_object();

        if ($comment == null) {
            return new Response("Comment does not exist");
        }

        $query = "DELETE FROM tut_comments WHERE CommentId = ?";
        $statement = $db->connection->prepare($query);
        $statement->bind_param("i", $commentId);

        if ($statement->execute() === TRUE) {
            $statement->free_result();
            $statement->close();
            return $this->redirect('/items/detail/');
        } else {
            return new Response("Error: " . $query . "<br>" . $db->connection->error);
        }
    }

    private function checkAuth(Request $request) {
        $session = $request->getSession();

        return $session->has('userId');
    }
}
