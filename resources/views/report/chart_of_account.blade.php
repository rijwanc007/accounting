@extends('master')
@section('report','active') @section('report-show','show') @section('report','active') @section('report-show','show') @section('chart_of_account-report','active')
@php
    $dr_sum=0;
    $cr_sum=0;
    $sub_head_sum = 0;
    $sub_head_dr = 0;
    $sub_head_cr = 0;
    $sub_head_dr_prev = 0;
    $sub_head_cr_prev = 0;
@endphp
@section('content')
    <div class="col-lg-12">
        {!! Form::open(['route' => 'report.chart_of_account_date_search','method' => 'GET']) !!}
        <div class="row text-center">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="age">Date From</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="age">Date To</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="none"></label>
                    <button class="btn custom_button btn-lg btn-block form-control" id="search_balance">Search</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <br/>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div id="chart_of_account">
                    <br/><br/><br/>
                    <div class="col-sm-12 text-center text-info"><h2>Chart Of Accounts </h2><hr/></div>
                    <div class="col-sm-12 text-center text-info"><h4> As @if(!empty($from)) {{$from}} To @endif {{$to}} <hr/></h4></div>
                    <br/>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                            <tr class="text-center">
                                <th>Particulars</th>
                                <th>Opening</th>
                                <th>DR</th>
                                <th>CR</th>
                                <th>Closing</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($heads as $head)
                                <tr>
{{--                                    @if($head->id == 6)--}}
{{--                                        <td colspan="4"><h3 class="text-center">{{$head->head_name}}</h3></td>--}}
{{--                                        <td ><h3 class="text-center">{{number_format($revenue_from_service_amount)}}.00</h3></td>--}}
{{--                                    @else--}}
                                        <td colspan="5"><h3 class="text-center">{{$head->head_name}}</h3></td>
{{--                                    @endif--}}
                                </tr>
                                @foreach($sub_heads as $sub_head)
                                    @if($sub_head->head_id == $head->id)
                                        @foreach($child_heads as $child_head)
                                            @if($child_head->sub_head_id == $sub_head->id)
                                                <tr class="text-center">
                                                    <td>{{$child_head->child_head_name}}</td>
                                                    <td>
                                                        @if(empty($from))
                                                            {{0}}.00
                                                        @else
                                                            @foreach($prev_administratives as $administrative)
                                                                @if($administrative->child_head_id == $child_head->id)
                                                                    @php
                                                                        $dr_sum += $administrative->debit_amount;
                                                                    @endphp
                                                                @endif
                                                                @if(($child_head->id == 27) && $administrative->mode_of_payment_name == 'cash')
                                                                    @php
                                                                        $cr_sum += $administrative->credit_amount;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            @foreach($prev_financings as $financing)
                                                                @if($financing->child_head_id == $child_head->id)
                                                                    @php
                                                                        $dr_sum += $financing->debit_amount;
                                                                    @endphp
                                                                @endif
                                                                @if(($child_head->id == 27) && $financing->mode_of_payment_name == 'cash')
                                                                    @php
                                                                        $cr_sum += $financing->credit_amount;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            @foreach($prev_marketings as $marketing)
                                                                @if($marketing->child_head_id == $child_head->id)
                                                                    @php
                                                                        $dr_sum += $marketing->debit_amount;
                                                                    @endphp
                                                                @endif
                                                                @if(($child_head->id == 27) && $marketing->mode_of_payment_name == 'cash')
                                                                    @php
                                                                        $cr_sum += $marketing->credit_amount;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            @foreach($prev_journals as $journal)
                                                                @if($journal->dr_child_head == $child_head->id)
                                                                    @php
                                                                        $dr_sum += $journal->debit_amount;
                                                                    @endphp
                                                                @endif
                                                                @if($journal->cr_child_head == $child_head->id)
                                                                    @php
                                                                        $cr_sum += $journal->credit_amount;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
{{--                                                            @foreach($prev_payments as $payment)--}}
{{--                                                                @if($payment->childhead_id == $child_head->id)--}}
{{--                                                                    @php--}}
{{--                                                                        $dr_sum += $payment->debit_amount;--}}
{{--                                                                    @endphp--}}
{{--                                                                @endif--}}
{{--                                                                @if(($child_head->id == 27) && $payment->mode_of_payment == 'cash')--}}
{{--                                                                    @php--}}
{{--                                                                        $cr_sum += $payment->credit_amount;--}}
{{--                                                                    @endphp--}}
{{--                                                                @endif--}}
{{--                                                            @endforeach--}}
                                                            {{number_format($dr_sum - $cr_sum)}} .00
                                                        @endif
                                                        @php
                                                            $sub_head_dr_prev += $dr_sum;
                                                            $sub_head_cr_prev += $cr_sum;
                                                            $dr_sum =  0;
                                                            $cr_sum = 0;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @foreach($administratives as $administrative)
                                                            @if($administrative->child_head_id == $child_head->id)
                                                                @php
                                                                    $dr_sum += $administrative->debit_amount;
                                                                @endphp
                                                            @endif
                                                            @if(($child_head->id == 27) && $administrative->mode_of_payment_name == 'cash')
                                                                @php
                                                                    $cr_sum += $administrative->credit_amount;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @foreach($financings as $financing)
                                                            @if($financing->child_head_id == $child_head->id)
                                                                @php
                                                                    $dr_sum += $financing->debit_amount;
                                                                @endphp
                                                            @endif
                                                            @if(($child_head->id == 27) && $financing->mode_of_payment_name == 'cash')
                                                                @php
                                                                    $cr_sum += $financing->credit_amount;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @foreach($marketings as $marketing)
                                                            @if($marketing->child_head_id == $child_head->id)
                                                                @php
                                                                    $dr_sum += $marketing->debit_amount;
                                                                @endphp
                                                            @endif
                                                            @if(($child_head->id == 27) && $marketing->mode_of_payment_name == 'cash')
                                                                @php
                                                                    $cr_sum += $marketing->credit_amount;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @foreach($journals as $journal)
                                                            @if($journal->dr_child_head == $child_head->id)
                                                                @php
                                                                    $dr_sum += $journal->debit_amount;
                                                                @endphp
                                                            @endif
                                                            @if($journal->cr_child_head == $child_head->id)
                                                                @php
                                                                    $cr_sum += $journal->credit_amount;
                                                                @endphp
                                                            @endif
                                                        @endforeach
{{--                                                        @foreach($payments as $payment)--}}
{{--                                                            @if($payment->childhead_id == $child_head->id)--}}
{{--                                                                @php--}}
{{--                                                                    $dr_sum += $payment->amount;--}}
{{--                                                                @endphp--}}
{{--                                                            @endif--}}
{{--                                                            @if(($child_head->id == 27) && $payment->mode_of_payment == 'cash')--}}
{{--                                                                @php--}}
{{--                                                                    $cr_sum += $payment->amount;--}}
{{--                                                                @endphp--}}
{{--                                                            @endif--}}
{{--                                                        @endforeach--}}
                                                        {{number_format($dr_sum)}} .00
                                                    </td>
                                                    <td>{{number_format($cr_sum)}} .00</td>
                                                    <td>{{($head->id == 4 || $head->id == 5 || $head->id == 6) ? number_format(($cr_sum - $dr_sum)) : number_format(($dr_sum - $cr_sum))}} .00</td>
                                                </tr>
                                            @endif
                                            @php
                                                $sub_head_dr += $dr_sum;
                                                $sub_head_cr += $cr_sum;
                                                    $dr_sum =  0;
                                                    $cr_sum = 0;
                                            @endphp
                                        @endforeach
                                        @foreach($administratives as $administrative)
                                            @if(empty($administrative->child_head_id) && $administrative->sub_head_id == $sub_head->id)
                                                @php
                                                    $sub_head_dr += $administrative->debit_amount;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @foreach($financings as $financing)
                                            @if(empty($financing->child_head_id) && $financing->sub_head_id == $sub_head->id)
                                                @php
                                                    $sub_head_dr += $financing->debit_amount;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @foreach($marketings as $marketing)
                                            @if(empty($marketing->child_head_id) && $marketing->sub_head_id == $sub_head->id)
                                                @php
                                                    $sub_head_dr += $marketing->debit_amount;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @foreach($journals as $journal)
                                            @if(empty($journal->dr_child_head) && $journal->dr_sub_head == $sub_head->id)
                                                @php
                                                    $sub_head_dr += $journal->debit_amount;
                                                @endphp
                                            @endif
                                            @if(empty($journal->cr_child_head) && $journal->cr_sub_head == $sub_head->id)
                                                @php
                                                    $sub_head_cr += $journal->credit_amount;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <tr class="text-center">
                                            <td><h4>{{$sub_head->sub_head_name}}</h4></td>
                                            <td>
                                                <h4>
                                                    @if(empty($from && $to))
                                                        {{0}}.00
                                                    @else
                                                        {{($head->id == 4 || $head->id == 5 || $sub_head->id == 24) ? number_format(($sub_head_cr_prev - $sub_head_dr_prev)) : number_format(($sub_head_dr_prev - $sub_head_cr_prev))}} .00
                                                    @endif
                                                </h4>
                                            </td>
                                            {{--                                    @if($sub_head->id == 17)--}}
                                            {{--                                        {{dd($sub_head_dr)}}--}}
                                            {{--                                        @endif--}}
                                            <td><h4>{{number_format($sub_head_dr)}} .00</h4></td>
                                            <td><h4>{{number_format($sub_head_cr)}} .00</h4></td>
                                            <td><h4>{{($head->id == 4 || $head->id == 5 || $sub_head->id == 24) ? number_format(($sub_head_cr - $sub_head_dr)) : number_format(($sub_head_dr - $sub_head_cr))}} .00</h4></td>
                                        </tr>
                                    @endif
                                    @php
                                        $dr_sum =  0;
                                        $cr_sum = 0;
                                        $sub_head_dr= 0;
                                        $sub_head_cr= 0;
                                        $sub_head_dr_prev = 0;
                                        $sub_head_cr_prev = 0;
                                    @endphp
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="form-group">
                    <br/>
                    <input type="button" class="print_button btn-gradient-primary btn-block form-control" onclick="printDiv('chart_of_account')" value="Print" />
                </div>
            </div>
        </div>
    </div>

    <script>
        function printDiv(divName)
        {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
