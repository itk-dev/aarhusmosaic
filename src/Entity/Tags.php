<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\TagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TagsRepository::class)]
#[ORM\UniqueConstraint(name: 'tag', columns: ['tag'])]
#[ApiResource(
    operations: [
        new GetCollection(),
    ],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    security: "is_granted('ROLE_API_USER')"
)]
class Tags
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('read')]
    private ?string $tag = null;

    #[ORM\ManyToMany(targetEntity: Tile::class, mappedBy: 'tags')]
    private Collection $tiles;

    #[ORM\ManyToMany(targetEntity: Screen::class, mappedBy: 'tags')]
    private Collection $screens;

    public function __construct()
    {
        $this->tiles = new ArrayCollection();
        $this->screens = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->tag ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getTiles(): Collection
    {
        return $this->tiles;
    }

    public function addTile(Tile $tile): self
    {
        if (!$this->tiles->contains($tile)) {
            $this->tiles->add($tile);
            $tile->addTag($this);
        }

        return $this;
    }

    public function removeTile(Tile $tile): self
    {
        if ($this->tiles->removeElement($tile)) {
            $tile->removeTag($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Screen>
     */
    public function getScreens(): Collection
    {
        return $this->screens;
    }

    public function addScreen(Screen $screen): self
    {
        if (!$this->screens->contains($screen)) {
            $this->screens->add($screen);
            $screen->addTag($this);
        }

        return $this;
    }

    public function removeScreen(Screen $screen): self
    {
        if ($this->screens->removeElement($screen)) {
            $screen->removeTag($this);
        }

        return $this;
    }
}
