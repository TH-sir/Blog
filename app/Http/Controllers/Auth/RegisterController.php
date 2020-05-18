<?php

namespace App\Http\Controllers\Auth;

use App\Models\Auth\Admin;
use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Models\Visitor\visitorInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:blog_users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Auth\User
     */

    protected function create(array $data)
    {
        $img = Input::file('img');
        $src = $this->uploadFile($img);
        if ($src['code'] === 1){
           dd($src['data']);
        }
        else{
            return User::create([
                'avatar'=> $src['path'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }

    }

    public function uploadFile($file) {
        $upload = new UploadController();
        // 此时 $this->upload如果成功就返回文件名不成功返回false
        $fileName =$upload->upload($file);
        if ($fileName){
            return ['path'=>$fileName,'code'=>0];
        }
        return ['code'=>1,'data'=>'上传失败请检查图片大小不大于2M，仅限格式为jpg，png，gif'];
    }
}
