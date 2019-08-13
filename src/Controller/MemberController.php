<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserFormType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MemberController extends AbstractController
{
    /**
     * @Route("/member", name="app_member")
     */
    public function index()
    {
        return $this->render('member/index.html.twig', [
            'controller_name' => 'MemberController',
        ]);
    }

    /**
     * @Route("/member/edit/{id}", name="app_member_edit")
     * @ParamConverter("user", options={"mapping"={"id"="id"}})
     */
    public function edit(User $user, Request $request,UserPasswordEncoderInterface $passwordEncoder, LoggerInterface $logger)
    {

        $form = $this->createForm(RegisterUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_member');
        }

        return $this->render('member/edit.html.twig', [
            'controller_name' => 'MemberController',
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/member/delete/{id}", name="app_member_delete")
     * @ParamConverter("user", options={"mapping"={"id"="id"}})
     */
    public function remove(User $user)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        return $this->redirectToRoute('app_login');
    }


}
