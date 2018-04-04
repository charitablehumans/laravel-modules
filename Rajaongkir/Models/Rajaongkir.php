<?php

namespace Modules\Rajaongkir\Models;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Rajaongkir extends Model
{
    const STARTER_PROVINCE_URL = 'https://api.rajaongkir.com/starter/province';
    const STARTER_CITY_URL = 'https://api.rajaongkir.com/starter/city';
    const STARTER_COST_URL = 'https://api.rajaongkir.com/starter/cost';

    const BASIC_PROVINCE_URL = 'https://api.rajaongkir.com/basic/province';
    const BASIC_CITY_URL = 'https://api.rajaongkir.com/basic/city';
    const BASIC_COST_URL = 'https://api.rajaongkir.com/basic/cost';

    const PRO_PROVINCE_URL = 'https://api.rajaongkir.com/pro/province';
    const PRO_CITY_URL = 'https://api.rajaongkir.com/pro/city';
    const PRO_COST_URL = 'https://pro.rajaongkir.com/api/cost';

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

    /**
     * [getCostCourier description]
     * @param array $data
     * [
     *      'origin' => '155', // regency_id
     *      'destination' => '447', // regency_id
     *      'weight' => '1000', // grams
     *      'courier' => 'jne', // $this->getCouriersId()
     * ]
     * @return [type] [description]
     */
    public function getCostCourier($formParams = [])
    {
        try {
            $client = new Client();
            $options['headers'] = ['Key' => env('RAJAONGKIR_KEY')];
            $formParams ? $options['form_params'] = $formParams : '';
            $response = $client->post($this->getCostUrl(), $options);

            $contents = json_decode($response->getBody()->getContents(), true);
            $results = $contents['rajaongkir']['results'][0];
        } catch (ClientException $e) {
            // $response = $e->getResponse();
            // $contents = json_decode($response->getBody()->getContents(), true);
            $results = false;
        }

        return $results;
    }

    public function getCostUrl()
    {
        $account = strtolower(env('RAJAONGKIR_ACCOUNT'));

        switch ($account) {
            case 'starter':
                return self::STARTER_COST_URL;
            case 'basic':
                return self::BASIC_COST_URL;
            case 'pro':
                return self::PRO_COST_URL;
            default :
                return self::STARTER_COST_URL;
        }
    }

    public function getCouriers()
    {
        $account = strtolower(env('RAJAONGKIR_ACCOUNT'));
        $couriers = [
            'jne' => 'JNE',
            'tiki' => 'TIKI',
            'pos' => 'POS',
        ];

        switch ($account) {
            case 'starter':
                break;
            case 'basic':
                $couriers = [
                    'jne' => 'JNE',
                    'tiki' => 'TIKI',
                    'pcp' => 'PCP',
                    'pos' => 'POS',
                    'rpx' => 'RPX',
                ];
                break;
            case 'pro':
                $couriers = [
                    'cahaya' => 'Cahaya',
                    'dse' => 'DSE',
                    'esl' => 'ESL',
                    'first' => 'First',
                    'indah' => 'Indah Cargo',
                    'jet' => 'JET',
                    'jne' => 'JNE',
                    'jnt' => 'J&T',
                    'ncs' => 'NCS',
                    'nss' => 'NSS',
                    'pahala' => 'Pahala',
                    'pandu' => 'Pandu',
                    'pcp' => 'PCP',
                    'pos' => 'POS',
                    'rpx' => 'RPX',
                    'sap' => 'SAP',
                    'sicepat' => 'SiCepat',
                    'slis' => '', // not found
                    'star' => 'STAR',
                    'tiki' => 'TIKI',
                    'wahana' => 'Wahana',
                ];
                break;
            default :
                $couriers;
        }

        return $couriers;
    }

    public function getCouriersId()
    {
        $couriers = $this->getCouriers();
        $couriers = array_keys($couriers);
        return $couriers;
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
