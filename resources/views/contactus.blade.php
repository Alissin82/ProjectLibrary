@extends('layouts.layout')

@section('title')
    تماس با ما
@endsection

@section('content')
    <a class="btn btn-primary" href="{{ url('/upload') }}" >
        آپلود فایل
    </a>
    <form action="{{ url('/contact') }}" method="post" class="needs-validation container" novalidate>
        @csrf
        @if(Session::has('success'))
            <div>
                {{Session::get('success')}}
            </div>
        @endif
        <div class="row mb-3">
            <div class="col">
                <label for="name">نام :</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col">
                <label for="email">ایمیل :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="message">پیام :</label>
            <textarea class="form-control" id="message" name="message" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">ارسال</button>
    </form>
@endsection
