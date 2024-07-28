@extends('layouts.layout')

@section('title', 'Donasi-Zakat | Rumah Amal USK')

@section('content')

<main class="main">

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
          <label for="zakat-type">Pilih Jenis Zakat:</label>
          <select id="zakat-type" onchange="updateTotal()">
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
          <input type="number" id="zakat-amount" placeholder="Masukkan jumlah" oninput="updateTotal()">
        </div>

        <div>
          <p>Pastikan harta Anda memenuhi syarat untuk berzakat / sudah nishab (senilai 85 gram emas)</p>
        </div>
        
        <p id="total-zakat"></p>

        <div class="button">
          <a class="button-zakat" href="/donate" role="button">Bayar Zakat</a>
        </div>
      </div>
    </div>
  </section> <!-- End Section -->

</main>

@endsection

<script>
    function updateTotal() {
    const amount = document.getElementById('zakat-amount').value;
    const zakatType = document.getElementById('zakat-type').value;
    const totalZakat = document.getElementById('total-zakat');
    let zakatAmount = 0;

    if (amount && zakatType) {
      switch(zakatType) {
        case 'Zakat Maal':
        case 'Zakat Emas':
        case 'Zakat Perniagaan':
          zakatAmount = amount * 0.025;
          break;
        case 'Zakat Fitrah':
          zakatAmount = 30000; // Fixed amount for Zakat Fitrah
          break;
        default:
          zakatAmount = 0;
      }

      totalZakat.innerHTML = `Jumlah total Zakat ${zakatType}mu adalah <span class="total-amount">Rp. ${zakatAmount.toFixed(2)}`;
    } else {
      totalZakat.textContent = '';
    }
  }
</script>
