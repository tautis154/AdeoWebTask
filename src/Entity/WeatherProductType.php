<?php

namespace App\Entity;

use App\Repository\WeatherProductTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeatherProductTypeRepository::class)
 */
class WeatherProductType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="weatherProductTypes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Weather", inversedBy="weatherProductTypes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $forecastName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getForecastName(): ?Weather
    {
        return $this->forecastName;
    }

    public function setForecastName(?Weather $forecastName): self
    {
        $this->forecastName = $forecastName;

        return $this;
    }
}
