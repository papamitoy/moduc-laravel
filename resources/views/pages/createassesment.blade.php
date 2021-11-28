@extends("layouts.home")
@section('content')
    <create-assessment :section="{{ $section }}" :subject={{ $subject }}></create-assessment>
@endsection
