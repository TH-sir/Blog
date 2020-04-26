<?php

namespace App\Http\Controllers\Home\Blog;

use App\Models\Auth\User;
use App\Models\Blog\Article;
use App\Models\Blog\ArticleTag;
use App\Models\Visitor\UserFavourite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use function MongoDB\BSON\toJSON;


class MainController extends Controller
{
   public function index($name,Request $request){
        $email = base64_decode($name);
        $info = User::query()->select('name','email')->where('email',$email)->first();
        $info['url'] = $request->route()->getName();
        return $info;
   }

   public function Articleconsole(Request $request){
       $user_id = Auth::guard('web')->id();
       $data = Article::with('category:id,cate_name')
           ->select('cate_id', 'slug', 'title', 'read_count', 'created_at', 'is_top', 'description')
           ->where('user_id',$user_id)
           ->orderByDesc('is_top')->orderByDesc('created_at');
       //dd($data);
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
       //return $data;
       return view('home.main.index',$data);
       dd($data);
   }

   public function favourite($id){
        $favourite = new UserFavourite();
        $favourite->user_id = Auth::user()->id;
        $favourite->article_id = $id;
        $favourite->save();

   }

}
