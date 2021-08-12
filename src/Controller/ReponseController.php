<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Reponse;
use App\Repository\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class ReponseController extends AbstractController
{
    /**
     * @Route("/reponse", name="reponse")
     */
    public function index(ReponseRepository $repository): Response
    {
        $reponses = $repository->findAll();
        return $this->json($reponses, 200, [], ['groups' => 'reponse']);
    }
// dans create ci dessous dans la route c l'id du message
    /**
     * @Route("/reponse/create/{id}", name="create_reponse", methods={"POST"})
     */
    public function create(EntityManagerInterface $manager, Message $message, SerializerInterface $serialize, Request $request): Response
    {
        $json = $request->getContent();

        $reponse = $serialize->deserialize($json, Reponse::class, 'json');
        $reponse->setMessage($message);
        $manager->persist($reponse);
        $manager->flush();

        return $this->json($reponse, 200, [], ['groups' => 'reponse']);
    }

    /**
     * @Route ("/reponse/delete/{id}", name="delete_message", methods={"DELETE"})
     */
    public function delete(EntityManagerInterface $manager, Reponse $reponse): Response
    {
        $confirmation = "La réponse est bien supprimée";
        $manager->remove($reponse);
        $manager->flush();

        return $this->json($confirmation, 200);
    }
}
