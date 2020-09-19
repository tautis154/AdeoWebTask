<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Weather;
use App\Entity\WeatherProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Rest\Get("/api/products/recommended/{city}")
     * @param string $city
     * @return void
     */
    public function index(string $city)
    {
        echo $city;
        $weatherConditions = $this->getDoctrine()->getRepository(Weather::class)->findAll();
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        $conditions = $this->getDoctrine()->getRepository(WeatherProductType::class)->findAll();
        foreach ($conditions as $condition){
            echo $condition->getProduct()->getName() . '+++++++' . $condition->getForecastName()->getForecastName();
            echo '------------------------';
        }

        die();

    }
}
