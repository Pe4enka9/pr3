@extends('theme')
@section('title', 'Авторизация')
@section('content')
    <form id="loginForm">
        @csrf
        <h1>Авторизация</h1>

        <div class="input-wrapper">
            <label for="email">Электронная почта</label>
            <input type="email" name="email" id="email" placeholder="Введите ваш email">
            <div class="error" id="emailError"></div>
        </div>

        <div class="input-wrapper">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" placeholder="Введите пароль">
            <div class="error" id="passwordError"></div>
        </div>

        <label class="custom-checkbox">
            <input type="checkbox" name="remember" id="remember">
            <span class="checkmark"></span>
            Запомнить меня
        </label>

        <button type="submit" class="btn">Войти</button>

        <div class="error" id="formMessage"></div>
    </form>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            const csrfToken = document.querySelector('input[name="_token"]').value;
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const remember = document.getElementById('remember').checked;

            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');

            const formMessage = document.getElementById('formMessage');

            let hasError = false;

            if (!email) {
                emailError.textContent = 'Поле обязательно для заполнения';
                hasError = true;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                emailError.textContent = 'Некорректный адрес электронной почты';
                hasError = true;
            }

            if (!password) {
                passwordError.textContent = 'Поле обязательно для заполнения';
                hasError = true;
            }

            if (hasError) return;

            const data = {
                email: email,
                password: password,
                remember: remember,
            };

            try {
                const response = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    formMessage.textContent = 'Успешная авторизация';
                    formMessage.style.color = 'green';
                } else {
                    if (result.errors) {
                        const errors = result.errors;

                        document.querySelectorAll('.error').forEach(el => el.textContent = '');

                        if (errors.email) {
                            emailError.textContent = errors.email[0];
                        }
                        if (errors.password) {
                            passwordError.textContent = errors.password[0];
                        }
                    }

                    formMessage.textContent = 'Неверный логин или пароль.';
                    formMessage.style.color = '#d00000';
                }
            } catch (error) {
                formMessage.textContent = 'Не удалось отправить запрос. Проверьте соединение.';
                formMessage.style.color = '#d00000';
            }
        });
    </script>
@endsection
