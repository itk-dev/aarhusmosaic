<?php

namespace App\Repository;

use App\Entity\Tile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tile>
 *
 * @method Tile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tile[]    findAll()
 * @method Tile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tile::class);
    }

    public function save(Tile $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Tile $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Get random Tiles.
     *
     * @param int $limit
     *   Max number of Tiles to fetch
     * @param array $tags
     *   Array of tags to filter on
     *
     * @return array
     *   Well Tiles
     */
    public function getRandomTiles(int $limit, array $tags): array
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->addSelect('RAND() as HIDDEN rand')->orderBy('rand')
            ->andWhere('t.accepted = true')
            ->innerJoin('t.tags', 'tt');

        if (!empty($tags)) {
            $queryBuilder->andWhere('tt.tag IN (:tagNames)');
        }

        $query = $this->getEntityManager()
            ->createQuery($queryBuilder->getDQL())
            ->setFirstResult(0)
            ->setMaxResults($limit);
        if (!empty($tags)) {
            $query->setParameter('tagNames', $tags);
        }
        $paginator = new Paginator($query);

        $tiles = [];
        foreach ($paginator as $tile) {
            $tiles[] = $tile;
        }

        return $tiles;
    }
}
