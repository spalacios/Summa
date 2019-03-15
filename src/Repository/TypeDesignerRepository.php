<?php

namespace App\Repository;

use App\Entity\TypeDesigner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeDesigner|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeDesigner|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeDesigner[]    findAll()
 * @method TypeDesigner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeDesignerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeDesigner::class);
    }

    /**
     * @param $object
     * @param array $arguments
     */
    public function delete($object, array $arguments = ['flush'=>true])
    {
        $this->_em->remove($object);

        if ($arguments['flush'] === true) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return TypeDesigner[] Returns an array of TypeDesigner objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeDesigner
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
