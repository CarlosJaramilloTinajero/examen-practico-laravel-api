<div>
    <form wire:submit.prevent="submit()">
        <div class="mb-3">
            <div class="form-floating mb-3">
                <input wire:model="formData.name" type="text" required class="form-control" id="floatingInput"
                    placeholder="Nombre">
                <label for="floatingInput">Nombre de la empresa</label>
            </div>
        </div>

        <div class="mb-5">
            <label class="form-label">Sector</label>
            <select required wire:model="formData.sector" class="form-select">
                <option value="">Seleccione una opcion</option>
                <option value="tecnologia">Tecnologia</option>
                <option value="salud">Salud</option>
                <option value="educacion">Educacion</option>
            </select>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary btn-sm">Agregar</button>
        </div>
    </form>
</div>
