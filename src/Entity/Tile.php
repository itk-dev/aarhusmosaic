<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\GetRandomTilesController;
use App\Repository\TileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TileRepository::class)]
#[ApiFilter(OrderFilter::class, properties: ['updatedAt', 'name'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['tags.tag' => 'exact'])]
#[ApiResource(
    operations: [
        new Get(
            priority: 10,
        ),
        new GetCollection(
            uriTemplate: '/tiles/random',
            controller: GetRandomTilesController::class,
            openapiContext: [
                'parameters' => [
                    [
                        'name' => 'limit',
                        'type' => 'int',
                        'in' => 'query',
                        'required' => true,
                        'description' => 'Limit number of results (Max Tiles returned is 100)',
                        'example' => '15',
                    ],
                    [
                        'name' => 'tags.tag',
                        'in' => 'query',
                        'required' => false,
                        'schema' => [
                            'type' => 'string',
                        ],
                        'allowEmptyValue' => true,
                        'style' => 'form',
                        'explode' => true,
                        'allowReserved' => false,
                    ],
                    [
                        'name' => 'tags.tag[]',
                        'in' => 'query',
                        'required' => false,
                        'schema' => [
                            'type' => 'array',
                            'items' => [
                                'type' => 'string',
                            ],
                        ],
                        'allowEmptyValue' => true,
                        'style' => 'form',
                        'explode' => true,
                        'allowReserved' => false,
                    ],
                ],
            ],
            paginationEnabled: false,
            read: false,
            priority: 0,
            name: 'tilerandom'
        ),
        new GetCollection(),
    ],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    paginationEnabled: true,
    security: "is_granted('ROLE_API_USER')"
)]
class Tile
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $mail = null;

    #[ORM\Column(type: 'json', nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $extra = '';

    #[ORM\Column]
    private ?bool $accepted = null;

    #[ORM\ManyToMany(targetEntity: Tags::class, inversedBy: 'tiles')]
    #[Groups(['read', 'write'])]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getImage(): ?string
    {
        // HACK: add path here prefix to ensure image paths work both in API and easy admin.
        return '/tiles/'.$this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getExtra(): ?string
    {
        return $this->extra;
    }

    public function setExtra(?string $extra): self
    {
        $this->extra = $extra;

        return $this;
    }

    public function isAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function setAccepted(bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }

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
}
