<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\LokasioohController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\PhotographyController;
use App\Http\Controllers\Admin\ServiceDetailController;
use App\Http\Controllers\Admin\ServiceCategoryController;


use App\Http\Controllers\Admin\PortofolioController;
use App\Http\Controllers\Admin\PortofolioCategoryController;

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin');

    // About Us
    Route::get('/admin/about', [\App\Http\Controllers\Admin\AboutController::class, 'index'])->name('admin.about.index');
    Route::get('/admin/about/edit/{id}', [\App\Http\Controllers\Admin\AboutController::class, 'edit'])->name('admin.about.edit');
    Route::put('/admin/about/update/{id}', [\App\Http\Controllers\Admin\AboutController::class, 'update'])->name('admin.about.update');

    // Hero
    Route::get('/admin/hero-list', [HeroController::class, 'index'])->name('hero');
    Route::post('/admin/hero/create', [HeroController::class, 'createHero']);
    Route::get('/admin/hero/create', [HeroController::class, 'create'])->name('hero-add');
    Route::delete('/admin/delete-hero/{id}', [HeroController::class, 'delete'])->name('hero-delete');
    Route::put('/admin/hero/update/{id}', [HeroController::class, 'updateHero'])->name('hero-update');
    Route::get('/admin/hero/update/{id}', [HeroController::class, 'update'])->name('hero-edit');
    Route::post('/admin/hero/reorder', [HeroController::class, 'reorder'])->name('hero-reorder');

    // Service
    Route::get('/admin/service-list', [ServiceController::class, 'index'])->name('service-list');
    Route::get('/admin/service/create', [ServiceController::class, 'create']);
    Route::post('/admin/service/create', [ServiceController::class, 'createService']);
    Route::get('/admin/service/edit/{id}', [ServiceController::class, 'edit']);
    Route::delete('/admin/service-list/{id}', [ServiceController::class, 'destroy'])->name('admin.service-list.destroy');
    Route::put('/admin/service/{id}', [ServiceController::class, 'updateService'])->name('admin.service.update');

    // Service Detail (Categories/Tabs for each Service)
    Route::post('/admin/service-categories', [ServiceCategoryController::class, 'store'])->name('service-categories.store');
    Route::put('/admin/service-categories/{id}', [ServiceCategoryController::class, 'update'])->name('service-categories.update');
    Route::delete('/admin/service-categories/{id}', [ServiceCategoryController::class, 'destroy'])->name('service-categories.destroy');
    Route::resource('/admin/service-details', ServiceDetailController::class)->names('service-details');

    // Partner
    Route::get('/admin/partner-list', [PartnerController::class, 'index'])->name('partner-list');
    Route::get('/admin/partner/create', [PartnerController::class, 'create']);
    Route::post('/admin/partner/create', [PartnerController::class, 'store']);
    Route::delete('/admin/partner-list/{id}', [PartnerController::class, 'destroy'])->name('admin.partner-list.destroy');
    Route::get('/admin/partner/edit/{id}', [PartnerController::class, 'edit']);
    Route::put('/admin/partner/{id}', [PartnerController::class, 'update'])->name('admin.partner.update');

    // Lokasi DOOH
    Route::get('/admin/lokasi-list', [LokasiController::class, 'index'])->name('lokasi-list');
    Route::get('/admin/lokasi/create-lokasi', [LokasiController::class, 'create'])->name('lokasi.create');
    Route::post('/admin/lokasi/create-lokasi', [LokasiController::class, 'store'])->name('lokasi.store');
    Route::post('/admin/lokasi/update/{id}', [LokasiController::class, 'update'])->name('lokasi.update');
    Route::get('/admin/lokasi-list/edit/{id}', [LokasiController::class, 'edit'])->name('lokasi.edit');
    Route::delete('/admin/delete-lokasi/{id}', [LokasiController::class, 'delete'])->name('lokasi.destroy');

    // Lokasi OOH
    Route::get('/admin/lokasiooh-wilayah', [LokasioohController::class, 'wilayah'])->name('wilayah-list-ooh');
    Route::get('/admin/lokasiooh-list/{wilayah}', [LokasioohController::class, 'index'])->name('lokasi-list-ooh');
    Route::get('/admin/lokasiooh/create', [LokasioohController::class, 'create'])->name('create-OOH');
    Route::post('/admin/lokasiooh/create', [LokasioohController::class, 'createLokasiooh'])->name('createLokasiooh');
    Route::put('/admin/lokasiooh/update/{id}', [LokasioohController::class, 'updateLokasiooh'])->name('update-OOH');
    Route::get('/admin/lokasiooh/edit/{id}', [LokasioohController::class, 'edit'])->name('edit-OOH');
    Route::delete('/admin/delete-lokasiooh/{id}', [LokasioohController::class, 'delete'])->name('delete-OOH');

    // Video GIF
    Route::get('/admin/video-list', [VideoController::class, 'index'])->name('video-list');
    Route::get('/admin/video/create', [VideoController::class, 'create']);
    Route::post('/admin/video/create', [VideoController::class, 'createvideo']);
    Route::post('/admin/delete-video/{id}', [VideoController::class, 'delete']);
    Route::post('/admin/video/update/{id}', [VideoController::class, 'updatevideo']);
    Route::get('/admin/video/edit/{id}', [VideoController::class, 'edit']);

    // Contact (Admin)
    Route::get('/admin/contact', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contact-admin');
    Route::get('/admin/contact/edit/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'edit'])->name('edit.contact');
    Route::put('/admin/contact/update/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'update'])->name('update.contact');

    // FAQ
    Route::resource('/admin/faq', \App\Http\Controllers\Admin\FaqController::class)->names('admin.faq');

    // Legality
    Route::resource('/admin/legality', \App\Http\Controllers\Admin\LegalityController::class)->names('admin.legality');

    // Brand
    Route::get('/admin/brand-list', [BrandController::class, 'index'])->name('brand-list');
    Route::get('/admin/brand/create-brand', [BrandController::class, 'create'])->name('brand.create');
    Route::post('/admin/brand/create-brand', [BrandController::class, 'store'])->name('brand.store');
    Route::delete('/admin/delete-brand/{id}', [BrandController::class, 'delete'])->name('brand.destroy');
    Route::put('/admin/brand/update/{id}', [BrandController::class, 'update'])->name('brand.update');
    Route::get('/admin/brand/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');

    // Photography
    Route::prefix('admin/photography')->group(function () {
        Route::get('/', [PhotographyController::class, 'index'])->name('photography');
        Route::get('/add-photography', function () {
            return view('admin.photography.create-Photography');
        });
        Route::post('/add-photography', [PhotographyController::class, 'create'])->name('photography-add');
        Route::get('/edit-photography/{id}', [PhotographyController::class, 'edit'])->name('photography-edit');
        Route::put('/edit-photography/{id}', [PhotographyController::class, 'update'])->name('photography-update');
        Route::delete('/{id}', [PhotographyController::class, 'destroy'])->name('photography-delete');
    });



    // Portofolio
    Route::resource('/admin/portofolio', PortofolioController::class)->names('portofolio');
    Route::delete('/admin/portofolio/image/{id}', [PortofolioController::class, 'deleteImage'])->name('portofolio.image.delete');
    Route::resource('/admin/portofolio_categories', PortofolioCategoryController::class)->names('portofolio_categories');

});
