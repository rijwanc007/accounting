@extends('master')
@section('account','active') @section('account-show','show') @section('vouchar','active') @section('vouchar-show','show') @section('journal','active') @section('journal-show','show') @section('journal-index','active')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="print_report">
                        <br/><br/>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8"><div class="text-center"><img src="{{asset('assets/images/logo/nahidplastic.png')}}" style="width: 10%;"></div><h2 class="text-center">{{!empty($siscon = \App\SisterConcern::find($show->sister_concern_id)) ? $siscon->name : 'Company Is Removed'}}</h2></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-12"><h5 class="text-center">Manufacturers & Exporter all kind of Poly Bag. Hanger and Other Accessores</h5></div>
                        </div>
                        <br/><br/>
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6">
                                    <table class="custom">
                                        <thead>
                                        <tr>
                                            <td>Sister Concern</td>
                                            <td>:</td>
                                            <td>{{!empty($siscon = \App\SisterConcern::find($show->sister_concern_id)) ? $siscon->name : 'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Voucher No</td>
                                            <td>:</td>
                                            <td>{{$show->voucher_no}}</td>
                                        </tr>
                                        </thead>
                                    </table>
                                    <br/>
                                </div>
                                <div class="col-sm-6">
                                    <table class="custom">
                                        <thead>
                                        <tr>
                                            <td>Date</td>
                                            <td>:</td>
                                            <td>{{date('d-m-Y', strtotime($show->date))}}</td>
                                        </tr>
                                        <tr>
                                            <td> Voucher Type</td>
                                            <td>:</td>
                                            <td>Journal Voucher</td>
                                        </tr>
                                        </thead>
                                    </table>
                                    <br/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="custom">
                                                <thead>
                                                <tr class="text-center">
                                                    <td>Particular</td>
                                                    <td>Debit</td>
                                                    <td> Credit </td>
                                                    <td> Amount </td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="text-center">
                                                    <td>{{$show->transfer_amount_to}}</td>
                                                    <td>DR</td>
                                                    <td></td>
                                                    <td>{{$show->debit_amount}}</td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>{{$show->transfer_amount_from}}</td>
                                                    <td></td>
                                                    <td>CR</td>
                                                    <td>{{$show->credit_amount}}</td>
                                                </tr>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="4"><h5 class="text-center">Narration : {{$show->naration}}</h5></td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <br/><br/><br/><br/><br/><br/><br/><br/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/><br/>
    <div class="row text-center">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="form-group">
                <br/>
                <input type="button" class="print_button custom_button btn-block form-control" onclick="printDiv('print_report')" value="Print" />
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
