@extends('layouts.frontend')

@section('content')
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Tentang Saya</h1>
        </div>
    </div>
</header>
<!-- Section -->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 m-auto">
                <div class="about-me">
                    <h2 class="text-center mb-4">Halo, Saya [Nama Anda]</h2>
                    <p class="text-justify">
                        Selamat datang di halaman "Tentang Saya". Nama saya adalah [Nama Anda], seorang [profesi atau deskripsi singkat tentang diri Anda]. 
                        Saya memiliki passion dalam [bidang atau hobi Anda], dan saya berkomitmen untuk terus belajar dan berbagi pengetahuan 
                        kepada orang lain.
                    </p>
                    <p class="text-justify">
                        Saya memiliki pengalaman dalam [bidang keahlian Anda], di mana saya telah bekerja pada berbagai proyek yang menantang 
                        dan memberikan dampak positif. Selain itu, saya juga senang [hobi atau aktivitas favorit Anda] pada waktu luang saya.
                    </p>
                    <p class="text-justify">
                        Jika Anda ingin tahu lebih banyak tentang saya atau berkolaborasi dalam proyek yang menarik, jangan ragu untuk 
                        menghubungi saya melalui halaman <a href="/kontak" class="text-primary">Kontak</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
