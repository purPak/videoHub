<?php

namespace App\Controller;

use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="/")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getRepository(Video::class);
        $video = $entityManager->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'video' => $video
        ]);
    }
}
