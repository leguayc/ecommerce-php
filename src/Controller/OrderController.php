<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserAdressRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

#[Route('/order')]
class OrderController extends AbstractController
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

    #[Route('/', name: 'order_index', methods: ['GET'])]
    #[IsGranted("ROLE_USER")]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findBy(array('user' => $this->security->getUser())),
        ]);
    }

    #[Route('/admin', name: 'order_admin', methods: ['GET'])]
    #[IsGranted("ROLE_ADMIN")]
    public function indexAdmin(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'order_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_USER")]
    public function new(EntityManagerInterface $entityManager, UserAdressRepository $userAdressRepository, UserRepository $userRepository, ProductRepository $productRepository): Response
    {
        $session = $this->requestStack->getSession();

        $cart = $session->get('cart');
        $userAdress = $session->get('address');

        if ($cart == null || $userAdress == null) {
            return $this->redirectToRoute('homepage');
        }

        $order = new Order();
        $order->setUser($userRepository->find($this->security->getUser()));
        $order->setDateTime(new \DateTime());
        $order->setValid(true);
        $order->setUserAdress($userAdressRepository->find($userAdress));

        $entityManager->persist($order);
        $entityManager->flush();
        
        foreach ($cart->getCartLines() as $cartLine) {
            $orderLine = new OrderLine();
            $orderLine->setOrderCmd($order);
            $orderLine->setProduct($productRepository->find($cartLine->getProduct()));
            $orderLine->setQuantity($cartLine->getQuantity());

            $entityManager->persist($orderLine);
        }

        $session->remove('cart');
        $session->remove('address');

        $entityManager->flush();

        return $this->redirectToRoute('order_index');
    }

    #[Route('/{id}', name: 'order_show', methods: ['GET'])]
    #[IsGranted("ROLE_USER")]
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/{id}', name: 'order_delete', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('order_index', [], Response::HTTP_SEE_OTHER);
    }
}
