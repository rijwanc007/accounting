@extends('master')
@section('content')
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="main_head_button" href="{{route('announcement.index')}}">All Announcement</a>
            <br/><br/><br/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="item">
                <h2>Announcement</h2>
            </div>
            <br/>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="text-center">Creator</h2>
                            <hr/>
                            <h5>Name : {{$show->creator_name}}</h5>
                            <h5>Email : {{$show->creator_email}}</h5>
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
                        <div class="col-md-12 text-center"><h4>{{$show->announcement_name}}</h4></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><div>{{$show->announcement_description}}</div><br/><br/></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
@endsection
