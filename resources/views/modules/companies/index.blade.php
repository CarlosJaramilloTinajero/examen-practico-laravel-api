@extends('layout.master')

@section('content')
    <section class="container-view-header">
        <div class="title-view">
            <p>Lista de compañias</p>
        </div>
        <div class="button-actions">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">Agregar</button>
        </div>
    </section>

    {{-- Content --}}
    @livewire('companies.companies-table')

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalLabel">Agregar una compañia</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @livewire('companies.companies-add-modal')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
