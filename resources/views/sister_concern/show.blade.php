@extends('master')
@section('management','active') @section('management-show','show') @section('sister-concern','active') @section('sister-concern-show','show')
@section('content')
{{--    @php $s = 1 @endphp--}}
{{--    <div class="row" >--}}
{{--        <div class="col-lg-12 grid-margin stretch-card">--}}
{{--            <div class="card" id="sister_concern_wise_employee">--}}
{{--                <div class="card-body">--}}
{{--                    <div class="row"><div class="col-md-12"><h3 class="text-center text-info">{{$sister_concern}}</h3><br/></div></div>--}}
{{--                    <div class="row table-responsive">--}}
{{--                        <div class="col-lg-12">--}}
{{--                            <table class="custom">--}}
{{--                                <thead>--}}
{{--                                <tr class="text-center">--}}
{{--                                    <td>S/L</td>--}}
{{--                                    <td>Photo</td>--}}
{{--                                    <td> Name </td>--}}
{{--                                    <td> Email </td>--}}
{{--                                    <td> Phone </td>--}}
{{--                                    <td> Salary </td>--}}
{{--                                    <td> Joining Date </td>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @forelse($employees as $employee)--}}
{{--                                    <tr>--}}
{{--                                        <td class="text-center">{{ $s++ }}</td>--}}
{{--                                        <td class="text-center"><img src="{{asset('assets/images/employees/'.$employee->image)}}" alt=""></td>--}}
{{--                                        <td class="text-center">{{$employee->name}}</td>--}}
{{--                                        <td class="text-center">{{$employee->email}}</td>--}}
{{--                                        <td class="text-center">{{$employee->phone}}</td>--}}
{{--                                        <td class="text-center">{{$employee->salary}}</td>--}}
{{--                                        <td class="text-center">{{$employee->joining_date}}</td>--}}
{{--                                    </tr>--}}
{{--                                @empty--}}
{{--                                    <tr>--}}
{{--                                        <td colspan="7" class="text-center text-danger">{{'No Employee Found'}}</td>--}}
{{--                                    </tr>--}}
{{--                                @endforelse--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-4"></div>--}}
{{--        <div class="col-md-4"><input type="button" class="print_button custom_button btn-block form-control" onclick="printDiv('sister_concern_wise_employee')" value="Print" /></div>--}}
{{--        <div class="col-md-4"></div>--}}
{{--    </div>--}}
{{--    <script>--}}
{{--        function printDiv(divName)--}}
{{--        {--}}
{{--            var printContents = document.getElementById(divName).innerHTML;--}}
{{--            var originalContents = document.body.innerHTML;--}}
{{--            document.body.innerHTML = printContents;--}}
{{--            window.print();--}}
{{--            document.body.innerHTML = originalContents;--}}
{{--        }--}}
{{--    </script>--}}
@endsection
