<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
class DashboardController extends AbstractController
{
    #[Route('/', name:'app_dashboard')]
    // #[Route('/', name:'index')]
    public function index(ChartBuilderInterface $chartBuilder): Response
    {
        //gesion des conneions des utilisateurs
        $user = $this->getUser();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // dd($user);

        //graphique 
        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [1, 10, 5, 2, 20, 80, 45],
                ],
            ],
        ]);
        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
            'animation' => [
                'duration' => 2000, // Durée de l'animation en millisecondes
                'easing' => 'easeInOutQuad', // Type d'animation
            ],
        ]);

        $chart_circle = $chartBuilder->createChart(Chart::TYPE_PIE);
        $chart_circle->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [1, 10, 5, 2, 20, 80, 45],
                ],
            ],
        ]);
        $chart_circle->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
            'animation' => [
                'duration' => 2000, // Durée de l'animation en millisecondes
                'easing' => 'easeInOutQuad', // Type d'animation
            ],
        ]);

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'chart' => $chart,
            'chart_circle' => $chart_circle

        ]);
    }
}
