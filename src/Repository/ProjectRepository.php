<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

//    /**
//     * @return Project[] Returns an array of Project objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Project
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findByFilters(?string $title, ?string $status, ?string $filename): array
{
    $qb = $this->createQueryBuilder('p');

    if ($title) {
        $qb->andWhere('p.title LIKE :title')
           ->setParameter('title', '%' . $title . '%');
    }

    if ($status) {
        $qb->andWhere('p.status = :status')
           ->setParameter('status', $status);
    }

    if ($filename) {
        $qb->andWhere('p.filenameOrUrl LIKE :filename')
           ->setParameter('filename', '%' . $filename . '%');
    }

    return $qb->getQuery()->getResult();
}

}
