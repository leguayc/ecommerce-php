<?php

namespace App\Controller;

use App\Entity\UserAdress;
use App\Form\UserAdressType;
use App\Repository\UserAdressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/adress")
 */
class UserAdressController extends AbstractController
{
    /**
     * @Route("/", name="user_adress_index", methods={"GET"})
     */
    public function index(UserAdressRepository $userAdressRepository): Response
    {
        return $this->render('user_adress/index.html.twig', [
            'user_adresses' => $userAdressRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_adress_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userAdress = new UserAdress();
        $form = $this->createForm(UserAdressType::class, $userAdress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($userAdress);
            $entityManager->flush();

            return $this->redirectToRoute('user_adress_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_adress/new.html.twig', [
            'user_adress' => $userAdress,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user_adress_show", methods={"GET"})
     */
    public function show(UserAdress $userAdress): Response
    {
        return $this->render('user_adress/show.html.twig', [
            'user_adress' => $userAdress,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_adress_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, UserAdress $userAdress, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserAdressType::class, $userAdress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_adress_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_adress/edit.html.twig', [
            'user_adress' => $userAdress,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user_adress_delete", methods={"POST"})
     */
    public function delete(Request $request, UserAdress $userAdress, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userAdress->getId(), $request->request->get('_token'))) {
            $entityManager->remove($userAdress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_adress_index', [], Response::HTTP_SEE_OTHER);
    }
}
