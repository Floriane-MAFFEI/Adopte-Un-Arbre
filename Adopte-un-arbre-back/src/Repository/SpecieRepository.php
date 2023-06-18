<?php

namespace App\Repository;

use App\Entity\Specie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Specie>
 *
 * @method Specie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Specie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Specie[]    findAll()
 * @method Specie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Specie::class);
    }

    public function add(Specie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Specie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Specie[] Returns an array of Specie objects
//     */
    public function findByProjectId($value): array
    {
         return $this->createQueryBuilder('s')
             ->join('s.trees', 't')
             ->andWhere('t.project=:projectid')
             ->setParameter('projectid', $value)
             ->getQuery()
             ->getResult()
         ;
    }

//    public function findOneBySomeField($value): ?Specie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
