@extends('layouts.layout')

@section('title')
    فهرست پروژه ها
@endsection

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th>عنوان</th>
                <th>کلیدواژه‌ها</th>
                <th>توضیحات</th>
                <th>فناوری ها</th>
                <th>نگاهی به آینده</th>
                <th>نمره استاد</th>
                <th>امتیاز کاربران</th>
                <th>تاریخ ثبت پروژه</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($projects as $project)
            <tr>
                <td>
                    <a href="{{ route('showProject', ['id' => $project->id]) }}" title="مشاهده پروژه" >
                        {{ $project->title }}
                    </a>
                </td>

                <td>
                    @foreach (json_decode($project->keywords, true) as $keyword)
                        {{ $keyword }}<br>
                    @endforeach
                </td>

                <td>{{ substr($project->description,0,100) }}...</td>

                <td>
                    @foreach (json_decode($project->technologies, true) as $technology)
                        {{ $technology }}<br>
                    @endforeach
                </td>

                <td>{{ $project->look_to_future }}</td>

                <td>{{ $project->score }}</td>

                <td>{{ $project->rate }}</td>

                <td>{{ $project->created_at }}</td>
            </tr>
        @endforeach
        </tbody>

    </table>
@endsection
