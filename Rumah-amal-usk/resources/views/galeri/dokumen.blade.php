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

    <!-- Document Section -->
    <section id="dokumen" class="dokumen section">
        <div class="container" id="dokumen-container">
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
    const confirmDownload = document.getElementById('confirmDownload');
    const modalDocName = document.getElementById('modal-doc-name');

    document.querySelectorAll('.download-button').forEach(button => {
        button.addEventListener('click', function() {
            const fileName = this.dataset.name;
            const fileUrl = this.dataset.url;

            console.log("Klik tombol unduh:", fileName, fileUrl); // Debugging log

            modalDocName.innerText = fileName;
            confirmDownload.setAttribute('data-url', fileUrl);
            confirmDownload.setAttribute('data-name', fileName);
        });
    });

    confirmDownload.addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah perilaku default

        const fileUrl = this.getAttribute('data-url');
        const fileName = this.getAttribute('data-name');

        console.log("Mengunduh:", fileName, fileUrl); // Debugging log

        if (!fileUrl) {
            alert("URL file tidak ditemukan!");
            return;
        }

        // Membuat elemen <a> untuk langsung mengunduh file
        const a = document.createElement('a');
        a.href = fileUrl;
        a.download = fileName || 'dokumen';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });
});

</script>



