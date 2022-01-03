<?php

namespace App\Http\Controllers\Admin;
use App\Accounting;
use App\Bank;
use App\Chartofaccount;
use App\ContraJournal;
use App\CreditVoucher;
use App\DebitVoucher;
use App\Http\Controllers\Controller;
use App\Journal;
use App\SisterConcern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function ledger(){
        if(Auth::user()->sister_concern_id == 0){
            $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        }
        else{
            $sister_concerns = SisterConcern::where('id', Auth::user()->sister_concern_id)->orderBy('id', 'DESC')->get();
        }
        $company = null;
        $data = array();
        foreach($sister_concerns as $concern){
            $heads[$concern->id] = Chartofaccount::where('sister_concern_id', $concern->id)->where('sub_head_id', 0)->where('child_head_id', 0)->orderBy('id', 'DESC')->get();
            $sub_heads[$concern->id] = Chartofaccount::where('sister_concern_id', $concern->id)->where('sub_head_id','!=', 0)->where('child_head_id', 0)->orderBy('id', 'DESC')->get();
            $child_heads[$concern->id] = Chartofaccount::where('sister_concern_id', $concern->id)->where('child_head_id','!=', 0)->orderBy('id', 'DESC')->get();
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
            $k = count($data[$concern->id]);
            for($i = 0 ; $i<count($child_heads[$concern->id]) ; $i++){
                $data[$concern->id][$k]['id'] = $child_heads[$concern->id][$i]->child_head_id;
                $data[$concern->id][$k]['type'] = 1;
                $data[$concern->id][$k]['name'] = $child_heads[$concern->id][$i]->child_head_name;
                ++$k;
            }
        }
        $results = null;
        $chart = null;
        $balance = 0;
        return view('report.ledger', compact('data', 'results', 'chart', 'balance', 'sister_concerns', 'company'));
    }
    public function ledger_search(Request $request){
        if(Auth::user()->sister_concern_id == 0){
            $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        }
        else{
            $sister_concerns = SisterConcern::where('id', Auth::user()->sister_concern_id)->orderBy('id', 'DESC')->get();
        }
        $company = SisterConcern::find($request->sister_concern_id);
        $from = $request->date_from;
        $to = $request->date_to;
        $data = array();
        foreach($sister_concerns as $concern){
            $heads[$concern->id] = Chartofaccount::where('sister_concern_id', $concern->id)->where('sub_head_id', 0)->where('child_head_id', 0)->orderBy('id', 'DESC')->get();
            $sub_heads[$concern->id] = Chartofaccount::where('sister_concern_id', $concern->id)->where('sub_head_id','!=', 0)->where('child_head_id', 0)->orderBy('id', 'DESC')->get();
            $child_heads[$concern->id] = Chartofaccount::where('sister_concern_id', $concern->id)->where('child_head_id','!=', 0)->orderBy('id', 'DESC')->get();
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
            $k = count($data[$concern->id]);
            for($i = 0 ; $i<count($child_heads[$concern->id]) ; $i++){
                $data[$concern->id][$k]['id'] = $child_heads[$concern->id][$i]->child_head_id;
                $data[$concern->id][$k]['type'] = 1;
                $data[$concern->id][$k]['name'] = $child_heads[$concern->id][$i]->child_head_name;
                ++$k;
            }
        }

        $chart = Chartofaccount::where('head_id', $request->chart_id)
            ->where('sub_head_id', 0)
            ->where('child_head_id', 0)
            ->orWhere('sub_head_id', $request->chart_id)
            ->where('sub_head_id', '!=', 0)
            ->where('child_head_id', 0)
            ->orWhere('child_head_id', $request->chart_id)
            ->where('child_head_id', '!=', 0)
            ->orderBy('id', 'DESC')
            ->first();
        if($chart->sub_head_id == 0 && $chart->child_head_id == 0){
            $charts = Chartofaccount::where('head_id', $request->chart_id)->where('sub_head_id', '!=', 0)->orderBy('id', 'DESC')->pluck('sub_head_id')->toArray();
        }
        elseif($chart->sub_head_id != 0 && $chart->child_head_id == 0){
            $charts = Chartofaccount::where('head_id', $request->chart_id)->where('sub_head_id', $chart->sub_head_id)->orderBy('id', 'DESC')->pluck('child_head_id')->toArray();
        }
        else{
            $charts = array();
        }
        if(!empty($from) && !empty($to)){
            $cr_credits = CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $request->chart_id)->orWhereIn('credit_id', $charts)->orderBy('date', 'ASC')->get(['date','time', 'transfer_amount_to',  'debit_amount', 'voucher_no', 'naration', 'created_at'])->toArray();
            $dr_credits = CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $request->chart_id)->orWhereIn('debit_id', $charts)->orderBy('date', 'ASC')->get(['date','time',  'transfer_amount_from',  'credit_amount', 'voucher_no', 'naration', 'created_at'])->toArray();
            $dr_debits = DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $request->chart_id)->orWhereIn('debit_id', $charts)->orderBy('date', 'ASC')->get(['date','time',  'transfer_amount_from', 'credit_amount', 'voucher_no', 'naration', 'created_at'])->toArray();
            $cr_debits = DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $request->chart_id)->orWhereIn('credit_id', $charts)->orderBy('date', 'ASC')->get(['date','time',  'transfer_amount_to', 'debit_amount', 'voucher_no', 'naration', 'created_at'])->toArray();
            $journal_debits = Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $request->chart_id)->orWhereIn('debit_id', $charts)->orderBy('date', 'ASC')->get(['date','time',  'transfer_amount_from', 'credit_amount', 'voucher_no', 'naration', 'created_at'])->toArray();
            $journal_credits = Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $request->chart_id)->orWhereIn('credit_id', $charts)->orderBy('date', 'ASC')->get(['date','time',  'transfer_amount_to',  'debit_amount', 'voucher_no', 'naration', 'created_at'])->toArray();
        }
        else{
            $cr_credits = CreditVoucher::where('credit_id', $request->chart_id)->orWhereIn('credit_id', $charts)->orderBy('date', 'ASC')->get(['date','time',  'transfer_amount_to',  'debit_amount', 'voucher_no', 'naration', 'created_at'])->toArray();
            $dr_credits = CreditVoucher::where('debit_id', $request->chart_id)->orWhereIn('debit_id', $charts)->orderBy('date', 'ASC')->get(['date','time',  'transfer_amount_from',  'credit_amount', 'voucher_no', 'naration', 'created_at'])->toArray();
            $dr_debits = DebitVoucher::where('debit_id', $request->chart_id)->orWhereIn('debit_id', $charts)->orderBy('date', 'ASC')->get(['date','time',  'transfer_amount_from', 'credit_amount', 'voucher_no', 'naration', 'created_at'])->toArray();
            $cr_debits = DebitVoucher::where('credit_id', $request->chart_id)->orWhereIn('credit_id', $charts)->orderBy('date', 'ASC')->get(['date','time',  'transfer_amount_to', 'debit_amount', 'voucher_no', 'naration', 'created_at'])->toArray();
            $journal_debits = Journal::where('debit_id', $request->chart_id)->orWhereIn('debit_id', $charts)->orderBy('date', 'ASC')->get(['date','time',  'transfer_amount_from', 'credit_amount', 'voucher_no', 'naration', 'created_at'])->toArray();
            $journal_credits = Journal::where('credit_id', $request->chart_id)->orWhereIn('credit_id', $charts)->orderBy('date', 'ASC')->get(['date','time',  'transfer_amount_to',  'debit_amount', 'voucher_no', 'naration', 'created_at'])->toArray();
        }
        $results = array_merge($cr_credits,$dr_credits, $dr_debits, $cr_debits, $journal_debits, $journal_credits );
        sort($results);
        $balance = 0;
        return view('report.ledger', compact('sister_concerns','data', 'results', 'chart','from', 'to', 'balance', 'company'));
    }

    public function balance(){
        $from= null;
        $to = null;
        $sis_con = null;
        $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        $assets = ['Current Asset', 'Non-Current Asset'];
        $check_current_asset = array();
        $check_non_current_asset = array();
        $liabilities = ['Current Liabilities', 'Non-Current Liabilities', 'Equity'];
        $check_current_liabilities = array();
        $check_non_current_liabilities = array();
        $check_equities = array();


        for($i=0;$i<count($assets) ;$i++){
            $j = 0;
            $heads = Chartofaccount::where('category', $assets[$i])->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
            foreach($heads as $head){
                $sub_head_id = Chartofaccount::where('head_id', $head->head_id)->where('sub_head_id','!=', 0)->pluck('sub_head_id')->toArray();
                if(!empty($from) && !empty($to)){
                    $head_sum = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                            + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                            + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                            + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')) -
                        (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                            + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                            + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                            + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount'));
                }
                else{
                    $head_sum = (CreditVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                            + DebitVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                            + Journal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                            + ContraJournal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')) -
                        (CreditVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                            + DebitVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                            + Journal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                            + ContraJournal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount'));
                }
                if($assets[$i] == 'Current Asset'){
                    $check_current_asset[$j]['particular'] = $head->head_name;
                    $check_current_asset[$j]['amount'] = $head_sum;
                }
                if($assets[$i] == 'Non-Current Asset'){
                    $check_non_current_asset[$j]['particular'] = $head->head_name;
                    $check_non_current_asset[$j]['amount'] = $head_sum;
                }
            }
        }
        for($i=0;$i<count($liabilities) ;$i++){
            $j = 0;
            $heads = Chartofaccount::where('category', $liabilities[$i])->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
            foreach($heads as $head){
                $sub_head_id = Chartofaccount::where('head_id', $head->head_id)->where('sub_head_id','!=', 0)->pluck('sub_head_id')->toArray();
                if(!empty($from) && !empty($to)){
                    $head_sum = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                            + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                            + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                            + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')) -
                        (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                            + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                            + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                            + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount'));
                }
                else{
                    $head_sum = (CreditVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                            + DebitVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                            + Journal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                            + ContraJournal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                        (CreditVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                            + DebitVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                            + Journal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                            + ContraJournal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount'));
                }
                if($liabilities[$i] == 'Current Liabilities'){
                    $check_current_liabilities[$j]['particular'] = $head->head_name;
                    $check_current_liabilities[$j]['amount'] = $head_sum;
                }
                if($liabilities[$i] == 'Non-Current Liabilities'){
                    $check_non_current_liabilities[$j]['particular'] = $head->head_name;
                    $check_non_current_liabilities[$j]['amount'] = $head_sum;
                }
                if($liabilities[$i] == 'Equity'){
                    $check_equities[$j]['particular'] = $head->head_name;
                    $check_equities[$j]['amount'] = $head_sum;
                }
            }
        }

        for($i = 0 ; $i<count($check_current_asset); $i++){
            $check = Accounting::where('particular', $check_current_asset[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $check_current_asset[$i]['particular'],
                    'amount' => $check_current_asset[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $check_current_asset[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $current_assets = Accounting::all();
        Accounting::truncate();

        for($i = 0 ; $i<count($check_non_current_asset); $i++){
            $check = Accounting::where('particular', $check_non_current_asset[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $check_non_current_asset[$i]['particular'],
                    'amount' => $check_non_current_asset[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $check_non_current_asset[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $non_current_assets = Accounting::all();
        Accounting::truncate();

        for($i = 0 ; $i<count($check_current_liabilities); $i++){
            $check = Accounting::where('particular', $check_current_liabilities[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $check_current_liabilities[$i]['particular'],
                    'amount' => $check_current_liabilities[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $check_current_liabilities[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $current_liabilities = Accounting::all();
        Accounting::truncate();

        for($i = 0 ; $i<count($check_non_current_liabilities); $i++){
            $check = Accounting::where('particular', $check_non_current_liabilities[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $check_non_current_liabilities[$i]['particular'],
                    'amount' => $check_non_current_liabilities[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $check_non_current_liabilities[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $non_current_liabilities = Accounting::all();
        Accounting::truncate();

        for($i = 0 ; $i<count($check_equities); $i++){
            $check = Accounting::where('particular', $check_equities[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $check_equities[$i]['particular'],
                    'amount' => $check_equities[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $check_equities[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $equities = Accounting::all();
        Accounting::truncate();


        /*Retained Earnings Code */

        $sales_id = [9, 26, 31, 35, 39, 43];
        $except = [10,28,32,36,40,44,11, 29, 33, 37,41 ,45];
        $less_id = [10,28,32,36,40,44,11, 29, 33, 37,41 ,45,20,21];
        if(!empty($from) && !empty($to)){
            $sales =   (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount'));
        }
        else{
            $sales =   (CreditVoucher::whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + DebitVoucher::whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + Journal::whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                (CreditVoucher::whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + DebitVoucher::whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + Journal::whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount'));
        }

        $expense_heads = Chartofaccount::where('category', 'Expense')->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
        $income_heads = Chartofaccount::where('category', 'Income')->where('head_id', '!=', $sales_id)->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
        $i = 0;
        $j = 0;
        $expense_sum = 0;
        $gross_expense = 0;
        $cost_of_sale = 0;
        $income_sum = 0;
        foreach($expense_heads as $head){
            $sub_head_id = Chartofaccount::where('head_id', $head->head_id)->where('sub_head_id','!=', 0)->pluck('sub_head_id')->toArray();
            if(!empty($from) && !empty($to)){
                $head_sum = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')) -
                    (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount'));
            }
            else{
                $head_sum = (CreditVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')) -
                    (CreditVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount'));
            }
            if(in_array($head->head_id, $less_id)){
                $check_less[$i]['particular'] = $head->head_name;
                $check_less[$i]['amount'] = $head_sum;
                if($head->head_id == 21){
                    $cost_of_sale -= $head_sum;
                }
                else{
                    $cost_of_sale += $head_sum;
                }
                $i++;
            }
            if(!in_array($head->head_id, $less_id)){
                $check_expense[$j]['particular'] = $head->head_name;
                $check_expense[$j]['amount'] = $head_sum;
                $expense_sum += $head_sum;
                $j++;
            }
            if(!in_array($head->head_id, $except)){
                $gross_expense += $head_sum;
            }

        }
        $j = 0;
        foreach($income_heads as $head){
            $sub_head_id = Chartofaccount::where('head_id', $head->head_id)->where('sub_head_id','!=', 0)->pluck('sub_head_id')->toArray();
            if(!empty($from) && !empty($to)){
                $head_sum = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')) -
                    (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount'));
            }
            else{
                $head_sum = (CreditVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                    (CreditVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount'));
            }

            if(!in_array($head->head_id, $sales_id)){
                $check_income[$j]['particular'] = $head->head_name;
                $check_income[$j]['amount'] = $head_sum;
                $income_sum += $head_sum;
                $j++;
            }
        }

        $retained_earnings = ($sales - $cost_of_sale) - ($expense_sum + $income_sum);

        /*Retained Earnings End */

        return view('report.balance', compact('sister_concerns', 'sis_con','from','to','current_assets', 'non_current_assets','current_liabilities',  'non_current_liabilities', 'equities', 'retained_earnings'));
    }
    public function balance_date_search(Request $request){
        $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        $from = $request->date_from;
        $to = $request->date_to;
        $sis_con = $request->sister_concern_id;
        $assets = ['Current Asset', 'Non-Current Asset'];
        $check_current_asset = array();
        $check_non_current_asset = array();
        $liabilities = ['Current Liabilities', 'Non-Current Liabilities', 'Equity'];
        $check_current_liabilities = array();
        $check_non_current_liabilities = array();
        $check_equities = array();


        for($i=0;$i<count($assets) ;$i++){
            $j = 0;
            $heads = Chartofaccount::where('category', $assets[$i])->where('sister_concern_id', $sis_con)->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
            foreach($heads as $head){
                $sub_head_id = Chartofaccount::where('sister_concern_id', $sis_con)->where('head_id', $head->head_id)->where('sub_head_id','!=', 0)->pluck('sub_head_id')->toArray();
                if(!empty($from) && !empty($to)){
                    $head_sum = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                            + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                            + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                            + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')) -
                        (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                            + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                            + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                            + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount'));
                }
                else{
                    $head_sum = (CreditVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                            + DebitVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                            + Journal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                            + ContraJournal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')) -
                        (CreditVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                            + DebitVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                            + Journal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                            + ContraJournal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount'));
                }
                if($assets[$i] == 'Current Asset'){
                    $check_current_asset[$j]['particular'] = $head->head_name;
                    $check_current_asset[$j]['amount'] = $head_sum;
                }
                if($assets[$i] == 'Non-Current Asset'){
                    $check_non_current_asset[$j]['particular'] = $head->head_name;
                    $check_non_current_asset[$j]['amount'] = $head_sum;
                }
            }
        }
        for($i=0;$i<count($liabilities) ;$i++){
            $j = 0;
            $heads = Chartofaccount::where('category', $liabilities[$i])->where('sister_concern_id', $sis_con)->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
            foreach($heads as $head){
                $sub_head_id = Chartofaccount::where('sister_concern_id', $sis_con)->where('head_id', $head->head_id)->where('sub_head_id','!=', 0)->pluck('sub_head_id')->toArray();
                if(!empty($from) && !empty($to)){
                    $head_sum = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                            + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                            + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                            + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')) -
                        (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                            + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                            + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                            + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount'));
                }
                else{
                    $head_sum = (CreditVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                            + DebitVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                            + Journal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                            + ContraJournal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                        (CreditVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                            + DebitVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                            + Journal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                            + ContraJournal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount'));
                }
                if($liabilities[$i] == 'Current Liabilities'){
                    $check_current_liabilities[$j]['particular'] = $head->head_name;
                    $check_current_liabilities[$j]['amount'] = $head_sum;
                }
                if($liabilities[$i] == 'Non-Current Liabilities'){
                    $check_non_current_liabilities[$j]['particular'] = $head->head_name;
                    $check_non_current_liabilities[$j]['amount'] = $head_sum;
                }
                if($liabilities[$i] == 'Equity'){
                    $check_equities[$j]['particular'] = $head->head_name;
                    $check_equities[$j]['amount'] = $head_sum;
                }
            }
        }

        for($i = 0 ; $i<count($check_current_asset); $i++){
            $check = Accounting::where('particular', $check_current_asset[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $check_current_asset[$i]['particular'],
                    'amount' => $check_current_asset[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $check_current_asset[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $current_assets = Accounting::all();
        Accounting::truncate();

        for($i = 0 ; $i<count($check_non_current_asset); $i++){
            $check = Accounting::where('particular', $check_non_current_asset[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $check_non_current_asset[$i]['particular'],
                    'amount' => $check_non_current_asset[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $check_non_current_asset[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $non_current_assets = Accounting::all();
        Accounting::truncate();

        for($i = 0 ; $i<count($check_current_liabilities); $i++){
            $check = Accounting::where('particular', $check_current_liabilities[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $check_current_liabilities[$i]['particular'],
                    'amount' => $check_current_liabilities[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $check_current_liabilities[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $current_liabilities = Accounting::all();
        Accounting::truncate();

        for($i = 0 ; $i<count($check_non_current_liabilities); $i++){
            $check = Accounting::where('particular', $check_non_current_liabilities[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $check_non_current_liabilities[$i]['particular'],
                    'amount' => $check_non_current_liabilities[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $check_non_current_liabilities[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $non_current_liabilities = Accounting::all();
        Accounting::truncate();

        for($i = 0 ; $i<count($check_equities); $i++){
            $check = Accounting::where('particular', $check_equities[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $check_equities[$i]['particular'],
                    'amount' => $check_equities[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $check_equities[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $equities = Accounting::all();
        Accounting::truncate();


        /*Retained Earnings Code */

        if($sis_con == 1){
            $sales_id = [43];
            $except = [44,45];
            $less_id = [44,45,20,21];
        }
        if($sis_con == 3){
            $sales_id = [39];
            $except = [40,41];
            $less_id = [40,41,20,21];
        }
        if($sis_con == 4){
            $sales_id = [35];
            $except = [36,37];
            $less_id = [36,37,20,21];
        }
        if($sis_con == 5){
            $sales_id = [31];
            $except = [32,33];
            $less_id = [32,33,20,21];
        }
        if($sis_con == 9){
            $sales_id = [26];
            $except = [28,29];
            $less_id = [28,29,20,21];
        }
        if($sis_con == 10){
            $sales_id = [9];
            $except = [10,11];
            $less_id = [10,11,20,21];
        }
        if($sis_con == null){
            $sales_id = [9, 26, 31, 35, 39, 43];
            $except = [10,28,32,36,40,44,11, 29, 33, 37,41 ,45];
            $less_id = [10,28,32,36,40,44,11, 29, 33, 37,41 ,45,20,21];
        }
        if(!empty($from) && !empty($to)){
            $sales =   (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('sister_concern_id', $sis_con)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('sister_concern_id', $sis_con)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('sister_concern_id', $sis_con)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('sister_concern_id', $sis_con)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('sister_concern_id', $sis_con)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('sister_concern_id', $sis_con)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount'));
        }
        else{
            $sales =   (CreditVoucher::where('sister_concern_id', $sis_con)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + DebitVoucher::where('sister_concern_id', $sis_con)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + Journal::where('sister_concern_id', $sis_con)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                (CreditVoucher::where('sister_concern_id', $sis_con)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + DebitVoucher::where('sister_concern_id', $sis_con)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + Journal::where('sister_concern_id', $sis_con)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount'));
        }

        if(!empty($sis_con)){
            $expense_heads = Chartofaccount::where('sister_concern_id', $sis_con)->where('category', 'Expense')->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
            $income_heads = Chartofaccount::where('sister_concern_id', $sis_con)->where('category', 'Income')->where('head_id', '!=', $sales_id)->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
        }
        else{
            $expense_heads = Chartofaccount::where('category', 'Expense')->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
            $income_heads = Chartofaccount::where('category', 'Income')->where('head_id', '!=', $sales_id)->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
        }


        $less = array();
        $i = 0;
        $j = 0;
        $expense = array();
        $expense_sum = 0;
        $gross_expense = 0;
        $cost_of_sale = 0;
        $income = array();
        $income_sum = 0;
        foreach($expense_heads as $head){
            $sub_head_id = Chartofaccount::where('sister_concern_id', $sis_con)->where('head_id', $head->head_id)->where('sub_head_id','!=', 0)->pluck('sub_head_id')->toArray();
            if(!empty($from) && !empty($to)){
                $head_sum = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')) -
                    (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount'));
            }
            else{
                $head_sum = (CreditVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')) -
                    (CreditVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount'));
            }
            if(in_array($head->head_id, $less_id)){
                $less[$i]['particular'] = $head->head_name;
                $less[$i]['amount'] = $head_sum;
                if($head->head_id == 21){
                    $cost_of_sale -= $head_sum;
                }
                else{
                    $cost_of_sale += $head_sum;
                }
                $i++;
            }
            if(!in_array($head->head_id, $less_id)){
                $expense[$j]['particular'] = $head->head_name;
                $expense[$j]['amount'] = $head_sum;
                $expense_sum += $head_sum;
                $j++;
            }
            if(!in_array($head->head_id, $except)){
                $gross_expense += $head_sum;
            }

        }
        $j = 0;
        foreach($income_heads as $head){
            $sub_head_id = Chartofaccount::where('sister_concern_id', $sis_con)->where('head_id', $head->head_id)->where('sub_head_id','!=', 0)->pluck('sub_head_id')->toArray();
            if(!empty($from) && !empty($to)){
                $head_sum = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')) -
                    (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount'));
            }
            else{
                $head_sum = (CreditVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                    (CreditVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount'));
            }

            if(!in_array($head->head_id, $sales_id)){
                $income[$j]['particular'] = $head->head_name;
                $income[$j]['amount'] = $head_sum;
                $income_sum += $head_sum;
                $j++;
            }
        }

        $retained_earnings = ($sales - $cost_of_sale) - ($expense_sum + $income_sum);

        /*Retained Earnings End */

        return view('report.balance', compact('sister_concerns', 'sis_con','from','to','current_assets', 'non_current_assets','current_liabilities',  'non_current_liabilities', 'equities', 'retained_earnings'));
    }

    public function income_statement(){
        $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        $sis_con = null;
        $from = null;
        $to = null;
        $sales_id = [9,26,31,35,39.43];
        $except = [10,11,28,29,32,33,36,37,40,41,44,45];
        $less_id = [10,11,20,21,28,29,32,33,36,37,40,41,44,45];
        if(!empty($from) && !empty($to)){
            $sales =   (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount'));
        }
        else{
            $sales =   (CreditVoucher::whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + DebitVoucher::whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + Journal::whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                (CreditVoucher::whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + DebitVoucher::whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + Journal::whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount'));
        }

        $expense_heads = Chartofaccount::where('category', 'Expense')->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
        $income_heads = Chartofaccount::where('category', 'Income')->where('head_id', '!=', $sales_id)->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
        $check_less = array();
        $i = 0;
        $j = 0;
        $check_expense = array();
        $expense_sum = 0;
        $gross_expense = 0;
        $cost_of_sale = 0;
        $check_income = array();
        $income_sum = 0;
        foreach($expense_heads as $head){
            $sub_head_id = Chartofaccount::where('head_id', $head->head_id)->where('sub_head_id','!=', 0)->pluck('sub_head_id')->toArray();
            if(!empty($from) && !empty($to)){
                $head_sum = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')) -
                    (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount'));
            }
            else{
                $head_sum = (CreditVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')) -
                    (CreditVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount'));
            }
            if(in_array($head->head_id, $less_id)){
                $check_less[$i]['particular'] = $head->head_name;
                $check_less[$i]['amount'] = $head_sum;
                if($head->head_id == 21){
                    $cost_of_sale -= $head_sum;
                }
                else{
                    $cost_of_sale += $head_sum;
                }
                $i++;
            }
            if(!in_array($head->head_id, $less_id)){
                $check_expense[$j]['particular'] = $head->head_name;
                $check_expense[$j]['amount'] = $head_sum;
                $expense_sum += $head_sum;
                $j++;
            }
            if(!in_array($head->head_id, $except)){
                $gross_expense += $head_sum;
            }

        }
        $j = 0;
        foreach($income_heads as $head){
            $sub_head_id = Chartofaccount::where('head_id', $head->head_id)->where('sub_head_id','!=', 0)->pluck('sub_head_id')->toArray();
            if(!empty($from) && !empty($to)){
                $head_sum = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')) -
                    (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount'));
            }
            else{
                $head_sum = (CreditVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                    (CreditVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount'));
            }

            if(!in_array($head->head_id, $sales_id)){
                $check_income[$j]['particular'] = $head->head_name;
                $check_income[$j]['amount'] = $head_sum;
                $income_sum += $head_sum;
                $j++;
            }
        }
        for($i = 0 ; $i<count($check_less); $i++){
            $check = Accounting::where('particular', $check_less[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $check_less[$i]['particular'],
                    'amount' => $check_less[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $check_less[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $lesses = Accounting::all();
        Accounting::truncate();
        for($i = 0 ; $i<count($check_expense); $i++){
            $check = Accounting::where('particular', $check_expense[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $check_expense[$i]['particular'],
                    'amount' => $check_expense[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $check_expense[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $expenses = Accounting::all();
        Accounting::truncate();
        for($i = 0 ; $i<count($check_income); $i++){
            $check = Accounting::where('particular', $check_income[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $check_income[$i]['particular'],
                    'amount' => $check_income[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $check_income[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $incomes = Accounting::all();
        Accounting::truncate();

        return view('report.income_statement', compact('sister_concerns','sales', 'cost_of_sale', 'lesses', 'gross_expense','expenses', 'expense_sum', 'incomes', 'income_sum', 'from', 'to', 'sis_con' ));
    }
    public function income_statement_date_search(Request $request){
        $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        $sis_con = $request->sister_concern_id;
        $from = $request->date_from;
        $to = $request->date_to;

        if($sis_con == 1){
            $sales_id = [43];
            $except = [44,45];
            $less_id = [44,45];
        }
        if($sis_con == 3){
            $sales_id = [39];
            $except = [40,41];
            $less_id = [40,41];
        }
        if($sis_con == 4){
            $sales_id = [35];
            $except = [36,37];
            $less_id = [36,37];
        }
        if($sis_con == 5){
            $sales_id = [31];
            $except = [32,33];
            $less_id = [32,33];
        }
        if($sis_con == 9){
            $sales_id = [26];
            $except = [28,29];
            $less_id = [28,29];
        }
        if($sis_con == 10){
            $sales_id = [9];
            $except = [10,11];
            $less_id = [10,11,20,21];
        }
        if(!empty($from) && !empty($to)){
            $sales =   (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('sister_concern_id', $sis_con)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('sister_concern_id', $sis_con)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('sister_concern_id', $sis_con)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                    (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('sister_concern_id', $sis_con)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('sister_concern_id', $sis_con)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('sister_concern_id', $sis_con)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount'));
        }
        else{
            $sales =   (CreditVoucher::where('sister_concern_id', $sis_con)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + DebitVoucher::where('sister_concern_id', $sis_con)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')
                    + Journal::where('sister_concern_id', $sis_con)->whereIn('credit_id', $sales_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                (CreditVoucher::where('sister_concern_id', $sis_con)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + DebitVoucher::where('sister_concern_id', $sis_con)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount')
                    + Journal::where('sister_concern_id', $sis_con)->whereIn('debit_id', $sales_id)->orderBy('date', 'DESC')->sum('debit_amount'));
        }

        $expense_heads = Chartofaccount::where('sister_concern_id', $sis_con)->where('category', 'Expense')->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
        $income_heads = Chartofaccount::where('sister_concern_id', $sis_con)->where('category', 'Income')->where('head_id', '!=', $sales_id)->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();

        $less = array();
        $i = 0;
        $j = 0;
        $expense = array();
        $expense_sum = 0;
        $gross_expense = 0;
        $cost_of_sale = 0;
        $income = array();
        $income_sum = 0;
        foreach($expense_heads as $head){
            $sub_head_id = Chartofaccount::where('sister_concern_id', $sis_con)->where('head_id', $head->head_id)->where('sub_head_id','!=', 0)->pluck('sub_head_id')->toArray();
            if(!empty($from) && !empty($to)){
                $head_sum = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')) -
                    (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount'));
            }
            else{
                $head_sum = (CreditVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')) -
                    (CreditVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount'));
            }
            if(in_array($head->head_id, $less_id)){
                $less[$i]['particular'] = $head->head_name;
                $less[$i]['amount'] = $head_sum;
                if($head->head_id == 21){
                    $cost_of_sale -= $head_sum;
                }
                else{
                    $cost_of_sale += $head_sum;
                }
                $i++;
            }
            if(!in_array($head->head_id, $less_id)){
                $expense[$j]['particular'] = $head->head_name;
                $expense[$j]['amount'] = $head_sum;
                $expense_sum += $head_sum;
                $j++;
            }
            if(!in_array($head->head_id, $except)){
                $gross_expense += $head_sum;
            }

        }
        $j = 0;
        foreach($income_heads as $head){
            $sub_head_id = Chartofaccount::where('sister_concern_id', $sis_con)->where('head_id', $head->head_id)->where('sub_head_id','!=', 0)->pluck('sub_head_id')->toArray();
            if(!empty($from) && !empty($to)){
                $head_sum = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')) -
                    (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount'));
            }
            else{
                $head_sum = (CreditVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + DebitVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + Journal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                        + ContraJournal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                    (CreditVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + DebitVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + Journal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                        + ContraJournal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount'));
            }

            if(!in_array($head->head_id, $sales_id)){
                $income[$j]['particular'] = $head->head_name;
                $income[$j]['amount'] = $head_sum;
                $income_sum += $head_sum;
                $j++;
            }
        }
        return view('report.income_statement', compact('sister_concerns','sales', 'cost_of_sale', 'less', 'gross_expense','expense', 'expense_sum', 'income', 'income_sum', 'from', 'to', 'sis_con' ));
    }

    public function equity_statement(){
        $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        $heads = null ;
        $from = null ;
        $to = null ;
        $sis_con = null ;
        $total = 0;
        return view('report.equity_statement', compact('sister_concerns', 'heads', 'from', 'to', 'sis_con', 'total'));
    }
    public function equity_statement_date_search(Request $request){
        $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        $from = $request->date_from;
        $to = $request->date_to;;
        $sis_con = $request->sister_concern_id;
        $total = 0;
        $heads = Chartofaccount::where('sister_concern_id', $sis_con)->where('category', 'Equity')->where('sub_head_id', 0)->orderBy('id', 'DESC')->get();
        return view('report.equity_statement', compact('sister_concerns', 'heads', 'from', 'to', 'sis_con', 'total'));
    }

    public function cash_flow_statement(){
        $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        $company = null;
        $from = null;
        $to = null;
        $cash_id = [3,13,14,15,16,17];
        $bank_id_list = Bank::orderBy('id', 'DESC')->pluck('ledger_id')->toArray();
        $bank_id = Chartofaccount::whereIn('head_id', $bank_id_list)->where('sub_head_id', '!=', 0)->pluck('sub_head_id')->toArray();
        $cash_in_hand =     (CreditVoucher::whereIn('debit_id', $cash_id)->sum('debit_amount')
                            + DebitVoucher::whereIn('debit_id', $cash_id)->sum('debit_amount')
                            + ContraJournal::whereIn('debit_id', $cash_id)->sum('debit_amount'))
                            - (CreditVoucher::whereIn('credit_id', $cash_id)->sum('credit_amount')
                            + DebitVoucher::whereIn('credit_id', $cash_id)->sum('credit_amount')
                            + ContraJournal::whereIn('credit_id', $cash_id)->sum('credit_amount'));

        $cv_cr_cash_id = CreditVoucher::whereIn('debit_id', $cash_id)->distinct('credit_id')->pluck('credit_id')->toArray();
        $dv_cr_cash_id = DebitVoucher::whereIn('debit_id', $cash_id)->distinct('credit_id')->pluck('credit_id')->toArray();
        $cjv_cr_cash_id = ContraJournal::whereIn('debit_id', $cash_id)->distinct('credit_id')->pluck('credit_id')->toArray();

        $cv_dr_cash_id = CreditVoucher::whereIn('credit_id', $cash_id)->distinct('debit_id')->pluck('debit_id')->toArray();
        $dv_dr_cash_id = DebitVoucher::whereIn('credit_id', $cash_id)->distinct('debit_id')->pluck('debit_id')->toArray();
        $cjv_dr_cash_id = ContraJournal::whereIn('credit_id', $cash_id)->distinct('debit_id')->pluck('debit_id')->toArray();

        $cash_received_id = array_merge($cv_cr_cash_id, $dv_cr_cash_id,$cjv_cr_cash_id);
        $cash_received = array();
        for($i=0 ; $i<count($cash_received_id) ; $i++){
            $cash_received[$i]['particular'] = (!empty($chart = Chartofaccount::where('head_id', $cash_received_id[$i])->where('sub_head_id', 0)->first()) ? $chart->head_name : (!empty($chart = Chartofaccount::where('sub_head_id', $cash_received_id[$i])->where('sub_head_id', '!=', 0)->first()) ? $chart->sub_head_name : 'N/A'));
            $cash_received[$i]['amount'] = (CreditVoucher::whereIn('debit_id', $cash_id)->where('credit_id', $cash_received_id[$i])->sum('debit_amount')
                + DebitVoucher::whereIn('debit_id', $cash_id)->where('credit_id', $cash_received_id[$i])->sum('debit_amount')
                + ContraJournal::whereIn('debit_id', $cash_id)->where('credit_id', $cash_received_id[$i])->sum('debit_amount'));
        }

        for($i = 0 ; $i<count($cash_received); $i++){
            $check = Accounting::where('particular', $cash_received[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $cash_received[$i]['particular'],
                    'amount' => $cash_received[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $cash_received[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $cash_receiveds = Accounting::all();
        Accounting::truncate();


        $cash_paid_id = array_merge($cv_dr_cash_id, $dv_dr_cash_id,$cjv_dr_cash_id);
        $cash_paid = array();
        for($i=0 ; $i<count($cash_paid_id) ; $i++){
            $cash_paid[$i]['particular'] = (!empty($chart = Chartofaccount::where('head_id', $cash_paid_id[$i])->where('sub_head_id', 0)->first()) ? $chart->head_name : (!empty($chart = Chartofaccount::where('sub_head_id', $cash_paid_id[$i])->where('sub_head_id', '!=', 0)->first()) ? $chart->sub_head_name : 'N/A'));
            $cash_paid[$i]['amount'] = (CreditVoucher::whereIn('credit_id', $cash_id)->where('debit_id', $cash_paid_id[$i])->sum('debit_amount')
                + DebitVoucher::whereIn('credit_id', $cash_id)->where('debit_id', $cash_paid_id[$i])->sum('debit_amount')
                + ContraJournal::whereIn('credit_id', $cash_id)->where('debit_id', $cash_paid_id[$i])->sum('debit_amount'));
        }

        for($i = 0 ; $i<count($cash_paid); $i++){
            $check = Accounting::where('particular', $cash_paid[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $cash_paid[$i]['particular'],
                    'amount' => $cash_paid[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $cash_paid[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $cash_paids = Accounting::all();
        Accounting::truncate();

        $cv_cr_bank_id = CreditVoucher::whereIn('debit_id', $bank_id)->distinct('credit_id')->pluck('credit_id')->toArray();
        $dv_cr_bank_id = DebitVoucher::whereIn('debit_id', $bank_id)->distinct('credit_id')->pluck('credit_id')->toArray();
        $cjv_cr_bank_id = ContraJournal::whereIn('debit_id', $bank_id)->distinct('credit_id')->pluck('credit_id')->toArray();

        $cv_dr_bank_id = CreditVoucher::whereIn('credit_id', $bank_id)->distinct('debit_id')->pluck('debit_id')->toArray();
        $dv_dr_bank_id = DebitVoucher::whereIn('credit_id', $bank_id)->distinct('debit_id')->pluck('debit_id')->toArray();
        $cjv_dr_bank_id = ContraJournal::whereIn('credit_id', $bank_id)->distinct('debit_id')->pluck('debit_id')->toArray();

        $bank_received_id = array_merge($cv_cr_bank_id, $dv_cr_bank_id,$cjv_cr_bank_id);
        $bank_received_total = 0;
        $bank_received = array();
        for($i=0 ; $i<count($bank_received_id) ; $i++){
            $bank_received[$i]['particular'] = (!empty($chart = Chartofaccount::where('head_id', $bank_received_id[$i])->where('sub_head_id', 0)->first()) ? $chart->head_name : (!empty($chart = Chartofaccount::where('sub_head_id', $bank_received_id[$i])->where('sub_head_id', '!=', 0)->first()) ? $chart->sub_head_name : 'N/A'));
            $bank_received[$i]['amount'] = (CreditVoucher::whereIn('debit_id', $bank_id)->where('credit_id', $bank_received_id[$i])->sum('debit_amount')
                + DebitVoucher::whereIn('debit_id', $bank_id)->where('credit_id', $bank_received_id[$i])->sum('debit_amount')
                + ContraJournal::whereIn('debit_id', $bank_id)->where('credit_id', $bank_received_id[$i])->sum('debit_amount'));
            $bank_received_total += $bank_received[$i]['amount'];
        }

        for($i = 0 ; $i<count($bank_received); $i++){
            $check = Accounting::where('particular', $bank_received[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $bank_received[$i]['particular'],
                    'amount' => $bank_received[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $bank_received[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $bank_receiveds = Accounting::all();
        Accounting::truncate();

        $bank_paid_id = array_merge($cv_dr_bank_id, $dv_dr_bank_id,$cjv_dr_bank_id);
        $bank_paid_total = 0;
        $bank_paid = array();
        for($i=0 ; $i<count($bank_paid_id) ; $i++){
            $bank_paid[$i]['particular'] = (!empty($chart = Chartofaccount::where('head_id', $bank_paid_id[$i])->where('sub_head_id', 0)->first()) ? $chart->head_name : (!empty($chart = Chartofaccount::where('sub_head_id', $bank_paid_id[$i])->where('sub_head_id', '!=', 0)->first()) ? $chart->sub_head_name : 'N/A'));
            $bank_paid[$i]['amount'] = (CreditVoucher::whereIn('credit_id', $bank_id)->where('debit_id', $bank_paid_id[$i])->sum('debit_amount')
                + DebitVoucher::whereIn('credit_id', $bank_id)->where('debit_id', $bank_paid_id[$i])->sum('debit_amount')
                + ContraJournal::whereIn('credit_id', $bank_id)->where('debit_id', $bank_paid_id[$i])->sum('debit_amount'));
            $bank_paid_total += $bank_paid[$i]['amount'];
        }

        for($i = 0 ; $i<count($bank_paid); $i++){
            $check = Accounting::where('particular', $bank_paid[$i]['particular'])->first();
            if(empty($check)){
                Accounting::create([
                    'particular' => $bank_paid[$i]['particular'],
                    'amount' => $bank_paid[$i]['amount'],
                ]);
            }else{
                $total = $check->amount + $bank_paid[$i]['amount'];
                $check->update([
                    'amount' => $total,
                ]);
            }
        }
        $bank_paids = Accounting::all();
        Accounting::truncate();

        return view('report.cash_flow_statement', compact('sister_concerns','cash_in_hand', 'cash_receiveds',
           'cash_paids', 'bank_receiveds', 'bank_paids', 'company', 'from', 'to'));
    }
    public function cash_flow_statement_search(Request $request){
        $sister_concerns = SisterConcern::orderBy('id', 'DESC')->get();
        $company = SisterConcern::find($request->sister_concern_id);
        if($request->date_from == null && $request->date_to == null){
            $from = '2000-01-01';
            $to = date('Y-m-d');
        }
        elseif($request->date_from != null && $request->date_to == null){
            $from = $request->date_from;
            $to = date('Y-m-d');
        }
        elseif($request->date_from == null && $request->date_to != null){
            $from = '2000-01-01';
            $to = $request->date_to;
        }
        else{
            $from = $request->date_from;
            $to = $request->date_to;
        }


        if($company->id == 1){
            $cash_id = [17];
        }
        if($company->id == 3){
            $cash_id = [16];
        }
        if($company->id == 4){
            $cash_id = [15];
        }
        if($company->id == 5){
            $cash_id = [14];
        }
        if($company->id == 9){
            $cash_id = [13];
        }
        if($company->id == 10){
            $cash_id = [3];
        }
        $bank_id_list = Bank::where('sister_concern_id', $company->id)->orderBy('id', 'DESC')->pluck('ledger_id')->toArray();
        $bank_id = Chartofaccount::where('sister_concern_id', $company->id)->whereIn('head_id', $bank_id_list)->where('sub_head_id', '!=', 0)->pluck('sub_head_id')->toArray();

        if(!empty($from) && !empty($to)){
            $cash_in_hand =     (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $cash_id)->sum('debit_amount')
                    + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $cash_id)->sum('debit_amount')
                    + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $cash_id)->sum('debit_amount'))
                - (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $cash_id)->sum('debit_amount')
                    + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $cash_id)->sum('debit_amount')
                    + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $cash_id)->sum('debit_amount'));

            $cv_cr_cash_id = CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $cash_id)->distinct('credit_id')->pluck('credit_id')->toArray();
            $dv_cr_cash_id = DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $cash_id)->distinct('credit_id')->pluck('credit_id')->toArray();
            $cjv_cr_cash_id = ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $cash_id)->distinct('credit_id')->pluck('credit_id')->toArray();

            $cv_dr_cash_id = CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $cash_id)->distinct('debit_id')->pluck('debit_id')->toArray();
            $dv_dr_cash_id = DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $cash_id)->distinct('debit_id')->pluck('debit_id')->toArray();
            $cjv_dr_cash_id = ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $cash_id)->distinct('debit_id')->pluck('debit_id')->toArray();

            $cash_received_id = array_merge($cv_cr_cash_id, $dv_cr_cash_id,$cjv_cr_cash_id);
            $cash_received = array();
            for($i=0 ; $i<count($cash_received_id) ; $i++){
                $cash_received[$i]['particular'] = (!empty($chart = Chartofaccount::where('head_id', $cash_received_id[$i])->where('sub_head_id', 0)->first()) ? $chart->head_name : (!empty($chart = Chartofaccount::where('sub_head_id', $cash_received_id[$i])->where('sub_head_id', '!=', 0)->first()) ? $chart->sub_head_name : 'N/A'));
                $cash_received[$i]['amount'] = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $cash_id)->where('credit_id', $cash_received_id[$i])->sum('debit_amount')
                    + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $cash_id)->where('credit_id', $cash_received_id[$i])->sum('debit_amount')
                    + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $cash_id)->where('credit_id', $cash_received_id[$i])->sum('debit_amount'));
            }

            for($i = 0 ; $i<count($cash_received); $i++){
                $check = Accounting::where('particular', $cash_received[$i]['particular'])->first();
                if(empty($check)){
                    Accounting::create([
                        'particular' => $cash_received[$i]['particular'],
                        'amount' => $cash_received[$i]['amount'],
                    ]);
                }else{
                    $total = $check->amount + $cash_received[$i]['amount'];
                    $check->update([
                        'amount' => $total,
                    ]);
                }
            }
            $cash_receiveds = Accounting::all();
            Accounting::truncate();


            $cash_paid_id = array_merge($cv_dr_cash_id, $dv_dr_cash_id,$cjv_dr_cash_id);
            $cash_paid = array();
            for($i=0 ; $i<count($cash_paid_id) ; $i++){
                $cash_paid[$i]['particular'] = (!empty($chart = Chartofaccount::where('head_id', $cash_paid_id[$i])->where('sub_head_id', 0)->first()) ? $chart->head_name : (!empty($chart = Chartofaccount::where('sub_head_id', $cash_paid_id[$i])->where('sub_head_id', '!=', 0)->first()) ? $chart->sub_head_name : 'N/A'));
                $cash_paid[$i]['amount'] = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $cash_id)->where('debit_id', $cash_paid_id[$i])->sum('debit_amount')
                    + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $cash_id)->where('debit_id', $cash_paid_id[$i])->sum('debit_amount')
                    + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $cash_id)->where('debit_id', $cash_paid_id[$i])->sum('debit_amount'));
            }

            for($i = 0 ; $i<count($cash_paid); $i++){
                $check = Accounting::where('particular', $cash_paid[$i]['particular'])->first();
                if(empty($check)){
                    Accounting::create([
                        'particular' => $cash_paid[$i]['particular'],
                        'amount' => $cash_paid[$i]['amount'],
                    ]);
                }else{
                    $total = $check->amount + $cash_paid[$i]['amount'];
                    $check->update([
                        'amount' => $total,
                    ]);
                }
            }
            $cash_paids = Accounting::all();
            Accounting::truncate();

            $cv_cr_bank_id = CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $bank_id)->distinct('credit_id')->pluck('credit_id')->toArray();
            $dv_cr_bank_id = DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $bank_id)->distinct('credit_id')->pluck('credit_id')->toArray();
            $cjv_cr_bank_id = ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $bank_id)->distinct('credit_id')->pluck('credit_id')->toArray();

            $cv_dr_bank_id = CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $bank_id)->distinct('debit_id')->pluck('debit_id')->toArray();
            $dv_dr_bank_id = DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $bank_id)->distinct('debit_id')->pluck('debit_id')->toArray();
            $cjv_dr_bank_id = ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $bank_id)->distinct('debit_id')->pluck('debit_id')->toArray();

            $bank_received_id = array_merge($cv_cr_bank_id, $dv_cr_bank_id,$cjv_cr_bank_id);
            $bank_received_total = 0;
            $bank_received = array();
            for($i=0 ; $i<count($bank_received_id) ; $i++){
                $bank_received[$i]['particular'] = (!empty($chart = Chartofaccount::where('head_id', $bank_received_id[$i])->where('sub_head_id', 0)->first()) ? $chart->head_name : (!empty($chart = Chartofaccount::where('sub_head_id', $bank_received_id[$i])->where('sub_head_id', '!=', 0)->first()) ? $chart->sub_head_name : 'N/A'));
                $bank_received[$i]['amount'] = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $bank_id)->where('credit_id', $bank_received_id[$i])->sum('debit_amount')
                    + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $bank_id)->where('credit_id', $bank_received_id[$i])->sum('debit_amount')
                    + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('debit_id', $bank_id)->where('credit_id', $bank_received_id[$i])->sum('debit_amount'));
                $bank_received_total += $bank_received[$i]['amount'];
            }

            for($i = 0 ; $i<count($bank_received); $i++){
                $check = Accounting::where('particular', $bank_received[$i]['particular'])->first();
                if(empty($check)){
                    Accounting::create([
                        'particular' => $bank_received[$i]['particular'],
                        'amount' => $bank_received[$i]['amount'],
                    ]);
                }else{
                    $total = $check->amount + $bank_received[$i]['amount'];
                    $check->update([
                        'amount' => $total,
                    ]);
                }
            }
            $bank_receiveds = Accounting::all();
            Accounting::truncate();

            $bank_paid_id = array_merge($cv_dr_bank_id, $dv_dr_bank_id,$cjv_dr_bank_id);
            $bank_paid_total = 0;
            $bank_paid = array();
            for($i=0 ; $i<count($bank_paid_id) ; $i++){
                $bank_paid[$i]['particular'] = (!empty($chart = Chartofaccount::where('head_id', $bank_paid_id[$i])->where('sub_head_id', 0)->first()) ? $chart->head_name : (!empty($chart = Chartofaccount::where('sub_head_id', $bank_paid_id[$i])->where('sub_head_id', '!=', 0)->first()) ? $chart->sub_head_name : 'N/A'));
                $bank_paid[$i]['amount'] = (CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $bank_id)->where('debit_id', $bank_paid_id[$i])->sum('debit_amount')
                    + DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $bank_id)->where('debit_id', $bank_paid_id[$i])->sum('debit_amount')
                    + ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->whereIn('credit_id', $bank_id)->where('debit_id', $bank_paid_id[$i])->sum('debit_amount'));
                $bank_paid_total += $bank_paid[$i]['amount'];
            }

            for($i = 0 ; $i<count($bank_paid); $i++){
                $check = Accounting::where('particular', $bank_paid[$i]['particular'])->first();
                if(empty($check)){
                    Accounting::create([
                        'particular' => $bank_paid[$i]['particular'],
                        'amount' => $bank_paid[$i]['amount'],
                    ]);
                }else{
                    $total = $check->amount + $bank_paid[$i]['amount'];
                    $check->update([
                        'amount' => $total,
                    ]);
                }
            }
            $bank_paids = Accounting::all();
            Accounting::truncate();
        }
        else{
            $cash_in_hand =     (CreditVoucher::whereIn('debit_id', $cash_id)->sum('debit_amount')
                    + DebitVoucher::whereIn('debit_id', $cash_id)->sum('debit_amount')
                    + ContraJournal::whereIn('debit_id', $cash_id)->sum('debit_amount'))
                - (CreditVoucher::whereIn('credit_id', $cash_id)->sum('debit_amount')
                    + DebitVoucher::whereIn('credit_id', $cash_id)->sum('debit_amount')
                    + ContraJournal::whereIn('credit_id', $cash_id)->sum('debit_amount'));

            $cv_cr_cash_id = CreditVoucher::whereIn('debit_id', $cash_id)->distinct('credit_id')->pluck('credit_id')->toArray();
            $dv_cr_cash_id = DebitVoucher::whereIn('debit_id', $cash_id)->distinct('credit_id')->pluck('credit_id')->toArray();
            $cjv_cr_cash_id = ContraJournal::whereIn('debit_id', $cash_id)->distinct('credit_id')->pluck('credit_id')->toArray();

            $cv_dr_cash_id = CreditVoucher::whereIn('credit_id', $cash_id)->distinct('debit_id')->pluck('debit_id')->toArray();
            $dv_dr_cash_id = DebitVoucher::whereIn('credit_id', $cash_id)->distinct('debit_id')->pluck('debit_id')->toArray();
            $cjv_dr_cash_id = ContraJournal::whereIn('credit_id', $cash_id)->distinct('debit_id')->pluck('debit_id')->toArray();

            $cash_received_id = array_merge($cv_cr_cash_id, $dv_cr_cash_id,$cjv_cr_cash_id);
            $cash_received = array();
            for($i=0 ; $i<count($cash_received_id) ; $i++){
                $cash_received[$i]['particular'] = (!empty($chart = Chartofaccount::where('head_id', $cash_received_id[$i])->where('sub_head_id', 0)->first()) ? $chart->head_name : (!empty($chart = Chartofaccount::where('sub_head_id', $cash_received_id[$i])->where('sub_head_id', '!=', 0)->first()) ? $chart->sub_head_name : 'N/A'));
                $cash_received[$i]['amount'] = (CreditVoucher::whereIn('debit_id', $cash_id)->where('credit_id', $cash_received_id[$i])->sum('debit_amount')
                    + DebitVoucher::whereIn('debit_id', $cash_id)->where('credit_id', $cash_received_id[$i])->sum('debit_amount')
                    + ContraJournal::whereIn('debit_id', $cash_id)->where('credit_id', $cash_received_id[$i])->sum('debit_amount'));
            }

            for($i = 0 ; $i<count($cash_received); $i++){
                $check = Accounting::where('particular', $cash_received[$i]['particular'])->first();
                if(empty($check)){
                    Accounting::create([
                        'particular' => $cash_received[$i]['particular'],
                        'amount' => $cash_received[$i]['amount'],
                    ]);
                }else{
                    $total = $check->amount + $cash_received[$i]['amount'];
                    $check->update([
                        'amount' => $total,
                    ]);
                }
            }
            $cash_receiveds = Accounting::all();
            Accounting::truncate();


            $cash_paid_id = array_merge($cv_dr_cash_id, $dv_dr_cash_id,$cjv_dr_cash_id);
            $cash_paid = array();
            for($i=0 ; $i<count($cash_paid_id) ; $i++){
                $cash_paid[$i]['particular'] = (!empty($chart = Chartofaccount::where('head_id', $cash_paid_id[$i])->where('sub_head_id', 0)->first()) ? $chart->head_name : (!empty($chart = Chartofaccount::where('sub_head_id', $cash_paid_id[$i])->where('sub_head_id', '!=', 0)->first()) ? $chart->sub_head_name : 'N/A'));
                $cash_paid[$i]['amount'] = (CreditVoucher::whereIn('credit_id', $cash_id)->where('debit_id', $cash_paid_id[$i])->sum('debit_amount')
                    + DebitVoucher::whereIn('credit_id', $cash_id)->where('debit_id', $cash_paid_id[$i])->sum('debit_amount')
                    + ContraJournal::whereIn('credit_id', $cash_id)->where('debit_id', $cash_paid_id[$i])->sum('debit_amount'));
            }

            for($i = 0 ; $i<count($cash_paid); $i++){
                $check = Accounting::where('particular', $cash_paid[$i]['particular'])->first();
                if(empty($check)){
                    Accounting::create([
                        'particular' => $cash_paid[$i]['particular'],
                        'amount' => $cash_paid[$i]['amount'],
                    ]);
                }else{
                    $total = $check->amount + $cash_paid[$i]['amount'];
                    $check->update([
                        'amount' => $total,
                    ]);
                }
            }
            $cash_paids = Accounting::all();
            Accounting::truncate();

            $cv_cr_bank_id = CreditVoucher::whereIn('debit_id', $bank_id)->distinct('credit_id')->pluck('credit_id')->toArray();
            $dv_cr_bank_id = DebitVoucher::whereIn('debit_id', $bank_id)->distinct('credit_id')->pluck('credit_id')->toArray();
            $cjv_cr_bank_id = ContraJournal::whereIn('debit_id', $bank_id)->distinct('credit_id')->pluck('credit_id')->toArray();

            $cv_dr_bank_id = CreditVoucher::whereIn('credit_id', $bank_id)->distinct('debit_id')->pluck('debit_id')->toArray();
            $dv_dr_bank_id = DebitVoucher::whereIn('credit_id', $bank_id)->distinct('debit_id')->pluck('debit_id')->toArray();
            $cjv_dr_bank_id = ContraJournal::whereIn('credit_id', $bank_id)->distinct('debit_id')->pluck('debit_id')->toArray();

            $bank_received_id = array_merge($cv_cr_bank_id, $dv_cr_bank_id,$cjv_cr_bank_id);
            $bank_received_total = 0;
            $bank_received = array();
            for($i=0 ; $i<count($bank_received_id) ; $i++){
                $bank_received[$i]['particular'] = (!empty($chart = Chartofaccount::where('head_id', $bank_received_id[$i])->where('sub_head_id', 0)->first()) ? $chart->head_name : (!empty($chart = Chartofaccount::where('sub_head_id', $bank_received_id[$i])->where('sub_head_id', '!=', 0)->first()) ? $chart->sub_head_name : 'N/A'));
                $bank_received[$i]['amount'] = (CreditVoucher::whereIn('debit_id', $bank_id)->where('credit_id', $bank_received_id[$i])->sum('debit_amount')
                    + DebitVoucher::whereIn('debit_id', $bank_id)->where('credit_id', $bank_received_id[$i])->sum('debit_amount')
                    + ContraJournal::whereIn('debit_id', $bank_id)->where('credit_id', $bank_received_id[$i])->sum('debit_amount'));
                $bank_received_total += $bank_received[$i]['amount'];
            }

            for($i = 0 ; $i<count($bank_received); $i++){
                $check = Accounting::where('particular', $bank_received[$i]['particular'])->first();
                if(empty($check)){
                    Accounting::create([
                        'particular' => $bank_received[$i]['particular'],
                        'amount' => $bank_received[$i]['amount'],
                    ]);
                }else{
                    $total = $check->amount + $bank_received[$i]['amount'];
                    $check->update([
                        'amount' => $total,
                    ]);
                }
            }
            $bank_receiveds = Accounting::all();
            Accounting::truncate();

            $bank_paid_id = array_merge($cv_dr_bank_id, $dv_dr_bank_id,$cjv_dr_bank_id);
            $bank_paid_total = 0;
            $bank_paid = array();
            for($i=0 ; $i<count($bank_paid_id) ; $i++){
                $bank_paid[$i]['particular'] = (!empty($chart = Chartofaccount::where('head_id', $bank_paid_id[$i])->where('sub_head_id', 0)->first()) ? $chart->head_name : (!empty($chart = Chartofaccount::where('sub_head_id', $bank_paid_id[$i])->where('sub_head_id', '!=', 0)->first()) ? $chart->sub_head_name : 'N/A'));
                $bank_paid[$i]['amount'] = (CreditVoucher::whereIn('credit_id', $bank_id)->where('debit_id', $bank_paid_id[$i])->sum('debit_amount')
                    + DebitVoucher::whereIn('credit_id', $bank_id)->where('debit_id', $bank_paid_id[$i])->sum('debit_amount')
                    + ContraJournal::whereIn('credit_id', $bank_id)->where('debit_id', $bank_paid_id[$i])->sum('debit_amount'));
                $bank_paid_total += $bank_paid[$i]['amount'];
            }

            for($i = 0 ; $i<count($bank_paid); $i++){
                $check = Accounting::where('particular', $bank_paid[$i]['particular'])->first();
                if(empty($check)){
                    Accounting::create([
                        'particular' => $bank_paid[$i]['particular'],
                        'amount' => $bank_paid[$i]['amount'],
                    ]);
                }else{
                    $total = $check->amount + $bank_paid[$i]['amount'];
                    $check->update([
                        'amount' => $total,
                    ]);
                }
            }
            $bank_paids = Accounting::all();
            Accounting::truncate();
        }

        return view('report.cash_flow_statement', compact('sister_concerns','cash_in_hand', 'cash_receiveds',
            'cash_paids', 'bank_receiveds', 'bank_paids', 'company', 'from', 'to'));
    }
}
