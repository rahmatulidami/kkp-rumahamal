@extends('layouts.layout')

@section('title', 'Donasi-Zakat | Rumah Amal USK')

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
          <li class="current">Zakat</li>
        </ol>
      </div>
    </nav>
  </div><!-- End Page Title -->

  <!-- Section -->
  <section id="zakat" class="zakat section">
    <div class="container">
      <div class="left">
        <a class="button-infak" href="/donasi-infak" role="button">Infak</a>
        <a class="button-zakat" href="/donasi-zakat" role="button">Zakat</a>
      </div>
      <div class="right">
        <div class="judul">
          <i class="bi bi-cash"></i>
          <h3>Ayo Bayar Zakat!</h3>
        </div>

        <div>
          <label for="infak-type">Pilih Jenis Zakat:</label>
          <select id="infak-type" onchange="updateTotal()">
            <option value="">--Pilih Jenis Zakat--</option>
            <option value="Zakat Maal">Maal</option>
            <option value="Zakat Fitrah">Fitrah</option>
            <option value="Zakat Emas">Emas</option>
            <option value="Zakat Perniagaan">Perniagaan</option>
          </select>
        </div>

        <div>
          <p>Coba masukkan jumlah hartamu dan kalkulator kami akan menghitung jumlah zakatnya.</p>
        </div>

        <div class="input-group">
          <button id="currency-button">Rp.</button>
          <input type="number" id="infak-amount" placeholder="Masukkan jumlah" oninput="updateTotal()">
        </div>

        <div>
          <p>Pastikan harta Anda memenuhi syarat untuk berzakat / sudah nishab (senilai 85 gram emas)</p>
        </div>
        
        <p id="total-infak"></p>

        <div class="button">
          <a class="button-infak" href="/donate" role="button">Bayar Zakat</a>
        </div>
      </div>
    </div>
  </section> <!-- End Section -->

</main>

@endsection

<script>
    function updateTotal() {
        const amount = document.getElementById('infak-amount').value;
        const infakType = document.getElementById('infak-type').value;
        const totalInfak = document.getElementById('total-infak');

        if (amount) {
            totalInfak.textContent = `Jumlah total Zakatmu adalah Rp. ${amount} untuk ${infakType}`;
        } else {
            totalInfak.textContent = '';
        }
    }
</script>
