<style>
    body {
        font-family: 'Poppins', 'sans-serif';
        color: #1d2b4f;
        font-size: 1.25rem;
        line-height: 1.8;
    }

    em {
        font-style: normal;
        font-weight: bold;
        color: #ffaa00;
    }
</style>
@php
    $namaOoh = is_array($lokasiooh->nama) ? ($lokasiooh->nama[app()->getLocale()] ?? $lokasiooh->nama['en'] ?? $lokasiooh->nama['id'] ?? '') : ($lokasiooh->nama ?: $lokasiooh->getRawOriginal('nama'));
    $descOoh = is_array($lokasiooh->deskripsi_lokasi) ? ($lokasiooh->deskripsi_lokasi[app()->getLocale()] ?? $lokasiooh->deskripsi_lokasi['en'] ?? $lokasiooh->deskripsi_lokasi['id'] ?? '') : ($lokasiooh->deskripsi_lokasi ?: $lokasiooh->getRawOriginal('deskripsi_lokasi'));
@endphp
@extends('pages.template')
@section('title', "Tokabe.id - $namaOoh")
@section('content')

        <div class="cba_demo_one">
            <div class="section-wrapper ps-rel" data-scroll-section>
                <x-navbar/>
                <!-- Header Start -->
                <!-- Header End -->
                <!-- hero-area-start -->
                <div class="common-hero-area d-flex align-items-center"
                    style="background-image:linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('storage/image_lokasiooh/' . $lokasiooh->gambar) }}')">
                    <div class="container container-1290">
                        <div class="hero-part">
                            <div class="hero-link d-flex align-items-center justify-content-center">
                                <h2 class="cb-ff cb-fs-48 cb-color-white text-center" style="font-weight: bold;">
                                    SUPER LOCATION and EYE-CATCHING OOH Billboard in Sumatera
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- hero-area-end -->
                <!-- Project-Details-part-start -->
                <div class="container container-1290 mt-20">
                    <div class="Project-Details-part">
                        <h1 class="cb-ff cb-fs-60 cb-fw-400 cb-lh-70" style="color: black; font-weight: bold;">
                            {{ $namaOoh }}</h1>
                        <div class="project-details-billboard mt-50 imghover">
                            <img src="{{ asset('storage/image_lokasiooh/' . $lokasiooh->gambar) }}" 
                                 alt="{{ \App\Helpers\SeoHelper::getImageAlt('ooh', $lokasiooh->nama, $lokasiooh->wilayah ?? 'Medan') }}" 
                                 class="cb-br-20" 
                                 loading="lazy">
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-8">
                                <h2 class="cb-ff cb-fs-40 cb-fw-600 cb-lh-45 text-capitalize mt-35 pro-hed">Point Of
                                    Interest</h2>
                                <p class="cb-ff cb-fs-18 cb-fw-400 cb-lh-27 cb-color-gray300 mt-25" data-aos="fade-up"
                                    data-aos-duration="3000">{!! $descOoh !!}</p>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="serevice-get-touch cb-br-20 cb-bg-color-white overflow-hidden p-3 border">
                                    <div class="serevice-get-touch-heading mb-30">
                                        <h2 class="cb-ff cb-fs-36 cb-fw-400 cb-lh-42">Vehicle / Day</h2>
                                    </div>
                                    <div class="serevice-get-touch-body">
                                        <div class="service-get-content d-flex align-items-center mb-15">
                                            <div class="touch-icon cb-bg-color-brown rounded-circle center mr-15">
                                                <i class="fa-solid fa-car"></i>
                                            </div>
                                            <p class="cb-ff cb-fs-18 cb-fw-400 cb-lh-27">Car : {{ $lokasiooh->mobil }}</p>
                                        </div>
                                        <div class="service-get-content d-flex align-items-center mb-15">
                                            <div class="touch-icon cb-bg-color-brown rounded-circle center mr-15">
                                                <i class="fa-solid fa-motorcycle"></i>
                                            </div>
                                            <p class="cb-ff cb-fs-18 cb-fw-400 cb-lh-27">Motorcycle :
                                                {{ $lokasiooh->motor }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <!-- Maps -->
                                <div class="map-and-card position-relative">
                                    <!-- Maps -->
                                    <div class="map-container my-4 d-flex justify-content-center">
                                        <div class="shadow-lg border-0 rounded-4 overflow-hidden" style="width: 90%;">
                                            <div class="ratio ratio-16x9">
                                                <iframe
                                                    src="https://www.google.com/maps?q={{ $lokasiooh->koordinat }}&hl=es;z=14&output=embed"
                                                    style="border:0;" allowfullscreen="true" loading="lazy"
                                                    referrerpolicy="no-referrer-when-downgrade">
                                                </iframe>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cards -->
                                    <div class="card-wrapper cb-ff d-flex justify-content-center gap-3 position-absolute w-100"
                                        style="bottom: -60px; z-index: 2;">
                                        <!-- Media -->
                                        <div class="card-info card-hover text-center p-4 shadow-sm rounded-4 bg-white">
                                            <div class="icon-wrapper mb-3">
                                                <i class="fa-solid fa-photo-film fa-2x text-warning"></i>
                                            </div>
                                            <div class="text-orange fw-semibold mb-1 label">Media</div>
                                            <div class="fw-bold fs-5 text-dark title">{{ $lokasiooh->media }}</div>
                                        </div>

                                        <!-- Type -->
                                        <div class="card-info card-hover text-center p-4 shadow-sm rounded-4 bg-white">
                                            <div class="icon-wrapper mb-3">
                                                <i class="fa-solid fa-expand fa-2x text-warning"></i>
                                            </div>
                                            <div class="text-orange fw-semibold mb-1 label">Type</div>
                                            <div class="fw-bold fs-5 text-dark title">{{ $lokasiooh->type }}</div>
                                        </div>

                                        <!-- Screen Size -->
                                        <div class="card-info card-hover text-center p-4 shadow-sm rounded-4 bg-white">
                                            <div class="icon-wrapper mb-3">
                                                <i
                                                    class="fa-solid fa-up-right-and-down-left-from-center fa-2x text-warning"></i>
                                            </div>
                                            <div class="text-orange fw-semibold mb-1 label">Screen Size</div>
                                            <div class="fw-bold fs-5 text-dark title">{{ $lokasiooh->size }}</div>
                                        </div>

                                        <!-- Coordinates -->
                                        <div class="card-info card-hover text-center p-4 shadow-sm rounded-4 bg-white">
                                            <div class="icon-wrapper mb-3">
                                                <i class="fa-solid fa-location-dot fa-2x text-warning"></i>
                                            </div>
                                            <div class="text-orange fw-semibold mb-1 label">Lighting</div>
                                            <div class="fw-bold fs-5 text-dark title">{{ $lokasiooh->lighting }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Service disini -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
