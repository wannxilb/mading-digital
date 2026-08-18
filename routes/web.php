<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\Admin\AchievementController as AdminAchievementController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AnnouncementController as PublicAnnouncementController;
use App\Http\Controllers\ArticleController as PublicArticleController;
use App\Http\Controllers\EventController as PublicEventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Siswa\ArticleController as SiswaArticleController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\ProfileController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [NewsController::class, 'index'])->name('berita.index');
Route::get('/berita/{post:slug}', [NewsController::class, 'show'])->name('berita.show');
Route::get('/artikel', [PublicArticleController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{article:slug}', [PublicArticleController::class, 'show'])->name('artikel.show');
Route::get('/pengumuman', [PublicAnnouncementController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{announcement}', [PublicAnnouncementController::class, 'show'])->name('pengumuman.show');
Route::get('/agenda', [PublicEventController::class, 'index'])->name('agenda.index');
Route::get('/agenda/{event}', [PublicEventController::class, 'show'])->name('agenda.show');
Route::get('/prestasi', [AchievementController::class, 'index'])->name('prestasi.index');
Route::get('/prestasi/{achievement}', [AchievementController::class, 'show'])->name('prestasi.show');
Route::get('/cari', [SearchController::class, 'index'])->name('cari.index');
Route::get('/kategori/{category:slug}', [HomeController::class, 'category'])->name('category');
Route::get('/tentang', [AboutController::class, 'index'])->name('tentang');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.attempt');
    });

    Route::middleware(['auth', EnsureUserIsAdmin::class])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('berita')->name('berita.')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('index');
            Route::get('/baru', [PostController::class, 'create'])->name('create');
            Route::post('/', [PostController::class, 'store'])->name('store');
            Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
            Route::put('/{post}', [PostController::class, 'update'])->name('update');
            Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('artikel')->name('artikel.')->group(function () {
            Route::get('/', [AdminArticleController::class, 'index'])->name('index');
            Route::get('/baru', [AdminArticleController::class, 'create'])->name('create');
            Route::post('/', [AdminArticleController::class, 'store'])->name('store');
            Route::get('/{article}/edit', [AdminArticleController::class, 'edit'])->name('edit');
            Route::put('/{article}', [AdminArticleController::class, 'update'])->name('update');
            Route::delete('/{article}', [AdminArticleController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
            Route::get('/', [AnnouncementController::class, 'index'])->name('index');
            Route::get('/baru', [AnnouncementController::class, 'create'])->name('create');
            Route::post('/', [AnnouncementController::class, 'store'])->name('store');
            Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');
            Route::put('/{announcement}', [AnnouncementController::class, 'update'])->name('update');
            Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('agenda')->name('agenda.')->group(function () {
            Route::get('/', [AdminEventController::class, 'index'])->name('index');
            Route::get('/baru', [AdminEventController::class, 'create'])->name('create');
            Route::post('/', [AdminEventController::class, 'store'])->name('store');
            Route::get('/{event}/edit', [AdminEventController::class, 'edit'])->name('edit');
            Route::put('/{event}', [AdminEventController::class, 'update'])->name('update');
            Route::delete('/{event}', [AdminEventController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('prestasi')->name('prestasi.')->group(function () {
            Route::get('/', [AdminAchievementController::class, 'index'])->name('index');
            Route::get('/baru', [AdminAchievementController::class, 'create'])->name('create');
            Route::post('/', [AdminAchievementController::class, 'store'])->name('store');
            Route::get('/{achievement}/edit', [AdminAchievementController::class, 'edit'])->name('edit');
            Route::put('/{achievement}', [AdminAchievementController::class, 'update'])->name('update');
            Route::delete('/{achievement}', [AdminAchievementController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('pengguna')->name('pengguna.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/baru', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/import', [UserController::class, 'import'])->name('import');
            Route::post('/import', [UserController::class, 'processImport'])->name('import.process');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('kategori')->name('kategori.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        });

        Route::get('/pengaturan', [SettingController::class, 'index'])->name('pengaturan');
        Route::put('/pengaturan', [SettingController::class, 'update'])->name('pengaturan.update');
        Route::delete('/pengaturan/{key}', [SettingController::class, 'destroyImage'])->name('pengaturan.destroyImage');

        Route::prefix('persetujuan')->name('persetujuan.')->group(function () {
            Route::get('/', [ApprovalController::class, 'index'])->name('index');
            Route::post('/berita/{post}/setuju', [ApprovalController::class, 'approvePost'])->name('approvePost');
            Route::post('/berita/{post}/tolak', [ApprovalController::class, 'rejectPost'])->name('rejectPost');
            Route::post('/artikel/{article}/setuju', [ApprovalController::class, 'approveArticle'])->name('approveArticle');
            Route::post('/artikel/{article}/tolak', [ApprovalController::class, 'rejectArticle'])->name('rejectArticle');
            Route::post('/pengumuman/{announcement}/setuju', [ApprovalController::class, 'approveAnnouncement'])->name('approveAnnouncement');
            Route::post('/pengumuman/{announcement}/tolak', [ApprovalController::class, 'rejectAnnouncement'])->name('rejectAnnouncement');
        });
    });
});

Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'EnsureRole:siswa'])->group(function () {
    Route::get('/', [SiswaDashboardController::class, 'index'])->name('dashboard');

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');

    Route::prefix('karya')->name('karya.')->group(function () {
        Route::get('/', [SiswaArticleController::class, 'index'])->name('index');
        Route::get('/baru', [SiswaArticleController::class, 'create'])->name('create');
        Route::post('/', [SiswaArticleController::class, 'store'])->name('store');
        Route::get('/{article}', [SiswaArticleController::class, 'show'])->name('show');
        Route::get('/{article}/edit', [SiswaArticleController::class, 'edit'])->name('edit');
        Route::put('/{article}', [SiswaArticleController::class, 'update'])->name('update');
        Route::delete('/{article}', [SiswaArticleController::class, 'destroy'])->name('destroy');
    });
});
