<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;

/**
 * Filter to limit the number of results in the result set.
 */
final class LimitFilter extends AbstractFilter
{
    /**
     * Limit the max number of Tiles to load from the database in a single request.
     */
    private const MAX_ALLOWED_RESULTS = 100;

    /**
     * {@inheritDoc}
     */
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        $value = min(self::MAX_ALLOWED_RESULTS, $value);
        $queryBuilder->setMaxResults($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription(string $resourceClass): array
    {
        return [
            'limit' => [
                'property' => 'Limit',
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => true,
                'description' => 'Limit number of results (Max Tiles returned is 100)',
                'openapi' => [
                    'example' => '15',
                    'allowReserved' => false,
                    'allowEmptyValue' => true,
                    'explode' => false,
                ],
            ],
        ];
    }
}
