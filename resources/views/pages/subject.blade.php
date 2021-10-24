@extends("layouts.home")
@section("content")

    <div class="col-12">
        <div class="white_card mb_30 ">
            <div class="white_card_header">
                <div class="bulder_tab_wrapper">
                    <ul class="nav justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="Themes-tab" data-toggle="tab" href="#Themes" role="tab" aria-controls="Themes" aria-selected="true">Stream</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="page-tab" data-toggle="tab" href="#page" role="tab" aria-controls="profile" aria-selected="false">Classwork</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="Header-tab" data-toggle="tab" href="#Header" role="tab" aria-controls="Header" aria-selected="false">People</a>
                        </li>
                    </ul>
                      
                </div>
            </div>
            <div class="white_card_body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="Themes" role="tabpanel" aria-labelledby="Themes-tab">
                        <div class="builder_select">
                            <div class="row">
                                <div class="col-lg-12" >
                                    <div style=" background-image: url('pages/img/profilebox/1.jpg'); height: 200px; width: 100%; " class="white_box mb_30" style="background-image: linear-gradient(to right, rgba(0,177,232,2), rgba(0,234,211,2));">

                                        <div class="row justify-content-center">
                                            <div class="col-lg-12">
                                                <div class="header">
                                                  <h1 style="color: white;">{{ $subject->subject_name }}</h1>
                                                  <p style="color: white;">{{ $subject->section_name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                                <div  class="col-lg-3" >
                                    <div class="white_card box_shadow">
                                        <div class="white_card_header border_bottom_1px"><h4 class="card-title mb-0">Upcomming</h4></div>
                                        <!--end white_card_header border_bottom_1px-->
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label class="col-xl-10 col-lg-10 col-form-label">Wohooo No work due soon..</label>
                                            </div>
                                            <div class="form-group row">
                                                <a class="col-xl-10" href="#">Multimedia Project</a>
                                            </div>


                                            <div class="form-group row">
                                                <div class="col-lg-9 col-xl-8 offset-lg-3 offset-xl-3">
                                                    <div class="custom-control custom-checkbox">
                                                       <a href="#"><strong>View All</strong></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end card-body-->
                                    </div>
                                <!--end card-->
                                </div>
                                
                                <div class="col-lg-9">
                                    <div class="white_box mb_30">
                                        <div class="box_header ">
                                            <div class="main-title">
                                                <h2 class="mb-0" >Newsfeed</h2>
                                            </div>
                                        </div>


                                        <!--start here the container kay dre nag sogod tanan-->

                                        <div  class="col-lg-12" >
                                                <div class="white_card box_shadow">
                                                    <div class="white_card_header border_bottom_1px"><img style="display: inline-block" src="pages/img/customers/1.png"><strong>&nbsp;&nbsp;Charles Lydon Abiero</strong></div>
                                                    <!--end white_card_header border_bottom_1px-->
                                                    <div class="card-body">
                                                        <div class="form-group row">
                                                            <label class="col-xl-10 col-lg-10 col-form-label">Wohooo No work due soon..</label>
                                                        </div>
                                                        <div class="form-group row">
                                                            <a class="col-xl-12 white_card_header border_bottom_1px" href="#">FileName</a>
                                                        </div>



                                                        <div class="form-group row">
                                                            <div class="col-lg-9 col-xl-8 ">
                                                                <div class="custom-control custom-checkbox">
                                                                   <a href="#"><strong>View all comments</strong></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end card-body-->
                                                </div>
                                                <!--end card-->
                                        </div><br><br>
                                        <div  class="col-lg-12  " >
                                                <div class="white_card box_shadow">
                                                    <div class="white_card_header border_bottom_1px"><img style="display: inline-block" src="pages/img/customers/1.png"><strong>&nbsp;&nbsp;Charles Lydon Abiero</strong></div>
                                                    <!--end white_card_header border_bottom_1px-->
                                                    <div class="card-body">
                                                        <div class="form-group row">
                                                            <label class="col-xl-10 col-lg-10 col-form-label">Wohooo No work due soon..</label>
                                                        </div>
                                                        <div class="form-group row">
                                                            <a class="col-xl-12 white_card_header border_bottom_1px" href="#">FileName</a>
                                                        </div>



                                                        <div class="form-group row">
                                                            <div class="col-lg-9 col-xl-8 offset-lg-3 offset-xl-3">
                                                                <div class="custom-control custom-checkbox">
                                                                   <a href="#"><strong>View All</strong></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end card-body-->
                                                </div>
                                                <!--end card-->
                                            </div>


                                    </div>
                                </div>
                        </div>
                            
                      </div>
                    </div>
                    <!--classwork -->
<div class="tab-pane fade" id="page" role="tabpanel" aria-labelledby="page-tab">
    <div class="builder_select">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8">
               
                <div class="box_body">

                    <div class="col-lg-12">
                        <div class="card_box box_shadow position-relative mb_30">
                            <div class="box_body">
                                <div class="default-according" id="accordion">
                                    <div class="card ">
                                      <div class="card-header parpel_bg" id="headingOne">
                                        <h5 class="mb-0">
                                          <img src="img/customers/1.png"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Self Assesment 1</button><span>Due Feb 1 11:00 AM</span>
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
                                          <img src="img/customers/1.png"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseOne">Self Assesment 1</button><span>Due Feb 1 11:00 AM</span>
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
                                          <img src="img/customers/1.png"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseOne">Self Assesment 1</button><span>Due Feb 1 11:00 AM</span>
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
                    </div>
                </div>
            </div>
        </div>
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
                            <h2>CAP 101</h2><br>

                            <div class="box_right d-flex lms_block">
                                <div class="serach_field_2">
                                    <div class="search_inner">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="white_box_tittle list_header">
                            <h4>Adviser : Mary Grace Cuyno-Lozada</h4>

                            <div class="box_right d-flex lms_block">
                                <div class="serach_field_2">
                                    <div class="search_inner">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <table class="table lms_table_active">
                                <thead>

                                    <tr>
                                        <th scope="col">

                                        </th>
                                        <th scope="col"></th>
                                        <th scope="col">Name</th>

                                        <th scope="col">Details</th>
                                        <th scope="col">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                           </th>
                                        <td> <i class="fas fa-chalkboard-teacher"></i> </td>
                                        <td>
                                            <div class="media align-items-center">
                                                <img class="circle-rounded mr-3" src="img/messages/1.png" alt="" width="30" height="30"> 
                                                <div class="">
                                                    <p>Mary Grace Cuyno-Lozada</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                        <p> Adviser</p>
                                        </td>
                                        <td>
                                            <p class="">mgbcuyno@gmail.com </p>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                </tbody>

                                <thead>

                                    <tr>
                                        <th scope="col">

                                        </th>
                                        <th scope="col"></th>
                                        <th scope="col">name</th>

                                        <th scope="col">details</th>
                                        <th scope="col">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                           </th>
                                        <td> <i class="fas fa-user-alt"></i>
                                        <td>
                                            <div class="media align-items-center">
                                                <img class="circle-rounded mr-3" src="img/messages/1.png" alt="" width="30" height="30"> 
                                                <div class="">
                                                    <p>Charles Lydon Abiero</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                        <p> Student</p>
                                        </td>
                                        <td>
                                            <p class="">lydon.charles.abiero@gmail.com </p>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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