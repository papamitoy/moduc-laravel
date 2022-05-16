@extends("layouts.home")
@section('content')
<div class="col-12" >
@if($responseSubmission)
<div class="container-fluid p-0">
<div class="row justify-content-center">
<div class="col-lg-8">
    <div class="white_card card_height_100 mb_30">
      <div class="col-lg-12 justify-content-center">

          <div class="card_box position-relative  mb_30 white_bg ">
              <div style="margin: 60px 60px 0 0;" class="float-right">
                      <div class="btn-group">

                          <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">Edit</a>
                          <a class="dropdown-item" href="#">Delete</a>
                          </div>
                      </div>
                   </div>
              <div class="white_box_tittle">
                  <div class="main-title2 ">
                      <h1 class="mb-2 nowrap">{{ $assessment->title }}</h1>
                      <small>You already responded</small>
                  </div>
              </div>
              <div style="padding-bottom: 40px; padding-top: 20px; position: relative;" class="box_body">
                    <a class="btn btn-primary" href="/subject/{{$assessment->subject->id}}">Back</a>
              </div>
          </div>
      </div>
    </div>
</div>
</div>
</div>
@elseif(!$assessment->allow_response)
<div class="container-fluid p-0">
    <div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="white_card card_height_100 mb_30">
          <div class="col-lg-12 justify-content-center">

              <div class="card_box position-relative  mb_30 white_bg ">
                  <div style="margin: 60px 60px 0 0;" class="float-right">
                          <div class="btn-group">

                              <div class="dropdown-menu">
                              <a class="dropdown-item" href="#">Edit</a>
                              <a class="dropdown-item" href="#">Delete</a>
                              </div>
                          </div>
                       </div>
                  <div class="white_box_tittle">
                      <div class="main-title2 ">
                          <h1 class="mb-2 nowrap">{{ $assessment->title }}</h1>
                          <small>Accepting response is close</small>
                      </div>
                  </div>
                  <div style="padding-bottom: 40px; padding-top: 20px; position: relative;" class="box_body">
                        <a class="btn btn-primary" href="/subject/{{$assessment->subject->id}}">Back</a>
                  </div>
              </div>
          </div>
        </div>
    </div>
    </div>
    </div>
@else
<assessment-response :assessment="{{ $assessment }}" :user="{{ Auth::user() }}" >
    {{-- @livewire('response-timer', ['assessment'=>$assessment]) --}}
</assessment-response>
@endif
</div>
@endsection
