<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Video;
use App\Form\VideoFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class VideoController extends AbstractController
{
    /**
     * @Route("/video", name="app_video")
     */
    public function Addvideo(Request $request)
    {
        $video = new Video();
        $form = $this->createForm(VideoFormType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();
            return $this->redirectToRoute('/' );
        }

        return $this->render('video/index.html.twig',
            ['form' => $form->createView()]
        );
    }


}
