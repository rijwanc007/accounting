<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Message;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;


class UserController extends Controller
{
    public function index()
    {
        $users = User::where('status','=','show')->orderBy('id','DESC')->paginate(20);
        return view('admin.user.user_index',compact('users'));
    }
    public function userSearch(Request $request){
        $users = User::where('name','like','%'.$request->search.'%')->where('status','=','show')->orWhere('email','like','%'.$request->search.'%')->where('status','=','show')->orWhere('position','like','%'.$request->search.'%')->where('status','=','show')->orWhere('created_at','like','%'.$request->search.'%')->where('status','=','show')->orWhere('created_person','like','%'.$request->search.'%')->where('status','=','show')->paginate(20);
        return view('admin.user.user_index',compact('users'));
    }
    public function create()
    {
       return view('admin.user.user_create');
    }
    public function store(Request $request)
    {
        $nid_check = User::where('nid','=',$request->nid)->first();
        $phone_check = User::where('phone','=',$request->phone)->first();
        if(!empty($nid_check)){
            $request->validate([
               'nid' => 'unique:users',
            ]);
        }
        if (!empty($phone_check)){
            $request->validate([
               'phone' => 'unique:users',
            ]);
        }
        $request->validate([
           'email' => 'unique:users',
           'nid' => 'required|min:13|max:13',
           'phone' => 'required|:min:11|max:11',
        ]);
        $image = $request->file('image');
        $image_name = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path().'/assets/images/user',$image_name);
        $user_create = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name.' '.$request->last_name,
            'image' => $image_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'nid' => $request->nid,
            'position' => $request->position,
            'about' => $request->about,
            'created_person' => Auth::user()->name,
            'status' => 'show',
            'password' => bcrypt($request->password),
        ]);
        Session::flash('success','User Created Successfully');
        return redirect('user');
    }
    public function show($id)
    {
        $show = User::find($id);
        return view('admin.user.user_show',compact('show'));
    }
    public function edit($id)
    {
        $edit = User::find($id);
        return view('admin.user.user_edit',compact('edit'));
    }
    public function update(Request $request, $id)
    {
        $user_update = User::find($id);
        $user_image = User::find($id);
        $nid_check = User::where('id','!=',$id)->where('nid','=',$request->nid)->first();
        $phone_check = User::where('id','!=',$id)->where('phone','=',$request->phone)->first();
        $email_check = User::where('id','!=',$id)->where('email','=',$request->email)->first();
        $message_check = Message::where('sender_id','=',$id);
        if(!empty($nid_check)){
            $request->validate([
                'nid' => 'unique:users',
            ]);
        }
        if (!empty($phone_check)){
            $request->validate([
                'phone' => 'unique:users',
            ]);
        }
        if(!empty($email_check)){
            $request->validate([
               'email' => 'unique:users',
            ]);
        }
        if(!empty($request->password)){
            $user_password_update = User::find($id);
            $user_password_update->update([
               'password' => bcrypt($request->password)
            ]);
        }
        $image = $request->file('image');
        if(!empty($image)){
        unlink('assets/images/user/'.$user_image->image);
        $image_name = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path().'/assets/images/user',$image_name);
        $user_update->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name.' '.$request->last_name,
            'image' => $image_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'nid' => $request->nid,
            'position' => $request->position,
            'about' => $request->about,
            'created_person' => Auth::user()->name,
            'status' => 'show',
        ]);
        if(!empty($message_check)){
        $message_update = Message::where('sender_id','=',$id);
        $message_update->update([
           'sender_image' => $image_name
        ]);
        }
        }else{
        $user_update->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'nid' => $request->nid,
            'position' => $request->position,
            'about' => $request->about,
            'created_person' => Auth::user()->name,
            'status' => 'show',
        ]);
        }
        Session::flash('success','User Updated Successfully');
        return redirect('user');
    }
    public function destroy($id)
    {
        $message = Message::where('receiver_id','=',$id);
        $user = User::find($id);
        if(!empty($message)){
            $message->delete();
        }
        $user->delete();
        unlink('assets/images/user/'.$user->image);
        Session::flash('success','User Deleted Successfully');
        return redirect('user');
    }
}
