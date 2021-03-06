<?php

namespace ArticleBundle\Entity;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends \Doctrine\ORM\EntityRepository
{

	public function getAdverts()
	{
	$query = $this->createQueryBuilder('a')
	  // Jointure sur l'attribut image
	  ->leftJoin('a.image', 'i')
	  ->addSelect('i')
	  ->addSelect('c')
	  ->orderBy('a.date', 'DESC')
	  ->getQuery()
	;

	return $query->getResult();
	}


	}
