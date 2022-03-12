<?php

namespace App\Entity;

class CartLine
{
    private $product;
    private $quantity;

    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->quantity = 1;
    }

    public function getProduct() : Product {
        return $this->product;
    }

    public function setProduct(Product $product) {
        $this->product = $product;
    }

    public function getQuantity() : int {
        return $this->quantity;
    }

    public function setQuantity(int $quantity) {
        $this->quantity = $quantity;
    }

    public function addQuantity(int $quantity) {
        $this->quantity += $quantity;
    }

    public function getPrice(): int {
        return $this->quantity * $this->product->getPrice();
    }
}