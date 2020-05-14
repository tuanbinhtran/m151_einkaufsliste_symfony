<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Item;
use Doctrine\ORM\EntityManagerInterace;
use AppBundle\Database;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ItemController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function listAction(Request $request, Database $db)
    {
        $sql = "SELECT ItemId, Name, Anzahl FROM tut_items";
        $items = [];

        foreach ($db->connection->query($sql) as $row) {
            array_push($items, $row);
        }

        return $this->render('item/list.html.php', [
            'items' => $items,
        ]);
    }

    /**
     * @Route("/items/add", methods={"POST"})
     */
    public function addAction(Request $request, Database $db)
    {
        if (!$request->isMethod("POST")) {
            return new Response("Invalid method", 405);
        }

        $name = $request->request->get('name');
        $anzahl = $request->request->get('anzahl');

        if (!is_numeric($anzahl) || !$anzahl || !is_string($name)) {
            return new Response("Error: invalid input", 400);
        }

        $query = "INSERT INTO tut_items (Name, Anzahl) VALUES (?, ?)";
        $statement = $db->connection->prepare($query);
        $statement->bind_param("si", $name, $anzahl);

        if ($statement->execute() === TRUE) {
            $statement->free_result();
            $statement->close();
            return $this->redirectToRoute('list');
        } else {
            return new Response("Error: " . $query . "<br>" . $db->connection->error);
        }
    }

    /**
     * @Route("/items/remove/{id}")
     */
    public function removeAction(Request $request, Database $db)
    {
        $itemId = $request->attributes->get('id');

        if (!is_numeric($itemId) || !$itemId) {
            return new Response("Error: invalid input", 400);
        }

        $query = "DELETE FROM tut_items WHERE ItemId = ?";
        $statement = $db->connection->prepare($query);
        $statement->bind_param("i", $itemId);

        if ($statement->execute() === TRUE) {
            $statement->free_result();
            $statement->close();
            return $this->redirectToRoute('list');
        } else {
            return new Response("Error: " . $query . "<br>" . $db->connection->error);
        }
    }

    /**
     * @Route("/items/edit/{id}", methods={"GET"})
     */
    public function editFormAction(Request $request, Database $db)
    {
        if (!$request->isMethod("GET")) {
            return new Response("Invalid method", 405);
        }

        $itemId = $request->attributes->get('id');

        if (!is_numeric($itemId) || !$itemId) {
            return new Response("Error: invalid input", 400);
        }

        $query = "SELECT ItemId, Name, Anzahl FROM tut_items WHERE ItemId = ? LIMIT 1";
        $statement = $db->connection->prepare($query);
        $statement->bind_param("i", $itemId);

        if ($statement->execute() === TRUE) {
            $result = $statement->get_result();
            $item = $result->fetch_object();
            $statement->free_result();
            $statement->close();

            return $this->render('item/edit.html.php', [
                'item' => $item,
            ]);
        } else {
            return new Response("Error: " . $query . "<br>" . $db->connection->error);
        }
    }

    /**
     * @Route("/items/edit/{id}", methods={"POST"})
     */
    public function editFormActionPost(Request $request, Database $db)
    {
        if (!$request->isMethod("POST")) {
            return new Response("Invalid method", 405);
        }

        $itemId =   $request->attributes->get('id');
        $name =     $request->request->get('name');
        $anzahl =   $request->request->get('anzahl');

        if (!is_numeric($itemId) || !$itemId || !is_numeric($anzahl) || !is_string($name)) {
            return new Response("Error: invalid input", 400);
        }

        $query = "UPDATE tut_items SET Name = ?, Anzahl = ? WHERE ItemId = ?";
        $statement = $db->connection->prepare($query);
        $statement->bind_param("sii", $name, $anzahl, $itemId);

        if ($statement->execute() === TRUE) {
            $statement->free_result();
            $statement->close();
            return $this->redirectToRoute('list');
        } else {
            return new Response("Error: " . $query . "<br>" . $db->connection->error);
        }
    }
}
