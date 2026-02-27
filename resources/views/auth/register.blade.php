@extends('theme')
@section('title', 'Регистрация')
@section('content')
    <form id="registerForm">
        @csrf
        <h1>Регистрация</h1>

        <div class="input-wrapper">
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" placeholder="Введите ваше имя">
            <div class="error" id="nameError"></div>
        </div>

        <div class="input-wrapper">
            <label for="last_name">Фамилия</label>
            <input type="text" name="last_name" id="last_name" placeholder="Введите вашу фамилию">
            <div class="error" id="lastNameError"></div>
        </div>

        <div class="input-wrapper">
            <label for="email">Электронная почта</label>
            <input type="email" name="email" id="email" placeholder="Введите ваш email">
            <div class="error" id="emailError"></div>
        </div>

        <div class="input-wrapper">
            <label for="phone">Телефон</label>
            <input type="tel" name="phone" id="phone" placeholder="+7 (___) ___-__-__">
            <div class="error" id="phoneError"></div>
        </div>

        <div class="radio-wrapper">
            <label>Пол</label>
            <div class="radio-group">
                @foreach($genders as $gender)
                    <label class="custom-radio">
                        <input type="radio" name="gender" id="gender-{{ $gender->name }}" value="{{ $gender->id }}">
                        <span class="radiomark"></span>
                        {{ $gender->name === 'male' ? 'Мужской' : 'Женский' }}
                    </label>
                @endforeach
            </div>
            <div class="error" id="genderError"></div>
        </div>

        <div class="input-wrapper">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" placeholder="Создайте пароль">
            <div class="error" id="passwordError"></div>
        </div>

        <div class="input-wrapper">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   placeholder="Повторите пароль">
            <div class="error" id="passwordConfirmationError"></div>
        </div>

        <label class="custom-checkbox">
            <input type="checkbox" name="terms" id="terms">
            <span class="checkmark"></span>
            <span class="text">Я согласен с <a href="#">условиями использования</a></span>
        </label>
        <div class="error" id="termsError"></div>

        <button type="submit" class="btn">Зарегистрироваться</button>

        <div class="error" id="formMessage"></div>
    </form>

    <script>
        document.getElementById('registerForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            const csrfToken = document.querySelector('input[name="_token"]').value;
            const name = document.getElementById('name').value.trim();
            const lastName = document.getElementById('last_name').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const gender = document.querySelector('input[name="gender"]:checked')?.value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;

            const nameError = document.getElementById('nameError');
            const lastNameError = document.getElementById('lastNameError');
            const emailError = document.getElementById('emailError');
            const phoneError = document.getElementById('phoneError');
            const genderError = document.getElementById('genderError');
            const passwordError = document.getElementById('passwordError');
            const passwordConfirmationError = document.getElementById('passwordConfirmationError');
            const termsError = document.getElementById('termsError');

            const formMessage = document.getElementById('formMessage');

            let hasError = false;

            if (!name) {
                nameError.textContent = 'Поле обязательно для заполнения';
                hasError = true;
            } else if (!/^[A-ZА-Я][a-zа-я]*$/.test(name)) {
                nameError.textContent = 'Имя должно начинаться с заглавной буквы и содержать только буквы';
                hasError = true;
            }

            if (!lastName) {
                lastNameError.textContent = 'Поле обязательно для заполнения';
                hasError = true;
            } else if (!/^[A-ZА-Я][a-zа-я]*$/.test(lastName)) {
                lastNameError.textContent = 'Фамилия должна начинаться с заглавной буквы и содержать только буквы';
                hasError = true;
            }

            if (!email) {
                emailError.textContent = 'Поле обязательно для заполнения';
                hasError = true;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                emailError.textContent = 'Некорректный адрес электронной почты';
                hasError = true;
            }

            if (!phone) {
                phoneError.textContent = 'Поле обязательно для заполнения';
                hasError = true;
            } else if (!/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/.test(phone)) {
                phoneError.textContent = 'Неверный формат телефона. Пример: +7 (999) 123-45-67';
                hasError = true;
            }

            if (!gender) {
                genderError.textContent = 'Выберите пол';
                hasError = true;
            }

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

            if (!terms) {
                termsError.textContent = 'Необходимо согласиться с условиями использования';
                hasError = true;
            }

            if (hasError) return;

            const data = {
                name: name,
                last_name: lastName,
                email: email,
                phone: phone,
                gender: gender,
                password: password,
                password_confirmation: passwordConfirmation,
                terms: terms
            };

            try {
                const response = await fetch('/register', {
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
                    formMessage.textContent = 'Успешная регистрация';
                    formMessage.style.color = 'green';
                } else {
                    if (result.errors) {
                        const errors = result.errors;

                        document.querySelectorAll('.error').forEach(el => el.textContent = '');

                        if (errors.name) {
                            nameError.textContent = errors.name[0];
                        }
                        if (errors.last_name) {
                            lastNameError.textContent = errors.last_name[0];
                        }
                        if (errors.email) {
                            emailError.textContent = errors.email[0];
                        }
                        if (errors.phone) {
                            phoneError.textContent = errors.phone[0];
                        }
                        if (errors.gender) {
                            genderError.textContent = errors.gender[0];
                        }
                        if (errors.password) {
                            passwordError.textContent = errors.password[0];
                        }
                        if (errors.terms) {
                            termsError.textContent = errors.terms[0];
                        }
                    }

                    formMessage.textContent = 'Ошибка при регистрации';
                    formMessage.style.color = '#d00000';
                }
            } catch (error) {
                formMessage.textContent = 'Не удалось отправить запрос. Проверьте соединение.';
                formMessage.style.color = '#d00000';
            }
        });
    </script>
@endsection
