@extends('master')
@section('content')
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="main_head_button" href="{{route('user.index')}}">All User</a>
            <br/><br/><br/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="item">
                <h2>User Information</h2>
            </div>
            <br/>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                   <div class="row">
                       <div class="col-md-3"><img class="show_image" src="{{asset('assets/images/user/'.$show->image)}}" alt="image"/></div>
                       <div class="col-md-1"></div>
                       <div class="col-md-8">
                           <h5>Name : {{$show->name}}</h5>
                           <h5>Email : {{$show->email}}</h5>
                           <h5>Position : {{$show->position}}</h5>
                           <h5>Created Person : {{$show->created_person}}</h5>
                           <h5>Phone : {{$show->phone}}</h5>
                           <h5>Address : {{$show->address}}</h5>
                           <h5>National ID Number : {{$show->nid}}</h5>
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
                        <div class="col-md-12 text-center"><h4>About</h4></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><div>{{$show->about}}</div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
    @endsection
