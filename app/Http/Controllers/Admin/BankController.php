<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Bank;
use App\Chartofaccount;
use App\Cheque;
use App\ContraJournal;
use App\Http\Controllers\Controller;
use App\SisterConcern;
use Auth;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use NumberToWords\NumberToWords;

class BankController extends Controller
{
    public function index()
    {
        $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        $banks = Bank::orderBy('id', 'DESC')->get();
        return view('banks.index', compact('banks', 'sister_concerns'));
    }
    public function search(Request $request){
        $input = $request->item;
        $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        $banks = Bank::where('bank_name', 'like', "%$input%")
            ->orWhere('branch', 'like', "%$input%")
            ->orWhere('account', 'like', "%$input%")
            ->orderBy('id', 'DESC')->get();
        return view('banks.index', compact('banks', 'sister_concerns'));

    }
    public function create()
    {
        $sister_concern_s = SisterConcern::orderBy('id','DESC')->get();
        return view('banks.create',compact('sister_concern_s'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'account' => 'required|unique:banks',
        ]);
        if($request->sister_concern_id == 1){
            $chart = Chartofaccount::where('sister_concern_id', $request->sister_concern_id)->where('head_id', 61)->where('sub_head_id', 0)->first();
        }
        if($request->sister_concern_id == 3){
            $chart = Chartofaccount::where('sister_concern_id', $request->sister_concern_id)->where('head_id', 60)->where('sub_head_id', 0)->first();
        }
        if($request->sister_concern_id == 4){
            $chart = Chartofaccount::where('sister_concern_id', $request->sister_concern_id)->where('head_id', 59)->where('sub_head_id', 0)->first();
        }
        if($request->sister_concern_id == 5){
            $chart = Chartofaccount::where('sister_concern_id', $request->sister_concern_id)->where('head_id', 58)->where('sub_head_id', 0)->first();
        }
        if($request->sister_concern_id == 9){
            $chart = Chartofaccount::where('sister_concern_id', $request->sister_concern_id)->where('head_id', 57)->where('sub_head_id', 0)->first();
        }
        if($request->sister_concern_id == 10){
            $chart = Chartofaccount::where('sister_concern_id', $request->sister_concern_id)->where('head_id', 4)->where('sub_head_id', 0)->first();
        }


        $sub_heads = Chartofaccount::distinct('sub_head_id')->pluck('sub_head_id')->toArray();
        if(end($sub_heads) == 0){
            $sub_head_id = 50001;
        }
        else{
            $sub_head_id = (end($sub_heads) + 1);
        }
        if(!empty($chart)){
            Chartofaccount::create([
                'sister_concern_id' => $request->sister_concern_id,
                'type'=>'Sub-Head',
                'category'=>$chart->category,
                'head_name'=>$chart->head_name,
                'head_id'=>$chart->head_id,
                'sub_head_name'=>$request->account,
                'sub_head_id'=>$sub_head_id,
            ]);
        }
        Bank::create([
            'sister_concern_id' => $request->sister_concern_id,
            'bank_name'=>$request->bank_name,
            'branch'=>$request->branch,
            'account'=>$request->account,
            'ledger_id' => $sub_head_id,
        ]);
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Created Bank account for '. SisterConcern::find($request->sister_concern_id)->name,
        ]);
        Session::flash('success', 'Bank account created successfully');
        return redirect()->route('bank.index');
    }
    public function show($id)
    {
        $from= null;
        $to=null;
        $bank = Bank::find($id);
        $dr_contra_journals = ContraJournal::where('transfer_amount_to', $bank->account)->orderBy('date', 'DESC')->get(['date', 'debit_amount'])->toArray();
        $cr_contra_journals = ContraJournal::where('transfer_amount_from', $bank->account)->orderBy('date', 'DESC')->get(['date', 'credit_amount'])->toArray();

        $results = array_merge( $dr_contra_journals, $cr_contra_journals);
        usort($results, function($a,$b) {
            return $a['date'] < $b['date'];
        });

        return view('banks.show',compact('bank', 'results' , 'from', 'to'));
    }
    public function edit($id)
    {
        $sister_concern_s = SisterConcern::orderBy('id','DESC')->get();
        $edit = Bank::find($id);
        return view('banks.edit', compact('sister_concern_s','edit'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'unique:banks,account,'.$id,
        ]);
        $update = Bank::find($id);
        $update->update([
            'sister_concern_id' => $request->sister_concern_id,
            'bank_name'=>$request->bank_name,
            'branch'=>$request->branch,
            'account'=>$request->account,
        ]);
        $chart = Chartofaccount::where('sub_head_id', $update->ledger_id)->first();
        $chart->update([
            'sister_concern_id' => $request->sister_concern_id,
            'sub_head_name'=>$update->account,
        ]);
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Updated Bank account for '. SisterConcern::find($request->sister_concern_id)->name,
        ]);
        Session::flash('success', 'Bank account created successfully');
        return redirect()->route('bank.index');
    }

    public function destroy($id)
    {
        $bank = Bank::find($id);
        Chartofaccount::where('sub_head_id', $bank->ledger_id)->delete();
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Deleted Bank account for '. SisterConcern::find($bank->sister_concern_id)->name,
        ]);
        $bank->delete();
        Session::flash('success', 'Bank account Deleted successfully');
        return redirect()->back();
    }

    public function date_search(Request $request){
        $from = $request->date_from;
        $to = $request->date_to;
        $id = $request->id;
        $bank = Bank::find($id);
        $dr_contra_journals = ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('transfer_amount_to', $bank->account)->orderBy('date', 'DESC')->get(['date', 'debit_amount'])->toArray();
        $cr_contra_journals = ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('transfer_amount_from', $bank->account)->orderBy('date', 'DESC')->get(['date', 'credit_amount'])->toArray();
        $results = array_merge( $dr_contra_journals, $cr_contra_journals);
        usort($results, function($a,$b) {
            return $a['date'] < $b['date'];
        });
        return view('banks.show',compact('bank','results', 'from', 'to'));
    }

    public function cheque_index()
    {
        $from = null;
        $cheques = Cheque::orderBy('id','DESC')->paginate(20);
        return view('cheque.index', compact('cheques', 'from'));
    }

    public function cheque_date_search(Request $request){
        $from = $request->date_from;
        $to = $request->date_to;
        $cheques = Cheque::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('id','DESC')->paginate(20);
        return view('cheque.index', compact('cheques', 'from', 'to'));
    }

    public function cheque_create()
    {
        return view('cheque.create');
    }

    public function cheque_store(Request $request)
    {
        Cheque::create([
            'date'=>$request->date,
            'pay_to'=>$request->pay_to,
            'amount'=>$request->amount,
            'ac_payee'=>$request->ac_payee,
        ]);
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Issued Cheque of '. $request->amount . ' for '. $request->pay_to,
        ]);
        Session::flash('success', 'Cheque book entered successfully');
        return redirect()->route('cheque.index');
    }

    public function cheque_show($id)
    {
        $cheque = Cheque::find($id);
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');
        return view('cheque.print', compact('cheque', 'numberTransformer'));
    }

    public function cheque_edit($id)
    {
        $cheque = Cheque::find($id);
        return view('cheque.edit', compact('cheque'));
    }

    public function cheque_update(Request $request, $id)
    {
        $cheque = Cheque::find($id);
        $cheque->update([
            'date'=>$request->date,
            'pay_to'=>$request->pay_to,
            'amount'=>$request->amount,
            'ac_payee'=>$request->ac_payee,
        ]);
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Updated the Issued Cheque of '. $request->amount . ' for '. $request->pay_to,
        ]);
        Session::flash('success', 'Cheque book Updated successfully');
        return redirect()->route('cheque.index');
    }

    public function cheque_destroy($id)
    {
        Cheque::find($id)->delete();
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        Activity::create([
            'user_id'=>Auth::user()->id,
            'date'=>$dt->format('Y-m-d'),
            'time'=>$dt->format('H:i:s'),
            'message'=>'Deleted Cheque',
        ]);
        Session::flash('success', 'Cheque book Deleted successfully');
        return redirect()->route('cheque.index');
    }

    public function bank_status(){
        $banks = Bank::orderBy('id', 'DESC')->get();
        $from= null;
        $to=null;
        foreach ($banks as $bank){
            $dr_contra_journals = ContraJournal::where('transfer_amount_to', $bank->account)->orderBy('date', 'DESC')->get(['date', 'debit_amount'])->toArray();
            $cr_contra_journals = ContraJournal::where('transfer_amount_from', $bank->account)->orderBy('date', 'DESC')->get(['date', 'credit_amount'])->toArray();

            $results = array_merge( $dr_contra_journals, $cr_contra_journals);
            usort($results, function($a,$b) {
                return $a['date'] < $b['date'];
            });
        }
        return view('banks.bank_status',compact('banks', 'results' , 'from', 'to'));
    }
    public function bank_status_search(Request $request){
        $from = $request->date_from;
        $to = $request->date_to;
        $banks = Bank::orderBy('id', 'DESC')->get();
        foreach ($banks as $bank){
            $dr_prev_contra_journals = ContraJournal::whereDate('date', '<', $from)->where('transfer_amount_to', $bank->account)->orderBy('date', 'DESC')->get(['date', 'debit_amount'])->toArray();
            $cr_prev_contra_journals = ContraJournal::whereDate('date', '<', $from)->where('transfer_amount_from', $bank->account)->orderBy('date', 'DESC')->get(['date', 'credit_amount'])->toArray();

            $dr_contra_journals = ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('transfer_amount_to', $bank->account)->orderBy('date', 'DESC')->get(['date', 'debit_amount'])->toArray();
            $cr_contra_journals = ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('transfer_amount_from', $bank->account)->orderBy('date', 'DESC')->get(['date', 'credit_amount'])->toArray();
        }


        $results = array_merge($dr_contra_journals, $cr_contra_journals);
        $prev_results = array_merge($dr_prev_contra_journals, $cr_prev_contra_journals);
        usort($results, function($a,$b) {
            return $a['date'] < $b['date'];
        });
        usort($prev_results, function($a,$b) {
            return $a['date'] < $b['date'];
        });
        return view('banks.bank_status',compact( 'banks','results' ,'prev_results', 'from', 'to'));
    }

    public function cash_status(){
        $from= null;
        $to=null;

        $cash_id = [3,13,14,15,16,17];

        $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        $dr_contra_journals = ContraJournal::whereIn('debit_id', $cash_id)->orderBy('date', 'DESC')->get(['date', 'debit_amount'])->toArray();
        $cr_contra_journals = ContraJournal::whereIn('credit_id', $cash_id)->orderBy('date', 'DESC')->get(['date', 'credit_amount'])->toArray();

        $results = array_merge($dr_contra_journals, $cr_contra_journals);
        usort($results, function($a,$b) {
            return $a['date'] < $b['date'];
        });

        return view('banks.cash_status',compact( 'results' , 'from', 'to', 'sister_concerns'));
    }
    public function cash_date_search(Request $request){
        $from = $request->date_from;
        $to = $request->date_to;
        $sis_con = $request->sister_concern_id;
        $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        if($sis_con == 10){
            $sis_con_cash_id = 3;
        }if($sis_con == 9){
            $sis_con_cash_id = 13;
        }if($sis_con == 5){
            $sis_con_cash_id = 14;
        }if($sis_con == 4){
            $sis_con_cash_id = 15;
        }if($sis_con == 3){
            $sis_con_cash_id = 16;
        }if($sis_con == 1){
            $sis_con_cash_id = 17;
        }
        $cash_id = [3,13,14,15,16,17];

        if(!empty($from) && !empty($to) && !empty($sis_con)){
            $dr_contra_journals = ContraJournal::where('sister_concern_id', $sis_con)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $sis_con_cash_id)->orderBy('date', 'DESC')->get(['date', 'debit_amount'])->toArray();
            $cr_contra_journals = ContraJournal::where('sister_concern_id', $sis_con)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $sis_con_cash_id)->orderBy('date', 'DESC')->get(['date', 'credit_amount'])->toArray();
        }
        if(!empty($from) && !empty($to) && empty($sis_con)){
            $dr_contra_journals = ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $cash_id)->orderBy('date', 'DESC')->get(['date', 'debit_amount'])->toArray();
            $cr_contra_journals = ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $cash_id)->orderBy('date', 'DESC')->get(['date', 'credit_amount'])->toArray();
        }
        if(empty($from) && empty($to) && !empty($sis_con)){
            $dr_contra_journals = ContraJournal::where('sister_concern_id', $sis_con)->where('debit_id', $sis_con_cash_id)->orderBy('date', 'DESC')->get(['date', 'debit_amount'])->toArray();
            $cr_contra_journals = ContraJournal::where('sister_concern_id', $sis_con)->where('credit_id', $sis_con_cash_id)->orderBy('date', 'DESC')->get(['date', 'credit_amount'])->toArray();
        }
        $results = array_merge($dr_contra_journals, $cr_contra_journals);
        usort($results, function($a,$b) {
            return $a['date'] < $b['date'];
        });

        return view('banks.cash_status',compact( 'results' , 'from', 'to', 'sister_concerns'));
    }


}
