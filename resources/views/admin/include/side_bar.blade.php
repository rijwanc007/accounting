<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
         <a href="#" class="nav-link">
            <div class="nav-profile-image">
              <img src="{{asset('assets/images/user/'.Auth::user()->image)}}" alt="profile">
              <span class="login-status online"></span>
            </div>
            <div class="nav-profile-text d-flex flex-column">
               <span class="font-weight-bold mb-2">{{Auth::user()->name}}</span>
               <span class="text-secondary text-small">{{Auth::user()->position}}</span>
            </div>
             <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('home')}}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#user-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">User</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi mdi-account-circle menu-icon"></i>
            </a>
            <div class="collapse" id="user-basic">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('user.index')}}">All User</a></li>
            </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#account-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Account</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
            <div class="collapse" id="account-basic">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('account.index')}}">All Account</a></li>
            </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#voucher-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Voucher</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi mdi-receipt menu-icon"></i>
            </a>
            <div class="collapse" id="voucher-basic">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="">All Voucher</a></li>
            </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#report-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Report</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi mdi-book-open menu-icon"></i>
            </a>
            <div class="collapse" id="report-basic">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="">Ledger</a></li>
                <li class="nav-item"> <a class="nav-link" href="">Trail Balance</a></li>
                <li class="nav-item"> <a class="nav-link" href="">Ledger(Duel Currency)</a></li>
                <li class="nav-item"> <a class="nav-link" href="">Cash Trail Balance</a></li>
                <li class="nav-item"> <a class="nav-link" href="">Cash Trail Balance(Including Head)</a></li>
            </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Tools</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-toolbox menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
                 <li class="nav-item"> <a class="nav-link" href="{{route('main_head.index')}}">Main Head</a></li>
                 <li class="nav-item"> <a class="nav-link" href="{{route('sub_head.index')}}">Sub Head</a></li>
                 <li class="nav-item"> <a class="nav-link" href="{{route('sub_sub__head.index')}}">Sub Sub Head</a></li>
            </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#announcement-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Announcement</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi mdi-bell-ring menu-icon"></i>
            </a>
            <div class="collapse" id="announcement-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('announcement.index')}}">All Announcement</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#message-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Message</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi mdi-message menu-icon"></i>
            </a>
            <div class="collapse" id="message-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('message.index')}}">All Message</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#role-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Role</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi mdi mdi-account-key menu-icon"></i>
            </a>
            <div class="collapse" id="role-basic">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="">All Role</a></li>
            </ul>
            </div>
        </li>
    </ul>
</nav>
