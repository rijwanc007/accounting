@extends('master')
@section('content')
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="main_head_button" href="{{route('main_head.create')}}">Create Main Head</a>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <br/>
            <form class="d-flex" action="#">
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                        <i class="input-group-text border-0 mdi mdi-magnify"></i>
                    </div>
                    <input type="text" class="form-control bg-transparent border-0" placeholder="Search Main Head">
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-12 table-responsive">
            <br/><br/>
            <table class="table table-hover">
                <tr>
                    <th>Serial</th>
                    <th>Account Type</th>
                    <th>Main Head</th>
                    <th>Sub Head</th>
                    <th>Created Time</th>
                    <th>Created Person</th>
                    <th>Option</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>rijwan</td>
                    <td>11-02-2019</td>
                    <td>No</td>
                    <td>chowdhury</td>
                    <td>Nothing</td>
                    <td>
                        <button type="button" class="btn btn-inverse-dark btn-icon"><i class="mdi mdi-table-edit btn-icon-append"></i></button>
                        <button type="button" class="btn btn-inverse-danger btn-icon"><i class="mdi mdi-delete btn-icon-append"></i></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @endsection