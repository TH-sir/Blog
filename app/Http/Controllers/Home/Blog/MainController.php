<?php

namespace App\Http\Controllers\Home\Blog;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Auth\User;
use App\Models\Blog\Article;
use App\Models\Blog\ArticleTag;
use App\Models\Blog\UserFavourite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\In;


class MainController extends Controller
{
    public function index(){
        return view('home.main.components.main');
    }
    //个人信息
   public function main($name,Request $request){
        $email = base64_decode($name);
        $info = User::query()->select('name','email','avatar','introduce')->where('email',$email)->first();
        $info['favourite'] = UserFavourite::query()->select('id')->where('user_id',Auth::user()->id);
       //return $info;
        return view('home.main.components.main')->with('info',$info);
   }
    //我的博客
   public function Articleconsole(Request $request){
       $user_id = Auth::guard('web')->id();
       $data = Article::with('category:id,cate_name')
           ->select('cate_id', 'slug', 'title', 'read_count', 'created_at', 'is_top', 'description')
           ->where('user_id',$user_id)
           ->orderByDesc('is_top')->orderByDesc('created_at');
       if (isset($request->id)) {
           $data = $data->where('id', '=', $request->id);
       }
       if (isset($request->name)) {
           $data = $data->where('name', 'like', '%' . $request->name . '%');
       }
       if (isset($request->start_at) && isset($request->end_at)) {
           $data = $data->whereBetween('created_at', [$request->start_at, $request->end_at]);
       }
       $data = $data->paginate('20')->toArray();
       return view('home.main.components.console',$data);
   }
    //添加收藏
    public function favourite($id){
        $favourite = new UserFavourite();
       $favourite->user_id = Auth::user()->id;
       $favourite->article_id = $id;
       $flag = UserFavourite::where('user_id',Auth::user()->id)->where('article_id',$id)->get();
       if ($flag->count() <= 0){
           if ($favourite->save()){
               return 1;
           };
       };
       return 0;
   }

   public function focus(){
        return view('home.main.components.focus');
   }

   public function favourites(){
        $user_id = Auth::guard('web')->id();
        $data = DB::table('blog_favourite as a')
            ->join('blog_articles as b','a.article_id','b.id')
            ->where('a.user_id',$user_id)
            ->get();
       $result = json_decode($data, true);
       return view('home.main.components.favourites')->with('data',$result);
   }

    public function modify(){
        $upload = new RegisterController();
        $src = Auth::user()->avatar;
        $path = substr($src,15);
        if(Storage::disk('avatar')->delete($path) or !Storage::disk('avatar')->exists($path)){
            $path = $upload->uploadFile(Input::file('img'));
            if ($path){
                User::query()->where('email',Auth::user()->email)->update(['avatar'=>$path]);
                return ['code'=>0,'data'=>'修改成功','path'=>$path];
            }
        }
        return ['code'=>1,'data'=>'修改失败'];
    }


    public function resetPassword()
    {
        $pass = Input::post('password');
        if (Auth::check()){
            if (!is_null($pass));{
                User::query()->where('email',Auth::user()->email)->update(['password'=>Hash::make($pass)]);
                return ['data'=>'密码修改成功','code'=>0];
            }
        }


    }
}
