<?php
namespace App\Http\Tools;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
class Wechat{
    public  $request;
    public  $client;
    public function __construct(Request $request,Client $client)
    {
        $this->request = $request;
        $this->client = $client;
    }

    // 根据标签id获取标签粉丝
    public function mark_user($tag_id){
        $url = 'https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token='.$this->get_access_token();
        $data = [
            'tagid' => $tag_id,
            'next_openid' => ''
        ];
        $re = $this->post($url,json_encode($data));
        return json_decode($re,1);
    }

    /**
     * 公众号的标签列表
     */
    public function mark_fans_list()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$this->get_access_token();
        $re = file_get_contents($url);
        $mark_info = json_decode($re,1);
        return $mark_info;
    }
	// 获取用户信息
	public function wechat_user_info($openid){
        $access_token = $this->get_access_token();
        $wechat_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
        $user_info = json_decode($wechat_user,1);
        return $user_info;
    }

    /**
     * 上传微信素材资源
     */
    public function upload_source($up_type,$type,$title='',$desc=''){
        $file = $this->request->file($type);
        $file_ext = $file->getClientOriginalExtension();//获取文件扩展名
        //重命名
        $new_file_name = time().rand(1000,9999). '.'.$file_ext;
        //文件保存路径
        //保存文件
        $save_file_path = $file->storeAs('wechat/video',$new_file_name);//返回保存成功之后的文件路径
        $path = './storage/'.$save_file_path;
        if($up_type  == 1){
            // 临时素材
            $url='https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.$this->get_access_token().'&type='.$type;

        }elseif($up_type == 2){
            // 永久素材
            $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->get_access_token().'&type='.$type;
        }
        $multipart = [
            [
                'name'     => 'media',
                'contents' => fopen(realpath($path), 'r')
            ],
        ];
        if($type == 'video' && $up_type == 2){
            $multipart[] = [
                    'name'     => 'description',
                    'contents' => json_encode(['title'=>$title,'introduction'=>$desc])
            ];
        }
        $response = $this->client->request('POST',$url,[
            'multipart' => $multipart
        ]);
        //返回信息
        $body = $response->getBody();
        unlink($path);
        return $body;
    }

	/**
	 * 根据openid发送模板消息
	 * @param  [type] $openid [description]
	 * @return [type]         [description]
	 */
	public function push_template($openid)
    {
        //$openid = 'otAUQ1XOd-dph7qQ_fDyDJqkUj90';
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->get_access_token();
        $data = [
            'touser'=>$openid,
            'template_id'=>'2cKbeGOnrL7CaaBhfZLr1k3GW4HdXEMhapmrUYGcHHE',
            'url'=>'http://www.baidu.com',
            'data' => [
                'first' => [
                    'value' => '',
                    'color' => ''
                ],
                'keyword1' => [
                    'value' => '自定义1',
                    'color' => ''
                ],
                'keyword2' => [
                    'value' => '',
                    'color' => ''
                ],
                'remark' => [
                    'value' => '备注',
                    'color' => ''
                ]
            ]
        ];
        $re = $this->post($url,json_encode($data));
        return $re;
    }

    /**
     * post请求
     * @param $url
     * @param $data
     * @return bool|string
     */
    public function post($url, $data = []){
        //初使化init方法
        $ch = curl_init();
        //指定URL
        curl_setopt($ch, CURLOPT_URL, $url);
        //设定请求后返回结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //声明使用POST方式来进行发送
        curl_setopt($ch, CURLOPT_POST, 1);
        //发送什么数据
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //忽略证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //忽略header头信息
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //设置超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        //发送请求
        $output = curl_exec($ch);
        //关闭curl
        curl_close($ch);
        //返回数据
        return $output;
    }

    /**
     * 获取access_token
     */
    public function get_access_token(){
        //获取access_token
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');
        $access_token_key = 'wechat_access_token';
        if($redis->exists($access_token_key)){
            //去缓存拿
            $access_token = $redis->get($access_token_key);
        }else{
            //去微信接口拿
            $access_re = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET'));
            $access_result = json_decode($access_re,1);
            $access_token = $access_result['access_token'];
            $expire_time = $access_result['expires_in'];
            //加入缓存
            $redis->set($access_token_key,$access_token,$expire_time);
        }
        // dd($access_token);
        return $access_token;
    }

    // 获取openid
    public function openid(){
        // 获取用户基本信息
        $access_token = $this->get_access_token();
        // dd($access_token);
        // 获取关注用户列表
        $user_info = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}&next_openid=");
        $user_info = json_decode($user_info,1);
        // dd($user_info);
        $openid = $user_info['data']['openid'];
        return $openid;
    }
}