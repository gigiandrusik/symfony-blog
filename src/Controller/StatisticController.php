<?php

namespace App\Controller;

use App\Entity\Statistic;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class StatisticController
 *
 * @package App\Controller
 */
class StatisticController extends Controller
{
    /**
     * @Route("/statistic", name="statistic")
     */
    public function statistic()
    {
        $statistic = $this->getDoctrine()->getRepository(Statistic::class);

        return $this->render('statistic/index.html.twig', [
            'statistics' => $statistic->findAll(),
            'info' => $statistic->info()
        ]);
    }
}