@extends('master')
@section('report','active') @section('report-show','show') @section('equity_statement-report','active')
@section('content')
    <div class="col-sm-12 text-center text-info"><h2>Equity Statement <hr/></h2></div>
    <br/>
    <div class="col-lg-12">
        {!! Form::open(['route' => 'report.equity_statement_date_search','method' => 'GET']) !!}
        <div class="row text-center">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="sister_concern_id">Sister Concern</label>
                    <select class="form-control selectpicker" data-live-search="true" name="sister_concern_id" id="sister_concern_id" required>
                        <option selected disabled value="">choose an option</option>
                        @foreach($sister_concerns as $sister_concern)
                            <option value="{{ $sister_concern->id}}">{{$sister_concern->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="age">Date From</label>
                    <input type="date" class="form-control" id="date_from" name="date_from">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="age">Date To</label>
                    <input type="date" class="form-control" id="date_to" name="date_to">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="none"></label>
                    <button class="btn custom_button btn-lg btn-block form-control" id="search_balance">Search</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div id="printPeriod_income">
                    <br/><br/><br/>
                    <div class="row text-center">
                        <div class="col-sm-12"><h3> {{($sis_con != null) ? \App\SisterConcern::find($sis_con)->name : 'Nahid Group'}} Equity Statement</h3><hr/></div>
                        <br/>
                        @if(empty($from))
                            <div class="col-sm-12 text-center text-primary"><h3>as 31 Dec' {{date('Y')}}</h3></div>
                        @else
                            <div class="col-sm-12 text-center text-primary"><h4>{{date('F-d-Y', strtotime($from))}} &nbsp; - &nbsp;{{date('F-d-Y', strtotime($to))}}</h4></div>
                        @endif
                        <div class="col-sm-12"><h3 class="text-danger"> {{($sis_con != null) ? ' ' : 'Select Sister Concern'}}<h3/></div>
                    </div>
                    <br/><br/><br/>
                    @if($sis_con != null)
                    @foreach($heads as $head)
                            @php
                                $sub_head_id = \App\Chartofaccount::where('sister_concern_id', $sis_con)->where('head_id', $head->head_id)->where('sub_head_id','!=', 0)->pluck('sub_head_id')->toArray();
                              if(!empty($from) && !empty($to)){
                                  $head_sum = (\App\CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                                                 + \App\DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                                                 + \App\Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')
                                                 + \App\ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('credit_amount')) -
                                                   (\App\CreditVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                                                 + \App\DebitVoucher::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                                                 + \App\Journal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount')
                                                 + \App\ContraJournal::whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('date', 'DESC')->sum('debit_amount'));
                              }
                              else{
                                  $head_sum = (\App\CreditVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                                                 + \App\DebitVoucher::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                                                 + \App\Journal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')
                                                 + \App\ContraJournal::where('credit_id', $head->head_id)->orWhereIn('credit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('credit_amount')) -
                                                   (\App\CreditVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                                                 + \App\DebitVoucher::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                                                 + \App\Journal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount')
                                                 + \App\ContraJournal::where('debit_id', $head->head_id)->orWhereIn('debit_id', $sub_head_id)->orderBy('date', 'DESC')->sum('debit_amount'));
                              }


                              $total += $head_sum;
                            @endphp
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-5"><h4>{{$head->head_name}}</h4></div>
                        <div class="col-sm-2">:</div>
                        <div class="col-sm-4"><h4>{{number_format($head_sum)}}</h4></div>
                    </div>
                    <hr/>
                    @endforeach
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4"><h3>Net Profit</h3></div>
                            <div class="col-sm-2">:</div>
                            <div class="col-sm-4"><h3>{{number_format($total)}}</h3></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="form-group">
                    <br/>
                    <input type="button" class="print_button btn-gradient-primary btn-block form-control" onclick="printDiv('printPeriod_income')" value="Print" />
                </div>
            </div>
        </div>
    </div>
@endsection
