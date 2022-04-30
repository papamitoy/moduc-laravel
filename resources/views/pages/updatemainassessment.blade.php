@extends("layouts.home")
@section("pageTitle")
Mudoc |   Update assessment
@endsection

@section('content')
    <create-assessment  :mainassessment="{{$mainassessment}}"></create-assessment>
@endsection
