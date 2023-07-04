@extends('layouts.layout')

@section('title')
    فهرست فایل ها
@endsection

@section('content')
    <a class="btn btn-primary mb-3" href="{{ url('/upload') }}" >آپلود فایل</a>
    <table class="table ">
        <thead>
        <tr>
            <th>نوع</th>
            <th>نام فایل</th>
            <th>تاریخ ایجاد</th>
            <th>تاریخ آخرین ویرایش</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($files as $file)
            <tr>
                <td>{{ $file->type }}</td>

                <td><a href="{{ route('showFile', ['filename' => $file->filename,'filetype' => $file->type]) }}" target="_blank">{{ $file->filename }}</a></td>

                <td>{{ $file->created_at }}</td>
                <td>{{ $file->updated_at }}</td>
                <td><a class="btn btn-outline-primary btn-sm" href="{{ route('download', $file->id) }}">دانلود</a></td>
            </tr>
        @endforeach
        </tbody>

    </table>
@endsection
