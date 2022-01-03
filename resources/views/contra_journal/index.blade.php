@extends('master')
@section('account','active') @section('account-show','show') @section('vouchar','active') @section('vouchar-show','show') @section('contra-journal','active') @section('contra-journal-show','show') @section('contra-journal-index','active')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row table-responsive">
                        <div class="col-lg-2 float-right"></div>
                        <div class="col-lg-12">
                            {!! Form::open(['route' => 'contra_journal.date_search','method' => 'GET']) !!}
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_from" >Date From</label>
                                            <input type="date" class="form-control" id="date_from" name="date_from">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_to" >Date To</label>
                                            <input type="date" class="form-control" id="date_to" name="date_to">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="input" ></label>
                                        <input type="submit" class="form-control btn custom_button btn-sm btn-block" value="Search">
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <br/><br/>
                            @if(!empty($from))
                                <div class="row">
                                    <div class="col-md-3">From : {{$from}} <br/> To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$to}}</div>
                                    <div class="col-md-6"><h4 class="project_info_tag text-center">Contra-Journal History</h4></div>
                                    <div class="col-md-3">Date :: {{date('Y-m-d')}}</div>
                                </div>
                                <br/>
                            @else
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6"><h4 class="project_info_tag text-center">Contra-Journal History</h4></div>
                                    <div class="col-md-3">Date :: {{date('d-m-Y')}}</div>
                                </div>
                                <br/>
                            @endif
                            <table class="custom">
                                <thead>
                                <tr class="text-center">
                                    <th>S/L</th>
                                    <th>Date</th>
                                    <th>Voucher No</th>
                                    <th>Debit Amount</th>
                                    <th>Credit Amount</th>
                                    <th>Option</th>
                                </tr>
                                </thead>
                                <tbody id="table">
                                @forelse($contra_journals as $contra_journal)
                                    <tr class="text-center">
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{date('d-m-Y', strtotime($contra_journal->date))}}</td>
                                        <td>{{$contra_journal->voucher_no}}</td>
                                        <td>{{$contra_journal->debit_amount}}</td>
                                        <td>{{$contra_journal->credit_amount}}</td>
                                        <td>
                                            <button type="button" class="btn-floating btn-inverse-info  btn-icon" onclick="window.location='{{route('contra_journal.edit',$contra_journal->id)}}'" data-toggle="tooltip" title="Edit"><i class="mdi mdi-pencil"></i></button>
                                            <button type="button" class="btn-floating btn-inverse-success  btn-icon" onclick="window.location='{{route('contra_journal.show',$contra_journal->id)}}'" data-toggle="tooltip" title="Show"><i class="mdi mdi-eye"></i></button>
                                            <div class="modal fade" id="delete_modal_{{$contra_journal->id}}" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Contra Journal</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are You Want To Delete This Contra Journal</p>
                                                            <p>Once You Delete This Contra Journal</p>
                                                            <p>You Will Delete Information Permanently</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            {!! Form::open(['route' => ['contra_journal.destroy',$contra_journal->id],'method' => 'DELETE']) !!}
                                                            <button type="submit" class="btn btn-success">submit</button>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-floating btn-inverse-danger btn-icon" data-toggle="modal" data-target="#delete_modal_{{$contra_journal->id}}" data-title="tooltip" title="Delete"><i class="mdi mdi-delete-forever"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-info">{{'No Data Found !!'}}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <br/><br/>
                            {{$contra_journals->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
