<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Chartofaccount;
use App\DebitVoucher;
use App\Http\Controllers\Controller;
use App\SisterConcern;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DebitVoucherController extends Controller
{
    public function index()
    {
        $from = null;
        $debit_vouchers = DebitVoucher::orderBy('id', 'DESC')->paginate(10);
        return view('debit_voucher.index', compact('debit_vouchers', 'from'));
    }

    public function create()
    {
        if(Auth::user()->sister_concern_id == 0){
            $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        }
        else{
            $sister_concerns = SisterConcern::where('id', Auth::user()->sister_concern_id)->orderBy('id', 'DESC')->get();
        }
        $debit_vouchers = DebitVoucher::orderBy('id', 'DESC')->get();
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
        return view('debit_voucher.create', compact('sister_concerns', 'debit_vouchers','data'));
    }

    public function store(Request $request)
    {
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        if(count($request->debit_id) > 1){
            for($i =0 ; $i<count($request->debit_id) ; $i++){
                DebitVoucher::create([
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
                DebitVoucher::create([
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
            'message'=>'Created Debit Voucher for ' . SisterConcern::find($request->sister_concern_id)->name,
        ]);
        Session::flash('success', 'Debit Voucher Created Successfully');
        return redirect()->route('debit_voucher.index');
    }
    public function show($id)
    {
        $show = DebitVoucher::find($id);
        return view('debit_voucher.show',compact('show'));
    }

    public function edit($id)
    {
        if(Auth::user()->sister_concern_id == 0){
            $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        }
        else{
            $sister_concerns = SisterConcern::where('id', Auth::user()->sister_concern_id)->orderBy('id', 'DESC')->get();
        }
        $edit = DebitVoucher::find($id);
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
        return view('debit_voucher.edit', compact('sister_concerns', 'edit', 'data'));
    }

    public function update(Request $request, $id)
    {
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $update = DebitVoucher::find($id);
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
            'message'=>'Updated Debit Voucher for ' . SisterConcern::find($request->sister_concern_id)->name,
        ]);
        Session::flash('success', 'Debit Voucher Updated Successfully');
        return redirect()->route('debit_voucher.index');
    }

    public function destroy($id)
    {
        $debit = DebitVoucher::find($id);
        DebitVoucher::find($id)->delete();
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Deleted Debit Voucher for ' . SisterConcern::find($debit->sister_concern_id)->name,
        ]);
        Session::flash('success', 'Debit Voucher Deleted Successfully');
        return redirect()->route('debit_voucher.index');
    }
    public function date_search(Request $request){
        $from = $request->date_from;
        $to = $request->date_to;
        $debit_vouchers = DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->paginate(10);
        return view('debit_voucher.index', compact('debit_vouchers', 'from', 'to'));
    }
    public function accept($id){
        $update = DebitVoucher::find($id);
        $update->update([
            'status'=>1,
        ]);
        Session::flash('success', 'Voucher Accepted Successfully');
        return redirect()->back();
    }
}
