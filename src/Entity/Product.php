<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sku;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WeatherProductType", mappedBy="product")
     */
    private $weatherProductTypes;

    public function __construct()
    {
        $this->weatherProductTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|WeatherProductType[]
     */
    public function getWeatherProductTypes(): Collection
    {
        return $this->weatherProductTypes;
    }

    public function addWeatherProductType(WeatherProductType $weatherProductType): self
    {
        if (!$this->weatherProductTypes->contains($weatherProductType)) {
            $this->weatherProductTypes[] = $weatherProductType;
            $weatherProductType->setProduct($this);
        }

        return $this;
    }

    public function removeWeatherProductType(WeatherProductType $weatherProductType): self
    {
        if ($this->weatherProductTypes->contains($weatherProductType)) {
            $this->weatherProductTypes->removeElement($weatherProductType);
            // set the owning side to null (unless already changed)
            if ($weatherProductType->getProduct() === $this) {
                $weatherProductType->setProduct(null);
            }
        }

        return $this;
    }
}
