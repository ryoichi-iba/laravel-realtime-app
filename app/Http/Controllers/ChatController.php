<?php

namespace App\Http\Controllers;

use App\Events\GreetingSent;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\User;

class ChatController extends Controller
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
    public function showChat()
    {
        return view('chat.show');
    }

    public function messageReceived(Request $request)
    {
        $rules = [
            'message' => 'required'
        ];

        $request->validate($rules);

        broadcast(new MessageSent($request->user(), $request->message));

        return response()->json('Message broadcast');
    }

    public function greetReceived(Request $request, User $user)
    {
        //reveiver
        //GreetingSent(User $user,$message)
        //$userのidでprivateChannelを作成 (chat.greet.$id)

        //$userはgreetを押されたユーザー (パラメータでモデルバインディング) 
        //$requets->user()はgreetを押したユーザー 

        broadcast(new GreetingSent($user, "{$request->user()->name} greet you"));
        //sender
        
        broadcast(new GreetingSent($request->user(), "You greet {$user->name}"));

        return    ":Greeting {$user->name} from  {$request} ";
    }
}
