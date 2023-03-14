<?php

namespace App\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Tile;
use Doctrine\ORM\QueryBuilder;

/**
 * Doctrine extension to filter out all Tiles that have not been accepted from API requests.
 */
class AcceptedTileExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * {@inheritDoc}
     */
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * Filter out Tile that has not yet been marked as accepted.
     *
     * @param queryBuilder $queryBuilder
     *   The query builder for the current query
     * @param string $resourceClass
     *   The resource the query runs against
     *
     * @return void
     */
    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if (Tile::class !== $resourceClass) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.accepted = :accepted', $rootAlias));
        $queryBuilder->setParameter('accepted', true);
    }
}
