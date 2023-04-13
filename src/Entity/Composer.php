<?php

namespace App\Entity;

use App\Repository\ComposerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: ComposerRepository::class)]
class Composer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    private ?\DateTimeImmutable $dateOfBbirth = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\OneToMany(mappedBy: 'composer', targetEntity: Symphony::class, orphanRemoval: true)]
    #[Ignore]
    private Collection $symphonies;

    public function __construct()
    {
        $this->symphonies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDateOfBbirth(): ?\DateTimeImmutable
    {
        return $this->dateOfBbirth;
    }

    public function setDateOfBbirth(\DateTimeImmutable $dateOfBbirth): self
    {
        $this->dateOfBbirth = $dateOfBbirth;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, Symphony>
     */
    public function getSymphonies(): Collection
    {
        return $this->symphonies;
    }

    public function addSymphony(Symphony $symphony): self
    {
        if (!$this->symphonies->contains($symphony)) {
            $this->symphonies->add($symphony);
            $symphony->setComposer($this);
        }

        return $this;
    }

    public function removeSymphony(Symphony $symphony): self
    {
        if ($this->symphonies->removeElement($symphony)) {
            // set the owning side to null (unless already changed)
            if ($symphony->getComposer() === $this) {
                $symphony->setComposer(null);
            }
        }

        return $this;
    }
}
