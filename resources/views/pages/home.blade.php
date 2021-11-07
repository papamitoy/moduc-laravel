@extends("layouts.home")
@section("content")
           @foreach (Auth::user()->subjects as $subject)
           <div class="col-md-6 col-lg-6 col-xl-4 box-col-6">
            <div class="card custom-card">
                <div class="card-header"><img class="img-fluid" src="{{ asset("pages/img/profilebox/3.jpg")}}" alt="" data-original-title="" title="">
                    <h1 style="position: absolute; top: 0;  left: 0; color: white; "><strong>{{ $subject->subject_name }}</strong><br>
                    <small style="position: absolute; font-size: 20px;">{{ $subject->class_name }}</small></h1>




                </div>
                <div class="card-profile"><img class="rounded-circle" src="{{ asset("pages/img/profilebox/9.jpg")}}" alt="" data-original-title="" title=""></div>

                <div class="text-center profile-details">
                <h4>{{ Auth::user()->fullname }}</h4>
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