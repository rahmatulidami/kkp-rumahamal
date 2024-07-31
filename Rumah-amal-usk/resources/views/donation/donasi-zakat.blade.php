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

        <div class="form-group">
          <label for="zakat-type">Pilih Jenis Zakat:</label>
          <select id="zakat-type" class="form-control" onchange="updateInputs()">
            <option value="">--Pilih Jenis Zakat--</option>
            <option value="Zakat Maal">Maal</option>
            <option value="Zakat Fitrah">Fitrah</option>
            <option value="Zakat Emas">Emas</option>
            <option value="Zakat Perniagaan">Perniagaan</option>
          </select>
        </div>

        <div id="input-fields" class="form-group">
          <!-- Additional input fields will be inserted here -->
        </div>

        <p id="total-zakat" class="total-zakat"></p>

        <div class="button">
          <a class="button-zakat" href="/donate" role="button">Bayar Zakat</a>
        </div>
      </div>
    </div>
  </section> <!-- End Section -->
</main>

@endsection

<style>

  .form-group {
    margin-bottom: 15px;
  }

  .form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
  }

  .input-group input {
    padding: 10px;
    border: 1px solid #ccc;
    border-left: none;
    font-size: 16px;
    flex: 1;
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
  }

  .input-group button {
    padding: 10px;
    border: 1px solid #ccc;
    border-right: none;
    font-size: 16px;
    background-color: #f8f8f8;
    cursor: default;
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
  }

  .total-zakat {
    font-weight: bold;
    margin-top: 15px;
  }

  .button {
    margin-top: 20px;
    text-align: center;
  }

  .button a {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
  }

  .button a:hover {
    background-color: #0056b3;
  }
</style>

<script>
  function updateInputs() {
    const zakatType = document.getElementById('zakat-type').value;
    const inputFields = document.getElementById('input-fields');
    inputFields.innerHTML = '';

    if (zakatType === 'Zakat Emas') {
      inputFields.innerHTML = `
        <div class="form-group">
          <p>Pastikan harta Anda memenuhi syarat untuk berzakat / sudah nishab (senilai 85 gram emas)</p>
        </div>
        <div class="form-group">
          <label for="emas">Jumlah Emas (gram):</label>
          <input type="number" id="emas" class="form-control" oninput="updateTotal()">
        </div>
        <div class="form-group">
          <label for="perhiasan">Jumlah Perhiasan (gram):</label>
          <input type="number" id="perhiasan" class="form-control" oninput="updateTotal()">
        </div>
        <div class="form-group">
          <label for="perak">Jumlah Perak (gram):</label>
          <input type="number" id="perak" class="form-control" oninput="updateTotal()">
        </div>
      `;
    } else if (zakatType === 'Zakat Perniagaan') {
      inputFields.innerHTML = `
        <div class="form-group">
          <label for="aset">Nilai Aset:</label>
          <input type="number" id="aset" class="form-control" oninput="updateTotal()">
        </div>
        <div class="form-group">
          <label for="laba">Nilai Laba:</label>
          <input type="number" id="laba" class="form-control" oninput="updateTotal()">
        </div>
        <div class="form-group">
          <label for="hutang">Nilai Hutang:</label>
          <input type="number" id="hutang" class="form-control" oninput="updateTotal()">
        </div>
      `;
    } else if (zakatType === 'Zakat Maal') {
      inputFields.innerHTML = `
        <div class="input-group">
          <button id="currency-button">Rp.</button>
          <input type="number" id="zakat-amount" class="form-control" placeholder="Masukkan jumlah" oninput="updateTotal()">
        </div>
        <div class="form-group">
          <p>Pastikan harta Anda memenuhi syarat untuk berzakat / sudah nishab (senilai 85 gram emas)</p>
        </div>
      `;
    }
    updateTotal();
  }

  function updateTotal() {
    const zakatType = document.getElementById('zakat-type').value;
    const totalZakat = document.getElementById('total-zakat');
    let zakatAmount = 0;

    if (zakatType === 'Zakat Maal') {
      const amount = parseFloat(document.getElementById('zakat-amount')?.value || 0);
      zakatAmount = amount * 0.025;
    } else if (zakatType === 'Zakat Emas') {
      const emas = parseFloat(document.getElementById('emas')?.value || 0);
      const perhiasan = parseFloat(document.getElementById('perhiasan')?.value || 0);
      const perak = parseFloat(document.getElementById('perak')?.value || 0);
      const total = emas + perhiasan + perak;
      zakatAmount = total * 0.025;
      totalZakat.innerHTML = `Jumlah total ${zakatType}mu adalah ${zakatAmount.toFixed(2)} gram.`;
      return;
    } else if (zakatType === 'Zakat Perniagaan') {
      const aset = parseFloat(document.getElementById('aset')?.value || 0);
      const laba = parseFloat(document.getElementById('laba')?.value || 0);
      const hutang = parseFloat(document.getElementById('hutang')?.value || 0);
      const total = (aset + laba) - hutang;
      zakatAmount = total * 0.025;
    } else if (zakatType === 'Zakat Fitrah') {
      zakatAmount = 30000; // Fixed amount for Zakat Fitrah
    }

    totalZakat.innerHTML = zakatType ? `Jumlah total ${zakatType}mu adalah <span class="total-amount">Rp. ${zakatAmount.toFixed(2)}</span>` : '';
  }
</script>
