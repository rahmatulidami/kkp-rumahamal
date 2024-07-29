@extends('layouts.layout')

@section('title', 'Dokumen | Rumah Amal USK')

@section('content')

<main class="main">

<!-- Page Title -->
<div class="page-title">
    <div class="heading">
        <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
                <h1>DOKUMEN</h1>
            </div>
        </div>
    </div>
</div>

<!-- Filter and Search Section -->
<div class="filter-section">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="input-group mb-3">
                    <select id="filter-select" class="form-select" aria-label="Filter Dokumen">
                        <option value="name-asc">A-Z</option>
                        <option value="name-desc">Z-A</option>
                        <option value="date-asc">Terlama</option>
                        <option value="date-desc">Terbaru</option>
                        <option value="type-pdf">PDF</option>
                        <option value="type-doc">DOC</option>
                        <option value="type-csv">CSV</option>
                    </select>
                    <input type="text" id="search-input" class="form-control" placeholder="Cari Dokumen...">
                    <button class="btn btn-outline-secondary" id="search-button"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section -->
<section id="dokumen" class="dokumen section">
    <div class="container" id="dokumen-container">
        <div class="kumpulan-dokumen" data-name="Pengumuman Beasiswa BPRA-UKT" data-date="2024-07-11" data-type="pdf">
            <div class="icon-and-details">
                <i class="bi bi-filetype-pdf"></i>
                <div class="details">
                    <p class="dokumen-name">Pengumuman Beasiswa BPRA-UKT</p>
                    <p class="date"><strong>11-Juli-2024</strong></p>
                </div>
                <button class="btn btn-outline-secondary"><i class="bi bi-download"></i></button>
            </div>
        </div>

        <div class="kumpulan-dokumen" data-name="Pengumuman Beasiswa BPRA-UKT" data-date="2024-07-11" data-type="doc">
            <div class="icon-and-details">
                <i class="bi bi-filetype-doc"></i>
                <div class="details">
                    <p class="dokumen-name">Pengumuman Beasiswa BPRA-UKT</p>
                    <p class="date"><strong>11-Juli-2024</strong></p>
                </div>
                <button class="btn btn-outline-secondary"><i class="bi bi-download"></i></button>
            </div>
        </div>

        <div class="kumpulan-dokumen" data-name="Pengumuman Beasiswa BPRA-UKT" data-date="2024-07-11" data-type="csv">
            <div class="icon-and-details">
                <i class="bi bi-filetype-csv"></i>
                <div class="details">
                    <p class="dokumen-name">Pengumuman Beasiswa BPRA-UKT</p>
                    <p class="date"><strong>11-Juli-2024</strong></p>
                </div>
                <button class="btn btn-outline-secondary"><i class="bi bi-download"></i></button>
            </div>
        </div>

        <div class="kumpulan-dokumen" data-name="Beasiswa BPRA-UKT" data-date="2024-06-11" data-type="csv">
            <div class="icon-and-details">
                <i class="bi bi-filetype-csv"></i>
                <div class="details">
                    <p class="dokumen-name">Beasiswa BPRA-UKT</p>
                    <p class="date"><strong>11-Juni-2024</strong></p>
                </div>
                <button class="btn btn-outline-secondary"><i class="bi bi-download"></i></button>
            </div>
        </div>
    </div>
</section>
<!-- End Section -->

</main>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelect = document.getElementById('filter-select');
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');
        const dokumenContainer = document.getElementById('dokumen-container');
        const dokumenItems = Array.from(dokumenContainer.getElementsByClassName('kumpulan-dokumen'));

        function filterAndSort() {
            const filterValue = filterSelect.value;
            const searchValue = searchInput.value.toLowerCase();

            let filteredItems = dokumenItems.filter(item => {
                const name = item.dataset.name.toLowerCase();
                return name.includes(searchValue);
            });

            if (filterValue.includes('name')) {
                filteredItems = filteredItems.sort((a, b) => {
                    const nameA = a.dataset.name.toLowerCase();
                    const nameB = b.dataset.name.toLowerCase();
                    return filterValue === 'name-asc' ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
                });
            } else if (filterValue.includes('date')) {
                filteredItems = filteredItems.sort((a, b) => {
                    const dateA = new Date(a.dataset.date);
                    const dateB = new Date(b.dataset.date);
                    return filterValue === 'date-asc' ? dateA - dateB : dateB - dateA;
                });
            } else if (filterValue.includes('type')) {
                filteredItems = filteredItems.filter(item => item.dataset.type === filterValue.split('-')[1]);
            }

            dokumenContainer.innerHTML = '';
            filteredItems.forEach(item => {
                dokumenContainer.appendChild(item);
            });
        }

        filterSelect.addEventListener('change', filterAndSort);
        searchInput.addEventListener('input', filterAndSort);
        searchButton.addEventListener('click', filterAndSort);
        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                filterAndSort();
            }
        });
    });
</script>
