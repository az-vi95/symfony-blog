<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 *
 * - Validation : contrainte d'unicité sur le nom
 * - requete SQL pour vérifier si l'entité est unique
 * @UniqueEntity(fields={"name"}, message="cette catégorie existe deja")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     *
     * -Validation : non vide
     * @Assert\NotBlank(message="Le nom est obligatoire")
     *
     * -Validation : nombre de caracteres
     * @Assert\Length(max="20", min="",maxMessage="Le nom ne doit pas dépasser {{ limit }}
      caracteres ")
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
