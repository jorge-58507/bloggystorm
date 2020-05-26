<?php

namespace App\Http\Controllers;

use App\bs_post;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $model_post = new bs_post;
        $user = $request->user();
        $today = date('Y-m-d');
        $qry_post_published = $model_post->where('bs_posts.post_ai_user_id',$user['id'])->where('bs_posts.tx_post_date',"<=",$today)
        ->select('bs_posts.ai_post_id','bs_posts.tx_post_title','bs_posts.tx_post_content','bs_posts.tx_post_date');
        $rs_post_published = $qry_post_published->get();
        $qry_post_notpublished = $model_post->where('bs_posts.post_ai_user_id',$user['id'])->where('bs_posts.tx_post_date',">",$today)
        ->select('bs_posts.ai_post_id','bs_posts.tx_post_title','bs_posts.tx_post_content','bs_posts.tx_post_date');
        $rs_post_notpublished = $qry_post_notpublished->get();
        $compacted_data = ['post_published'=>$rs_post_published,'post_notpublished'=>$rs_post_notpublished];
        return view('home', compact('compacted_data'));
    }
}
