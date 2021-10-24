@extends("layouts.home")
@section("content")
           @foreach (Auth::user()->subjects as $subject)
           <div class="col-md-6 col-lg-6 col-xl-4 box-col-6">
            <div class="card custom-card">
                <div class="card-header"><img class="img-fluid" src="pages/img/profilebox/3.jpg" alt="" data-original-title="" title=""><h1 style="position: absolute; top: 8px;  left: 16px; color: white; ">CAP 101 <br><span>asdad</span></h1></div>
                <div class="card-profile"><img class="rounded-circle" src="pages/img/profilebox/9.jpg" alt="" data-original-title="" title=""></div>
                
                <div class="text-center profile-details">
                <h4>{{ Auth::user()->email }}</h4>
                <h6>{{ Auth::user()->type }}</h6>
                </div>
                
                <div class="card-footer row">
                <div class="col-4 col-sm-4">
                    <h6>Student</h6>
                    <h3 class="counter">54</h3>
                </div>
                    <div class="col-4 col-sm-8">
                    <button onclick="" class="btn_1 w-100 mb-2 btn-lg email-gradient gradient-9-hover email__btn waves-effect">View</button>
                </div>
                
                </div>
            </div>
        </div>
           @endforeach
@endsection