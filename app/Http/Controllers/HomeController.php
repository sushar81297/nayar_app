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

    public function add($id)
    {
        $page_id = $id;
        return view('posts.create', compact('page_id'));
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
        // $photo = new Blob($request->file('file'));
        $page = Page::where('page_id', $request->page_id)->first();

        if ($request->file('file')) {
            $url = "https://graph.facebook.com/v18.0/me/photos?access_token=".$page->page_access_token;
            $client = new \GuzzleHttp\Client();
            $params['headers'] = ['Content-Type' => 'application/x-www-form-urlencoded'];
            $params['form_params'] = array('message' => $request->message ?? '', 'source' => $request->file('files'));
            $response = $client->post($url, $params);
            $body = $response->getBody();
        } else {
            $url = "https://graph.facebook.com/v18.0/".$request->page_id."/feed?access_token=".$page->page_access_token;
            $client = new \GuzzleHttp\Client();
            $params['headers'] = ['Content-Type' => 'application/x-www-form-urlencoded'];
            $params['form_params'] = array('message' => $request->message ?? '', 'source' => $request->file('files'));
            $response = $client->post($url, $params);
            $body = $response->getBody();
        }

        $data = json_decode($body);

        $post_url = "https://graph.facebook.com/v18.0/".$data->id."?fields=attachments,story,message,created_time,comments.limit(100).summary(true),reactions.limit(100).summary(true)&access_token=".$page->page_access_token;
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