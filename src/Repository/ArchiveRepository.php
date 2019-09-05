<?php

namespace App\Repository;

use App\Entity\Archive;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Archive|null find($id, $lockMode = null, $lockVersion = null)
 * @method Archive|null findOneBy(array $criteria, array $orderBy = null)
 * @method Archive[]    findAll()
 * @method Archive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Archive::class);
    }

    public function sortieArchive(){
        $qb = $this->createQueryBuilder('a');
        $qb->select('nom', 'dateHeureDebut')
            ->from(Sortie::class);
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;


    }

}
