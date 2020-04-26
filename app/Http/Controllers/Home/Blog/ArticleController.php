<?php

namespace App\Http\Controllers\Home\Blog;

use App\Models\Blog\Article;
use App\Models\Blog\ArticleTag;
use App\Models\Blog\Category;
use App\Models\Blog\Tag;
use App\Models\Visitor\visitorInfo;
use DOMDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ArticleController extends CommonController
{
    //
    public function index(Request $request)
    {
        $size = 20;
        $data = Article::with('category:id,cate_name')
            ->select('cate_id', 'slug', 'title', 'read_count', 'created_at', 'is_top', 'description')
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
        $data = $data->paginate($size)->toArray();
        $this->sidebar($data);
        // 记录来访IP，服务运行商，浏览器型号
        if (env('IP_LOG') === true){
            $this->visitorInfo();
        }


        return view('home.index', $data);
    }

    public function show($slug)
    {
        $article = Article::with('category:id,cate_name')
            ->select('blog_articles.id','blog_users.name','blog_users.email','blog_articles.cate_id', 'blog_articles.slug', 'blog_articles.title', 'blog_articles.read_count', 'blog_articles.created_at', 'blog_articles.is_top', 'blog_articles.description', 'blog_articles.markdown', 'blog_articles.keywords')
            ->where('slug', '=', $slug)
            ->leftJoin("blog_users","blog_articles.user_id","blog_users.id")
            ->first();
        //dd($article);
        if (!$article) {
            return view('errors.404');
        }

        $article->increment("read_count");

        $tags = ArticleTag::query()
            ->select('blog_tags.tag_name')
            ->where('article_id', '=', $article->id)
            ->leftJoin('blog_tags', 'blog_article_tags.tag_id', 'blog_tags.id')
            ->get();

        $article = $article->toArray();
//        $article['markdown'] = markdown($article['markdown']);
        $article['markdown'] = $this->lazyImageMarkdown(markdown($article['markdown']));

        $data['article']                 = $article;
        $data['article']['tags']         = $tags->toArray();
        $data['guess_you_like_articles'] = $this->guessYouLikeArticles($article['cate_id'], $slug);

        $this->sidebar($data);

        $keywords = '';

        foreach ($data['article']['tags'] as $i => $tag) {
            if ($i == 0) $keywords .= $tag['tag_name'];
            else $keywords .= ',' . $tag['tag_name'];
        }

        $data['meta']['title']       = $article['title'];
        $data['meta']['description'] = $article['description'];
        $data['meta']['keywords']    = $keywords;

        return view('home.blog.article.index', $data);
    }

    /* guess you like*/
    protected function guessYouLikeArticles($cate_id, $slug)
    {
        $articles = Article::query()
            ->select('slug', 'title', 'read_count', 'description')
            ->where('cate_id', '=', $cate_id)
            ->where('slug', '!=', $slug)
            ->inRandomOrder()
            ->limit(8)->get();

        return $this->parseToArray($articles);
    }

    protected function lazyImageMarkdown($markdown)
    {
        $dom = new DomDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">' . $markdown);

        $list = $dom->getElementsByTagName('img');
        foreach ($list as $i => $item) {
            if ($i == 0) continue;
            $attr_src = $item->getAttribute('src');
            $item->setAttribute("data-original", $attr_src);
            $item->setAttribute("src", "data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%201%201'%3E%3C/svg%3E");
//            $item->removeAttribute('src');
            $item->setAttribute('class', 'lazyload');
        }

        $html = $dom->saveHTML();
        return $html;
    }

    //获取用户信息
    public function visitorInfo()
    {
        $vistorInfo["ip"]       = $this->getIp();
        $vistorInfo["cityinfo"] = $this->findCityByIp($vistorInfo["ip"]);
        $vistorInfo["borwser"]  = $this->getBrowser();
        
        $visit     = new visitorInfo();
        $visit->ip = $vistorInfo["ip"];
        $visit->isp= $vistorInfo["cityinfo"]['data']['isp'];
        $visit->address = $vistorInfo["cityinfo"]['data']['country'] . $vistorInfo["cityinfo"]['data']['region'] . $vistorInfo["cityinfo"]['data']['city'];
        $visit->save();
        return $vistorInfo;
    }

    //获取访客ip
    public function getIp()

    {

        $ip = false;
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) {
                array_unshift($ips, $ip);
                $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++) {
                if (!eregi("^(10│172.16│192.168).", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }

    //根据ip获取城市、网络运营商等信息
    public function findCityByIp($ip)
    {
        //$data = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip,false, stream_context_create($opts));
        $cnt = 0;
        while ($cnt < 3 && ($data = @file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip)) === FALSE) $cnt++;
        return json_decode($data, $assoc = true);
    }

    //获取用户浏览器类型
    public function getBrowser()
    {
        $agent = $_SERVER["HTTP_USER_AGENT"];
        if (strpos($agent, 'MSIE') !== false || strpos($agent, 'rv:11.0')) //ie11判断
            return "ie";
        else if (strpos($agent, 'Firefox') !== false)
            return "Firefox";
        else if (strpos($agent, 'Chrome') !== false)
            return "Chrome";
        else if (strpos($agent, 'Opera') !== false)
            return 'Opera';
        else if ((strpos($agent, 'Chrome') == false) && strpos($agent, 'Safari') !== false)
            return 'Safari';
        else
            return 'Unknown';
    }


}
