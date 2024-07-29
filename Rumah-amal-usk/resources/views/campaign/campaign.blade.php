@extends('layouts.layout')

@section('title', 'Campaign')

@section('content')

  <main class="main">

    <!-- Page Title -->
    <div class="page-title">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>CAMPAIGN</h1>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="/">Home</a></li>
            <li class="current">Campaign</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- campaign Section -->
    <section id="campaign-unggulan" class="campaign-unggulan section">
<div class="container">

  <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

        <div class="program-filters" data-aos="fade-up" data-aos-delay="100">
            <select id="filter-select" class="isotope-filters">
                <option value="*" class="filter-active">ALL</option>
                <option value=".filter-pendidikan">PENDIDIKAN</option>
                <option value=".filter-pemberdayaan">PEMBERDAYAAN</option>
                <option value=".filter-sosial">SOSIAL & KEMANUSIAAN</option>
                <option value=".filter-syiar">SYIAR & QURBAN</option>
                <option value=".filter-kemitraan">KEMITRAAN</option>
                <option value=".filter-fasilitator">FASILITATOR & RELAWAN</option>
            </select>
        </div>

    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

    <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-pendidikan">
      <div class="campaign-unggulan-content h-100">
          <a href=""><img src="assets/img/campaign/palestine.png" alt=""></a>
          <div class="campaign-unggulan-info">
              <h4><a href="campaign-unggulan-details.html" title="More Details">Peduli Palestine</a></h4>
              <div class="progress-container">
                <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">3 hari lagi</div>
                      </div>
                  </div>

                  <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar w-75"></div>
                  </div>

                  <div class="progress-info">
                      <div class="progress-start">
                          <span>Terkumpul</span>
                          <div class="amount">Rp. 2.500.000</div>
                      </div>

                      <div class="progress-end">
                          <span>Dana dibutuhkan</span>
                          <div class="jumlah">Rp. 3.000.000</div>
                      </div>
                  </div>
                  
              </div>
              <a class="btn-btn-primary" href="/donate" role="button">DONASI</a>
          </div>
      </div>
  </div><!-- End campaign-unggulan Item -->

  <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-product">
      <div class="campaign-unggulan-content h-100">
          <a href=""><img src="assets/img/campaign/palestine.png" alt=""></a>
          <div class="campaign-unggulan-info">
              <h4><a href="campaign-unggulan-details.html" title="More Details">Peduli Palestine</a></h4>
              <div class="progress-container">
                <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">3 hari lagi</div>
                      </div>
                  </div>

                  <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar w-75"></div>
                  </div>

                  <div class="progress-info">
                      <div class="progress-start">
                          <span>Terkumpul</span>
                          <div class="amount">Rp. 2.500.000</div>
                      </div>

                      <div class="progress-end">
                          <span>Dana dibutuhkan</span>
                          <div class="jumlah">Rp. 3.000.000</div>
                      </div>
                  </div>
                  
              </div>
              <a class="btn-btn-primary" href="/donate" role="button">DONASI</a>
          </div>
      </div>
  </div><!-- End campaign-unggulan Item -->

  <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-product">
      <div class="campaign-unggulan-content h-100">
          <a href=""><img src="assets/img/campaign/palestine.png" alt=""></a>
          <div class="campaign-unggulan-info">
              <h4><a href="campaign-unggulan-details.html" title="More Details">Peduli Palestine</a></h4>
              <div class="progress-container">
                <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">3 hari lagi</div>
                      </div>
                  </div>

                  <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar w-75"></div>
                  </div>

                  <div class="progress-info">
                      <div class="progress-start">
                          <span>Terkumpul</span>
                          <div class="amount">Rp. 2.500.000</div>
                      </div>

                      <div class="progress-end">
                          <span>Dana dibutuhkan</span>
                          <div class="jumlah">Rp. 3.000.000</div>
                      </div>
                  </div>
                  
              </div>
              <a class="btn-btn-primary" href="/donate" role="button">DONASI</a>
          </div>
      </div>
  </div><!-- End campaign-unggulan Item -->

  <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-product">
      <div class="campaign-unggulan-content h-100">
          <a href=""><img src="assets/img/campaign/palestine.png" alt=""></a>
          <div class="campaign-unggulan-info">
              <h4><a href="campaign-unggulan-details.html" title="More Details">Peduli Palestine</a></h4>
              <div class="progress-container">
                <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">3 hari lagi</div>
                      </div>
                  </div>

                  <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar w-75"></div>
                  </div>

                  <div class="progress-info">
                      <div class="progress-start">
                          <span>Terkumpul</span>
                          <div class="amount">Rp. 2.500.000</div>
                      </div>

                      <div class="progress-end">
                          <span>Dana dibutuhkan</span>
                          <div class="jumlah">Rp. 3.000.000</div>
                      </div>
                  </div>
                  
              </div>
              <a class="btn-btn-primary" href="/donate" role="button">DONASI</a>
          </div>
      </div>
  </div><!-- End campaign-unggulan Item -->

  <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-product">
      <div class="campaign-unggulan-content h-100">
          <a href=""><img src="assets/img/campaign/palestine.png" alt=""></a>
          <div class="campaign-unggulan-info">
              <h4><a href="campaign-unggulan-details.html" title="More Details">Peduli Palestine</a></h4>
              <div class="progress-container">
                <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">3 hari lagi</div>
                      </div>
                  </div>

                  <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar w-75"></div>
                  </div>

                  <div class="progress-info">
                      <div class="progress-start">
                          <span>Terkumpul</span>
                          <div class="amount">Rp. 2.500.000</div>
                      </div>

                      <div class="progress-end">
                          <span>Dana dibutuhkan</span>
                          <div class="jumlah">Rp. 3.000.000</div>
                      </div>
                  </div>
                  
              </div>
              <a class="btn-btn-primary" href="/donate" role="button">DONASI</a>
          </div>
      </div>
  </div><!-- End campaign-unggulan Item -->

  <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-product">
      <div class="campaign-unggulan-content h-100">
          <a href=""><img src="assets/img/campaign/palestine.png" alt=""></a>
          <div class="campaign-unggulan-info">
              <h4><a href="campaign-unggulan-details.html" title="More Details">Peduli Palestine</a></h4>
              <div class="progress-container">
                <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">3 hari lagi</div>
                      </div>
                  </div>

                  <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar w-75"></div>
                  </div>

                  <div class="progress-info">
                      <div class="progress-start">
                          <span>Terkumpul</span>
                          <div class="amount">Rp. 2.500.000</div>
                      </div>

                      <div class="progress-end">
                          <span>Dana dibutuhkan</span>
                          <div class="jumlah">Rp. 3.000.000</div>
                      </div>
                  </div>
                  
              </div>
              <a class="btn-btn-primary" href="/donate" role="button">DONASI</a>
          </div>
      </div>
  </div><!-- End campaign-unggulan Item -->

    </div><!-- End Portfolio Container -->

  </div>

</div>

</section>

</main>

@endsection