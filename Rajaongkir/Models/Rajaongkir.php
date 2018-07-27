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

    const PRO_PROVINCE_URL = 'https://pro.rajaongkir.com/api/province';
    const PRO_CITY_URL = 'https://pro.rajaongkir.com/api/city';
    const PRO_SUBSDISTRICT_URL = 'https://pro.rajaongkir.com/api/subdistrict';
    const PRO_COST_URL = 'https://pro.rajaongkir.com/api/cost';
    const PRO_WAYBILL_URL = 'https://pro.rajaongkir.com/api/waybill';

    protected $fillable = [];

    public function getCityUrl()
    {
        $account = strtolower(config('rajaongkir.account'));

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
            $options['headers'] = ['Key' => config('rajaongkir.key')];
            $query ? $options['query'] = $query : '';
            $response = $client->get($this->getCityUrl(), $options);

            $contents = json_decode($response->getBody()->getContents(), true);
            $results = $contents['rajaongkir']['results'];
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $contents = $response->getBody()->getContents();
            logger()->error($response->getStatusCode().'. '.$contents);
            abort($response->getStatusCode(), $contents);
        }

        return $results;
    }

    /**
     * [getCostCourier description]
     * @param array $formParams
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
        $formParams['originType'] = isset($formParams['originType']) ? $formParams['originType'] : 'city';
        $formParams['weight'] = $formParams['weight'] > 0 ? $formParams['weight'] : 1;
        $formParams['destinationType '] = isset($formParams['destinationType']) ? $formParams['destinationType'] : 'subdistrict';

        try {
            $client = new Client();
            $options['form_params'] = $formParams;
            $options['headers'] = ['Key' => config('rajaongkir.key')];
            $response = $client->post($this->getCostUrl(), $options);

            $contents = json_decode($response->getBody()->getContents(), true);
            $results = $contents['rajaongkir']['results'][0];
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $contents = $response->getBody()->getContents();
            logger()->error($response->getStatusCode().'. '.$contents);
            abort($response->getStatusCode(), $contents);
        }

        return $results;
    }

    /**
     * [getCosts description]
     * @param array $formParams
     * [
     *      'origin' => '155', // regency_id
     *      'destination' => '447', // regency_id
     *      'weight' => '1000', // grams
     * ]
     * @param array $couriers
     * [
     *      'jne',
     *      'tiki',
     * ]
     * @return [type] [description]
     */
    public function getCosts($formParams = [], $couriers = [])
    {
        $costs = [];
        $formParams['originType'] = isset($formParams['originType']) ? $formParams['originType'] : 'city';
        $formParams['destinationType '] = isset($formParams['destinationType']) ? $formParams['destinationType'] : 'city';
        $formParams['weight'] = $formParams['weight'] > 0 ? $formParams['weight'] : 1;

        foreach ($couriers as $courier) {
            try {
                $client = new Client();
                $formParams['courier'] = $courier;
                $options['form_params'] = $formParams;
                $options['headers'] = ['Key' => config('rajaongkir.key')];
                $response = $client->post($this->getCostUrl(), $options);

                $contents = json_decode($response->getBody()->getContents(), true);
                $results = $contents['rajaongkir']['results'][0];

                foreach ($results['costs'] as $result) {
                    $costs[] = [
                        'code' => $results['code'],
                        'name' => $results['name'],
                        'service' => $result['service'],
                        'description' => $result['description'],
                        'cost' => $result['cost'][0]['value'],
                        'etd' => $result['cost'][0]['etd'],
                        'note' => $result['cost'][0]['note'],
                    ];
                }
            } catch (ClientException $e) {
                $response = $e->getResponse();
                $contents = $response->getBody()->getContents();
                logger()->error($response->getStatusCode().'. '.$contents);
                abort($response->getStatusCode(), $contents);
            }
        }

        return $costs;
    }

    public function getCostUrl()
    {
        $account = strtolower(config('rajaongkir.account'));

        switch ($account) {
            case 'starter':
                return self::STARTER_COST_URL;
            case 'basic':
                return self::BASIC_COST_URL;
            case 'pro':
                return self::STARTER_COST_URL;
                // return self::PRO_COST_URL; // destinationType is not readable
            default :
                return self::STARTER_COST_URL;
        }
    }

    public function getCouriers()
    {
        $account = strtolower(config('rajaongkir.account'));
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
                // destinationType is not readable
                // $couriers = [
                //     'cahaya' => 'Cahaya',
                //     'dse' => 'DSE',
                //     'esl' => 'ESL',
                //     'first' => 'First',
                //     'indah' => 'Indah Cargo',
                //     'jet' => 'JET',
                //     'jne' => 'JNE',
                //     'jnt' => 'J&T',
                //     'ncs' => 'NCS',
                //     'nss' => 'NSS',
                //     'pahala' => 'Pahala',
                //     'pandu' => 'Pandu',
                //     'pcp' => 'PCP',
                //     'pos' => 'POS',
                //     'rpx' => 'RPX',
                //     'sap' => 'SAP',
                //     'sicepat' => 'SiCepat',
                //     'slis' => '', // not found
                //     'star' => 'STAR',
                //     'tiki' => 'TIKI',
                //     'wahana' => 'Wahana',
                // ];
                // break;
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
        $account = strtolower(config('rajaongkir.account'));

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
            $options['headers'] = ['Key' => config('rajaongkir.key')];
            $query ? $options['query'] = $query : '';
            $response = $client->get($this->getProvinceUrl(), $options);

            $contents = json_decode($response->getBody()->getContents(), true);
            $results = $contents['rajaongkir']['results'];
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $contents = $response->getBody()->getContents();
            logger()->error($response->getStatusCode().'. '.$contents);
            abort($response->getStatusCode(), $contents);
        }

        return $results;
    }

    /**
     * [getSubdistricts description]
     * @param array $query
     * [
     *      'id' => 1,
     * ]
     */
    public function getSubdistricts($query = [])
    {
        try {
            $client = new Client();
            $options['headers'] = ['Key' => config('rajaongkir.key')];
            $query ? $options['query'] = $query : '';
            $response = $client->get($this->getSubdistrictUrl(), $options);

            $contents = json_decode($response->getBody()->getContents(), true);
            $results = $contents['rajaongkir']['results'];
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $contents = $response->getBody()->getContents();
            logger()->error($response->getStatusCode().'. '.$contents);
            abort($response->getStatusCode(), $contents);
        }

        return $results;
    }

    public function getSubdistrictUrl()
    {
        $account = strtolower(config('rajaongkir.account'));

        switch ($account) {
            case 'pro':
                return self::PRO_SUBSDISTRICT_URL;
            default :
                return self::PRO_SUBSDISTRICT_URL;
        }
    }

    public function getWaybillUrl()
    {
        $account = strtolower(config('rajaongkir.account'));

        switch ($account) {
            case 'pro':
                return self::PRO_WAYBILL_URL;
            default :
                return self::PRO_WAYBILL_URL;
        }
    }

    /**
     * [getWaybill description]
     * @param array $body
     * [
     *      'courier' => jne,
     *      'waybill' => 'SOCAG00183235715',
     * ]
     */
    public function getWaybill($formParams = [])
    {
        try {
            $client = new Client();
            $options['headers'] = ['Key' => config('rajaongkir.key')];
            $formParams ? $options['form_params'] = $formParams : '';
            $response = $client->post($this->getWaybillUrl(), $options);

            $contents = json_decode($response->getBody()->getContents(), true);
            $result = $contents['rajaongkir']['result'];
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $contents = $response->getBody()->getContents();
            logger()->error($response->getStatusCode().'. '.$contents);
            abort($response->getStatusCode(), $contents);
        }

        return $result;
    }
}
