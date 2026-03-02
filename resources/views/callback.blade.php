@extends('theme')
@section('title', 'Обратный звонок')
@section('content')
    <form id="callbackForm">
        @csrf
        <h1>Обратный звонок</h1>

        <div class="input-wrapper">
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" placeholder="Как вас зовут?">
            <div class="error" id="nameError"></div>
        </div>

        <div class="input-wrapper">
            <label for="phone">Телефон</label>
            <input type="tel" name="phone" id="phone" placeholder="+7 (___) ___-__-__">
            <div class="error" id="phoneError"></div>
        </div>

        <div class="input-wrapper">
            <label for="time">Удобное время для звонка</label>
            <select name="time" id="time">
                <option value="" hidden>Выберите время</option>
                <option value="morning">Утро (9:00 - 12:00)</option>
                <option value="afternoon">День (12:00 - 18:00)</option>
                <option value="evening">Вечер (18:00 - 21:00)</option>
            </select>
            <div class="error" id="timeError"></div>
        </div>

        <button type="submit" class="btn">Заказать звонок</button>

        <div class="error" id="formMessage"></div>
    </form>

    <script>
        document.getElementById('callbackForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            const csrfToken = document.querySelector('input[name="_token"]').value;
            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const time = document.getElementById('time').value;

            const nameError = document.getElementById('nameError');
            const phoneError = document.getElementById('phoneError');
            const timeError = document.getElementById('timeError');

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

            if (!time) {
                timeError.textContent = 'Выберите удобное время';
                hasError = true;
            }

            if (hasError) return;

            const data = {
                name: name,
                phone: phone,
                time: time
            };

            try {
                const response = await fetch('/callback', {
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
                    formMessage.textContent = 'Звонок успешно заказан';
                    formMessage.style.color = 'green';
                } else {
                    if (result.errors) {
                        const errors = result.errors;

                        if (errors.name) {
                            nameError.textContent = errors.name[0];
                        }
                        if (errors.phone) {
                            phoneError.textContent = errors.phone[0];
                        }
                        if (errors.time) {
                            timeError.textContent = errors.gender[0];
                        }
                    }

                    formMessage.textContent = 'Ошибка при заказе звонка';
                    formMessage.style.color = '#d00000';
                }
            } catch (error) {
                formMessage.textContent = 'Не удалось отправить запрос. Проверьте соединение.';
                formMessage.style.color = '#d00000';
            }
        });
    </script>
@endsection
