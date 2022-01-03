@extends('master')
@section('bank','active') @section('bank-show','show') @section('chequebook','active') @section('chequebook-show','show')
@section('content')
    <div class="check">
        <div class="border">
            <div class="container" id="container">
                <div id="printCheque">
                    <div class="content">
                        <div class="one">
                            <form>
                                <div class="date"><input type="text"  id="date_bank" name="date" size="15" value="{{date('d-m-Y', strtotime($cheque->date))}}"></div>
                                @if($cheque->ac_payee == 'yes')
                                <div class="ac_pay"><img src="{{asset('assets/images/signature/ac.png')}}" class="cheque_sign" width="50%"></div>
                                @endif
                                <div class="title"><input type="text"  id="name_bank" name="name" value="{{$cheque->pay_to}}"> </div>
                                <div class="amount"><input type="text" id="amount_bank" name="amount" size="15" value="{{number_format($cheque->amount) .'.00'}}"></div>
                                <div class="sum"><textarea type="text" id="sum_bank" name="sum" >{{$numberTransformer->toWords($cheque->amount) . ' only'}}</textarea></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/><br/><br/>
    <div class="row text-center">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="form-group">
                <br/>
                <input type="button" class="print_button custom_button" onclick="printDiv('printCheque')" value="print" />
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
