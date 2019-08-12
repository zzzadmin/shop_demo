<?php

namespace App\Http\Controllers;
use App\Http\Model\Wechat_openid;//模型
use App\Http\Model\Admin;//模型
use Illuminate\Http\Request;
use App\Http\Model\User_openid;
use DB;
use App\Http\Tools\Wechat;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
class WechatController extends Controller
{
	public $request;
	public $wechat;
	public function __construct(Request $request,Wechat $wechat){
		$this->request = $request;
		$this->wechat = $wechat;
	}
	// 微信消息推送
	public function event(){
		// echo $_GET['echostr'];
        // die();
        //$this->checkSignature();
        $data = file_get_contents("php://input");
        //解析XML
        $xml = simplexml_load_string($data,'SimpleXMLElement', LIBXML_NOCDATA);        //将 xml字符串 转换成对象
        $xml = (array)$xml; //转化成数组
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
        file_put_contents(storage_path('logs/wx_event.log'),$log_str,FILE_APPEND);
        \Log::Info(json_encode($xml));
        $message = '你好!';
        $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
        echo $xml_str;
        //echo $_GET['echostr'];
	}
	// 清除接口调用次数
	public function clean_up(){
        $url = 'https://api.weixin.qq.com/cgi-bin/clear_quota?access_token='.$this->wechat->get_access_token();
        $data = [
          'appid' => env('WECHAT_APPID'),
        ];
        $datas = $this->wechat->post($url,json_encode($data));
        dd(json_decode($datas));
    }
	// 根据标签为用户推送消息
	public function push_mark_message(Request $request){
		$data = $this->wechat->mark_user($request->all()['tag_id']);
		// 当关注粉丝为空时
		if($data['count'] == 0){
			echo ("<script>alert('该标签下粉丝数为0,请添加粉丝');location='/wechat/mark_list';</script>");die;
		}
		$tag_id = $request->all()['tag_id'];
		// dd($data);
		$openid = json_encode($data['data']['openid']);//转换为json形式
		return view('wechat.pushMarkMessage',['openid'=>$openid,'tag_id'=>$tag_id]);
	}

	// 执行推送消息
	public function push_mark_message_do(Request $request){
		$url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$this->wechat->get_access_token();
		$tag_id = $request->all()['tag_id'];
		// 接收推送类型
		$push_type = $request->all()['push_type'];
		// 根据推送类型进行判断
		if($push_type == 1){
			// 文本消息
			$data = [
				"filter" => ["is_to_all"=>false,"tag_id"=>$tag_id],
			   "text" => ['content' => $request->all()['content']],
			    "msgtype"=> "text"
			];
		}elseif($push_type == 2){
			// 图文消息
			$data = [
                'filter' => ['is_to_all'=>false,'tag_id'=>$tag_id],
                'image' => ['media_id' => $request->all()['media_id']],
                'msgtype' => 'image'
            ];
		}
			
		$re = $this->wechat->post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        dd(json_decode($re,1));
	}
	// 创建标题视图
	public function mark(){
		return view('wechat.add_mark');
	}
	// 创建标签
	public function mark_add(Request $request){
		$name = $request->all()['name'];
		// dd($name);
		$url = "https://api.weixin.qq.com/cgi-bin/tags/create?access_token=".$this->wechat->get_access_token();
		$data = [
			'tag'=>['name'=>$name]
		];
		// dd($data);
		$re = $this->wechat->post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
		if($re){
			echo ("<script>alert('创建标签成功');location='/wechat/mark_list';</script>");
		 }else{
			echo ("<script>alert('创建标签失败');location='/wechat/mark_list';</script>");
		}
        // dd($re);
	}

	// 获取公众号已创建的标签
	public function mark_list(){
		$url = "https://api.weixin.qq.com/cgi-bin/tags/get?access_token=".$this->wechat->get_access_token();
		// 请求方式get
		$re = file_get_contents($url);
		// dd($re);
		$info = json_decode($re,1);//转为数组
		// dd($info);
		// dd($info['tags']);
		return view('wechat/mark_list',['info'=>$info['tags']]);
	}

	// 获取用户标签
	public function mark_list_do(Request $request){
		$url = "https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token=".$this->wechat->get_access_token();
		$openid = ['openid'=>$request->all()['openid']];
		$re = $this->wechat->post($url,json_encode($openid));
		// 用户标签列表
		$user_mark_info = json_decode($re,1);
		// dd($user_mark_info);
		$mark_info = $this->wechat->mark_fans_list();
		// dd($mark_info);
		// dd($openid);
		$mark_arr = $mark_info['tags'];
		// dd($mark_arr);
		foreach($mark_arr as $v){
            foreach($user_mark_info['tagid_list'] as $vo){
                if($vo == $v['id']){
                    echo $v['name']."<a href='".env('APP_URL').'/wechat/mark_peo_del'.'?tag_id='.$v['id'].'&openid='.$request->all()['openid']."'>删除</a><br/>";
                }
            }
        }
	}

	// 编辑标签视图
	public function mark_update(Request $request){
		$tag_id = $request->all()['tag_id'];
		// dd($tag_id);
		return view('wechat.upd_mark',['tag_id'=>$tag_id]);
	}

	// 编辑标签
	public function mark_upd(Request $request){
		$data = $request->all();
		$tag_id = $data['tag_id'];
		$name = $data['name'];
		$url = "https://api.weixin.qq.com/cgi-bin/tags/update?access_token=".$this->wechat->get_access_token();
		$data = [
			'tag'=>['id'=>$tag_id,'name'=>$name]
		];
		$re = $this->wechat->post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
		// dd($re);
		if($re){
			echo ("<script>alert('修改成功');location='/wechat/mark_list';</script>");
		 }else{
			echo ("<script>alert('修改失败');location='/wechat/mark_list';</script>");
		}

	}

	// 删除标签
	public function mark_del(Request $request){
		// 获取接收的标签id
		$id = $request->all()['id'];

		$url = "https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=".$this->wechat->get_access_token();
		$data = [
			'tag'=>['id'=>$id]
		];
		$re = $this->wechat->post($url,json_encode($data));
		if($re){
			echo ("<script>alert('删除成功');location='/wechat/mark_list';</script>");
		 }else{
			echo ("<script>alert('删除失败');location='/wechat/mark_list';</script>");
		}
	}

	// 获取标签下粉丝列表
	public function mark_fans_list(Request $request){
		$id = $request->all()['id'];
		$url = 'https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token='.$this->wechat->get_access_token();
		// 获取openid
    	// $openid = $this->wechat->openid();
    	$data = [
    			"tagid"=> $id,
				"next_openid"=>''  
			];
		// dd($data);
    	$re = $this->wechat->post($url,json_encode($data));
    	$info = json_decode($re,1);
		// dd($info);
		// 当关注粉丝为空时
		if($info['count'] == 0){
			echo ("<script>alert('该标签下粉丝数为0,请添加粉丝');location='/wechat/mark_list';</script>");die;
		}
		return view('wechat/fans_list',['info'=>$info['data']['openid']]);
	}

	// 批量为用户打标签
	public function mark_peo(Request $request){
		$openid_info = Wechat_openid::whereIn('id',$request->all()['id_list'])->select(['openid'])->get()->toArray();
		$openid_list = [];
        foreach($openid_info as $v){
            $openid_list[] = $v['openid'];
        }
		// dd($openid_list);
		$url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$this->wechat->get_access_token();
		$tag_id = $request->all()['tag_id'];
		// dd($tag_id);
        $data = [
            'openid_list'=>$openid_list,
            'tagid'=>$request->all()['tag_id'],
        ];
        // dd($data);
		$re = $this->wechat->post($url,json_encode($data));
		if($re){
			echo ("<script>alert('为粉丝打标签成功');location='/wechat/mark_list';</script>");
		 }else{
			echo ("<script>alert('为粉丝打标签失败');location='/wechat/mark_list';</script>");
		}
		// dd($re);

	}

	// 获取用户身上的标签列表
	public function mark_peo_list(Request $request){
		// 获取openid
		$openid = $this->wechat->openid();
		$url = "https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token=".$this->wechat->get_access_token();
		foreach ($openid as $v) {
			$data = [
				'openid'=>$v
			];
		}
		// dd($data);
		$re = $this->wechat->post($url,json_encode($data));
		dd($re);
	}

	// 批量为用户取消标签
	public function mark_peo_del(Request $request){
		// 获取用户的tagid和openid
		$tagid = $request->all()['tag_id'];
		$openid = $request->all()['openid'];
    	$url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token=".$this->wechat->get_access_token();
    	if(!is_array($openid)){
    		$openid_list = [$openid];
    	}else{
    		$openid = $openid;
    	}
    	// dd($openid_list);
    	$data = [
            'openid_list' => $openid_list,
            'tagid' => $tagid
        ];
    	$re = $this->wechat->post($url,json_encode($data));
		// dd(json_decode($re,1));
		if($re){
			echo ("<script>alert('为粉丝删除标签成功');location='/wechat/mark_list';</script>");
		 }else{
			echo ("<script>alert('为粉丝删除标签失败');location='/wechat/mark_list';</script>");
		}
	}
	
    // 推送模板消息
    public function push_template()
    {
        $openid_info = Wechat_openid::select('openid')->limit(10)->get()->toArray();
        foreach($openid_info as $v){
            $this->wechat->push_template($v['openid']);
        }
    }

    // 模板列表
    public function template_list()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token='.$this->wechat->get_access_token();
        $re = file_get_contents($url);
        dd(json_decode($re,1));
    }

    // 删除模板消息
    public function del_template()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token='.$this->wechat->get_access_token();
        $data = [
            'template_id' => 'z2E0ChWznRD1MdXueonMdVQspeSrJUEp3j8s7ogfbMs'
        ];
        $re = $this->wechat->post($url,json_encode($data));
        dd($re);
    }

    // 登录
	public function login(){
		$redirect_uri = 'http://www.shopdemo.com/wechat/code';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect ';

		header('Location:'.$url);
	}
	// 通过code获得access_token
	public function code(Request $request){
		$data = $request->all();
		$code = $data['code'];
		// dd($code);
		// 获取access_token
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env("WECHAT_APPID")."&secret=".env("WECHAT_APPSECRET")."&code=".$code."&grant_type=authorization_code";

		$info = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."&code=".$code."&grant_type=authorization_code");
    	$infos = json_decode($info,1);
    	// dd($infos);
    	$access_token = $infos['access_token'];
        $openid = $infos['openid'];

        // 获取用户基本信息
    	$Wechat_openid_user_info = $this->wechat->wechat_user_info($openid);
        //去user_openid 表查 是否有数据 openid = $openid
        $user_openid = User_openid::where(['openid'=>$openid])->first();

        if(!empty($user_openid)){
        	// 有数据 在网站用用户admin表中的数据登录框
        	$user_info = Admin::where(['id'=>$user_openid->uid])->first();
        	$request->session()->put('username',$user_info['name']);
        	// 推送模板消息[告诉用户在我们的模板登录了]
        	$openid_info = Wechat_openid::select('openid')->limit(10)->get()->toArray();
	        foreach($openid_info as $v){
	            $this->wechat->push_template($v['openid']);
	        }
        	header('Location:http://www.shopdemo.com');
        }else{
        	// 没有数据 注册信息 insert user user_openid  生成新用户
        	DB::connection("mysqldemo")->beginTransaction();
        	$user_result = Admin::insertGetId([
        		'pwd' => '',
        		'r_name' => $Wechat_openid_user_info['nickname'],
        		'r_time' => time()
        	]);
        	dd($user_result);
        	$openid_result = User_openid::insert([
        		'uid'=>$user_result,
                'openid' => $openid,
        	]);
        	DB::connection("mysqldemo")->commit();
        	// 登录操作
        	$user_info = Admin::where(['id'=>$user_openid->uid])->first();
        	$request->session()->put('username',$user_info['r_name']);
        	// 你在我们的网站登录了
        	$openid_info = Wechat_openid::select('openid')->limit(10)->get()->toArray();
	        foreach($openid_info as $v){
	            $this->wechat->push_template($v['openid']);
	        }
        	header('Location:http://www.shopdemo.com');

        }
	}

	/**
     * 我的素材
     */
    public function upload_source()
    {
    	$url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$this->wechat->get_access_token();
        $data = ['type'=>'image','offset'=>0,'count'=>20];
        $re = $this->wechat->post($url,json_encode($data));
        // echo '<pre>';
        // print_r(json_decode($re,1));
        // dd($re);
        return view('wechat.uploadSource');
    }


    // 上传资源
    public function do_upload(Request $request)
    {
        $upload_type = $request['up_type'];
        $re = '';
        if($request->hasFile('image')){
            //图片类型
            $re = $this->wechat->upload_source($upload_type,'image');
        }elseif($request->hasFile('voice')){
            //音频类型
            //保存文件
            $re = $this->wechat->upload_source($upload_type,'voice');
        }elseif($request->hasFile('video')){
            //视频
            //保存文件
            $re = $this->wechat->upload_source($upload_type,'video','视频标题','视频描述');
        }elseif($request->hasFile('thumb')){
            //缩略图
            $path = $request->file('thumb')->store('wechat/thumb');
        }
        echo $re;
        dd();

    }
	// 获取音频
	public function get_voice_source()
    {
        $media_id = 'UKml31rzRRlr8lYfWgAno9mGe-meph0BKmVtZugAHQTqZIxOhUoBvCnqfJMRMKTG';
        $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->wechat->get_access_token().'&media_id='.$media_id;
        //echo $url;echo '</br>';
        //保存图片
        $client = new Client();
        $response = $client->get($url);
        //$h = $response->getHeaders();
        //echo '<pre>';print_r($h);echo '</pre>';die;
        //获取文件名
        $file_info = $response->getHeader('Content-disposition');
        $file_name = substr(rtrim($file_info[0],'"'),-20);
        //$wx_image_path = 'wx/images/'.$file_name;
        //保存图片
        $path = 'wechat/voice/'.$file_name;
        $re = Storage::put($path, $response->getBody());
        echo env('APP_URL').'/storage/'.$path;
        dd($re);
    }

    // 获取视频
    public function get_video_source(){
        $media_id = 'xAoUUhXXhoBPzDB0R6oBYmHKkKZgR_JptrbL2yHnXMhKLibHeTccFGTQE5a7i8dq'; //视频
        $url = 'http://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->wechat->get_access_token().'&media_id='.$media_id;
        $client = new Client();
        $response = $client->get($url);
        
        $video_url = json_decode($response->getBody(),1)['video_url'];
        echo($response->getBody());
        $file_name = explode('/',parse_url($video_url)['path'])[2];
        //设置超时参数
        $opts=array(
            "http"=>array(
                "method"=>"GET",
                "timeout"=>3  //单位秒
            ),
        );
        //创建数据流上下文
        $context = stream_context_create($opts);
        //$url请求的地址，例如：
        $read = file_get_contents($video_url,false, $context);
        $re = file_put_contents('./storage/wechat/video/'.$file_name,$read);
        var_dump($re);
        die();
    }
    // 获取图片
    public function get_source()
    {
        $media_id = 'ZAUX6xRdbtVsh5H51zexIqS4LUcd5FE8yeyyESvs8cqiIrT4HMJ1N_W80NdbcQqa'; //图片

        $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->wechat->get_access_token().'&media_id='.$media_id;
        //echo $url;echo '</br>';
        //保存图片
        $client = new Client();
        $response = $client->get($url);
        //$h = $response->getHeaders();
        //echo '<pre>';print_r($h);echo '</pre>';die;
        //获取文件名
        $file_info = $response->getHeader('Content-disposition');
        $file_name = substr(rtrim($file_info[0],'"'),-20);
        //$wx_image_path = 'wx/images/'.$file_name;
        //保存图片
        $path = 'wechat/image/'.$file_name;
        $re = Storage::disk('local')->put($path, $response->getBody());
        echo env('APP_URL').'/storage/'.$path;
        dd($re);

        //return $file_name;
    }

    // 删除永久素材
    public function del_source(){
    	$url = 'https://api.weixin.qq.com/cgi-bin/material/del_material?access_token='.$this->wechat->get_access_token();
    	$data = [
            'media_id' => '9Q6khhYaqVsG0wAF0iFoupDrhA8XHbbOsC7yZbu2XAE'
        ];
        $re = $this->wechat->post($url,json_encode($data));
        dd($re);
    }
	

	// 获取关注用户列表
    public function get_user_list(){
    	$access_token = $this->wechat->get_access_token();
    	// dd($access_token);
    	// 获取关注用户列表
    	$Wechat_openid_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}&next_openid=");
    	// 用户信息
    	$user_info = json_decode($Wechat_openid_user,1);
    	$openid = $user_info['data']['openid'];
    	foreach ($openid as $v){
    		$subscribe = Wechat_openid::where(['openid'=>$v])->value('subscribe');
    		if(empty($subscribe)){
    			// 获取用户详细信息
    			$access_token = $this->wechat->get_access_token();
	    		$openid = $v;
	    		$Wechat_openid_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
		    	$user = json_decode($Wechat_openid_user,1);
	    		$res = Wechat_openid::insert([
	    			'openid'=> $v,
	    			'add_time'=> time(),
	    			'subscribe'=> $user['subscribe']
	    		]);
    		}else{
    			// 获取用户详细信息
    			$access_token = $this->wechat->get_access_token();
	    		$openid = $v;
	    		$Wechat_openid_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
		    	$user = json_decode($Wechat_openid_user,1);
		    	if($subscribe != $user['subscribe']){
		    		$res = Wechat_openid::where(['openid'=>$v])->update([
		    			'subscribe'=>$user['subscribe'],
		    		]);
		    	}
    		}
    		

    	}
    	echo "<script>history.go(-1);</script>";
    
    }

    // 获取关注用户信息
    public function get_user_info(){
    	$access_token = $this->wechat->get_access_token();
    	$openid = $this->get_user_list();
    	// dd($openid);
    	// 用户信息
    	$Wechat_openid_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
    	$Wechat_openid_info = json_decode($Wechat_openid_user,1);
    	// dd($Wechat_openid_info);
    }

    // 粉丝信息列表
    public function get_user_info_list(Request $request){
    	$tag_id = !empty($request->all()['tag_id'])?$request->all()['tag_id']:'';
    	$data = Wechat_openid::get();
    	// dd($data);
    	return view('wechat.user_list',['data'=>$data,'tag_id'=>$tag_id]);
    }

    // 用户基本信息
    public function get_user_basic_list(Request $request){
    	// 接收传过来的值
    	$openid = $request->get('openid');
    	// dd($openid);
    	$access_token = $this->wechat->get_access_token();
    	// 用户信息
    	$Wechat_openid_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
    	$Wechat_openid_info = json_decode($Wechat_openid_user,1);
    	$nickname = $Wechat_openid_info['nickname'];//名称
    	$sex = $Wechat_openid_info['sex'];//性别
    	$city = $Wechat_openid_info['city'];//城市
    	$subscribe = $Wechat_openid_info['subscribe'];//是否关注
    	$oid = $Wechat_openid_info['openid'];
    	$headimgurl = $Wechat_openid_info['headimgurl'];
    	// dd($Wechat_openid_info);
    	return view('wechat.user_basic_list',['data'=>$Wechat_openid_info,'sex'=>$sex,'nickname'=>$nickname,'city'=>$city,'openid'=>$oid,'subscribe'=>$subscribe,'headimgurl'=>$headimgurl]);

    }

    
}
