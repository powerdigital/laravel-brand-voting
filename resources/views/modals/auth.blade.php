<div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="authModalLabel">Авторизация</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center text-primary">
                    Для голосования Вам необходимо войти в систему. Укажите, пожалуйста, номер телефона для
                    получения кода подтверждения.
                </p>
                <form>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">Телефон:</label>
                        <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required class="form-control"
                               id="phone" data-mask="+7 (000) 000 00 00" placeholder="+7 (___) ___ __ __">
                        <small class="text-danger"></small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary submit">Получить код</button>
            </div>
        </div>
    </div>
</div>
