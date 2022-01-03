@extends('master')
@section('report','active') @section('report-show','show') @section('income_statement-report','active')
@section('content')
    <div class="col-sm-12 text-center text-info"><h2>Income Statement <hr/></h2></div>
    <br/>
    <div class="col-lg-12">
        {!! Form::open(['route' => 'report.income_statement_date_search','method' => 'GET']) !!}
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
                        <div class="col-sm-12"><h3> {{($sis_con != null) ? \App\SisterConcern::find($sis_con)->name : 'Nahid Group'}} Income Statement</h3><hr/></div>
                        <br/>
                        @if(empty($from))
                            <div class="col-sm-12 text-center text-primary"><h3>as 31 Dec' {{date('Y')}}</h3></div>
                        @else
                            <div class="col-sm-12 text-center text-primary"><h4>{{date('F-d-Y', strtotime($from))}} &nbsp; - &nbsp;{{date('F-d-Y', strtotime($to))}}</h4></div>
                        @endif
                    </div>
                    <br/><br/><br/>
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5"><h4>Sales Revenue</h4></div>
                            <div class="col-sm-2">:</div>
                            <div class="col-sm-4"><h4>{{number_format($sales)}}</h4></div>
                        </div>

                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5"><h4> Less : Cost Of Sale</h4></div>
                            <div class="col-sm-2">:</div>
                            <div class="col-sm-4"><h4>{{number_format($cost_of_sale)}}</h4></div>
                        </div>

                    @if($sis_con != null)
                    @for($i = 0 ; $i<count($less) ; $i++)
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4"><h5>{{$less[$i]['particular']}}</h5></div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-5"><h5>{{number_format($less[$i]['amount'])}}</h5></div>
                        </div>
                        @endfor
                    @else
                        @foreach($lesses as $less)
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4"><h5>{{$less->particular}}</h5></div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-5"><h5>{{number_format($less->amount)}}</h5></div>
                            </div>
                        @endforeach
                    @endif

                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5"><h4>Gross Profit</h4></div>
                            <div class="col-sm-2">:</div>
                            <div class="col-sm-4"><h4>{{number_format($sales - $cost_of_sale)}}</h4></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5"><h4>Expense</h4></div>
                            <div class="col-sm-2">:</div>
                            <div class="col-sm-4"><h4>{{number_format($expense_sum)}}</h4></div>
                        </div>
                    @if($sis_con != null)
                        @for($i = 0 ; $i<count($expense) ; $i++)
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4"><h5>{{$expense[$i]['particular']}}</h5></div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-5"><h5>{{number_format($expense[$i]['amount'])}}</h5></div>
                            </div>
                        @endfor
                    @else
                        @foreach($expenses as $expense)
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4"><h5>{{$expense->particular}}</h5></div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-5"><h5>{{number_format($expense->amount)}}</h5></div>
                            </div>
                        @endforeach
                    @endif
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5"><h4>Income</h4></div>
                            <div class="col-sm-2">:</div>
                            <div class="col-sm-4"><h4>{{number_format($income_sum)}}</h4></div>
                        </div>
                    @if($sis_con != null)
                        @for($i = 0 ; $i<count($income) ; $i++)
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4"><h5>{{$income[$i]['particular']}}</h5></div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-5"><h5>{{number_format($income[$i]['amount'])}}</h5></div>
                            </div>
                        @endfor
                    @else
                        @foreach($incomes as $income)
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4"><h5>{{$income->particular}}</h5></div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-5"><h5>{{number_format($income->amount)}}</h5></div>
                            </div>
                        @endforeach
                    @endif
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5"><h4>Net Profit</h4></div>
                            <div class="col-sm-2">:</div>
                            <div class="col-sm-4"><h4>{{number_format( ($sales - $cost_of_sale) - ($expense_sum + $income_sum))}}</h4></div>
                        </div>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="form-group">
                    <br/>
                    <input type="button" class="print_button custom_button btn-block form-control" onclick="printDiv('printPeriod_income')" value="Print" />
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
