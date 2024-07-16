@extends('layouts.layout')

@section('title', 'Donasi-infak | Rumah Amal USK')

@section('content')

<main class="main">

  <!-- Section -->
  <section id="infak" class="infak section">
    <div class="container">
      <div class="left">
        <a class="button-infak" href="/donasi-infak" role="button">Infak</a>
        <a class="button-zakat" href="/donasi-zakat" role="button">Zakat</a>
      </div>
      <div class="right">
        <div class="judul">
          <i class="bi bi-cash-coin"></i>
          <h3>Ayo Mulai Berinfak!</h3>
        </div>

        <div>
          <p>Silakan isi jumlah infakmu. Insya Allah berkah.</p>
        </div>

        <div>
          <label for="infak-type">Pilih Jenis Infak:</label>
          <select id="infak-type" onchange="updateTotal()">
            <option value="">--Pilih Jenis Infak--</option>
            <option value="Infak Anak Yatim">Infak Anak Yatim</option>
            <option value="Infak Pembangunan Masjid">Infak Pembangunan Masjid</option>
            <option value="Infak Pendidikan">Infak Pendidikan</option>
            <option value="Infak Kesehatan">Infak Kesehatan</option>
          </select>
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
        const infakType = document.getElementById('infak-type').value;
        const totalInfak = document.getElementById('total-infak');

        if (amount) {
            totalInfak.textContent = `Jumlah total infakmu adalah Rp. ${amount} untuk ${infakType}`;
        } else {
            totalInfak.textContent = '';
        }
    }
</script>
