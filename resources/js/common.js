$(document).ready(function () {
    $('.company-details-link').on('click', function (e) {
        e.preventDefault();
        let companyModal = $('#companyModal');
        companyModal.find('.modal-title').html($(this).parents('ul').find('.company-name').html());
        companyModal.find('.modal-body').html($(this).parents('ul').find('.company-desc').html());
        companyModal.modal('show');
    });

    $('.like').on('click', function () {
        $.ajax({
            url: '/voting/add',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {company_id: $(this).parents('.company').attr('data-company-id')},
            dataType: 'json',
            success: function (response) {
                showMessageModal(response);
            },
            error: function (response) {
                if (401 === response.status) {
                    handleAuthForm();
                }
            }
        });
    });

    function showMessageModal(response) {
        let messageModal = $('#messageModal');

        messageModal.on('hide.bs.modal', function () {
            location.reload();
        });

        let className = response.success ? 'text-primary' : 'text-danger';
        let messageBody = response.message ? response.message : 'Ошибка системы. Обратитесь к администрации сайта';
        let message = '<p class="text-center ' + className + '">' + messageBody + '</p>';

        messageModal.find('.modal-body').html(message);

        const button = messageModal.find('.continue');
        button.html('Продолжить');

        button.on('click', function () {
            location.reload();
        });

        messageModal.modal('show');
    }

    function handleAuthForm() {
        let authModal = $('#authModal');
        authModal.modal('show');
        authModal.find('button.close').on('click', function () {
            authModal.modal('hide');
        });

        let button = authModal.find('.submit');

        button.on('click', function () {
            let number = $('#phone');
            let phone = number.val().replace(/[()+\s]/gi, '');

            if (!/^\d{10,15}$/.test(phone)) {
                authModal.find('small.text-danger').html('Пожалуйста, введите корректный номер телефона');
                return false;
            }

            number.attr('disabled', true);
            button.attr('disabled', true);

            $.ajax({
                url: '/get-auth-code',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {phone: phone},
                dataType: 'json',
                success: function (response) {
                    if (response.generated) {
                        authModal.modal('hide');
                        $('#codeModal').attr('phone', phone);

                        handleConfirmationForm();
                    }
                },
                error: function (response) {
                    console.log(response);
                }
            }).done(function () {
                authModal.find('#phone').val('');
            });
        });
    }

    function handleConfirmationForm() {
        let codeModal = $('#codeModal');

        codeModal.on('hide.bs.modal', function () {
            location.reload();
        });

        codeModal.modal('show');

        codeModal.find('.submit').on('click', function () {
            let phone = codeModal.attr('phone');
            let code = codeModal.find('#code').val().trim();

            if (!/^\d{4}$/.test(code)) {
                codeModal.find('small.text-danger').html('Пожалуйста, введите корректный код авторизации');
                return false;
            }

            $.ajax({
                url: '/authenticate',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {phone: phone, password: code},
                dataType: 'json',
                success: function (response) {
                    codeModal.find('#code').val('');
                    codeModal.modal('hide');

                    response.message = 'Вы успешно авторизованы в системе';
                    showMessageModal(response);
                },
                error: function (response) {
                    codeModal.find('#code').val('');
                    codeModal.modal('hide');

                    response.message = 'Ошибка авторизации. Попробуйте снова либо обратитесь в администрацию сайта';
                    showMessageModal(response);
                }
            });
        });
    }
});
