<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TeacherAssignmentController;
use App\Http\Controllers\VideoTestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\OraliqNazoratController;

// Redirect root to login if not authenticated
Route::get('/', function () {
    return auth()->check() ? redirect()->route('home.index') : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Home/Materials routes
    Route::resource('home', HomeController::class)->middleware('verified');
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // routes/web.php


    // Bu guruh ichida faqat tizimga kirgan foydalanuvchilar kira oladi
    Route::middleware(['auth'])->group(function () {
        Route::resource('resources', ResourceController::class)->only([
            'index',
            'create',
            'store',
            'destroy'
        ]);
    });
    Route::get('/contact', function () {
        return view('contact.index');
    })->name('contact');
    // Teacher Assignment routes (RESTful)
    Route::prefix('teacher/assignments')->name('teacher.assignments.')->group(function () {
        Route::get('/', [TeacherAssignmentController::class, 'index'])->name('index');
        Route::get('/create', [TeacherAssignmentController::class, 'create'])->name('create');
        Route::post('/', [TeacherAssignmentController::class, 'store'])->name('store');
        Route::get('/{assignment}/edit', [TeacherAssignmentController::class, 'edit'])->name('edit');
        Route::put('/{assignment}', [TeacherAssignmentController::class, 'update'])->name('update');
        Route::delete('/{assignment}', [TeacherAssignmentController::class, 'destroy'])->name('destroy');
        Route::get('/{assignment}/submissions', [TeacherAssignmentController::class, 'showSubmissions'])->name('submissions');
        Route::post('/score/{submission}', [TeacherAssignmentController::class, 'score'])->name('score');
    });

    // Student Submission routes
    Route::prefix('assignments')->name('assignments.')->group(function () {
        Route::post('/{assignment}/submit', [SubmissionController::class, 'store'])->name('submit');
    });

    // Video Test routes
    Route::prefix('video-test')->name('video-test.')->group(function () {
        Route::post('/{material}/check-answer', [VideoTestController::class, 'checkAnswer'])->name('check-answer');
        Route::post('/{material}/save-progress', [VideoTestController::class, 'saveProgress'])->name('save-progress');
        Route::post('/{material}/complete', [VideoTestController::class, 'completeVideo'])->name('complete');
        Route::get('/{material}/progress', [VideoTestController::class, 'getProgress'])->name('progress');
    });

    // Glossary Routes
    Route::post('/glossary/{material}', [App\Http\Controllers\GlossaryController::class, 'store'])->name('glossary.store');
    Route::put('/glossary/{glossary}', [App\Http\Controllers\GlossaryController::class, 'update'])->name('glossary.update');
    Route::delete('/glossary/{glossary}', [App\Http\Controllers\GlossaryController::class, 'destroy'])->name('glossary.destroy');

    // Admin Test Routes
    Route::prefix('admin/tests')->name('admin.tests.')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminTestController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\AdminTestController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\AdminTestController::class, 'store'])->name('store');
        Route::get('/{test}', [App\Http\Controllers\AdminTestController::class, 'show'])->name('show');
        Route::put('/{test}', [App\Http\Controllers\AdminTestController::class, 'update'])->name('update');
        Route::delete('/{test}', [App\Http\Controllers\AdminTestController::class, 'destroy'])->name('destroy');
        Route::post('/{test}/publish', [App\Http\Controllers\AdminTestController::class, 'publish'])->name('publish');

        // Questions
        Route::post('/{test}/questions', [App\Http\Controllers\AdminTestController::class, 'storeQuestion'])->name('questions.store');
        Route::delete('/questions/{question}', [App\Http\Controllers\AdminTestController::class, 'destroyQuestion'])->name('questions.destroy');

        // Results
        Route::get('/{test}/results', [App\Http\Controllers\AdminTestController::class, 'results'])->name('results');
    });

    // Oraliq Nazorat routes
    Route::prefix('oraliq-nazorat')->name('oraliq.')->group(function () {
        Route::get('/', [OraliqNazoratController::class, 'index'])->name('index');
        Route::get('/create', [OraliqNazoratController::class, 'create'])->name('create');
        Route::post('/', [OraliqNazoratController::class, 'store'])->name('store');
        Route::get('/{oraliq}', [OraliqNazoratController::class, 'show'])->name('show');
        Route::get('/{oraliq}/edit', [OraliqNazoratController::class, 'edit'])->name('edit');
        Route::put('/{oraliq}', [OraliqNazoratController::class, 'update'])->name('update');
        Route::post('/{oraliq}/submit', [OraliqNazoratController::class, 'submit'])->name('submit');
        Route::post('/submission/{submission}/score', [OraliqNazoratController::class, 'score'])->name('score');
        Route::delete('/{oraliq}', [OraliqNazoratController::class, 'destroy'])->name('destroy');
    });

    // Yakuniy Nazorat routes
    Route::prefix('yakuniy-nazorat')->name('yakuniy.')->group(function () {
        Route::get('/', [App\Http\Controllers\YakuniyNazoratController::class, 'index'])->name('index');
        Route::get('/take', [App\Http\Controllers\YakuniyNazoratController::class, 'take'])->name('take');
        Route::post('/submit', [App\Http\Controllers\YakuniyNazoratController::class, 'submit'])->name('submit');

        // Admin
        Route::get('/settings', [App\Http\Controllers\YakuniyNazoratController::class, 'settings'])->name('settings');
        Route::post('/settings', [App\Http\Controllers\YakuniyNazoratController::class, 'storeSettings'])->name('settings.store');
        Route::get('/questions', [App\Http\Controllers\YakuniyNazoratController::class, 'questions'])->name('questions');
        Route::post('/questions', [App\Http\Controllers\YakuniyNazoratController::class, 'storeQuestion'])->name('questions.store');
        Route::delete('/questions/{question}', [App\Http\Controllers\YakuniyNazoratController::class, 'deleteQuestion'])->name('questions.destroy');
        Route::get('/results', [App\Http\Controllers\YakuniyNazoratController::class, 'results'])->name('results');
    });

    // Student Exam Routes
    Route::prefix('student/tests')->name('student.tests.')->group(function () {
        Route::get('/', [App\Http\Controllers\StudentTestController::class, 'index'])->name('index');
        Route::get('/{test}/take', [App\Http\Controllers\StudentTestController::class, 'show'])->name('show');
        Route::post('/{test}/submit', [App\Http\Controllers\StudentTestController::class, 'submit'])->name('submit');
        Route::get('/{test}/result', [App\Http\Controllers\StudentTestController::class, 'result'])->name('result');
    });
});

Route::get('/dashboard', function () {
    return redirect()->route('home.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
