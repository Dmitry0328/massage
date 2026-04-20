<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Масаж | Запис на прийом</title>
    <style>
        :root {
            --bg: #f8f3ef;
            --surface: #ffffff;
            --accent: #b6846b;
            --accent-dark: #946a54;
            --text: #2b2421;
            --muted: #746762;
            --line: #eaded7;
            --shadow: 0 12px 35px rgba(85, 58, 45, 0.08);
            --radius: 22px;
            --container: 1180px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            max-width: 100%;
            display: block;
            border-radius: 18px;
        }

        .container {
            width: min(100% - 32px, var(--container));
            margin: 0 auto;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 24px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            transition: 0.25s ease;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            background: var(--accent-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: transparent;
            color: var(--text);
            border: 1px solid var(--line);
        }

        .btn-secondary:hover {
            background: #fff;
        }

        .section {
            padding: 84px 0;
        }

        .section-title {
            font-size: clamp(30px, 4vw, 46px);
            line-height: 1.1;
            margin: 0 0 16px;
        }

        .section-text {
            font-size: 17px;
            color: var(--muted);
            margin: 0;
            max-width: 700px;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            backdrop-filter: blur(10px);
            background: rgba(248, 243, 239, 0.88);
            border-bottom: 1px solid rgba(234, 222, 215, 0.9);
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 16px 0;
        }

        .logo {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .logo span {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 22px;
            font-size: 15px;
            color: var(--muted);
            flex-wrap: wrap;
        }

        .hero {
            padding: 56px 0 28px;
        }

        .hero-grid,
        .prices-wrap,
        .contact-grid,
        .about-wrap {
            display: grid;
            gap: 36px;
        }

        .hero-grid {
            grid-template-columns: 1.1fr 0.9fr;
            align-items: center;
        }

        .hero-card,
        .card,
        .form-card,
        .price-card,
        .review-card,
        .info-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .hero-card,
        .price-card,
        .form-card,
        .info-card.large {
            padding: 40px;
        }

        .card,
        .review-card,
        .info-card {
            padding: 28px;
        }

        .eyebrow {
            display: inline-flex;
            padding: 8px 14px;
            border-radius: 999px;
            background: #f2e6df;
            color: var(--accent-dark);
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .hero-title {
            font-size: clamp(36px, 5vw, 62px);
            line-height: 1.02;
            margin: 0 0 18px;
        }

        .hero-text {
            font-size: 18px;
            color: var(--muted);
            margin: 0 0 28px;
            max-width: 640px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 28px;
        }

        .hero-points,
        .services-grid,
        .benefits-grid,
        .reviews-grid {
            display: grid;
            gap: 14px;
        }

        .hero-points {
            grid-template-columns: repeat(3, 1fr);
        }

        .point {
            padding: 18px;
            border-radius: 18px;
            background: #fcf8f5;
            border: 1px solid var(--line);
        }

        .point strong {
            display: block;
            font-size: 20px;
            margin-bottom: 4px;
        }

        .point span,
        .card p,
        .review-card p,
        .info-card p,
        .contact-item span,
        .about-list li,
        .floating-box p {
            color: var(--muted);
        }

        .hero-image {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            background: linear-gradient(180deg, #e9d7cf 0%, #cfae9e 100%);
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
            padding: 24px;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            min-height: 620px;
            object-fit: cover;
            border-radius: 22px;
        }

        .floating-box {
            position: absolute;
            left: 24px;
            bottom: 24px;
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid var(--line);
            padding: 18px 20px;
            border-radius: 18px;
            max-width: 260px;
            box-shadow: var(--shadow);
        }

        .floating-box strong,
        .price-card h3,
        .card h3,
        .info-card h3,
        .form-card h3 {
            display: block;
            margin: 0 0 8px;
            font-size: 22px;
        }

        .services-grid,
        .benefits-grid,
        .reviews-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            margin-top: 30px;
        }

        .service-icon {
            font-size: 30px;
            margin-bottom: 14px;
        }

        .prices-wrap {
            grid-template-columns: 1fr 0.9fr;
            margin-top: 30px;
        }

        .price-list,
        .contact-list {
            display: grid;
            gap: 16px;
        }

        .price-item,
        .contact-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 18px 0;
            border-bottom: 1px solid var(--line);
        }

        .price-item:last-child,
        .contact-item:last-child {
            border-bottom: none;
        }

        .price-name {
            font-weight: 700;
            margin-bottom: 4px;
        }

        .price-sub {
            color: var(--muted);
            font-size: 14px;
        }

        .price-value {
            font-size: 24px;
            font-weight: 800;
            white-space: nowrap;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr 0.9fr;
            gap: 18px;
            margin-top: 30px;
        }

        .gallery-grid img {
            height: 340px;
            object-fit: cover;
            width: 100%;
        }

        .about-wrap {
            grid-template-columns: 0.88fr 1.12fr;
            align-items: center;
            margin-top: 30px;
        }

        .about-image img {
            width: 100%;
            height: 100%;
            min-height: 520px;
            object-fit: cover;
            border-radius: 28px;
            box-shadow: var(--shadow);
        }

        .about-list {
            margin: 22px 0 0;
            padding-left: 18px;
        }

        .about-list li + li {
            margin-top: 10px;
        }

        .contact-grid {
            grid-template-columns: 1fr 0.95fr;
            margin-top: 30px;
            align-items: start;
        }

        .map-box {
            margin-top: 24px;
            overflow: hidden;
            border-radius: 20px;
            border: 1px solid var(--line);
        }

        .map-box iframe {
            width: 100%;
            height: 280px;
            border: 0;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 14px;
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 14px 16px;
            font-size: 16px;
            background: #fff;
            color: var(--text);
        }

        textarea {
            min-height: 140px;
            resize: vertical;
            margin-bottom: 16px;
        }

        footer {
            padding: 0 0 40px;
        }

        .footer-box {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            color: var(--muted);
            font-size: 14px;
            border-top: 1px solid var(--line);
            padding-top: 28px;
        }

        @media (max-width: 980px) {
            .hero-grid,
            .prices-wrap,
            .contact-grid,
            .about-wrap,
            .gallery-grid,
            .hero-points,
            .services-grid,
            .benefits-grid,
            .reviews-grid,
            .form-row {
                grid-template-columns: 1fr;
            }

            .hero-image img,
            .about-image img {
                min-height: 420px;
            }

            .nav {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 640px) {
            .hero-card,
            .price-card,
            .form-card,
            .info-card.large,
            .card,
            .review-card,
            .info-card {
                padding: 24px;
            }

            .section {
                padding: 64px 0;
            }

            .footer-box,
            .price-item,
            .contact-item {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container nav">
            <a class="logo" href="#home">Massage<span>Studio</span></a>

            <nav class="nav-links">
                <a href="#services">Послуги</a>
                <a href="#prices">Ціни</a>
                <a href="#reviews">Відгуки</a>
                <a href="#about">Про мене</a>
                <a href="#contact">Контакти</a>
                <a href="{{ url('/admin') }}">Адмінка</a>
            </nav>

            <a class="btn btn-primary" href="#booking">Записатися</a>
        </div>
    </header>

    <main>
        <section class="hero" id="home">
            <div class="container hero-grid">
                <div class="hero-card">
                    <div class="eyebrow">Турбота про тіло • Розслаблення • Відновлення</div>
                    <h1 class="hero-title">Масаж, після якого хочеться повернутися ще</h1>
                    <p class="hero-text">
                        М’який світлий дизайн, зрозуміла структура, акцент на довірі та комфорті. Саме та атмосфера,
                        яку ви показали у шаблоні, вже перенесена в Laravel і готова під подальше наповнення.
                    </p>

                    <div class="hero-actions">
                        <a class="btn btn-primary" href="#booking">Онлайн запис</a>
                        <a class="btn btn-secondary" href="#prices">Переглянути ціни</a>
                    </div>

                    <div class="hero-points">
                        <div class="point">
                            <strong>60 хв</strong>
                            <span>стандартна тривалість сеансу</span>
                        </div>
                        <div class="point">
                            <strong>Пн-Нд</strong>
                            <span>робота без вихідних</span>
                        </div>
                        <div class="point">
                            <strong>2 хв</strong>
                            <span>щоб залишити заявку на запис</span>
                        </div>
                    </div>
                </div>

                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=1200&q=80" alt="Кабінет масажу">

                    <div class="floating-box">
                        <strong>Спокійна атмосфера</strong>
                        <p>Світла м’яка подача, теплі акценти та комфортна подача послуг без перевантаження.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="services">
            <div class="container">
                <h2 class="section-title">Послуги</h2>
                <p class="section-text">
                    Блок послуг повторює структуру шаблону: коротко, чисто й без зайвого візуального шуму.
                </p>

                <div class="services-grid">
                    <article class="card">
                        <div class="service-icon">🌿</div>
                        <h3>Класичний масаж</h3>
                        <p>Для загального розслаблення, зняття напруги та підтримки гарного самопочуття.</p>
                    </article>

                    <article class="card">
                        <div class="service-icon">💆</div>
                        <h3>Оздоровчий масаж</h3>
                        <p>Підходить для спини, шиї, попереку та локальних зон, які потребують уваги.</p>
                    </article>

                    <article class="card">
                        <div class="service-icon">✨</div>
                        <h3>Комплексні процедури</h3>
                        <p>Комбіновані формати для клієнтів, яким потрібен більш інтенсивний результат.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section" id="prices">
            <div class="container">
                <h2 class="section-title">Ціни</h2>
                <p class="section-text">
                    Секція повністю в дусі вашої верстки: ліворуч прайс, праворуч сильний блок довіри та переваг.
                </p>

                <div class="prices-wrap">
                    <div class="price-card">
                        <h3>Актуальний прайс</h3>

                        <div class="price-list">
                            <div class="price-item">
                                <div>
                                    <div class="price-name">Класичний масаж</div>
                                    <div class="price-sub">60 хвилин</div>
                                </div>
                                <div class="price-value">500 грн</div>
                            </div>

                            <div class="price-item">
                                <div>
                                    <div class="price-name">Класичний масаж + УЗД</div>
                                    <div class="price-sub">60 хвилин</div>
                                </div>
                                <div class="price-value">600 грн</div>
                            </div>

                            <div class="price-item">
                                <div>
                                    <div class="price-name">Апаратний масаж</div>
                                    <div class="price-sub">60 хвилин</div>
                                </div>
                                <div class="price-value">600 грн</div>
                            </div>

                            <div class="price-item">
                                <div>
                                    <div class="price-name">Апаратний масаж + УЗД</div>
                                    <div class="price-sub">60 хвилин</div>
                                </div>
                                <div class="price-value">800 грн</div>
                            </div>
                        </div>
                    </div>

                    <div class="price-card">
                        <h3>Чому зручно записуватись через сайт</h3>
                        <p class="section-text" style="max-width:none;">
                            Нові клієнти одразу бачать послуги, ціни, фото та можуть швидко залишити заявку. Постійним
                            клієнтам не потрібно довго писати в повідомлення, достатньо обрати день та час.
                        </p>

                        <div class="benefits-grid">
                            <div class="info-card">
                                <h3>Швидко</h3>
                                <p>Запис за 1 хвилину з телефону або комп’ютера.</p>
                            </div>
                            <div class="info-card">
                                <h3>Зручно</h3>
                                <p>Вся інформація в одному місці: ціни, графік, контакти.</p>
                            </div>
                            <div class="info-card">
                                <h3>Для реклами</h3>
                                <p>Підходить для Instagram, Facebook та Google-реклами.</p>
                            </div>
                            <div class="info-card">
                                <h3>Довіра</h3>
                                <p>Фото, відгуки та опис формують відчуття професійного сервісу.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <h2 class="section-title">Атмосфера та кабінет</h2>
                <p class="section-text">
                    Галерея побудована так само, як у вашому шаблоні: великі світлі фото й затишна подача простору.
                </p>

                <div class="gallery-grid">
                    <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=1200&q=80" alt="Інтер'єр кабінету">
                    <img src="https://images.unsplash.com/photo-1507652313519-d4e9174996dd?auto=format&fit=crop&w=1200&q=80" alt="Масажна процедура">
                    <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=1200&q=80" alt="Розслабляюча атмосфера">
                </div>
            </div>
        </section>

        <section class="section" id="reviews">
            <div class="container">
                <h2 class="section-title">Відгуки клієнтів</h2>
                <p class="section-text">
                    Блок відгуків теж повторює шаблонну структуру: три чисті картки з короткими сильними враженнями.
                </p>

                <div class="reviews-grid">
                    <article class="review-card">
                        <div>★★★★★</div>
                        <p>Дуже сподобалась атмосфера і сам підхід. Після сеансу спина стала набагато легшою.</p>
                        <strong>— Олена</strong>
                    </article>

                    <article class="review-card">
                        <div>★★★★★</div>
                        <p>Все акуратно, комфортно і без поспіху. Зручно, що можна одразу записатися через сайт.</p>
                        <strong>— Марина</strong>
                    </article>

                    <article class="review-card">
                        <div>★★★★★</div>
                        <p>Приємний сервіс, зрозумілі ціни та хороший результат вже після перших процедур.</p>
                        <strong>— Ірина</strong>
                    </article>
                </div>
            </div>
        </section>

        <section class="section" id="about">
            <div class="container">
                <h2 class="section-title">Про мене</h2>
                <p class="section-text">
                    Цей блок залишився у тому самому стилі: фото зліва, змістовний текст та список переваг справа.
                </p>

                <div class="about-wrap">
                    <div class="about-image">
                        <img src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=1200&q=80" alt="Майстер масажу">
                    </div>

                    <div class="hero-card">
                        <h3>Турбота, комфорт і індивідуальний підхід</h3>
                        <p class="section-text" style="max-width:none; margin-top:14px;">
                            Я працюю для того, щоб клієнт відчував не лише фізичне полегшення, а й спокій, довіру та
                            комфорт. Пояснюю процедури, уважно ставлюсь до деталей і допомагаю підібрати оптимальний
                            формат саме під ваш запит.
                        </p>

                        <ul class="about-list">
                            <li>Затишний кабінет і комфортна атмосфера.</li>
                            <li>Зручна локація та запис без довгого очікування.</li>
                            <li>Індивідуальний підхід до нових і постійних клієнтів.</li>
                            <li>Гарна подача студії для реклами й рекомендацій.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="contact">
            <div class="container">
                <h2 class="section-title">Контакти та онлайн запис</h2>
                <p class="section-text">
                    Нижче блок контактів і форми заявки в тому самому макеті, який ви скинули. Його можна далі
                    прив’язати до повноцінної системи запису.
                </p>

                <div class="contact-grid">
                    <div class="info-card large">
                        <h3>Інформація</h3>
                        <p>Замініть контакти, адресу, Instagram, години роботи та карту на свої дані.</p>

                        <div class="contact-list">
                            <div class="contact-item">
                                <strong>Телефон</strong>
                                <span>+38 (0XX) XXX-XX-XX</span>
                            </div>
                            <div class="contact-item">
                                <strong>Instagram</strong>
                                <span>@yourmassagepage</span>
                            </div>
                            <div class="contact-item">
                                <strong>Адреса</strong>
                                <span>Ваше місто, вулиця, кабінет</span>
                            </div>
                            <div class="contact-item">
                                <strong>Графік</strong>
                                <span>Пн-Нд: 10:00 – 18:00</span>
                            </div>
                        </div>

                        <div class="map-box">
                            <iframe src="https://www.google.com/maps?q=Kyiv&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>

                    <div class="form-card" id="booking">
                        <h3>Записатися на прийом</h3>
                        <p>Заповни форму, і я зв’яжусь з тобою для підтвердження запису.</p>

                        <form id="bookingForm">
                            <div class="form-row">
                                <input type="text" name="name" placeholder="Ваше ім’я" required>
                                <input type="tel" name="phone" placeholder="Номер телефону" required>
                            </div>

                            <div class="form-row">
                                <select name="service" required>
                                    <option value="">Оберіть послугу</option>
                                    <option>Класичний масаж</option>
                                    <option>Класичний масаж + УЗД</option>
                                    <option>Апаратний масаж</option>
                                    <option>Апаратний масаж + УЗД</option>
                                </select>
                                <input type="date" name="date" required>
                            </div>

                            <div class="form-row">
                                <input type="time" name="time" required>
                                <input type="text" name="instagram" placeholder="Instagram або Telegram">
                            </div>

                            <textarea name="message" placeholder="Коментар до запису"></textarea>
                            <button class="btn btn-primary" type="submit">Надіслати заявку</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container footer-box">
            <div>© 2026 MassageStudio. Всі права захищені.</div>
            <div>Сайт побудований на Laravel, а адмінка працює на Filament.</div>
        </div>
    </footer>

    <script>
        const form = document.getElementById('bookingForm');

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            alert('Дякуємо! Ваша заявка на запис відправлена.');
            form.reset();
        });
    </script>
</body>
</html>
