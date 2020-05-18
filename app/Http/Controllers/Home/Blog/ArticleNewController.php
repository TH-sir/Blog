<?php

namespace App\Http\Controllers\Home\Blog;

use App\Models\Blog\Article;
use App\Models\Blog\ArticleTag;
use App\Models\Blog\Category;
use App\Models\Blog\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ArticleNewController extends Controller
{

    public function new(Request $request)
    {
        $categories = Category::all()->toArray();
        $data = $request->input();
        $data['categories'] = $categories;
        return view('home.blog.article.article_new',$data);
    }

    public function store(Request $request)
    {
        //dd(json_encode('哈哈',JSON_UNESCAPED_UNICODE));
        $input = $request->input();
        $message = [
            'title.required' => '标题不能为空',
            'description.required' => '描述不能为空',
            'slug.required' => 'Slug不能为空',
            'slug.unqiue:blog_articles' => 'Slug已存在',
            'tags.required' =>'标签不能为空',
            'keywords.required' => '关键字不能为空',
            'tags,required' => '分类不能为空',

        ];
        $this->validate($request, [
            'title' => 'required|max:150',
            'slug' => 'required|max:255|unique:blog_articles',
            'description' => 'required|max:150',
            'keywords' => 'required|max:50',
            'markdown' => 'required',
            'tags' => 'required|max:100',
        ],$message);

        $input['cate_id'] = isset($input['cate_id']) ? $input['cate_id'] : false;

        if(!$input['new_category'] and !$input['cate_id']) {
            return redirect()->route('admin.blog.article.new')->withInput()->withErrors([
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
        $res = $article->checkStore($input);

        if ($res) {
            foreach ($tagIds as $tagId) {
                ArticleTag::firstOrCreate(['article_id' => $article->id, 'tag_id' => $tagId]);
            }
            if ($input['hidden'] === 'Home'){
                return redirect()->route('index');
            }
            return redirect()->route('index');
        }

        return redirect()->route('home.blog.article.new')->withInput();
    }
}
