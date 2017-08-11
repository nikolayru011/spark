<?php

namespace App\Http\Controllers;

use App\Channels;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

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

        // $this->middleware('subscribed');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show()
    {
       $user_id = Auth::user()->id;
        if(Auth::user()->provider == 'slack' && Auth::user()->provider_id != ''){
            $userChannels = User::with('channels')->get();
            $channelUser = $userChannels[0]['relations']['channels']->channels;
            $channels_object = json_decode($channelUser);
            $channels = $channels_object->channels;

            $slackUsers = User::select('id','name','email','photo_url')->where([
                ['provider', '=', 'slack'],
                ['id', '<>',$user_id]
            ])->get();
            $slackUserCount = count($slackUsers);
            return view('home',compact('slackUsers'),compact('slackUserCount'))->with('channels',$channels);
        }else{
            return view('home');
        }
    }

    public function deleteUser(Request $request)
    {
        $user_id = $request->id;
        User::find($user_id)->delete();
        Channels::where('user_id',$user_id)->delete();
        return response()->json([
            'error' => true
        ]);
    }
}
