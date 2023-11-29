<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;
use App\Models\Post;
use App\Models\Group;
use Carbon\Carbon;
  
class HomeController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        if(Auth::check()){
            $pages = Page::where('user_id', Auth::user()->id)->get();

            return view('home', compact('pages'));
        }
  
        return redirect("login")->withSuccess('Opps! You do not have access');
    }  

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function post(Request $request)
    {
        $page_id = $request->id;
        $posts = Post::where('user_id', Auth::user()->id)
        ->where('page_id', $page_id)->orderBy('created_time', 'desc')->get();

        $page = Page::where('page_id', $page_id)->first();
        $page_name = $page->page_name;

        return view('posts.index', compact('posts', 'page_name', 'page_id'));
    }  

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postList()
    {
        $posts = Post::orderBy('created_time', 'desc')->get();

        return view('posts.list', compact('posts'));
    }  

    public function group()
    {
        $groups = Group::where('user_id', Auth::user()->id)->get();

        return view('group', compact('groups'));
    }  

    public function add()
    {
        $pages = Page::where('user_id', Auth::user()->id)->get();
        return view('posts.create', compact('pages'));
    }  

    public function delete($id)
    {
        $post = Post::where('user_id', Auth::user()->id)
        ->where('post_id', $id)->first();
        
        $page = Page::where('page_id', $post->page_id)->first();

        $url = "https://graph.facebook.com/v18.0/".$id."?access_token=".$page->page_access_token;
        $client = new \GuzzleHttp\Client();
        $client->delete($url);
        $post = Post::where('post_id', $id);
        $post->delete();

        return redirect('page_post/'.$page->page_id);

    }


    public function store(Request $request)
    {
        $page = Page::where('page_id', $request->page_id)->first();

        if ($request->file('file')) {
            $url = "https://graph.facebook.com/v18.0/me/photos?access_token=EABax6Tm1ZApcBOZBLdPgMMF1lZAANApYZAA1P5auMsDkNCSiHZAEFo1t2ZBPrepIdbl4UBLLZCKSTe3NKxRCPAXv6miqG295ZBGJWEunMwca68Oabi94wQfvwAJhZCrnUGGk2l8sDCoCZB2tKC6jLT93hCX9ptBpZCksMxfLLywgAc7rZCtX95uADPThj6eVZAx9mGtIZD&message";

            $message = $request->message;
            $filePath = $request->file('file');
    
            $command = "curl -X POST -H 'Content-Type: multipart/form-data' -F 'message={$message}' -F 'file=@{$filePath}' {$url}";
            $response = shell_exec($command);
            $data = json_decode($response);
        } else {
            $url = "https://graph.facebook.com/v18.0/".$request->page_id."/feed?access_token=EABax6Tm1ZApcBOZBLdPgMMF1lZAANApYZAA1P5auMsDkNCSiHZAEFo1t2ZBPrepIdbl4UBLLZCKSTe3NKxRCPAXv6miqG295ZBGJWEunMwca68Oabi94wQfvwAJhZCrnUGGk2l8sDCoCZB2tKC6jLT93hCX9ptBpZCksMxfLLywgAc7rZCtX95uADPThj6eVZAx9mGtIZD&message";

            $message = $request->message;
    
            $command = "curl -X POST -H 'Content-Type: multipart/form-data' -F 'message={$message}' {$url}";
            $response = shell_exec($command);
            $data = json_decode($response);
        }
        $data_id = $data->id;
        if ($data && isset($data->post_id)) $data_id = $data->post_id;
        $client = new \GuzzleHttp\Client();
        $post_url = "https://graph.facebook.com/v18.0/".$data_id."?fields=attachments,story,message,created_time,comments.limit(100).summary(true),reactions.limit(100).summary(true)&access_token=".$page->page_access_token;
        $res = $client->get($post_url);
        $resBody = $res->getBody();
        $post_data = json_decode($resBody);

        $image = null;
        $images = null;
        if ($post_data && isset($post_data->attachments)) {
            if (isset($post_data->attachments->data[0]) && isset($post_data->attachments->data[0]->media->image->src)) {
                $image = $post_data->attachments->data[0]->media->image->src;
            }
            if (isset($post_data->attachments->data[0]) && isset($post_data->attachments->data[0]->subattachments)) {
                $images = [];
                $imageArr = $post_data->attachments->data[0]->subattachments;
                foreach ($imageArr->data as $i) {
                    if (isset($i->media->image->src)) {
                        $images[] = $i->media->image->src;
                    }
                }
            }
        }
        
        Post::updateOrCreate(['post_id' => $post_data->id],
            [
            'user_id' => $page->user_id,
            'page_id'=> $page->page_id,
            'post_id'=> $post_data->id,
            'message'=> optional($post_data)->message ?? optional($post_data)->story,
            'comments'=> $post_data->comments->summary->total_count,
            'likes'=> $post_data->reactions->summary->total_count,
            'image'=> $image,
            'images'=> $images,
            'created_time' => Carbon::parse($post_data->created_time)->format('Y-m-d H:i:s')
        ]);


        return redirect('page_post/'.$page->page_id);

    } 
      
}