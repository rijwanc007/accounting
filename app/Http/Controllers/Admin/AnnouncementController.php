<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('id','DESC')->paginate(20);
        return view('admin.announcement.announcement_index',compact('announcements'));
    }
    public function announcementSearch(Request $request){
        $announcements = Announcement::where('creator_name','like','%'.$request->search.'%')->orWhere('creator_email','like','%'.$request->search.'%')->orWhere('announcement_name','like','%'.$request->search.'%')->orWhere('announcement_description','like','%'.$request->search.'%')->paginate(20);
        return view('admin.announcement.announcement_index',compact('announcements'));
    }
    public function create()
    {
        return view('admin.announcement.announcement_create');
    }
    public function store(Request $request)
    {
        Announcement::create([
           'creator_name' => Auth::user()->name,
           'creator_email' => Auth::user()->email,
           'announcement_name' => $request->announcement_name,
           'announcement_description' => $request->announcement_description,
        ]);
        Session::flash('success','Announcement Created Successfully');
        return redirect('announcement');
    }
    public function show($id)
    {
       $show = Announcement::find($id);
       return view('admin.announcement.announcement_show',compact('show'));
    }
    public function edit($id)
    {
       $edit = Announcement::find($id);
       return view('admin.announcement.announcement_edit',compact('edit'));
    }
    public function update(Request $request, $id)
    {
       $update = Announcement::find($id);
       $update->update([
           'creator_name' => Auth::user()->name,
           'creator_email' => Auth::user()->email,
           'announcement_name' => $request->announcement_name,
           'announcement_description' => $request->announcement_description,
       ]);
        Session::flash('success','Announcement Updated Successfully');
        return redirect('announcement');
    }
    public function destroy($id)
    {
       $delete = Announcement::find($id);
       $delete->delete();
        Session::flash('success','Announcement Deleted Successfully');
        return redirect('announcement');
    }
}
