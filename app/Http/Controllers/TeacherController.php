<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TeacherController extends Controller
{
    public function ShowProjects(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $validated = $request->validate([
            'teacher_id' => 'required'
        ]);

        $teacherProjects = DB::table('projects')
            ->where('supervisor_id', $validated['teacher_id'])
            ->get();

        return view('teacher.projects',['projects' => $teacherProjects]);
    }

    public function showProfile(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return(view('teacher.profile'));
    }
}
