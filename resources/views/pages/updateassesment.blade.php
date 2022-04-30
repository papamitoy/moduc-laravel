@extends("layouts.home")
@section("pageTitle")
Mudoc |  {{ $subject->subject_name }} : Update assessment
@endsection

@section('content')
    <update-assessment :section="{{ $section }}" :subject="{{ $subject }}" :assessment="{{$assessment}}"></update-assessment>
@endsection
