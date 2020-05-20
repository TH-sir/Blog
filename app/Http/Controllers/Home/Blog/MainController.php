<?php

namespace App\Http\Controllers\Home\Blog;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Auth\User;
use App\Models\Blog\Article;
use App\Models\Blog\ArticleTag;
use App\Models\Blog\Category;
use App\Models\Blog\Tag;
use App\Models\Blog\UserFavourite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;


class MainController extends Controller
{
    public function index(){
        //return view('home.main.components.console');
    }
    //个人信息
   public function main($name,Request $request){
        $email = base64_decode($name);
        $info = User::query()->select('name','email','avatar','introduce')->where('email',$email)->first();
        $info['favourite'] = UserFavourite::query()->select('id')->where('user_id',Auth::user()->id);
        $info['blog'] = Article::query()->with('user_id',Auth::user()->id)->count();
       //return $info;
        return view('home.main.components.main')->with('info',$info);
   }
    //我的博客
   public function Articleconsole(Request $request){
       $user_id = Auth::guard('web')->id();
       $data = Article::with('category:id,cate_name')
           ->select('id','cate_id', 'slug', 'title', 'read_count', 'created_at', 'is_top', 'description')
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
            if ($path['code'] === 0){
                User::query()->where('email',Auth::user()->email)->update(['avatar'=>$path['path']]);
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

    public function delete($id)
    {
        if (Auth::check()){
            Article::destroy($id);
            return back();
        }
    }

    public function edit($id)
    {
        $article = Article::find($id);
        if (!$article) {
            abort(404);
        }
        $data['article'] = $article->toArray();

        $tagNames = ArticleTag::select('blog_tags.tag_name')->where('article_id', '=', $id)
            ->leftJoin('blog_tags', 'blog_article_tags.tag_id', 'blog_tags.id')->get();

        $data['article']['tags'] = '';
        foreach ($tagNames as $tagName) {
            if (!$data['article']['tags']) {
                $data['article']['tags'] = $tagName->tag_name;
            } else {
                $data['article']['tags'] = $data['article']['tags'] . ',' . $tagName->tag_name;
            }
        }

        $categories = Category::all()->toArray();
        $data['categories'] = $categories;

        return view('home.main.components.edit', $data);
    }

    public function update(Request $request)
    {
        $input = $request->input();
        $this->validate($request, [
            'id' => 'required',
            'title' => 'required|max:100',
            'slug' => 'required|max:255',
            'description' => 'required|max:150',
            'keywords' => 'required|max:50',
            'markdown' => 'required',
            'tags' => 'required|max:100',
        ]);

        $article = Article::select('id', 'slug')->where('slug', '=', $input['slug'])->first();
        if(isset($article->id) and $article->id != $input['id']) {
            return redirect()->route('admin.blog.article.edit', $input['id'])->withInput()->withErrors([
                "slug" => "slug 已存在！"
            ]);
        }

        $input['cate_id'] = isset($input['cate_id']) ? $input['cate_id'] : false;

        if(!$input['new_category'] and !$input['cate_id']) {
            return redirect()->route('admin.blog.article.edit', $input['id'])->withInput()->withErrors([
                'category' => '请选择分类或新建一个'
            ]);
        }

        if ($input['new_category']) {
            $category = Category::firstOrCreate(['cate_name' => $input['new_category']]);
            $input['cate_id'] = $category->id;
        }

        $tags = explode(",", $input['tags']);
        $tagIds = array();
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['tag_name' => trim($tagName)]);
            $tagIds[] = $tag->id;
        }

        $input['user_id'] = Auth::guard('admin')->id();

        $article = new Article();
        $res = $article->checkUpdate($input['id'], $input);

        if ($res) {
            foreach ($tagIds as $tagId) {
                ArticleTag::firstOrCreate(['article_id' => $input['id'], 'tag_id' => $tagId]);
            }
            return redirect()->route('home.main.article');
        }

        return redirect()->route('home.main.edit', $input['id'])->withInput();
    }

    public function cancel($article_id){
        if (Auth::check()){
           DB::table('blog_favourite')->where('id',Auth::user()->id)->where('article_id',$article_id)->delete();
           return back();
        }
    }

}
