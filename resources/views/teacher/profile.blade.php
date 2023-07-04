@extends('layouts.layout')

@section('title')
    پروفایل استاد
@endsection

@section('content')
    <form method="post" action="/teacher/projects">
        @csrf
        <input type="hidden" value="{{rand(1,3)}}" name="teacher_id">
        <input type="submit" value="پروژه های این استاد">
    </form>
@endsection
