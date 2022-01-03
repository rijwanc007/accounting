<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Http\Controllers\Controller;
use App\SisterConcern;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SisterConcernController extends Controller
{

    public function index()
    {
        $concerns = SisterConcern::orderBy('id', 'DESC')->paginate(10);
        return view('sister_concern.index', compact('concerns'));
    }

    public function create()
    {
        return view('sister_concern.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'unique:sisterconcerns'
        ]);
        SisterConcern::create([
            'name'=>$request->name,
            'status'=>$request->status,
        ]);
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Created Sister Concern',
        ]);
        Session::flash('success','New Sister Concern Created Successfully');
        return redirect()->route('sister_concern.index');
    }

    public function show($id)
    {
        $sister_concern = Sisterconcern::find($id)->name;
        return view('sister_concern.show',compact('sister_concern'));
    }


    public function edit($id)
    {
        $edit = Sisterconcern::find($id);
        return view('sister_concern.edit',compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'unique:sisterconcerns,name,' . $id,
        ]);
        $update = Sisterconcern::find($id);
        $update->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Updated Sister Concern',
        ]);
        Session::flash('success','Update Sister Concern Name Successfully');
        return redirect()->route('sister_concern.index');
    }

    public function destroy($id)
    {
        $delete = Sisterconcern::find($id);
        $delete->delete();
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Deleted Sister Concern',
        ]);
        Session::flash('success','Sister Concern Deleted Successfully');
        return redirect()->route('sister_concern.index');
    }
    public function search(Request $request){
        $concerns = SisterConcern::where('name','like','%'.$request->search.'%')
            ->orWhere('status','like','%'.$request->search.'%')
            ->orderBy('id','DESC')->paginate(20);
        return view('sister_concern.index',compact('concerns'));
    }
}
