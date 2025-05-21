@extends('layouts.layout')

@section('title', 'Program Detail')

@section('content')

<main class="main">
  <!-- Page Title -->
  <div class="page-title">
    <div class="heading">
      <div class="container">
        <div class="row d-flex justify-content-center text-center">
          <div class="col-lg-8">
            <h1 id="program-title">Program Detail</h1>
          </div>
        </div>
      </div>
    </div>
    <nav class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="/">Home</a></li>
          <li><a href="/program">Program</a></li>
          <li class="current" id="breadcrumb-title">Program Detail</li>
        </ol>
      </div>
    </nav>
  </div><!-- End Page Title -->

  <!-- Program Detail Section -->
  <section id="program-detail" class="program-detail section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <!-- Program Image -->
          <img id="program-image" class="img-fluid program-image" alt="Program Image" style="display:none;">

          <!-- Program Content -->
          <div id="program-content" class="program-content mt-4">
            <p>Loading program details...</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

@endsection

<!-- JavaScript -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const programTitle = document.getElementById('program-title');
    const programBreadcrumb = document.getElementById('breadcrumb-title');
    const programImage = document.getElementById('program-image');
    const programContent = document.getElementById('program-content');

    // Get the slug from the current URL
    const urlPath = window.location.pathname;
    const slug = urlPath.split('/').pop();

    // Fetch program details based on the slug
    fetch(`https://rumahamal.usk.ac.id/api/wp-json/wp/v2/program?slug=${slug}`)
      .then(response => response.json())
      .then(data => {
        if (data.length > 0) {
          const program = data[0];

          // Update the page title and breadcrumb
          document.title = program.title.rendered + ' | Program Detail';
          programTitle.textContent = program.title.rendered;
          programBreadcrumb.textContent = program.title.rendered;

          // Extract the first image from the content
          const parser = new DOMParser();
          const contentHtml = program.content.rendered;
          const doc = parser.parseFromString(contentHtml, "text/html");

          // Get the first image and remove it from the content
          const imgElement = doc.querySelector("img");
          const imageUrl = imgElement ? imgElement.src : null;
          if (imgElement) imgElement.remove(); // Remove image from content

          // Update the program image and content if image exists
          if (imageUrl) {
            programImage.src = imageUrl;
            programImage.style.display = 'block'; // Display the image
          }
          programContent.innerHTML = doc.body.innerHTML; // Render content without the first image
        } else {
          // Handle the case where no program is found
          programTitle.textContent = 'Program Not Found';
          programBreadcrumb.textContent = 'Program Not Found';
          programContent.innerHTML = '<p>Sorry, the program you are looking for does not exist.</p>';
        }
      })
      .catch(error => {
        console.error('Error fetching program data:', error);
        programContent.innerHTML = '<p>Failed to load program details.</p>';
      });
  });
</script>
