@extends("layouts.home")
@section('content')
<excel-grades :subject="{{ $subject }}" :module_section="{{ $moduleSection }}"></excel-grades>
@endsection