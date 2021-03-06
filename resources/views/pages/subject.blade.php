@extends("layouts.home")
@section("pageTitle")
    Mudoc | {{ $subject->subject_name  }}
@endsection
@section("pagesStyles")
    <style>
        .subject-title{
            font-size: 30px;
            font-weight: bold;
        }
        .edit-subject{
            display: none;
        }
        .subject-title:hover ~ .edit-subject,
        .subject-title:hover{
           display: inline  !important;
           cursor: pointer;
        }
    </style>
@endsection
@section('content')

    <div class="col-12">
        <div class="white_card mb_30 ">
            <div class="white_card_header">
                <div class="bulder_tab_wrapper">
                    <ul class="nav justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="Themes-tab" data-toggle="tab" href="#Themes" role="tab"
                                aria-controls="Themes" aria-selected="true">Stream</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="page-tab" data-toggle="tab" href="#page" role="tab"
                                aria-controls="profile" aria-selected="false">Classwork</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="Header-tab" data-toggle="tab" href="#Header" role="tab"
                                aria-controls="Header" aria-selected="false">People</a>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="white_card_body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="Themes" role="tabpanel" aria-labelledby="Themes-tab">
                        <div class="builder_select">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div style=" background-image: url({{ asset('pages/img/profilebox/1.jpg') }}); height: 200px; width: 100%; "
                                        class="white_box mb_30"
                                        style="background-image: linear-gradient(to right, rgba(0,177,232,2), rgba(0,234,211,2));">

                                        <div class="row justify-content-center">
                                            <div class="col-lg-12">
                                                <div class="header">
                                                    <div style="color: white;" data-toggle="modal" data-target="#updateClass">
                                                       <span class="subject-title"> {{ $subject->subject_name }} </span>
                                                       <div class="fas fa-pen edit-subject" ></div>
                                                    </div>
                                                    <p style="color: white;">{{ $subject->section_name }}</p>
                                                     @if(Auth::user()->isAdviser())
                                                    <p style="color: white;">SUBJECT CODE: {{ $subject->subject_code }}</p>
                                                    <a class="btn btn-primary mt-2" href="/subject/{{ $subject->id }}/grades" target="_BLANK">VIEW CLASS RECORD</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="white_card box_shadow">
                                        <div class="white_card_header border_bottom_1px">
                                            <h4 class="card-title mb-0">Upcomming</h4>
                                        </div>

                                        <!--end white_card_header border_bottom_1px-->
                                        <div class="card-body">
                                            @forelse ($assessments as $assessment)
                                            <div class="" style="display:flex; justify-content:space-between;width:100%;">
                                                <a target="_blank" href="/subject/{{$subject->id}}/response?assessment_id={{$assessment->id}}">{{ $assessment->title }}</a>
                                                <small>{{ date('F d ', strtotime( $assessment->deadline)); }}</small>
                                            </div>
                                            @empty
                                            <div class="form-group row">
                                              No assessment
                                            </div>
                                            @endforelse



                                            {{-- <div class="form-group row">
                                                <div class="col-lg-9 col-xl-8 offset-lg-3 offset-xl-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <a href="#"><strong>View All</strong></a>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <!--end card-body-->
                                    </div>
                                    <!--end card-->
                                </div>

                                <div class="col-lg-9">
                                    <div class="white_box mb_30">
                                        <div class="box_header ">
                                            <div class="main-title">
                                                <h2 class="mb-0">Newsfeed</h2>
                                            </div>
                                        </div>


                                        <!--start here the container kay dre nag sogod tanan-->
                                        @forelse ($feeds as $feed)
                                        <div class="col-lg-12">
                                            <div class="white_card box_shadow">
                                                <div class="white_card_header border_bottom_1px"><img
                                                        style="display: inline-block"
                                                        src="{{ asset('pages/img/customers/1.png') }}"><strong>&nbsp;&nbsp; {{ $subject->user->fullname }}</strong></div>
                                                <!--end white_card_header border_bottom_1px-->
                                                <div class="card-body">
                                                    <div class="mx-4 mb-4">
                                                        @if(!Auth::user()->isAdviser())
                                                        <h4 class="mb-0"><a style="color:#444;" href="{!!$feed->student_link!!}">{{ $feed->title }}</a></h4>
                                                        @else
                                                        <h4 class="mb-0"><a style="color:#444;" href="{!!$feed->adviser_link!!}">{{ $feed->title }}</a></h4>
                                                        @endif
                                                       <div> <label class="col-xl-10 col-lg-10 col-form-label">{{ $feed->body }}</label></div>
                                                    </div>

                                                    {{-- <div class="form-group row">
                                                        <div class="col-lg-9 col-xl-8 ">
                                                            <div class="custom-control custom-checkbox">
                                                                <a href="#"><strong>View all comments</strong></a>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                                <!--end card-body-->
                                            </div>
                                            <!--end card-->
                                        </div><br><br>
                                        @empty

                                        @endforelse


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--classwork -->
                    <div class="tab-pane fade" id="page" role="tabpanel" aria-labelledby="page-tab">
                        <div class="row justify-content-center">
                            @foreach ($moduleSection as $section)
                                <module-section :responses="{{Auth::user()->responses}}" :user_id="{{ Auth::user()->id }}" :grades="{{  $grades }}" :assessments="{{ $section->assessments }}" :subject1="{{ json_encode($subject) }}"
                                     :is_adviser="{{ $adviser->id == Auth::user()->id ? 1 : 0 }}" :section1="{{ $section }}">
                                </module-section>
                            @endforeach
                            <!--
                                                                                    <div class="col-lg-12">
                                                                                        <div class="card_box box_shadow position-relative mb_30">
                                                                                            <div class="box_body">
                                                                                                <div class="default-according" id="accordion">
                                                                                                    <div class="card ">
                                                                                                      <div class="card-header parpel_bg" id="headingOne">
                                                                                                        <h5 class="mb-0">
                                                                                                          <img src="{{ asset('pages/img/customers/1.png') }}"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Self Assesment 1</button><span>Due Feb 1 11:00 AM</span>
                                                                                                        </h5>
                                                                                                      </div>
                                                                                                      <div class="collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordion" style="">
                                                                                                        <div class="card-body">
                                                                                                            <p>Posted Jan 14</p><br><br>
                                                                                                            <p>Write your answer for # 1 here then use the attached form for # 2. Deadline will be on Feb. 27 (Saturday) at 12:00nn. The submission is by group</p><br><br>
                                                                                                            <a href="#"><i class="fa fa-file" aria-hidden="true"> &nbsp; &nbsp;</i>View Attached File</a><br><br>
                                                                                                            <div class="border_bottom_1px"></div><br>
                                                                                                            <a href="#">View Comments</a>
                                                                                                        </div>
                                                                                                      </div>
                                                                                                    </div>

                                                                                                    <div class="card ">
                                                                                                      <div class="card-header parpel_bg" id="headingTwo">
                                                                                                        <h5 class="mb-0">
                                                                                                          <img src="{{ asset('pages/img/customers/1.png') }}"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseOne">Self Assesment 1</button><span>Due Feb 1 11:00 AM</span>
                                                                                                        </h5>
                                                                                                      </div>
                                                                                                      <div class="collapse" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordion" style="">
                                                                                                        <div class="card-body">
                                                                                                            <p>Posted Jan 14</p><br><br>
                                                                                                            <p>Write your answer for # 1 here then use the attached form for # 2. Deadline will be on Feb. 27 (Saturday) at 12:00nn. The submission is by group</p><br><br>
                                                                                                            <a href="#"><i class="fa fa-file" aria-hidden="true"> &nbsp; &nbsp;</i>View Attached File</a><br><br>
                                                                                                            <div class="border_bottom_1px"></div><br>
                                                                                                            <a href="#">View Comments</a>
                                                                                                        </div>
                                                                                                      </div>
                                                                                                    </div>
                                                                                                    <div class="card ">
                                                                                                      <div class="card-header parpel_bg" id="headingThree">
                                                                                                        <h5 class="mb-0">
                                                                                                          <img src="{{ asset('pages/img/customers/1.png') }}"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseOne">Self Assesment 1</button><span>Due Feb 1 11:00 AM</span>
                                                                                                        </h5>
                                                                                                      </div>
                                                                                                      <div class="collapse" id="collapseThree" aria-labelledby="headingThree" data-parent="#accordion" style="">
                                                                                                        <div class="card-body">
                                                                                                            <p>Posted Jan 14</p><br><br>
                                                                                                            <p>Write your answer for # 1 here then use the attached form for # 2. Deadline will be on Feb. 27 (Saturday) at 12:00nn. The submission is by group</p><br><br>
                                                                                                            <a href="#"><i class="fa fa-file" aria-hidden="true"> &nbsp; &nbsp;</i>View Attached File</a><br><br>
                                                                                                            <div class="border_bottom_1px"></div><br>
                                                                                                            <a href="#">View Comments</a>
                                                                                                        </div>
                                                                                                      </div>
                                                                                                    </div>
                                                                                                  </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div> -->
                        </div>

                    </div>
                    <!--/classwork -->

                    <div class="tab-pane fade" id="Header" role="tabpanel" aria-labelledby="Header-tab">
                        <div class="builder_select">
                            <div class="container-fluid p-0">
                                <div class="row justify-content-center ">
                                    <div class="col-md-9 box_shadow">
                                        <div class="white_box QA_section mb_30">
                                            <div class="white_box_tittle list_header">
                                                <h2>{{ $subject->subject_name }}</h2><br>

                                                <div class="box_right d-flex lms_block">
                                                    <div class="serach_field_2">
                                                        <div class="search_inner">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="white_box_tittle list_header">
                                                <h4>Adviser : {{ $adviser->fullname }}</h4>

                                                <div class="box_right d-flex lms_block">
                                                    <div class="serach_field_2">
                                                        <div class="search_inner">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="QA_table ">
                                                <!-- table-responsive -->


                                                        <manage-people :is_adviser="{{ $adviser->id == Auth::user()->id ? 1 : 0 }}" :students="{{$students}}" :adviser="{{$adviser}}"></manage-people>



                                            </div>
                                        </div><br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection
