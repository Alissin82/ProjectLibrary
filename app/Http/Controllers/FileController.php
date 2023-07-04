<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File AS F;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /*
     * نمایش فرم آپلود فایل
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|View
     */
    public function show(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('upload_file');
    }

    /*
     * بارگذاری فایل آپلود شده و ذخیره آن در بانک اطلاعاتی
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function upload(Request $request): RedirectResponse
    {
        // اعتبارسنجی درخواست با validate()
        $validated = $request->validate([
            'pdf' => 'required|mimetypes:application/pdf',
            'image' => 'sometimes|mimetypes:image/jpeg,image/png',
            'compressed' => 'sometimes|mimetypes:application/zip,application/x-rar-compressed'
        ]);

        $pdf_file_path = $request->file('pdf');

        $pdf_file_name = md5($request->input('project_id'));
        $pdf_file_name .= md5(time());
        $pdf_file_name .= md5($pdf_file_path->getClientOriginalExtension());
        $pdf_file_name .= '.' . $pdf_file_path->getClientOriginalExtension();

        Storage::disk('public')->putFileAs('files/pdf', $pdf_file_path, $pdf_file_name);

        // ایجاد رکورد در پایگاه داده برای فایل pdf

        $pdf_file = new File();
        $pdf_file->type = 'pdf';
        $pdf_file->filename = $pdf_file_name;
        $pdf_file->project_id = $request->input('project_id');
        $pdf_file->save();

        // ذخیره‌سازی فایل image
        if ($request->hasFile('image')) { // اضافه شد
            $image_file_path = $request->file('pdf');

            $image_file_name = md5($request->input('project_id'));
            $image_file_name .= md5(time());
            $image_file_name .= md5($image_file_path->getClientOriginalExtension());
            $image_file_name .= '.' . $image_file_path->getClientOriginalExtension();

            Storage::disk('public')->putFileAs('files/image', $image_file_path, $image_file_name);

            $image_file = new File();
            $image_file->type = 'image';
            $image_file->filename = $image_file_name;
            $image_file->project_id = $request->input('project_id');
            $image_file->save();
        }

        // ذخیره‌سازی فایل compressed
        if ($request->hasFile('compressed')) { // اضافه شد
            $compressed_file_path = $request->file('compressed');

            $compressed_file_name = md5($request->input('project_id'));
            $compressed_file_name .= md5(time());
            $compressed_file_name .= md5($compressed_file_path->getClientOriginalExtension());
            $compressed_file_name .= '.' . $compressed_file_path->getClientOriginalExtension();

            Storage::disk('public')->putFileAs('files/compressed', $compressed_file_path, $compressed_file_name);

            $compressed_file = new File();
            $compressed_file->type = 'compressed';
            $compressed_file->filename = $compressed_file_name;
            $compressed_file->project_id = $request->input('project_id');
            $compressed_file->save();
        }

        return back()->with('success', 'فایل با موفقیت آپلود شد.'); // تغییر داده شد
    }



    /*
     * دانلود فایل با استفاده از ID فایل
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($id): StreamedResponse
    {
        //یافتن فایل مورد نظر با استفاده از ID آن
        $file = File::findOrFail($id);
        $path = "files/{$file->type}/{$file->filename}";

        //دریافت فایل و ارسال آن به عنوان پاسخ به درخواست کاربر
        return Storage::disk('public')->download($path);
    }

    public function showFile($filename,$filetype): Response
    {
        $path = storage_path('app/public/files/' . $filetype . '/' . $filename);
        if (!F::exists($path)) {
            abort(404);
        }

        $file = file_get_contents($path);

        $response = new Response($file, 200);
        $contentType = mime_content_type($path);
        $response->headers->set('Content-Type', $contentType);

        return $response;
    }

}
