<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Bank;
use App\Chartofaccount;
use App\ContraJournal;
use App\Http\Controllers\Controller;
use App\SisterConcern;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ContraJournalController extends Controller
{

    public function index()
    {
        $contra_journals = ContraJournal::orderBy('id', 'DESC')->paginate(10);
        return view('contra_journal.index', compact('contra_journals'));
    }

    public function create()
    {
        if(Auth::user()->sister_concern_id == 0){
            $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        }
        else{
            $sister_concerns = SisterConcern::where('id', Auth::user()->sister_concern_id)->orderBy('id', 'DESC')->get();
        }
        $contra_journals = ContraJournal::orderBy('id', 'DESC')->get();
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
        return view('contra_journal.create', compact('sister_concerns', 'contra_journals', 'data'));
    }

    public function store(Request $request)
    {
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        if(count($request->debit_id) > 1){
            for($i =0 ; $i<count($request->debit_id) ; $i++){
                ContraJournal::create([
                    'voucher_no'=>$request->voucher_no,
                    'date'=>$request->date,
                    'time'=>$dt->format('H:i:s'),
                    'sister_concern_id_to'=>$request->sister_concern_id_to,
                    'debit_id'=>$request->debit_id[$i],
                    'debit_amount'=>$request->debit_amount[$i],
                    'sister_concern_id_from'=>$request->sister_concern_id_from,
                    'credit_id'=>$request->credit_id[0],
                    'credit_amount'=>$request->debit_amount[$i],
                    'narration'=>$request->narration,
                    'transfer_amount_to'=>$request->transfer_amount_to[$i],
                    'debit_overview'=>$request->debit_overview[$i],
                    'debit_amount_overview'=>$request->debit_amount_overview[$i],
                    'transfer_amount_from'=>$request->transfer_amount_from[0],
                    'credit_overview'=>$request->credit_overview[0],
                    'credit_amount_overview'=>$request->debit_amount_overview[$i],
                ]);
            }
        }
        else{
            for($i =0 ; $i<count($request->credit_id) ; $i++){
                ContraJournal::create([
                    'voucher_no'=>$request->voucher_no,
                    'date'=>$request->date,
                    'time'=>$dt->format('H:i:s'),
                    'sister_concern_id_to'=>$request->sister_concern_id_to,
                    'debit_id'=>$request->debit_id[0],
                    'debit_amount'=>$request->credit_amount[$i],
                    'sister_concern_id_from'=>$request->sister_concern_id_from,
                    'credit_id'=>$request->credit_id[$i],
                    'credit_amount'=>$request->credit_amount[$i],
                    'narration'=>$request->narration,
                    'transfer_amount_to'=>$request->transfer_amount_to[0],
                    'debit_overview'=>$request->debit_overview[0],
                    'debit_amount_overview'=>$request->credit_amount_overview[$i],
                    'transfer_amount_from'=>$request->transfer_amount_from[$i],
                    'credit_overview'=>$request->credit_overview[$i],
                    'credit_amount_overview'=>$request->credit_amount_overview[$i],
                ]);
            }
        }
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'transfer money from ' . SisterConcern::find($request->sister_concern_id_from)->name . 'to'. SisterConcern::find($request->sister_concern_id_to)->name,
        ]);
            Session::flash('success', 'Amount transfer is successful');
            return redirect()->route('contra_journal.index');
    }

    public function show($id)
    {
        $show = ContraJournal::find($id);
        return view('contra_journal.show',compact('show'));
    }

    public function edit($id)
    {
        if(Auth::user()->sister_concern_id == 0){
            $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        }
        else{
            $sister_concerns = SisterConcern::where('id', Auth::user()->sister_concern_id)->orderBy('id', 'DESC')->get();
        }
        $edit = ContraJournal::find($id);
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
        return view('contra_journal.edit', compact('sister_concerns', 'edit', 'data'));
    }

    public function update(Request $request, $id)
    {

        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $update = ContraJournal::find($id);
        $update->update([
            'voucher_no'=>$request->voucher_no,
            'date'=>$request->date,
            'time'=>$dt->format('H:i:s'),
            'sister_concern_id_to'=>$request->sister_concern_id_to,
            'debit_id'=>$request->debit_id,
            'debit_amount'=>$request->debit_amount,
            'sister_concern_id_from'=>$request->sister_concern_id_from,
            'credit_id'=>$request->credit_id,
            'credit_amount'=>$request->credit_amount,
            'narration'=>$request->narration,
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
            'message'=>'transfer money from ' . SisterConcern::find($request->sister_concern_id_from)->name . 'to'. SisterConcern::find($request->sister_concern_id_to)->name,
        ]);
        Session::flash('success', 'Amount transfer is updated successful');
        return redirect()->route('contra_journal.index');
    }

    public function destroy($id)
    {
        $contra = ContraJournal::find($id);
        ContraJournal::find($id)->delete();
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Deleted Contra Journal for ' . SisterConcern::find($contra->sister_concern_id_from)->name. 'and '.SisterConcern::find($contra->sister_concern_id_from)->name,
        ]);
        Session::flash('success', 'Contra Journal Deleted Successfully');
        return redirect()->route('contra_journal.index');
    }
    public function banks($id){
        $banks = Bank::where('sister_concern_id', $id)->get();
        return response()->json($banks);
    }
    public function date_search(Request $request){
        $from = $request->date_from;
        $to = $request->date_to;
        $contra_journals = ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('id', 'DESC')->paginate(10);
        return view('contra_journal.index', compact('contra_journals', 'from', 'to'));
    }
}
