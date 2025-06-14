<header>
    <nav data-bs-theme="dark" class="navbar bg-dark navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('companies.index') }}">Inicio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                            href="{{ route('companies.index') }}">Compañias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('tasks.index') }}">Tareas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
