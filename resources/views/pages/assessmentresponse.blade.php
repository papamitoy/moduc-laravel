@extends("layouts.home")
@section('content')

<assessment-response :assessment="{{ $assessment }}" :user="{{ Auth::user() }}"></assessment-response>
@endsection
