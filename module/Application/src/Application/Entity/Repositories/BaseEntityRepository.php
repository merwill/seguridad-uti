<?php

namespace Application\Entity\Repositories;

use Doctrine\ORM\EntityRepository;

/**
 * BaseEntityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BaseEntityRepository extends EntityRepository
{
	protected $em = null;

    function __construct($em)
    {
        $this->em = $em;
    }

}
