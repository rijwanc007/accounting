<?php

namespace App\Http\Controllers\Admin;


use App\Admin\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainHeadController extends Controller
{
    public function index()
    {
        return view('admin.main_head.main_head_index');
    }
    public function create()
    {
        $accounts = Account::where('status','=','Yes')->orderBy('id','DESC')->get();
        return view('admin.main_head.main_head_create',compact('accounts'));
    }
    public function store(Request $request)
    {
        //
    }
    public function show($id)
    {
        //
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
        //
    }
    public function accountCodeSerial(Request $request){

    }
}
