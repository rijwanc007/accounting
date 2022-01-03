@extends('master')
@section('content')
    <div class="modal fade" id="myModal" role="dialog">
        {!! Form::open(['route'=>'message.store','method' => 'POST']) !!}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="message_header">Write Your Message To The User</h3>
                </div>
                <div class="modal-body">
                    <div>Name : {{$details->sender_name}}</div><br/>
                    <div>Email : {{$details->sender_email}}</div><br/>
                    <div class="form-group row">
                        <label for="about" class="col-sm-3 col-form-label">Message Him/Her</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="receiver_id" value="{{$details->sender_id}}"/>
                            <input type="hidden" name="receiver_name" value="{{$details->sender_name}}"/>
                            <input type="hidden" name="receiver_email" value="{{$details->sender_email}}"/>
                            <input type="hidden" name="sender_id" value="{{Auth::user()->id}}"/>
                            <input type="hidden" name="sender_image" value="{{Auth::user()->image}}"/>
                            <input type="hidden" name="sender_name" value="{{Auth::user()->name}}"/>
                            <input type="hidden" name="sender_email" value="{{Auth::user()->email}}"/>
                            <textarea class="form-control" id="about" name="message" rows="8" placeholder="Type Your Message To Him Or Her" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" value="Send"/>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
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
                        <div class="col-md-12">
                            <h2 class="text-center">Sender</h2>
                            <hr/>
                            <h5>Name : {{$details->sender_name}}</h5>
                            <h5>Email : {{$details->sender_email}}</h5>
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
                        <div class="col-md-12"><div>{{$details->message}}</div><br/><br/></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="button" class="reply_button" data-toggle="modal" data-target="#myModal">Reply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
@endsection
