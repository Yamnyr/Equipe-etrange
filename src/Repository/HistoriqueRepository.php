<?php

namespace App\Repository;

use App\Entity\Historique;
use App\Entity\Mission;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Historique>
 *
 * @method Historique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Historique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Historique[]    findAll()
 * @method Historique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Historique::class);
    }

    /**
     * Vérifie si une ligne avec les mêmes informations et la même date existe déjà.
     *
     * @param User $user
     * @param Mission $mission
     * @param \DateTimeInterface $dateAjoutMdj
     * @return bool
     */
    public function doesEntryExist(User $user, Mission $mission, \DateTimeInterface $dateAjoutMdj): bool
    {
        $result = $this->createQueryBuilder('h')
            ->select('COUNT(h.id) as count')
            ->andWhere('h.user = :user')
            ->andWhere('h.mission = :mission')
            ->andWhere('h.date_ajout_mdj = :dateAjoutMdj')
            ->setParameters([
                'user' => $user,
                'mission' => $mission,
                'dateAjoutMdj' => $dateAjoutMdj,
            ])
            ->getQuery()
            ->getScalarResult();

        return $result[0]['count'] > 0;
    }
//    /**
//     * @return Historique[] Returns an array of Historique objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Historique
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
