@extends('pages.template')
@section('title', __('Tokabe.id - Layanan Event Organizer Profesional'))
@section('meta_description', __('Layanan Event Organizer (EO) Tokabe.id. Solusi profesional untuk perencanaan dan pelaksanaan event korporat, pameran, konser, dan promosi di Sumatera.'))
@section('meta_keywords', 'Event Organizer Medan, EO Sumatera, Jasa Event Promosi, Corporate Event Planner')
@section('og_title', __('Tokabe.id - Layanan Event Organizer Profesional'))
@section('og_description', __('Layanan Event Organizer (EO) Tokabe.id. Solusi profesional untuk perencanaan dan pelaksanaan event korporat, pameran, konser, dan promosi di Sumatera.'))
@section('og_image', asset('images/service/iklan.jpg'))
@section('content')
<div class="bg-dark-theme-wrapper" style="background-color: #2C1A0E !important; color: #F5EFE7 !important; min-height: 100vh; width: 100%;">
  <style>
      .bg-dark-theme-wrapper hr {
          border-color: rgba(212, 165, 116, 0.3) !important;
      }
      .bg-dark-theme-wrapper p, .bg-dark-theme-wrapper h3, .bg-dark-theme-wrapper h4, .bg-dark-theme-wrapper h6, .bg-dark-theme-wrapper ul {
          color: #F5EFE7 !important;
      }
      body {
          background-color: #2C1A0E !important;
      }
  </style>
  <!-- ***** Main Banner Area Start ***** -->
  <div class="banner">
    <div class="swiper-container" id="top">
      <div class="swiper-wrapper">
        @php
          $firstActiveIndex = -1; // Indeks pertama gambar aktif setelah gambar pertama non-aktif
        @endphp
        @foreach ($hero as $index => $item)
          @if ($item->status === 1)
            @if ($firstActiveIndex === -1)
              @php
                $firstActiveIndex = $index; // Setel indeks pertama gambar aktif
              @endphp
            @endif
            <div class="swiper-slide {{ ($index === $firstActiveIndex) ? 'swiper-slide-active' : '' }}">
              <div class="slide-inner" style="background-image:url({{ asset('storage/image_hero/' . $item->gambar) }})">
                <div class="container">
                  <div class="row">
                    <div class="col-lg-8">
                      <div class="header-text">
                        <h2>{{ $item->judul }}</h2>
                        <div class="div-dec"></div>
                        <p>{{ $item->deskripsi }}</p>
                        <div class="buttons">
                          <div class="green-button">
                            <a href="{{ route('service') }}">{{ __('Discover More') }}</a>
                          </div>
                          <div class="orange-button">
                            <a href="{{ route('contact') }}">{!! __('Contact Us') !!}</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endif
        @endforeach
      </div>
      <div class="swiper-button-next swiper-button-white"></div>
      <div class="swiper-button-prev swiper-button-white"></div>
    </div>
  </div>
  <!-- ***** Main Banner Area End ***** -->

<div class="container mt-5 text-center">
  <h3 style="letter-spacing: 5px;">Event Organizer</h3>
  <hr>

  <div class="row mt-5 p-3">
    <div class="col-md-6">
      <p style="text-align: left;">Tokabe.id adalah solusi terbaik untuk layanan jasa pembuatan dan pemasangan iklan Billboard dan Videotron yang efektif. Kami membantu Anda mengekspos pesan promosi Anda dengan cara yang mencolok dan mengesankan, mencakup segala kebutuhan mulai dari desain hingga pemasangan. Percayakan kampanye iklan Anda kepada kami, dan biarkan Billboard dan Videotron kami menyampaikan pesan Anda kepada audiens yang tepat!</p>
    </div>
    <div class="col-md-6">
      <div style="max-height: 300px; overflow: hidden;">
        <img src="{{ asset('images/service/iklan.jpg') }}" alt="{{ \App\Helpers\SeoHelper::getImageAlt('event', 'Layanan Event Organizer') }}">
      </div>
    </div>
  </div>
  <hr>

    <div class="row mt-5 p-3">
      <h4 style="letter-spacing: 3px; text-align: left;">Mengapa Tokabe.id</h4>
      <p class="mt-3" style="text-align:left;">Tokabe.id adalah perusahaan yang berpengalaman dalam pembuatan dan pemasangan iklan berupa Billboard dan Videotron. Tim profesional kami akan membantu Anda menghadirkan pesan promosi dengan cara yang unik dan memukau, sehingga Anda bisa mencapai audiens yang tepat.</p>

    <h6 class="mt-3" style="text-align: left;">Keunggulan kami</h6>
    <ul style="text-align: left;">
      <li>Pengalaman Terpercaya: Kami memiliki rekam jejak yang kuat dalam industri periklanan.</li>
      <li>Tim Kreatif Berbakat: Desainer dan profesional berpengalaman siap membantu Anda.</li>
      <li>Teknologi Terbaru: Menggunakan teknologi terkini untuk hasil terbaik.</li>
      <li>Penempatan Strategis: Menempatkan iklan Anda di lokasi yang strategis.</li>
      <li>Harga Kompetitif: Menawarkan harga yang bersaing untuk semua anggaran.</li>
    </ul>

  </div>
</div>
</div>
  @endsection
