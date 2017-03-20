<?php

namespace RolesBundle\Repository;


use Doctrine\ORM\EntityRepository;

/**
 * UtilisateurRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UtilisateurRepository extends \Doctrine\ORM\EntityRepository
{


	public function test_connexion($email, $mdp)
    {
        $response = $this->createQueryBuilder('u')
	                    ->where("u.email = ?1")
	                    ->andWhere("u.mdp = ?2")
	                    ->setParameter(1, $email)
	                    ->setParameter(2, $mdp)
	                    ->getQuery()
	                    ->getResult();

	    return $response;
	    
    }

    public function count_nb_user()
    {
        $response = $this->createQueryBuilder('u')
	                    ->select("COUNT(u)")
	                    ->getQuery()
                        ->getSingleScalarResult();

	    return $response;
	    
    }

}
