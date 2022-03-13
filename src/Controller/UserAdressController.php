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
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @Route("/user/adress")
 */
class UserAdressController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;
    private $requestStack;

    public function __construct(Security $security, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->security = $security;
    }

    /**
     * @Route("/", name="user_adress_index", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function index(UserAdressRepository $userAdressRepository, Request $request): Response
    {
        return $this->render('user_adress/index.html.twig', [
            'user_adresses' => $userAdressRepository->findBy(array('user' => $this->security->getUser())),
        ]);
    }

    /**
     * @Route("/new", name="user_adress_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userAdress = new UserAdress();
        $form = $this->createForm(UserAdressType::class, $userAdress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userAdress->setUser($this->security->getUser());
            $entityManager->persist($userAdress);
            $entityManager->flush();

            $redirectRoute = $request->query->get('redirectRoute');

            if ($redirectRoute != null && $redirectRoute != "") {
                return $this->redirectToRoute($redirectRoute);
            }

            return $this->redirectToRoute('user_adress_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_adress/new.html.twig', [
            'user_adress' => $userAdress,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user_adress_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(UserAdress $userAdress, Request $request): Response
    {
        if ($userAdress->getUser() != $this->security->getUser()) {
            return $this->redirectToRoute('user_adress_index');
        }

        return $this->render('user_adress/show.html.twig', [
            'user_adress' => $userAdress,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_adress_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, UserAdress $userAdress, EntityManagerInterface $entityManager): Response
    {
        if ($userAdress->getUser() != $this->security->getUser()) {
            return $this->redirectToRoute('user_adress_index');
        }

        $form = $this->createForm(UserAdressType::class, $userAdress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userAdress->setUser($this->security->getUser());
            $entityManager->flush();

            return $this->redirectToRoute('user_adress_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_adress/edit.html.twig', [
            'user_adress' => $userAdress,
            'form' => $form,
        ]);
    }
}
