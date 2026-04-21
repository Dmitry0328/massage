<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title>Massage Studio | Онлайн запис</title>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
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
    }

    .hero {
      padding: 56px 0 28px;
    }

    .hero-grid {
      display: grid;
      grid-template-columns: 1.1fr 0.9fr;
      gap: 36px;
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

    .hero-card {
      padding: 52px;
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

    .hero-points {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
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

    .point span {
      color: var(--muted);
      font-size: 14px;
    }

    .hero-image {
      position: relative;
      min-height: 100%;
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
      background: rgba(255,255,255,0.95);
      border: 1px solid var(--line);
      padding: 18px 20px;
      border-radius: 18px;
      max-width: 260px;
      box-shadow: var(--shadow);
    }

    .floating-box strong {
      display: block;
      margin-bottom: 6px;
      font-size: 17px;
    }

    .floating-box p {
      margin: 0;
      color: var(--muted);
      font-size: 14px;
    }

    .services-grid,
    .reviews-grid,
    .benefits-grid,
    .contact-grid,
    .gallery-grid {
      display: grid;
      gap: 22px;
    }

    .services-grid {
      grid-template-columns: repeat(3, 1fr);
      margin-top: 34px;
    }

    .card {
      padding: 28px;
    }

    .service-icon {
      width: 54px;
      height: 54px;
      display: grid;
      place-items: center;
      border-radius: 16px;
      background: #f4e7df;
      font-size: 24px;
      margin-bottom: 18px;
    }

    .card h3,
    .price-card h3,
    .review-card h3,
    .info-card h3,
    .form-card h3 {
      margin: 0 0 10px;
      font-size: 24px;
    }

    .card p,
    .price-card p,
    .review-card p,
    .info-card p {
      margin: 0;
      color: var(--muted);
    }

    .prices-wrap {
      display: grid;
      grid-template-columns: 0.95fr 1.05fr;
      gap: 24px;
      margin-top: 34px;
    }

    .price-card {
      padding: 30px;
    }

    .price-list {
      margin-top: 18px;
      display: grid;
      gap: 14px;
    }

    .price-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
      padding: 15px 0;
      border-bottom: 1px solid var(--line);
    }

    .price-item:last-child {
      border-bottom: none;
      padding-bottom: 0;
    }

    .price-name {
      font-weight: 700;
    }

    .price-sub {
      color: var(--muted);
      font-size: 14px;
      margin-top: 4px;
    }

    .price-value {
      font-size: 22px;
      font-weight: 800;
      white-space: nowrap;
    }

    .price-side {
      display: grid;
      justify-items: end;
      gap: 10px;
    }

    .price-book-btn {
      padding: 10px 18px;
      font-size: 14px;
      line-height: 1;
    }

    .benefits-grid {
      grid-template-columns: repeat(4, 1fr);
      margin-top: 34px;
    }

    .info-card {
      padding: 24px;
    }

    .gallery-grid {
      grid-template-columns: repeat(3, 1fr);
      margin-top: 34px;
    }

    .gallery-grid img {
      width: 100%;
      height: 290px;
      object-fit: cover;
    }

    .reviews-grid {
      grid-template-columns: repeat(3, 1fr);
      margin-top: 34px;
    }

    .review-card {
      padding: 26px;
    }

    .stars {
      font-size: 18px;
      letter-spacing: 2px;
      margin-bottom: 14px;
      color: var(--accent);
    }

    .review-author {
      margin-top: 18px;
      font-weight: 700;
    }

    .about-wrap {
      display: grid;
      grid-template-columns: 0.9fr 1.1fr;
      gap: 28px;
      align-items: center;
      margin-top: 34px;
    }

    .about-image img {
      width: 100%;
      height: 100%;
      min-height: 500px;
      object-fit: cover;
    }

    .about-box {
      padding: 34px;
    }

    .about-list {
      margin: 22px 0 0;
      padding: 0;
      list-style: none;
      display: grid;
      gap: 14px;
    }

    .about-list li {
      padding-left: 28px;
      position: relative;
      color: var(--muted);
    }

    .about-list li::before {
      content: "•";
      position: absolute;
      left: 8px;
      top: 0;
      color: var(--accent);
      font-size: 24px;
      line-height: 1;
    }

    .contact-grid {
      grid-template-columns: 0.9fr 1.1fr;
      margin-top: 34px;
      align-items: start;
    }

    .form-card,
    .info-card.large {
      padding: 32px;
    }

    form {
      display: grid;
      gap: 14px;
      margin-top: 18px;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    input,
    select,
    textarea {
      width: 100%;
      border: 1px solid var(--line);
      background: #fff;
      border-radius: 16px;
      padding: 15px 16px;
      font-size: 15px;
      color: var(--text);
      outline: none;
    }

    textarea {
      min-height: 130px;
      resize: vertical;
    }

    input:focus,
    select:focus,
    textarea:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(182, 132, 107, 0.12);
    }

    .contact-list {
      display: grid;
      gap: 16px;
      margin-top: 20px;
    }

    .contact-item {
      padding: 18px;
      border: 1px solid var(--line);
      border-radius: 18px;
      background: #fcf8f5;
    }

    .contact-item strong {
      display: block;
      margin-bottom: 6px;
    }

    .map-box {
      margin-top: 18px;
      border-radius: 20px;
      overflow: hidden;
      border: 1px solid var(--line);
    }

    .map-box iframe {
      width: 100%;
      height: 260px;
      border: 0;
    }

    .notice,
    .error-list {
      border-radius: 16px;
      padding: 14px 16px;
      margin-bottom: 14px;
    }

    .notice {
      background: #eef8f1;
      color: #1e6b37;
      border: 1px solid #cce8d4;
    }

    .error-list {
      background: #fff1ef;
      color: #9a3a2b;
      border: 1px solid #f0c9c1;
    }

    .error-list ul {
      margin: 0;
      padding-left: 18px;
    }

    .slot-hint {
      font-size: 13px;
      color: var(--muted);
      margin-top: -2px;
    }

    .visually-hidden {
      position: absolute;
      width: 1px;
      height: 1px;
      padding: 0;
      margin: -1px;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      white-space: nowrap;
      border: 0;
    }

    [hidden] {
      display: none !important;
    }

    .booking-flow {
      display: grid;
      gap: 18px;
    }

    .booking-block {
      padding: 18px;
      border: 1px solid var(--line);
      border-radius: 20px;
      background: #fcf8f5;
    }

    .booking-block h4 {
      margin: 0 0 12px;
      font-size: 18px;
    }

    .booking-block-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 12px;
      margin-bottom: 12px;
    }

    .services-picker,
    .masters-picker,
    .time-grid {
      display: grid;
      gap: 12px;
    }

    .services-picker {
      grid-template-columns: 1fr;
    }

    .masters-picker {
      grid-template-columns: repeat(2, 1fr);
    }

    .service-option,
    .master-option,
    .day-chip,
    .time-chip,
    .period-chip,
    .calendar-nav {
      border: 1px solid var(--line);
      background: #fff;
      color: var(--text);
      border-radius: 18px;
      cursor: pointer;
      transition: 0.2s ease;
    }

    .service-option,
    .master-option {
      width: 100%;
      text-align: left;
      padding: 18px;
    }

    .service-option.active,
    .master-option.active,
    .day-chip.active,
    .time-chip.active,
    .period-chip.active {
      background: #2f8dad;
      color: #fff;
      border-color: #2f8dad;
      box-shadow: 0 10px 24px rgba(47, 141, 173, 0.18);
    }

    .service-option strong,
    .master-option strong {
      display: block;
      font-size: 17px;
      margin-bottom: 6px;
    }

    .service-meta,
    .master-meta {
      display: flex;
      justify-content: space-between;
      gap: 12px;
      align-items: center;
      font-size: 14px;
      color: var(--muted);
    }

    .service-option.active .service-meta,
    .service-option.active p,
    .master-option.active .master-meta {
      color: rgba(255, 255, 255, 0.88);
    }

    .service-option p {
      margin: 10px 0 0;
      font-size: 14px;
    }

    .additional-service-box {
      margin-top: 14px;
      display: grid;
      gap: 10px;
    }

    .additional-service-box label {
      font-size: 14px;
      font-weight: 700;
    }

    .add-service-trigger {
      padding: 10px 18px;
      font-size: 14px;
      line-height: 1;
    }

    .selected-services-list,
    .additional-services-picker {
      display: grid;
      gap: 12px;
    }

    .services-section-label {
      font-size: 13px;
      font-weight: 700;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      color: var(--muted);
      margin-top: 4px;
    }

    .selected-service-card {
      display: grid;
      gap: 8px;
      padding: 16px 18px;
      border-radius: 18px;
      background: #fffaf6;
      border: 1px solid #dfc8bb;
      box-shadow: inset 0 0 0 1px rgba(182, 132, 107, 0.08);
    }

    .selected-service-head {
      display: flex;
      justify-content: space-between;
      gap: 12px;
      align-items: flex-start;
    }

    .selected-service-head strong {
      display: block;
      margin-bottom: 6px;
    }

    .selected-service-meta {
      color: var(--muted);
      font-size: 14px;
    }

    .remove-service-btn {
      border: none;
      background: transparent;
      color: var(--muted);
      font-size: 24px;
      line-height: 1;
      cursor: pointer;
      padding: 0;
    }

    .additional-picker-list {
      display: grid;
      gap: 10px;
    }

    .service-badge {
      display: inline-flex;
      padding: 6px 10px;
      border-radius: 999px;
      background: #e7f7fb;
      color: #2f8dad;
      font-size: 12px;
      font-weight: 700;
    }

    .service-option.active .service-badge {
      background: rgba(255, 255, 255, 0.18);
      color: #fff;
    }

    .calendar-nav {
      width: 46px;
      height: 46px;
      display: grid;
      place-items: center;
      font-size: 22px;
      padding: 0;
    }

    .calendar-nav:disabled {
      opacity: 0.45;
      cursor: not-allowed;
    }

    .month-picker {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      margin-bottom: 14px;
    }

    .month-picker-title {
      font-weight: 700;
      font-size: 16px;
    }

    .date-slider {
      display: grid;
      grid-template-columns: 46px 1fr 46px;
      gap: 12px;
      align-items: center;
      margin-top: 14px;
    }

    .days-grid {
      display: grid;
      grid-template-columns: repeat(7, minmax(0, 1fr));
      gap: 10px;
    }

    .day-chip {
      padding: 14px 8px;
      text-align: center;
    }

    .day-chip.is-disabled {
      opacity: 0.45;
      cursor: not-allowed;
      background: #f6f2ee;
    }

    .day-chip span {
      display: block;
    }

    .day-chip .day-name {
      font-size: 13px;
      color: var(--muted);
      margin-bottom: 6px;
    }

    .day-chip.active .day-name,
    .day-chip.active .day-date {
      color: #fff;
    }

    .day-chip .day-date {
      font-size: 24px;
      font-weight: 800;
      line-height: 1;
    }

    .day-chip .day-month {
      margin-top: 6px;
      font-size: 12px;
      color: var(--muted);
    }

    .time-grid {
      grid-template-columns: repeat(4, minmax(0, 1fr));
      margin-top: 16px;
    }

    .time-chip {
      padding: 14px 10px;
      text-align: center;
      font-weight: 700;
    }

    .time-grid.is-disabled {
      pointer-events: none;
    }

    .empty-state {
      padding: 16px;
      border: 1px dashed var(--line);
      border-radius: 18px;
      color: var(--text);
      text-align: center;
      background: #fffaf6;
      font-weight: 600;
    }

    .time-chip.is-consumed {
      background: #f3ebe5;
      border-color: #dfc8bb;
      color: #8b6f61;
      cursor: not-allowed;
    }

    .booking-summary {
      display: grid;
      gap: 14px;
      padding: 22px;
      border-radius: 22px;
      background: #f5f3f0;
      border: 1px solid var(--line);
    }

    .booking-summary-head,
    .booking-total {
      display: flex;
      justify-content: space-between;
      gap: 12px;
      align-items: baseline;
    }

    .booking-summary small,
    .booking-summary p {
      margin: 0;
      color: var(--muted);
    }

    .booking-summary strong {
      font-size: 20px;
    }

    .booking-summary-line {
      display: grid;
      gap: 4px;
      padding-top: 14px;
      border-top: 1px solid var(--line);
    }

    .contact-fields {
      display: grid;
      gap: 14px;
    }

    footer {
      padding: 28px 0 50px;
      color: var(--muted);
      font-size: 14px;
    }

    .footer-box {
      display: flex;
      justify-content: space-between;
      gap: 20px;
      align-items: center;
      padding-top: 26px;
      border-top: 1px solid var(--line);
    }

    @media (max-width: 1080px) {
      .hero-grid,
      .prices-wrap,
      .about-wrap,
      .contact-grid {
        grid-template-columns: 1fr;
      }

      .services-grid,
      .reviews-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .benefits-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .hero-card {
        padding: 36px;
      }

      .hero-image img,
      .about-image img {
        min-height: 420px;
      }
    }

    @media (max-width: 760px) {
      .topbar {
        position: static;
      }

      .nav {
        flex-direction: column;
        align-items: stretch;
        gap: 14px;
        padding: 14px 0;
      }

      .logo {
        text-align: center;
        font-size: 24px;
      }

      .nav-links {
        width: 100%;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px 14px;
        font-size: 14px;
      }

      .nav-links a {
        padding: 8px 10px;
        border-radius: 999px;
        background: rgba(255,255,255,0.72);
        border: 1px solid var(--line);
      }

      .nav > .btn {
        width: 100%;
      }

      .hero {
        padding: 24px 0 10px;
      }

      .hero-card,
      .price-card,
      .card,
      .review-card,
      .info-card,
      .form-card,
      .info-card.large,
      .about-box {
        padding: 22px;
        border-radius: 20px;
      }

      .hero-points,
      .services-grid,
      .reviews-grid,
      .benefits-grid,
      .gallery-grid,
      .form-row {
        grid-template-columns: 1fr;
      }

      .days-grid,
      .time-grid,
      .masters-picker {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }

      .hero-title {
        font-size: 34px;
      }

      .hero-text,
      .section-text,
      .card p,
      .price-card p,
      .review-card p,
      .info-card p {
        font-size: 15px;
      }

      .hero-actions {
        flex-direction: column;
      }

      .hero-actions .btn,
      .form-card .btn {
        width: 100%;
      }

      .hero-image {
        padding: 14px;
        border-radius: 22px;
      }

      .hero-image img,
      .about-image img {
        min-height: 280px;
        border-radius: 16px;
      }

      .section {
        padding: 52px 0;
      }

      .section-title {
        font-size: 30px;
      }

      .floating-box {
        position: static;
        margin-top: 14px;
        max-width: none;
      }

      .price-item {
        align-items: flex-start;
        flex-direction: column;
        gap: 8px;
      }

      .price-side {
        width: 100%;
        justify-items: stretch;
      }

      .price-book-btn {
        width: 100%;
      }

      .price-value {
        font-size: 20px;
      }

      .gallery-grid img {
        height: 220px;
      }

      input,
      select,
      textarea {
        font-size: 16px;
        padding: 14px 15px;
      }

      .contact-item {
        padding: 16px;
      }

      .map-box iframe {
        height: 220px;
      }

      .footer-box {
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
            Допомагаю зняти напругу, втому та дискомфорт у тілі. Зручний запис онлайн,
            зрозумілі ціни та затишна атмосфера для нових і постійних клієнтів.
          </p>

          <div class="hero-actions">
            <a class="btn btn-primary" href="#booking">Онлайн запис</a>
            <a class="btn btn-secondary" href="#prices">Переглянути ціни</a>
          </div>

          <div class="hero-points">
            <div class="point">
              <strong>60 хв</strong>
              <span>популярна тривалість сеансу</span>
            </div>
            <div class="point">
              <strong>100+</strong>
              <span>задоволених клієнтів</span>
            </div>
            <div class="point">
              <strong>Запис 24/7</strong>
              <span>залишай заявку у будь-який час</span>
            </div>
          </div>
        </div>

        <div class="hero-image">
          <img src="https://images.unsplash.com/photo-1519823551278-64ac92734fb1?auto=format&fit=crop&w=1200&q=80" alt="Масажний кабінет" />
          <div class="floating-box">
            <strong>Перший візит без зайвого стресу</strong>
            <p>Обери послугу, зручний час і залиш заявку за 1 хвилину.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="section" id="services">
      <div class="container">
        <h2 class="section-title">Послуги</h2>
        <p class="section-text">
          Можеш залишити базові послуги або замінити цей блок під себе: класичний, апаратний, антицелюлітний,
          релакс-масаж, масаж спини, шиї та інші процедури.
        </p>

        <div class="services-grid">
          <article class="card">
            <div class="service-icon">🌿</div>
            <h3>Класичний масаж</h3>
            <p>Для зняття напруги, покращення самопочуття та загального розслаблення тіла.</p>
          </article>

          <article class="card">
            <div class="service-icon">💆</div>
            <h3>Масаж спини та шиї</h3>
            <p>Підійде тим, хто має сидячу роботу, втому в спині або відчуття скутості.</p>
          </article>

          <article class="card">
            <div class="service-icon">✨</div>
            <h3>Апаратний масаж</h3>
            <p>Спрямований на тонус, корекцію зон та покращення зовнішнього вигляду шкіри.</p>
          </article>
        </div>
      </div>
    </section>

    <section class="section" id="prices">
      <div class="container">
        <h2 class="section-title">Ціни</h2>
        <p class="section-text">
          Цей блок легко редагується. Просто заміни назви процедур, опис і вартість на свої актуальні.
        </p>

        <div class="prices-wrap">
          <div class="price-card">
            <h3>Прайс</h3>
            <p>Прозора вартість без прихованих доплат.</p>

            <div class="price-list">
              <div class="price-item">
                <div>
                  <div class="price-name">Класичний масаж</div>
                  <div class="price-sub">60 хвилин</div>
                </div>
                <div class="price-side">
                  <div class="price-value">500 грн</div>
                  <a class="btn btn-primary price-book-btn" href="#booking" data-service-target="classic">Записатися</a>
                </div>
              </div>

              <div class="price-item">
                <div>
                  <div class="price-name">Класичний масаж + УЗД</div>
                  <div class="price-sub">60 хвилин</div>
                </div>
                <div class="price-side">
                  <div class="price-value">600 грн</div>
                  <a class="btn btn-primary price-book-btn" href="#booking" data-service-target="classic_usd">Записатися</a>
                </div>
              </div>

              <div class="price-item">
                <div>
                  <div class="price-name">Апаратний масаж</div>
                  <div class="price-sub">60 хвилин</div>
                </div>
                <div class="price-side">
                  <div class="price-value">600 грн</div>
                  <a class="btn btn-primary price-book-btn" href="#booking" data-service-target="hardware">Записатися</a>
                </div>
              </div>

              <div class="price-item">
                <div>
                  <div class="price-name">Апаратний масаж + УЗД</div>
                  <div class="price-sub">60 хвилин</div>
                </div>
                <div class="price-side">
                  <div class="price-value">800 грн</div>
                  <a class="btn btn-primary price-book-btn" href="#booking" data-service-target="hardware_usd">Записатися</a>
                </div>
              </div>
            </div>
          </div>

          <div class="price-card">
            <h3>Чому зручно записуватись через сайт</h3>
            <p>
              Нові клієнти одразу бачать послуги, ціни, фото та можуть швидко залишити заявку.
              Постійним клієнтам не треба довго писати в повідомлення — достатньо обрати день та час.
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
                <p>Ідеально для Instagram, Facebook та Google-реклами.</p>
              </div>
              <div class="info-card">
                <h3>Довіра</h3>
                <p>Фото, відгуки та опис підвищують впевненість клієнта.</p>
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
          Тут можна показати свій кабінет, масажне крісло, робоче місце або фото процедур.
        </p>

        <div class="gallery-grid">
          <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=1200&q=80" alt="Інтер'єр кабінету" />
          <img src="https://images.unsplash.com/photo-1507652313519-d4e9174996dd?auto=format&fit=crop&w=1200&q=80" alt="Масажна процедура" />
          <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=1200&q=80" alt="Розслабляюча атмосфера" />
        </div>
      </div>
    </section>

    <section class="section" id="reviews">
      <div class="container">
        <h2 class="section-title">Відгуки клієнтів</h2>
        <p class="section-text">
          Сюди можна вставити свої реальні відгуки або скріни переписок, якщо є дозвіл клієнтів.
        </p>

        <div class="reviews-grid">
          <article class="review-card">
            <div class="stars">★★★★★</div>
            <p>Дуже сподобалась атмосфера і сам підхід. Після сеансу спина стала набагато легшою.</p>
            <div class="review-author">— Олена</div>
          </article>

          <article class="review-card">
            <div class="stars">★★★★★</div>
            <p>Все акуратно, комфортно і без поспіху. Зручно, що можна одразу записатись через сайт.</p>
            <div class="review-author">— Марина</div>
          </article>

          <article class="review-card">
            <div class="stars">★★★★★</div>
            <p>Приємний сервіс, зрозумілі ціни та хороший результат вже після перших процедур.</p>
            <div class="review-author">— Ірина</div>
          </article>
        </div>
      </div>
    </section>

    <section class="section" id="about">
      <div class="container">
        <h2 class="section-title">Про мене</h2>
        <p class="section-text">
          У цьому блоці ти можеш коротко розповісти про себе: досвід, підхід до клієнтів, локацію та переваги.
        </p>

        <div class="about-wrap">
          <div class="about-image">
            <img src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=1200&q=80" alt="Майстер масажу" />
          </div>

          <div class="hero-card about-box">
            <h3>Турбота, комфорт і індивідуальний підхід</h3>
            <p class="section-text" style="max-width:none; margin-top: 14px;">
              Я працюю для того, щоб клієнт відчував не лише фізичне полегшення, а й спокій, довіру та комфорт.
              Приділяю увагу деталям, пояснюю процедури та допомагаю підібрати оптимальний варіант саме під ваш запит.
            </p>

            <ul class="about-list">
              <li>Затишний кабінет і комфортна атмосфера.</li>
              <li>Зручна локація та запис без довгого очікування.</li>
              <li>Індивідуальний підхід до нових і постійних клієнтів.</li>
              <li>Можливість вести клієнтів із реклами прямо на сайт.</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <section class="section" id="contact">
      <div class="container">
        <h2 class="section-title">Контакти та онлайн запис</h2>
        <p class="section-text">
          Нижче форма заявки. Вона може поки що відправляти дані в Telegram, email або просто працювати як макет.
        </p>

        <div class="contact-grid">
          <div class="info-card large">
            <h3>Інформація</h3>
            <p>Замінюй контакти, адресу, Instagram, години роботи та карту на свої дані.</p>

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
                <span>Пн–Сб: 10:00 – 19:00</span>
              </div>
            </div>

            <div class="map-box">
              <iframe src="https://www.google.com/maps?q=Kyiv&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>

          <div class="form-card" id="booking">
            <h3>Записатися на прийом</h3>
            <p>Оберіть послугу, майстра, день і час у форматі, схожому на Booksy. Після цього залиште контакти для підтвердження.</p>

            @if (session('booking_success'))
              <div class="notice">{{ session('booking_success') }}</div>
            @endif

            @if ($errors->any())
              <div class="error-list">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form id="bookingForm" method="POST" action="{{ route('booking.store') }}">
              @csrf

              <input type="hidden" name="service" id="service_input" value="{{ old('service') }}">
              <input type="hidden" name="master_id" id="master_id" value="{{ old('master_id') }}">
              <input type="hidden" name="appointment_date" id="appointment_date" value="{{ old('appointment_date') }}">
              <input type="hidden" name="appointment_time" id="appointment_time" value="{{ old('appointment_time') }}">

              <div class="booking-flow">
                <div class="booking-block">
                  <h4>1. Оберіть послугу</h4>
                  <div class="services-picker" id="services-picker">
                    @foreach ($services as $service)
                      <button
                        type="button"
                        class="service-option {{ old('service') === $service['key'] ? 'active' : '' }}"
                        data-service-key="{{ $service['key'] }}"
                        data-service-label="{{ $service['label'] }}"
                        data-service-price="{{ $service['price'] }}"
                        data-service-duration="{{ $service['duration'] }}"
                      >
                        <strong>{{ $service['label'] }}</strong>
                        <div class="service-meta">
                          <span>{{ number_format($service['price'], 0, ',', ' ') }} грн</span>
                          <span>{{ $service['duration'] }}</span>
                          <span class="service-badge">{{ $service['badge'] }}</span>
                        </div>
                        <p>{{ $service['description'] }}</p>
                      </button>
                    @endforeach
                  </div>

                </div>

                <div class="booking-block">
                  <h4>2. Оберіть майстра</h4>
                  <div class="masters-picker" id="masters-picker">
                    @foreach ($masters as $master)
                      <button
                        type="button"
                        class="master-option {{ (string) old('master_id') === (string) $master->id ? 'active' : '' }}"
                        data-master-id="{{ $master->id }}"
                        data-master-name="{{ $master->name }}"
                        {{ $masters->isEmpty() ? 'disabled' : '' }}
                      >
                        <strong>{{ $master->name }}</strong>
                        <div class="master-meta">
                          <span>{{ $master->phone ?: 'Онлайн запис' }}</span>
                        </div>
                      </button>
                    @endforeach
                  </div>
                </div>

                <div class="booking-block">
                  <div class="booking-block-header">
                    <h4 style="margin: 0;">3. Оберіть дату та час</h4>
                    <small id="calendar-range-label"></small>
                  </div>

                  <div class="month-picker">
                    <button type="button" class="calendar-nav" id="month-prev" aria-label="Попередній місяць">‹</button>
                    <div class="month-picker-title" id="month-label"></div>
                    <button type="button" class="calendar-nav" id="month-next" aria-label="Наступний місяць">›</button>
                  </div>

                  <div class="date-slider">
                    <button type="button" class="calendar-nav" id="days-prev" aria-label="Попередні дні">‹</button>
                    <div class="days-grid" id="days-grid"></div>
                    <button type="button" class="calendar-nav" id="days-next" aria-label="Наступні дні">›</button>
                  </div>

                  <div class="slot-hint" id="slot-hint" style="margin-top: 14px;">Оберіть майстра вище, щоб побачити доступний час.</div>

                  <div class="time-grid is-disabled" id="time-grid"></div>
                </div>

                <div class="booking-block" id="additional-services-block">
                  <div class="booking-block-header">
                    <h4 style="margin: 0;">4. Додаткові послуги</h4>
                    <button type="button" class="btn btn-secondary add-service-trigger" id="add-service-trigger">+ Додати ще послугу</button>
                  </div>

                  <div class="slot-hint" id="additional-services-hint">Після вибору часу ви зможете додати ще одну або кілька послуг до запису.</div>
                  <div id="additional-services-inputs"></div>
                  <div class="services-section-label" id="selected-services-label" hidden>Вибрано</div>
                  <div class="selected-services-list" id="selected-services-list"></div>
                  <div class="services-section-label" id="available-services-label" hidden>Доступно для додавання</div>
                  <div class="additional-services-picker" id="additional-services-picker" hidden>
                    <div class="additional-picker-list" id="additional-picker-list"></div>
                  </div>
                </div>

                <div class="booking-summary" id="booking-summary">
                  <div class="booking-summary-head">
                    <div>
                      <strong id="summary-service">Послугу ще не обрано</strong>
                      <p id="summary-master">Оберіть майстра</p>
                    </div>
                    <div style="text-align: right;">
                      <small>Разом</small>
                      <strong id="summary-price">0 грн</strong>
                    </div>
                  </div>

                  <div class="booking-summary-line">
                    <small>Дата і час</small>
                    <p id="summary-datetime">Оберіть дату та вільний слот</p>
                  </div>

                  <div class="booking-summary-line">
                    <small>Додатково</small>
                    <p id="summary-additional">Без додаткової послуги</p>
                  </div>

                  <div class="booking-total">
                    <small id="summary-duration">Тривалість буде показана після вибору послуги</small>
                    <small>Онлайн бронювання</small>
                  </div>
                </div>

                <div class="booking-block">
                  <h4>5. Контактні дані</h4>
                  <div class="contact-fields">
                    <div class="form-row">
                      <input type="text" name="client_name" placeholder="Ваше ім’я" value="{{ old('client_name') }}" required />
                      <input type="tel" name="phone" placeholder="Номер телефону" value="{{ old('phone') }}" required />
                    </div>

                    <div class="form-row">
                      <input type="text" name="social_contact" placeholder="Instagram або Telegram (необов’язково)" value="{{ old('social_contact') }}" />
                      <input type="text" value="Пн-Сб: 10:00 - 19:00" disabled />
                    </div>

                    <textarea name="message" placeholder="Коментар до запису">{{ old('message') }}</textarea>
                    <button class="btn btn-primary" type="submit" {{ $masters->isEmpty() ? 'disabled' : '' }}>Підтвердити запис</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <div class="container footer-box">
      <div>© 2026 MassageStudio. Всі права захищені.</div>
      <div>Шаблон можна редагувати під твій бренд, кольори та послуги.</div>
    </div>
  </footer>

  <script type="application/json" id="legacy-booking-script-disabled">
    const services = @json($services);
    const masters = @json($mastersForUi);
    const bookingConfig = @json($bookingConfig);
    const calendarUrl = @json(route('booking.calendar'));
    const availabilityUrl = @json(route('booking.availability'));
    const oldValues = {
      service: @json(old('service')),
      additional_service: @json(old('additional_service')),
      master_id: @json(old('master_id')),
      appointment_date: @json(old('appointment_date')),
      appointment_time: @json(old('appointment_time')),
    };

    const serviceInput = document.getElementById('service_input');
    const additionalServiceSelect = document.getElementById('additional_service');
    const masterInput = document.getElementById('master_id');
    const dateInput = document.getElementById('appointment_date');
    const timeInput = document.getElementById('appointment_time');
    const slotHint = document.getElementById('slot-hint');
    const serviceCards = document.querySelectorAll('.service-option');
    const masterCards = document.querySelectorAll('.master-option');
    const dayGrid = document.getElementById('days-grid');
    const daysPrev = document.getElementById('days-prev');
    const daysNext = document.getElementById('days-next');
    const monthPrev = document.getElementById('month-prev');
    const monthNext = document.getElementById('month-next');
    const monthLabel = document.getElementById('month-label');
    const timeGrid = document.getElementById('time-grid');
    const rangeLabel = document.getElementById('calendar-range-label');
    const summaryService = document.getElementById('summary-service');
    const summaryAdditional = document.getElementById('summary-additional');
    const summaryMaster = document.getElementById('summary-master');
    const summaryPrice = document.getElementById('summary-price');
    const summaryDatetime = document.getElementById('summary-datetime');
    const summaryDuration = document.getElementById('summary-duration');

    const servicesByKey = Object.fromEntries(services.map((service) => [service.key, service]));

    const makeDate = (value) => new Date(`${value}T00:00:00`);
    const formatMonthKey = (date) => `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
    const minDate = makeDate(bookingConfig.minDate);
    const maxDate = makeDate(bookingConfig.maxDate);
    const monthKeys = [];
    const cursor = new Date(minDate.getFullYear(), minDate.getMonth(), 1);
    const lastMonth = new Date(maxDate.getFullYear(), maxDate.getMonth(), 1);

    while (cursor <= lastMonth) {
      monthKeys.push(formatMonthKey(cursor));
      cursor.setMonth(cursor.getMonth() + 1);
    }

    const initialDate = oldValues.appointment_date || bookingConfig.minDate;
    const initialMonthKey = monthKeys.includes(formatMonthKey(makeDate(initialDate)))
      ? formatMonthKey(makeDate(initialDate))
      : monthKeys[0];

    const state = {
      service: oldValues.service || '',
      additionalService: oldValues.additional_service || '',
      masterId: oldValues.master_id ? String(oldValues.master_id) : '',
      date: initialDate,
      time: oldValues.appointment_time || '',
      monthKey: initialMonthKey,
      dayPage: 0,
      availableSlots: [],
      availableDays: {},
    };

    const pageSizeDays = 7;

    const formatPrice = (value) => `${new Intl.NumberFormat('uk-UA').format(value)} грн`;

    const formatSelectedDate = (isoDate) => {
      if (!isoDate) {
        return 'Оберіть дату та вільний слот';
      }

      const date = new Date(`${isoDate}T00:00:00`);
      return new Intl.DateTimeFormat('uk-UA', { day: 'numeric', month: 'long', weekday: 'long' }).format(date);
    };

    const getCurrentMonthDate = () => makeDate(`${state.monthKey}-01`);

    const getMonthDays = (monthKey) => {
      const baseDate = makeDate(`${monthKey}-01`);
      const month = baseDate.getMonth();
      const items = [];
      const current = new Date(baseDate);

      while (current.getMonth() === month) {
        items.push({
          iso: current.toISOString().slice(0, 10),
          dayName: new Intl.DateTimeFormat('uk-UA', { weekday: 'short' }).format(current),
          dayNumber: new Intl.DateTimeFormat('uk-UA', { day: 'numeric' }).format(current),
          monthName: new Intl.DateTimeFormat('uk-UA', { month: 'short' }).format(current),
        });
        current.setDate(current.getDate() + 1);
      }

      return items;
    };

    const updateAdditionalServiceOptions = () => {
      Array.from(additionalServiceSelect.options).forEach((option) => {
        if (!option.value) {
          return;
        }

        option.disabled = option.value === state.service;
      });

      if (state.additionalService === state.service) {
        state.additionalService = '';
        additionalServiceSelect.value = '';
      }
    };

    const updateSummary = () => {
      const selectedService = servicesByKey[state.service];
      const selectedAdditionalService = servicesByKey[state.additionalService];
      const selectedMaster = masters.find((master) => master.id === state.masterId);
      const totalPrice = (selectedService?.price || 0) + (selectedAdditionalService?.price || 0);

      summaryService.textContent = selectedService ? selectedService.label : 'Послугу ще не обрано';
      summaryMaster.textContent = selectedMaster ? `Майстер: ${selectedMaster.name}` : 'Оберіть майстра';
      summaryAdditional.textContent = selectedAdditionalService ? selectedAdditionalService.label : 'Без додаткової послуги';
      summaryPrice.textContent = formatPrice(totalPrice);
      summaryDuration.textContent = selectedService ? `Тривалість: ${selectedService.duration}` : 'Тривалість буде показана після вибору послуги';
      summaryDatetime.textContent = state.date && state.time
        ? `${formatSelectedDate(state.date)}, ${state.time}`
        : 'Оберіть дату та вільний слот';
    };

    const setActiveCard = (collection, predicate) => {
      collection.forEach((element) => {
        element.classList.toggle('active', predicate(element));
      });
    };

    const renderDays = () => {
      const allDays = getMonthDays(state.monthKey);
      const start = state.dayPage * pageSizeDays;
      const visibleDays = allDays.slice(start, start + pageSizeDays);
      const monthDate = getCurrentMonthDate();

      dayGrid.innerHTML = '';
      monthLabel.textContent = new Intl.DateTimeFormat('uk-UA', { month: 'long', year: 'numeric' }).format(monthDate);
      rangeLabel.textContent = `Доступно до ${bookingConfig.maxDate}`;

      visibleDays.forEach((day) => {
        const dayMeta = state.availableDays[day.iso];
        const dayDate = makeDate(day.iso);
        const outsideWindow = dayDate < minDate || dayDate > maxDate;
        const isDisabled = outsideWindow || (state.masterId && (!dayMeta || !dayMeta.available));
        const button = document.createElement('button');
        button.type = 'button';
        button.className = `day-chip${day.iso === state.date ? ' active' : ''}${isDisabled ? ' is-disabled' : ''}`;
        button.disabled = isDisabled;
        button.innerHTML = `
          <span class="day-name">${day.dayName}</span>
          <span class="day-date">${day.dayNumber}</span>
          <span class="day-month">${day.monthName}</span>
        `;
        button.addEventListener('click', () => {
          if (isDisabled) {
            return;
          }

          state.date = day.iso;
          dateInput.value = day.iso;
          state.time = '';
          timeInput.value = '';
          renderDays();
          updateSummary();
          loadAvailability();
        });
        dayGrid.appendChild(button);
      });

      daysPrev.disabled = state.dayPage === 0;
      daysNext.disabled = start + pageSizeDays >= allDays.length;
      monthPrev.disabled = monthKeys.indexOf(state.monthKey) === 0;
      monthNext.disabled = monthKeys.indexOf(state.monthKey) === monthKeys.length - 1;
    };

    const renderTimes = () => {
      timeGrid.innerHTML = '';
      const consumedSlots = getConsumedSlots();

      if (!state.masterId) {
        timeGrid.classList.add('is-disabled');
        timeGrid.innerHTML = '<div class="empty-state" style="grid-column: 1 / -1;">Оберіть майстра вище, щоб відкрити доступний час.</div>';
        slotHint.textContent = 'Оберіть майстра вище, щоб побачити доступний час.';
        return;
      }

      if (!state.date) {
        timeGrid.classList.add('is-disabled');
        timeGrid.innerHTML = '<div class="empty-state" style="grid-column: 1 / -1;">Оберіть день у календарі.</div>';
        slotHint.textContent = 'Після вибору майстра оберіть доступний день.';
        return;
      }

      if (!state.availableSlots.length) {
        timeGrid.classList.add('is-disabled');
        timeGrid.innerHTML = '<div class="empty-state" style="grid-column: 1 / -1;">На цю дату вільного часу немає.</div>';
        slotHint.textContent = 'На обрану дату немає вільних слотів.';
        return;
      }

      timeGrid.classList.remove('is-disabled');
      slotHint.textContent = 'Показані всі вільні слоти для обраного майстра на цей день.';

      state.availableSlots.forEach((slot) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = `time-chip${slot === state.time ? ' active' : ''}`;
        button.textContent = slot;
        button.addEventListener('click', () => {
          state.time = slot;
          timeInput.value = slot;
          renderTimes();
          updateSummary();
        });
        timeGrid.appendChild(button);
      });
    };

    const ensureValidSelectedDate = () => {
      const monthDays = getMonthDays(state.monthKey).map((day) => day.iso);

      if (!monthDays.includes(state.date)) {
        state.date = '';
        dateInput.value = '';
      }

      if (state.masterId) {
        const currentDay = state.availableDays[state.date];

        if (!currentDay || !currentDay.available) {
          const firstAvailableDay = monthDays.find((date) => state.availableDays[date]?.available);
          state.date = firstAvailableDay || '';
          dateInput.value = state.date;
        }
      }

      if (state.date) {
        const selectedDayIndex = monthDays.findIndex((date) => date === state.date);
        state.dayPage = selectedDayIndex >= 0 ? Math.floor(selectedDayIndex / pageSizeDays) : 0;
      } else {
        state.dayPage = 0;
      }
    };

    const loadMonthAvailability = async () => {
      state.availableDays = {};

      if (!state.masterId) {
        renderDays();
        renderTimes();
        updateSummary();
        return;
      }

      rangeLabel.textContent = 'Завантаження днів...';

      const params = new URLSearchParams({
        master_id: state.masterId,
        month: state.monthKey,
      });
      appendServiceSelection(params);
      appendServiceSelection(params);

      try {
        const response = await fetch(`${calendarUrl}?${params.toString()}`, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
          },
        });

        if (!response.ok) {
          throw new Error('Availability request failed');
        }

        const payload = await response.json();
        state.availableDays = Object.fromEntries((payload.days ?? []).map((day) => [day.date, day]));
        ensureValidSelectedDate();
        renderDays();
        await loadAvailability();
      } catch (error) {
        state.availableDays = {};
        renderDays();
        state.availableSlots = [];
        state.time = '';
        timeInput.value = '';
        renderTimes();
        slotHint.textContent = 'Не вдалося завантажити календар доступності. Оновіть сторінку або спробуйте ще раз.';
      }
    };

    const loadAvailability = async () => {
      if (!state.masterId || !state.date) {
        state.availableSlots = [];
        state.time = '';
        timeInput.value = '';
        renderTimes();
        updateSummary();
        return;
      }

      slotHint.textContent = 'Завантаження вільного часу...';

      const params = new URLSearchParams({
        master_id: state.masterId,
        date: state.date,
      });
      appendServiceSelection(params);

      if (state.time) {
        params.set('time', state.time);
      }
      appendServiceSelection(params);

      if (state.time) {
        params.set('time', state.time);
      }

      try {
        const response = await fetch(`${availabilityUrl}?${params.toString()}`, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
          },
        });

        if (!response.ok) {
          throw new Error('Availability request failed');
        }

        const payload = await response.json();
        state.availableSlots = payload.slots ?? [];

        if (!state.availableSlots.includes(state.time)) {
          state.time = '';
          timeInput.value = '';
        }

        renderTimes();
        updateSummary();
      } catch (error) {
        state.availableSlots = [];
        state.time = '';
        timeInput.value = '';
        renderTimes();
        slotHint.textContent = 'Сталася помилка під час завантаження слотів. Оновіть сторінку або спробуйте ще раз.';
      }
    };

    serviceCards.forEach((card) => {
      card.addEventListener('click', () => {
        state.service = card.dataset.serviceKey || '';
        serviceInput.value = state.service;
        updateAdditionalServiceOptions();
        setActiveCard(serviceCards, (element) => element.dataset.serviceKey === state.service);
        updateSummary();
      });
    });

    additionalServiceSelect.addEventListener('change', () => {
      state.additionalService = additionalServiceSelect.value || '';
      updateSummary();
    });

    masterCards.forEach((card) => {
      card.addEventListener('click', () => {
        state.masterId = card.dataset.masterId || '';
        masterInput.value = state.masterId;
        state.time = '';
        timeInput.value = '';
        setActiveCard(masterCards, (element) => element.dataset.masterId === state.masterId);
        updateSummary();
        loadMonthAvailability();
      });
    });

    document.querySelectorAll('[data-service-target]').forEach((button) => {
      button.addEventListener('click', () => {
        const service = button.getAttribute('data-service-target');

        if (service) {
          state.service = service;
          serviceInput.value = service;
          updateAdditionalServiceOptions();
          setActiveCard(serviceCards, (element) => element.dataset.serviceKey === service);
          updateSummary();
        }
      });
    });

    monthPrev.addEventListener('click', () => {
      const currentIndex = monthKeys.indexOf(state.monthKey);

      if (currentIndex > 0) {
        state.monthKey = monthKeys[currentIndex - 1];
        state.dayPage = 0;
        state.time = '';
        timeInput.value = '';
        loadMonthAvailability();
      }
    });

    monthNext.addEventListener('click', () => {
      const currentIndex = monthKeys.indexOf(state.monthKey);

      if (currentIndex < monthKeys.length - 1) {
        state.monthKey = monthKeys[currentIndex + 1];
        state.dayPage = 0;
        state.time = '';
        timeInput.value = '';
        loadMonthAvailability();
      }
    });

    daysPrev.addEventListener('click', () => {
      if (state.dayPage > 0) {
        state.dayPage -= 1;
        renderDays();
      }
    });

    daysNext.addEventListener('click', () => {
      const totalDays = getMonthDays(state.monthKey).length;

      if ((state.dayPage + 1) * pageSizeDays < totalDays) {
        state.dayPage += 1;
        renderDays();
      }
    });

    if (state.service) {
      serviceInput.value = state.service;
      setActiveCard(serviceCards, (element) => element.dataset.serviceKey === state.service);
    }

    state.additionalService = state.additionalService || '';
    additionalServiceSelect.value = state.additionalService;
    updateAdditionalServiceOptions();

    if (state.masterId) {
      masterInput.value = state.masterId;
      setActiveCard(masterCards, (element) => element.dataset.masterId === state.masterId);
    }

    if (state.date) {
      const initialMonthDays = getMonthDays(state.monthKey).map((day) => day.iso);
      const selectedDayIndex = initialMonthDays.findIndex((date) => date === state.date);
      state.dayPage = selectedDayIndex >= 0 ? Math.floor(selectedDayIndex / pageSizeDays) : 0;
    }

    dateInput.value = state.date || '';
    timeInput.value = state.time || '';
    renderDays();
    updateSummary();
    loadMonthAvailability();
  </script>

  <script>
    const services = @json($services);
    const masters = @json($mastersForUi);
    const bookingConfig = @json($bookingConfig);
    const calendarUrl = @json(route('booking.calendar'));
    const availabilityUrl = @json(route('booking.availability'));
    const oldValues = {
      service: @json(old('service')),
      additional_services: @json(old('additional_services', [])),
      master_id: @json(old('master_id')),
      appointment_date: @json(old('appointment_date')),
      appointment_time: @json(old('appointment_time')),
    };

    const serviceInput = document.getElementById('service_input');
    const masterInput = document.getElementById('master_id');
    const dateInput = document.getElementById('appointment_date');
    const timeInput = document.getElementById('appointment_time');
    const slotHint = document.getElementById('slot-hint');
    const serviceCards = document.querySelectorAll('.service-option');
    const masterCards = document.querySelectorAll('.master-option');
    const dayGrid = document.getElementById('days-grid');
    const daysPrev = document.getElementById('days-prev');
    const daysNext = document.getElementById('days-next');
    const monthPrev = document.getElementById('month-prev');
    const monthNext = document.getElementById('month-next');
    const monthLabel = document.getElementById('month-label');
    const timeGrid = document.getElementById('time-grid');
    const rangeLabel = document.getElementById('calendar-range-label');
    const summaryService = document.getElementById('summary-service');
    const summaryAdditional = document.getElementById('summary-additional');
    const summaryMaster = document.getElementById('summary-master');
    const summaryPrice = document.getElementById('summary-price');
    const summaryDatetime = document.getElementById('summary-datetime');
    const summaryDuration = document.getElementById('summary-duration');
    const addServiceTrigger = document.getElementById('add-service-trigger');
    const additionalServicesHint = document.getElementById('additional-services-hint');
    const additionalServicesInputs = document.getElementById('additional-services-inputs');
    const selectedServicesLabel = document.getElementById('selected-services-label');
    const selectedServicesList = document.getElementById('selected-services-list');
    const availableServicesLabel = document.getElementById('available-services-label');
    const additionalServicesPicker = document.getElementById('additional-services-picker');
    const additionalPickerList = document.getElementById('additional-picker-list');

    const servicesByKey = Object.fromEntries(services.map((service) => [service.key, service]));
    const mastersById = Object.fromEntries(masters.map((master) => [String(master.id), master]));

    const makeDate = (value) => new Date(`${value}T00:00:00`);
    const formatMonthKey = (date) => `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
    const minDate = makeDate(bookingConfig.minDate);
    const maxDate = makeDate(bookingConfig.maxDate);
    const monthKeys = [];
    const monthCursor = new Date(minDate.getFullYear(), minDate.getMonth(), 1);
    const lastMonth = new Date(maxDate.getFullYear(), maxDate.getMonth(), 1);

    while (monthCursor <= lastMonth) {
      monthKeys.push(formatMonthKey(monthCursor));
      monthCursor.setMonth(monthCursor.getMonth() + 1);
    }

    const normalizeAdditionalServices = (values, primaryService) => {
      if (!Array.isArray(values)) {
        return [];
      }

      return [...new Set(
        values.filter((value) => typeof value === 'string' && value && servicesByKey[value] && value !== primaryService)
      )];
    };

    const initialDate = oldValues.appointment_date || bookingConfig.minDate;
    const initialMonthKey = monthKeys.includes(formatMonthKey(makeDate(initialDate)))
      ? formatMonthKey(makeDate(initialDate))
      : monthKeys[0];

    const state = {
      service: oldValues.service || '',
      additionalServices: normalizeAdditionalServices(oldValues.additional_services, oldValues.service || ''),
      masterId: oldValues.master_id ? String(oldValues.master_id) : '',
      date: initialDate,
      time: oldValues.appointment_time || '',
      monthKey: initialMonthKey,
      dayPage: 0,
      availableSlots: [],
      availableAdditionalServiceKeys: [],
      availableDays: {},
      isAdditionalPickerOpen: false,
    };

    const pageSizeDays = 7;

    const formatPrice = (value) => `${new Intl.NumberFormat('uk-UA').format(value)} грн`;

    const formatSelectedDate = (isoDate) => {
      if (!isoDate) {
        return 'Оберіть дату та вільний слот';
      }

      return new Intl.DateTimeFormat('uk-UA', { day: 'numeric', month: 'long', weekday: 'long' }).format(makeDate(isoDate));
    };

    const getDurationMinutes = (service) => {
      const numericValue = Number.parseInt(String(service?.duration || '').replace(/[^\d]/g, ''), 10);
      return Number.isFinite(numericValue) ? numericValue : 0;
    };

    const formatTotalDuration = (minutes) => {
      if (!minutes) {
        return 'Тривалість буде показана після вибору послуги';
      }

      if (minutes % 60 === 0) {
        return `Тривалість: ${minutes / 60} год`;
      }

      return `Тривалість: ${minutes} хв`;
    };

    const getCurrentMonthDate = () => makeDate(`${state.monthKey}-01`);

    const getMonthDays = (monthKey) => {
      const baseDate = makeDate(`${monthKey}-01`);
      const month = baseDate.getMonth();
      const items = [];
      const current = new Date(baseDate);

      while (current.getMonth() === month) {
        items.push({
          iso: current.toISOString().slice(0, 10),
          dayName: new Intl.DateTimeFormat('uk-UA', { weekday: 'short' }).format(current),
          dayNumber: new Intl.DateTimeFormat('uk-UA', { day: 'numeric' }).format(current),
          monthName: new Intl.DateTimeFormat('uk-UA', { month: 'short' }).format(current),
        });
        current.setDate(current.getDate() + 1);
      }

      return items;
    };

    const setActiveCard = (collection, predicate) => {
      collection.forEach((element) => {
        element.classList.toggle('active', predicate(element));
      });
    };

    const syncAdditionalServiceInputs = () => {
      additionalServicesInputs.innerHTML = '';

      state.additionalServices.forEach((serviceKey) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'additional_services[]';
        input.value = serviceKey;
        additionalServicesInputs.appendChild(input);
      });
    };

    const getAvailableAdditionalServices = () => {
      const allowedKeys = state.time
        ? (state.availableAdditionalServiceKeys.length
          ? state.availableAdditionalServiceKeys
          : services
            .map((service) => service.key)
            .filter((serviceKey) => serviceKey !== state.service && !state.additionalServices.includes(serviceKey)))
        : services
          .map((service) => service.key)
          .filter((serviceKey) => serviceKey !== state.service && !state.additionalServices.includes(serviceKey));

      return services.filter((service) => allowedKeys.includes(service.key));
    };

    const getRemainingAdditionalServices = () => services.filter((service) => (
      service.key !== state.service && !state.additionalServices.includes(service.key)
    ));

    const resetAdditionalServices = () => {
      state.additionalServices = [];
      state.availableAdditionalServiceKeys = [];
      state.isAdditionalPickerOpen = false;
      syncAdditionalServiceInputs();
    };

    const appendServiceSelection = (params) => {
      if (state.service) {
        params.set('service', state.service);
      }

      state.additionalServices.forEach((serviceKey) => {
        params.append('additional_services[]', serviceKey);
      });
    };

    const updateSummary = () => {
      const selectedService = servicesByKey[state.service];
      const selectedAdditionalServices = state.additionalServices.map((serviceKey) => servicesByKey[serviceKey]).filter(Boolean);
      const selectedMaster = mastersById[state.masterId];
      const totalPrice = (selectedService?.price || 0) + selectedAdditionalServices.reduce((sum, service) => sum + (service.price || 0), 0);
      const totalDuration = (selectedService ? getDurationMinutes(selectedService) : 0)
        + selectedAdditionalServices.reduce((sum, service) => sum + getDurationMinutes(service), 0);

      summaryService.textContent = selectedService ? selectedService.label : 'Послугу ще не обрано';
      summaryMaster.textContent = selectedMaster ? `Майстер: ${selectedMaster.name}` : 'Оберіть майстра';
      summaryAdditional.textContent = selectedAdditionalServices.length
        ? selectedAdditionalServices.map((service) => service.label).join(', ')
        : 'Без додаткових послуг';
      summaryPrice.textContent = formatPrice(totalPrice);
      summaryDuration.textContent = formatTotalDuration(totalDuration);
      summaryDatetime.textContent = state.date && state.time
        ? `${formatSelectedDate(state.date)}, ${state.time}`
        : 'Оберіть дату та вільний слот';
    };

    const getSelectedTotalDuration = () => {
      const selectedService = servicesByKey[state.service];
      const selectedAdditionalServices = state.additionalServices
        .map((serviceKey) => servicesByKey[serviceKey])
        .filter(Boolean);

      return (selectedService ? getDurationMinutes(selectedService) : 0)
        + selectedAdditionalServices.reduce((sum, service) => sum + getDurationMinutes(service), 0);
    };

    const getSlotStepMinutes = () => {
      const slots = bookingConfig.slots || [];

      if (slots.length > 1) {
        const first = new Date(`2000-01-01T${slots[0]}:00`);
        const second = new Date(`2000-01-01T${slots[1]}:00`);

        return Math.max((second - first) / 60000, 1);
      }

      return 60;
    };

    const getConsumedSlots = () => {
      if (!state.time) {
        return [];
      }

      const totalDuration = getSelectedTotalDuration();
      const stepMinutes = getSlotStepMinutes();

      if (totalDuration <= stepMinutes) {
        return [];
      }

      const consumed = [];
      const start = new Date(`2000-01-01T${state.time}:00`);

      for (let offset = stepMinutes; offset < totalDuration; offset += stepMinutes) {
        const current = new Date(start.getTime() + offset * 60000);
        consumed.push(current.toLocaleTimeString('uk-UA', {
          hour: '2-digit',
          minute: '2-digit',
          hour12: false,
        }));
      }

      return consumed;
    };

    const renderAdditionalServices = () => {
      const canAddServices = Boolean(state.service && state.time);
      const availableAdditionalServices = getAvailableAdditionalServices();
      const remainingAdditionalServices = getRemainingAdditionalServices();

      addServiceTrigger.disabled = !canAddServices || availableAdditionalServices.length === 0;
      addServiceTrigger.textContent = state.isAdditionalPickerOpen && canAddServices
        ? 'Закрити список послуг'
        : '+ Додати ще послугу';
      additionalServicesPicker.hidden = false;
      additionalServicesPicker.style.display = state.isAdditionalPickerOpen && canAddServices ? 'grid' : 'none';
      selectedServicesList.innerHTML = '';
      additionalPickerList.innerHTML = '';
      selectedServicesList.hidden = state.additionalServices.length === 0;
      selectedServicesLabel.hidden = state.additionalServices.length === 0;
      availableServicesLabel.hidden = !(state.isAdditionalPickerOpen && canAddServices && availableAdditionalServices.length);

      if (!state.time) {
        additionalServicesHint.textContent = 'Спочатку оберіть основну послугу, майстра, день і час, а потім зможете додати ще послуги.';
      } else if (!availableAdditionalServices.length && !state.additionalServices.length) {
        additionalServicesHint.textContent = 'Інших послуг для додавання зараз немає.';
      } else if (!availableAdditionalServices.length) {
        additionalServicesHint.textContent = 'Усі доступні додаткові послуги вже додані до запису.';
      } else if (state.additionalServices.length) {
        additionalServicesHint.textContent = 'Можна додати ще одну послугу або прибрати зайву зі списку нижче.';
      } else {
        additionalServicesHint.textContent = 'Після вибору часу ви можете додати одну або кілька додаткових послуг до запису.';
      }

      if (state.time && !availableAdditionalServices.length && remainingAdditionalServices.length) {
        additionalServicesHint.textContent = 'На вибраний час уже не вистачає безперервного вікна для ще однієї послуги. Можна записати її окремо на інший час.';
      }

      state.additionalServices
        .map((serviceKey) => servicesByKey[serviceKey])
        .filter(Boolean)
        .forEach((service) => {
          const card = document.createElement('div');
          card.className = 'selected-service-card';
          card.innerHTML = `
            <div class="selected-service-head">
              <strong>${service.label}</strong>
              <button type="button" class="remove-service-btn" data-remove-service="${service.key}" aria-label="Видалити послугу">×</button>
            </div>
            <div class="selected-service-meta">
              <span>${formatPrice(service.price || 0)}</span>
              <span>${service.duration || ''}</span>
            </div>
          `;
          selectedServicesList.appendChild(card);
        });

      selectedServicesList.querySelectorAll('[data-remove-service]').forEach((button) => {
        button.addEventListener('click', () => {
          state.additionalServices = state.additionalServices.filter((serviceKey) => serviceKey !== button.dataset.removeService);
          syncAdditionalServiceInputs();
          renderAdditionalServices();
          updateSummary();
          loadAvailability();
        });
      });

      if (!availableAdditionalServices.length) {
        availableServicesLabel.hidden = true;
        return;
      }

      availableAdditionalServices.forEach((service) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'service-option';
        button.innerHTML = `
          <strong>${service.label}</strong>
          <div class="service-meta">
            <span>${formatPrice(service.price || 0)}</span>
            <span>${service.duration || ''}</span>
            ${service.badge ? `<span class="service-badge">${service.badge}</span>` : ''}
          </div>
          <p>${service.description || ''}</p>
        `;
        button.addEventListener('click', () => {
          state.additionalServices = [...state.additionalServices, service.key];
          state.isAdditionalPickerOpen = false;
          syncAdditionalServiceInputs();
          renderAdditionalServices();
          updateSummary();
          loadAvailability();
        });
        additionalPickerList.appendChild(button);
      });
    };

    const renderDays = () => {
      const allDays = getMonthDays(state.monthKey);
      const start = state.dayPage * pageSizeDays;
      const visibleDays = allDays.slice(start, start + pageSizeDays);
      const monthDate = getCurrentMonthDate();

      dayGrid.innerHTML = '';
      monthLabel.textContent = new Intl.DateTimeFormat('uk-UA', { month: 'long', year: 'numeric' }).format(monthDate);
      rangeLabel.textContent = `Доступно до ${bookingConfig.maxDate}`;

      visibleDays.forEach((day) => {
        const dayMeta = state.availableDays[day.iso];
        const dayDate = makeDate(day.iso);
        const outsideWindow = dayDate < minDate || dayDate > maxDate;
        const isDisabled = outsideWindow || (state.masterId && (!dayMeta || !dayMeta.available));
        const button = document.createElement('button');
        button.type = 'button';
        button.className = `day-chip${day.iso === state.date ? ' active' : ''}${isDisabled ? ' is-disabled' : ''}`;
        button.disabled = isDisabled;
        button.innerHTML = `
          <span class="day-name">${day.dayName}</span>
          <span class="day-date">${day.dayNumber}</span>
          <span class="day-month">${day.monthName}</span>
        `;
        button.addEventListener('click', () => {
          if (isDisabled) {
            return;
          }

          state.date = day.iso;
          dateInput.value = day.iso;
          state.time = '';
          timeInput.value = '';
          resetAdditionalServices();
          renderDays();
          renderAdditionalServices();
          updateSummary();
          loadAvailability();
        });
        dayGrid.appendChild(button);
      });

      daysPrev.disabled = state.dayPage === 0;
      daysNext.disabled = start + pageSizeDays >= allDays.length;
      monthPrev.disabled = monthKeys.indexOf(state.monthKey) === 0;
      monthNext.disabled = monthKeys.indexOf(state.monthKey) === monthKeys.length - 1;
    };

    const renderTimes = () => {
      timeGrid.innerHTML = '';
      const consumedSlots = getConsumedSlots();

      if (!state.masterId) {
        timeGrid.classList.add('is-disabled');
        timeGrid.innerHTML = '<div class="empty-state" style="grid-column: 1 / -1;">Оберіть майстра вище, щоб відкрити доступний час.</div>';
        slotHint.textContent = 'Спочатку оберіть майстра.';
        renderAdditionalServices();
        return;
      }

      if (!state.date) {
        timeGrid.classList.add('is-disabled');
        timeGrid.innerHTML = '<div class="empty-state" style="grid-column: 1 / -1;">Оберіть день у календарі.</div>';
        slotHint.textContent = 'Після вибору майстра оберіть доступний день.';
        renderAdditionalServices();
        return;
      }

      if (!state.availableSlots.length) {
        timeGrid.classList.add('is-disabled');
        timeGrid.innerHTML = '<div class="empty-state" style="grid-column: 1 / -1;">На цю дату вільного часу немає.</div>';
        slotHint.textContent = 'На обрану дату немає вільних слотів.';
        renderAdditionalServices();
        return;
      }

      timeGrid.classList.remove('is-disabled');
      slotHint.textContent = 'Показані всі вільні слоти для обраного майстра на цей день.';

      state.availableSlots.forEach((slot) => {
        const isConsumed = consumedSlots.includes(slot);
        const button = document.createElement('button');
        button.type = 'button';
        button.className = `time-chip${slot === state.time ? ' active' : ''}${isConsumed ? ' is-consumed' : ''}`;
        button.textContent = slot;
        button.disabled = isConsumed;

        if (isConsumed) {
          button.title = 'Цей час уже входить у вибраний запис';
        }

        button.addEventListener('click', () => {
          if (isConsumed) {
            return;
          }

          const previousTime = state.time;
          state.time = slot;
          timeInput.value = slot;

          if (previousTime !== slot) {
            resetAdditionalServices();
          }

          renderTimes();
          renderAdditionalServices();
          updateSummary();
          loadAvailability();
        });
        timeGrid.appendChild(button);
      });

      renderAdditionalServices();
    };

    const ensureValidSelectedDate = () => {
      const monthDays = getMonthDays(state.monthKey).map((day) => day.iso);

      if (!monthDays.includes(state.date)) {
        state.date = '';
        dateInput.value = '';
      }

      if (state.masterId) {
        const currentDay = state.availableDays[state.date];

        if (!currentDay || !currentDay.available) {
          const firstAvailableDay = monthDays.find((date) => state.availableDays[date]?.available);
          state.date = firstAvailableDay || '';
          dateInput.value = state.date;
          state.time = '';
          timeInput.value = '';
          resetAdditionalServices();
        }
      }

      if (state.date) {
        const selectedDayIndex = monthDays.findIndex((date) => date === state.date);
        state.dayPage = selectedDayIndex >= 0 ? Math.floor(selectedDayIndex / pageSizeDays) : 0;
      } else {
        state.dayPage = 0;
      }
    };

    const loadMonthAvailability = async () => {
      state.availableDays = {};

      if (!state.masterId) {
        renderDays();
        renderTimes();
        updateSummary();
        return;
      }

      rangeLabel.textContent = 'Завантаження днів...';

      const params = new URLSearchParams({
        master_id: state.masterId,
        month: state.monthKey,
      });
      appendServiceSelection(params);

      try {
        const response = await fetch(`${calendarUrl}?${params.toString()}`, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
          },
        });

        if (!response.ok) {
          throw new Error('Availability request failed');
        }

        const payload = await response.json();
        state.availableDays = Object.fromEntries((payload.days ?? []).map((day) => [day.date, day]));
        ensureValidSelectedDate();
        renderDays();
        await loadAvailability();
      } catch (error) {
        state.availableDays = {};
        state.availableSlots = [];
        state.time = '';
        timeInput.value = '';
        resetAdditionalServices();
        renderDays();
        renderTimes();
        slotHint.textContent = 'Не вдалося завантажити календар доступності. Оновіть сторінку або спробуйте ще раз.';
      }
    };

    const loadAvailability = async () => {
      if (!state.masterId || !state.date) {
        state.availableSlots = [];
        state.availableAdditionalServiceKeys = [];
        state.time = '';
        timeInput.value = '';
        resetAdditionalServices();
        renderTimes();
        updateSummary();
        return;
      }

      slotHint.textContent = 'Завантаження вільного часу...';

      const params = new URLSearchParams({
        master_id: state.masterId,
        date: state.date,
      });
      appendServiceSelection(params);

      if (state.time) {
        params.set('time', state.time);
      }

      try {
        const response = await fetch(`${availabilityUrl}?${params.toString()}`, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
          },
        });

        if (!response.ok) {
          throw new Error('Availability request failed');
        }

        const payload = await response.json();
        state.availableSlots = payload.slots ?? [];
        state.availableAdditionalServiceKeys = payload.available_additional_services ?? [];

        if (!state.availableSlots.includes(state.time)) {
          state.time = '';
          timeInput.value = '';
          resetAdditionalServices();
        }

        renderTimes();
        updateSummary();
      } catch (error) {
        state.availableSlots = [];
        state.availableAdditionalServiceKeys = [];
        state.time = '';
        timeInput.value = '';
        resetAdditionalServices();
        renderTimes();
        slotHint.textContent = 'Сталася помилка під час завантаження слотів. Оновіть сторінку або спробуйте ще раз.';
      }
    };

    serviceCards.forEach((card) => {
      card.addEventListener('click', () => {
        const nextService = card.dataset.serviceKey || '';
        const serviceChanged = state.service !== nextService;
        state.service = nextService;
        serviceInput.value = state.service;
        state.additionalServices = normalizeAdditionalServices(state.additionalServices, state.service);

        if (serviceChanged) {
          syncAdditionalServiceInputs();
          renderAdditionalServices();
          loadMonthAvailability();
        }

        setActiveCard(serviceCards, (element) => element.dataset.serviceKey === state.service);
        updateSummary();
      });
    });

    masterCards.forEach((card) => {
      card.addEventListener('click', () => {
        const nextMasterId = card.dataset.masterId || '';
        const masterChanged = state.masterId !== nextMasterId;
        state.masterId = nextMasterId;
        masterInput.value = state.masterId;
        state.time = '';
        timeInput.value = '';

        if (masterChanged) {
          resetAdditionalServices();
        }

        setActiveCard(masterCards, (element) => element.dataset.masterId === state.masterId);
        renderAdditionalServices();
        updateSummary();
        loadMonthAvailability();
      });
    });

    document.querySelectorAll('[data-service-target]').forEach((button) => {
      button.addEventListener('click', () => {
        const service = button.getAttribute('data-service-target');

        if (!service) {
          return;
        }

        state.service = service;
        serviceInput.value = service;
        state.additionalServices = normalizeAdditionalServices(state.additionalServices, state.service);
        syncAdditionalServiceInputs();
        setActiveCard(serviceCards, (element) => element.dataset.serviceKey === service);
        renderAdditionalServices();
        updateSummary();
        loadMonthAvailability();
      });
    });

    addServiceTrigger.addEventListener('click', () => {
      if (addServiceTrigger.disabled) {
        return;
      }

      state.isAdditionalPickerOpen = !state.isAdditionalPickerOpen;
      addServiceTrigger.textContent = state.isAdditionalPickerOpen ? 'Закрити список послуг' : '+ Додати ще послугу';
      renderAdditionalServices();
    });

    monthPrev.addEventListener('click', () => {
      const currentIndex = monthKeys.indexOf(state.monthKey);

      if (currentIndex > 0) {
        state.monthKey = monthKeys[currentIndex - 1];
        state.dayPage = 0;
        state.time = '';
        timeInput.value = '';
        resetAdditionalServices();
        loadMonthAvailability();
      }
    });

    monthNext.addEventListener('click', () => {
      const currentIndex = monthKeys.indexOf(state.monthKey);

      if (currentIndex < monthKeys.length - 1) {
        state.monthKey = monthKeys[currentIndex + 1];
        state.dayPage = 0;
        state.time = '';
        timeInput.value = '';
        resetAdditionalServices();
        loadMonthAvailability();
      }
    });

    daysPrev.addEventListener('click', () => {
      if (state.dayPage > 0) {
        state.dayPage -= 1;
        renderDays();
      }
    });

    daysNext.addEventListener('click', () => {
      const totalDays = getMonthDays(state.monthKey).length;

      if ((state.dayPage + 1) * pageSizeDays < totalDays) {
        state.dayPage += 1;
        renderDays();
      }
    });

    if (state.service) {
      serviceInput.value = state.service;
      setActiveCard(serviceCards, (element) => element.dataset.serviceKey === state.service);
    }

    if (state.masterId) {
      masterInput.value = state.masterId;
      setActiveCard(masterCards, (element) => element.dataset.masterId === state.masterId);
    }

    if (state.date) {
      const initialMonthDays = getMonthDays(state.monthKey).map((day) => day.iso);
      const selectedDayIndex = initialMonthDays.findIndex((date) => date === state.date);
      state.dayPage = selectedDayIndex >= 0 ? Math.floor(selectedDayIndex / pageSizeDays) : 0;
    }

    syncAdditionalServiceInputs();
    dateInput.value = state.date || '';
    timeInput.value = state.time || '';
    addServiceTrigger.textContent = '+ Додати ще послугу';
    renderDays();
    renderAdditionalServices();
    updateSummary();
    loadMonthAvailability();
  </script>
</body>
</html>
