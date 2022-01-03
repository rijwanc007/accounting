@extends('master')
@section('bank','active') @section('bank-show','show') @section('chequebook','active') @section('chequebook-show','show') @section('cheque-index','active')
@section('content')
    <div class="card">
            <div class="card-body">
                <div class="row table-responsive">
                    <div class="col-lg-12">
                        {!! Form::open(['route' => 'cheque.date_search','method' => 'GET']) !!}
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date_from" >Date From</label>
                                        <input type="date" class="form-control" id="date_from" name="date_from" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date_to" >Date To</label>
                                        <input type="date" class="form-control" id="date_to" name="date_to" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="input" ></label>
                                    <input type="submit" class="custom_button" value="Search">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <br/><br/>
                        @if(!empty($from))
                            <div class="row">
                                <div class="col-md-3">From : {{date('d-m-Y', strtotime($from))}} <br/> To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{date('d-m-Y', strtotime($to))}}</div>
                                <div class="col-md-6"><h4 class="project_info_tag text-center">Cheque Book Entry List</h4></div>
                                <div class="col-md-3">Date :: {{date('d-m-Y')}}</div>
                            </div>
                            <br/>
                        @else
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6"><h4 class="project_info_tag text-center">Cheque Book Entry List</h4></div>
                                <div class="col-md-3">Date :: {{date('d-m-Y')}}</div>
                            </div>
                            <br/>
                        @endif
                        <table class="custom">
                            <thead>
                            <tr class="text-center">
                                <th>S/L</th>
                                <th>Date</th>
                                <th> Pay To </th>
                                <th> Amount</th>
                                <th>Account Payee</th>
                                <th> Option </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($cheques as $cheque)
                                <tr class="text-center">
                                    <td>{{ ($cheques->currentpage()-1) * $cheques ->perpage() + $loop->index + 1 }}</td>
                                    <td>{{date('d-m-Y', strtotime($cheque->date))}}</td>
                                    <td>{{$cheque->pay_to}} </td>
                                    <td>{{$cheque->amount}} </td>
                                    <td>{{strtoupper($cheque->ac_payee)}} </td>
                                    <td>
                                        <button type="button" class="btn-floating btn-inverse-info btn-icon" onclick="window.location='{{route('cheque.edit',$cheque->id)}}'" data-toggle="tooltip" title="Edit"><i class="mdi mdi-pencil"></i></button>
                                        <button type="button" class="btn-floating btn-inverse-primary btn-icon" onclick="window.location='{{route('cheque.show',$cheque->id)}}'" data-toggle="tooltip" title="Print"><i class="mdi mdi-printer"></i></button>
                                        <div class="modal fade" id="delete_modal_{{$cheque->id}}" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Delete Cheque</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are You Want To Delete This Cheque.Once You Delete This Cheque</p>
                                                        <p>You Will Delete This Cheque Information Permanently</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        {!! Form::open(['route' => ['cheque.destroy',$cheque->id],'method' => 'POST']) !!}
                                                        <button type="submit" class="btn btn-success">submit</button>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-floating btn-inverse-danger btn-icon" data-toggle="modal" data-target="#delete_modal_{{$cheque->id}}" data-title="tooltip" title="Delete"><i class="mdi mdi-delete-forever"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-info">{{'No Cheque Book Entry Found'}}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <br/><br/>
                        {!! $cheques->links() !!}
                    </div>
                </div>
            </div>
        </div>
@endsection
