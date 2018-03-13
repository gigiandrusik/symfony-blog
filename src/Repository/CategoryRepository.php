<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CategoryRepository
 *
 * @package AppBundle\Repository
 */
class CategoryRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('category')->orderBy('category.name', 'ASC');
    }
}