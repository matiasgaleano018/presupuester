@php
$accTypes = $data['accTypes'];
$accounts = $data['accounts'] ?? [];
@endphp

@extends('layouts.base')
@section('title', 'Cuentas - Presupuester')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
            <h2 class="page-title">
                Cuentas
            </h2>
            </div>

            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Agregar cuenta
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            @foreach ($accounts as $account)
            <div class="col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">{{$account['label']}}</h3>
                    <div class="card-actions">
                        @if($account['status'] == 1)
                        <a href="{{$account['id']}}" class="btn btn-danger account-pause" id="{{$account['status']}}" title="Pausar cuenta">
                        <i class="fas fa-pause"></i>
                        @else
                        <a href="{{$account['id']}}" class="btn btn-success account-pause" id="{{$account['status']}}" title="Reanudar cuenta">
                        <i class="fas fa-play"></i>
                        @endif
                        </a>
                    </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="p-4">
                            <b class="fs-1">Gs. {{$account['amount']}}</b> <br>
                            <b>Numero de cuenta: </b>{{$account['number']}} <br>
                            <b>Tipo: </b>{{$accTypes[$account['type_id']] ?? 'No definido'}} <br>
                            <b>@if($account['status'] == 1) <p class="text-success">Activo</p> @else <p class="text-danger">Inactivo</p> @endif</b>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('modals')
@include('accounts._new-account')
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.8.1"></script>

<script>
    var accSetStatusUrl = "{{ route('account-set-status', ['id' => ':id']) }}";
    new AutoNumeric('#acc-amount', { 
        currencySymbol : 'Gs. ',
        digitGroupSeparator : '.',
        decimalCharacter : ',',
        decimalPlaces : 0,
        unformatOnSubmit: true,
		modifyValueOnWheel: false,
    });

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".account-pause").forEach(button => {
            button.addEventListener("click", function(event) {
                event.preventDefault();
                var accountId = this.getAttribute("href");
                var status = this.getAttribute("id");
                if(status == 1){
                    var text = "¿Deseas pausar la cuenta?";
                }else{
                    var text = "¿Deseas activar la cuenta?";
                }
                Swal.fire({
                    title: "Atención",
                    text: text,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Confirmar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(accSetStatusUrl.replace(':id', accountId), {
                            method: "POST",
                            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": '{{ csrf_token() }}' },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(() => {
                            Swal.fire({
                                title: "Atención",
                                text: "Cuenta actualizada correctamente",
                                icon: "success",
                                confirmButtonColor: "#3085d6"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        })
                        .catch(error => {
                            Swal.fire({
                                title: "Atención",
                                text: "Error al actualizar la cuenta",
                                icon: "error",
                                confirmButtonColor: "#3085d6"
                            });
                            console.error("Error:", error);
                        });
                    }
                });
            });
        });
    });

</script>
@endsection