<?php

namespace App\Service;

use App\DataProvider\WeatherProvider;
use App\Entity\Weather;
use App\Entity\WeatherProductType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class ProductWeatherService
{


    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var WeatherProvider
     */
    private $weatherProvider;

    /**
     * ProductService constructor.
     * @param EntityManagerInterface $manager
     * @param WeatherProvider $weatherProvider
     */
    public function __construct(EntityManagerInterface $manager, WeatherProvider $weatherProvider)
    {
        $this->manager = $manager;
        $this->weatherProvider = $weatherProvider;
    }

    /**
     * @param string $city
     * @return string
     * @throws \Exception
     */
    public function getProductsByCurrentWeatherAndCity(string $city)
    {
        $weathers = $this->getUpcomingWeathersByCityAndDate($city, new DateTime());

        if (is_null($weathers)) {
            throw new ServiceUnavailableHttpException();
        }

        $products = array();
        foreach ($weathers as $weather){
            $products = $this->manager->getRepository(WeatherProductType::class)
                ->findByWeatherType($weather['weather-forecast']);
        }

        return $this->bindData($products, $city, $weathers);
    }

    public function getUpcomingWeathersByCityAndDate(string $city, DateTime $dt)
    {
        $currentHour = $dt->format('H');
        $currentDay = $dt->format('d');

        $weathers = array();
        $responseData = $this->weatherProvider->getWeatherByCity($city);
        $counting = 0;
        foreach ($responseData->forecastTimestamps as $timestamp) {
            $date = strtotime($timestamp->forecastTimeUtc);
            if (date("d", $date) == $currentDay && date("H", $date) == $currentHour && $counting == 0) {
                $weathers[] = [
                    'weather-forecast' => $this->manager->getRepository(Weather::class)
                        ->findOneByName($timestamp->conditionCode),
                    'date' => substr($timestamp->forecastTimeUtc,'0','10')
                ];
                $counting++;
                break;
            }
        }

        $dt->modify('+' . $counting .' day');
        $nextDay = $dt->format('d');
        foreach ($responseData->forecastTimestamps as $timestamp) {
            $date = strtotime($timestamp->forecastTimeUtc);
            if ($counting < 3 && date("d", $date) == $nextDay ) {
                $weathers[] = [
                    'weather-forecast' => $this->manager->getRepository(Weather::class)
                        ->findOneByName($timestamp->conditionCode),
                    'date' => substr($timestamp->forecastTimeUtc,'0','10')

                ];
                $dt->modify('+' . $counting .' day');
                $nextDay = $dt->format('d');
                $counting++;
            }
        }
        return $weathers;
    }

    private function bindData($products, $city, $weathers)
    {
        $weathersTemp = array();
        $data['source'] = 'LHMT';
        $data['city'] = ucfirst($city);
        $counter=0;
        $tempVar = $counter;
        foreach ($weathers as $key=>$weather){
            $weathersTemp[$key][] = [
                'weather-forecast' => $weather['weather-forecast']->getForecastName(),
                'date' => $weather['date']
            ];
            $otherTempVar = 0;
            for($i = $tempVar; $i < $tempVar + 2; $i++){
                $weathersTemp[$key][$otherTempVar+1] = [
                    'sku' => $products[$i]->getProduct()->getSku(),
                    'name' => $products[$i]->getProduct()->getName(),
                    'price' => $products[$i]->getProduct()->getPrice(),
                ];
                $counter++;
                $otherTempVar++;
            }
            $tempVar = $counter;
        }
        $data['recommendations'] = $weathersTemp;
        return $data;
    }
}
