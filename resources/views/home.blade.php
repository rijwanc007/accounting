@extends('master')
@section('content')
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body table-responsive">
                    <h4 class="card-title">Current User's</h4>
                    <table class="table custom">
                        <thead>
                        <tr class="text-center">
                            <th> # </th>
                            <th> Image </th>
                            <th> Name </th>
                            <th> Email </th>
                            <th> Phone </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr class="text-center">
                                <td>{{ ($users->currentpage()-1) * $users ->perpage() + $loop->index + 1 }}</td>
                                <td><img src="{{asset('/assets/images/user/'.$user->image)}}" alt=""></td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->phone}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"><div class="text-danger"> No User Found</div></td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3 id="monthAndYear"></h3>
                    <div class="button-container-calendar">
                        <button id="previous" onclick="previous()">&#8249;</button>
                        <button id="next" onclick="next()">&#8250;</button>
                    </div>
                    <table class="table-calendar" id="calendar" data-lang="en">
                        <thead id="thead-month"></thead>
                        <tbody id="calendar-body"></tbody>
                    </table>
                    <div class="footer-container-calendar">
                        <label for="month">Jump To: </label>
                        <select id="month" onchange="jump()">
                            <option value=0>Jan</option>
                            <option value=1>Feb</option>
                            <option value=2>Mar</option>
                            <option value=3>Apr</option>
                            <option value=4>May</option>
                            <option value=5>Jun</option>
                            <option value=6>Jul</option>
                            <option value=7>Aug</option>
                            <option value=8>Sep</option>
                            <option value=9>Oct</option>
                            <option value=10>Nov</option>
                            <option value=11>Dec</option>
                        </select>
                        <select id="year" onchange="jump()"></select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/calender.js')}}"></script>
@endsection
