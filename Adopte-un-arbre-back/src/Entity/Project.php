<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"project_list","project","project_species", "user_authentication"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"project_list"})
     *  @Groups({"project_read","project","project_species", "project_species"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"project_list", "project","project_species"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"project_list", "project","project_species"})
     */
    private $localization;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"project_list", "project","project_species"})
     */
    private $stock;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"project_list","project","project_species"})
     */
    private $start_at;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"project_list","project","project_species"})
     */
    private $evolution;

    /**
     * @ORM\Column(type="text")
     * @Groups({"project_list"})
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Tree::class, mappedBy="project")
     * @Groups({"project_list"})
     */
    private $trees;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="project")
     * @Groups({"project_list","project"})
     */
    private $pictures;

    /**
     * @ORM\ManyToOne(targetEntity=Organism::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"project_list","project"})
     */
    private $organism;

    public function __construct()
    {
        $this->trees = new ArrayCollection();
        $this->pictures = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLocalization(): ?string
    {
        return $this->localization;
    }

    public function setLocalization(string $localization): self
    {
        $this->localization = $localization;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->start_at;
    }

    public function setStartAt(\DateTimeImmutable $start_at): self
    {
        $this->start_at = $start_at;

        return $this;
    }

    public function getEvolution(): ?int
    {
        return $this->evolution;
    }

    public function setEvolution(int $evolution): self
    {
        $this->evolution = $evolution;

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
            $tree->setProject($this);
        }

        return $this;
    }

    public function removeTree(Tree $tree): self
    {
        if ($this->trees->removeElement($tree)) {
            // set the owning side to null (unless already changed)
            if ($tree->getProject() === $this) {
                $tree->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setProject($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getProject() === $this) {
                $picture->setProject(null);
            }
        }

        return $this;
    }

    public function getOrganism(): ?Organism
    {
        return $this->organism;
    }

    public function setOrganism(?Organism $organism): self
    {
        $this->organism = $organism;

        return $this;
    }

    /**
     * @Groups("projet_trees")
     */

    public function getSpecies():array
    {
        $trees = $this->trees;
        $species = [];
    /**
     * @var Tree $tree
     */
        foreach ($trees as $tree) {
            $species[] = $tree->getSpecie();
        }
        return array_unique($species);
    }


    /**
     * 
     * @Groups("projet_trees")
     */
    public function getTreesStock()
    
    {
        return count($this->trees);
    }
}
