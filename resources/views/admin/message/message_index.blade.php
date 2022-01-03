@extends('master')
@section('content')
    @php(
    $s = 1
    )
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="item">
                <h3>All Message</h3>
            </div>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <br/>
            {!! Form::open(['id' => 'form_submit','class' => 'd-flex','route' => 'message.search' ,'method' => 'POST']) !!}
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                        <i class="input-group-text border-0 mdi mdi-magnify submit_button"></i>
                    </div>
                    <input type="text" class="form-control bg-transparent border-0" name="search" placeholder="Search Message">
                </div>
            {!! Form::close() !!}
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-12 table-responsive text-center">
            <br/><br/>
            <table class="table table-hover">
                <tr>
                    <th>Serial</th>
                    <th>Receiver Name</th>
                    <th>Receiver Email</th>
                    <th>Message</th>
                    <th>Sender Name</th>
                    <th>Sender Email</th>
                    <th>Option</th>
                </tr>
                @if($messages->count() ==! 0)
                   @foreach($messages as $message)
                <tr>
                    <td>{{$s++}}</td>
                    <td>{{$message->receiver_name}}</td>
                    <td>{{$message->receiver_email}}</td>
                    <td>{!! str_limit($message->message,$limit=20,$end='....') !!}</td>
                    <td>{{$message->sender_name}}</td>
                    <td>{{$message->sender_email}}</td>
                    <td>
                        <button type="button" class="btn btn-inverse-info btn-icon" onclick="window.location.href = '{{route('message.show',$message->id)}}';" ><i class="mdi mdi-book-open-variant"></i></button>
                        <div class="modal fade" id="deleteModal_{{$message->id}}" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="message_header">Delete Message</h3>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are You Want To Delete These Message.Once You Delete </p>
                                        <p>These Message,These Message Will Be Delete Permanently</p>
                                    </div>
                                    {!! Form::open(['route' => ['message.destroy',$message->id],'method' => 'DELETE']) !!}
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-success" value="Delete"/>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-inverse-danger btn-icon" data-toggle="modal" data-target="#deleteModal_{{$message->id}}"><i class="mdi mdi-delete btn-icon-append"></i></button>
                    </td>
                </tr>
                   @endforeach
                @else
                 <tr>
                     <td colspan="6">No Message Available To see</td>
                </tr>
                @endif
            </table>
            {!! $messages->links() !!}
        </div>
    </div>
    <script>
        $(document).on('click','.submit_button',function(){
            document.getElementById('form_submit').submit();
        })
    </script>
    @endsection