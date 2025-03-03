@extends('layouts.layout')

@section('title', 'FAQ Detail | Rumah Amal USK')

@section('content')
<main class="main">

  <!-- Page Title -->
  <div class="page-title">
    <div class="heading">
      <div class="container">
        <div class="row d-flex justify-content-center text-center">
        </div>
      </div>
    </div>

    <nav class="breadcrumbs">
      <div class="container">
          <ol>
            <li><a href="/faq">Paling Sering Ditanyakan</a></li>
            <li class="current" id="breadcrumbCurrent">{{ $faq['question'] }}</li>
          </ol>
      </div>
    </nav>
  </div>
  <!-- End Page Title -->

  <section id="faq-detail" class="faq-detail-section mt-4">
    <div class="container">
      <div class="answer-box">
        <h4>{{ $faq['question'] }}</h4>
        <p class="text-justify">{{ $faq['answer'] }}</p>

        @if(isset($faq['steps']) && count($faq['steps']) > 0)
          <div class="faq-steps mt-4">
            @foreach($faq['steps'] as $index => $step)
              <div class="faq-step mb-3">
                <h5>Langkah {{ $index + 1 }}</h5>
                <p>{{ $step['text'] }}</p>
                @if(isset($step['image']))
                  <div class="text-center">
                    <img src="{{ asset($step['image']) }}" alt="Step {{ $index + 1 }}" class="img-fluid mx-auto d-block mt-2" style="max-width: 80%;">
                  </div>
                @endif
              </div>
            @endforeach
          </div>
        @endif

      </div>
      <div id="buttonbantuan" class="text-center">
          <a href="{{ route('bantuan.bantuan') }}" class="btn btn-primary">
              <i class="fas fa-arrow-left"></i> <span class="ms-2">Kembali ke FAQ</span>
          </a>
      </div>

    </div>
  </section>
</main>
@endsection
