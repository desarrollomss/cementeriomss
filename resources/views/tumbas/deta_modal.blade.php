<style>
    #imagenSeleccionada {
        max-width: 60%;
        display: inline-block;
    }

    @media (min-width: 355px) {
        #imagenSeleccionada {
            max-width: 100%;
        }
    }

    @media (min-width: 330px) {
        #imagenSeleccionada {
            max-width: 100%;
        }
    }

    @media (min-width: 760px) {
        #imagenSeleccionada {
            max-width: 50%;
        }
    }

    .caja {
        background-color: transparent;
        border: 0px;
        outline: none;
        width: 95%;
    }

    .titulos {
        color: #0DA8EE;
    }

    ul{
        list-style: none;
        color: #000;
    }
</style>
<div class="modal fade tumbadetalle" id="tumbasdeta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalle de Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-4">
                        <p class="titulos">Nombres </p>
                    </div>
                    <div class="col">
                        <input type="text" name="nombres" class="caja" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <p class="titulos">A. Paterno </p>
                    </div>
                    <div class="col">
                        <input type="text" name="paterno" class="caja" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <p class="titulos">A. Materno </p>
                    </div>
                    <div class="col">
                        <input type="text" name="materno" class="caja" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <p class="titulos">Fecha Deceso </p>
                    </div>
                    <div class="col">
                        <input type="text" name="fecha_deceso" class="caja" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <p class="titulos">Observaciones </p>
                    </div>
                    <div class="col">
                        <ul class="obslista">
                        </ul>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <p class="titulos">Adicionales </p>
                    </div>
                    <div class="col">

                        <ul class="adilista">
                        </ul>
                    </div>
                </div>
                <div class="form-row mt-4">
                    <div class="col">
                        <img id="imgdetalle" alt="Imagen" style="max-height: 230px;" class="mx-auto d-block">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cerra</button>
            </div>
        </div>
    </div>
</div>
