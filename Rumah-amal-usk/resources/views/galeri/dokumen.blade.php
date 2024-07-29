@extends('layouts.layout')

@section('title', 'Dokumen | Rumah Amal USK')

@section('content')

<main class="main">

<!-- Page Title -->
<div class="page-title">
    <div class="heading">
        <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
                <h1>DOKUMEN</h1>
            </div>
        </div>
    </div>
</div>

  <!-- Section -->
  <section id="dokumen" class="dokumen section">
    <div class="container">
        <div class="kumpulan-dokumen">
            <div class="icon-and-details">
                <i class="bi bi-filetype-pdf"></i>
                <div class="details">
                    <p class="dokumen-name">Pengumuman Beasiswa BPRA-UKT</p>
                    <p class="date"><strong>11-Juli-2024</strong></p>
                </div>
                <i class="bi bi-download"></i>
            </div>
        </div>

        <div class="kumpulan-dokumen">
            <div class="icon-and-details">
                <i class="bi bi-filetype-doc"></i>
                <div class="details">
                    <p class="dokumen-name">Pengumuman Beasiswa BPRA-UKT</p>
                    <p class="date"><strong>11-Juli-2024</strong></p>
                </div>
                <i class="bi bi-download"></i>
            </div>
        </div>

        <div class="kumpulan-dokumen">
            <div class="icon-and-details">
                <i class="bi bi-filetype-csv"></i>
                <div class="details">
                    <p class="dokumen-name">Pengumuman Beasiswa BPRA-UKT</p>
                    <p class="date"><strong>11-Juli-2024</strong></p>
                </div>
                <i class="bi bi-download"></i>
            </div>
        </div>
    </div>
</section>
 <!-- End Section -->

</main>

@endsection
