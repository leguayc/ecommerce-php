<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Cart
{
    private $totalPrice;
    private $cartLines;

    public function __construct()
    {
        $this->cartLines = new Collection([]);
        $this->totalPrice = 0;
    }

    /**
     * @return Collection|CartLine[]
     */
    public function getCartLines(): Collection
    {
        return $this->cartLines;
    }

    public function addCartLine(Product $product): self
    {
        $index = $this->getCartIndexOfProduct($product);
        if ($index == -1) {
            $cartLine = new CartLine($product);
            $this->cartLines[] = $cartLine;
            $this->addTotalPrice($cartLine->getPrice());
        } else {
            $this->cartLines[$index]->quantity += 1;
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

    public function removeCartLine(CartLine $cartLine): self
    {
        if ($this->cartLines->removeElement($cartLine)) {
            $this->addTotalPrice(-$cartLine.getPrice());
        }

        return $this;
    }

    public function getTotalPrice(): int {
        return $this->totalPrice;
    }

    public function addTotalPrice(int $price) {
        $this->totalPrice += $price;
    }
}