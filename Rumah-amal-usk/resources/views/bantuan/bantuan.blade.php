@extends('layouts.layout')

@section('title', 'FAQ | Rumah Amal USK')

@section('meta')
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Kami menyediakan sistem dan layanan yang memudahkan para muzakki atau donatur dalam menunaikan zakat, infaq, shadaqah, maupun wakaf dengan sebaik-baiknya.">
    <link rel="stylesheet" href="{{ asset('assets/css/faq.css') }}">
@endsection

@section('content')

<main class="main">
  <!-- Page Title -->
  <div class="page-title">
    <div class="heading">
      <div class="container">
        <div class="row d-flex justify-content-center text-center">
          <div class="col-lg-8">
            <h1>Paling Sering Ditanyakan</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Page Title -->

  <!-- Search Bar -->
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-6 d-flex">
        <input type="text" id="searchFaq" class="form-control search-input" placeholder="Cari pertanyaan..." onkeypress="handleKeyPress(event)">
        <button class="search-btn" onclick="searchFaqs()">Cari</button>
      </div>
    </div>
  </div>
  <!-- End Search Bar -->

  <section id="faq" class="faq-section mt-4">
    <div class="container">
      <div class="row" id="faqList">
      @if(count($faqs) > 0)
        @foreach ($faqs as $key => $faq)
          <div class="col-md-4 mb-4 faq-item">
            <div class="faq-box p-3 border rounded shadow-sm">
              <p class="faq-category text-danger">Rumah Amal USK</p>
              <a href="{{ route('bantuan.show', ['id' => $key]) }}" class="faq-link">
                <h4 class="faq-question">{{ $faq['question'] }}</h4>
              </a>
            </div>
          </div>
        @endforeach
      @else
        <div class="col-12 text-center" id="notFoundMessage">
          <p class="alert alert-warning">Pertanyaan yang dicari tidak tersedia.</p>
        </div>
      @endif 
      </div>
      <div class="col-12 text-center" id="searchNotFoundMessage" style="display: none;">
        <p class="alert alert-warning">Pertanyaan yang dicari tidak tersedia.</p>
      </div>
    </div>
  </section>
</main>

@endsection

@push('scripts')

<script>
  function searchFaqs() {
    let searchQuery = document.getElementById('searchFaq').value.toLowerCase().trim();
    let faqs = document.querySelectorAll('.faq-item');
    let notFoundMessage = document.getElementById('searchNotFoundMessage');
    let found = false;
    
    faqs.forEach(function(faq) {
      let question = faq.querySelector('.faq-question').textContent.toLowerCase();
      if (question.includes(searchQuery)) {
        faq.style.display = 'block';
        found = true;
      } else {
        faq.style.display = 'none';
      }
    });
    
    notFoundMessage.style.display = found ? 'none' : 'block';
  }

  function handleKeyPress(event) {
    if (event.key === 'Enter') {
      searchFaqs();
    }
  }
</script>
@endpush
