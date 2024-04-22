<div>
    <form wire:submit.prevent="submit()">
        <div class="mb-3">
            <div class="form-floating mb-3">
                <input wire:model="formData.name" type="text" required class="form-control" id="floatingInput"
                    placeholder="Nombre">
                <label for="floatingInput">Nombre de la tarea</label>
            </div>
        </div>

        <div class="mb-3">
            <div class="form-floating mb-3">
                <input wire:model="formData.description" type="text" required class="form-control" id="floatingInput"
                    placeholder="Descripcion">
                <label for="floatingInput">Descripcion de la tarea</label>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Usuario</label>
            <select required wire:model="formData.user_id" class="form-select">
                <option value="">Seleccione una opcion</option>
                @forelse ($users as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @empty
                @endforelse
            </select>
        </div>

        <div class="mb-5">
            <label class="form-label">Compañia</label>
            <select required wire:model="formData.company_id" class="form-select">
                <option value="">Seleccione una opcion</option>
                @forelse ($companies as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @empty
                @endforelse
            </select>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary btn-sm">Agregar</button>
        </div>
    </form>
</div>
