<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Chartofaccount;
use App\Http\Controllers\Controller;
use App\Journal;
use App\SisterConcern;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class JournalController extends Controller
{

    public function index()
    {
        $from = null;
        $journals = Journal::orderBy('id', 'DESC')->paginate(10);
        return view('journal.index', compact('journals', 'from'));
    }

    public function create()
    {
        if(Auth::user()->sister_concern_id == 0){
            $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        }
        else{
            $sister_concerns = SisterConcern::where('id', Auth::user()->sister_concern_id)->orderBy('id', 'DESC')->get();
        }
        $journals = Journal::orderBy('id', 'DESC')->get();
        $data = array();
        foreach($sister_concerns as $concern){
            $heads[$concern->id] = Chartofaccount::where('sister_concern_id', $concern->id)->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
            $sub_heads[$concern->id] = Chartofaccount::where('sister_concern_id', $concern->id)->where('sub_head_id','!=', 0)->orderBy('id', 'DESC')->get();
        }
        foreach($sister_concerns as $concern){
            for($i = 0 ; $i<count($heads[$concern->id]) ; $i++){
                $data[$concern->id][$i]['id'] = $heads[$concern->id][$i]->head_id;
                $data[$concern->id][$i]['type'] = 0;
                $data[$concern->id][$i]['name'] = $heads[$concern->id][$i]->head_name;
            }
            $j = count($data[$concern->id]);
            for($i = 0 ; $i<count($sub_heads[$concern->id]) ; $i++){
                $data[$concern->id][$j]['id'] = $sub_heads[$concern->id][$i]->sub_head_id;
                $data[$concern->id][$j]['type'] = 1;
                $data[$concern->id][$j]['name'] = $sub_heads[$concern->id][$i]->sub_head_name;
                ++$j;
            }
        }
        return view('journal.create', compact('sister_concerns', 'journals', 'data'));
    }

    public function store(Request $request)
    {
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        if(count($request->debit_id) > 1){
            for($i =0 ; $i<count($request->debit_id) ; $i++){
                Journal::create([
                    'sister_concern_id'=>$request->sister_concern_id,
                    'voucher_no'=>$request->voucher_no,
                    'voucher_type'=>0,
                    'date'=>$request->date,
                    'time'=>$dt->format('H:i:s'),
                    'debit_id'=>$request->debit_id[$i],
                    'debit_amount'=>$request->debit_amount[$i],
                    'credit_id'=>$request->credit_id[0],
                    'credit_amount'=>$request->debit_amount[$i],
                    'naration'=>$request->naration,
                    'transfer_amount_to'=>$request->transfer_amount_to[$i],
                    'debit_overview'=>$request->debit_overview[$i],
                    'debit_amount_overview'=>$request->debit_amount_overview[$i],
                    'transfer_amount_from'=>$request->transfer_amount_from[0],
                    'credit_overview'=>$request->credit_overview[0],
                    'credit_amount_overview'=>$request->debit_amount_overview[$i],
                    'status'=>0,
                ]);
            }
        }
        else{
            for($i =0 ; $i<count($request->credit_id) ; $i++){
                Journal::create([
                    'sister_concern_id'=>$request->sister_concern_id,
                    'voucher_no'=>$request->voucher_no,
                    'voucher_type'=>0,
                    'date'=>$request->date,
                    'time'=>$dt->format('H:i:s'),
                    'debit_id'=>$request->debit_id[0],
                    'debit_amount'=>$request->credit_amount[$i],
                    'credit_id'=>$request->credit_id[$i],
                    'credit_amount'=>$request->credit_amount[$i],
                    'naration'=>$request->naration,
                    'transfer_amount_to'=>$request->transfer_amount_to[0],
                    'debit_overview'=>$request->debit_overview[0],
                    'debit_amount_overview'=>$request->credit_amount_overview[$i],
                    'transfer_amount_from'=>$request->transfer_amount_from[$i],
                    'credit_overview'=>$request->credit_overview[$i],
                    'credit_amount_overview'=>$request->credit_amount_overview[$i],
                    'status'=>0,
                ]);
            }
        }
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Created Journal Voucher for ' . SisterConcern::find($request->sister_concern_id)->name,
        ]);
        Session::flash('success', 'Journal Created Successfully');
        return redirect()->route('journal.index');
    }

    public function show($id)
    {
        $show = Journal::find($id);
        return view('journal.show',compact('show'));
    }

    public function edit($id)
    {
        if(Auth::user()->sister_concern_id == 0){
            $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        }
        else{
            $sister_concerns = SisterConcern::where('id', Auth::user()->sister_concern_id)->orderBy('id', 'DESC')->get();
        }
        $edit = Journal::find($id);
        $data = array();
        foreach($sister_concerns as $concern){
            $heads[$concern->id] = Chartofaccount::where('sister_concern_id', $concern->id)->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
            $sub_heads[$concern->id] = Chartofaccount::where('sister_concern_id', $concern->id)->where('sub_head_id','!=', 0)->orderBy('id', 'DESC')->get();
        }
        foreach($sister_concerns as $concern){
            for($i = 0 ; $i<count($heads[$concern->id]) ; $i++){
                $data[$concern->id][$i]['id'] = $heads[$concern->id][$i]->head_id;
                $data[$concern->id][$i]['type'] = 0;
                $data[$concern->id][$i]['name'] = $heads[$concern->id][$i]->head_name;
            }
            $j = count($data[$concern->id]);
            for($i = 0 ; $i<count($sub_heads[$concern->id]) ; $i++){
                $data[$concern->id][$j]['id'] = $sub_heads[$concern->id][$i]->sub_head_id;
                $data[$concern->id][$j]['type'] = 1;
                $data[$concern->id][$j]['name'] = $sub_heads[$concern->id][$i]->sub_head_name;
                ++$j;
            }
        }
        return view('journal.edit', compact('sister_concerns', 'edit', 'data'));
    }

    public function update(Request $request, $id)
    {
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $update = Journal::find($id);
        $update->update([
            'sister_concern_id'=>$request->sister_concern_id,
            'voucher_no'=>$request->voucher_no,
            'date'=>$request->date,
            'time'=>$dt->format('H:i:s'),
            'debit_id'=>$request->debit_id,
            'debit_amount'=>$request->debit_amount,
            'credit_id'=>$request->credit_id,
            'credit_amount'=>$request->credit_amount,
            'naration'=>$request->naration,
            'transfer_amount_to'=>$request->transfer_amount_to,
            'debit_overview'=>$request->debit_overview,
            'debit_amount_overview'=>$request->debit_amount_overview,
            'transfer_amount_from'=>$request->transfer_amount_from,
            'credit_overview'=>$request->credit_overview,
            'credit_amount_overview'=>$request->credit_amount_overview,
        ]);
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Updated Journal Voucher for ' . SisterConcern::find($update->sister_concern_id)->name,
        ]);
        Session::flash('success', 'Journal Updated Successfully');
        return redirect()->route('journal.index');
    }

    public function destroy($id)
    {
        $journal = Journal::find($id);
        Journal::find($id)->delete();
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Updated Journal Voucher for ' . SisterConcern::find($journal->sister_concern_id)->name,
        ]);
        Session::flash('success', 'Journal Updated Successfully');
        return redirect()->route('journal.index');
    }
    public function date_search(Request $request){
        $from = $request->date_from;
        $to = $request->date_to;
        $journals = Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->paginate(10);
        return view('journal.index', compact('journals', 'from', 'to'));
    }
    public function accept($id){
        $update = Journal::find($id);
        $update->update([
            'status'=>1,
        ]);
        Session::flash('success', 'Voucher Accepted Successfully');
        return redirect()->back();
    }

}
