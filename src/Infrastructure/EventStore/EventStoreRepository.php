<?php

namespace App\Infrastructure\EventStore;

use App\Domain\Task\EventSourcing\Entity\EventStore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventStore>
 */
class EventStoreRepository extends ServiceEntityRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, EventStore::class);
    }

    public function save(EventStore $eventStore)
    {
        $this->entityManager->persist($eventStore);
        $this->entityManager->flush();
    }

    //    /**
    //     * @return EventStore[] Returns an array of EventStore objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?EventStore
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
