@php
    $sister_concerns = \App\SisterConcern::orderBy('id', 'DESC')->get();
@endphp
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{asset('/assets/images/user/'. Auth::user()->image)}}" alt="profile">
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{Auth::user()->name}}</span>
                    <span class="text-secondary text-small">{{Auth::user()->email}}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('home')}}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item @yield('admin')">
            <a class="nav-link" data-toggle="collapse" href="#admin-basic" @if(View::hasSection('admin')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="admin-basic">
                <span class="menu-title">Admin</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon"></i>
            </a>
            <div class="collapse @yield('admin-show')" id="admin-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item @yield('user')">
                        <a class="nav-link" data-toggle="collapse" href="#user-basic" @if(View::hasSection('user')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="ui-basic">
                            <span class="menu-title">User's</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse @yield('user-show')" id="user-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link @yield('user-create')" href="{{route('user.create')}}">Create</a></li>
                                <li class="nav-item"> <a class="nav-link @yield('user-index')" href="{{route('user.index')}}">Index</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item @yield('role')">
                        <a class="nav-link" data-toggle="collapse" href="#role-basic" @if(View::hasSection('role')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="role-basic">
                            <span class="menu-title">Role's</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse @yield('role-show')" id="role-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link @yield('role-create')" href="{{route('role.create')}}">Create</a></li>
                                <li class="nav-item"> <a class="nav-link @yield('role-index')" href="{{route('role.index')}}">Index</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item @yield('management')">
            <a class="nav-link" data-toggle="collapse" href="#management-basic" @if(View::hasSection('management')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="management-basic">
                <span class="menu-title">Management</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-magnet-on menu-icon"></i>
            </a>
            <div class="collapse @yield('management-show')" id="management-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item  @yield('sister-concern')">
                        <a class="nav-link" data-toggle="collapse" href="#sister-concern-basic" @if(View::hasSection('sister-concern')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="sister-concern-basic">
                            <span class="menu-title">Sister Concern's</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse @yield('sister-concern-show')" id="sister-concern-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link @yield('sister-concern-create')" href="{{route('sister_concern.create')}}">Create</a></li>
                                <li class="nav-item"> <a class="nav-link @yield('sister-concern-index')" href="{{route('sister_concern.index')}}">Index</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item  @yield('account')">
            <a class="nav-link" data-toggle="collapse" href="#account-basic" @if(View::hasSection('account')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="account-basic">
                <span class="menu-title">Account's</span><i class="menu-arrow"></i><i class="mdi mdi-credit-card-marker menu-icon"></i>
            </a>
            <div class="collapse @yield('account-show')" id="account-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item @yield('chart_of_account')">
                        <a class="nav-link" data-toggle="collapse" href="#chart_of_account-basic" @if(View::hasSection('chart_of_account')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="chart_of_account-basic">
                            <span class="menu-title">Chart</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse @yield('chart_of_account-show')" id="chart_of_account-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link  @yield('chart_of_account-create')" href="{{route('chart_of_account.create')}}">Create</a></li>
                                <li class="nav-item @yield('index')">
                                    <a class="nav-link" data-toggle="collapse" href="#index-basic" @if(View::hasSection('index')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="index-basic">
                                        <span class="menu-title">Index</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="collapse @yield('index-show')" id="index-basic">
                                        <ul class="nav flex-column sub-menu">
                                            @foreach($sister_concerns as $sister_concern)
                                                <li class="nav-item"> <a class="nav-link @yield('chart_of_account-'. $sister_concern->id)" href="{{route('chart_of_account.index',$sister_concern->id)}}" title="{{$sister_concern->name}}">{{substr($sister_concern->name, 0, 15)}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item @yield('vouchar')">
                        <a class="nav-link" data-toggle="collapse" href="#vouchar-basic" @if(View::hasSection('vouchar')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="received-basic">
                            <span class="menu-title">Vouchar</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse @yield('vouchar-show')" id="vouchar-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item @yield('credit_voucher')">
                                    <a class="nav-link" data-toggle="collapse" href="#credit_voucher-basic" @if(View::hasSection('credit_voucher')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="credit_voucher-basic">
                                        <span class="menu-title">Credit Voucher</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="collapse @yield('credit_voucher-show')" id="credit_voucher-basic">
                                        <ul class="nav flex-column sub-menu">
                                            <li class="nav-item"> <a class="nav-link @yield('credit_voucher-create')" href="{{route('credit_voucher.create')}}">Create</a></li>
                                            <li class="nav-item"> <a class="nav-link @yield('credit_voucher-index')" href="{{route('credit_voucher.index')}}">Index</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item @yield('debit_voucher')">
                                    <a class="nav-link" data-toggle="collapse" href="#debit_voucher-basic" @if(View::hasSection('debit_voucher')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="debit_voucher-basic">
                                        <span class="menu-title">Debit Voucher</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="collapse @yield('debit_voucher-show')" id="debit_voucher-basic">
                                        <ul class="nav flex-column sub-menu">
                                            <li class="nav-item"> <a class="nav-link @yield('debit_voucher-create')" href="{{route('debit_voucher.create')}}">Create</a></li>
                                            <li class="nav-item"> <a class="nav-link @yield('debit_voucher-index')" href="{{route('debit_voucher.index')}}">Index</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item @yield('contra-journal')">
                                    <a class="nav-link" data-toggle="collapse" href="#contra-journal-basic" @if(View::hasSection('contra-journal')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="contra-journal-basic">
                                        <span class="menu-title">Contra Journal</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="collapse @yield('contra-journal-show')" id="contra-journal-basic">
                                        <ul class="nav flex-column sub-menu">
                                            <li class="nav-item"> <a class="nav-link @yield('contra-journal-create')" href="{{route('contra_journal.create')}}">Create</a></li>
                                            <li class="nav-item"> <a class="nav-link @yield('contra-journal-index')" href="{{route('contra_journal.index')}}">Index</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item @yield('journal')">
                                    <a class="nav-link" data-toggle="collapse" href="#journal-basic" @if(View::hasSection('journal')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="contra-journal-basic">
                                        <span class="menu-title">Journal</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="collapse @yield('journal-show')" id="journal-basic">
                                        <ul class="nav flex-column sub-menu">
                                            <li class="nav-item"> <a class="nav-link @yield('journal-create')" href="{{route('journal.create')}}">Create</a></li>
                                            <li class="nav-item"> <a class="nav-link @yield('journal-index')" href="{{route('journal.index')}}">Index</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item"> <a class="nav-link @yield('account-ledger')" href="{{route('report.ledger')}}">Ledger</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item @yield('bank')">
            <a class="nav-link" data-toggle="collapse" href="#bank-basic" @if(View::hasSection('bank')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="head-basic">
                <span class="menu-title">Bank</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-bank menu-icon"></i>
            </a>
            <div class="collapse @yield('bank-show')" id="bank-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link @yield('bank-create')" href="{{route('bank.create')}}">Create</a></li>
                    <li class="nav-item"> <a class="nav-link @yield('bank-index')" href="{{route('bank.index')}}">Index</a></li>
                    <li class="nav-item  @yield('chequebook')">
                        <a class="nav-link" data-toggle="collapse" href="#chequebook-basic" @if(View::hasSection('chequebook')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="chequebook-basic">
                            <span class="menu-title">Chequebook's</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse @yield('chequebook-show')" id="chequebook-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link @yield('cheque-create')" href="{{route('cheque.create')}}">Chequebook Entry</a></li>
                                <li class="nav-item"> <a class="nav-link @yield('cheque-index')" href="{{route('cheque.index')}}">Chequebook Print</a></li>
                            </ul>
                        </div>
                    </li>
{{--                    <li class="nav-item  @yield('bank-cash-status')">--}}
{{--                        <a class="nav-link" data-toggle="collapse" href="#bank-cash-status-basic" @if(View::hasSection('bank-cash-status')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="'bank-cash-status-basic">--}}
{{--                            <span class="menu-title">Status</span><i class="menu-arrow"></i>--}}
{{--                        </a>--}}
{{--                        <div class="collapse @yield('bank-cash-status-show')" id="bank-cash-status-basic">--}}
{{--                            <ul class="nav flex-column sub-menu">--}}
{{--                                <li class="nav-item"> <a class="nav-link @yield('bank-status')" href="{{route('bank.status')}}">Bank</a></li>--}}
{{--                                <li class="nav-item"> <a class="nav-link @yield('cash-status')" href="{{route('cash.status')}}">Cash</a></li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </li>--}}
                </ul>
            </div>
        </li>
        <li class="nav-item @yield('report')">
            <a class="nav-link" data-toggle="collapse" href="#report-basic" @if(View::hasSection('report')) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="ui-basic">
                <span class="menu-title">Report</span><i class="menu-arrow"></i><i class="mdi mdi-file menu-icon"></i>
            </a>
            <div class="collapse @yield('report-show')" id="report-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link @yield('income_statement-report')" href="{{route('report.income_statement')}}">Income Statement</a></li>
                    <li class="nav-item"> <a class="nav-link @yield('balance_sheet-report')" href="{{route('report.balance')}}">Balance Sheet</a></li>
                    <li class="nav-item"> <a class="nav-link @yield('cash_flow_statement-report')" href="{{route('report.cash_flow_statement')}}">Cash Flow Statement</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
