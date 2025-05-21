@extends('layouts.layout')

@section('title', 'Donasi-Zakat | Rumah Amal USK')

@section('meta')
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Kami menyediakan sistem dan layanan yang memudahkan para muzakki atau donatur dalam menunaikan zakat, infaq, shadaqah, maupun wakaf dengan sebaik-baiknya.">
    <link rel="stylesheet" href="{{ asset('assets/css/zakat.css') }}">
@endsection

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
          <h3>Ayo Hitung Zakat Anda!</h3>
        </div>

        <div class="form-group">
          <label for="zakat-type">Pilih Jenis Zakat:</label>
          <select id="zakat-type" class="form-control" onchange="updateInputs()">
            <option value="">--Pilih Jenis Zakat--</option>
            <option value="Zakat Maal">Maal</option>
            <option value="Zakat Profesi">Profesi</option>
            <option value="Zakat Emas">Emas</option>
            <option value="Zakat Perniagaan">Perniagaan</option>
            <option value="Zakat Perusahaan">Perusahaan</option>
          </select>
        </div>

        <div id="input-fields" class="form-group"></div>
        <div id="info-message" class="info-message"></div>
        <p id="total-zakat" class="total-zakat"></p>
        <p id="not-wajib-message" class="not-wajib-message" style="color:red; display:none;"></p>
        <div id="zakat-info" style="margin-top: 20px; background: #f8f9fa; padding: 15px; border-radius: 5px;"></div>

        <div class="button">
          <a id="pay-button" class="button-zakat" href="/donate" role="button" style="display:none;">Bayar Zakat</a>
        </div>
      </div>
    </div>
  </section>
</main>

@endsection

@push('scripts')
<script>
  let goldPricePerGram = 0;
  const nishabMaal = 94;
  const nishabProfesi = 10500000;
  const nishabEmas = 94;
  const nishabPerniagaan = 94;
  const nishabPerusahaan = 94;

  async function getGoldPrice() {
    try {
      const response = await fetch('https://logam-mulia-api.vercel.app/prices/hargaemas-com');
      const data = await response.json();
      goldPricePerGram = data.data[0].sell;
      console.log('Current gold sell price:', goldPricePerGram);
      updateGoldPriceDisplay();
    } catch (error) {
      console.error('Error fetching gold price:', error);
      goldPricePerGram = 1000000;
      updateGoldPriceDisplay();
    }
  }

  function updateGoldPriceDisplay() {
    const zakatInfo = document.getElementById('zakat-info');
    const zakatType = document.getElementById('zakat-type').value;
    
    if (zakatType === 'Zakat Emas') {
      zakatInfo.innerHTML = `<strong>Harga emas hari ini:</strong> ${formatRupiah(goldPricePerGram)}/gram`;
      zakatInfo.style.display = 'block';
    } else if (zakatType === 'Zakat Maal' || zakatType === 'Zakat Perniagaan' || zakatType === 'Zakat Perusahaan') {
      zakatInfo.innerHTML = `<strong>Nishab (94 gram emas):</strong> ${formatRupiah(nishabMaal * goldPricePerGram)}`;
      zakatInfo.style.display = 'block';
    } else if (zakatType === 'Zakat Profesi') {
      zakatInfo.innerHTML = `
        <strong>Ketentuan Zakat Profesi:</strong><br>
        - Nishab: ${formatRupiah(nishabProfesi)} per bulan<br>
        (${formatRupiah(nishabProfesi*12)} per tahun)
      `;
      zakatInfo.style.display = 'block';
    } else {
      zakatInfo.style.display = 'none';
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    getGoldPrice();
  });

  function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
  }

  function updateInputs() {
    const zakatType = document.getElementById('zakat-type').value;
    const inputFields = document.getElementById('input-fields');
    const totalZakat = document.getElementById('total-zakat');
    const notWajibMessage = document.getElementById('not-wajib-message');
    const payButton = document.getElementById('pay-button');
    
    // Reset all previous displays
    inputFields.innerHTML = '';
    totalZakat.innerHTML = '';
    totalZakat.style.display = 'none';
    notWajibMessage.innerHTML = '';
    notWajibMessage.style.display = 'none';
    payButton.style.display = 'none';
    
    const zakatInfo = document.getElementById('zakat-info');

    if (zakatType === 'Zakat Maal') {
      inputFields.innerHTML = `
        <div class="form-group">
          <label for="total-harta">Total Harta (Rp):</label>
          <input type="text" id="total-harta" class="form-control" oninput="formatInput(this); calculateZakat()" placeholder="Total harta yang dimiliki">
        </div>
        <div class="form-group">
          <label for="hutang">Hutang (Rp):</label>
          <input type="text" id="hutang" class="form-control" oninput="formatInput(this); calculateZakat()" placeholder="Total hutang">
        </div>
      `;
      zakatInfo.innerHTML = `
        <strong>Ketentuan Zakat Maal:</strong><br>
        - Nishab: 94 gram emas (senilai ${formatRupiah(nishabMaal * goldPricePerGram)})<br>
        - Kadar zakat: 2.5% dari total harta bersih<br>
        - Harta bersih = Total Harta - Hutang <br><br>
		 <strong>Perhatian:</strong> Nishab zakat di Aceh adalah 94 gram emas
      `;
      zakatInfo.style.display = 'block';
    } else if (zakatType === 'Zakat Profesi') {
      inputFields.innerHTML = `
        <div class="form-group">
          <label for="penghasilan">Penghasilan Bulanan (Rp):</label>
          <input type="text" id="penghasilan" class="form-control" oninput="formatInput(this); calculateZakat()" placeholder="Penghasilan bersih per bulan">
        </div>
        <div class="form-group">
          <label for="bonus">Bonus/Tunjangan (Rp):</label>
          <input type="text" id="bonus" class="form-control" oninput="formatInput(this); calculateZakat()" placeholder="Bonus/tunjangan lain">
        </div>
      `;
      zakatInfo.innerHTML = `
        <strong>Ketentuan Zakat Profesi:</strong><br>
        - Nishab per Bulan: ${formatRupiah(nishabProfesi)} <br>
        - Nishab per Tahun: ${formatRupiah(nishabProfesi*12)} <br>
        - Kadar Zakat: 2.5% dari penghasilan bersih
      `;
      zakatInfo.style.display = 'block';
    } else if (zakatType === 'Zakat Perniagaan') {
      inputFields.innerHTML = `
        <div class="form-group">
          <label for="aset">Total Aset dan Keuntungan (Rp):</label>
          <input type="text" id="aset" class="form-control" oninput="formatInput(this); calculateZakat()" placeholder="Total Aset dan Keuntungan yang dimiliki">
        </div>
        <div class="form-group">
          <label for="hutang">Hutang Jangka Pendek (Rp):</label>
          <input type="text" id="hutang" class="form-control" oninput="formatInput(this); calculateZakat()" placeholder="Hutang yang harus segera dibayar">
        </div>
      `;
      zakatInfo.innerHTML = `
        <strong>Ketentuan Zakat Perniagaan:</strong><br>
        - Nishab: 94 gram emas (senilai ${formatRupiah(nishabPerniagaan * goldPricePerGram)})<br>
        - Kadar zakat: 2.5% dari total harta usaha<br>
        - Harta usaha = Total Aset dan Keuntungan - Hutang Jangka Pendek<br><br>
        <strong>Perhatian:</strong> Nishab zakat di Aceh adalah 94 gram emas
      `;
      zakatInfo.style.display = 'block';
    } else if (zakatType === 'Zakat Emas') {
      inputFields.innerHTML = `
        <div class="form-group">
          <label for="berat-emas">Berat Emas (gram):</label>
          <input type="number" id="berat-emas" class="form-control" oninput="calculateZakat()" placeholder="Berat emas yang dimiliki">
        </div>
      `;
      zakatInfo.innerHTML = `
        <strong>Ketentuan Zakat Emas:</strong><br>
        - Nishab: 94 gram emas<br>
        - Kadar zakat: 2.5% dari total nilai emas<br>
        <strong>Harga emas hari ini (<a href="https://www.hargaemas.com/" target="_blank" style="color:rgb(3, 129, 41); ">hargaemas.com</a>):</strong> ${formatRupiah(goldPricePerGram)}/gram
		<br><br>
		 <strong>Perhatian:</strong> Nishab zakat di Aceh adalah 94 gram emas
      `;
      zakatInfo.style.display = 'block';
    } else if (zakatType === 'Zakat Perusahaan') {
      inputFields.innerHTML = `
        <div class="form-group">
          <label for="jenis-perusahaan">Jenis Perusahaan:</label>
          <select id="jenis-perusahaan" class="form-control" onchange="calculateZakat()">
            <option value="dagang">Perusahaan Dagang/Industri</option>
            <option value="jasa">Perusahaan Jasa</option>
          </select>
        </div>
        <div class="form-group" id="aset-lancar-group">
          <label for="aset-lancar">Aset Lancar (Rp):</label>
          <input type="text" id="aset-lancar" class="form-control" oninput="formatInput(this); calculateZakat()" placeholder="Total aset lancar perusahaan">
        </div>
        <div class="form-group" id="utang-lancar-group">
          <label for="utang-lancar">Utang Lancar (Rp):</label>
          <input type="text" id="utang-lancar" class="form-control" oninput="formatInput(this); calculateZakat()" placeholder="Total utang lancar perusahaan">
        </div>
        <div class="form-group" id="laba-group" style="display:none;">
          <label for="laba">Laba Sebelum Pajak (Rp):</label>
          <input type="text" id="laba" class="form-control" oninput="formatInput(this); calculateZakat()" placeholder="Laba sebelum pajak">
        </div>
      `;
      zakatInfo.innerHTML = `
        <strong>Ketentuan Zakat Perusahaan:</strong><br>
        - Nishab: 94 gram emas (senilai ${formatRupiah(nishabPerusahaan * goldPricePerGram)})<br>
        - Untuk perusahaan dagang/industri: 2.5% × (Aset Lancar - Utang Lancar)<br>
        - Untuk perusahaan jasa: 2.5% × Laba Sebelum Pajak<br><br>
        <strong>Perhatian:</strong> Nishab zakat di Aceh adalah 94 gram emas
      `;
      zakatInfo.style.display = 'block';
      
      // Add event listener for company type change
      document.getElementById('jenis-perusahaan').addEventListener('change', function() {
        const jenis = this.value;
        if (jenis === 'dagang') {
          document.getElementById('aset-lancar-group').style.display = 'block';
          document.getElementById('utang-lancar-group').style.display = 'block';
          document.getElementById('laba-group').style.display = 'none';
        } else {
          document.getElementById('aset-lancar-group').style.display = 'none';
          document.getElementById('utang-lancar-group').style.display = 'none';
          document.getElementById('laba-group').style.display = 'block';
        }
        calculateZakat();
      });
    } else {
      zakatInfo.style.display = 'none';
    }
  }

  function formatInput(input) {
    let value = input.value.replace(/\D/g, '');
    input.value = formatRupiah(value).replace('Rp', '').trim();
    calculateZakat();
  }

  function parseCurrency(value) {
    return parseInt(value.replace(/\D/g, '')) || 0;
  }

  function calculateZakat() {
    const zakatType = document.getElementById('zakat-type').value;
    const totalZakat = document.getElementById('total-zakat');
    const notWajibMessage = document.getElementById('not-wajib-message');
    const payButton = document.getElementById('pay-button');

    if (!zakatType) {
      totalZakat.style.display = 'none';
      notWajibMessage.style.display = 'none';
      payButton.style.display = 'none';
      return;
    }

    if (zakatType === 'Zakat Maal') {
      const totalHarta = parseCurrency(document.getElementById('total-harta')?.value || 0);
      const hutang = parseCurrency(document.getElementById('hutang')?.value || 0);
      const hartaBersih = totalHarta - hutang;
      const nishabValue = nishabMaal * goldPricePerGram;

      if (hartaBersih >= nishabValue) {
        const zakatAmount = hartaBersih * 0.025;
        totalZakat.innerHTML = `
          <strong>Zakat Maal yang harus dibayar:</strong> ${formatRupiah(zakatAmount)}<br>
          <small>Perhitungan: 2.5% × ${formatRupiah(hartaBersih)} (harta bersih)</small>
        `;
        totalZakat.style.display = 'block';
        notWajibMessage.style.display = 'none';
        payButton.style.display = 'block';
      } else {
        totalZakat.style.display = 'none';
        notWajibMessage.innerHTML = `
          <strong>Anda belum wajib zakat Maal, silahkan anda berinfak saja</strong><br>
          Nishab zakat maal saat ini adalah ${formatRupiah(nishabValue)} (94 gram emas).<br>
          Total harta bersih Anda ${formatRupiah(hartaBersih)}.
        `;
        notWajibMessage.style.display = 'block';
        payButton.style.display = 'none';
      }
    } else if (zakatType === 'Zakat Profesi') {
      const penghasilan = parseCurrency(document.getElementById('penghasilan')?.value || 0);
      const bonus = parseCurrency(document.getElementById('bonus')?.value || 0);
      const penghasilanBulanan = penghasilan + bonus;
      const penghasilanTahunan = (penghasilan + bonus ) * 12;

      if (penghasilanBulanan >= nishabProfesi) {
        const zakatAmount = penghasilanBulanan * 0.025;
        const zakatTahun = penghasilanBulanan * 0.025 * 12;
        totalZakat.innerHTML = `
          <strong>Zakat Profesi yang harus dibayar per bulan:</strong> ${formatRupiah(zakatAmount)}<br>
          <small>Perhitungan: 2.5% × ${formatRupiah(penghasilanBulanan)} (penghasilan bulanan)</small><br>
          <strong>Zakat Profesi yang harus dibayar per tahun:</strong> ${formatRupiah(zakatTahun)}<br>
          <small>Perhitungan: 2.5% × ${formatRupiah(penghasilanTahunan)} (penghasilan tahunan)</small>
        `;
        totalZakat.style.display = 'block';
        notWajibMessage.style.display = 'none';
        payButton.style.display = 'block';
      } else {
        totalZakat.style.display = 'none';
        notWajibMessage.innerHTML = `
          <strong>Anda belum wajib zakat profesi, silahkan anda berinfak saja</strong><br><br>
          <strong>Nishab zakat profesi:</strong><br>
          - Per bulan: ${formatRupiah(nishabProfesi)}<br><br>
          <strong>Penghasilan Anda:</strong><br>
          - Bulan ini: ${formatRupiah(penghasilanBulanan)}<br>
          <em>Zakat profesi diwajibkan ketika penghasilan mencapai nishab</em>
        `;
        notWajibMessage.style.display = 'block';
        payButton.style.display = 'none';
      }
    } else if (zakatType === 'Zakat Perniagaan') {
      const aset = parseCurrency(document.getElementById('aset')?.value || 0);
      const hutang = parseCurrency(document.getElementById('hutang')?.value || 0);
      
      const totalAsset = aset - hutang;
      const nishabValue = nishabPerniagaan * goldPricePerGram;

      if (totalAsset >= nishabValue) {
        const zakatAmount = totalAsset * 0.025;
        totalZakat.innerHTML = `
          <strong>Zakat Perniagaan yang harus dibayar:</strong> <strong style="color: #218838;">${formatRupiah(zakatAmount)}</strong><br>
          <small>Perhitungan: 2.5% × ${formatRupiah(totalAsset)} (total harta usaha)</small>
        `;
        totalZakat.style.display = 'block';
        notWajibMessage.style.display = 'none';
        payButton.style.display = 'block';
      } else {
        totalZakat.style.display = 'none';
        notWajibMessage.innerHTML = `
          <strong>Anda belum wajib zakat perniagaan, silahkan anda berinfak saja</strong><br>
          Nishab zakat perniagaan saat ini adalah ${formatRupiah(nishabValue)} (94 gram emas).<br>
          Total harta usaha Anda ${formatRupiah(totalAsset)}.
        `;
        notWajibMessage.style.display = 'block';
        payButton.style.display = 'none';
      }
    } else if (zakatType === 'Zakat Emas' && goldPricePerGram > 0) {
      const beratEmas = parseFloat(document.getElementById('berat-emas')?.value) || 0;
      const totalNilaiEmas = beratEmas * goldPricePerGram;
      
      if (beratEmas >= nishabEmas) {
        const zakatAmount = totalNilaiEmas * 0.025;
        totalZakat.innerHTML = `
          <strong>Zakat Emas yang harus dibayar:</strong> <strong style="color: #218838;">${formatRupiah(zakatAmount)}</strong><br>
          <small>Perhitungan: 2.5% × (${beratEmas} gram × ${formatRupiah(goldPricePerGram)}/gram)</small>
        `;
        totalZakat.style.display = 'block';
        notWajibMessage.style.display = 'none';
        payButton.style.display = 'block';
      } else {
        totalZakat.style.display = 'none';
        notWajibMessage.innerHTML = `
          <strong>Anda belum wajib zakat Emas, silahkan anda berinfak saja</strong><br>
          Nishab zakat emas adalah ${nishabEmas} gram (senilai ${formatRupiah(nishabEmas * goldPricePerGram)}).<br>
          Emas yang Anda miliki ${beratEmas} gram (senilai ${formatRupiah(totalNilaiEmas)}).
        `;
        notWajibMessage.style.display = 'block';
        payButton.style.display = 'none';
      }
    } else if (zakatType === 'Zakat Perusahaan') {
      const jenisPerusahaan = document.getElementById('jenis-perusahaan').value;
      let zakatAmount = 0;
      let nishabValue = nishabPerusahaan * goldPricePerGram;
      let wajibZakat = false;
      let calculationDetails = '';

      if (jenisPerusahaan === 'dagang') {
        const asetLancar = parseCurrency(document.getElementById('aset-lancar')?.value || 0);
        const utangLancar = parseCurrency(document.getElementById('utang-lancar')?.value || 0);
        const hartaBersih = asetLancar - utangLancar;
        
        if (hartaBersih >= nishabValue) {
          zakatAmount = hartaBersih * 0.025;
          calculationDetails = `2.5% × (${formatRupiah(asetLancar)} - ${formatRupiah(utangLancar)})`;
          wajibZakat = true;
        } else {
          notWajibMessage.innerHTML = `
            <strong>Perusahaan Anda belum wajib zakat, silahkan berinfak saja</strong><br>
            Nishab zakat perusahaan saat ini adalah ${formatRupiah(nishabValue)} (94 gram emas).<br>
            Total harta bersih perusahaan Anda ${formatRupiah(hartaBersih)}.
          `;
        }
      } else {
        const laba = parseCurrency(document.getElementById('laba')?.value || 0);
        
        if (laba >= nishabValue) {
          zakatAmount = laba * 0.025;
          calculationDetails = `2.5% × ${formatRupiah(laba)}`;
          wajibZakat = true;
        } else {
          notWajibMessage.innerHTML = `
             <strong>Perusahaan Anda belum wajib zakat, silahkan berinfak saja</strong><br>
            Nishab zakat perusahaan saat ini adalah ${formatRupiah(nishabValue)} (94 gram emas).<br>
            Laba perusahaan Anda ${formatRupiah(laba)}.
          `;
        }
      }

      if (wajibZakat) {
        totalZakat.innerHTML = `
          <strong>Zakat Perusahaan yang harus dibayar:</strong> <strong style="color: #218838;">${formatRupiah(zakatAmount)}</strong><br>
          <small>Perhitungan: ${calculationDetails}</small>
        `;
        totalZakat.style.display = 'block';
        notWajibMessage.style.display = 'none';
        payButton.style.display = 'block';
      } else {
        totalZakat.style.display = 'none';
        notWajibMessage.style.display = 'block';
        payButton.style.display = 'none';
      }
    }
  }
</script>
@endpush