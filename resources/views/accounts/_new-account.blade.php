<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        {!! Form::open(['route' => 'accounts', 'method' => 'POST', 'id' => 'form-new-account']) !!}
        <div class="modal-header">
            <h5 class="modal-title">Crear cuenta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label">Tipo de cuenta</label>
                        {!! Form::select('acc_type', $accTypes, null, ['class' => 'form-select', 'id' => 'acc-type-select']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Banco</label>
                        <input type="text" name="acc_bank" class="form-control input-acc" id="bank-input">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Numero de cuenta</label>
                        <input type="text" name="acc_number" class="form-control input-acc" id="acc-number-input">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Monto inicial</label>
                        <input type="text" name="acc_amount" class="form-control text-right" id="acc-amount" value="0">
                    </div>
                </div>
                <div class="col-lg-12">
                    <label class="form-label">Descripción</label>
                    {!! Form::textarea('acc_description', null, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                Guardar
            </button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>