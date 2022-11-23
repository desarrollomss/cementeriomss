<!-- Modal -->
<div class="modal fade eliminar" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('tumbas.delete')}}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <h5>¿Seguro de Eliminar el Registro?</h5>
                    <h6 class="nombre"></h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit"class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
