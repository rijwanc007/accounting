@extends('master')
@section('content')
    @php(
        $s = 1
        )
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="create_user_button" href="{{route('announcement.create')}}">Create Announcement</a>
        </div>
        <div class="col-md-12 text-center">
            <div class="item">
                <h3>All Announcement</h3>
            </div>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <br/>
            {!! Form::open(['id' => 'form_submit','class' => 'd-flex','route' => 'announcement.search' ,'method' => 'POST']) !!}
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                    <i class="input-group-text border-0 mdi mdi-magnify submit_button"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" name="search" placeholder="Search Announcement">
            </div>
            {!! Form::close() !!}
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-12 table-responsive text-center">
            <br/><br/>
            <table class="table table-hover">
                <tr>
                    <th>Serial</th>
                    <th>Creator Name</th>
                    <th>Creator Email</th>
                    <th>Announcement Name</th>
                    <th>Announcement Description</th>
                    <th>Option</th>
                </tr>
                @if($announcements->count() ==! 0)
                @foreach($announcements as $announcement)
                <tr>
                    <td>{{$s++}}</td>
                    <td>{{$announcement->creator_name}}</td>
                    <td>{{$announcement->creator_email}}</td>
                    <td>{{$announcement->announcement_name}}</td>
                    <td>{!! str_limit($announcement->announcement_description,$limit = 20,$end = '...') !!}</td>
                    <td>
                        <button type="button" class="btn btn-inverse-info btn-icon" onclick="window.location.href = '{{route('announcement.show',$announcement->id)}}';" ><i class="mdi mdi-book-open-variant"></i></button>
                        <button type="button" class="btn btn-inverse-dark btn-icon" onclick="window.location.href = '{{route('announcement.edit',$announcement->id)}}'"><i class="mdi mdi-table-edit btn-icon-append"></i></button>
                        <div class="modal fade" id="deleteModal_{{$announcement->id}}" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="message_header">Delete Announcement</h3>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are You Want To Delete These Announcement.Once You Delete </p>
                                        <p>These Announcement,These Announcement Will Be Delete</p>
                                        <p>Permanently</p>
                                    </div>
                                    {!! Form::open(['route' => ['announcement.destroy',$announcement->id],'method' => 'DELETE']) !!}
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-success" value="Delete"/>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-inverse-danger btn-icon" data-toggle="modal" data-target="#deleteModal_{{$announcement->id}}"><i class="mdi mdi-delete btn-icon-append"></i></button>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="6">No Announcement Available</td>
                </tr>
                @endif
            </table>
            {!! $announcements->links() !!}
        </div>
    </div>
    <script>
        $(document).on('click','.submit_button',function(){
            document.getElementById('form_submit').submit();
        })
    </script>
@endsection
