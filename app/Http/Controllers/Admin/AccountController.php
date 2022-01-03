<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::orderBy('id','DESC')->paginate(24);
        return view('admin.account.account_index',compact('accounts'));
    }
    public function accountSearch(Request $request){
        $accounts = Account::where('account_type','like','%'.$request->search.'%')->paginate(24);
        return view('admin.account.account_index',compact('accounts'));
    }
    public function create()
    {
        return view('admin.account.account_create');
    }
    public function store(Request $request)
    {
        $request->validate([
           'account_type' => 'unique:accounts'
        ]);
        Account::create([
           'account_type' => $request->account_type,
           'status' => $request->status,
        ]);
        Session::flash('success','Account Type Created Successfully');
        return redirect('account');
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $edit = Account::find($id);
        return view('admin.account.account_edit',compact('edit'));
    }
    public function update(Request $request, $id)
    {
        $account_check = Account::where('id','!=',$id)->where('account_type','=',$request->account_type)->first();
        if (!empty($account_check)){
            $request->validate([
               'account_type' => 'unique:accounts'
            ]);
        }
        $update = Account::find($id);
        $update->update([
            'account_type' => $request->account_type,
            'status' => $request->status,
        ]);
        Session::flash('success','Account Type Updated Successfully');
        return redirect('account');
    }
    public function destroy($id)
    {
       $delete = Account::find($id);
       $delete->delete();
        Session::flash('success','Account Type Deleted Successfully');
        return redirect('account');
    }
}
