<?php

namespace App\Http\Controllers\love;
use App\Http\Tools\Wechat;
use App\Http\Model\User_openid;
use App\Http\Model\Wechat_openid;//模型
use App\Http\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoveController extends Controller
{
	public $wechat;
    public function __construct(Wechat $wechat)
    {
        $this->wechat = $wechat;
    }

    // 我要表白视图
	public function add(){
		$redirect_uri = 'http://www.shopdemo.com/love/code';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect ';
        header('Location:'.$url);
		return view('love.add');
	}

	public function code(Request $request){
		$data = $request->all();
		dd($data);
	}

	public function send(Request $request){
		$openid = $request->all()['openid'];
		return view('love.send',['openid'=>$openid]);	
	}

	public function send_do(Request $request){
		$content = $request->all()['content'];
		// dd($content);
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
            'template_id'=>'axAay26XpP_zxvrCkIGejrSaY-VjftDAUljevOeC19Y',
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
