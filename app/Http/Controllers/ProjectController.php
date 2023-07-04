<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use App\Models\Project;

class ProjectController extends Controller
{
    public function showProject($id): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $project = Project::findOrFail($id);
        return view('project.index', compact('project'));
    }
}
