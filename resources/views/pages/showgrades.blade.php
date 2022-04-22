@extends("layouts.home")

@section("pageTitle")
    Mudoc | {{$subject->subject_name}} : Grade sheet
@endsection

@section('content')
<excel-grades :subject="{{ $subject }}" :module_section="{{ $moduleSection }}"></excel-grades>
@endsection
