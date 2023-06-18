<?php

namespace App\Entity;

use App\Repository\TreeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TreeRepository::class)
 */
class Tree
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"tree_list"})
     * @Groups({"tree","project_species"})
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"tree_list"})
     * @Groups({"tree"})
     * 
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tree_list"})
     * @Groups({"tree_read","tree","user_authentication","project_species"})
     */
    private $origin;

    /**
     * @ORM\Column(type="float")
     * @Groups({"tree_list"})
     * @Groups({"tree_read","project_species"})
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Specie::class, inversedBy="trees")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"tree_read","user_authentication"})
     */
    private $specie;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trees")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="tree", cascade={"remove"})
     * @Groups({"tree_list"})
     */
    private $pictures;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="trees")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user_authentication"})
     */
    private $project;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
   
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSpecie(): ?Specie
    {
        return $this->specie;
    }

    public function setSpecie(?Specie $specie): self
    {
        $this->specie = $specie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $picture->setTree($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getTree() === $this) {
                $picture->setTree(null);
            }
        }

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }
}
