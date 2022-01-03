@extends('master')
@section('content')
    @php(
         $s = 1
        )
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="create_user_button" href="{{route('account.create')}}">Create Account</a>
        </div>
        <div class="col-md-12 text-center">
            <div class="item">
                <h3>All Account</h3>
            </div>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <br/>
            {!! Form::open(['id' => 'form_submit','class' => 'd-flex' ,'route' => 'account.search','method' => 'POST']) !!}
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                    <i class="input-group-text border-0 mdi mdi-magnify submit_button"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" name="search" placeholder="Search Account">
            </div>
            {!! Form::close() !!}
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-12 table-responsive text-center">
            <br/><br/>
            <table class="table table-hover">
                <tr>
                    <th>Serial</th>
                    <th>Account Type</th>
                    <th>Account Status</th>
                    <th>Option</th>
                </tr>
                @if($accounts->count() ==! 0)
                    @foreach($accounts as $account)
                        <tr>
                            <td>{{$s++}}</td>
                            <td>{{$account->account_type}}</td>
                            <td>{{$account->status}}</td>
                            <td>
                                <button type="button" class="btn btn-inverse-dark btn-icon" onclick="window.location.href = '{{route('account.edit',$account->id)}}'"><i class="mdi mdi-table-edit btn-icon-append"></i></button>
                                <div class="modal fade" id="deleteModal_{{$account->id}}" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="message_header">Delete Message</h3>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are You Want To Delete These Account Type.Once You Delete </p>
                                                <p>These Account Type,These Account Type Will Be </p>
                                                <p>Delete Permanently & These Account Type Related </p>
                                                <p>Transaction Will Be Deleted Permanently</p>
                                            </div>
                                            {!! Form::open(['route' => ['account.destroy',$account->id],'method' => 'DELETE']) !!}
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-success" value="Delete"/>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-inverse-danger btn-icon" data-toggle="modal" data-target="#deleteModal_{{$account->id}}"><i class="mdi mdi-delete btn-icon-append"></i></button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">No Account Available To see</td>
                    </tr>
                @endif
            </table>
            {!! $accounts->links() !!}
        </div>
    </div>
    <script>
        $(document).on('click','.submit_button',function(){
            document.getElementById('form_submit').submit();
        })
    </script>
    @endsection
