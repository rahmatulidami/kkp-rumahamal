@extends('layouts.layout')

@section('title', 'Program | Rumah Amal USK')

@section('content')

<main class="main">

  <!-- Page Title -->
  <div class="page-title">
    <div class="heading">
      <div class="container">
        <div class="row d-flex justify-content-center text-center">
          <div class="col-lg-8">
            <h1>PROGRAM RUMAH AMAL USK</h1>
          </div>
        </div>
      </div>
    </div>
    <nav class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="/">Home</a></li>
          <li class="current">Program</li>
        </ol>
      </div>
    </nav>
  </div><!-- End Page Title -->

  <!-- Section -->
  <section id="program" class="program section">
    <div class="container">
      <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
        <div class="program-filters" data-aos="fade-up" data-aos-delay="100">
          <select id="filter-select" class="isotope-filters" aria-label="filter">
            <option value="*" class="filter-active">ALL</option>
            <option value=".filter-pendidikan">PENDIDIKAN</option>
            <option value=".filter-pemberdayaan">PEMBERDAYAAN</option>
            <option value=".filter-sosial">SOSIAL & KEMANUSIAAN</option>
            <option value=".filter-syiar">SYIAR & QURBAN</option>
            <option value=".filter-kemitraan">KEMITRAAN</option>
            <option value=".filter-fasilitator">FASILITATOR & RELAWAN</option>
          </select>
        </div>

        <div class="row isotope-container" data-aos="fade-up" data-aos-delay="200" id="program-items">
          <!-- Data will be injected here by JavaScript -->
        </div>
      </div>
    </div>
  </section>

</main>

@endsection

<!-- JavaScript -->
<script>
    // JavaScript to fetch program data and set correct link
document.addEventListener("DOMContentLoaded", function () {
  const programContainer = document.getElementById("program-items");

  // Fetch program data from API
  fetch("https://rumahamal.usk.ac.id/api/wp-json/wp/v2/program")
    .then(response => response.json())
    .then(data => {
      // Render programs
      data.forEach(post => {
        let filterClass = '';
        const categories = post.categories;

        // Mapping categories to filter classes
        if (categories.includes(61)) filterClass = 'filter-pendidikan';
        else if (categories.includes(64)) filterClass = 'filter-pemberdayaan';
        else if (categories.includes(65)) filterClass = 'filter-sosial';
        else if (categories.includes(62)) filterClass = 'filter-syiar';
        else if (categories.includes(63)) filterClass = 'filter-kemitraan';
        else if (categories.includes(66)) filterClass = 'filter-fasilitator';

        // Extract image URL from the content
        const parser = new DOMParser();
        const contentHtml = post.content.rendered;
        const doc = parser.parseFromString(contentHtml, "text/html");
        const imgElement = doc.querySelector("img");
        const imageUrl = imgElement ? imgElement.src : "/assets/img/default.jpeg";

        // Get slug or ID to form link to internal program detail page
        const postSlug = post.slug || "";  // Use slug to form URL
        const postLink = `/program/${postSlug}`;  // Construct internal link
        
        const postTitle = post.title.rendered || "Untitled";

        // Create HTML structure for the program post
        const programItem = `
          <div class="col-lg-2-4 col-md-6 program-item isotope-item ${filterClass}">
            <div class="program-content h-100">
              <a href="${postLink}">
                <img src="${imageUrl}" class="img-fluid" alt="${postTitle}" loading="lazy">
              </a>
            </div>
          </div>
        `;

        // Append the program item to the container
        programContainer.innerHTML += programItem;
      });
    })
    .catch(error => {
      console.error('Error fetching program data:', error);
      programContainer.innerHTML = "<p>Failed to load programs.</p>";
    });
});

</script>
