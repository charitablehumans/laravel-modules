<?php

namespace Modules\Rpx\Models;

use Illuminate\Database\Eloquent\Model;

use Artisaninweb\SoapWrapper\SoapWrapper;

class RpxSoap extends Model
{
    protected $fillable = [];

    protected $soapWrapper;

	protected $user;
	protected $password;
	protected $account_number;
	protected $format;
	
    public function __construct()
    {
        $this->soapWrapper = new soapWrapper;

        $this->soapWrapper->add('Data', function ($service) {
            $service
                ->wsdl('http://api.rpxholding.com/wsdl/rpxwsdl.php?wsdl')
                ->trace(true);
        });

        $this->user 			= config('rpx.user');
        $this->password 		= config('rpx.password');
        $this->account_number 	= config('rpx.account_number');
        $this->format 			= 'JSON';
    }

	public function getProvince()
	{
        $response = $this->soapWrapper->call('Data.getProvince', [
            'user'		=> $this->user, 
            'password'	=> $this->password,
            'format'	=> $this->format
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	/**
     * @param string(50) $province province_name ex. DKI JAKARTA
     */
	public function getRPXOffice($province)
	{
        $response = $this->soapWrapper->call('Data.getRPXOffice', [
            'user'		=> $this->user, 
            'password'	=> $this->password,
            'province'	=> $province,
            'format'	=> $this->format
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function getService()
	{
        $response = $this->soapWrapper->call('Data.getService', [
            'user'		=> $this->user, 
            'password'	=> $this->password,
            'format'	=> $this->format
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function getOrigin()
	{
        $response = $this->soapWrapper->call('Data.getOrigin', [
            'user'		=> $this->user, 
            'password'	=> $this->password,
            'format'	=> $this->format
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function getDestination()
	{
        $response = $this->soapWrapper->call('Data.getDestination', [
            'user'		=> $this->user, 
            'password'	=> $this->password,
            'format'	=> $this->format
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	/**
     * @param string(3) $origin ex. JAK
     * @param string(3) $destination ex. BDO
     * @param string(3) $service_type ex. 
     * @param numeric(3) $weight ex. 2
     * @param numeric(3) $disc ex. 0
     */
	public function getRates()
	{
        $response = $this->soapWrapper->call('Data.getRates', [
            'user'			=> $this->user,
            'password'		=> $this->password,
            'origin' 		=> 'JAK',
            'destination' 	=> 'BDO',
            'service_type' 	=> 'SDP',
            'weight' 		=> 2,
            'disc'			=> 50,
            'format'		=> $this->format
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function getRatesPostalCode()
	{
        $response = $this->soapWrapper->call('Data.getRatesPostalCode', [
            'user'						=> $this->user, 
            'password'					=> $this->password,
            'origin_postal_code' 		=> '14450',
            'destination_postal_code'	=> '14250',
            'service_type' 				=> 'SDP',
            'weight' 					=> 2,
            'disc' 						=> 10,
            'format'					=> $this->format,
            'account_number' 			=> $this->account_number
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function getTrackingAWB($awb)
	{
        $response = $this->soapWrapper->call('Data.getTrackingAWB', [
            'user'		=> $this->user, 
            'password'	=> $this->password,
            'awb' 		=> $awb,
            'format'	=> $this->format
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function getClearanceAWB($awb)
	{
        $response = $this->soapWrapper->call('Data.getClearanceAWB', [
            'user'		=> $this->user, 
            'password'	=> $this->password,
            'awb' 		=> $awb,
            'format'	=> $this->format
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function getRouteOrigin($postal_code)
	{
        $response = $this->soapWrapper->call('Data.getRouteOrigin', [
            'user'			=> $this->user, 
            'password'		=> $this->password,
            'postal_code'	=> $postal_code,
            'format'		=> $this->format
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function getRouteDestination($postal_code)
	{
        $response = $this->soapWrapper->call('Data.getRouteDestination', [
            'user'			=> $this->user, 
            'password'		=> $this->password,
            'postal_code'	=> $postal_code,
            'format'		=> $this->format
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function getCity()
	{
        $response = $this->soapWrapper->call('Data.getCity', [
            'user'		=> $this->user, 
            'password'	=> $this->password,
            'format'	=> $this->format
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function getPostalCode($city_id, $cod_area)
	{
        $response = $this->soapWrapper->call('Data.getPostalCode', [
            'user'		=> $this->user, 
            'password'	=> $this->password,
            'city_id'	=> $city_id,
            'format'	=> $this->format,
            'cod_area'	=> $cod_area
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function getAWBbyReference($reference_no)
	{
        $response = $this->soapWrapper->call('Data.getAWBbyReference', [
            'user'			=> $this->user, 
            'password'		=> $this->password,
            'reference_no'	=> $reference_no,
            'format'		=> $this->format
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function getRevenue($trackdate_from, $trackdate_to)
	{
        $response = $this->soapWrapper->call('Data.getRevenue', [
            'user'				=> $this->user, 
            'password'			=> $this->password,
            'account_number'	=> $this->account_number,
            'trackdate_from'	=> $trackdate_from,
            'trackdate_to'		=> $trackdate_to
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function getPOD($year)
	{
        $response = $this->soapWrapper->call('Data.getPOD', [
            'user'				=> $this->user, 
            'password'			=> $this->password,
            'account_number'	=> $this->account_number,
            'year'				=> $year
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function getCustomerRates()
	{
        $response = $this->soapWrapper->call('Data.getCustomerRates', [
            'user'				=> $this->user, 
            'password'			=> $this->password,
            'account_number'	=> $this->account_number,
            'service_type' 		=> '',
            'origin'			=> 'JAK',
            'destination'		=> 'BDO',
            'weight'			=> 2,
            'disc'				=> 10,
            'format'			=> $this->format
        ]);

        $data = json_decode($response, true);

        return $data;
	}

	public function sendShipmentData()
	{
        $response = $this->soapWrapper->call('Data.sendShipmentData', [
            'user'					=> $this->user, 
            'password'				=> $this->password,
            'awb'					=> '',
            'package_id'			=> '',
            'order_type'			=> '',
            'order_number'			=> '',
            'service_type_id'		=> '',
            'shipper_account'		=> $this->account_number,
            'shipper_name'			=> '',
            'shipper_company'		=> '',
            'shipper_address1'		=> '',
            'shipper_address2'		=> '',
            'shipper_kelurahan'		=> '',
            'shipper_kecamatan'		=> '',
            'shipper_city'			=> '',
            'shipper_state'			=> '',
            'shipper_zip'			=> '',
            'shipper_phone'			=> '',
            'identity_no'			=> '',
            'shipper_mobile_no'		=> '',
            'shipper_email'			=> '',
            'consignee_account'		=> '',
            'consignee_name'		=> '',
            'consignee_company'		=> '',
            'consignee_address1'	=> '',
            'consignee_address2'	=> '',
            'consignee_kelurahan'	=> '',
            'consignee_kecamatan'	=> '',
            'consignee_city'		=> '',
            'consignee_state'		=> '',
            'consignee_zip'			=> '',
            'consignee_phone'		=> '',
            'consignee_mobile_no'	=> '',
            'consignee_email'		=> '',
            'desc_of_goods'			=> '',
            'tot_package'			=> '',
            'actual_weight'			=> '',
            'tot_weight'			=> '',
            'tot_declare_value'		=> '',
            'tot_dimensi' 			=> '',
            'flag_mp_spec_handling' => '',
            'insurance' 			=> '',
            'surcharge' 			=> '',
            'high_value' 			=> '',
            'value_docs' 			=> '',
            'electronic' 			=> '',
            'flag_dangerous_goods' 	=> '',
            'flag_birdnest' 		=> '',
            'declare_value' 		=> '',
            'format'				=> '',
            'dest_store_id'			=> '',
            'dest_dc_id'			=> '',
            'widhtx'				=> '',
            'lengthx'				=> '',
            'heightx'				=> ''
        ]);

        $data = json_decode($response, true);

        return $data;
	}







}
