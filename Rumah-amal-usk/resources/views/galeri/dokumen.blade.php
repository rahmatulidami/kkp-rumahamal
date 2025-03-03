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
                <div class="row">
                    @foreach ($documents as $document)
                        <div class="col-md-3 mb-4">
                            <div class="kumpulan-dokumen p-3 border rounded d-flex flex-column align-items-center text-center" data-name="{{ $document['name'] }}" data-type="{{ $document['type'] }}" style="height: 250px;">
                                <img src="{{ $document['icon'] }}" alt="{{ $document['type'] }}" class="file-icon mb-2" style="width: 60px; height: 60px;" />
                                <p class="dokumen-name mb-2 font-weight-bold">{{ $document['name'] }}</p>
                                <button class="btn btn-outline-secondary mt-auto download-button" data-url="{{ $document['download'] }}" data-name="{{ $document['name'] }}" data-bs-toggle="modal" data-bs-target="#downloadModal">
                                    <i class="bi bi-download"></i> Download
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
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
    const downloadButtons = document.querySelectorAll('.download-button');
    const modalDocName = document.getElementById('modal-doc-name');
    const confirmDownload = document.getElementById('confirmDownload');

    // ✅ Ambil nilai dari URL jika ada
    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get('search') || '';
    const filterValue = urlParams.get('filter') || 'all';

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

            // ✅ Set nama file di modal
            modalDocName.textContent = fileName;
            confirmDownload.setAttribute('href', fileUrl);
        });
    });

    // ✅ Unduh file langsung setelah klik "Ya"
    confirmDownload.addEventListener('click', function(event) {
        event.preventDefault();

        const fileUrl = confirmDownload.getAttribute('href');
        if (fileUrl) {
            const a = document.createElement('a');
            a.href = fileUrl;
            a.setAttribute('download', ''); // Menandai sebagai file yang bisa diunduh
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            // Tutup modal setelah klik "Ya"
            const modalElement = document.getElementById('downloadModal');
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    });

    // ✅ Tambahan: Menutup modal jika di luar area modal diklik
    document.addEventListener('click', function(event) {
        const modalElement = document.getElementById('downloadModal');
        if (modalElement && event.target === modalElement) {
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    });
});
</script>
