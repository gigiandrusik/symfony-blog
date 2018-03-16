<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class StatisticRepository
 *
 * @package App\Repository
 */
class StatisticRepository extends EntityRepository
{
    /**
     * @return mixed
     */
    public function info()
    {
        $result = [];

        $statistics = $this->createQueryBuilder('statistic')
            ->select(['statistic.userAgent', 'count(statistic.userAgent) as total'])
            ->groupBy('statistic.userAgent')
            ->getQuery()
            ->execute();

        foreach ($statistics as $statistic) {
            $result[$statistic['userAgent']] = $statistic['total'];
        }

        return $result;
    }
}