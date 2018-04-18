<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Data;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanelController extends Controller
{
    /**
    * @Route("/panel", name="panel")
    */
    public function panel()
    {
        $emManager      = $this->getDoctrine()->getManager();
        $dataRepository = $emManager->getRepository(Data::class);

        $dateLastHour = new \DateTime();
        $dateLastHour->modify('-1 hour');

        $dateLastDay = new \DateTime();
        $dateLastDay->modify('-1 day');

        return $this->render('panel/panel.html.twig', [
            "datas" =>                      $dataRepository->findDataSince($dateLastHour),
            "distinctPiece" =>              $dataRepository->findDistinctDataPieceSince($dateLastHour),
            "countData" =>                  $dataRepository->getCountData(),
            "countPiece" =>                 $dataRepository->getCountDistinctPiece(),
            "countDistinctCapteur" =>       $dataRepository->getCountDistinctCapteur(),
            "minMaxAvgCapteur" =>           $dataRepository->findMinMaxAvgCapteurPiece($dateLastDay),
        ]);
    }



    /**
     * @Route("/data/{piece}/{capteur}/{donnee}")
     */
    public function data($piece, $capteur, $donnee)
    {
        $emManager = $this->getDoctrine()->getManager();

        if ($donnee <= 11000) {
            $data = new Data();
            $data
                ->setPiece($piece)
                ->setCapteur($capteur)
                ->setValeur($donnee / 100)
                ->setDateTime(new \DateTime());

            $emManager->persist($data);
            $emManager->flush();
        }

        return new Response('ok');
    }

}