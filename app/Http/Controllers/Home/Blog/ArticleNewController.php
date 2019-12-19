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

}
