<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[]
     */
    public function findByCategoryNameAndPriceLessThan(?string $categoryName = null, ?int $priceLessThan = null, int $limit = 5) : array
    {
        $qb = $this->createQueryBuilder('p');

        if ($categoryName) {
            $qb->innerJoin('p.category', 'c')
                ->where('c.name = :categoryName')
                ->setParameter('categoryName', $categoryName);
        }

        if ($priceLessThan) {
            $qb->andWhere('p.price <= :priceLessThan')
                ->setParameter('priceLessThan', $priceLessThan);
        }

        $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}
