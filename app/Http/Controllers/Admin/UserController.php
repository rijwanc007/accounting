<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Http\Controllers\Controller;
use App\SisterConcern;
use App\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('remember_token','=',null)->orderBy('id','DESC')->paginate(20);
        return view('user.index',compact('users'));
    }

    public function create()
    {
        $sister_concerns = SisterConcern::where('status','=','Active')->orderBy('id','DESC')->get();
        return view('user.create', compact('sister_concerns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'unique:users',
            'password' => 'required|confirmed|',
        ]);
        $image = $request->file('image');
        $image_name = rand().'.'.$image->getClientOriginalExtension();
        $image->move(public_path().'/assets/images/user/',$image_name);
        User::create([
            'sister_concern_id' => $request->sister_concern_id,
            'name' => $request->name,
            'image'=>$image_name,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'email'=>$request->email,
            'password' => bcrypt($request->password)
        ]);
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Created User',
        ]);
        Session::flash('success','User Created Successfully');
        return redirect()->route('user.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = User::find($id);
        $sister_concerns = SisterConcern::where('status','=','Active')->orderBy('id','DESC')->get();
        return view('user.edit',compact('edit', 'sister_concerns'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'unique:users,email,'.$id,
            'password' => 'confirmed'
        ]);
        $update = User::find($id);
        if(!empty($request->file('image'))){
            $image = $request->file('image');
            $image_name = rand().'.'.$image->getClientOriginalExtension();
            $image->move(public_path().'/assets/images/user/',$image_name);
        }else{
            $image_name = $update->image;
        }
        if(!empty($request->password)){
            $password = bcrypt($request->password);
        }else{
            $password = $update->password;
        }
        $update->update([
            'sister_concern_id' => $request->sister_concern_id,
            'name' => $request->name,
            'image'=>$image_name,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'email'=>$request->email,
            'password' => $password
        ]);
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Updated User',
        ]);
        Session::flash('success','User Updated Successfully');
        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        $delete = User::find($id);
        if(!empty($delete->image)){
            unlink('assets/images/user/'.$delete->image);
        }
        $delete->delete();
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Deleted User',
        ]);
        Session::flash('success','User Deleted Successfully');
        return redirect()->route('user.index');
    }

    public function search(Request $request){
        $input = $request->item;
        $users = User::where('name', 'like', "%$input%")
            ->orWhere('email', 'like', "%$input%")
            ->orWhere('phone', 'like', "%$input%")
            ->orWhere('address', 'like', "%$input%")
            ->where('remember_token','=',null)
            ->orderBy('id', 'DESC')->paginate(20);
        return view('user.index',compact('users'));

    }
}
