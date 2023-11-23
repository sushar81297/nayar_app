<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Page;
use App\Models\Post;
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

            return view('dashboard', compact('pages'));
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

        return view('post', compact('posts', 'page_name'));
    }  
      
}