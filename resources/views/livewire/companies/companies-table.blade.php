<div>
    <table class="table table-striped table-sm table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Sector</th>
                <th>Catn. tareas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($companies as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->sector }}</td>
                    <td>{{ $item->tasks->count() }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Acciones
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" style="cursor: pointer" wire:click="deleteCompanie({{$item->id}})">Eliminar</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @empty
                <div class="alert alert-info">¡<strong>No</strong> hay compañias!</div>
            @endforelse
        </tbody>
    </table>

    {{ $companies->links() }}
</div>
