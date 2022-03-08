<?php

namespace App\Entity;

use App\Repository\UserAdressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserAdressRepository::class)
 */
class UserAdress
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $adress;

    /**
     * @ORM\Column(type="integer")
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $phoneNumber;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="userAdress")
     */
    private $shopOrder;

    public function __construct()
    {
        $this->shopOrder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getShopOrder(): Collection
    {
        return $this->shopOrder;
    }

    public function addShopOrder(Order $shopOrder): self
    {
        if (!$this->shopOrder->contains($shopOrder)) {
            $this->shopOrder[] = $shopOrder;
            $shopOrder->setUserAdress($this);
        }

        return $this;
    }

    public function removeShopOrder(Order $shopOrder): self
    {
        if ($this->shopOrder->removeElement($shopOrder)) {
            // set the owning side to null (unless already changed)
            if ($shopOrder->getUserAdress() === $this) {
                $shopOrder->setUserAdress(null);
            }
        }

        return $this;
    }
}
