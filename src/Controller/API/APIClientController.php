<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;

use App\Entity\ClientRelease;
use App\Entity\Song;
use App\Entity\SongReview;
//use App\Entity\SongSpinPlay;
use App\Entity\User;
use App\Entity\Promo;

class APIClientController extends AbstractController
{
    /**
     * @Route("/api/latestVersion/{platform}", name="api.latestVersion")
     * @Route("/api/latestVersion/{platform}/")
     */
    public function latestVersion(string $platform)
    {   
        $em = $this->getDoctrine()->getManager();
        $data = [];

        $latestVersion = $em->getRepository(ClientRelease::class)->findOneBy(array('platform' => $platform), array('majorVersion' => 'DESC', 'minorVersion' => 'DESC', 'patchVersion' => 'DESC'));

        if($latestVersion) {
            $data = $latestVersion->getJSON();

            $response = new JsonResponse(['version' => $this->getParameter('api_version'), 'status' => 200, 'data' => $data]);
        } else {
            $response = new JsonResponse(['version' => $this->getParameter('api_version'), 'status' => 404, 'data' => []]);
        }
        return $response;
    }
}
