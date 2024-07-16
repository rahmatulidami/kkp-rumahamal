@extends('layouts.layout')

@section('title', 'Donasi-infak | Rumah Amal USK')

@section('content')

<main class="main">

    <!-- Page Title -->
    <div class="page-title">
      <div class="heading">
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="/">Home</a></li>
            <li class="current">Infak</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- Section -->
    <section id="infak" class="infak section">
        <div class="container">
            <div class="left">
                <a class="button-infak" role="button">Infak</a>
                <a class="button-zakat" role="button">Zakat</a>
            </div>
            <div class="right">Right Content</div>
        </div>
    </section> <!-- End Section -->
</main>
@endsection