<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;
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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $comments = Comment::get();
        return view('home', ['comments' => $comments]);
    }
    
    public function add(Request $request)
{
    $user = Auth::user();
    $comment = $request->input('comment');
    Comment::create([
        'login_id' => $user->id,
        'name' => $user->name,
        'comment' => $comment
    ]);
    return redirect()->route('home');
}
    public function getData()
{
    $comments = Comment::orderBy('created_at', 'desc')->get();
    $json = ["comments" => $comments];
    return response()->json($json);
}
}