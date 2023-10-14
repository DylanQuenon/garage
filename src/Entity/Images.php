<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cars $cars = null;

    #[ORM\Column(length: 255)]
    #[Assert\Url(message: "veuillez donner une URL valide")]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 10, max:255, minMessage:"Le titre de l'image doit faire plus de 10 caractères", maxMessage:"Le titre de l'image ne doit pas faire plus de 255 caractères")]
    private ?string $caption = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCars(): ?Cars
    {
        return $this->cars;
    }

    public function setCars(?Cars $cars): static
    {
        $this->cars = $cars;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(string $caption): static
    {
        $this->caption = $caption;

        return $this;
    }
}
