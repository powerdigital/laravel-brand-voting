<div class="modal fade" id="codeModal" tabindex="-1" role="dialog" aria-labelledby="codeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="codeModalLabel">Идентификация</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <small>Введите полученный по SMS код в это поле и нажмите "Подтвердить"</small>
                <form>
                    <div class="form-group">
                        <label for="code" class="col-form-label">Код авторизации:</label>
                        <input type="text" class="form-control" id="code" data-mask="0000" placeholder="_ _ _ _">
                        <small class="text-danger"></small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary submit">Подтвердить</button>
            </div>
        </div>
    </div>
</div>
