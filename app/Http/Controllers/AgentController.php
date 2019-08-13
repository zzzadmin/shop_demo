<?php

namespace App\Http\Controllers;
use App\Http\Tools\Wechat;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use App\Http\Model\Admin;//模型
use App\Http\Model\User_agent;//模型
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public $wechat;
    public function __construct(Wechat $wechat)
    {
        $this->wechat = $wechat;
    }

    // 用户列表
    public function user_list(){
    	$user_info = Admin::get();
    	// dd($user_info);
    	return view('agent.userList',['user_info'=>$user_info]);
    }

    // 生成专属二维码
    public function create_qrcode(Request $request)
    {
        //生成带参数的二维码
        $uid = $request->all()['uid']; //用户uid
        // dd($uid);
        //用户uid就是专属推广码
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->wechat->get_access_token();
        $data = [
            'expire_seconds' => 24 * 3600 * 30,
            'action_name' => 'QR_STR_SCENE',
            'action_info' => [
                'scene' => [
                    'scene_str' => $uid
                ]
            ]
        ];
        $re = $this->wechat->post($url,json_encode($data));
        $qrcode_result = json_decode($re);
        //二维码存入larvel
        $qr_url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$qrcode_result->ticket;
        $client = new Client();
        $response = $client->get($qr_url);
        //获取文件名
        $h = $response->getHeaders();
        //echo '<pre>';print_r($h);echo '</pre>';die;
        $ext = explode('/',$h['Content-Type'][0])[1];
        $file_name = time().rand(1000,9999).'.'.$ext;
        //$wx_image_path = 'wx/images/'.$file_name;
        //保存图片
        $path = 'qrcode/'.$file_name;
        $re = Storage::disk('local')->put($path, $response->getBody());
        $qrcode_url = env('APP_URL').'/storage/'.$path;
        //存入数据库
        Admin::where(['id'=>$uid])->update([
            'qrcode_url' => $qrcode_url,
            'agent_code' => $uid
        ]);
        //返回二维码链接
        return redirect('agent/user_list');
    }

    // 用户推广列表
    public function agent_list(Request $request){
    	//用户uid
    	$uid = $request->all()['uid']; 
        //user_agent 表数据 根据uid查询
    }
}
