@if ($paginator->hasPages()) <!--Aqui gestionamos la barra de navegacion para que se pueda usar en todo la aplicacion -->
    <div class="paginacion">
            <div class="botonesPaginacion">
                @if (!$paginator->onFirstPage())
                    <a class="botonIzquierda" href="{{ $paginator->previousPageUrl() }}">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                @endif

                <div class="numerosPaginacion">
                    @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $pagina => $url)
                        <a href="{{ $url }}" class="numero {{ $pagina == $paginator->currentPage() ? 'pagina-activa' : '' }}">
                        {{ $pagina }}
                        </a>
                    @endforeach
                </div>

                @if ($paginator->hasMorePages())
                    <a class="botonDerecha" href="{{ $paginator->nextPageUrl() }}">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @endif
            </div>

            <p class="contadorPaginas">
                Página {{ $paginator->currentPage() }} de {{ $paginator->lastPage() }}
            </p>
            
        </div>
@endif
