<?php /** @noinspection PhpUndefinedNamespaceInspection */

use App\Http\Controllers\ContactController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Models\File;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




Route::get('/contact',[ContactController::class,'show']);
Route::post('/contact',[ContactController::class,'send']);




Route::get('/upload',[FileController::class,'show']);
Route::post('/upload',[FileController::class,'upload']);




// select * from files
Route::get('/files', function () {
    $files = File::all();
    return view('files', ['files' => $files]);
});

// download a file
Route::get('/download/{id}', [FileController::class, 'download'])
    ->name('download');

//show a file
Route::get('/showFile/{filename}/{filetype}', [FileController::class, 'showFile'])
    ->name('showFile');




// select * from projects
Route::get('/projects', function () {
    $projects = Project::all();
    return view('project.projects', ['projects' => $projects]);
});

// show a project
Route::get('/project/{id}', [ProjectController::class, 'showProject'])
    ->name('showProject');




//insert a new rate
Route::get('rate/{project_id}/{rate}',[RateController::class,'rate'])
    ->name('rate');

//insert a new bookmark
Route::get('bookmark/{project_id}',[BookmarkController::class,'bookmark'])
    ->name('bookmark');




Auth::routes();

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');




Route::post('/teacher/projects',[TeacherController::class,'ShowProjects'])
    ->name('showTeacherProjects');

Route::get('/teacher/profile',[TeacherController::class,'ShowProfile'])->name('ShowProfile');
