<?php

namespace Modules\Rajaongkir\Models;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Rajaongkir extends Model
{
    const STARTER_PROVINCE_URL = 'https://api.rajaongkir.com/starter/province';
    const STARTER_CITY_URL = 'https://api.rajaongkir.com/starter/city';
    const BASIC_PROVINCE_URL = 'https://api.rajaongkir.com/basic/province';
    const BASIC_CITY_URL = 'https://api.rajaongkir.com/basic/city';
    const PRO_PROVINCE_URL = 'https://api.rajaongkir.com/pro/province';
    const PRO_CITY_URL = 'https://api.rajaongkir.com/pro/city';

    protected $fillable = [];

    public function getCityUrl()
    {
        $account = strtolower(env('RAJAONGKIR_ACCOUNT'));

        switch ($account) {
            case 'starter':
                return self::STARTER_CITY_URL;
            case 'basic':
                return self::BASIC_CITY_URL;
            case 'pro':
                return self::PRO_CITY_URL;
            default :
                return self::STARTER_CITY_URL;
        }
    }

    /**
     * [getCities description]
     * @param array $query
     * [
     *      'id' => 1,
     * ]
     */
    public function getCities($query = [])
    {
        try {
            $client = new Client();
            $options['headers'] = ['Key' => env('RAJAONGKIR_KEY')];
            $query ? $options['query'] = $query : '';
            $response = $client->get($this->getCityUrl(), $options);

            $contents = json_decode($response->getBody()->getContents(), true);
            $results = $contents['rajaongkir']['results'];
        } catch (ClientException $e) {
            // $response = $e->getResponse();
            // $contents = json_decode($response->getBody()->getContents(), true);
            $results = false;
        }

        return $results;
    }

    public function getProvinceUrl()
    {
        $account = strtolower(env('RAJAONGKIR_ACCOUNT'));

        switch ($account) {
            case 'starter':
                return self::STARTER_PROVINCE_URL;
            case 'basic':
                return self::BASIC_PROVINCE_URL;
            case 'pro':
                return self::PRO_PROVINCE_URL;
            default :
                return self::STARTER_PROVINCE_URL;
        }
    }

    /**
     * [getProvinces description]
     * @param array $query
     * [
     *      'city_id' => 1,
     *      'province_id' => 21,
     * ]
     */
    public function getProvinces($query = [])
    {
        try {
            $client = new Client();
            $options['headers'] = ['Key' => env('RAJAONGKIR_KEY')];
            $query ? $options['query'] = $query : '';
            $response = $client->get($this->getProvinceUrl(), $options);

            $contents = json_decode($response->getBody()->getContents(), true);
            $results = $contents['rajaongkir']['results'];
        } catch (ClientException $e) {
            // $response = $e->getResponse();
            // $contents = json_decode($response->getBody()->getContents(), true);
            $results = false;
        }

        return $results;
    }
}
