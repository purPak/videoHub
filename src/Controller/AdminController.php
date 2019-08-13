<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Video;
use App\Form\CategoryFormType;
use App\Form\RegisterUserFormType;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="app_admin")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getRepository(User::class);
        $user = $entityManager->findAll();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function seeAllUser()
    {
        $entityManager = $this->getDoctrine()->getRepository(User::class);
        $user = $entityManager->findAll();
        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/user/new", name="admin_user_create")
     */
    public function newUser(Request $request, UserPasswordEncoderInterface $passwordEncoder, LoggerInterface $logger)
    {
        $user = new User();
        $form = $this->createForm(RegisterUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Your account has been created. You can now login.');
            $logger->info(sprintf('User registered: %s', $user->getEmail()));
            return $this->redirectToRoute('admin_users' );
        }

        return $this->render('security/register.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/admin/user/{id}/delete", name="admin_user_delete")
     * @ParamConverter("user", options={"mapping"={"id"="id"}})
     */
    public function deleteUser(User $user)
    {
        $entityManager = $this->getDoctrine()->getManager();
       // $user = $entityManager->findOneBy();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('admin_users');
    }


    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function seeAllCategories()
    {
        $entityManager = $this->getDoctrine()->getRepository(Category::class);
        $category = $entityManager->findAll();
        return $this->render('admin/category.html.twig', [
            'controller_name' => 'AdminController',
            'category' => $category
        ]);
    }

    /**
     * @Route("/admin/category/new", name="admin_category_create")
     */
    public function newCategory(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('admin_categories' );
        }

        return $this->render('admin/editCategory.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/admin/category/{id}/delete", name="admin_category_delete")
     * @ParamConverter("category", options={"mapping"={"id"="id"}})
     */
    public function deleteCategory(Category $category)
    {
        $entityManager = $this->getDoctrine()->getManager();
        // $user = $entityManager->findOneBy();
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('admin_categories');
    }

    /**
     * @Route("/admin/video", name="admin_video")
     */
    public function seeAllVideos()
    {
        $entityManager = $this->getDoctrine()->getRepository(Video::class);
        $video = $entityManager->findAll();
        return $this->render('admin/video.html.twig', [
            'controller_name' => 'AdminController',
            'video' => $video
        ]);
    }

    /**
     * @Route("/admin/video/{id}/delete", name="admin_video_delete")
     * @ParamConverter("video", options={"mapping"={"id"="id"}})
     */
    public function deleteVideo(Video $video)
    {
        $entityManager = $this->getDoctrine()->getManager();
        // $user = $entityManager->findOneBy();
        $entityManager->remove($video);
        $entityManager->flush();

        return $this->redirectToRoute('admin_users');
    }

}
