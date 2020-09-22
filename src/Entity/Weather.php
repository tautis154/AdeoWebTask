<?php

namespace App\Entity;

use App\Repository\WeatherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeatherRepository::class)
 */
class Weather
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
    private $forecastName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WeatherProductType", mappedBy="forecastName")
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

    public function getForecastName(): ?string
    {
        return $this->forecastName;
    }

    public function setForecastName(string $forecastName): self
    {
        $this->forecastName = $forecastName;

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
            $weatherProductType->setForecastName($this);
        }

        return $this;
    }

    public function removeWeatherProductType(WeatherProductType $weatherProductType): self
    {
        if ($this->weatherProductTypes->contains($weatherProductType)) {
            $this->weatherProductTypes->removeElement($weatherProductType);
            // set the owning side to null (unless already changed)
            if ($weatherProductType->getForecastName() === $this) {
                $weatherProductType->setForecastName(null);
            }
        }

        return $this;
    }
}
