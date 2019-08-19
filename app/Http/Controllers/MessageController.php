<?php

namespace App\Http\Controllers;
use App\Http\Tools\Wechat;
use Illuminate\Http\Request;
use App\Http\Model\User_openid;
use App\Http\Model\Wechat_openid;//模型
use App\Http\Model\Admin;
class MessageController extends Controller
{
    public $wechat;
    public function __construct(Wechat $wechat)
    {
        $this->wechat = $wechat;
    }

    // 用户同意授权，获取code
    public function login(){
    	$redirect_uri = 'http://www.shopdemo.com/message/code';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect ';
        header('Location:'.$url);
    }

    // 通过code获得access_token
    public function code(Request $request){
    	$req = $request->all();
    	$code = $req['code'];
    	// 获取access_token
    	$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env("WECHAT_APPID")."&secret=".env("WECHAT_APPSECRET")."&code=".$code."&grant_type=authorization_code";
    	// 获取access_token
        $re = file_get_contents($url);
        $result = json_decode($re,1);//转为数组
        // 获取access_token 和 openid
		$access_token = $result['access_token'];
        $openid = $result['openid'];
        // 登录网站
        
        //获取用户基本信息
        $wechat_user_info = $this->wechat->wechat_user_info($openid);
        // 去user_openid 表查 是否有数据 openid = $openid
        $user_openid = User_openid::where(['openid'=>$openid])->first();
        if(!empty($user_openid)){
        	// 有数据 跳转粉丝列表页面
        	$user_info = Admin::where(['id'=>$user_openid->uid])->first();
        	// 已注册 需要登录操作
            $request->session()->put('uid'=>$user_openid['uid']);
            // 推送模板消息[告诉用户在我们的模板登录了]
        	$openid_info = Wechat_openid::select('openid')->limit(10)->get()->toArray();
	        foreach($openid_info as $v){
	            $this->wechat->push_template($v['openid']);
	        }
        	header('Location:http://www.shopdemo.com/wechat/get_user_info_list');
        }
    }

    // 发送留言视图
    public function send_message(Request $request){
    	$openid = $request->all()['openid'];
    	return view('message.send_message',['openid'=>$openid]);
    }

    public function send_message_do(Request $request){
    	// 留言内容
    	$content = $request->all()['content'];
    	$openid = $request->all()['openid'];

    	$access_token = $this->wechat->get_access_token();
    	// 用户信息
    	$Wechat_openid_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
    	$Wechat_openid_info = json_decode($Wechat_openid_user,1);
    	$nickname = $Wechat_openid_info['nickname'];//名称
    	// dd();

    	// dd($openid);
    	// $this->wechat->push_template($openid);

    	$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->wechat->get_access_token();
        $data = [
            'touser'=>$openid,
            'template_id'=>'5orHUWxTQDVOwIJPURreYpglaPI6sZgBwAEqeUdAnWM',
            'url'=>'http://www.baidu.com',
            'data' => [
                'first' => [
                    'value' => $nickname,
                    'color' => ''
                ],
                'keyword1' => [
                    'value' => $content,
                    'color' => ''
                ]
            ]
        ];
        $re = $this->wechat->post($url,json_encode($data));
        dd($re);
    }
}
