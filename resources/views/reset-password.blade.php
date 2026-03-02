@extends('theme')
@section('title', 'Восстановление пароля')
@section('content')
    <form id="resetPasswordForm">
        @csrf
        <h1>Восстановление пароля</h1>

        <div class="input-wrapper">
            <label for="password">Новый пароль</label>
            <input type="password" name="password" id="password" placeholder="Придумайте новый пароль">
            <div class="error" id="passwordError"></div>
        </div>

        <div class="input-wrapper">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   placeholder="Повторите пароль">
            <div class="error" id="passwordConfirmationError"></div>
        </div>

        <button type="submit" class="btn">Изменить пароль</button>

        <div class="error" id="formMessage"></div>
    </form>

    <script>
        document.getElementById('resetPasswordForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            const csrfToken = document.querySelector('input[name="_token"]').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            const passwordError = document.getElementById('passwordError');
            const passwordConfirmationError = document.getElementById('passwordConfirmationError');

            const formMessage = document.getElementById('formMessage');

            let hasError = false;

            if (!password) {
                passwordError.textContent = 'Поле обязательно для заполнения';
                hasError = true;
            } else if (password.length < 8) {
                passwordError.textContent = 'Пароль должен содержать не менее 8 символов';
                hasError = true;
            } else if (!/(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])/.test(password)) {
                passwordError.textContent = 'Пароль должен содержать заглавную букву, цифру и спецсимвол';
                hasError = true;
            }

            if (!passwordConfirmation) {
                passwordConfirmationError.textContent = 'Поле обязательно для заполнения';
                hasError = true;
            } else if (password !== passwordConfirmation) {
                passwordConfirmationError.textContent = 'Пароли не совпадают';
                hasError = true;
            }

            if (hasError) return;

            const data = {
                password: password,
                password_confirmation: passwordConfirmation
            };

            try {
                const response = await fetch('/reset-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                console.log(result);

                if (response.ok) {
                    formMessage.textContent = 'Успешный сброс пароля';
                    formMessage.style.color = 'green';
                } else {
                    if (result.errors) {
                        const errors = result.errors;

                        document.querySelectorAll('.error').forEach(el => el.textContent = '');

                        if (errors.password) {
                            passwordError.textContent = errors.password[0];
                        }
                    }

                    formMessage.textContent = 'Ошибка при сбросе пароля';
                    formMessage.style.color = '#d00000';
                }
            } catch (error) {
                formMessage.textContent = 'Не удалось отправить запрос. Проверьте соединение.';
                formMessage.style.color = '#d00000';
            }
        });
    </script>
@endsection
