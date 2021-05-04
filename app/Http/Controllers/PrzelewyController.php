<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

define('PRZELEWY24_MERCHANT_ID', '140219');
define('PRZELEWY24_CRC', '3c1863b879671d24');         //secure
//define('PRZELEWY24_CRC', 'bfa52e883065224e');   //sandbox
// sandbox - środowisko testowe, secure - środowisko produkcyjne
define('PRZELEWY24_TYPE', 'secure');

class PrzelewyController extends Controller
{
    public function CreateToken($p24_amount = null, $p24_description = null, $p24_email = null, $p24_url_return = null, $p24_url_status = null, $p24_session_id = null)
    {
        $headers[] = 'p24_merchant_id=' . PRZELEWY24_MERCHANT_ID;
        $headers[] = 'p24_pos_id=' . PRZELEWY24_MERCHANT_ID;
        $headers[] = 'p24_crc=' . PRZELEWY24_CRC;
        $headers[] = 'p24_session_id=' . $p24_session_id;
        $headers[] = 'p24_amount=' . $p24_amount;
        $headers[] = 'p24_currency=PLN';
        $headers[] = 'p24_description=' . $p24_description;
        $headers[] = 'p24_country=PL';
        $headers[] = 'p24_url_return=' . urlencode($p24_url_return);
        $headers[] = 'p24_url_status=' . urlencode($p24_url_status);
        $headers[] = 'p24_api_version=3.2';
        $headers[] = 'p24_sign=' . md5($p24_session_id . '|' . PRZELEWY24_MERCHANT_ID . '|' . $p24_amount . '|PLN|' . PRZELEWY24_CRC);
        $headers[] = 'p24_email=' . $p24_email;

        $oCURL = curl_init();
        curl_setopt($oCURL, CURLOPT_POST, 1);
        curl_setopt($oCURL, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
        curl_setopt($oCURL, CURLOPT_POSTFIELDS, implode('&', $headers));
        curl_setopt($oCURL, CURLOPT_URL, 'https://' . PRZELEWY24_TYPE . '.przelewy24.pl/trnRegister');
        curl_setopt($oCURL, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($oCURL, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($oCURL, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCURL, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($oCURL);
        curl_close($oCURL);

        parse_str($response, $output);
        return isset($output['token']) ? $output['token'] : 0;
    }

    public function Pay($p24_amount = null, $p24_description = null, $p24_email = null, $p24_url_return = null, $p24_url_status = null, $p24_session_id = null)
    {
        $token = $this->CreateToken($p24_amount, $p24_description, $p24_email, $p24_url_return, $p24_url_status, $p24_session_id);
        return 'https://' . PRZELEWY24_TYPE . '.przelewy24.pl/trnRequest/' . $token;
    }

    public function Verify($data = null)
    {
        if($data != null){
        $headers[] = 'p24_merchant_id=' . $data['p24_merchant_id'];
        $headers[] = 'p24_pos_id=' . $data['p24_pos_id'];
        $headers[] = 'p24_session_id=' . $data['p24_session_id'];
        $headers[] = 'p24_amount=' . $data['p24_amount'];
        $headers[] = 'p24_currency=PLN';
        $headers[] = 'p24_order_id=' . $data['p24_order_id'];
        $headers[] = 'p24_sign=' . md5($data['p24_session_id'] . '|' . $data['p24_order_id'] . '|' . $data['p24_amount'] . '|PLN|' . PRZELEWY24_CRC);

        $oCURL = curl_init();
        curl_setopt($oCURL, CURLOPT_POST, 1);
        curl_setopt($oCURL, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
        curl_setopt($oCURL, CURLOPT_POSTFIELDS, implode('&', $headers));
        curl_setopt($oCURL, CURLOPT_URL, 'https://' . PRZELEWY24_TYPE . '.przelewy24.pl/trnVerify');
        curl_setopt($oCURL, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($oCURL, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($oCURL, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCURL, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($oCURL);
        curl_close($oCURL);

        parse_str($response, $output);
        if ($output['error'] == 0) {
            $cos = 'true';
        }else{
            $cos = 'false';
        }
        return $cos;
    } else {
        return back();
    }
    }

    public function verifyPayment()
    {
        $merchant = $_POST['p24_merchant_id'];
        $session = $_POST['p24_session_id'];
        $amount = $_POST['p24_amount'];
        $currency = "PLN";
        $order = $_POST['p24_order_id'];
        $crc = '3c1863b879671d24';
        $sign = md5($session."|".$order."|".$amount."|".$currency."|".$crc);

        $reg = array(
            'p24_merchant_id' => $merchant,
            'p24_pos_id' => $merchant,
            'p24_session_id' => $session,
            'p24_amount' => $amount,
            'p24_currency' => $currency,
            'p24_order_id' => $order,
            'p24_sign' => $sign
            );

        $curl = curl_init('https://secure.przelewy24.pl/trnVerify');
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $reg
            ));

        $response = curl_exec($curl);

        if(!curl_error($curl)) {
            DB::table('order')->where('numer_sesji', $session)->update(['status' => 'Zapłacone']);
        }

        curl_close($curl);
    }

}
