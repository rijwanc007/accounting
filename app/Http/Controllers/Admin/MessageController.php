<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Message;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::orderBy('id','DESC')->paginate(20);
        return view('admin.message.message_index',compact('messages'));
    }
    public function messageSearch(Request $request){
        $messages = Message::where('receiver_name','like','%'.$request->search.'%')->orWhere('receiver_email','like','%'.$request->search.'%')->orWhere('message','like','%'.$request->search.'%')->orWhere('sender_name','like','%'.$request->search.'%')->orWhere('sender_email','like','%'.$request->search.'%')->paginate(20);
        return view('admin.message.message_index',compact('messages'));
    }
    public function create()
    {
        $users = User::where('status','=','show')->orderBy('id','DESC')->get();
        return view('admin.message.multi_user_message',compact('users'));
    }
    public function store(Request $request)
    {
        Message::create([
           'receiver_id' => $request->receiver_id,
           'receiver_name' => $request->receiver_name,
           'receiver_email' => $request->receiver_email,
           'message' => $request->message,
           'sender_id' => $request->sender_id,
           'sender_image' => $request->sender_image,
           'sender_name' => $request->sender_name,
           'sender_email' => $request->sender_email,
        ]);
        Session::flash('success','Your Message Has Send Successfully');
        return redirect()->back();
    }
    public function show($id)
    {
        $show = Message::find($id);
        return view('admin.message.message_show',compact('show'));
    }
    public function messageDetails($id){
        $details = Message::find($id);
        return view('admin.message.message_details',compact('details'));
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        $delete = Message::find($id);
        $delete->delete();
        Session::flash('success','Message Are Deleted Successfully');
        return redirect('message');
    }
    public function multiUserMessageStore(Request $request){
        if($request->receiver_id == null){
            Session::flash('error','No User Selected');
            return redirect()->back();
        }else{
          for($i = 0 ;$i < count($request->receiver_id) ;$i++){
              $user_find = User::find($request->receiver_id[$i]);
              Message::create([
                  'receiver_id' => $request->receiver_id[$i],
                  'receiver_name' => $user_find->name,
                  'receiver_email' => $user_find->email,
                  'message' => $request->message,
                  'sender_id' => $request->sender_id,
                  'sender_image' => $request->sender_image,
                  'sender_name' => $request->sender_name,
                  'sender_email' => $request->sender_email,
              ]);
          }
          Session::flash('success','Your Message Send Successfully To The All User');
          return redirect()->back();
        }
    }
}
