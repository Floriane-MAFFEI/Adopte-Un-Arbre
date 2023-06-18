<?php

namespace App\Entity;

use App\Repository\SpecieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SpecieRepository::class)
 */
class Specie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"specie","specie_list","project_species"})
    
    */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"specie_list","specie","user_authentication","project_species"})
     * 
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"specie_list", "specie","user_authentication" ,"project_species"})
     */
    private $scientific_name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"specie_list","specie","user_authentication","project_species"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Tree::class, mappedBy="specie", cascade={"remove"})
     * @Groups({"specie_list"})
     */
    private $trees;

    public function __construct()
    {
        $this->trees = new ArrayCollection();
    }

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

    public function getScientificName(): ?string
    {
        return $this->scientific_name;
    }

    public function setScientificName(string $scientific_name): self
    {
        $this->scientific_name = $scientific_name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Tree>
     */
    public function getTrees(): Collection
    {
        return $this->trees;
    }

    public function addTree(Tree $tree): self
    {
        if (!$this->trees->contains($tree)) {
            $this->trees[] = $tree;
            $tree->setSpecie($this);
        }

        return $this;
    }

    public function removeTree(Tree $tree): self
    {
        if ($this->trees->removeElement($tree)) {
            //set the owning side to null (unless already changed)
            if ($tree->getSpecie() === $this) {
                $tree->setSpecie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
