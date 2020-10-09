@extends('rocXolid::layouts.default')

@section('content')

{!! $component->render('include.organize', [ 'assignments' => $assignments ]) !!}

@endsection