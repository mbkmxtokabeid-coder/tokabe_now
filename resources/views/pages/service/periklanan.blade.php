@extends('pages.template')
@section('title', "Tokabe.id - $service->judul")
@section('content')
    <div class="cba_demo_one">
        <div class="section-wrapper ps-rel" data-scroll-section>
        <x-navbar/>
        @php
            $items = collect([
                ['text' => __('Home'), 'link' => route('home')],
                ['text' => __('Service Detail'), 'link' => '#']
            ])
        @endphp
        <!-- hero-area-start -->
        <x-hero-breadcrumb :items="$items"/>
        <!-- hero-area-end -->

        <!-- About Us-part-start -->
        <div class="container container-1290 mt-60">
            <div class="About-us-part">
                <div class="chose-us">
                    <h1 class="cb-ff cb-fs-60 cb-fw-400 cb-lh-70 text-capitalize mb-20 text-center text-lg-start fw-bold">
                        {{ $service->judul }}
                    </h1>
                    <div class="row justify-content-center align-items-center">
                        <!-- Konten Kiri -->
                        <div class="col-12 col-lg-6">
                            <div class="About-chose-us px-3 px-md-4">
                                <span class="cb-ff cb-fs-18 cb-fw-400 cb-lh-27 cb-color-gray300 d-block mb-3">
                                    {!! $service->deskripsi !!}
                                </span>
                                <div class="about-btn cb-br-50 mt-45 d-flex align-items-center btn-effect2">
                                    <a href="{{ $serviceLinks }}" class="cb-ff cb-fs-14 cb-fw-600 text-capitalize">
                                        Discover More<i class="icon icon-right-arrow ml-10"></i>
                                    </a>
                                </div>
                                <div class="wa-button mt-20">
                                    @php
                                        $advPhone = isset($globalContact) && $globalContact->phone ? $globalContact->phone : '628115239999';
                                        $advMessage = isset($globalContact) && $globalContact->message 
                                                        ? urlencode($globalContact->message) 
                                                        : urlencode('Halo Admin Tokabe, saya mau menanyakan tentang DOOH Advertising dan OOH Billboard / Baliho 🙏');
                                        $advUrl = "https://api.whatsapp.com/send?phone={$advPhone}&text={$advMessage}";
                                    @endphp
                                    <a
                                        href="{{ $advUrl }}"
                                        class='whatsapp-order-btn'
                                        target="_blank"
                                        data-service-id="{{ $service->id }}">
                                        <i class="fa-brands fa-whatsapp mr-2"></i>
                                        Call Astronaut : {{ $advPhone }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Gambar Kanan -->
                        <div class="col-12 col-lg-6 mt-4 mt-lg-0">
                            <div class="about-chose-billboard d-flex justify-content-center ps-rel px-3 px-md-4">
                                <div class="d-flex justify-content-center imghover overflow-hidden">
                                    <img class="img-fluid" style="border-radius: 20px; max-width: 100%;"
                                        src="{{ asset('storage/image_service/' . $service->gambar) }}"
                                        alt="{{ \App\Helpers\SeoHelper::getImageAlt('service', $service->judul) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        </div>
    </div>
@endsection