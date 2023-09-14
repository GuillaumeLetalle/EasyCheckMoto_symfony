<?php

namespace App\Repository;

use App\Entity\CT;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CT>
 *
 * @method CT|null find($id, $lockMode = null, $lockVersion = null)
 * @method CT|null findOneBy(array $criteria, array $orderBy = null)
 * @method CT[]    findAll()
 * @method CT[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CTRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CT::class);
    }

    public function setCtToTechnicienToNull($idTechnicien)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            UPDATE ct c set technicien_controle_id = null 
            WHERE c.technicien_controle_id = ' . $idTechnicien;
        $conn->executeQuery($sql);
    }

    public function setCtToVehiculeToNull($idMoto)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            UPDATE ct c set vehicule_controle_id = null 
            WHERE c.vehicule_controle_id = ' . $idMoto;
        $conn->executeQuery($sql);
    }

    public function setCtToClientToNull($idClient)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            UPDATE ct c set client_id = null 
            WHERE c.client_id = ' . $idClient;
        $conn->executeQuery($sql);
    }
}

