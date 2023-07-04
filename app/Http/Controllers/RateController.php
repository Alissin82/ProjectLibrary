<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Rate;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class RateController extends Controller
{
    public function rate($project_id, $rate_value): Response
    {
        // تولید شناسه کاربر به صورت تصادفی
        $user_id = rand(1, 10);

        // جستجوی امتیاز موجود با استفاده از شناسه کاربر و شناسه پروژه
        $existingRate = Rate::where('user_id', $user_id)->where('project_id', $project_id)->first();

        if ($existingRate) {
            $existingRate->rate = $rate_value;
            $existingRate->save();

            $message = "امتیاز شما با موفقیت ویرایش شد";
        } else {
            // ایجاد یک امتیاز جدید
            $rate = new Rate();
            $rate->user_id = $user_id;
            $rate->project_id = $project_id;
            $rate->rate = $rate_value;
            $rate->save();

            $message = "امتیاز شما با موفقیت ثبت شد";
        }

        // محاسبه میانگین امتیازها برای پروژه مورد نظر
        $averageRate = DB::table('rates')
            ->where('project_id', $project_id)
            ->avg('rate');

        // به روزرسانی مقدار رتبه‌بندی پروژه
        $project = Project::where('id', $project_id)->first();

        $project->rate = round($averageRate,1);
        $project->save();

        return response($message, 200); // بازگردانی پاسخ به صورت متن

    }

}
