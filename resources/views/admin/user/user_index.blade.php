@extends('master')
@section('content')
    @php(
    $s = 1
    )
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="create_user_button" href="{{route('user.create')}}">Create User</a>
        </div>
        <div class="col-md-12 text-center">
            <div class="item">
                <h3>All User</h3>
            </div>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <br/>
            {!! Form::open(['id' => 'form_submit','class' => 'd-flex' ,'route' => 'user.search','method' => 'POST']) !!}
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                        <i class="input-group-text border-0 mdi mdi-magnify submit_button"></i>
                    </div>
                    <input type="text" class="form-control bg-transparent border-0" name="search" placeholder="Search User">
                </div>
            {!! Form::close() !!}
        </div>
        <div class="col-md-3"></div>
    </div>
    <br/><br/><br/>
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="main_head_button " href="{{route('message.create')}}">Multi User Message</a>
        </div>
        <div class="col-md-12 table-responsive text-center">
            <br/><br/>
            <table class="table table-hover">
                <tr>
                    <th>Serial</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Created Time</th>
                    <th>Created Person</th>
                    <th>Option</th>
                </tr>
                @if($users->count() ==! 0)
                @foreach($users as $user)
                <tr>
                    <td>{{$s++}}</td>
                    <th><img class="user_image_size" src="{{asset('assets/images/user/'.$user->image)}}" alt="image"></th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->position}}</td>
                    <td>{{date('F d,Y',strtotime($user->created_at))}}</td>
                    <td>{{$user->created_person}}</td>
                    <td>
                       <div class="modal fade" id="myModal_{{$user->id}}" role="dialog">
                           {!! Form::open(['route'=>'message.store','method' => 'POST']) !!}
                          <div class="modal-dialog">
                              <div class="modal-content">
                                 <div class="modal-header">
                                     <h3 class="message_header">Write Your Message To The User</h3>
                                 </div>
                                 <div class="modal-body">
                                     <div>Name : {{$user->name}}</div><br/>
                                     <div>Email : {{$user->email}}</div><br/>
                                     <div class="form-group row">
                                         <label for="about" class="col-sm-3 col-form-label">Message Him/Her</label>
                                         <div class="col-sm-9">
                                             <input type="hidden" name="receiver_id" value="{{$user->id}}"/>
                                             <input type="hidden" name="receiver_name" value="{{$user->name}}"/>
                                             <input type="hidden" name="receiver_email" value="{{$user->email}}"/>
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
                        <button type="button" class="btn btn-inverse-success btn-icon" data-toggle="modal" data-target="#myModal_{{$user->id}}"><i class="mdi mdi-email"></i></button>
                        <button type="button" class="btn btn-inverse-info btn-icon" onclick="window.location.href = '{{route('user.show',$user->id)}}';" ><i class="mdi mdi-book-open-variant"></i></button>
                        <button type="button" class="btn btn-inverse-dark btn-icon" onclick="window.location.href = '{{route('user.edit',$user->id)}}'"><i class="mdi mdi-table-edit btn-icon-append"></i></button>
                        <div class="modal fade" id="deleteModal_{{$user->id}}" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="message_header">Delete User</h3>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are You Want To Delete These User.Once You Delete </p>
                                        <p>These User,These User Will Be Delete Permanently</p>
                                    </div>
                                    {!! Form::open(['route' => ['user.destroy',$user->id],'method' => 'DELETE']) !!}
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-success" value="Delete"/>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-inverse-danger btn-icon" data-toggle="modal" data-target="#deleteModal_{{$user->id}}"><i class="mdi mdi-delete btn-icon-append"></i></button>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="8">No User Available</td>
                </tr>
                @endif
            </table>
            {!! $users->links() !!}
        </div>
    </div>
    <script>
        $(document).on('click','.submit_button',function(){
            document.getElementById('form_submit').submit();
        })
    </script>
    @endsection
