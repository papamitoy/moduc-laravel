
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
                                <span>2</span>
                            </a>
                            <!-- Menu_NOtification_Wrap  -->
                        <div class="Menu_NOtification_Wrap">
                            <div class="notification_Header">
                                <h4>Notifications</h4>
                            </div>
                            <div class="Notification_body">
                                <!-- single_notify  -->
                                <div class="single_notify d-flex align-items-center">
                                    <div class="notify_thumb">
                                        <a href="#"><img src="{{ asset("pages/img/staf/2.png")}}" alt=""></a>
                                    </div>
                                    <div class="notify_content">
                                        <a href="#"><h5>Cool Marketing </h5></a>
                                        <p>Lorem ipsum dolor sit amet</p>
                                    </div>
                                </div>
                                <!-- single_notify  -->
                                <div class="single_notify d-flex align-items-center">
                                    <div class="notify_thumb">
                                        <a href="#"><img src="{{ asset("pages/img/staf/4.png")}}" alt=""></a>
                                    </div>
                                    <div class="notify_content">
                                        <a href="#"><h5>Awesome packages</h5></a>
                                        <p>Lorem ipsum dolor sit amet</p>
                                    </div>
                                </div>
                                <!-- single_notify  -->
                                <div class="single_notify d-flex align-items-center">
                                    <div class="notify_thumb">
                                        <a href="#"><img src="{{ asset("pages/img/staf/3.png")}}" alt=""></a>
                                    </div>
                                    <div class="notify_content">
                                        <a href="#"><h5>what a packages</h5></a>
                                        <p>Lorem ipsum dolor sit amet</p>
                                    </div>
                                </div>
                                <!-- single_notify  -->
                                <div class="single_notify d-flex align-items-center">
                                    <div class="notify_thumb">
                                        <a href="#"><img src="{{ asset("pages/img/staf/2.png")}}" alt=""></a>
                                    </div>
                                    <div class="notify_content">
                                        <a href="#"><h5>Cool Marketing </h5></a>
                                        <p>Lorem ipsum dolor sit amet</p>
                                    </div>
                                </div>
                                <!-- single_notify  -->
                                <div class="single_notify d-flex align-items-center">
                                    <div class="notify_thumb">
                                        <a href="#"><img src="{{ asset("pages/img/staf/4.png")}}" alt=""></a>
                                    </div>
                                    <div class="notify_content">
                                        <a href="#"><h5>Awesome packages</h5></a>
                                        <p>Lorem ipsum dolor sit amet</p>
                                    </div>
                                </div>
                                <!-- single_notify  -->
                                <div class="single_notify d-flex align-items-center">
                                    <div class="notify_thumb">
                                        <a href="#"><img src="{{ asset("pages/img/staf/3.png")}}" alt=""></a>
                                    </div>
                                    <div class="notify_content">
                                        <a href="#"><h5>what a packages</h5></a>
                                        <p>Lorem ipsum dolor sit amet</p>
                                    </div>
                                </div>
                            </div>
                            <div class="nofity_footer">
                                <div class="submit_button text-center pt_20">
                                    <a href="#" class="btn_1">See More</a>
                                </div>
                            </div>
                        </div>
                        <!--/ Menu_NOtification_Wrap  -->
                        </li>
                        <li>
                            <a class="CHATBOX_open" href="#"> <img src="{{ asset("pages/img/icon/msg.svg")}}" alt=""> <span>2</span>  </a>
                        </li>
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

