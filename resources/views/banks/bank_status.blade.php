@extends('master')
 @section('bank','active') @section('bank-show','show') @section('bank-cash-status','active') @section('bank-cash-status-show','show') @section('bank-status','active')
@php
    $dr_sum = 0;
    $cr_sum = 0;
    $opening = 0;
@endphp

@section('content')
    <div class="row">
        <div class="col-lg-12">
            {!! Form::open(['route' => ['bank.bank_status_search'],'method' => 'GET']) !!}
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="age">Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="age">Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="none"></label>
                        <button class="btn custom_button btn-lg btn-block form-control" id="search_balance">Search</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <br/>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="printBankStatus">
                        <br/><br/><br/>
                        <div class="col-md-12 text-center"> <h3> Current Bank Status<hr/></h3></div>
                        @if(!empty($from))
                            <div class="col-md-12 text-center">{{date('d-m-Y', strtotime($from))}} - {{date('d-m-Y', strtotime($to))}}</div>
                        @endif
                        <br/>
                        <div class="table-responsive">
                            <table class="custom">
                                <thead>
                                <tr class="text-center">
                                    <td>S/L</td>
                                    <td>A/C</td>
                                    <td>Opening</td>
                                    <td>DR</td>
                                    <td>CR</td>
                                    <td>Closing</td>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($banks as $bank)
                                    <tr class="text-center">
                                        <td>{{$loop->index + 1 }}</td>
                                        <td>{{$bank->account}}</td>
                                        <td>
                                            @if(empty($from && $to))
                                                {{0}} .00
                                            @else
                                                @for($i =0 ;$i<count($prev_results) ; $i++)
                                                    @php
                                                        !empty($prev_results[$i]['debit_amount']) ? $dr_sum += $prev_results[$i]['debit_amount'] : $cr_sum += $prev_results[$i]['credit_amount'];
                                                    @endphp
                                                @endfor

                                                {{($dr_sum >= $cr_sum)  ? number_format($dr_sum - $cr_sum) : 0}} .00
                                                @php
                                                    $opening += $cr_sum - $dr_sum;
                                                    $dr_sum =0;
                                                    $cr_sum =0 ;
                                                @endphp
                                            @endif
                                        </td>
                                        @for($i =0 ;$i<count($results) ; $i++)
                                            @php
                                                !empty($results[$i]['debit_amount']) ? $dr_sum += $results[$i]['debit_amount'] : $cr_sum += $results[$i]['credit_amount'];
                                            @endphp
                                        @endfor
                                        <td>
                                            {{number_format($dr_sum)}} .00
                                        </td>
                                        <td>

                                            {{number_format($cr_sum)}}.00
                                        </td>
                                        <td>{{number_format($opening + $cr_sum - $dr_sum)}} .00</td>
                                    </tr>
                                    @php
                                        $opening = 0;
                                        $dr_sum = 0;
                                        $cr_sum = 0;
                                    @endphp
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-info">{{'No Current Bank Status Created Yet'}}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="form-group">
                <br/>
                <input type="button" class="print_button custom_button btn-block form-control" onclick="printDiv('printBankStatus')" value="Print" />
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
