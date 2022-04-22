@extends("layouts.home")
@section("pageTitle")
Mudoc |  {{ $subject->subject_name }} : Create assessment
@endsection

@section('content')
    <create-assessment :section="{{ $section }}" :subject="{{ $subject }}"></create-assessment>
@endsection
