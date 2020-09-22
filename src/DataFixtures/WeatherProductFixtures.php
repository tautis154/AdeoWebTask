<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Weather;
use App\Entity\WeatherProductType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class WeatherProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $normalWeatherTypes = [
            'clear', 'isolated-clouds', 'scattered-clouds', 'overcast',  'fog',
        ];
        $normalProducts = [
            'Hat', 'Shoes', 'Shorts', 'T-shirt', 'Glasses',
            'Slippers', 'Leggings', 'Jeans', 'Socks',
        ];

        $rainWeatherTypes = [
            'light-rain', 'moderate-rain', 'heavy-rain',
        ];
        $rainProducts = [
            'Umbrella', 'Hat', 'Shoes', 'Hoodie', 'Jeans', 'Jacket', 'Socks', 'Coat'
        ];
        $snowWeatherTypes = [
            'sleet', 'light-snow', 'moderate-snow', 'heavy-snow', 'fog',
        ];
        $snowProducts = [
            'Beanie', 'Shoes', 'Hoodie', 'Jeans', 'Jacket', 'Socks', 'Coat'
        ];

        $skuNumber = 0;

        foreach ($normalWeatherTypes as $condition) {
            $weather = new Weather();
            $weather->setForecastName($condition);
            $manager->persist($weather);
            $this->AddWeatherProducts($normalProducts, $skuNumber, $manager, $weather);
        }

        $skuNumber = 0;

        foreach ($rainWeatherTypes as $condition) {
            $weather = new Weather();
            $weather->setForecastName($condition);
            $manager->persist($weather);
            $this->AddWeatherProducts($rainProducts, $skuNumber, $manager, $weather);

        }

        $skuNumber = 0;

        foreach ($snowWeatherTypes as $condition) {
            $weather = new Weather();
            $weather->setForecastName($condition);
            $manager->persist($weather);
            $this->AddWeatherProducts($snowProducts, $skuNumber, $manager, $weather);

        }


        $manager->flush();
    }

    public function AddWeatherProducts($products, $skuNumber, ObjectManager $manager, Weather $weather){

        $generator = Factory::create();
        for ($i = 0; $i < 15; $i++) {
            $product = new Product();
            $name = $products[$generator->randomFloat(null, 0, count($products) - 1)];
            $product->setSku(strtoupper($name[0] . $name[1]) . '-' . $skuNumber);
            $product->setName($generator->colorName . ' ' . $name);
            $product->setPrice($generator->randomFloat(null, 10, 100));
            $manager->persist($product);

            $weatherProductType = new WeatherProductType();
            $weatherProductType->setProduct($product);
            $weatherProductType->setForecastName($weather);
            $manager->persist($weatherProductType);

            $skuNumber++;
        }
    }
}
