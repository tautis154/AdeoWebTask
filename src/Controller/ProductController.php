<?php

namespace App\Controller;

use App\Service\ProductWeatherService;
use Exception;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\Product;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("/api/products/recommended/{city}")
     * @param string $city
     * @param ProductWeatherService $productWeatherService
     * @return string
     * @throws Exception
     */
    public function getApiRecommendedByCity(string $city, ProductWeatherService $productWeatherService)
    {
        $result = $productWeatherService->getProductsByCurrentWeatherAndCity($city);
        return $this->view($result, Response::HTTP_OK);
    }
}
