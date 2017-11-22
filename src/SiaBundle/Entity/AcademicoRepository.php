<?php

namespace SiaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Academico Repository
 *
 */
class AcademicoRepository extends EntityRepository
{

    public function findAllOrderedByApellido()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT a FROM SiaBundle:Academico a ORDER BY a.apellido ASC'
            )
            ->getResult();
    }

    public function findByAcademico($academico_id)
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT s FROM SiaBundle:Solicitud s
                    JOIN s.academico a
                    WHERE a.id = :id
                    ORDER BY s.tipo ASC, s.fechaInicio ASC"
            )
            ->setParameter('id', $academico_id)
            ->getResult();
    }
}

