@extends('theme')
@section('title', 'Онлайн заказ')
@section('content')
    <form id="orderForm">
        @csrf
        <h1>Онлайн заказ</h1>

        <div class="input-wrapper">
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" placeholder="Введите ваше имя">
            <div class="error" id="nameError"></div>
        </div>

        <div class="input-wrapper">
            <label for="phone">Телефон</label>
            <input type="tel" name="phone" id="phone" placeholder="+7 (___) ___-__-__">
            <div class="error" id="phoneError"></div>
        </div>

        <div class="input-wrapper">
            <label for="email">Электронная почта</label>
            <input type="email" name="email" id="email" placeholder="Введите ваш email">
            <div class="error" id="emailError"></div>
        </div>

        <div class="input-wrapper">
            <label for="address">Адрес доставки</label>
            <input type="text" name="address" id="address" placeholder="Укажите полный адрес">
            <div class="error" id="addressError"></div>
        </div>

        <div class="input-wrapper">
            <label for="message">Комментарий к заказу</label>
            <textarea name="message" id="message" placeholder="Дополнительные пожелания"></textarea>
            <div class="error" id="messageError"></div>
        </div>

        <button type="submit" class="btn">Оформить заказ</button>

        <div class="error" id="formMessage"></div>
    </form>

    <script>
        document.getElementById('orderForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            const csrfToken = document.querySelector('input[name="_token"]').value;
            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const email = document.getElementById('email').value.trim();
            const address = document.getElementById('address').value.trim();
            const message = document.getElementById('message').value.trim();

            const nameError = document.getElementById('nameError');
            const phoneError = document.getElementById('phoneError');
            const emailError = document.getElementById('emailError');
            const addressError = document.getElementById('addressError');
            const messageError = document.getElementById('messageError');

            const formMessage = document.getElementById('formMessage');

            let hasError = false;

            if (!name) {
                nameError.textContent = 'Поле обязательно для заполнения';
                hasError = true;
            } else if (!/^[A-ZА-Я][a-zа-я]*$/.test(name)) {
                nameError.textContent = 'Имя должно начинаться с заглавной буквы и содержать только буквы';
                hasError = true;
            }

            if (!phone) {
                phoneError.textContent = 'Поле обязательно для заполнения';
                hasError = true;
            } else if (!/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/.test(phone)) {
                phoneError.textContent = 'Неверный формат телефона. Пример: +7 (999) 123-45-67';
                hasError = true;
            }

            if (!email) {
                emailError.textContent = 'Поле обязательно для заполнения';
                hasError = true;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                emailError.textContent = 'Некорректный адрес электронной почты';
                hasError = true;
            }

            if (!address) {
                addressError.textContent = 'Поле обязательно для заполнения';
                hasError = true;
            }

            if (hasError) return;

            const data = {
                name: name,
                phone: phone,
                email: email,
                address: address,
                message: message,
            };

            try {
                const response = await fetch('/online-order', {
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
                    formMessage.textContent = 'Успешный заказ';
                    formMessage.style.color = 'green';
                } else {
                    if (result.errors) {
                        const errors = result.errors;

                        document.querySelectorAll('.error').forEach(el => el.textContent = '');

                        if (errors.name) {
                            nameError.textContent = errors.name[0];
                        }
                        if (errors.phone) {
                            phoneError.textContent = errors.phone[0];
                        }
                        if (errors.email) {
                            emailError.textContent = errors.email[0];
                        }
                        if (errors.address) {
                            addressError.textContent = errors.gender[0];
                        }
                        if (errors.message) {
                            messageError.textContent = errors.password[0];
                        }
                    }

                    formMessage.textContent = 'Ошибка при заказе';
                    formMessage.style.color = '#d00000';
                }
            } catch (error) {
                formMessage.textContent = 'Не удалось отправить запрос. Проверьте соединение.';
                formMessage.style.color = '#d00000';
            }
        });
    </script>
@endsection
