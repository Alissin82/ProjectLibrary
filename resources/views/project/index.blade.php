@extends('layouts.layout')

@section('title')
    {{ $project->title }}
@endsection

@section('content')
    <div>
        <a class="btn btn-outline-primary" href="/projects">مشاهده تمام پروژه ها</a>
    </div>

    <div id="toast-area" style="position: absolute; top: 1em; right: 1em;">

    </div>

    <div class="mb-3 d-flex">
        <h1>{{ $project->title }}</h1>

        <div class="d-flex flex-wrap align-content-center">
            @for($i=1;$i<=5;$i++)
                <a href="{{ route('rate', ['project_id' => $project->id, 'rate' => $i]) }}" class="rate-link">
                    <span class="far fa-star text-warning"></span>
                </a>
            @endfor
        </div>

        <a href="{{ route('bookmark', ['project_id' => $project->id]) }}" id="bookmark-button"><span class="far fa-bookmark"></span></a>
        @php
            use Illuminate\Support\Facades\DB;
            $countBookmark = DB::table('bookmarks')
            ->where('project_id', $project->id)
            ->count('id');
            echo "($countBookmark)";
        @endphp
    </div>

    <div class="px-3">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h2>کلیدواژه‌ها</h2>
                <p>
                    @foreach (json_decode($project->keywords, true) as $keyword)
                        {{ $keyword }},
                    @endforeach
                </p>
            </div>

            <div>
                <h2>نمره استاد</h2>
                <p>{{ $project->score }}</p>
            </div>

            <div>
                <h2>امتیاز کاربران</h2>
                <p>
                    {{ $project->rate }}
                    @php
                        $countRate = DB::table('rates')
                        ->where('project_id', $project->id)
                        ->count('rate');
                        echo "($countRate)";
                    @endphp
                </p>
            </div>

            <div>
                <h2>تاریخ ثبت</h2>
                <p>{{ $project->created_at }}</p>
            </div>
        </div>

        <div class="mb-3">
            <h2>توضیحات</h2>
            <p>{{ $project->description }}</p>
        </div>

        <div class="d-flex mb-3">
            <div>
                <h2>فناوری های استفاده شده</h2>
                <p>
                    @foreach (json_decode($project->technologies, true) as $technology)
                        {{ $technology }}<br>
                    @endforeach
                </p>
            </div>

            <div class="flex-grow pe-5">
                <h2>نگاهی به آینده</h2>
                <p>{{ $project->look_to_future }}</p>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        function createToast(message) {
            // ایجاد عنصر div جدید
            const toastDiv = document.createElement("div");

            // تنظیم کلاس برای div
            toastDiv.classList.add("toast", "show", "fade", "toast-success", "mb-2");

            // تنظیم ویژگی های دیگر برای div
            toastDiv.setAttribute("data-mdb-autohide", "true");
            toastDiv.id = "success-div";

            // ایجاد عنصر div دیگر برای header
            const headerDiv = document.createElement("div");
            headerDiv.classList.add("toast-header", "toast-success", "d-flex", "flex-row-reverse");

            // ایجاد آیکون
            const icon = document.createElement("i");
            icon.classList.add("fas", "fa-check", "fa-lg", "me-2");

            // ایحاد المان strong برای متن عنوان
            const strongElement = document.createElement("strong");
            strongElement.classList.add("me-auto");
            strongElement.innerText = "موفقیت";

            // ایجاد دکمه بستن
            const closeButton = document.createElement("button");
            closeButton.type = "button";
            closeButton.classList.add("btn-close");
            closeButton.setAttribute("data-mdb-dismiss", "toast");
            closeButton.setAttribute("aria-label", "Close");

            // اضافه کردن آیکون، strong و دکمه بستن به header
            headerDiv.appendChild(icon);
            headerDiv.appendChild(strongElement);
            headerDiv.appendChild(closeButton);

            // ایجاد عنصر div برای بدنه متن
            const bodyDiv = document.createElement("div");
            bodyDiv.classList.add("toast-body", "text-start");
            bodyDiv.id = "success-message";
            bodyDiv.innerText = message;

            // الحاق header و body به div اصلی
            toastDiv.appendChild(headerDiv);
            toastDiv.appendChild(bodyDiv);

            // الحاق div به عنصر با شناسه "toast-area"
            const toastArea = document.getElementById("toast-area");
            if (toastArea) {
                toastArea.appendChild(toastDiv);
            }
        }

        // فراخوانی تابع برای ایجاد toast

        // فعال‌سازی رویداد کلیک بر روی لینک‌های با کلاس "rate-link"
        document.querySelectorAll('.rate-link').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // مانع از اجرای عملیات پیش‌فرض لینک شود

                const url = this.getAttribute('href'); // URL عملیات را از ویژگی href لینک دریافت می‌کنیم

                // ارسال درخواست AJAX
                fetch(url)
                    .then(response => response.text()) // دریافت داده‌های پاسخ در قالب متن
                    .then(data => {
                        createToast(data);
                    })
                    .catch(error => console.error(error)); // در صورت بروز خطا، گزارش خطا در کنسول نمایش داده می‌شود
            });
        });

        document.getElementById('bookmark-button').addEventListener('click', function (event) {
            event.preventDefault(); // مانع از اجرای عملیات پیش‌فرض لینک شود

            const url = this.getAttribute('href'); // URL عملیات را از ویژگی href لینک دریافت می‌کنیم

            console.log(url);

            // ارسال درخواست AJAX
            fetch(url)
                .then(response => response.text()) // دریافت داده‌های پاسخ در قالب متن
                .then(data => {
                    createToast(data);
                })
                .catch(error => console.error(error)); // در صورت بروز خطا، گزارش خطا در کنسول نمایش داده می‌شود
        });
    </script>
@endsection
