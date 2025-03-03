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

        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="/">Beranda</a></li>
                    <li class="current">Dokumen</li>
                </ol>
            </div>
        </nav>
    </div>

    <!-- Filter and Search Section -->
    <div class="filter-section">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <div class="input-group mb-3">
                        <select id="filter-select" class="form-select" aria-label="Filter Dokumen">
                            <option value="all">Semua</option>
                            <option value="name-asc">A-Z</option>
                            <option value="name-desc">Z-A</option>
                            <option value="date-asc">Terlama</option>
                            <option value="date-desc">Terbaru</option>
                            <option value="type-pdf">PDF</option>
                            <option value="type-doc">DOC</option>
                            <option value="type-csv">CSV</option>
                        </select>
                        <input type="text" id="search-input" class="form-control" placeholder="Cari Dokumen..." value="{{ request('search', '') }}">
                        <button class="btn btn-outline-secondary" id="search-button"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Document Section -->
    <section id="dokumen" class="dokumen section">
        <div class="container" id="dokumen-container">
        @if(count($documents) > 0)
            @foreach ($documents as $document)
                <div class="kumpulan-dokumen" data-name="{{ $document['name'] }}" data-type="{{ $document['type'] }}">
                    <div class="icon-and-details d-flex align-items-center justify-content-between">
                        <div class="details d-flex align-items-center">
                            <img src="{{ $document['icon'] }}" alt="{{ $document['type'] }}" class="file-icon" />
                            <div class="ml-3">
                                <p class="dokumen-name mb-0">{{ $document['name'] }}</p>
                            </div>
                        </div>
                        <button class="btn btn-outline-secondary download-button" data-url="{{ $document['download'] }}" data-name="{{ $document['name'] }}" data-bs-toggle="modal" data-bs-target="#downloadModal">
                            <i class="bi bi-download"></i>
                        </button>
                    </div>
                </div>
            @endforeach

            @else
                <div class="col-12 text-center">
                    <p class="alert alert-warning">Dokumen yang dicari tidak ditemukan.</p>
                </div>
            @endif 
        </div>
    </section>

    <!-- Pagination -->
    <section id="gallery-pagination" class="gallery-pagination section">
        <div class="container">
            <div class="d-flex justify-content-center">
                <ul>
                    @if($pagination['current_page'] > 1)
                        <li><a href="{{ url('dokumen?page=' . ($pagination['current_page'] - 1)) }}"><i class="bi bi-chevron-left"></i></a></li>
                    @endif

                    @for($i = 1; $i <= $pagination['total_pages']; $i++)
                        <li><a href="{{ url('dokumen?page=' . $i) }}" class="{{ $pagination['current_page'] == $i ? 'active' : '' }}">{{ $i }}</a></li>
                    @endfor

                    @if($pagination['current_page'] < $pagination['total_pages'])
                        <li><a href="{{ url('dokumen?page=' . ($pagination['current_page'] + 1)) }}"><i class="bi bi-chevron-right"></i></a></li>
                    @endif
                </ul>
            </div>
        </div>
    </section><!-- /Pagination -->

    <!-- Confirmation Modal -->
    <div id="downloadModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Unduhan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda ingin mengunduh berkas <strong id="modal-doc-name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <a id="confirmDownload" class="btn btn-primary" target="_blank">Ya</a>
                </div>
            </div>
        </div>
    </div>

</main>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    const filterSelect = document.getElementById('filter-select');

    // ✅ Ambil nilai dari URL jika ada
    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get('search') || '';
    const filterValue = urlParams.get('filter') || 'name-asc';

    searchInput.value = searchQuery;
    filterSelect.value = filterValue;

    function updateURLAndReload() {
        urlParams.set('search', searchInput.value.trim());
        urlParams.set('filter', filterSelect.value);
        urlParams.set('page', '1'); // Reset ke halaman pertama
        window.location.href = window.location.pathname + '?' + urlParams.toString();
    }

    searchButton.addEventListener('click', updateURLAndReload);
    filterSelect.addEventListener('change', updateURLAndReload);
    searchInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            updateURLAndReload();
        }
    });

    // 🔥 Event listener untuk tombol download
    downloadButtons.forEach(button => {
        button.addEventListener('click', function() {
            const fileUrl = this.getAttribute('data-url');
            const fileName = this.getAttribute('data-name');

            modalDocName.textContent = fileName;
            confirmDownload.setAttribute('href', fileUrl);
        });
    });

    // ✅ Unduh file langsung setelah klik "Ya" atau buka tab baru jika perlu
    confirmDownload.addEventListener('click', function(event) {
        event.preventDefault(); // Hindari navigasi langsung
        const fileUrl = this.getAttribute('href');

        if (fileUrl) {
            // Cek apakah URL mengarah ke Google Drive atau penyimpanan lain yang perlu dibuka di tab baru
            if (fileUrl.includes("drive.google.com") || fileUrl.includes("dropbox.com")) {
                window.open(fileUrl, '_blank'); // Buka di tab baru
            } else {
                // Jika bukan dari Drive atau Dropbox, langsung unduh file
                const a = document.createElement('a');
                a.href = fileUrl;
                a.download = fileUrl.split('/').pop(); // Ambil nama file dari URL
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }

            // Tutup modal setelah klik "Ya"
            const modalElement = document.getElementById('downloadModal');
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    });
});

</script>
