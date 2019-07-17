<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Pay;
class PayController extends Controller
{
    public $app_id;
    public $gate_way;
    public $notify_url;
    public $return_url;
    public $rsaPrivateKeyFilePath = '';  //路径
    public $aliPubKey = '';  //路径
    public $privateKey = 'MIIEpQIBAAKCAQEAzCKNJhtcarQgauKTPpKX8sp0FUC1RKaNyhdOiStdIp9qfS3per260TGOQXX3ZT8n2xlEFLgt7Ufb+sUBkvFUEcAEaG4ewh9aWrbT8GW+l8w/FQTby/02DqxVFVZYGPZCgIhXT2Mdd8QUR8/zmpUWURdHjAhy3ChUOoOd1ANucRYap7XOiNDQxKlXh1R5JFpZ5/qzBZOYqpNwmZ4htFc4kThYUTcmZSI6nR/9cCXs84yWx7rR7AI9BD5+BKg4KyDHlY3m5B5t60jwI2UmCWIRkwJCzBWSPLU2CqUSJuc1f/spv8EuRc+61eh0Ac/3kuwUTVIfRPotq82HD9Jlk+6CuQIDAQABAoIBAQCo2oOq28MMOEcAYr6taZDqsfBnjAjk6mgqnDDIYeg+NWNefFW+w6X+WGF1YGDtjNoo77NS+C51MZWSztbId3q03AJJZ51lsY2Jr+WL2n1XDwm3FzfAeoj2hjIy3iMtMrY7n4upDTFY2gZ0iFzWpy+4j+sMuAhad7mEVU5+CwCV5NqgNv3W9NI9hzxxYnmlnUW2oRridWw9U4lCgtMFGvwpW4FDnRU8hVoGSsWyYtue80vu7vdKkvQwx4dpHdqlEifL/EVVwxoMsq/KWx27uK73Gg3GSfxhkmRh7G8ajMTCn1Vqah1sQ5YSqQoE4ar9LrOvUauqSzHlLKwcxkSW7xFJAoGBAOZzPGIMgSV/92zbLdrB/eFtU48DWZtvaG6oMVTqiT1ovP0PEriqyhEX3OmvmoG6serv0WkzqUjwpTstIajUPlf/mDOv+LhTDj8g2V5FKKUat32uVn4EHVKcO40llsLYMKVK0ZLKybWvnoLhpJ3R5+B9YK3skelAsIQ4+IbdNN/jAoGBAOLEbG/d94GMmbDnykXBFnW4wfm6Aq/WWKknGWBt0niGseDK3OZF7PPFq+UjBbzfdIzpJ1PqXZ/9vq4o2TF0RdZ56wCYBgN+854MpcpvdxNoKkHLdJXG3YstlF2T/enXdVNYYv6hOQeVzDqicTk2eQoQ/f/nk4OOCY7qv9Vzxd2zAoGBALgYIoqpNppAaeX6Cd2Rz0DAV1oN8Q1sqF6N2ird2ZjHDQKTgf8n4JhbGc1MzP8Jp4vo3L9P19I++6AUY6k9NDiUJIBV+Tk2kFD56uuWD+wlNaQfG1U78DjIOgJ9nrw0fFfvNxAvE4girVwc6aZxwuzg+9S1AbL2TIyz/kWufMjFAoGAUatyblufzz2HAKqKM9MVtrIi0kDGxPNKnSkiv5Lt8VB5cb8+DYTzkNwJS43wfBRyUmmKK3PF4mAts2Wsy13X5SWlmGIoEExBixN9BkpctVWXmnie9W5Yzc5Nl+I72WMqsyirBo+kDXJKyndEldljgFecUvThMMkP8jPjgQmgIncCgYEAonkIY/sibb+btI35BGeZ1PgJ+L58ce1KqPIEcwYEMi93igO4hDPBbMe5fPQ9j+42M2d+Ag/5sWH8BuqSKAOQVmVa+HG+enWesmEPgJOSZA6RHlNFr9ZlgiEJdbIGSHpkx3XDLiex/7dQtMZnIx+4CHdYCOf35VWck3JPJgSL1HY=';
    public $publicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzTy/oS0t7ousGkmtwzc+N279J8dNyVN0LGtQlBhRdMD4FW3eDjv8IMhbl7obZI+Tstrw+2VYkIypW72Gkr12pHYByQymOhIyzLfx6PhXskgHNdgWF0GO5ToNbQrhKgQ+wiZ+v3yph9wX7U1OAAYO1+ig6DQT/w119LlOt5KzahPHoWhpJrJPRs/YfYLcLbv59BjEGtzaImU9NhEb/TxSF7qpwK9WwgVcr1w7cwnDM7HvP2JSVIJSEPiy3tzla2gp5hviDtEnxKOh38+t1O1fHYH5B4nnRFONrVi1bk0PLBWnBKPrYI+cmED75u8/EDAza5XMFnHXFOsxMkL/NOsufwIDAQAB';
    public function __construct()
    {
        $this->app_id = '2016101100657612';
        $this->gate_way = 'https://openapi.alipaydev.com/gateway.do';
        $this->notify_url = env('APP_URL').'/notify_url';
        $this->return_url = env('APP_URL').'/return_url';
    }

    public function do_pay(){
        $oid = time().mt_rand(1000,1111);  
        //订单编号
        $order = [
            'out_trade_no' => $oid,
            'total_amount' => '1',
            'subject' => 'test submit - 测试',
        ];
        
        return Pay::alipay()->web($order);
        //$this->ali_pay($oid);
    }

    public function notify_url(){
        $post_json = file_get_contents("php://input");
        \Log::Info($post_json);
        $post = json_decode($post_json,1);
        // 业务处理
    }
    
    public function rsaSign($params) {
        return $this->sign($this->getSignContent($params));
    }
    protected function sign($data) {
    	if($this->checkEmpty($this->rsaPrivateKeyFilePath)){
    		$priKey=$this->privateKey;
			$res = "-----BEGIN RSA PRIVATE KEY-----\n" .
				wordwrap($priKey, 64, "\n", true) .
				"\n-----END RSA PRIVATE KEY-----";
    	}else{
    		$priKey = file_get_contents($this->rsaPrivateKeyFilePath);
            $res = openssl_get_privatekey($priKey);
    	}
        
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        if(!$this->checkEmpty($this->rsaPrivateKeyFilePath)){
            openssl_free_key($res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }
    public function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                // 转换成目标字符集
                $v = $this->characet($v, 'UTF-8');
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }

    

    /**
     * 根据订单号支付
     * [ali_pay description]
     * @param  [type] $oid [description]
     * @return [type]      [description]
     */
    public function ali_pay($oid){
        $order = [];
        $order_info = $order;
        //业务参数
        $bizcont = [
            'subject'           => 'Lening-Order: ' .$oid,
            'out_trade_no'      => $oid,
            'total_amount'      => 10,
            'product_code'      => 'FAST_INSTANT_TRADE_PAY',
        ];
        //公共参数
        $data = [
            'app_id'   => $this->app_id,
            'method'   => 'alipay.trade.page.pay',
            'format'   => 'JSON',
            'charset'   => 'utf-8',
            'sign_type'   => 'RSA2',
            'timestamp'   => date('Y-m-d H:i:s'),
            'version'   => '1.0',
            'notify_url'   => $this->notify_url,        //异步通知地址
            'return_url'   => $this->return_url,        // 同步通知地址
            'biz_content'   => json_encode($bizcont),
        ];
        //签名
        $sign = $this->rsaSign($data);
        $data['sign'] = $sign;
        $param_str = '?';
        foreach($data as $k=>$v){
            $param_str .= $k.'='.urlencode($v) . '&';
        }
        $url = rtrim($param_str,'&');
        $url = $this->gate_way . $url;
        dd($url);
        header("Location:".$url);

    }
    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;
        return false;
    }
    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset) {
        if (!empty($data)) {
            $fileType = 'UTF-8';
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }
        return $data;
    }
    /**
     * 支付宝同步通知回调
     */
    public function aliReturn()
    {
        header('Refresh:2;url=/order_list');
        echo "<h2>订单： ".$_GET['out_trade_no'] . ' 支付成功，正在跳转</h2>';
    }
    /**
     * 支付宝异步通知
     */
    public function aliNotify()
    {
        $data = json_encode($_POST);
        $log_str = '>>>> '.date('Y-m-d H:i:s') . $data . "<<<<\n\n";
        //记录日志
        file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
        //验签
        $res = $this->verify($_POST);
        $log_str = '>>>> ' . date('Y-m-d H:i:s');
        if($res){
            //记录日志 验签失败
            $log_str .= " Sign Failed!<<<<< \n\n";
            file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
        }else{
            $log_str .= " Sign OK!<<<<< \n\n";
            file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
            //验证订单交易状态
            if($_POST['trade_status']=='TRADE_SUCCESS'){
                
            }
        }
        
        echo 'success';
    }
    //验签
    function verify($params) {
        $sign = $params['sign'];
        if($this->checkEmpty($this->aliPubKey)){
            $pubKey= $this->publicKey;
            $res = "-----BEGIN PUBLIC KEY-----\n" .
                wordwrap($pubKey, 64, "\n", true) .
                "\n-----END PUBLIC KEY-----";
        }else {
            //读取公钥文件
            $pubKey = file_get_contents($this->aliPubKey);
            //转换为openssl格式密钥
            $res = openssl_get_publickey($pubKey);
        }
        
        
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');
        //调用openssl内置方法验签，返回bool值
        $result = (bool)openssl_verify($this->getSignContent($params), base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        
        if(!$this->checkEmpty($this->aliPubKey)){
            openssl_free_key($res);
        }
        return $result;
    }
}
