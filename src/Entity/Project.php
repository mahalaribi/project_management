<?php

namespace App\Entity;



use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: "App\Repository\ProjectRepository")]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:255)]
    #[Assert\NotBlank(message: "Le titre est obligatoire.")]
    private ?string $title = null;

#[ORM\Column(type: 'string', length: 255, nullable: true)]
private ?string $image = null; // Ici on stocke le chemin relatif ou le nom du fichier

    #[ORM\Column(type:"string", length:255)]
    #[Assert\NotBlank(message: "Le filename ou URL est obligatoire.")]
    private ?string $filenameOrUrl = null;

    #[ORM\Column(type:"integer")]
    #[Assert\NotNull(message: "Le nombre de tâches est obligatoire.")]
    #[Assert\Positive(message: "Le nombre de tâches doit être positif.")]
    private ?int $numberOfTasks = null;

    #[ORM\Column(type:"text", nullable:true)]
    private ?string $description = null;


    #[ORM\Column(length: 50)]
    #[Assert\Choice(choices: ['in_progress', 'completed', 'pending'], message: 'Statut invalide.')]
    private ?string $status = null;

    // Getters et setters

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getFilenameOrUrl(): ?string
    {
        return $this->filenameOrUrl;
    }

    public function setFilenameOrUrl(string $filenameOrUrl): self
    {
        $this->filenameOrUrl = $filenameOrUrl;

        return $this;
    }

    public function getNumberOfTasks(): ?int
    {
        return $this->numberOfTasks;
    }

    public function setNumberOfTasks(int $numberOfTasks): self
    {
        $this->numberOfTasks = $numberOfTasks;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
