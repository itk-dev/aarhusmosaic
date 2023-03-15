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
class RandomTileExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, Operation $operation = null, array $context = []): void
    {
        // Do not load random when single Tile is requested by Id.
    }

    /**
     * {@inheritDoc}
     */
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * Added orderBy random to query limited to tile resources.
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

        $queryBuilder->addSelect('RAND() as HIDDEN rand')->orderBy('rand');
    }
}