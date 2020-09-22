<?php


namespace App\DataProvider;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class WeatherProvider
{
    /**
     * @param string $city
     * @return mixed
     */
    public function getWeatherByCity(string $city)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, 'https://api.meteo.lt/v1/places/' . $city . '/forecasts/long-term');
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new ServiceUnavailableHttpException();
        }
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status != 200) {
            throw new NotFoundHttpException();
        }
        curl_close($ch);
        return json_decode($response);
    }
}
