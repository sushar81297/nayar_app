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
        $posts = Post::where('user_id', Auth::user()->id)
        ->where('page_id', $request->id)->get();

        $page = Page::where('page_id', $request->id)->first();
        $page_name = $page->page_name;

        return view('posts.index', compact('posts', 'page_name'));
    }  

    public function group()
    {
        $groups = Group::where('user_id', Auth::user()->id)->get();

        return view('group', compact('groups'));
    }  

    public function add(Request $request)
    {
        $post = null;
        return view('posts.create', compact('post'));
    }  

    public function store(Request $request)
    {
        foreach($request->file('files') as $key => $file) {
        }
    } 
      
}