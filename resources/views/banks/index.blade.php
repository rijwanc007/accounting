@extends('master')
@section('bank','active') @section('bank-show','show') @section('bank-index','active')
@section('content')
    @php
        $j = 1;
    @endphp
    <div class="card">
        <div class="card-body">
            <div class="row text-center">
                <div class="col-sm-12">
                    {!! Form::open(['route' => 'bank.search','method' => 'GET']) !!}
                    <div class="row text-center">
                        <div class="col-md-3"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="form-control" id="item" name="item" placeholder="Search in table.....">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="custom_button" id="search_balance">Search</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <br/><br/>
                    <h4>Bank List<hr/></h4>
                </div>
            </div>
        </div>
    </div>
    <br/><br/><br/>
    <div class="row">
        @forelse($sister_concerns as $sister_concern)
            <div class=" @if($sister_concerns->count() == 1) col-md-12 @else col-md-6 @endif text-center">
                <div class="card">
                    <div class="card-body ">
                        <h6 class="text-info">{{$sister_concern->name}}<hr/></h6>
                        <div class="card_body_height">
                            <table class="custom">
                                <thead>
                                <tr>
                                    <th>S\L</th>
                                    <th>Account</th>
                                    <th>Option</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($banks as $bank)
                                    @if($sister_concern->id == $bank->sister_concern_id)
                                        <tr>
                                            <td>{{$j++}}</td>
                                            <td>{{$bank->account}}</td>
                                            <td>
                                                <button type="button" class="btn-floating btn-inverse-info btn-icon" onclick="window.location='{{route('bank.edit',$bank->id)}}'" data-toggle="tooltip" title="Edit"><i class="mdi mdi-pencil"></i></button>
                                                <button type="button" class="btn-floating btn-inverse-success btn-icon" onclick="window.location='{{route('bank.show',$bank->id)}}'" data-toggle="tooltip" title="Show"><i class="mdi mdi-eye"></i></button>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br/>
            </div>
            @php
                $j = 1;
            @endphp
        @empty
        @endforelse
    </div>
@endsection
