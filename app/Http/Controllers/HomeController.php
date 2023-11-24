<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Page;
use App\Models\Post;
use App\Models\Group;
use Hash;
  
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
        ->where('page_id', $page_id)->get();

        $page = Page::where('page_id', $page_id)->first();
        $page_name = $page->page_name;

        return view('posts.index', compact('posts', 'page_name', 'page_id'));
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

    public function store(Request $request)
    {
        $photo = new Blob($request->file('file'));
        dd($photo);
        $page = Page::where('page_id', $request->page_id)->first();

        $url = "https://graph.facebook.com/v18.0/".$request->page_id."/feed?access_token=".$page->page_access_token;
        $client = new \GuzzleHttp\Client();
        $params['headers'] = ['Content-Type' => 'application/x-www-form-urlencoded'];
        $params['form_params'] = array('message' => $request->message ?? '', 'source' => $request->file('files'));
        $response = $client->post($url, $params);
        $resBody = $response->getBody();
        $groups = json_decode($resBody);
    } 
      
}