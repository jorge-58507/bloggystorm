<?php

namespace App\Http\Controllers;

use App\bs_post;
use Illuminate\Http\Request;

class controller_post extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $model_post = new bs_post;
      $today = date("Y-m-d H:i:s");

      $qry_post = $model_post->where('bs_posts.tx_post_date',"<=",$today)
      ->select('bs_posts.ai_post_id','bs_posts.tx_post_title','bs_posts.tx_post_content','bs_posts.tx_post_date')->orderby('tx_post_date','DESC');
      $rs_post = $qry_post->get();
      $compacted_data = ['data'=>$rs_post];
      return view('welcome', compact('compacted_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $date = date("Y-m-d", strtotime($request->input('c'))).date(' H:i:s');
			$content = $request->input('b');
      $title = $request->input('a');

      $user = $request->user();
			$model_post = new bs_post;

			$check_post = $model_post->where('post_ai_user_id',$user['id'])->where('tx_post_title',$title);
			if ($check_post->count() > 0) {
        $message = 'This post has already been published';
        $status = 'failed';
			}else{
        $message = 'Published!';	
        $status = 'success';
				$model_post->post_ai_user_id = $user['id'];
				$model_post->tx_post_title = $title;
				$model_post->tx_post_content = $content;
				$model_post->tx_post_date = $date;
				$model_post->save();
			}

       // ANSWER
      $today = date("Y-m-d H:i:s");
			$qry_post_published = $model_post->where('bs_posts.post_ai_user_id',$user['id'])->where('bs_posts.tx_post_date',"<=",$today)
			->select('bs_posts.ai_post_id','bs_posts.tx_post_title','bs_posts.tx_post_content','bs_posts.tx_post_date');
      $rs_post_published = $qry_post_published->get();

			$qry_post_notpublished = $model_post->where('bs_posts.post_ai_user_id',$user['id'])->where('bs_posts.tx_post_date',">",$today)
			->select('bs_posts.ai_post_id','bs_posts.tx_post_title','bs_posts.tx_post_content','bs_posts.tx_post_date');
      $rs_post_notpublished = $qry_post_notpublished->get();

      return response()->json(['status'=>$status, 'message'=>$message,'data'=>['post_published'=>$rs_post_published,'post_notpublished'=>$rs_post_notpublished]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
      $model_post = new bs_post;
      $user = $request->user();
			$qry_post = $model_post->where('bs_posts.post_ai_user_id',$user['id'])->where('bs_posts.ai_post_id',$id)
			->select('bs_posts.ai_post_id','bs_posts.tx_post_title','bs_posts.tx_post_content','bs_posts.tx_post_date');
      $rs_post = $qry_post->get();
      if ($qry_post->count() < 1) {
        $message = 'Check what you see';  $status = 'failed';
        $authorized=0; 
      }else{
        $message = '';                    $status = 'success';
        if ( auth()->user()->checkRole('admin')){ 
          $authorized=1; 
        }else{ 
          $authorized=0; 
        }        
      }
      return response()->json(['status'=>$status, 'message'=>$message,'data'=>['post'=>$rs_post,'authorized'=>$authorized]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
      $model_post = new bs_post;
			$qry_post = $model_post->where('bs_posts.ai_post_id',$id)
			->select('bs_posts.ai_post_id','bs_posts.tx_post_title','bs_posts.tx_post_content','bs_posts.tx_post_date');
      $rs_post = $qry_post->get();
      if ($qry_post->count() < 1) {
        $message = 'Check what you see';  $status = 'failed';
        $authorized=0; 
      }else{
        $message = '';                    $status = 'success';
      }
      return response()->json(['status'=>$status, 'message'=>$message,'data'=>['post'=>$rs_post]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
      $model_post = new bs_post;
      $user = $request->user();
      $model_post->where('ai_post_id', $id)->delete();

       // ANSWER
      $today = date("Y-m-d H:i:s");
			$qry_post_published = $model_post->where('bs_posts.post_ai_user_id',$user['id'])->where('bs_posts.tx_post_date',"<=",$today)
			->select('bs_posts.ai_post_id','bs_posts.tx_post_title','bs_posts.tx_post_content','bs_posts.tx_post_date');
      $rs_post_published = $qry_post_published->get();

			$qry_post_notpublished = $model_post->where('bs_posts.post_ai_user_id',$user['id'])->where('bs_posts.tx_post_date',">",$today)
			->select('bs_posts.ai_post_id','bs_posts.tx_post_title','bs_posts.tx_post_content','bs_posts.tx_post_date');
      $rs_post_notpublished = $qry_post_notpublished->get();

      return response()->json(['status'=>'success', 'message'=>'Succesfully Deleted','data'=>['post_published'=>$rs_post_published,'post_notpublished'=>$rs_post_notpublished]]);
    }
    public function get_api(Request $request){
      $raw_data = json_decode( file_get_contents('https://sq1-api-test.herokuapp.com/posts'), true );

      foreach ($raw_data['data'] as $key => $data) {
        $model_post = new bs_post;
        $user = $request->user();
        $title = $data['title'];
        $content = $data['description'];
        $date = $data['publication_date'];
        $model_post->post_ai_user_id = 2;
				$model_post->tx_post_title = $title;
				$model_post->tx_post_content = $content;
				$model_post->tx_post_date = $date;
				$model_post->save();
      }
       // ANSWER
      $today = date("Y-m-d H:i:s");
			$qry_post_published = $model_post->where('bs_posts.post_ai_user_id',$user['id'])->where('bs_posts.tx_post_date',"<=",$today)
			->select('bs_posts.ai_post_id','bs_posts.tx_post_title','bs_posts.tx_post_content','bs_posts.tx_post_date');
      $rs_post_published = $qry_post_published->get();

			$qry_post_notpublished = $model_post->where('bs_posts.post_ai_user_id',$user['id'])->where('bs_posts.tx_post_date',">",$today)
			->select('bs_posts.ai_post_id','bs_posts.tx_post_title','bs_posts.tx_post_content','bs_posts.tx_post_date');
      $rs_post_notpublished = $qry_post_notpublished->get();

      return response()->json(['status'=>'success', 'message'=>'Posts Obtained','data'=>['post_published'=>$rs_post_published,'post_notpublished'=>$rs_post_notpublished]]);
    }
    public function sync($sort){
      $model_post = new bs_post;
      $today = date("Y-m-d H:i:s");

      $qry_post = $model_post->where('bs_posts.tx_post_date',"<=",$today)
      ->select('bs_posts.ai_post_id','bs_posts.tx_post_title','bs_posts.tx_post_content','bs_posts.tx_post_date')->orderby('tx_post_date',$sort)->limit(25);
      $rs_post = $qry_post->get();
      return response()->json(['status'=>'success', 'message'=>'Synchronized','data'=>$rs_post]);
    }
}
