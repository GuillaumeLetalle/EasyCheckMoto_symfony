<?php

namespace App\Repository;

use App\Entity\Moto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Moto>
 *
 * @method Moto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Moto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Moto[]    findAll()
 * @method Moto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Moto::class);
    }

    public function removeMotoClient($idUser)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            DELETE FROM moto 
            WHERE moto.client_id = '. $idUser;
        $conn->executeQuery($sql);
    }
}
