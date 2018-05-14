<?php

namespace App\Service;

use Goutte\Client;

class AddressClient
{
    public function getAddressByLatLng(float $lat, float $lng): ?string
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://nominatim.openstreetmap.org/reverse?format=xml&lat='.$lat.'&lon='.$lng.'&zoom=18&addressdetails=0');
        try {
            $address = $crawler->filter('reversegeocode > result')->html();
        } catch (\InvalidArgumentException $invalidArgumentException) {
            return null;
        }

        return $address;
    }
}