<?php
namespace App\Services;

use App\Models\Settings;
use GuzzleHttp\Client;
use Cart;

class ViettelPostService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://partner.viettelpost.vn/v2/']);
    }

    public function provinces()
    {
        $res = $this->client->request('GET', 'categories/listProvinceById?provinceId=');

        $result = json_decode($res->getBody()->getContents(), true);
        return $result;
    }

    public function districts($provinceId)
    {
        $res = $this->client->request('GET', 'categories/listDistrict?provinceId=' . $provinceId);

        $result = json_decode($res->getBody()->getContents(), true);
        return $result;
    }

    public function wards($districtId)
    {
        $res = $this->client->request('GET', 'categories/listWards?districtId=' . $districtId);

        $result = json_decode($res->getBody()->getContents(), true);
        return $result;
    }

    public function test(){
        $test = new Client();
        $res = $test->request('POST', 'https://dms.inet.vn/api/rms/v1/domain/checkavailable',[
            'json' => [
                "name" => "khailatao.vn"
            ],
            'headers' => [
                "token" => '0787DCA396ED00C9A89AA08F29530EBB7CB21FE9'
            ]
        ]);
        $result = json_decode($res->getBody()->getContents(), true);

        return $result;
    }

    public function getProvinceById($province_id)
    {
        $data = $this->provinces();
        if (isset($data['status']) && $data['status'] == 200) {
            foreach ($data['data'] as $value) {
                if ($value['PROVINCE_ID'] == $province_id) {
                    return $value['PROVINCE_NAME'];
                }
            }
        }
        return '';
    }

    public function getDistrictById($province_id, $district_id)
    {
        $data = $this->districts($province_id);
        if (isset($data['status']) && $data['status'] == 200) {
            foreach ($data['data'] as $value) {
                if ($value['DISTRICT_ID'] == $district_id) {
                    return $value['DISTRICT_NAME'];
                }
            }
        }
        return '';
    }

    public function getWardById($district_id, $ward_id)
    {
        $data = $this->wards($district_id);
        if (isset($data['status']) && $data['status'] == 200) {
            foreach ($data['data'] as $value) {
                if ($value['WARDS_ID'] == $ward_id) {
                    return $value['WARDS_NAME'];
                }
            }
        }
        return '';
    }

    public function prices($receiver_province = 1, $receiver_district = 1, $product_weight = 0, $order_service = 'VCN')
    {
        $options = Settings::where('type', 'viettel-post')->first();
        $content = json_decode($options->content);

        $res = $this->client->request('POST', 'order/getPrice', [
            'json' => [
                "PRODUCT_WEIGHT" => Cart::instance('shopping')->weight(0, 3, false),
                "PRODUCT_PRICE" => Cart::instance('shopping')->priceTotal(0, 3, false),
                "MONEY_COLLECTION" => 0,
                "ORDER_SERVICE_ADD" => "",
                "ORDER_SERVICE" => $order_service,
                "SENDER_PROVINCE" => $content->city_id ?? 1,
                "SENDER_DISTRICT" => $content->district_id ?? 1,
                "RECEIVER_PROVINCE" => $receiver_province,
                "RECEIVER_DISTRICT" => $receiver_district,
                "PRODUCT_TYPE" => "HH",
                "NATIONAL_TYPE" => 1
            ]
        ]);

        $result = json_decode($res->getBody()->getContents(), true);

        return $result;
    }

    public function getPrices($selecStore, $order, $product_weight = 0, $order_price = 0, $money_collection = 0,$order_service = 'VCN')
    {
        $options = Settings::where('type', 'viettel-post')->first();
        $content = json_decode($options->content);
        
        $res = $this->client->request('POST', 'order/getPrice', [
            'json' => [
                "PRODUCT_WEIGHT" => $product_weight,
                "PRODUCT_PRICE" => $order_price,
                "MONEY_COLLECTION" => $money_collection,
                "ORDER_SERVICE_ADD" => "",
                "ORDER_SERVICE" => $order_service,
                "SENDER_PROVINCE" => $selecStore['provinceId'] ?? 1,
                "SENDER_DISTRICT" => $selecStore['districtId'] ?? 1,
                "RECEIVER_PROVINCE" => $order->city_id,
                "RECEIVER_DISTRICT" => $order->district_id,
                "PRODUCT_TYPE" => "HH",
                "NATIONAL_TYPE" => 1
            ]
        ]);

        $result = json_decode($res->getBody()->getContents(), true);

        return $result;
    }

    public function getPriceAll($selecStore, $order, $product_weight = 0, $order_price = 0, $money_collection = 0)
    {
        $options = Settings::where('type', 'viettel-post')->first();
        $content = json_decode($options->content);

        $res = $this->client->request('POST', 'order/getPriceAll', [
            'json' => [
                "PRODUCT_WEIGHT" => $product_weight,
                "PRODUCT_PRICE" => $order_price,
                "MONEY_COLLECTION" => $money_collection,
                "SENDER_PROVINCE" => $selecStore['provinceId'] ?? 1,
                "SENDER_DISTRICT" => $selecStore['districtId'] ?? 1,
                "RECEIVER_PROVINCE" => $order->city_id,
                "RECEIVER_DISTRICT" => $order->district_id,
                "PRODUCT_TYPE" => "HH",
                "TYPE" => 1
            ]
        ]);

        $result = json_decode($res->getBody()->getContents(), true);

        return $result;
    }

    public function login($data)
    {
        $res = $this->client->request('POST', 'user/Login', [
            'json' => [
                "USERNAME" => $data['login_id'],
                "PASSWORD" => $data['password']
            ],
        ]);
        $result = json_decode($res->getBody()->getContents(), true);
        return $result;
    }

    public function getStore($user)
    {
        $res2 = $this->client->request('GET', 'user/listInventory', [
            'headers' => [
                'Token' => $user['data']['token']
            ]
        ]);

        $result2 = json_decode($res2->getBody()->getContents(), true);
        return $result2;
    }

    public function createBill($selecStore, $order, $input, $order_price = 0, $user, $check_collection){
        $options = Settings::where('type', 'viettel-post')->first();
        $content = json_decode($options->content);
        $ward = $order->ward_id ? ucwords(\Str::lower($this->getWardById($order->district_id, $order->ward_id))) : '';
        $city = $this->getProvinceById($order->city_id);
        $district = ucwords(\Str::lower($this->getDistrictById($order->city_id, $order->district_id)));
        dd($ward != '' ? $order->address.', '.$ward.', '.$district.', '.$city : $order->address.', '.$district.', '.$city);
        $res = $this->client->request('POST', 'order/createOrder', [
            'json' => [
                "ORDER_NUMBER" => $order->sku,
                "GROUPADDRESS_ID" => $input['store_id'],
                "CUS_ID" => $selecStore['cusId'],
                "DELIVERY_DATE" => date('d/m/Y h:i:m'),
                "SENDER_FULLNAME" => $selecStore['name'],
                "SENDER_ADDRESS" => $selecStore['address'],
                "SENDER_PHONE" => $selecStore['phone'],
                "SENDER_EMAIL" => "quanghoang321@gmail.com",
                "SENDER_WARD" => $selecStore['wardsId'],
                "SENDER_DISTRICT" => $selecStore['districtId'],
                "SENDER_PROVINCE" => $selecStore['provinceId'],
                "SENDER_LATITUDE" => 0,
                "SENDER_LONGITUDE" => 0,
                "RECEIVER_FULLNAME" => $order->name,
                "RECEIVER_ADDRESS" => $order->address,
                "RECEIVER_PHONE" => $order->phone,
                "RECEIVER_EMAIL" => $order->email,
                "RECEIVER_WARD" =>  $order->ward_id ? $order->ward_id : 0,
                "RECEIVER_DISTRICT" => $order->district_id,
                "RECEIVER_PROVINCE" => $order->city_id,
                "RECEIVER_LATITUDE" => 0,
                "RECEIVER_LONGITUDE" => 0,
                "PRODUCT_NAME" => $input['name_concat'],
                "PRODUCT_DESCRIPTION" => $input['name_concat'],
                "PRODUCT_QUANTITY" => 1,
                "PRODUCT_PRICE" => $order_price,
                "PRODUCT_WEIGHT" => $input['weight'],
                "PRODUCT_LENGTH" => $input['length'],
                "PRODUCT_WIDTH" => $input['width'],
                "PRODUCT_HEIGHT" => $input['height'],
                "PRODUCT_TYPE" => "HH",
                "ORDER_PAYMENT" => $check_collection == 1 ? 3 : 1,
                "ORDER_SERVICE" => $input['vtp_service'],
                "ORDER_SERVICE_ADD" => "",
                "ORDER_VOUCHER" => "",
                "ORDER_NOTE" => $input['note'],
                "MONEY_COLLECTION" => $check_collection == 1 ? $input['money_collection'] : 0,
                "MONEY_TOTALFEE" => 0,
                "MONEY_FEECOD" => 0,
                "MONEY_FEEVAS" => 0,
                "MONEY_FEEINSURRANCE" => 0,
                "MONEY_FEE" => 0,
                "MONEY_FEEOTHER" => 0,
                "MONEY_TOTALVAT" => 0,
                "MONEY_TOTAL" => 0,
                // "LIST_ITEM" => [
                //     [
                //     "PRODUCT_NAME" => "Máy xay sinh tố Philips HR2118 2.0L ",
                //     "PRODUCT_PRICE" => 2150000,
                //     "PRODUCT_WEIGHT" => 2500,
                //     "PRODUCT_QUANTITY" => 1
                //     ]
                // ],
                ],
            'headers' => [
                'Token' => $user['data']['token']
            ]
        ]);

        $result = json_decode($res->getBody()->getContents(), true);
        return $result;
    }
    
}