<div>
    <div class="table-responsive">
        <table class="table table-striped table-sm table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Usuario</th>
                    <th>Compañia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->user }}</td>
                        <td>{{ $item->company ? $item->company->name : 'NAN' }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Acciones
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" style="cursor: pointer"
                                            wire:click="deleteTask({{ $item->id }})">Eliminar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <div class="alert alert-info">¡<strong>No</strong> hay tareas!</div>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $tasks->links() }}
</div>
