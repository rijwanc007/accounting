@php
    use App\Admin\Message;
    use App\Admin\Announcement;
    $messages = Message::where('receiver_id','=',Auth::user()->id)->orderBy('id','DESC')->get();
    $announcements = Announcement::orderBy('id','DESC')->get();
@endphp
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{route('home')}}"><img src="{{asset('assets/images/logo/setcol-content.png')}}" alt="logo" /></a>
        <a class="{{--navbar-brand brand-logo-mini--}}" href="{{route('home')}}">{{--<img src="{{asset('assets/images/logo/setcol-content.png')}}" alt="logo" />--}}</a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <div class="nav-profile-img">
                        <img src="{{asset('assets/images/user/'.Auth::user()->image)}}" alt="image">
                        <span class="availability-status online"></span>
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black">{{Auth::user()->name}}</p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout mr-2 text-primary"></i>{{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
                <a class="nav-link">
                    <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-email-outline"></i>
                    <span class="count-symbol bg-warning"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                    <h6 class="p-3 mb-0 text-center">Messages</h6>
                    @if($messages->count() ==! 0)
                    @foreach($messages as $message)
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item" href="{{url('/message/details',$message->id)}}">
                        <div class="preview-thumbnail">
                            <img src="{{asset('assets/images/user/'.$message->sender_image)}}" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                            <h6 class="preview-subject ellipsis mb-1 font-weight-normal">{{str_limit($message->message,$limit =15,$end='...')}}</h6>
                        </div>
                    </a>
                    @endforeach
                    @else
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                <h6 class="preview-subject ellipsis mb-1 font-weight-normal">No Message Available</h6>
                            </div>
                        </a>
                    @endif
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-bell-outline"></i>
                    <span class="count-symbol bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                    <h6 class="p-3 mb-0">Notifications</h6>
                    @if($announcements->count() ==! 0)
                    @foreach($announcements as $announcement)
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item" href="{{route('announcement.show',$announcement->id)}}">
                        <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                            <h6 class="preview-subject font-weight-normal mb-1 text-center">{!! str_limit($announcement->announcement_name,$limit=15,$end='....') !!}</h6>
                            <p>Create By : {!! str_limit($announcement->creator_name,$limit = 15,$end='...') !!}</p>
                            <p class="text-gray ellipsis mb-0">{!! str_limit($announcement->announcement_description,$limit = 20,$end='....') !!}</p>
                        </div>
                    </a>
                    @endforeach
                    @else
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                            <h6 class="preview-subject ellipsis mb-1 font-weight-normal">No Announcement Available</h6>
                        </div>
                    </a>
                    @endif
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
