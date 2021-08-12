<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReponseRepository::class)
 */
class Reponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"message", "reponse"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"message", "reponse"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"message", "reponse"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Message::class, inversedBy="reponses")
     * @ORM\JoinColumn(nullable=false)
     * @Groups ({"reponse"})
     */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): self
    {
        $this->message = $message;

        return $this;
    }
}
