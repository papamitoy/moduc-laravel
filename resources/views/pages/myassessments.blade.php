@extends("layouts.home")
@section("pageTitle")
    My Assessments
@endsection
@section("content")

<my-assessment :mainassessments="{{$mainassessments}}" :subjects="{{$subjects}}"></my-assessment>
@endsection
