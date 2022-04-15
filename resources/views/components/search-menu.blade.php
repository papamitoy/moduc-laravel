
<div class="container-fluid no-gutters">
    <div class="row">
        <div class="col-lg-12 p-0 ">
            <div class="header_iner d-flex justify-content-between align-items-center">
                <div class="sidebar_icon d-lg-none">
                    <i class="ti-menu"></i>
                </div>
                <label class="switch_toggle d-none d-lg-block" for="checkbox">
                    <input type="checkbox" id="checkbox">
                    <div class="slider round open_miniSide"></div>
                </label>

                <div class="header_right d-flex justify-content-between align-items-center">
                    <div class="header_notification_warp d-flex align-items-center">
                        <li>
                            <a class="bell_notification_clicker" href="#"> <img src="{{ asset("pages/img/icon/bell.svg")}}" alt="">
                                @if (Auth::user()->notificationCount() > 0)
                                <span>{{Auth::user()->notificationCount()}} </span>
                                @endif
                            </a>

                            <!-- Menu_NOtification_Wrap  -->
                        <div class="Menu_NOtification_Wrap">
                            <div class="notification_Header">
                                <h4>Notifications</h4>
                            </div>
                            <div class="">
                                <!-- single_notify  -->
                                @forelse  (Auth::user()->notifications as $notification)
                                <a href="/notify-redirect?url={{$notification->link}}&id={{$notification->id}}" class="p-3 single_notify d-flex align-items-center" @if (!$notification->seen)style="background: rgba(0,0,0,.1)"@endif >
                                    <div class="notify_content">
                                       <span style="color:#222">{{$notification->title}} </span>
                                        <p>{{ $notification->body }}</p>
                                    </div>
                                </a>

                                @empty
                                <div class="p-3 single_notify d-flex align-items-center"  >
                                    <div class="text-center pt_20 ">
                                       No notifications
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                        <!--/ Menu_NOtification_Wrap  -->
                        </li>
                        {{-- <li>
                            <a class="CHATBOX_open" href="#"> <img src="{{ asset("pages/img/icon/msg.svg")}}" alt=""> <span>2</span>  </a>
                        </li> --}}
                    </div>

                    <div class="profile_info">
                        <img src="{{ asset("pages/img/client_img.png")}}" alt="#">
                        <div class="profile_info_iner">
                            <div class="profile_author_name">
                                <p style="font-size: 12px; opacity: .9;">{{Auth::user()->type}}</p>
                                <h5 style="font-size: 15px;" >{{Auth::user()->fullname}}</h5>
                            </div>
                            <div class="profile_info_details">
                                <a href="#">My Profile </a>
                                <a href="#">Settings</a>
                                <a href="/logout" >Log Out </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

