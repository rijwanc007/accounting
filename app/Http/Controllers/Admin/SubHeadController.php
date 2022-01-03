<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubHeadController extends Controller
{
    public function index()
    {
       return view('admin.sub_head.index_sub_head');
    }
    public function create()
    {
       return view('admin.sub_head.create_sub_head');
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
}
