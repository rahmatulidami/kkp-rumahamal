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
                <a class="button-infak" href="/donasi-infak" role="button">Infak</a>
                <a class="button-zakat" href="/" role="button">Zakat</a>
            </div>
            <div class="right">
                <div class="judul">
                    <i class="bi bi-cash-coin"></i>
                    <h3>Ayo Mulai Berinfak!</h3>
                </div>

                <div>
                    <p>Silakan isi jumlah infakmu. Insya Allah berkah.</p>
                </div>

                <div class="input-group">
                    <button id="currency-button">Rp.</button>
                    <input type="number" id="infak-amount" placeholder="Masukkan jumlah" oninput="updateTotal()">
                </div>

                <p id="total-infak"></p>

                <div class="button">
                    <a class="button-infak" href="/donate" role="button">Infak</a>
                </div>

                
            </div>
        </div>
    </section> <!-- End Section -->
</main>
@endsection

<script>
  function updateTotal() {
    const amount = document.getElementById('infak-amount').value;
    const totalInfak = document.getElementById('total-infak');

    if (amount) {
      totalInfak.textContent = `Jumlah total infakmu adalah Rp. ${amount}`;
    } else {
      totalInfak.textContent = '';
    }
  }
</script>