<?php
  
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
  
class FacebookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
           
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        try {
        
            $user = Socialite::driver('facebook')->user();
            $facebook_token = $user->token;
         
            $finduser = User::where('facebook_id', $user->id)->first();
         
            if($finduser){
         
                Auth::login($finduser);


                $client = new \GuzzleHttp\Client();
                $page_url = "https://graph.facebook.com/v18.0/".$user->id."/accounts?access_token=".$facebook_token;

                $response = $client->get($page_url);
                $body = $response->getBody();
                $datas = json_decode($body);
                
                foreach ($datas->data as $data) {
                    Page::updateOrCreate(['page_id' => $data->id],
                        [
                        'user_id' => $finduser->id,
                        'page_id'=> $data->id,
                        'page_name'=> $data->name,
                        'page_access_token' =>$data->access_token
                    ]);

                    $post_url = "https://graph.facebook.com/v18.0/".$data->id."/feed?limit=100&access_token=".$data->access_token;
                    $res = $client->get($post_url);
                    $resBody = $res->getBody();
                    $posts = json_decode($resBody);

                    foreach ($posts->data as $post) {
                        $comment_url = "https://graph.facebook.com/v18.0/".$post->id."/?access_token=".$data->access_token."&fields=comments.limit(100).summary(true)";
                        $like_url = "https://graph.facebook.com/v18.0/".$post->id."/?access_token=".$data->access_token."&fields=likes.limit(100).summary(true)";
                        $resComment = $client->get($comment_url);
                        $commentBody = $resComment->getBody();
                        $comments = json_decode($commentBody);

                        $resLike = $client->get($like_url);
                        $likeBody = $resLike->getBody();
                        $likes = json_decode($likeBody);

                        Post::updateOrCreate(['post_id' => $post->id],
                            [
                            'user_id' => $finduser->id,
                            'page_id'=> $data->id,
                            'post_id'=> $post->id,
                            'message'=> optional($post)->message ?? optional($post)->story,
                            'comments'=> $comments->comments->summary->total_count,
                            'likes'=> $likes->likes->summary->total_count,
                            'created_time' => Carbon::parse($post->created_time)->format('Y-m-d H:i:s')
                        ]);
                    }
                }

                $pages = Page::where('user_id', $finduser->id)->get();
                
                return view('dashboard', compact('pages'));
         
            }else{

                $newUser = User::updateOrCreate(['email' => $user->email],[
                        'name' => $user->name,
                        'facebook_id'=> $user->id,
                        'facebook_token'=> $user->token,
                        'password' => encrypt('123456dummy')
                    ]);
        
                Auth::login($newUser);

                $client = new \GuzzleHttp\Client();
                $page_url = "https://graph.facebook.com/v18.0/".$user->id."/accounts?access_token=".$facebook_token;

                $response = $client->get($page_url);
                $body = $response->getBody();
                $datas = json_decode($body);
                
                foreach ($datas->data as $data) {
                    Page::updateOrCreate(['page_id' => $data->id],
                        [
                        'user_id' => $newUser->id,
                        'page_id'=> $data->id,
                        'page_name'=> $data->name,
                        'page_access_token' =>$data->access_token
                    ]);

                    $post_url = "https://graph.facebook.com/v18.0/".$data->id."/feed?limit=100&access_token=".$data->access_token;
                    $res = $client->get($post_url);
                    $resBody = $res->getBody();
                    $posts = json_decode($resBody);

                    foreach ($posts->data as $post) {
                        $comment_url = "https://graph.facebook.com/v18.0/".$post->id."/?access_token=".$data->access_token."&fields=comments.limit(100).summary(true)";
                        $like_url = "https://graph.facebook.com/v18.0/".$post->id."/?access_token=".$data->access_token."&fields=likes.limit(100).summary(true)";
                        $resComment = $client->get($comment_url);
                        $commentBody = $resComment->getBody();
                        $comments = json_decode($commentBody);

                        $resLike = $client->get($like_url);
                        $likeBody = $resLike->getBody();
                        $likes = json_decode($likeBody);


                        Post::updateOrCreate(['post_id' => $post->id],
                            [
                            'user_id' => $newUser->id,
                            'page_id'=> $data->id,
                            'post_id'=> $post->id,
                            'message'=> optional($post)->message ?? optional($post)->story,
                            'comments'=> $comments->comments->summary->total_count,
                            'likes'=> $likes->likes->summary->total_count,
                            'created_time' => Carbon::parse($post->created_time)->format('Y-m-d H:i:s')
                        ]);
                    }
                }
        
                return redirect()->intended('dashboard');
            }
       
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}