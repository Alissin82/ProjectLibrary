<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    public function bookmark($project_id): Response
    {
        // تولید شناسه کاربر به صورت تصادفی
        $user_id = rand(1, 10);

        // بررسی وجود نشانه گذاری قبلی
        $existingBookmark = Bookmark::where('user_id', $user_id)->where('project_id', $project_id)->first();

        if ($existingBookmark) {
            // حذف نشانه گذاری موجود
            $existingBookmark->delete();
            $message = "نشانه گذاری شما با موفقیت حذف شد";
        } else {
            // ایجاد یک نشانه گذاری جدید
            $bookmark = new Bookmark();
            $bookmark->user_id = $user_id;
            $bookmark->project_id = $project_id;
            $bookmark->save();

            $message = "نشانه گذاری شما با موفقیت ثبت شد";
        }


        return response("$message", 200); // بازگردانی پاسخ به صورت متن
    }


}
