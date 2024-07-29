@if ($paginator->hasPages())
    <section id="blog-pagination" class="blog-pagination section">
        <div class="container">
            <div class="d-flex justify-content-center">
                <ul>
                    @if ($paginator->onFirstPage())
                        <li class="disabled"><a href="#"><i class="bi bi-chevron-left"></i></a></li>
                    @else
                        <li><a href="{{ $paginator->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a></li>
                    @endif

                    @foreach ($elements[0] as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><a href="{{ $url }}" class="active">{{ $page }}</a></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <li><a href="{{ $paginator->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a></li>
                    @else
                        <li class="disabled"><a href="#"><i class="bi bi-chevron-right"></i></a></li>
                    @endif
                </ul>
            </div>
        </div>
    </section>
<style>
    /* Add this to your CSS file */
.blog-pagination ul {
  list-style: none;
  padding: 0;
  margin-top: 100px;
  display: flex;
  gap: 5px;
}

.blog-pagination ul li {
  display: inline;
}

.blog-pagination ul li a,
.blog-pagination ul li.disabled a {
  display: block;
  padding: 10px 20px;
  border-radius: 5px;
  border: 1px solid #ddd;
  border-color: #5a7df3;
  background-color: #ffffff;
  color: #5a7df3;
  text-decoration: none;
}

.blog-pagination ul li a.active,
.blog-pagination ul li a:hover {
  background-color: #5a7df3;
}

.blog-pagination ul li.disabled a {
  background-color: #ddd;
  color: #7a7777;
  border: #ffffff00
}

</style>
@endif
