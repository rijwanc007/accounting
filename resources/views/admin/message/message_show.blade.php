@extends('master')
@section('content')
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="main_head_button" href="{{route('message.index')}}">All Message</a>
            <br/><br/><br/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="item">
                <h2>Message</h2>
            </div>
            <br/>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>Sender</h2>
                            <hr/>
                            <h5>Name : {{$show->sender_name}}</h5>
                            <h5>Email : {{$show->sender_email}}</h5>
                        </div>
                        <div class="col-md-6">
                            <h2>Receiver</h2>
                            <hr/>
                            <h5>Name : {{$show->receiver_name}}</h5>
                            <h5>Email : {{$show->receiver_email}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="row card_body_margin">
        <div class="col-md-3"></div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center"><h4>Message</h4></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><div>{{$show->message}}</div><br/><br/></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
    @endsection
