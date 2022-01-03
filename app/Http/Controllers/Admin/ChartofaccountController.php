<?php

namespace App\Http\Controllers\Admin;
use App\Activity;
use App\Chartofaccount;
use App\Http\Controllers\Controller;
use App\SisterConcern;
use Auth;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChartofaccountController extends Controller
{

    public function index($id)
    {
        $categories = ['Non-Current Asset', 'Current Asset', 'Non-Current Liabilities', 'Current Liabilities', 'Income', 'Expense', 'Equity'];
        return view('chart_of_account.index', compact('categories', 'id'));
    }
    public function search(Request $request){
        $input = $request->item;
        $id = $request->sister_concern_id;
        $categories = Chartofaccount::where('sister_concern_id', $id)
            ->where('category', 'like', "%$input%")
            ->orWhere('head_name', 'like', "%$input%")
            ->orWhere('sub_head_name', 'like', "%$input%")
            ->orderBy('id', 'DESC')->distinct()->pluck('category')->toArray();
        return view('chart_of_account.index', compact('categories', 'id'));

    }

    public function create()
    {
        $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        return view('chart_of_account.create', compact('sister_concerns'));
    }
    public function store(Request $request)
    {
        Chartofaccount::create([
            'sister_concern_id' => $request->sister_concern_id,
            'category'=>$request->category,
            'type'=>$request->type,
            'head_id'=>$request->head_id,
            'head_name'=>$request->head_name,
            'sub_head_id'=>$request->sub_head_id,
            'sub_head_name'=>$request->sub_head_name,
            'child_head_id'=>$request->child_head_id,
            'child_head_name'=>$request->child_head_name,
            'narration'=>$request->narration,
        ]);

        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Created Chart Of Account Heads',
        ]);
        Session::flash('success', 'Chart Of Account Created Successfully');
        return redirect()->route('chart_of_account.index', $request->sister_concern_id);
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        $edit = Chartofaccount::where('head_id', $id)->where('sub_head_id', 0)->where('child_head_id', 0)->orWhere('sub_head_id', $id)->where('sub_head_id','!=', 0)->where('child_head_id', 0)->orWhere('child_head_id', $id)->where('sub_head_id','!=', 0)->orderBy('id', 'DESC')->first();
        $heads = Chartofaccount::where('sub_head_id', 0)->where('child_head_id', 0)->where('category', $edit->category)->orderBy('id', 'DESC')->get();
        $sub_heads = Chartofaccount::where('child_head_id', 0)->where('sub_head_id', '!=', 0)->where('category', $edit->category)->orderBy('id', 'DESC')->get();
        return view('chart_of_account.edit', compact('sister_concerns','edit', 'heads', 'sub_heads'));
    }
    public function update(Request $request, $id)
    {
        $update = Chartofaccount::find($id);
        $update->update([
            'sister_concern_id' => $request->sister_concern_id,
            'category'=>$request->category,
            'type'=>$request->type,
            'head_id'=>$request->head_id,
            'head_name'=>$request->head_name,
            'sub_head_id'=>$request->sub_head_id,
            'sub_head_name'=>$request->sub_head_name,
            'child_head_id'=>$request->child_head_id,
            'child_head_name'=>$request->child_head_name,
            'narration'=>$request->narration,
        ]);
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Updated Chart Of Account Heads',
        ]);
        Session::flash('success', 'Chart Of Account Updated Successfully');
        return redirect()->route('chart_of_account.index', $request->sister_concern_id);
    }
    public function destroy($id)
    {
        Chartofaccount::find($id)->delete();
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Deleted Chart Of Account Heads',
        ]);
        Session::flash('success', 'Chart Of Account Deleted Successfully');
        return redirect()->back();
    }
    public function head_names($id){
        $heads = Chartofaccount::where('sister_concern_id', $id)->where('sub_head_id', 0)->distinct('head_id')->get();
        return response()->json($heads);
    }
    public function head_id(){
        $heads = Chartofaccount::distinct('head_id')->pluck('head_id')->toArray();
        return response()->json(end($heads) + 1);
    }
    public function sub_head_id(){
        $sub_heads = Chartofaccount::distinct('sub_head_id')->pluck('sub_head_id')->toArray();
        if(end($sub_heads) == 0){
            $sub_head_id = 50001;
        }
        else{
            $sub_head_id = (end($sub_heads) + 1);
        }
        return response()->json($sub_head_id);
    }
    public function child_head_id(){
        $child_heads = Chartofaccount::distinct('child_head_id')->pluck('child_head_id')->toArray();
        if(end($child_heads) == 0){
            $child_head_id = 100001;
        }
        else{
            $child_head_id = (end($child_heads) + 1);
        }
        return response()->json($child_head_id);
    }
    public function category_heads($id, $sid){
        $heads = Chartofaccount::where('sister_concern_id', $sid)->where('category', $id)->where('sub_head_id', 0)->distinct('head_id')->get();
        return response()->json($heads);
    }
    public function heads_category($id, $sid){
        $heads = Chartofaccount::where('sister_concern_id', $sid)->where('head_name', $id)->orderBy('id', 'DESC')->first();
        return response()->json($heads);
    }
    public function sub_heads_category($id, $sid){
        $sub_heads = Chartofaccount::where('sister_concern_id', $sid)->where('sub_head_name', $id)->orderBy('id', 'DESC')->first();
        return response()->json($sub_heads);
    }
    public function sub_heads($id, $sid){
        $heads = Chartofaccount::where('sister_concern_id', $sid)->where('head_name', $id)->orderBy('id', 'DESC')->first();
        $sub_heads = Chartofaccount::where('sister_concern_id', $sid)->where('head_name', $id)->where('sub_head_id', '!=', 0)->orderBy('id', 'DESC')->get();
        return response()->json([$heads,$sub_heads]);
    }
    public function ledger_charts($id){
        $heads = Chartofaccount::where('sister_concern_id', $id)->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
        $sub_heads = Chartofaccount::where('sister_concern_id', $id)->where('sub_head_id','!=', 0)->orderBy('id', 'DESC')->get();
        return response()->json([$heads, $sub_heads]);
    }
}
