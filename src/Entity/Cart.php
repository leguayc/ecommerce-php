<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Cart
{
    private $cartLines;

    public function __construct()
    {
        $this->cartLines = array();
    }

    /**
     * @return CartLine[]
     */
    public function getCartLines(): iterable
    {
        return $this->cartLines;
    }

    public function addCartLine(Product $product): self
    {
        $index = $this->getCartIndexOfProduct($product);
        if ($index == -1) {
            $cartLine = new CartLine($product);
            $this->cartLines[] = $cartLine;
        } else {
            $this->cartLines[$index]->addQuantity(1);
        }
        
        return $this;
    }

    public function getCartIndexOfProduct(Product $product): int {
        if ($this->cartLines == null) { return -1;}
        
        foreach ($this->cartLines as $key => $value) {
            if ($value->getProduct()->getId() == $product->getId())
                return $key;
        }

        return -1;
    }

    public function setCartLineQuantity(Product $product, int $quantity): int
    {
        $index = $this->getCartIndexOfProduct($product);
        if ($index != -1) {
            $this->cartLines[$index]->setQuantity($quantity);

            if ($this->cartLines[$index]->getQuantity() <= 0) {
                $this->removeCartLineOfProduct($product);
            }

            return $this->cartLines[$index]->getPrice();
        }

        return 0;
    }

    public function removeCartLineOfProduct(Product $product): self
    {
        $index = $this->getCartIndexOfProduct($product);
        if ($index != -1) {
            unset($this->cartLines[$index]);
        }

        return $this;
    }

    public function getTotalPrice(): int {
        $totalPrice = 0;

        foreach ($this->cartLines as $cartLine) {
            $totalPrice += $cartLine->getPrice();
        }

        return $totalPrice;
    }
}