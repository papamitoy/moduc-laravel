@extends("layouts.home")
@section('content')

<check-response :students="{{ json_encode($students) }}" :responses="{{ $responses }}" :assessment="{{ $assessment }}"></check-response>
@endsection
