<?php

namespace App\Repository;

use App\Entity\Credential;
use Doctrine\ORM\QueryBuilder;
use App\Entity\EntityInterface;
use ArrayIterator;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Credential|null find($id, $lockMode = null, $lockVersion = null)
 * @method Credential|null findOneBy(array $criteria, array $orderBy = null)
 * @method Credential[]    findAll()
 * @method Credential[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CredentialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Credential::class);
    }

    public function getFindByQueryBuilder(array $criteria): QueryBuilder
    {
        $alias = 'c';

        $expressions = [];
        foreach ($criteria as $name => $value) {
            $tmpExpression = $value instanceof EntityInterface ? $alias.'.'.$name .' = '. $value->getId() : $alias.'.'.$name .' = '. $value;
            $expressions[] = $tmpExpression;
        }

        $queryBuilder = $this->createQueryBuilder($alias);

        foreach ($expressions as $expression) {
            $queryBuilder->andWhere($expression);
        }

        return $queryBuilder;
    }

    public function findPaginatedBy(array $criteria, int $page = 1, int $maxPageSize = 50): Paginator
    {
		$firstResult = ($page - 1) * $maxPageSize;

		$queryBuilder = $this->getFindByQueryBuilder($criteria);
		
		// Add the first and max result limits
		$queryBuilder->setFirstResult($firstResult);
		$queryBuilder->setMaxResults($maxPageSize);
		
		// Generate the Query
		$query = $queryBuilder->getQuery();
		
		// Generate and return the Paginator
		return new Paginator($query);
    }

    // /**
    //  * @return Credential[] Returns an array of Credential objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Credential
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
