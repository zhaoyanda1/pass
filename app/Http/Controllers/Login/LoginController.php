<?php
namespace App\Http\Controllers\Login;
use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
class LoginController extends Controller
{
    public function login(Request $request)
    {
        $redirect = urldecode($request->input('redirect'));
        if(empty($redirect)){
            $redirect = env('SHOP_URL');
        }
        $info = [
            'redirect'  =>  $redirect,
        ];
        return view('login.login',$info);
    }
    /**
     * @param Request $request
     * @return array
     * 登陆处理请求
     */
    public function loginAction(Request $request)
    {
        $name = $request->input('u_name');
        $password = $request->input('u_pwd');
        //$redirect = urldecode($request->input('redirect')) ?? env('SHOP_URL');
        $where=[
            'name'=>$name
        ];
        $userInfo=UserModel::where($where)->first();
        if(empty($userInfo)){
            $response = [
                'errno' =>  40001,
                'msg'   =>  '用户名不存在'
            ];
            return $response;
        }
        $pas = $userInfo->password;
        if(password_verify($password,$pas)){
            $uid = $userInfo->id;
            $key = 'token:' . $uid;
            $token = Redis::get($key);
            if(empty($token)){
                $token = substr(md5(time() + $uid + rand(1000,9999)),10,20);
                Redis::del($key);
                Redis::hSet($key,'web',$token);
            }
            setcookie('xnn_uid',$uid,time()+86400,'/','pass.com',false,true);
            setcookie('xnn_token',$token,time()+86400,'/','pass.com',false,true);
            $request->session()->put('xnn_u_token',$token);
            $request->session()->put('xnn_uid',$uid);
            $response = [
                'errno' =>  0,
                'msg'   =>  '登陆成功',
            ];
        }else{
            $response = [
                'errno' =>  40002,
                'msg'   =>  '登录失败'
            ];
        }
        return $response;
    }
    public function webLogin()
    {
    }
    /**
     * 个人中心
     */
    public function center()
    {
        echo "个人中心";
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 注册页面
     */
    public  function reg(Request $request)
    {
        $redirect = urldecode($request->input('redirect'));
        if(empty($redirect)){
            $redirect = env('SHOP_URL');
        }
        $info = [
            'redirect'  =>  $redirect,
        ];
        return view('login.reg',$info);
    }
    public function registerAction(Request $request)
    {
        $pass=$request->input('u_pwd');
        $pass1=$request->input('u_pwd1');
        $re=UserModel::where(['name'=>$request->input('u_name')])->first();
        if($re){
            $response = [
                'errno' =>  40004,
                'msg'   =>  '用户名已存在'
            ];
            return $response;
        }
        if($pass1!==$pass){
            $response = [
                'errno' =>  40005,
                'msg'   =>  '密码与确认密码不一致'
            ];
            return $response;
        }
        $pas=password_hash($pass,PASSWORD_BCRYPT);
        $data=[
            'name'=>$request->input('u_name'),
            'password'=>$pas,
            'email'=>$request->input('u_email'),
            'add_time'=>time(),
        ];
        $uid=UserModel::insertGetId($data);
        if($uid){
            $key = 'token:' . $uid;
            $token = substr(md5(time() + $uid + rand(1000,9999)),10,20);
            Redis::del($key);
            Redis::hSet($key,'web',$token);
            setcookie('xnn_uid',$uid,time()+86400,'/','pass.com',false,true);
            setcookie('xnn_token',$token,time()+86400,'/','pass.com',false,true);
            $request->session()->put('xnn_u_token',$token);
            $request->session()->put('xnn_uid',$uid);
            $response = [
                'errno' =>  0,
                'msg'   =>  '注册成功'
            ];
        }else{
            $response = [
                'errno' =>  40006,
                'msg'   =>  '注册失败'
            ];
        }
        return $response;
    }
    public function apiLogin(Request $request)
    {
        $name = $request->input('u_name');
        $password = $request->input('u_pwd');
        $where=[
            'name'=>$name
        ];
        $userInfo=UserModel::where($where)->first();
        if(empty($userInfo)){
            $response = [
                'errno' =>  40001,
                'msg'   =>  '用户名不存在'
            ];
            return $response;
        }
        $pas = $userInfo->password;
        if(password_verify($password,$pas)){
            $uid = $userInfo->uid;
            $key = 'api:token:' . $uid;
            $token = Redis::get($key);
            if(empty($token)){
                $token = substr(md5(time() + $uid + rand(1000,9999)),10,20);
                Redis::del($key);
                Redis::hSet($key,'app',$token);
            }
            $response = [
                'errno' =>  0,
                'msg'   =>  '登陆成功',
                'token' =>  $token
            ];
        }else{
            $response = [
                'errno' =>  40002,
                'msg'   =>  '登录失败'
            ];
        }
        return $response;
    }
}