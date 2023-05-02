<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\ScreenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ScreenRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
    ],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    paginationEnabled: false,
    security: "is_granted('ROLE_API_USER')"
)]
class Screen
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $title = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $gridColumns = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $gridRows = null;

    #[ORM\Column(type: 'json', nullable: true)]
    #[Groups(['read', 'write'])]
    private string $variant = '';

    #[ORM\ManyToMany(targetEntity: Tags::class, inversedBy: 'screens')]
    #[Groups(['read', 'write'])]
    private Collection $tags;

    #[ORM\ManyToOne(inversedBy: 'screens')]
    private ?ApiUser $apiUser = null;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

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

    public function getGridColumns(): ?int
    {
        return $this->gridColumns;
    }

    public function setGridColumns(int $gridColumns): self
    {
        $this->gridColumns = $gridColumns;

        return $this;
    }

    public function getGridRows(): ?int
    {
        return $this->gridRows;
    }

    public function setGridRows(int $gridRows): self
    {
        $this->gridRows = $gridRows;

        return $this;
    }

    public function getVariant(): string
    {
        return $this->variant;
    }

    public function setVariant(string $variant): self
    {
        $this->variant = $variant;

        return $this;
    }

    /**
     * @return Collection<int, Tags>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getApiUser(): ?ApiUser
    {
        return $this->apiUser;
    }

    public function setApiUser(?ApiUser $apiUser): self
    {
        $this->apiUser = $apiUser;

        return $this;
    }

    /**
     * Helper function to generate query parameter for frontend loading.
     *
     * @return string
     *   The URI for loading the screen
     */
    public function getScreenUrl(): string
    {
        $apiUser = $this->apiUser;
        if (!is_null($apiUser) && !is_null($this->id)) {
            return sprintf('?id=%s&key=%s', $this->id, $apiUser->getToken());
        }

        // Should never happen.
        return '';
    }
}
