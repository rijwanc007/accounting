@extends('master')
@section('account','active') @section('account-show','show') @section('vouchar','active') @section('vouchar-show','show') @section('journal','active') @section('journal-show','show') @section('journal-index','active')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row table-responsive">
                        <div class="col-lg-2 float-right"></div>
                        <div class="col-lg-12">
                            {!! Form::open(['route' => 'journal.date_search','method' => 'GET']) !!}
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
                                    <div class="col-md-6"><h4 class="project_info_tag text-center">Journal History</h4></div>
                                    <div class="col-md-3">Date :: {{date('Y-m-d')}}</div>
                                </div>
                                <br/>
                            @else
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6"><h4 class="project_info_tag text-center">Journal History</h4></div>
                                    <div class="col-md-3">Date :: {{date('d-m-Y')}}</div>
                                </div>
                                <br/>
                            @endif
                            <table class="custom">
                                <thead>
                                <tr class="text-center">
                                    <th>S/L</th>
                                    <th>Date</th>
                                    <th>Sister Concern</th>
                                    <th>Voucher No</th>
                                    <th>Debit Amount</th>
                                    <th>Credit Amount</th>
                                    <th>Option</th>
                                </tr>
                                </thead>
                                <tbody id="table">
                                @forelse($journals as $journal)
                                   <tr class="text-center">
                                       <td>{{$loop->index + 1}}</td>
                                       <td>{{date('d-m-Y', strtotime($journal->date))}}</td>
                                       <td>{{!empty($siscon = \App\SisterConcern::find($journal->sister_concern_id)) ? $siscon->name : 'N/A'}}</td>
                                       <td>{{$journal->voucher_no}}</td>
                                       <td>{{$journal->debit_amount}}</td>
                                       <td>{{$journal->credit_amount}}</td>
                                       <td>
                                           <button type="button" class="btn-floating btn-inverse-success  btn-icon" onclick="window.location='{{route('journal.show',$journal->id)}}'" data-toggle="tooltip" title="Show"><i class="mdi mdi-eye"></i></button>
                                           @if($journal->voucher_type == 0)
                                               <button type="button" class="btn-floating btn-inverse-info  btn-icon" onclick="window.location='{{route('journal.edit',$journal->id)}}'" data-toggle="tooltip" title="Edit"><i class="mdi mdi-pencil"></i></button>
                                               <div class="modal fade" id="delete_modal_{{$journal->id}}" role="dialog">
                                                   <div class="modal-dialog">
                                                       <div class="modal-content">
                                                           <div class="modal-header">
                                                               <h4 class="modal-title">Delete Journal Voucher</h4>
                                                           </div>
                                                           <div class="modal-body">
                                                               <p>Are You Want To Delete This Journal Voucher</p>
                                                               <p>Once You Delete This Journal Voucher</p>
                                                               <p>You Will Delete Information Permanently</p>
                                                           </div>
                                                           <div class="modal-footer">
                                                               <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                               {!! Form::open(['route' => ['journal.destroy',$journal->id],'method' => 'DELETE']) !!}
                                                               <button type="submit" class="btn btn-success">submit</button>
                                                               {!! Form::close() !!}
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                               <button type="button" class="btn-floating btn-inverse-danger btn-icon" data-toggle="modal" data-target="#delete_modal_{{$journal->id}}" data-title="tooltip" title="Delete"><i class="mdi mdi-delete-forever"></i></button>
                                           @else
                                               @if($journal->status == 0)
                                                   <button type="button" class="btn-floating btn-inverse-info  btn-icon" onclick="window.location='{{route('journal.accept',$journal->id)}}'" data-toggle="tooltip" title="Accept"><i class="mdi mdi-hand-okay"></i></button>
                                               @endif
                                           @endif
                                       </td>
                                   </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-info">{{'No Data Found !!'}}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <br/><br/>
                            {{$journals->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
