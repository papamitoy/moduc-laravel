@extends("layouts.home")
@section('content')
<check-response :students="{{ json_encode($students) }}" :subject="{{ $subject }}" :responses="{{ $responses }}" :assessment="{{ $assessment }}"></check-response>
@endsection
