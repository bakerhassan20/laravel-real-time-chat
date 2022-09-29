<?php

namespace App\Http\Livewire;

use App\Models\Message;
use App\Models\GroubMessage;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class Chat extends Component
{

    public $messageText;
    public $user_id=1;

   // public $username;

   public function addTodo($id)
   {


   $this->user_id = $id;

   }

    public function render()
    {
        if($this->user_id == 100){
         $messages = GroubMessage::with('user')->latest()->take(100)->get()->sortBy('id');
        }
        else{
            $messages = Message::where([
                ['user_id_send',Auth::user()->id],
                ['user_id_receive',$this->user_id]
                               ])->orWhere([
                ['user_id_receive',Auth::user()->id],
                ['user_id_send',$this->user_id]
                             ])->get()->sortBy('id');

        }



    $users = User::all()->where('email','!=',Auth::user()->email);
    $user_info = User::where('id',$this->user_id)->first();
    return view('livewire.chat', compact('messages' ,'users','user_info'));
    }

    public function sendMessage()
    {
        Message::create([
            'user_id_send' => auth()->user()->id,
            'user_id_receive' => $this->user_id,
            'message_text' => $this->messageText,
        ]);

        $this->reset('messageText');
    }

    public function sendGroupMessage()
    {
        GroubMessage::create([
            'user_id' => auth()->user()->id,
            'message_text' => $this->messageText,
        ]);

        $this->reset('messageText');
    }

}
