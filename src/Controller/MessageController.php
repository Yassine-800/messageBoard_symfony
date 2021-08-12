<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message_index")
     */
    public function index(MessageRepository $repository): Response
    {
        $messages = $repository->findAll();

        return $this->json($messages, 200, [], ["groups" => "message"]);
    }

    /**
     * @Route("/message/create", name="create_message", methods={"POST"})
     */
    public function create(EntityManagerInterface $manager, Request $request, SerializerInterface $serializer): Response
    {
        $json = $request->getContent();

        $message = $serializer->deserialize($json, Message::class, 'json');
        $manager->persist($message);
        $manager->flush();

        return $this->json($message, 200);
    }

    /**
     * @Route ("/message/delete/{id}", name="delete_message", methods={"DELETE"})
     */
    public function delete(EntityManagerInterface $manager, Message $message): Response
    {
        $reponse = "C'est bien supprimé";
        $manager->remove($message);
        $manager->flush();

        return $this->json($reponse, 200);
    }

    /**
     * @Route("/message/update/{id}", name="update_message", methods={"PATCH"})
     */
    public function update(EntityManagerInterface $manager, Message $message, SerializerInterface $serializer, Request $request): Response
    {
        $json = $request->getContent();
        $newMessage = $serializer->deserialize($json, Message::class, 'json');

        $message->setTitle($newMessage->getTitle());
        $message->setContent($newMessage->getContent());

        $manager->persist($message);
        $manager->flush();

        return $this->json($message, 200);


    }
}
