<?php

namespace App\Http\Controllers;

use App\Events\GotMessage;
use App\Jobs\SendMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function index()
    {
        $users = User::select([
            'id', 'name', 'email',
        ])->get();

        return view('home', [
            'users' => $users,
        ]);
    }

    /* Show chat box view of specific user */
    public function userChat($id)
    {
        if (isset($id)) {
            $user = User::where('id', $id)->select([
                'id', 'name', 'email',
            ])->first();
        } else {
            $user = User::where('id', auth()->id())->select([
                'id', 'name', 'email',
            ])->first();
        }

        return view('user-chat', [
            'user' => $user,
        ]);
    }

    public function messages($id): JsonResponse
    {
        if (isset($_GET['isBroadcasting']) && $_GET['isBroadcasting'] != "null") {
            $messages = Message::where(function ($query) use ($id) {
                $query->where('user_id', auth()->user()->id)
                    ->orWhere('receiver_id', null);
            })
                ->with('user')
                ->get()
                ->append('time');
        } else {
            $messages = Message::where(function ($query) use ($id) {
                $query->where('user_id', $id)
                    ->where('receiver_id', auth()->user()->id);
            })
                ->orWhere(function ($query) use ($id) {
                    $query->where('user_id', auth()->user()->id)
                        ->where('receiver_id', $id);
                })
                ->with('user')
                ->get()
                ->append('time')
                ->sortBy('time')->values();
        }

        return response()->json($messages);
    }

    public function message(Request $request): JsonResponse
    {
        $message = Message::create([
            'user_id' => auth()->id(),
            'text' => $request->get('text'),
            'receiver_id' => (isset($request->is_broadcasting) && $request->is_broadcasting == true) ? null : $request->get('userId'),
        ]);

        // SendMessage::dispatch($message);

        GotMessage::dispatch([
            'id' => $message->id,
            'user_id' => $message->user_id,
            'receiver_id' => $message->receiver_id,
            'text' => $message->text,
            'time' => $message->time,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Message created and job dispatched.",
        ]);
    }

    public function broadcast()
    {
        $user = User::where('id', auth()->id())->select([
            'id', 'name', 'email',
        ])->first();

        return view('broadcast', [
            'user' => $user,
        ]);
    }
}
