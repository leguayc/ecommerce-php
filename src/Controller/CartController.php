<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $session = $this->requestStack->getSession();

        $cart = $session->get('cart');

        if ($cart != null && !empty($cart->getCartLines())) {
            return $this->render('cart/index.html.twig', [
                'cartLines' => $cart->getCartLines(),
                'cartPrice' => $cart->getTotalPrice(),
            ]);
        }
        
        return $this->render('cart/index.html.twig', [
            'cartLines' => null,
            'cartPrice' => 0,
        ]);
    }

    /**
     * @Route("/cart/add", name="cart_add")
     */
    public function add(Request $request, ProductRepository $productRepository): RedirectResponse
    {
        $session = $this->requestStack->getSession();

        $cart = $session->get('cart');

        if ($cart == null) {
            $cart = new Cart();
        }

        $productId = $request->query->get('productId');
        $product = $productRepository->find($productId);
        $cart->addCartLine($product);

        $session->set('cart', $cart);
        
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/setquantity", name="cart_quantity")
     */
    public function setQuantity(Request $request, ProductRepository $productRepository)
    {
        $session = $this->requestStack->getSession();

        $cart = $session->get('cart');

        if ($cart == null) {
            return $this->redirectToRoute('cart');
        }

        $productId = $request->query->get('productId');
        $product = $productRepository->find($productId);
        $cart->setCartLineQuantity($product, $request->query->get('quantity'));

        $jsonData = $cart->getTotalPrice();

        $session->set('cart', $cart);

        return new JsonResponse($jsonData);
    }

    /**
     * @Route("/cart/remove", name="cart_remove")
     */
    public function remove(Request $request, ProductRepository $productRepository)
    {
        $session = $this->requestStack->getSession();

        $cart = $session->get('cart');

        if ($cart == null) {
            return $this->redirectToRoute('cart');
        }

        $productId = $request->query->get('productId');
        $product = $productRepository->find($productId);
        $cart->removeCartLineOfProduct($product);

        $jsonData = $cart->getTotalPrice();

        $session->set('cart', $cart);

        return new JsonResponse($jsonData);
    }

    /**
     * @Route("/cart/empty", name="cart_empty")
     */
    public function empty(): RedirectResponse
    {
        $session = $this->requestStack->getSession();

        $session->remove('cart');
        
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/order", name="cart_order")
     */
    public function order(): RedirectResponse
    {
        // Do not use this, go to order controller
        $session = $this->requestStack->getSession();

        if ($session->get('address') != null) {
            return $this->redirectToRoute('order_new');
        }
        
        return $this->redirectToRoute('user_adress_index', [ 'redirectRoute' => 'order_new' ]);
    }
}
