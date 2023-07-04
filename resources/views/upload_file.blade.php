@extends('layouts.layout')

@section('title')
    آپلود فایل
@endsection

@section('content')
    <a class="btn btn-primary mb-3" href="{{ url('/files') }}" >فهرست فایل ها</a>
    <form action="{{ url('/upload') }}" method="post" enctype="multipart/form-data" class="needs-validation container " novalidate>
        @csrf
        @if(Session::has('success'))
            <div class="alert alert-success" >
                {{Session::get('success')}}
            </div>
        @endif
        <div class="row mb-3">
            <div class="col">
                <label for="pdf"><span class="text-danger" >*</span>مستندات :</label>
                <input type="file" class="form-control" id="pdf" name="pdf" required accept=".pdf">
            </div>
            <div class="col">
                <label for="image">تصویر :</label>
                <input type="file" class="form-control" id="image" name="image" accept=".jpg, .png">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="compressed">فایل های فشرده شده :</label>
                <input type="file" class="form-control" id="compressed" name="compressed" accept=".zip, .rar">
            </div>
        </div>
        <input type="submit" class="btn btn-primary" value="ثبت">
        <input type="hidden" name="project_id" value="0">
    </form>
@endsection
