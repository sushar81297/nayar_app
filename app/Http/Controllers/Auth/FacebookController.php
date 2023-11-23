<?php
  
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use App\Helper\Helper;
  
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
                Helper::setupData($user->id, $user->token, $finduser->id);

                $pages = Page::where('user_id', $finduser->id)->get();

                Auth::login($finduser);
                
                return view('home', compact('pages'));
         
            }else{

                $newUser = User::updateOrCreate(['email' => $user->email],[
                        'name' => $user->name,
                        'facebook_id'=> $user->id,
                        'facebook_token'=> $user->token,
                        'password' => encrypt('123456dummy')
                    ]);
                
                Helper::setupData($user->id, $user->token, $newUser->id);

                Auth::login($newUser);

                return view('home', compact('pages'));
            }
       
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}