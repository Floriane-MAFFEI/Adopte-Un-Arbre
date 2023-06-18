<?php

namespace App\Entity;

use App\Repository\OrganismRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=OrganismRepository::class)
 */
class Organism
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"Organism","organism_list"})
*/
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Organism","organism_list"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Organism"})
     */
    private $siret_insee;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Organism"})
     */
    private $adress;

    /**
     * @ORM\Column(type="string")
     * @Groups({"Organism"})
     */
    private $zip_code;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Organism"})
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     * @Groups({"Organism"})
     */
    private $phone_number;

    /**
     * @ORM\Column(type="text")
     * @Groups({"Organism"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Organism"})
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="organism")
     * @Groups({"Organism"})
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="organism")
     *  @Groups({"Organism"})
     */
    private $users;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getSiretInsee(): ?string
    {
        return $this->siret_insee;
    }

    public function setSiretInsee(string $siret_insee): self
    {
        $this->siret_insee = $siret_insee;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setOrganism($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getOrganism() === $this) {
                $project->setOrganism(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setOrganism($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getOrganism() === $this) {
                $user->setOrganism(null);
            }
        }

        return $this;
    }
}
