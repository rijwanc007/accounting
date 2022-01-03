@extends('master')
@section('content')
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="main_head_button" href="{{route('user.index')}}">All User</a>
        </div>
        <div class="col-md-12 text-center">
            <div class="item">
            <h3>Multi User Send Message</h3>
            </div>
            <br/><br/><br/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-check">
                <label class="form-check-label"> <input type="checkbox" name="select-all" id="select-all" /> {{'Select All'}} </label>
            </div>
        </div>
    </div>
    {!! Form::open(['route' => 'multi.user.message.store','method' => 'POST']) !!}
    <div class="row">
        @foreach($users as $user)
        <div class="col-md-2">
            <div class="form-check">
                <label class="form-check-label"><input class="checkbox" type="checkbox" value="{{$user->id}}" name="receiver_id[]"> {{$user->name}} </label>
            </div>
        </div>
        @endforeach
    </div>
    <input type="hidden" name="sender_id" value="{{Auth::user()->id}}"/>
    <input type="hidden" name="sender_image" value="{{Auth::user()->image}}"/>
    <input type="hidden" name="sender_name" value="{{Auth::user()->name}}"/>
    <input type="hidden" name="sender_email" value="{{Auth::user()->email}}"/>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="text-center">Message</div><br/>
            <div class="form-group">
                <textarea class="form-control" id="message" name="message" rows="16" placeholder="Type Your Message To The User" required></textarea>
            </div>
            <div class="text-center"><button class="reply_button">Send</button></div>
        </div>
        <div class="col-md-3"></div>
    </div>
    {!! Form::close() !!}
    <script>
        $('#select-all').click(function(event) {
            if(this.checked) {
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
@endsection
