<nav class="sidebar">
    <div class="logo d-flex justify-content-between">
        <a class="large_logo" href="/"><img src="{{ asset("pages/img/logo.png") }}" alt=""></a>
        <a class="small_logo" href="/"><img src="{{ asset("pages/img/mini_logo.png") }}" alt=""></a>
        <div class="sidebar_close_icon d-lg-none">
            <i class="ti-close"></i>
        </div>
    </div>
    <ul id="sidebar_menu">
        <li>
            <a href="/" aria-expanded="false">
                <div class="nav_icon_small">
                   <div class="fas fa-home"></div>
                </div>
                <div class="nav_title">
                    <span>Classes</span>
                </div>
            </a>
        </li>
       @if (Auth::user()->isAdviser())
        <h4 class="menu-text"><span>TEACHING</span> <i class="fas fa-ellipsis-h"></i> </h4>
        @foreach (Auth::user()->subjects as $subject)
        <li>
            <a href="/subject/{{ $subject->id }}" aria-expanded="false">
                <div class="nav_icon_small">
                    <img src="{{ asset("pages/img/menu-icon/2.svg")}}" alt="">
                </div>
                <div class="nav_title">
                    <span>{{ $subject->subject_name }}</span>
                </div>
            </a>
        </li>
        @endforeach

        @else
        <h4 class="menu-text"><span>Enrolled</span> <i class="fas fa-ellipsis-h"></i> </h4>

        @foreach (Auth::user()->enroll as $subject)
        <li>
            <a href="/subject/{{ $subject->subject->id }}" aria-expanded="false">
                <div class="nav_icon_small">
                    <img src="{{ asset("pages/img/menu-icon/2.svg")}}" alt="">
                </div>
                <div class="nav_title">
                    <span>{{ $subject->subject->subject_name }}</span>
                </div>
            </a>
        </li>
        @endforeach

       @endif


      </ul>
</nav>
