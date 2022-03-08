<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Product;
use App\Entity\Cart;
use App\Repository\ProductRepository;

class CartController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/cart", name="cart")
     */
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    /**
     * @Route("/cart/add", name="cart_add")
     */
    public function add(Request $request, ProductRepository $productRepository): Response
    {
        $session = $this->requestStack->getSession();

        // stores an attribute in the session for later reuse
        $cart = $session->get('cart');

        if ($cart == null) {
            $cart = new Cart();
        }

        $productId = $request->query->get('productId');
        $product = $productRepository->find($productId);
        $cart->addCartLine($product);

        $session->set('cart', $cart);
        
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
