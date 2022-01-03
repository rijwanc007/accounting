@extends('master')
@section('management','active') @section('management-show','show') @section('sister-concern','active') @section('sister-concern-show','show') @section('sister-concern-index','active')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row table-responsive">
                        <div class="col-lg-12">
                            <h2 class="text-center text-dark">Sister Concern's<hr/></h2><br/>
                            <br>
                            {!! Form::open(['route' => 'sister_concern.search','method' => 'GET']) !!}
                            <div class="row text-center">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="search" name="search" placeholder="Search in table.....">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button class="custom_button" id="search_balance">Search</button>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <br>
                            <table class="custom">
                                <thead>
                                <tr>
                                    <th class="text-center">S/L</th>
                                    <th class="text-center"> Name </th>
                                    <th class="text-center"> Status </th>
                                    <th class="text-center"> Option </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($concerns as $concern)
                                    <tr>
                                        <td class="text-center">{{ ($concerns->currentpage()-1) * $concerns ->perpage() + $loop->index + 1 }}</td>
                                        <td class="text-center">{{$concern->name}}</td>
                                        <td class="text-center">{{$concern->status}}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn-floating btn-inverse-info btn-icon" onclick="window.location='{{route('sister_concern.edit',$concern->id)}}'" data-toggle="tooltip" title="Edit"><i class="mdi mdi-pencil"></i></button>
                                            <div class="modal fade" id="delete_modal_{{$concern->id}}" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Sister Concern</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are You Want To Delete This Sister Concern</p>
                                                            <p>Once You Delete This Sister Concern</p>
                                                            <p>You Will Delete Sister Concern Permanently</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            {!! Form::open(['route' => ['sister_concern.destroy',$concern->id],'method' => 'DELETE']) !!}
                                                            <button type="submit" class="btn btn-success">submit</button>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-floating btn-inverse-danger btn-icon" data-toggle="modal" data-target="#delete_modal_{{$concern->id}}" data-title="tooltip" title="Delete"><i class="mdi mdi-delete-forever"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-danger">{{'No Sister Concern Found'}}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <br/><br/>
                            {!! $concerns->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
