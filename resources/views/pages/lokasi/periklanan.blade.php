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
    $rawNama = $lokasi->nama ?: $lokasi->getRawOriginal('nama');
    $namaLokasi = is_string($rawNama) && str_starts_with($rawNama, '{') ? json_decode($rawNama, true) : $rawNama;
    $namaLokasi = is_array($namaLokasi) ? (($namaLokasi[app()->getLocale()] ?? '') ?: ($namaLokasi['id'] ?? '') ?: ($namaLokasi['en'] ?? '') ?: (collect($namaLokasi)->first() ?? '')) : $namaLokasi;
    
    $rawDesc = $lokasi->deskripsi_lokasi ?: $lokasi->getRawOriginal('deskripsi_lokasi');
    $descLokasi = is_string($rawDesc) && str_starts_with($rawDesc, '{') ? json_decode($rawDesc, true) : $rawDesc;
    $descLokasi = is_array($descLokasi) ? (($descLokasi[app()->getLocale()] ?? '') ?: ($descLokasi['id'] ?? '') ?: ($descLokasi['en'] ?? '') ?: (collect($descLokasi)->first() ?? '')) : $descLokasi;
@endphp
@extends('pages.template')
@section('title', "Tokabe.id - $namaLokasi")
@section('content')
    <div class="cba_demo_one">
        <!-- Preloder Start -->
        <!-- Preloder End -->
        <div class="section-wrapper ps-rel" data-scroll-section>
            <x-navbar/>
            <!-- Header Start -->
            <!-- Header End -->
            <!-- hero-area-start -->
            <div class="common-hero-area d-flex align-items-center"
                style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('storage/image_lokasi/' . $lokasi->gambar) }}'); height: 500px; background-repeat: no-repeat;">
                <div class="container container-1290">
                    <div class="hero-part">
                        <div class="hero-link d-flex align-items-center justify-content-center">
                            <h2 class="cb-ff cb-fs-48 cb-color-white text-center" style="font-weight: bold; z-index: 2;">
                                {{ $lokasi->tagline }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- hero-area-end -->
            <!-- Project-Details-part-start -->
            <div class="container container-1290 mt-20">
                <div class="Project-Details-part">
                    <div style="display: flex; width: 100%; text-align: center;">
                        <h1 class="cb-ff cb-fs-60 cb-fw-400 cb-lh-70 text-capitalize" style="color: #00000; width: 100%; font-weight: bold;">
                            {{ $namaLokasi }}</h1>

                    </div>
                    <div class="project-details-billboard mt-50 imghover">
                        <img src="{{ asset('storage/image_lokasi/' . $lokasi->gambar) }}" 
                             alt="{{ \App\Helpers\SeoHelper::getImageAlt('dooh', $lokasi->nama, $lokasi->provinsi ?? 'Medan') }}" 
                             class="cb-br-20" 
                             loading="lazy">
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <h2 class="cb-ff cb-fs-40 cb-fw-600 cb-lh-45 text-capitalize mt-35 pro-hed">Point Of
                                Interest</h2>
                            <p class="cb-ff cb-fs-18 cb-fw-400 cb-lh-27 cb-color-gray300 mt-25" data-aos="fade-up"
                                data-aos-duration="3000">{!! $descLokasi !!}</p>
                            <!-- Maps -->
                            <div class="map-container my-4 d-flex justify-content-center">
                                <div class="shadow-lg border-0 rounded-4 overflow-hidden" style="width: 100%;">
                                    <div class="ratio ratio-16x9">
                                        <iframe
                                            src="https://www.google.com/maps?q={{ $lokasi->koordinat }}&hl=es;z=14&output=embed"
                                            style="border:0;" allowfullscreen="" loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="project-info cb-bg-color-white p-3">
                                <h3 class="cb-ff cb-fs-32 cb-fw-600 cb-lh-38 text-capitalize">Details Description</h3>
                                <div class="project-item catagori d-flex align-items-center p-3 mb-20">
                                    <h4 class="cb-ff cb-fs-24 cb-fw-600 cb-lh-30 text-capitalize">Ad Duration:</h4>
                                    <p class="cb-ff cb-fs-18 cb-fw-400 cb-lh-27 cb-color-gray300 ml-15">
                                        {{ $lokasi->duration }}
                                    </p>
                                </div>
                                <div class="project-item catagori d-flex align-items-center p-3 mb-20">
                                    <h4 class="cb-ff cb-fs-24 cb-fw-600 cb-lh-30 text-capitalize">1 Day:</h4>
                                    <p class="cb-ff cb-fs-18 cb-fw-400 cb-lh-27 cb-color-gray300 ml-15">
                                        {{ $lokasi->hour }}
                                    </p>
                                </div>
                                <div class="project-item catagori d-flex align-items-center p-3 mb-20">
                                    <h4 class="cb-ff cb-fs-24 cb-fw-600 cb-lh-30 text-capitalize">1 Day:</h4>
                                    <p class="cb-ff cb-fs-18 cb-fw-400 cb-lh-27 cb-color-gray300 ml-15">
                                        {{ $lokasi->spot }}
                                    </p>
                                </div>
                                <div class="project-item catagori d-flex align-items-center p-3 mb-20">
                                    <h4 class="cb-ff cb-fs-24 cb-fw-600 cb-lh-30 text-capitalize">1 Brand:</h4>
                                    <p class="cb-ff cb-fs-18 cb-fw-400 cb-lh-27 cb-color-gray300 ml-20">
                                        {{ $lokasi->brand }}
                                    </p>
                                </div>
                                <div class="project-item catagori d-flex align-items-center p-3 mb-20">
                                    <h4 class="cb-ff cb-fs-24 cb-fw-600 cb-lh-30 text-capitalize">Ad Display Hours:
                                    </h4>
                                    <p class="cb-ff cb-fs-18 cb-fw-400 cb-lh-27 cb-color-gray300 ml-20">
                                        {{ $lokasi->display }}
                                    </p>
                                </div>
                                <div class="project-item catagori d-flex align-items-center p-3 mb-20">
                                    <h4 class="cb-ff cb-fs-24 cb-fw-600 cb-lh-30 text-capitalize">Rating:</h4>
                                    <div class="rating ml-30">
                                        <i class="icon icon-star cb-color-brown"></i>
                                        <i class="icon icon-star cb-color-brown"></i>
                                        <i class="icon icon-star cb-color-brown"></i>
                                        <i class="icon icon-star cb-color-brown"></i>
                                        <i class="icon icon-star cb-color-brown"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="serevice-get-touch cb-br-20 cb-bg-color-white overflow-hidden p-3 border">
                                <div class="serevice-get-touch-heading mb-30">
                                    <h2 class="cb-ff cb-fs-36 cb-fw-400 cb-lh-42">Vehicle / Day</h2>
                                </div>
                                <div class="serevice-get-touch-body">
                                    <div class="service-get-content d-flex align-items-center mb-15">
                                        <div class="touch-icon cb-bg-color-brown rounded-circle center mr-15">
                                            <!-- <i class="icon icon-call cb-fs-14 cb-fw-900"></i> -->
                                            <i class="fa-solid fa-car"></i>
                                        </div>
                                        <p class="cb-ff cb-fs-18 cb-fw-400 cb-lh-27">Car : {{ $lokasi->mobil }}</p>
                                    </div>
                                    <div class="service-get-content d-flex align-items-center mb-15">
                                        <div class="touch-icon cb-bg-color-brown rounded-circle center mr-15">
                                            <!-- <i class="icon icon-message cb-fs-14 cb-fw-900"></i> -->
                                            <i class="fa-solid fa-motorcycle"></i>
                                        </div>
                                        <p class="cb-ff cb-fs-18 cb-fw-400 cb-lh-27">Motorcycle : {{ $lokasi->motor }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <!-- Media -->
                            <div class="card-wrapper cb-ff">
                                <div class="card-info card-hover text-center p-4 shadow-sm rounded-4">
                                    <div class="icon-wrapper mb-3">
                                        <i class="fa-solid fa-photo-film fa-2x text-warning"></i>
                                    </div>
                                    <div class="text-orange fw-semibold mb-1 label">Media</div>
                                    <div class="fw-bold fs-5 text-dark title">{{ $lokasi->media }}</div>
                                </div>

                                <!-- Type -->
                                <div class="card-info card-hover text-center p-4 shadow-sm rounded-4">
                                    <div class="icon-wrapper mb-3">
                                        <i class="fa-solid fa-expand fa-2x text-warning"></i>
                                    </div>
                                    <div class="text-orange fw-semibold mb-1 label">Type</div>
                                    <div class="fw-bold fs-5 text-dark title">{{ $lokasi->type }}</div>
                                </div>

                                <!-- Ukuran Layar -->
                                <div class="card-info card-hover text-center p-4 shadow-sm rounded-4">
                                    <div class="icon-wrapper mb-3">
                                        <i
                                            class="fa-solid fa-up-right-and-down-left-from-center fa-2x text-warning"></i>
                                    </div>
                                    <div class="text-orange fw-semibold mb-1 label">Screen Size</div>
                                    <div class="fw-bold fs-5 text-dark title">{{ $lokasi->size }}</div>
                                </div>

                                <!-- Koordinat -->
                                <div class="card-info card-hover text-center p-4 shadow-sm rounded-4">
                                    <div class="icon-wrapper mb-3">
                                        <i class="fa-solid fa-location-dot fa-2x text-warning"></i>
                                    </div>
                                    <div class="text-orange fw-semibold mb-1 label">Coordinates</div>
                                    <div class="fw-bold fs-5 text-dark title">{{ $lokasi->koordinat }}</div>
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