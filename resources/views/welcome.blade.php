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
      min-height: 54px;
      padding: 15px 30px;
      border-radius: 6px;
      border: 1px solid rgba(148, 106, 84, 0.76);
      cursor: pointer;
      font-size: 16px;
      font-weight: 800;
      line-height: 1.2;
      letter-spacing: 0.14em;
      text-transform: none;
      background: transparent;
      color: var(--accent-dark);
      box-shadow: none;
      backdrop-filter: blur(4px);
      transition: background 0.25s ease, border-color 0.25s ease, color 0.25s ease, transform 0.25s ease;
    }

    .btn-primary {
      background: transparent;
      color: var(--accent-dark);
      border-color: rgba(148, 106, 84, 0.82);
      box-shadow: none;
    }

    .btn-primary:hover {
      background: rgba(148, 106, 84, 0.1);
      transform: translateY(-1px);
    }

    .btn-secondary {
      background: transparent;
      color: var(--accent-dark);
      border-color: rgba(148, 106, 84, 0.62);
    }

    .btn-secondary:hover {
      background: rgba(148, 106, 84, 0.1);
      transform: translateY(-1px);
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
      background: var(--text);
      border-bottom: 1px solid rgba(234, 222, 215, 0.18);
      box-shadow: 0 10px 28px rgba(43, 36, 33, 0.16);
    }

    .nav {
      display: flex;
      align-items: stretch;
      justify-content: center;
      flex-direction: column;
      gap: 14px;
      padding: 16px 0 14px;
    }

    .logo {
      color: #fff;
      text-align: center;
      font-size: 24px;
      font-weight: 800;
      letter-spacing: 0.14em;
      text-transform: uppercase;
    }

    .logo span {
      color: #fff;
    }

    .logo small {
      display: block;
      margin-top: 2px;
      color: rgba(255, 255, 255, 0.78);
      font-size: 8px;
      font-weight: 700;
      letter-spacing: 0.26em;
    }

    .nav-links {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
      gap: 14px 22px;
      color: #fff;
      font-size: 12px;
      letter-spacing: 0.28em;
      text-transform: uppercase;
    }

    .mobile-brand-row,
    .mobile-socials {
      display: flex;
    }

    .mobile-round-cta {
      display: none;
    }

    .mobile-brand-row {
      align-items: center;
      justify-content: space-between;
      gap: 14px;
      color: #fff;
    }

    .mobile-salon-name {
      max-width: 150px;
      font-size: 13px;
      font-weight: 800;
      line-height: 1.25;
      letter-spacing: 0.12em;
      text-transform: uppercase;
    }

    .mobile-location {
      display: grid;
      justify-items: end;
      gap: 3px;
      font-size: 13px;
      letter-spacing: 0.24em;
      text-transform: uppercase;
    }

    .mobile-location-head {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: 7px;
    }

    .mobile-location small {
      color: rgba(255, 255, 255, 0.72);
      font-size: 9px;
      font-weight: 700;
      letter-spacing: 0.22em;
    }

    .mobile-location svg,
    .mobile-socials svg {
      width: 22px;
      height: 22px;
      stroke: currentColor;
    }

    .mobile-socials {
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
      gap: 10px 16px;
      color: #fff;
    }

    .mobile-socials a {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      font-size: 12px;
      font-weight: 700;
      line-height: 1;
    }

    .nav > .btn {
      display: none;
    }

    .hero {
      position: relative;
      background: var(--text);
      padding: 42px 0 54px;
    }

    .hero .container {
      width: min(100% - 32px, var(--container));
      max-width: var(--container);
    }

    .hero-grid {
      display: grid;
      min-height: min(620px, calc(100vh - 132px));
      gap: 0;
      align-items: stretch;
      overflow: hidden;
      border-radius: 14px;
      border: 1px solid rgba(255, 255, 255, 0.14);
      box-shadow: 0 26px 90px rgba(0, 0, 0, 0.34);
    }

    .hero-card,
    .hero-image {
      grid-area: 1 / 1;
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
      position: relative;
      z-index: 2;
      align-self: center;
      width: min(100% - 32px, 760px);
      margin: 0 auto;
      padding: clamp(72px, 10vw, 136px) 24px;
      background: transparent;
      border: 0;
      border-radius: 0;
      box-shadow: none;
      color: #fff;
      text-align: center;
    }

    .eyebrow {
      display: none;
      padding: 8px 14px;
      border-radius: 999px;
      background: #f2e6df;
      color: var(--accent-dark);
      font-weight: 700;
      font-size: 13px;
      margin-bottom: 18px;
    }

    .hero-title {
      max-width: 760px;
      margin: 0 auto 24px;
      color: #fff;
      font-size: clamp(38px, 5.2vw, 82px);
      font-weight: 900;
      line-height: 1.12;
      letter-spacing: 0.02em;
      text-wrap: balance;
    }

    .hero-text {
      font-size: 18px;
      color: var(--muted);
      margin: 0 0 28px;
      max-width: 640px;
    }

    .hero-benefits {
      display: grid;
      width: fit-content;
      max-width: min(100%, 520px);
      gap: 10px;
      margin: 0 auto 32px;
      padding: 0;
      list-style: none;
      color: #fff;
      text-align: left;
      font-size: clamp(17px, 1.45vw, 24px);
      font-weight: 600;
      line-height: 1.45;
    }

    .hero-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 14px;
      justify-content: center;
      margin-bottom: 0;
    }

    .hero-actions .btn-primary {
      display: none;
    }

    .hero-actions .btn-secondary {
      border-color: rgba(255, 255, 255, 0.86);
      color: #fff;
      background: rgba(43, 36, 33, 0.14);
      border-radius: 5px;
      font-weight: 500;
      letter-spacing: 0.16em;
    }

    .hero-actions .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.14);
    }

    .hero-points {
      display: none;
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
      min-height: inherit;
      overflow: hidden;
      border-radius: 0;
      background: #1f1916;
      border: 0;
      box-shadow: none;
      padding: 0;
    }

    .hero-image::after {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: 0;
      pointer-events: none;
      background:
        linear-gradient(90deg, rgba(43, 36, 33, 0.8) 0%, rgba(43, 36, 33, 0.52) 42%, rgba(43, 36, 33, 0.34) 100%),
        linear-gradient(180deg, rgba(43, 36, 33, 0.24) 0%, rgba(43, 36, 33, 0.48) 100%);
    }

    .hero-image img {
      width: 100%;
      height: 100%;
      min-height: inherit;
      object-fit: cover;
      border-radius: 0;
    }

    .floating-box {
      display: none;
    }

    .mobile-round-cta {
      position: absolute;
      z-index: 3;
      align-items: center;
      justify-content: center;
      border: 0;
      color: #fff;
      cursor: pointer;
    }

    .mobile-round-cta {
      right: 22px;
      bottom: 28px;
      width: 136px;
      height: 136px;
      border-radius: 50%;
      background: var(--accent);
      box-shadow: 0 18px 40px rgba(43, 36, 33, 0.22);
      padding: 18px;
      text-align: center;
      font-weight: 800;
      line-height: 1.12;
      font-size: 20px;
    }

    .floating-box {
      position: absolute;
      display: none;
      left: 24px;
      bottom: 24px;
      z-index: 2;
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

    .services-section {
      background: var(--text);
      color: #fff;
    }

    .services-intro {
      text-align: center;
    }

    .services-intro .section-title {
      letter-spacing: 0.08em;
      text-transform: uppercase;
    }

    .services-intro .section-text {
      margin-left: auto;
      margin-right: auto;
      color: rgba(255, 255, 255, 0.72);
    }

    .services-columns {
      display: grid;
      grid-template-columns: 1fr;
      margin-top: 34px;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.18);
      border-radius: 10px;
      box-shadow: 0 18px 50px rgba(0, 0, 0, 0.18);
      overflow: hidden;
    }

    .services-column {
      padding: 34px 28px;
    }

    .services-column + .services-column {
      border-top: 1px solid rgba(255, 255, 255, 0.18);
    }

    .services-details {
      display: grid;
      gap: 12px;
      margin: 28px 28px 34px;
      text-align: left;
    }

    .services-details > p {
      margin: 0;
      color: rgba(255, 255, 255, 0.76);
      font-size: 15px;
      text-align: center;
    }

    .service-accordion {
      display: grid;
      gap: 8px;
    }

    .service-accordion details {
      border: 1px solid rgba(255, 255, 255, 0.18);
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.05);
      overflow: hidden;
    }

    .service-accordion summary {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      padding: 14px 16px;
      color: #fff;
      cursor: pointer;
      font-size: 15px;
      font-weight: 700;
      list-style: none;
    }

    .service-accordion summary::-webkit-details-marker {
      display: none;
    }

    .service-accordion summary::after {
      content: "+";
      display: inline-grid;
      flex: 0 0 auto;
      width: 28px;
      height: 28px;
      place-items: center;
      margin-left: auto;
      color: #fff;
      font-size: 28px;
      font-weight: 400;
      line-height: 1;
    }

    .service-accordion details[open] summary::after {
      content: "−";
    }

    .service-accordion p {
      margin: 0;
      padding: 0 56px 16px 16px;
      color: rgba(255, 255, 255, 0.74);
      font-size: 14px;
      line-height: 1.55;
    }

    .services-column h3 {
      margin: 0 0 22px;
      color: #fff;
      font-size: 20px;
      letter-spacing: 0.08em;
      text-align: left;
      text-transform: uppercase;
    }

    .services-check-list {
      display: grid;
      gap: 16px;
      margin: 0;
      padding: 0;
      list-style: none;
      color: rgba(255, 255, 255, 0.78);
      font-size: 14px;
      line-height: 1.45;
      text-align: left;
    }

    .services-check-list li {
      display: grid;
      justify-items: start;
      gap: 5px;
      padding-bottom: 14px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    }

    .services-check-list li:last-child {
      padding-bottom: 0;
      border-bottom: 0;
    }

    .service-list-name {
      color: #fff;
      font-size: 15px;
      font-weight: 700;
      line-height: 1.35;
    }

    .service-list-meta {
      display: flex;
      width: 100%;
      justify-content: flex-start;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
      color: rgba(255, 255, 255, 0.72);
      font-size: 13px;
    }

    .service-list-time {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      border: 1px solid rgba(255, 255, 255, 0.18);
      border-radius: 999px;
      padding: 4px 9px;
      background: rgba(255, 255, 255, 0.06);
      color: rgba(255, 255, 255, 0.86);
      font-weight: 600;
    }

    .service-list-price {
      margin-left: auto;
      color: #fff;
      font-size: 15px;
      font-weight: 800;
      white-space: nowrap;
    }

    .service-list-apparatus-wrap {
      display: grid;
      grid-template-columns: minmax(0, 1fr) auto;
      gap: 18px;
      align-items: center;
      width: 100%;
      margin-top: 4px;
    }

    .service-list-apparatus-wrap .service-list-time {
      justify-content: center;
    }

    .service-list-apparatus-side {
      display: grid;
      gap: 4px;
      justify-items: center;
      align-content: center;
    }

    .service-list-apparatus-price-label {
      color: #fff;
      font-size: 17px;
      font-weight: 800;
      line-height: 1.25;
    }

    .service-list-apparatus-price {
      display: inline-grid;
      place-items: center;
      color: #fff;
      font-size: 17px;
      font-weight: 800;
      line-height: 1.25;
      text-align: center;
    }

    .service-list-apparatus {
      display: grid;
      gap: 8px;
      margin-top: 4px;
      padding-left: 0;
      list-style: none;
    }

    .service-list-apparatus-label {
      color: rgba(255, 255, 255, 0.68);
      font-size: 13px;
    }

    .service-list-apparatus li {
      position: relative;
      padding: 0 0 0 14px;
      border: 0;
      color: rgba(255, 255, 255, 0.82);
      font-size: 13px;
    }

    .service-list-apparatus li::before {
      content: "•";
      position: absolute;
      left: 0;
      top: 0;
      color: #fff;
    }

    .services-more {
      margin-top: 28px;
      border-color: rgba(255, 255, 255, 0.72);
      color: #fff;
      background: rgba(255, 255, 255, 0.08);
    }

    .services-more:hover {
      background: rgba(255, 255, 255, 0.16);
    }

    .quick-book-section {
      background: var(--text);
      color: #fff;
      padding-top: 0;
    }

    .quick-book-card {
      padding: 34px 28px;
      border: 1px solid rgba(255, 255, 255, 0.18);
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.06);
      box-shadow: 0 18px 50px rgba(0, 0, 0, 0.18);
      text-align: center;
    }

    .quick-book-card .section-title {
      color: #fff;
      letter-spacing: 0.08em;
      text-transform: uppercase;
    }

    .quick-book-card .section-text {
      margin-left: auto;
      margin-right: auto;
      color: rgba(255, 255, 255, 0.72);
    }

    .quick-steps {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 1px;
      margin-top: 30px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.16);
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.14);
    }

    .quick-step {
      padding: 26px 20px;
      background: rgba(43, 36, 33, 0.78);
    }

    .quick-step strong {
      display: block;
      margin-bottom: 8px;
      color: #fff;
      font-size: 18px;
      letter-spacing: 0.08em;
      text-transform: uppercase;
    }

    .quick-step p {
      margin: 0;
      color: rgba(255, 255, 255, 0.74);
      font-size: 14px;
    }

    .site-dark-section {
      background: var(--text);
      color: #fff;
    }

    .site-dark-section .section-title {
      color: #fff;
      letter-spacing: 0.08em;
      text-transform: uppercase;
    }

    #about .section-title {
      text-align: center;
    }

    #reviews .section-title {
      text-align: center;
    }

    #contact .section-title {
      text-align: center;
    }

    .site-dark-section .section-text {
      color: rgba(255, 255, 255, 0.72);
    }

    .site-dark-section .btn {
      border-color: rgba(255, 255, 255, 0.82);
      background: rgba(255, 255, 255, 0.04);
      color: #fff;
      box-shadow: none;
    }

    .site-dark-section .btn:hover {
      border-color: #fff;
      background: rgba(255, 255, 255, 0.14);
      color: #fff;
      transform: translateY(-1px);
    }

    .site-dark-section .hero-card,
    .site-dark-section .price-card,
    .site-dark-section .review-card,
    .site-dark-section .info-card,
    .site-dark-section .form-card,
    .site-dark-section .prep-card,
    .site-dark-section .about-master-card,
    .site-dark-section .about-profile-card {
      background: rgba(255, 255, 255, 0.06);
      border-color: rgba(255, 255, 255, 0.18);
      border-radius: 10px;
      box-shadow: 0 18px 50px rgba(0, 0, 0, 0.18);
      color: #fff;
    }

    .site-dark-section .price-card p,
    .site-dark-section .review-card p,
    .site-dark-section .info-card p,
    .site-dark-section .form-card p,
    .site-dark-section .about-list li,
    .site-dark-section .prep-card li,
    .site-dark-section .about-profile-text,
    .site-dark-section .price-sub,
    .site-dark-section .price-empty,
    .site-dark-section .service-meta,
    .site-dark-section .master-meta,
    .site-dark-section .apparatus-duration-box small,
    .site-dark-section .selected-service-meta,
    .site-dark-section .services-section-label {
      color: rgba(255, 255, 255, 0.72);
    }

    .site-dark-section .booking-block h4,
    .site-dark-section .booking-block-header h4 {
      color: #fff;
      text-shadow: 0 1px 12px rgba(0, 0, 0, 0.24);
    }

    .site-dark-section .booking-block-header small,
    .site-dark-section .slot-hint,
    .site-dark-section .apparatus-duration-box small {
      color: rgba(255, 255, 255, 0.78);
    }

    .site-dark-section .form-card > p {
      color: rgba(255, 255, 255, 0.88);
      font-size: 17px;
      line-height: 1.6;
    }

    .site-dark-section .booking-block input,
    .site-dark-section .booking-block textarea,
    .site-dark-section .booking-block select {
      color: #2b2421;
    }

    .site-dark-section .booking-block input::placeholder,
    .site-dark-section .booking-block textarea::placeholder {
      color: rgba(43, 36, 33, 0.68);
    }

    .site-dark-section .price-note,
    .site-dark-section .contact-item,
    .site-dark-section .booking-block,
    .site-dark-section .apparatus-duration-box,
    .site-dark-section .selected-service-card {
      background: rgba(255, 255, 255, 0.06);
      border-color: rgba(255, 255, 255, 0.18);
      color: #fff;
    }

    .site-dark-section .price-master-tab,
    .site-dark-section .service-option,
    .site-dark-section .master-option,
    .site-dark-section .day-chip,
    .site-dark-section .time-chip,
    .site-dark-section .period-chip,
    .site-dark-section .calendar-nav,
    .site-dark-section .apparatus-duration-option,
    .site-dark-section .apparatus-discuss-btn {
      background: rgba(255, 255, 255, 0.08);
      border-color: rgba(255, 255, 255, 0.2);
      color: #fff;
    }

    .site-dark-section .price-master-tab span {
      color: rgba(255, 255, 255, 0.72);
    }

    .site-dark-section .service-option strong,
    .site-dark-section .master-option strong,
    .site-dark-section .selected-service-card strong,
    .site-dark-section .month-picker-title {
      color: #fff;
    }

    .site-dark-section .service-option p,
    .site-dark-section .service-meta,
    .site-dark-section .master-meta,
    .site-dark-section .selected-service-meta,
    .site-dark-section .day-chip .day-name,
    .site-dark-section .day-chip .day-month {
      color: rgba(255, 255, 255, 0.8);
    }

    .site-dark-section .price-master-tab.active,
    .site-dark-section .service-option.active,
    .site-dark-section .master-option.active,
    .site-dark-section .day-chip.active,
    .site-dark-section .time-chip.active,
    .site-dark-section .period-chip.active,
    .site-dark-section .apparatus-duration-option.active,
    .site-dark-section .apparatus-discuss-btn.active {
      background: rgba(255, 255, 255, 0.18);
      border-color: rgba(255, 255, 255, 0.78);
      box-shadow: 0 14px 32px rgba(0, 0, 0, 0.18);
      color: #fff;
    }

    .site-dark-section .service-option:hover,
    .site-dark-section .master-option:hover,
    .site-dark-section .day-chip:not(:disabled):hover,
    .site-dark-section .time-chip:not(:disabled):hover,
    .site-dark-section .apparatus-duration-option:hover,
    .site-dark-section .apparatus-discuss-btn:hover {
      border-color: rgba(255, 255, 255, 0.62);
      background: rgba(255, 255, 255, 0.12);
    }

    .site-dark-section .time-chip.is-consumed {
      background: rgba(255, 255, 255, 0.88);
      border-color: rgba(255, 255, 255, 0.82);
      color: #7a5d50;
    }

    .site-dark-section .day-chip.is-disabled {
      background: rgba(255, 255, 255, 0.2);
      color: rgba(255, 255, 255, 0.58);
    }

    .site-dark-section .price-master-group h4 {
      border-color: rgba(255, 255, 255, 0.28);
      background: rgba(255, 255, 255, 0.08);
      color: #fff;
    }

    .site-dark-section .price-item {
      border-bottom-color: rgba(255, 255, 255, 0.16);
    }

    .site-dark-section .price-item-apparatus {
      border-color: rgba(255, 255, 255, 0.18);
      background: rgba(255, 255, 255, 0.05);
    }

    .site-dark-section .booking-summary {
      background: rgba(255, 255, 255, 0.08);
      border-color: rgba(255, 255, 255, 0.18);
      color: #fff;
    }

    .site-dark-section .booking-summary-line {
      border-top-color: rgba(255, 255, 255, 0.16);
    }

    .site-dark-section .booking-summary small,
    .site-dark-section .booking-summary p,
    .site-dark-section #summary-duration {
      color: rgba(255, 255, 255, 0.82);
    }

    .site-dark-section .price-apparatus-list {
      color: rgba(255, 255, 255, 0.84);
    }

    .site-dark-section .stars,
    .site-dark-section .about-list li::before {
      color: #fff;
    }

    .site-dark-section .gallery-slide img,
    .site-dark-section .about-image img,
    .site-dark-section .map-box {
      border: 1px solid rgba(255, 255, 255, 0.18);
      border-radius: 10px;
    }

    .site-dark-section input,
    .site-dark-section select,
    .site-dark-section textarea {
      background: rgba(255, 255, 255, 0.94);
    }

    footer {
      background: var(--text);
      color: rgba(255, 255, 255, 0.62);
    }

    .footer-box {
      border-top-color: rgba(255, 255, 255, 0.18);
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
      grid-template-columns: 1fr;
      gap: 24px;
      margin-top: 34px;
    }

    .price-card {
      padding: 30px;
    }

    .price-menu-card {
      text-align: center;
    }

    .price-menu-card > h3 {
      margin-left: auto;
      margin-right: auto;
    }

    .price-note {
      display: inline-block;
      margin-top: 6px;
      border: 1px solid var(--line);
      border-radius: 16px;
      background: #fffaf7;
      padding: 14px 18px;
      color: var(--text);
      font-size: 17px;
      line-height: 1.55;
      text-align: center;
    }

    .price-switch-label {
      margin: 20px 0 0;
      color: var(--text);
      font-size: 17px;
      font-weight: 800;
      text-align: center;
    }

    .price-list {
      margin-top: 18px;
      display: grid;
      gap: 14px;
      text-align: left;
    }

    .price-master-switch {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 12px;
      margin-top: 20px;
    }

    .price-master-tab {
      position: relative;
      overflow: hidden;
      border: 1px solid var(--line);
      border-radius: 16px;
      background: #fff;
      padding: 16px 18px;
      text-align: left;
      cursor: pointer;
      transform: translateY(0);
      transition: 0.18s ease;
      animation: priceTabFloat 3.8s ease-in-out infinite;
    }

    .price-master-tab:nth-child(2n) {
      animation-delay: 0.7s;
    }

    .price-master-tab::after {
      content: '';
      position: absolute;
      right: 18px;
      top: 18px;
      width: 13px;
      height: 13px;
      border-radius: 999px;
      background: rgba(47, 149, 173, 0.24);
      box-shadow: 0 0 0 0 rgba(47, 149, 173, 0.22);
      animation: priceTapPulse 2.4s ease-out infinite;
    }

    .price-master-tab:hover {
      border-color: #2f95ad;
      transform: translateY(-2px);
      box-shadow: 0 16px 34px rgba(47, 149, 173, 0.12);
    }

    .price-master-tab strong,
    .price-master-tab span {
      display: block;
    }

    .price-master-tab strong {
      font-size: 18px;
    }

    .price-master-tab span {
      margin-top: 5px;
      color: var(--muted);
      font-size: 14px;
    }

    .price-master-tab.active {
      border-color: #2f95ad;
      background: #2f95ad;
      color: #fff;
      box-shadow: 0 18px 36px rgba(47, 149, 173, 0.18);
    }

    .price-master-tab.active strong {
      color: #fff;
    }

    .price-master-tab.active span {
      color: rgba(255, 255, 255, 0.86);
    }

    .price-master-tab.active::after {
      background: rgba(255, 255, 255, 0.55);
      box-shadow: 0 0 0 8px rgba(255, 255, 255, 0.16);
    }

    @keyframes priceTabFloat {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-3px); }
    }

    @keyframes priceTapPulse {
      0% { transform: scale(0.7); box-shadow: 0 0 0 0 rgba(47, 149, 173, 0.22); opacity: 0.8; }
      70% { transform: scale(1); box-shadow: 0 0 0 13px rgba(47, 149, 173, 0); opacity: 1; }
      100% { transform: scale(0.7); box-shadow: 0 0 0 0 rgba(47, 149, 173, 0); opacity: 0.8; }
    }

    .price-master-group {
      display: grid;
      gap: 20px;
    }

    .price-master-group h4 {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: fit-content;
      margin: 10px auto 10px;
      border: 1px solid var(--accent);
      border-radius: 999px;
      background: rgba(182, 132, 107, 0.12);
      color: var(--accent-dark);
      padding: 9px 16px;
      font-size: 19px;
      font-weight: 800;
    }

    .price-empty {
      margin: 0;
      color: var(--muted);
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

    .price-item-apparatus {
      align-items: stretch;
      border: 1px solid rgba(182, 132, 107, 0.28);
      border-radius: 18px;
      padding: 18px 18px 28px;
      margin: 16px 0 6px;
      background: rgba(182, 132, 107, 0.05);
      overflow: hidden;
    }

    .price-item-apparatus:last-child {
      border-bottom: 1px solid rgba(182, 132, 107, 0.28);
      padding-bottom: 28px;
    }

    .price-name {
      font-weight: 700;
    }

    .price-apparatus-list {
      display: grid;
      gap: 7px;
      margin: 10px 0 0;
      color: var(--text);
      font-size: 15px;
      padding-bottom: 2px;
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

    .price-item-apparatus .price-side {
      align-content: center;
      min-width: 156px;
      padding-bottom: 2px;
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

    .gallery-section {
      text-align: center;
    }

    .gallery-section .section-text {
      margin-left: auto;
      margin-right: auto;
    }

    .gallery-slider {
      position: relative;
      max-width: 880px;
      margin-top: 34px;
      margin-left: auto;
      margin-right: auto;
    }

    .gallery-viewport {
      overflow: hidden;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.04);
    }

    .gallery-track {
      display: flex;
      transition: transform 0.35s ease;
      will-change: transform;
    }

    .gallery-slide {
      flex: 0 0 100%;
      display: grid;
      place-items: center;
    }

    .gallery-slide img {
      width: auto;
      max-width: 100%;
      height: clamp(520px, 72vw, 720px);
      object-fit: contain;
      background: rgba(43, 36, 33, 0.36);
    }

    .gallery-nav {
      position: absolute;
      top: 50%;
      z-index: 2;
      width: 44px;
      height: 44px;
      display: grid;
      place-items: center;
      border: 1px solid rgba(255, 255, 255, 0.72);
      border-radius: 999px;
      background: rgba(43, 36, 33, 0.58);
      color: #fff;
      cursor: pointer;
      font-size: 28px;
      line-height: 1;
      transform: translateY(-50%);
      transition: 0.2s ease;
    }

    .gallery-nav:hover {
      background: rgba(43, 36, 33, 0.78);
    }

    .gallery-prev {
      left: 16px;
    }

    .gallery-next {
      right: 16px;
    }

    .gallery-dots {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 18px;
    }

    .gallery-dot {
      width: 10px;
      height: 10px;
      border: 0;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.32);
      cursor: pointer;
      padding: 0;
    }

    .gallery-dot.active {
      background: #fff;
    }

    .reviews-grid {
      grid-template-columns: repeat(3, 1fr);
      margin-top: 34px;
    }

    .reviews-head {
      display: grid;
      justify-items: center;
      gap: 18px;
    }

    .reviews-page[hidden],
    .reviews-pagination[hidden] {
      display: none;
    }

    .review-actions {
      display: flex;
      justify-content: center;
      margin-top: 28px;
    }

    .review-card {
      padding: 26px;
    }

    .stars,
    .rating-stars {
      position: relative;
      display: inline-block;
      font-size: 18px;
      letter-spacing: 2px;
      color: rgba(255, 255, 255, 0.24);
      line-height: 1;
    }

    .stars {
      margin-bottom: 14px;
    }

    .rating-stars::before {
      content: "★★★★★";
    }

    .rating-stars::after {
      content: "★★★★★";
      position: absolute;
      inset: 0 auto 0 0;
      width: calc(var(--rating) / 5 * 100%);
      overflow: hidden;
      color: var(--accent);
    }

    .review-author {
      margin-top: 18px;
      font-weight: 700;
    }

    .review-meta {
      display: grid;
      gap: 6px;
      margin-top: 14px;
      color: rgba(255, 255, 255, 0.68);
      font-size: 14px;
      line-height: 1.45;
    }

    .reviews-pagination {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      margin-top: 24px;
    }

    .review-page-arrow,
    .review-page-dot {
      border: 1px solid rgba(255, 255, 255, 0.34);
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.08);
      color: #fff;
      cursor: pointer;
      font-weight: 800;
      transition: 0.2s ease;
    }

    .review-page-arrow {
      width: 42px;
      height: 42px;
      display: grid;
      place-items: center;
      font-size: 28px;
      line-height: 1;
    }

    .review-page-dot {
      width: 18px;
      height: 18px;
      padding: 0;
    }

    .review-page-arrow:hover,
    .review-page-dot:hover,
    .review-page-dot.active {
      border-color: rgba(255, 255, 255, 0.78);
      background: #fff;
      color: var(--text);
    }

    .review-page-arrow:disabled {
      opacity: 0.38;
      cursor: default;
      background: rgba(255, 255, 255, 0.06);
      color: #fff;
    }

    .review-form {
      display: grid;
      gap: 16px;
    }

    .review-form label {
      display: grid;
      gap: 8px;
      color: #fff;
      font-weight: 700;
    }

    .review-form small {
      color: rgba(255, 255, 255, 0.62);
      font-weight: 400;
    }

    .review-popup-dialog {
      background: rgba(43, 36, 33, 0.98);
      border: 1px solid rgba(255, 255, 255, 0.22);
      color: #fff;
      box-shadow: 0 26px 90px rgba(0, 0, 0, 0.46);
    }

    .review-popup-dialog strong {
      color: #fff;
      font-size: 24px;
      letter-spacing: 0.04em;
    }

    .review-popup-dialog input,
    .review-popup-dialog select,
    .review-popup-dialog textarea {
      border-color: rgba(255, 255, 255, 0.24);
      background: rgba(255, 255, 255, 0.94);
      color: var(--text);
    }

    .review-rating-control {
      display: grid;
      gap: 10px;
    }

    .review-rating-row {
      display: flex;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
    }

    .review-stars-picker {
      display: inline-flex;
      gap: 4px;
      padding: 4px 0;
      border: 0;
      background: transparent;
      cursor: pointer;
      color: rgba(255, 255, 255, 0.28);
      line-height: 1;
    }

    .review-star-option {
      position: relative;
      width: 30px;
      height: 32px;
      display: inline-grid;
      place-items: center;
      font-size: 30px;
    }

    .review-star-option::before {
      content: "★";
    }

    .review-star-option::after {
      content: "★";
      position: absolute;
      inset: 0;
      display: grid;
      place-items: center;
      width: var(--fill, 0%);
      overflow: hidden;
      color: var(--accent);
    }

    .review-stars-picker:focus-visible {
      outline: 2px solid rgba(255, 255, 255, 0.72);
      outline-offset: 4px;
      border-radius: 6px;
    }

    .review-rating-value {
      min-width: 46px;
      font-weight: 800;
      color: #fff;
    }

    .review-form-errors {
      display: grid;
      gap: 6px;
      margin: 0;
      padding: 12px 14px;
      border-radius: 8px;
      background: rgba(184, 70, 70, 0.1);
      color: #9f2f2f;
      font-size: 14px;
    }

    .review-form .btn {
      border-color: rgba(255, 255, 255, 0.82);
      background: transparent;
      color: #fff;
    }

    .review-form .btn:hover {
      background: rgba(255, 255, 255, 0.14);
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

    .prep-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 22px;
      margin-top: 34px;
    }

    .prepare-section {
      text-align: center;
    }

    .prepare-section .section-text {
      margin-left: auto;
      margin-right: auto;
    }

    .prep-card {
      display: grid;
      gap: 12px;
      padding: 26px;
      text-align: center;
    }

    .prep-card h3 {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin: 0;
      font-size: 22px;
    }

    .prep-card h3 span {
      display: inline-grid;
      width: 34px;
      height: 34px;
      place-items: center;
      border-radius: 999px;
      background: rgba(182, 132, 107, 0.16);
      color: #fff;
      font-size: 17px;
    }

    .prep-card ul,
    .about-profile-text {
      display: grid;
      gap: 10px;
      margin: 0;
      padding: 0;
      list-style: none;
      color: var(--muted);
    }

    .prep-card li,
    .about-profile-text p {
      margin: 0;
    }

    .about-profiles {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 22px;
      margin-top: 34px;
    }

    .about-profile-card {
      padding: 30px;
    }

    .about-profile-card h3 {
      margin: 0 0 16px;
      font-size: 26px;
    }

    .about-master-card {
      display: grid;
      grid-template-columns: 0.88fr 1.12fr;
      gap: 28px;
      align-items: stretch;
      margin-top: 34px;
      padding: 28px;
      overflow: hidden;
    }

    .about-master-card--reverse {
      grid-template-columns: 1.12fr 0.88fr;
    }

    .about-master-card--reverse .about-master-photo {
      order: 2;
    }

    .about-master-photo {
      min-height: 520px;
      border-radius: 10px;
      overflow: hidden;
      background: rgba(255, 255, 255, 0.08);
    }

    .about-master-photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .about-master-content {
      display: grid;
      align-content: center;
      gap: 18px;
      text-align: left;
    }

    .about-master-kicker {
      color: rgba(255, 255, 255, 0.68);
      font-size: 14px;
      font-weight: 700;
      letter-spacing: 0.16em;
      text-transform: uppercase;
    }

    .about-master-content h3 {
      margin: 0;
      color: #fff;
      font-size: clamp(30px, 4vw, 44px);
      line-height: 1.05;
      letter-spacing: 0.04em;
      text-transform: uppercase;
    }

    .about-master-text {
      position: relative;
      display: grid;
      gap: 12px;
      max-height: 190px;
      overflow: hidden;
      color: rgba(255, 255, 255, 0.78);
      font-size: 17px;
      line-height: 1.7;
      transition: max-height 0.35s ease;
    }

    .about-master-text::after {
      content: "";
      position: absolute;
      right: 0;
      bottom: 0;
      left: 0;
      height: 76px;
      pointer-events: none;
      background: linear-gradient(180deg, rgba(54, 46, 42, 0), rgba(54, 46, 42, 0.96));
      transition: opacity 0.25s ease;
    }

    .about-master-text.is-expanded {
      max-height: 900px;
    }

    .about-master-text.is-expanded::after {
      opacity: 0;
    }

    .about-master-text p {
      margin: 0;
    }

    .about-expand {
      width: fit-content;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      border: 0;
      padding: 4px 0;
      background: transparent;
      color: #fff;
      cursor: pointer;
      font: inherit;
      font-weight: 800;
      letter-spacing: 0.04em;
    }

    .about-expand-icon {
      width: 30px;
      height: 30px;
      display: grid;
      place-items: center;
      border: 1px solid rgba(255, 255, 255, 0.48);
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.08);
      transition: transform 0.25s ease, border-color 0.25s ease, background 0.25s ease;
    }

    .about-expand-icon::before {
      content: "";
      width: 8px;
      height: 8px;
      border-right: 2px solid currentColor;
      border-bottom: 2px solid currentColor;
      transform: translateY(-2px) rotate(45deg);
    }

    .about-expand:hover .about-expand-icon {
      border-color: rgba(255, 255, 255, 0.78);
      background: rgba(255, 255, 255, 0.14);
    }

    .about-expand[aria-expanded="true"] .about-expand-icon {
      transform: rotate(180deg);
    }

    .about-expand .toggle-open {
      display: none;
    }

    .about-expand[aria-expanded="true"] .toggle-open {
      display: inline;
    }

    .about-expand[aria-expanded="true"] .toggle-closed {
      display: none;
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

    .contact-item span {
      display: block;
    }

    .contact-item span + span {
      margin-top: 6px;
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

    .map-link {
      width: 100%;
      margin-top: 12px;
      color: #fff;
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

    .message-popup {
      position: fixed;
      inset: 0;
      z-index: 1000;
      display: grid;
      place-items: center;
      padding: 20px;
    }

    .message-popup-backdrop {
      position: absolute;
      inset: 0;
      background: rgba(18, 14, 12, 0.68);
      backdrop-filter: blur(5px);
    }

    .message-popup-dialog {
      position: relative;
      z-index: 1;
      width: min(460px, 100%);
      display: grid;
      gap: 18px;
      padding: 28px;
      border-radius: 10px;
      background:
        linear-gradient(180deg, rgba(65, 55, 50, 0.98), rgba(43, 36, 33, 0.98)),
        var(--text);
      border: 1px solid rgba(255, 255, 255, 0.18);
      color: #fff;
      box-shadow: 0 26px 80px rgba(0, 0, 0, 0.42);
    }

    .message-popup-close {
      position: absolute;
      top: 12px;
      right: 12px;
      display: grid;
      place-items: center;
      width: 38px;
      height: 38px;
      border: 1px solid rgba(255, 255, 255, 0.42);
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.06);
      color: #fff;
      cursor: pointer;
      font-size: 26px;
      line-height: 1;
    }

    .message-popup-close:hover {
      background: rgba(255, 255, 255, 0.16);
    }

    .message-popup-dialog strong {
      color: #fff;
      font-size: 22px;
      line-height: 1.25;
      letter-spacing: 0.03em;
    }

    .message-popup-dialog p {
      margin: 0;
      color: rgba(255, 255, 255, 0.78);
      line-height: 1.55;
      white-space: pre-line;
    }

    .message-popup-dialog label,
    .message-popup-dialog small {
      color: rgba(255, 255, 255, 0.82);
    }

    .message-popup-dialog input,
    .message-popup-dialog select,
    .message-popup-dialog textarea {
      border-color: rgba(255, 255, 255, 0.22);
      background: rgba(255, 255, 255, 0.94);
      color: var(--text);
      border-radius: 8px;
    }

    .message-popup-dialog .btn {
      border-color: rgba(255, 255, 255, 0.82);
      background: transparent;
      color: #fff;
      box-shadow: none;
    }

    .message-popup-dialog .btn:hover {
      background: rgba(255, 255, 255, 0.14);
    }

    .message-popup-actions {
      display: grid;
      grid-template-columns: 1fr;
      gap: 10px;
    }

    .message-popup-actions.has-confirm {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .message-popup-dialog.review-popup-dialog {
      width: min(500px, 100%);
      gap: 20px;
      padding: 30px;
      background: rgba(43, 36, 33, 0.98);
      border-color: rgba(255, 255, 255, 0.22);
      box-shadow: 0 26px 90px rgba(0, 0, 0, 0.46);
    }

    .message-popup-dialog.review-popup-dialog strong {
      color: #fff;
      font-size: 26px;
      letter-spacing: 0.04em;
      text-transform: uppercase;
    }

    .message-popup-dialog.review-popup-dialog small {
      color: rgba(255, 255, 255, 0.62);
    }

    @media (max-width: 520px) {
      .message-popup-actions.has-confirm {
        grid-template-columns: 1fr;
      }

      .floating-booking-btn {
        right: 14px;
        left: auto;
        bottom: calc(14px + env(safe-area-inset-bottom));
        max-width: calc(100% - 32px);
        transform: none;
      }

      .floating-booking-btn:hover,
      .floating-booking-btn:focus-visible {
        transform: translateY(-1px);
      }

      .booking-modal {
        padding: 10px;
      }

      .booking-modal-dialog {
        max-height: 94vh;
        border-radius: 10px;
      }
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

    body.is-booking-modal-open {
      overflow: hidden;
    }

    .floating-booking-btn {
      position: fixed;
      right: clamp(16px, 4vw, 42px);
      bottom: calc(18px + env(safe-area-inset-bottom));
      z-index: 95;
      min-height: 54px;
      padding: 0 24px;
      border: 0;
      border-radius: 999px;
      background: #d8ad55;
      color: #fff;
      cursor: pointer;
      font-size: 16px;
      font-weight: 800;
      line-height: 1;
      box-shadow:
        0 0 0 10px rgba(216, 173, 85, 0.16),
        0 12px 30px rgba(43, 36, 33, 0.26);
      animation: bookingPulse 2.1s ease-in-out infinite;
    }

    .floating-booking-btn:hover,
    .floating-booking-btn:focus-visible {
      background: #e0b964;
      outline: none;
      transform: translateY(-1px);
    }

    @keyframes bookingPulse {
      0%,
      100% {
        box-shadow:
          0 0 0 8px rgba(216, 173, 85, 0.14),
          0 12px 30px rgba(43, 36, 33, 0.24);
      }

      50% {
        box-shadow:
          0 0 0 18px rgba(216, 173, 85, 0.06),
          0 16px 36px rgba(43, 36, 33, 0.3);
      }
    }

    .booking-modal {
      position: fixed;
      inset: 0;
      z-index: 1100;
      display: grid;
      place-items: center;
      padding: 18px;
    }

    .booking-modal-backdrop {
      position: absolute;
      inset: 0;
      background: rgba(18, 14, 12, 0.72);
      backdrop-filter: blur(6px);
    }

    .booking-modal-dialog {
      position: relative;
      z-index: 1;
      width: min(100%, 760px);
      max-height: min(92vh, 980px);
      overflow: auto;
      border: 1px solid rgba(255, 255, 255, 0.22);
      border-radius: 14px;
      background: rgba(43, 36, 33, 0.98);
      box-shadow: 0 26px 90px rgba(0, 0, 0, 0.46);
    }

    .booking-modal-slot .form-card {
      border: 0;
      border-radius: 14px;
      box-shadow: none;
    }

    .booking-modal-close {
      position: sticky;
      top: 12px;
      left: calc(100% - 54px);
      z-index: 2;
      display: grid;
      place-items: center;
      width: 42px;
      height: 42px;
      margin: 12px 12px -54px auto;
      border: 1px solid rgba(255, 255, 255, 0.42);
      border-radius: 999px;
      background: rgba(43, 36, 33, 0.78);
      color: #fff;
      cursor: pointer;
      font-size: 28px;
      line-height: 1;
      backdrop-filter: blur(10px);
    }

    .booking-modal-close:hover {
      background: rgba(255, 255, 255, 0.14);
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
      position: relative;
      width: 100%;
      text-align: left;
      padding: 18px;
    }

    .service-option {
      padding-right: 54px;
    }

    .master-option {
      position: relative;
      overflow: hidden;
      padding-right: 52px;
      transform: translateY(0);
      animation: priceTabFloat 3.8s ease-in-out infinite;
    }

    .master-option:nth-child(2n) {
      animation-delay: 0.7s;
    }

    .master-option::after {
      content: '';
      position: absolute;
      right: 18px;
      top: 22px;
      width: 13px;
      height: 13px;
      border-radius: 999px;
      background: rgba(47, 149, 173, 0.24);
      box-shadow: 0 0 0 0 rgba(47, 149, 173, 0.22);
      animation: priceTapPulse 2.4s ease-out infinite;
    }

    .master-option:hover {
      border-color: #2f95ad;
      transform: translateY(-2px);
      box-shadow: 0 16px 34px rgba(47, 149, 173, 0.12);
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

    .service-option .service-order {
      position: absolute;
      top: 16px;
      right: 16px;
      display: none;
      place-items: center;
      width: 26px;
      height: 26px;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.92);
      color: #2f8dad;
      font-weight: 900;
      font-size: 13px;
    }

    .service-option.active .service-order {
      display: grid;
    }

    .master-option.active::after {
      background: rgba(255, 255, 255, 0.58);
      box-shadow: 0 0 0 8px rgba(255, 255, 255, 0.16);
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

    .apparatus-duration-box {
      display: grid;
      gap: 12px;
      margin-top: 14px;
      border: 1px solid var(--line);
      border-radius: 16px;
      background: #fffaf7;
      padding: 14px;
    }

    .apparatus-duration-options {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 8px;
    }

    .apparatus-duration-option,
    .apparatus-discuss-btn {
      border: 1px solid var(--line);
      border-radius: 999px;
      background: #fff;
      padding: 10px 12px;
      cursor: pointer;
      font-weight: 800;
    }

    .apparatus-duration-option.active,
    .apparatus-discuss-btn.active {
      border-color: #2f95ad;
      background: #2f95ad;
      color: #fff;
    }

    .apparatus-duration-box small {
      color: var(--muted);
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

    .add-service-trigger.is-unavailable {
      opacity: 0.65;
      cursor: not-allowed;
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
      display: flex;
      flex-wrap: wrap;
      gap: 8px 12px;
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

    .month-picker.is-nav-hidden {
      justify-content: center;
    }

    .date-slider.is-nav-hidden {
      grid-template-columns: 1fr;
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
      display: grid;
      place-items: center;
      gap: 3px;
      min-height: 56px;
      padding: 14px 10px;
      text-align: center;
      font-weight: 700;
    }

    .time-chip small {
      display: block;
      color: currentColor;
      font-size: 11px;
      font-weight: 600;
      line-height: 1.15;
      opacity: 0.72;
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
      overflow: hidden;
    }

    .booking-summary-head,
    .booking-total {
      display: flex;
      justify-content: space-between;
      gap: 12px;
      align-items: flex-start;
    }

    .booking-summary-head > div:first-child {
      min-width: 0;
    }

    .booking-summary-head > div:last-child {
      flex: 0 0 auto;
      min-width: 94px;
    }

    .booking-summary small,
    .booking-summary p {
      margin: 0;
      color: var(--muted);
    }

    .booking-summary p,
    #summary-duration {
      white-space: pre-line;
    }

    .booking-summary strong {
      font-size: 20px;
      line-height: 1.28;
      overflow-wrap: anywhere;
    }

    #summary-price {
      display: block;
      white-space: nowrap;
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
      padding: 28px 0 112px;
      background: var(--text);
      color: rgba(255, 255, 255, 0.62);
      font-size: 14px;
    }

    .sticky-cta {
      position: fixed;
      left: 50%;
      bottom: calc(18px + env(safe-area-inset-bottom));
      z-index: 80;
      width: min(calc(100% - 28px), 760px);
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 10px;
      padding: 10px;
      border: 1px solid rgba(255, 255, 255, 0.42);
      border-radius: 10px;
      background: rgba(43, 36, 33, 0.72);
      box-shadow: 0 18px 50px rgba(43, 36, 33, 0.24);
      backdrop-filter: blur(12px);
      transform: translateX(-50%);
    }

    .sticky-cta .btn {
      min-height: 50px;
      padding: 12px 16px;
      border-color: rgba(255, 255, 255, 0.78);
      background: rgba(255, 255, 255, 0.08);
      color: #fff;
      box-shadow: none;
      text-align: center;
      line-height: 1.2;
    }

    .sticky-cta .btn:hover {
      background: rgba(255, 255, 255, 0.16);
    }

    .footer-box {
      display: flex;
      justify-content: center;
      gap: 20px;
      align-items: center;
      padding-top: 26px;
      text-align: center;
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

      .about-profiles {
        grid-template-columns: 1fr;
      }

      .about-master-card {
        grid-template-columns: 1fr;
      }

      .about-master-card--reverse .about-master-photo {
        order: 0;
      }

      .about-master-photo {
        min-height: 380px;
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
        position: sticky;
        top: 0;
        background: var(--text);
        border-bottom: 1px solid rgba(234, 222, 215, 0.18);
        backdrop-filter: none;
        transition: background 0.2s ease, box-shadow 0.2s ease;
      }

      .nav {
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
        padding: 14px 0 12px;
        transition: padding 0.2s ease, gap 0.2s ease;
      }

      .topbar.is-compact {
        background: rgba(43, 36, 33, 0.9);
        box-shadow: 0 10px 28px rgba(43, 36, 33, 0.16);
      }

      .topbar.is-compact .nav {
        gap: 0;
        padding: 12px 0;
      }

      .logo {
        text-align: center;
        font-size: 24px;
        color: #fff;
        letter-spacing: 0.14em;
        text-transform: uppercase;
      }

      .logo span {
        color: #fff;
      }

      .logo small {
        display: block;
        margin-top: 2px;
        color: rgba(255, 255, 255, 0.78);
        font-size: 8px;
        font-weight: 700;
        letter-spacing: 0.26em;
      }

      .mobile-brand-row,
      .mobile-socials {
        display: flex;
      }

      .mobile-brand-row,
      .logo,
      .mobile-socials {
        max-height: 92px;
        opacity: 1;
        overflow: hidden;
        transform: translateY(0);
        transition: max-height 0.24s ease, opacity 0.18s ease, transform 0.24s ease, margin 0.24s ease;
      }

      .topbar.is-compact .logo,
      .topbar.is-compact .mobile-socials,
      .topbar.is-compact .mobile-brand-row,
      .topbar.is-compact .mobile-location {
        max-height: 0;
        opacity: 0;
        pointer-events: none;
        transform: translateY(-8px);
      }

      .nav-links {
        width: 100%;
        justify-content: center;
        flex-wrap: wrap;
        gap: 14px 20px;
        overflow: visible;
        padding: 0 2px 4px;
        color: #fff;
        font-size: 12px;
        letter-spacing: 0.28em;
        text-transform: uppercase;
      }

      .nav-links::-webkit-scrollbar {
        display: none;
      }

      .nav-links a {
        flex: 0 0 auto;
        white-space: nowrap;
      }

      .topbar.is-compact .nav-links {
        justify-content: safe center;
        padding-bottom: 0;
      }

      .nav > .btn {
        display: none;
      }

      .hero {
        padding: 0 0 10px;
      }

      .hero .container {
        width: 100%;
        max-width: none;
      }

      .hero-grid {
        min-height: calc(100svh - 166px);
        gap: 0;
        overflow: visible;
        border: 0;
        border-radius: 0;
        box-shadow: none;
      }

      .hero-card {
        align-self: end;
        width: min(100%, 680px);
        padding: 0 64px 104px;
      }

      .hero-card .eyebrow,
      .hero-points {
        display: none;
      }

      .hero-title {
        max-width: 540px;
        margin-left: auto;
        margin-right: auto;
        font-size: 34px;
        font-weight: 800;
        letter-spacing: 0.03em;
        line-height: 1.22;
        margin-bottom: 22px;
      }

      .hero-text {
        max-width: 430px;
        margin: 0 auto 28px;
        color: #fff;
        font-size: 16px;
        line-height: 1.62;
        letter-spacing: 0.08em;
      }

      .hero-benefits {
        width: fit-content;
        max-width: min(100%, 430px);
        margin: 0 auto 28px;
        color: #fff;
        text-align: left;
        font-size: 16px;
        line-height: 1.58;
        letter-spacing: 0.04em;
      }

      .hero-actions {
        flex-direction: column;
        align-items: center;
        margin-bottom: 0;
      }

      .hero-actions .btn-primary {
        display: none;
      }

      .hero-actions .btn-secondary {
        width: auto;
        min-width: 194px;
        border-color: rgba(255, 255, 255, 0.86);
        color: #fff;
        background: rgba(43, 36, 33, 0.1);
        border-radius: 5px;
        font-weight: 500;
        letter-spacing: 0.16em;
      }

      .hero-actions .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.14);
      }

      .btn {
        font-size: 15px;
        letter-spacing: 0.08em;
      }

      .price-card,
      .card,
      .services-column,
      .review-card,
      .info-card,
      .form-card,
      .info-card.large,
      .about-master-card,
      .about-box {
        padding: 22px;
        border-radius: 20px;
      }

      .services-grid,
      .services-columns,
      .quick-steps,
      .prep-grid,
      .reviews-grid,
      .benefits-grid,
      .gallery-grid,
      .form-row {
        grid-template-columns: 1fr;
      }

      .days-grid,
      .masters-picker {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }

      .date-slider {
        grid-template-columns: 38px minmax(0, 1fr) 38px;
        gap: 8px;
      }

      .date-slider .calendar-nav,
      .month-picker .calendar-nav {
        width: 38px;
        height: 44px;
      }

      .days-grid {
        display: flex;
        gap: 8px;
        min-width: 0;
        overflow-x: auto;
        overscroll-behavior-x: contain;
        scroll-snap-type: x proximity;
        -webkit-overflow-scrolling: touch;
        padding: 2px 2px 8px;
      }

      .day-chip {
        flex: 0 0 clamp(54px, 13vw, 66px);
        min-height: 92px;
        padding: 12px 6px;
        scroll-snap-align: center;
      }

      .time-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }

      .booking-summary-head,
      .booking-total {
        align-items: flex-start;
      }

      .booking-summary-head {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
      }

      .booking-summary strong {
        font-size: 18px;
      }

      .section-text,
      .card p,
      .price-card p,
      .review-card p,
      .info-card p {
        font-size: 15px;
      }

      .form-card .btn {
        width: 100%;
      }

      .hero-actions .btn {
        justify-content: center;
      }

      .form-card {
        scroll-margin-top: 18px;
      }

      .hero-image {
        min-height: inherit;
      }

      .hero-image::after {
        background:
          linear-gradient(180deg, rgba(43, 36, 33, 0.42) 0%, rgba(43, 36, 33, 0.24) 40%, rgba(43, 36, 33, 0.68) 100%),
          linear-gradient(0deg, rgba(43, 36, 33, 0.32) 0%, rgba(43, 36, 33, 0) 42%);
      }

      .hero-image img {
        max-height: 760px;
      }

      .about-image img {
        min-height: 280px;
        border-radius: 16px;
      }

      .about-master-photo {
        min-height: 320px;
      }

      .mobile-round-cta {
        display: flex;
      }

      .section {
        padding: 52px 0;
      }

      .section-title {
        font-size: 30px;
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

      .gallery-slide img {
        height: clamp(420px, 122vw, 620px);
      }

      .gallery-nav {
        width: 38px;
        height: 38px;
        font-size: 24px;
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
        align-items: center;
      }

      .sticky-cta {
        width: calc(100% - 20px);
        bottom: calc(8px + env(safe-area-inset-bottom));
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 6px;
        padding: 6px;
        border-color: rgba(255, 255, 255, 0.28);
        background: rgba(43, 36, 33, 0.34);
        box-shadow: 0 10px 28px rgba(43, 36, 33, 0.14);
        opacity: 0.58;
        backdrop-filter: blur(10px);
      }

      .sticky-cta:focus-within,
      .sticky-cta:hover {
        background: rgba(43, 36, 33, 0.86);
        opacity: 1;
      }

      .sticky-cta .btn {
        min-height: 38px;
        padding: 8px 10px;
        border-color: rgba(255, 255, 255, 0.52);
        background: rgba(255, 255, 255, 0.06);
        font-size: 11px;
        letter-spacing: 0.02em;
        backdrop-filter: none;
      }

      .service-list-apparatus-wrap {
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 12px;
      }

      footer {
        padding-bottom: 76px;
      }
    }

    @media (max-width: 420px) {
      .service-list-apparatus-wrap {
        grid-template-columns: 1fr;
      }

      .service-list-apparatus-side {
        justify-items: start;
      }

      .nav-links {
        gap: 12px 14px;
        font-size: 11px;
        letter-spacing: 0.18em;
      }

      .mobile-location {
        font-size: 11px;
        letter-spacing: 0.18em;
      }

      .mobile-salon-name {
        max-width: 128px;
        font-size: 11px;
        letter-spacing: 0.08em;
      }

      .hero-card {
        padding: 0 46px 94px;
      }

      .hero-title {
        font-size: 28px;
        letter-spacing: 0.02em;
      }

      .hero-text {
        font-size: 15px;
        letter-spacing: 0.09em;
      }

      .hero-benefits {
        font-size: 15px;
        letter-spacing: 0.05em;
      }

      .sticky-cta .btn {
        min-height: 36px;
        padding: 7px 8px;
        font-size: 10px;
      }

      .mobile-round-cta {
        width: 112px;
        height: 112px;
        right: 14px;
        bottom: 22px;
        font-size: 17px;
      }
    }
  </style>
</head>
<body>
  <header class="topbar">
    <div class="container nav">
      <div class="mobile-brand-row" aria-label="Mobile header details">
        <div class="mobile-salon-name">Tsaruk Massage</div>

        <div class="mobile-location" aria-label="Location">
          <div class="mobile-location-head">
            <small>Місто</small>
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M12 21s7-5.4 7-12a7 7 0 0 0-14 0c0 6.6 7 12 7 12Z" stroke-width="1.8" />
              <path d="M12 12.2a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke-width="1.8" />
            </svg>
          </div>
          <span>Нова Одеса</span>
        </div>
      </div>

      <a class="logo" href="#home">Масаж у Новій Одесі</a>

      <div class="mobile-socials" aria-label="Instagram">
        <a href="https://www.instagram.com/massage_serhiy_tsaruk/" target="_blank" rel="noopener" aria-label="Instagram Сергія">
          <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <rect x="3.4" y="3.4" width="17.2" height="17.2" rx="5" stroke-width="2" />
            <path d="M12 15.8a3.8 3.8 0 1 0 0-7.6 3.8 3.8 0 0 0 0 7.6Z" stroke-width="2" />
            <path d="M17.4 6.8h.1" stroke-width="3" stroke-linecap="round" />
          </svg>
          <span>massage_serhiy_tsaruk</span>
        </a>
        <a href="https://www.instagram.com/massage_olesia_tsaruk/" target="_blank" rel="noopener" aria-label="Instagram Олесі">
          <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <rect x="3.4" y="3.4" width="17.2" height="17.2" rx="5" stroke-width="2" />
            <path d="M12 15.8a3.8 3.8 0 1 0 0-7.6 3.8 3.8 0 0 0 0 7.6Z" stroke-width="2" />
            <path d="M17.4 6.8h.1" stroke-width="3" stroke-linecap="round" />
          </svg>
          <span>massage_olesia_tsaruk</span>
        </a>
      </div>

      <nav class="nav-links">
        <a href="#services">Послуги</a>
        <a href="#prepare">Рекомендації</a>
        <a href="#reviews">Відгуки</a>
        <a href="#about">Про нас</a>
        <a href="#contact">Контакти</a>
        @if (auth()->check() && auth()->user()->isAdmin())
          <a href="{{ url('/admin') }}">Адмінка</a>
        @endif
      </nav>

      <a class="btn btn-primary" href="#booking">Записатися</a>
    </div>
  </header>

  <main>
    <section class="hero" id="home">
      <div class="container hero-grid">
        <div class="hero-card">
          <div class="eyebrow">Турбота про тіло • Розслаблення • Відновлення</div>
          <h1 class="hero-title">Поверни легкість уже після першого сеансу.</h1>
          <ul class="hero-benefits">
            <li>✓ Турбота про кожного клієнта</li>
            <li>✓ Атмосфера спокою</li>
            <li>✓ Масаж, після якого тіло дякує</li>
          </ul>

          <div class="hero-actions">
            <button type="button" class="btn btn-secondary" data-client-request-open>Отримати консультацію</button>
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
          <img src="{{ asset('images/hero-tsaruk-massage.png') }}" alt="Масажист Tsaruk Massage у кабінеті" />
          <div class="floating-box">
            <strong>Перший візит без зайвого стресу</strong>
            <p>Обери послугу, зручний час і залиш заявку за 1 хвилину.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="section services-section" id="services">
      <div class="container services-intro">
        <h2 class="section-title">Наші послуги</h2>
        <p class="section-text">Короткий список послуг наших майстрів</p>

        <div class="services-columns">
          @foreach (['Олеся', 'Сергій'] as $serviceMasterName)
            @php
              $serviceMaster = $masters->firstWhere('name', $serviceMasterName);
              $serviceItems = $serviceMaster
                  ? ($priceServicesByMaster[(string) $serviceMaster->id] ?? collect())
                  : collect();
            @endphp

            <article class="services-column">
              <h3>Майстер {{ $serviceMasterName }}</h3>
              <ul class="services-check-list">
                @forelse ($serviceItems as $service)
                  <li>
                    <span class="service-list-name">✓ {{ rtrim($service['display_label'] ?? $service['label'], ':') }}</span>

                    @if (! empty($service['is_apparatus_group']) && ! empty($service['apparatus_items']))
                      <div class="service-list-apparatus-wrap">
                        <div>
                          <span class="service-list-apparatus-label">Доступні апаратні масажі:</span>
                          <ul class="service-list-apparatus">
                            @foreach ($service['apparatus_items'] as $apparatusItem)
                              <li>{{ $apparatusItem }}</li>
                            @endforeach
                          </ul>
                        </div>
                        <div class="service-list-apparatus-side">
                          <span class="service-list-apparatus-price-label">Ціна:</span>
                          <span class="service-list-apparatus-price">1 хв - {{ number_format($service['minute_price'] ?? 10, 0, ',', ' ') }} грн</span>
                        </div>
                      </div>
                    @else
                      <span class="service-list-meta">
                        @if (! empty($service['duration_label']))
                        <span class="service-list-time">⏱ Тривалість сеансу: {{ $service['duration_label'] }}</span>
                        <span class="service-list-price">Ціна: {{ $service['price_label'] ?? number_format($service['price'] ?? 0, 0, ',', ' ') . ' грн' }}</span>
                        @endif
                      </span>
                    @endif
                  </li>
                @empty
                  <li>✓ Послуги скоро будуть додані</li>
                @endforelse
              </ul>
            </article>
          @endforeach

          <div class="services-details">
            <p>* Ви можете прочитати про кожен вид масажу тут</p>
            <div class="service-accordion">
              @php
                $serviceDescriptions = [
                    'Міопресура' => 'Поєднання тиску та апаратної стимуляції для розслаблення мʼязів, зняття болю та покращення рухливості.',
                    'Пресотерапія' => 'Апаратна компресія, яка стимулює лімфодренаж — чудова для зменшення набряків, втоми ніг і детоксикації.',
                    'Кавітація' => 'Ультразвук руйнує жирові клітини, допомагаючи зменшити обʼєми та покращити контури тіла.',
                    'RF-ліфтинг' => 'Радіохвилі стимулюють вироблення колагену — шкіра стає більш підтягнутою, еластичною, зменшуються зморшки.',
                    'RF- ліфтинг' => 'Радіохвилі стимулюють вироблення колагену — шкіра стає більш підтягнутою, еластичною, зменшуються зморшки.',
                    'Вакуумний масаж' => 'Глибоко опрацьовує тканини, покращує кровотік, розщеплює жирові відкладення, ефективний проти целюліту.',
                    'Ендосфера' => 'Мікровібрації та тиск покращують лімфотік, зменшують набряки, формують рельєф і підтягують тіло.',
                    'Медовий масаж' => 'Виводить токсини, стимулює обмін речовин, підтягує шкіру й добре працює для детоксикації організму.',
                    'Масаж обличчя' => 'Покращує тонус шкіри, стимулює кровообіг, має ліфтинговий ефект, зменшує набряки та сприяє омолодженню.',
                    'Класичний масаж (будь яка одна зона)' => 'Покращує кровообіг, знімає мʼязову напругу, розслабляє та допомагає відновитися після навантажень.',
                    'Класичний масаж (будь яка зона)' => 'Покращує кровообіг, знімає мʼязову напругу, розслабляє та допомагає відновитися після навантажень.',
                    'Загальний масаж тіла' => 'Покращує кровообіг, знімає мʼязову напругу, розслабляє та допомагає відновитися після навантажень.',
                    'Загальний масаж всього тіла' => 'Покращує кровообіг, знімає мʼязову напругу, розслабляє та допомагає відновитися після навантажень.',
                    'Антицелюлітний' => 'Спрямований на розбиття жирових відкладень, покращення мікроциркуляції та зменшення проявів «апельсинової кірки».',
                    'Антицелюлітний масаж' => 'Спрямований на розбиття жирових відкладень, покращення мікроциркуляції та зменшення проявів «апельсинової кірки».',
                    'Лімфодренаж' => 'Виводить зайву рідину, зменшує набряки, покращує роботу лімфатичної системи та сприяє полегшенню відчуття важкості.',
                    'Лімфодренажний' => 'Виводить зайву рідину, зменшує набряки, покращує роботу лімфатичної системи та сприяє полегшенню відчуття важкості.',
                    'Лімфодренажний масаж' => 'Виводить зайву рідину, зменшує набряки, покращує роботу лімфатичної системи та сприяє полегшенню відчуття важкості.',
                ];

                $serviceDetails = collect($serviceCards)
                    ->filter(fn (array $service): bool => ! empty($service['display_label'] ?? $service['label'] ?? null))
                    ->unique(fn (array $service): string => (string) ($service['display_label'] ?? $service['label']))
                    ->values();
              @endphp

              @foreach ($serviceDetails as $serviceDetail)
                @php
                  $serviceDetailTitle = rtrim($serviceDetail['display_label'] ?? $serviceDetail['label'], ':');
                  $serviceDetailDescription = $serviceDescriptions[$serviceDetailTitle]
                      ?? $serviceDetail['description']
                      ?? 'Детальний опис цієї послуги скоро буде додано.';
                @endphp
                <details @if ($loop->first) open @endif>
                  <summary>{{ $serviceDetailTitle }}</summary>
                  <p>{{ $serviceDetailDescription }}</p>
                </details>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section site-dark-section prepare-section" id="prepare">
      <div class="container">
        <h2 class="section-title">Рекомендації перед масажем</h2>
        <p class="section-text">
          Кілька простих кроків перед сеансом допоможуть зробити масаж комфортнішим і ефективнішим.
        </p>

        <div class="prep-grid">
          <article class="prep-card info-card">
            <h3><span>💡</span>Гігієна</h3>
            <ul>
              <li>Прийміть душ перед масажем, щоб освіжитись і зняти забруднення зі шкіри.</li>
            </ul>
          </article>

          <article class="prep-card info-card">
            <h3><span>💡</span>Одяг</h3>
            <ul>
              <li>Оберіть зручний одяг, який легко знімати й одягати після сеансу.</li>
            </ul>
          </article>

          <article class="prep-card info-card">
            <h3><span>💡</span>Прийом їжі</h3>
            <ul>
              <li>Уникайте щільного прийому їжі за 1-2 години до початку сеансу.</li>
            </ul>
          </article>

          <article class="prep-card info-card">
            <h3><span>💡</span>Самопочуття та здоровʼя</h3>
            <ul>
              <li>Якщо відчуваєте хворобу або нездужання, краще перенесіть сеанс.</li>
              <li>Обовʼязково попередьте про будь-які травми, алергії та хвороби.</li>
              <li>Забезпечте собі достатньо часу після сеансу, щоб не поспішати й дати організму відпочити.</li>
            </ul>
          </article>

          <article class="prep-card info-card">
            <h3><span>💡</span>Спілкування з масажистом</h3>
            <ul>
              <li>Висловлюйте свої побажання та повідомляйте про будь-який дискомфорт чи біль.</li>
            </ul>
          </article>
        </div>
      </div>
    </section>

    @if ($showQuickBookBlock ?? false)
    <section class="section quick-book-section">
      <div class="container">
        <div class="quick-book-card">
          <h2 class="section-title">Як записатись за 10 секунд на прийом:</h2>
          <p class="section-text">Обери майстра, послугу та зручний час. Заявка одразу потрапить до нас, а ми підтвердимо запис.</p>

          <div class="quick-steps">
            <div class="quick-step">
              <strong>1. Обери майстра.</strong>
              <p>Обери майстра Олесю або Сергія та обери послугу/дату/час.</p>
            </div>
            <div class="quick-step">
              <strong>2. Час</strong>
              <p>Натисни зручний день і вільний час у формі запису.</p>
            </div>
            <div class="quick-step">
              <strong>3. Контакти</strong>
              <p>Залиши ім'я й телефон, щоб ми швидко підтвердили сеанс.</p>
            </div>
          </div>

          <a class="btn services-more" href="#booking">Записатися на прийом</a>
        </div>
      </div>
    </section>
    @endif

    <section class="section site-dark-section gallery-section">
      <div class="container">
        <h2 class="section-title">Фото-галерея</h2>

        <div class="gallery-slider" data-gallery-slider>
          <button type="button" class="gallery-nav gallery-prev" data-gallery-prev aria-label="Попереднє фото">‹</button>
          <div class="gallery-viewport">
            <div class="gallery-track" data-gallery-track>
              @foreach ([
                ['file' => 'gallery-01', 'alt' => 'Олеся та Сергій виконують масаж'],
                ['file' => 'gallery-02', 'alt' => 'Сергій виконує масаж спини'],
                ['file' => 'gallery-03', 'alt' => 'Бамбуковий масаж спини'],
                ['file' => 'gallery-04', 'alt' => 'Ручний масаж спини'],
                ['file' => 'gallery-05', 'alt' => 'Сергій біля апарату для пресотерапії'],
                ['file' => 'gallery-06', 'alt' => 'Апаратні процедури в кабінеті'],
                ['file' => 'gallery-07', 'alt' => 'Апаратний догляд за обличчям'],
                ['file' => 'gallery-08', 'alt' => 'Олеся проводить процедуру для обличчя'],
                ['file' => 'gallery-09', 'alt' => 'Олеся виконує масаж'],
              ] as $photo)
                <div class="gallery-slide">
                  <img
                    src="{{ asset('images/gallery/' . $photo['file'] . '-1400.jpg') }}"
                    srcset="{{ asset('images/gallery/' . $photo['file'] . '-700.jpg') }} 700w, {{ asset('images/gallery/' . $photo['file'] . '-1400.jpg') }} 1400w"
                    sizes="(max-width: 760px) calc(100vw - 48px), 940px"
                    alt="{{ $photo['alt'] }}"
                    width="1400"
                    height="2100"
                    loading="lazy"
                    decoding="async"
                  />
                </div>
              @endforeach
            </div>
          </div>
          <button type="button" class="gallery-nav gallery-next" data-gallery-next aria-label="Наступне фото">›</button>
          <div class="gallery-dots" data-gallery-dots aria-label="Навігація галереї"></div>
        </div>
      </div>
    </section>

    <section class="section site-dark-section" id="about">
      <div class="container">
        <h2 class="section-title">Про нас</h2>

        <article class="about-master-card">
          <div class="about-master-photo">
            <img
              src="{{ asset('images/about/olesya-1200.jpg') }}"
              srcset="{{ asset('images/about/olesya-700.jpg') }} 700w, {{ asset('images/about/olesya-1200.jpg') }} 807w"
              sizes="(max-width: 760px) calc(100vw - 48px), 360px"
              alt="Майстер Олеся"
              width="807"
              height="1034"
              loading="lazy"
              decoding="async"
            />
          </div>

          <div class="about-master-content">
            <div class="about-master-kicker">Майстер Олеся</div>
            <h3>Турбота, делікатність і професійний підхід</h3>
            <div class="about-master-text" id="olesya-about-text" data-about-text>
              <p>
                Я — Олеся, масажист із вищою освітою у сфері фізичного виховання. Я ціную довіру своїх клієнтів і прагну, щоб кожен візит був не просто процедурою, а приємним досвідом турботи про себе.
              </p>
              <p>Найбільше я спеціалізуюсь на релаксуючих масажах, процедурах для підтяжки обличчя та покращення тонусу тіла. У своїй роботі люблю поєднувати делікатність і турботу до клієнта. Вмію просто й зрозуміло пояснити все, що стосується процедур, догляду за тілом чи обличчям.</p>
              <p>Якщо у вас є сумніви щодо вибору масажу чи процедур, перед записом ви завжди можете проконсультуватися зі мною, і я допоможу підібрати саме те, що найкраще підійде для вашого стану та побажань.</p>
            </div>

            <button type="button" class="about-expand" data-about-toggle aria-expanded="false" aria-controls="olesya-about-text">
              <span class="about-expand-icon" aria-hidden="true"></span>
              <span class="toggle-closed">Розгорнути інформацію</span>
              <span class="toggle-open">Згорнути інформацію</span>
            </button>
          </div>
        </article>

        <article class="about-master-card about-master-card--reverse">
          <div class="about-master-photo">
            <img
              src="{{ asset('images/about/sergiy-1400.jpg') }}"
              srcset="{{ asset('images/about/sergiy-700.jpg') }} 700w, {{ asset('images/about/sergiy-1400.jpg') }} 1400w"
              sizes="(max-width: 760px) calc(100vw - 48px), 360px"
              alt="Майстер Сергій"
              width="1400"
              height="2100"
              loading="lazy"
              decoding="async"
            />
          </div>

          <div class="about-master-content">
            <div class="about-master-kicker">Майстер Сергій</div>
            <h3>Досвід, уважність і результативний масаж</h3>
            <div class="about-master-text" id="sergiy-about-text" data-about-text>
              <p>Я — Сергій, у нашому містечку мене часто знають як Сергія Юрійовича. Понад 15 років працював керівником фізичного виховання, тому добре знаю анатомію людини, причини болю та затисків у тілі.</p>
              <p>Більше 3 років професійно займаюсь масажем. Працюю не на кількість, а на результат — щоб після сеансу ви реально відчули ефект масажу.</p>
              <p>Я завжди уважно вислухаю вашу проблему, підберу підхід саме під ваш стан та, за потреби, підкажу вправи для підтримки здоровʼя вашого тіла.</p>
              <p>Про мою роботу найкраще говорять відгуки клієнтів, з якими можете ознайомитись тут на сайті.</p>
              <p>Знаю, що для жінок масаж у чоловіка може спочатку викликати дискомфорт, але запевняю: я завжди працюю професійно та з повагою до особистих меж клієнта.</p>
              <p>Моя дружина Олеся також масажист, тому якщо вам більше комфортний жіночий майстер або ви хочете релаксуючий масаж тіла чи обличчя — можете звернутись і до неї.</p>
            </div>

            <button type="button" class="about-expand" data-about-toggle aria-expanded="false" aria-controls="sergiy-about-text">
              <span class="about-expand-icon" aria-hidden="true"></span>
              <span class="toggle-closed">Розгорнути інформацію</span>
              <span class="toggle-open">Згорнути інформацію</span>
            </button>
          </div>
        </article>
      </div>
    </section>

    <section class="section site-dark-section" id="reviews">
      <div class="container">
        <div class="reviews-head">
          <h2 class="section-title">Відгуки клієнтів</h2>
          <button type="button" class="btn btn-primary" data-review-open>Залишити відгук</button>
        </div>

        @php
          $reviewChunks = $reviews->chunk(3)->values();
        @endphp

        <div class="reviews-pages" data-reviews-pages>
          @foreach ($reviewChunks as $chunk)
            <div class="reviews-grid reviews-page" data-review-page="{{ $loop->index }}" @if (! $loop->first) hidden @endif>
              @foreach ($chunk as $review)
                <article class="review-card">
                  <div class="stars rating-stars" style="--rating: {{ (float) $review['rating'] }}" aria-label="Оцінка {{ number_format((float) $review['rating'], 1, '.', '') }} з 5"></div>
                  <p>{{ $review['text'] }}</p>
                  <div class="review-meta">
                    @if (! empty($review['master_name']))
                      <span>Майстер: {{ $review['master_name'] }}</span>
                    @endif
                    @if (! empty($review['published_date']))
                      <span>{{ $review['published_date'] }}</span>
                    @endif
                  </div>
                  <div class="review-author">— {{ $review['client_name'] }}</div>
                </article>
              @endforeach
            </div>
          @endforeach
        </div>

        @if ($reviewChunks->count() > 1)
          <div class="reviews-pagination" data-reviews-pagination aria-label="Сторінки відгуків">
            <button type="button" class="review-page-arrow" data-review-prev aria-label="Попередня сторінка відгуків">‹</button>
            @foreach ($reviewChunks as $chunk)
              <button type="button" class="review-page-dot {{ $loop->first ? 'active' : '' }}" data-review-page-btn="{{ $loop->index }}" aria-label="Сторінка {{ $loop->iteration }}"></button>
            @endforeach
            <button type="button" class="review-page-arrow" data-review-next aria-label="Наступна сторінка відгуків">›</button>
          </div>
        @endif
      </div>
    </section>

    <div class="message-popup" id="review-popup" hidden role="dialog" aria-modal="true" aria-labelledby="review-popup-title">
      <div class="message-popup-backdrop" data-review-close></div>
      <div class="message-popup-dialog review-popup-dialog">
        <button type="button" class="message-popup-close" data-review-close aria-label="Закрити відгук">×</button>
        <strong id="review-popup-title">Залишити відгук</strong>
        <form class="review-form" method="POST" action="{{ route('reviews.store') }}">
          @csrf

          @if ($errors->review->any())
            <div class="review-form-errors">
              @foreach ($errors->review->all() as $error)
                <span>{{ $error }}</span>
              @endforeach
            </div>
          @endif

          <label>
            Ім'я
            <input type="text" name="client_name" placeholder="Введіть Ваше ім'я" value="{{ old('client_name') }}" minlength="2" maxlength="80" required />
          </label>

          <label>
            Майстер
            <select name="master_id" required>
              <option value="">Оберіть майстра</option>
              @foreach ($masters as $master)
                <option value="{{ $master->id }}" @selected((string) old('master_id') === (string) $master->id)>
                  {{ $master->name }}
                </option>
              @endforeach
            </select>
          </label>

          <label>
            Текст відгуку
            <textarea name="text" placeholder="Напишіть Ваш відгук про масаж" maxlength="2000" required>{{ old('text') }}</textarea>
          </label>

          <label class="review-rating-control">
            Яку оцінку за масаж ставите?
            <span class="review-rating-row">
              <button type="button" class="review-stars-picker" data-review-stars aria-label="Оберіть оцінку від 0 до 5 зірок">
                @for ($i = 1; $i <= 5; $i++)
                  <span class="review-star-option" data-review-star="{{ $i }}"></span>
                @endfor
              </button>
              <span class="review-rating-value" data-review-rating-value>{{ old('rating', 5) }}</span>
            </span>
            <input type="hidden" name="rating" value="{{ old('rating', 5) }}" data-review-rating />
            <small>Натисніть на ліву або праву половину зірки, щоб поставити оцінку з кроком 0.5.</small>
          </label>

          <button type="submit" class="btn btn-primary">Надіслати відгук</button>
        </form>
      </div>
    </div>

    <div class="message-popup" id="review-success-popup" hidden role="dialog" aria-modal="true" aria-labelledby="review-success-title">
      <div class="message-popup-backdrop" data-review-success-close></div>
      <div class="message-popup-dialog">
        <strong id="review-success-title">Дякую за відгук!</strong>
        <p id="review-success-text"></p>
        <div class="message-popup-actions">
          <button type="button" class="btn btn-primary" data-review-success-close>Зрозуміло</button>
        </div>
      </div>
    </div>

    @if (false)
    <section class="section site-dark-section prepare-section" id="prepare">
      <div class="container">
        <h2 class="section-title">Рекомендації перед масажем</h2>
        <p class="section-text">
          Кілька простих кроків перед сеансом допоможуть зробити масаж комфортнішим і ефективнішим.
        </p>

        <div class="prep-grid">
          <article class="prep-card info-card">
            <h3><span>💡</span>Гігієна</h3>
            <ul>
              <li>Прийміть душ перед масажем, щоб освіжитись і зняти забруднення зі шкіри.</li>
            </ul>
          </article>

          <article class="prep-card info-card">
            <h3><span>💡</span>Одяг</h3>
            <ul>
              <li>Оберіть зручний одяг, який легко знімати й одягати після сеансу.</li>
            </ul>
          </article>

          <article class="prep-card info-card">
            <h3><span>💡</span>Прийом їжі</h3>
            <ul>
              <li>Уникайте щільного прийому їжі за 1-2 години до початку сеансу.</li>
            </ul>
          </article>

          <article class="prep-card info-card">
            <h3><span>💡</span>Самопочуття та здоровʼя</h3>
            <ul>
              <li>Якщо відчуваєте хворобу або нездужання, краще перенесіть сеанс.</li>
              <li>Обовʼязково попередьте про будь-які травми, алергії та хвороби.</li>
              <li>Забезпечте собі достатньо часу після сеансу, щоб не поспішати й дати організму відпочити.</li>
            </ul>
          </article>

          <article class="prep-card info-card">
            <h3><span>💡</span>Спілкування з масажистом</h3>
            <ul>
              <li>Висловлюйте свої побажання та повідомляйте про будь-який дискомфорт чи біль.</li>
            </ul>
          </article>
        </div>
      </div>
    </section>

    @endif

    @if (false)
    <section class="section site-dark-section" id="about">
      <div class="container">
        <h2 class="section-title">Про мене</h2>
        <p class="section-text">
          Ми працюємо уважно, професійно й з повагою до особистих меж клієнта.
        </p>

        <div class="about-profiles">
          <article class="about-profile-card hero-card">
            <h3>Сергій</h3>
            <div class="about-profile-text">
              <p>Я — Сергій, у нашому містечку мене часто знають як Сергія Юрійовича. Понад 15 років працював керівником фізичного виховання, тому добре знаю анатомію людини, причини болю та затисків у тілі.</p>
              <p>Більше 3 років професійно займаюсь масажем. Працюю не на кількість, а на результат, щоб після сеансу ви реально відчули ефект масажу.</p>
              <p>Я завжди уважно вислухаю вашу проблему, підберу підхід саме під ваш стан та, за потреби, підкажу вправи для підтримки здоровʼя вашого тіла.</p>
              <p>Про мою роботу найкраще говорять відгуки клієнтів, з якими можете ознайомитись тут на сайті.</p>
              <p>Знаю, що для жінок масаж у чоловіка може спочатку викликати дискомфорт, але запевняю: я завжди працюю професійно та з повагою до особистих меж клієнта.</p>
              <p>Моя дружина Олеся також масажист, тому якщо вам більше комфортний жіночий майстер або ви хочете релаксуючий масаж тіла чи обличчя, можете звернутись і до неї.</p>
            </div>
          </article>

          <article class="about-profile-card hero-card">
            <h3>Олеся</h3>
            <div class="about-profile-text">
              <p>Я — Олеся, масажист із вищою освітою у сфері фізичного виховання. Я ціную довіру своїх клієнтів і прагну, щоб кожен візит був не просто процедурою, а приємним досвідом турботи про себе.</p>
              <p>Найбільше я спеціалізуюсь на релаксуючих масажах, процедурах для підтяжки обличчя та покращення тонусу тіла. У своїй роботі люблю поєднувати делікатність і турботу до клієнта.</p>
              <p>Вмію просто й зрозуміло пояснити все, що стосується процедур, догляду за тілом чи обличчям.</p>
              <p>Якщо у вас є сумніви щодо вибору масажу чи процедур, перед записом ви завжди можете проконсультуватися зі мною, і я допоможу підібрати саме те, що найкраще підійде для вашого стану та побажань.</p>
            </div>
          </article>
        </div>
      </div>
    </section>

    @endif

    <section class="section site-dark-section" id="contact">
      <div class="container">
        <h2 class="section-title">Контакти</h2>

        <div class="contact-grid">
          <div class="info-card large">
            <h3>Інформація</h3>

            <div class="contact-list">
              <div class="contact-item">
                <strong>Телефон</strong>
                <span>Олеся: <a href="tel:+380678764183">+380 (67) 876-41-83</a></span>
                <span>Сергій: <a href="tel:+380966059823">+380 (96) 605-98-23</a></span>
              </div>
              <div class="contact-item">
                <strong>Instagram</strong>
                <span><a href="https://www.instagram.com/massage_serhiy_tsaruk/" target="_blank" rel="noopener">@massage_serhiy_tsaruk</a></span>
                <span><a href="https://www.instagram.com/massage_olesia_tsaruk/" target="_blank" rel="noopener">@massage_olesia_tsaruk</a></span>
              </div>
              <div class="contact-item">
                <strong>Адреса</strong>
                <span>м. Нова Одеса 56-600, вул. Сапроненко 8</span>
              </div>
              <div class="contact-item">
                <strong>Графік</strong>
                <span>{{ $bookingConfig['scheduleLabel'] }}</span>
              </div>
            </div>

            <div class="map-box">
              <iframe src="https://www.google.com/maps?q=%D0%BC.%20%D0%9D%D0%BE%D0%B2%D0%B0%20%D0%9E%D0%B4%D0%B5%D1%81%D0%B0%2056-600%2C%20%D0%B2%D1%83%D0%BB.%20%D0%A1%D0%B0%D0%BF%D1%80%D0%BE%D0%BD%D0%B5%D0%BD%D0%BA%D0%BE%208&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              <a class="btn btn-secondary map-link" href="https://maps.app.goo.gl/rEQXh84ndFvyroz79?g_st=it" target="_blank" rel="noopener">Відкрити на карті</a>
            </div>
          </div>

          <div id="booking-inline-slot" hidden></div>
          <div class="form-card" id="booking">
            <h3 id="booking-modal-title">Записатися на прийом</h3>
            <p>Оберіть майстра, послугу, день і час для запису на прийом. Після цього залиште контакти для підтвердження прийому.</p>

            <form id="bookingForm" method="POST" action="{{ route('booking.store') }}">
              @csrf

              <input type="hidden" name="service" id="service_input" value="{{ old('service') }}">
              <input type="hidden" name="master_id" id="master_id" value="{{ old('master_id') }}">
              <input type="hidden" name="appointment_date" id="appointment_date" value="{{ old('appointment_date') }}">
              <input type="hidden" name="appointment_time" id="appointment_time" value="{{ old('appointment_time') }}">
              <input type="hidden" name="apparatus_discuss" id="apparatus_discuss" value="{{ old('apparatus_discuss') }}">
              <input type="hidden" name="apparatus_duration_minutes" id="apparatus_duration_minutes" value="{{ old('apparatus_duration_minutes') }}">

              <div class="booking-flow">
                <div class="booking-block">
                  <h4>1. Оберіть майстра</h4>
                  <div class="masters-picker" id="masters-picker">
                    @foreach ($masters as $master)
                      @php
                        $masterPhone = match ($master->name) {
                            'Олеся' => '+380 (67) 876-41-83',
                            'Сергій' => '+380 (96) 605-98-23',
                            default => $master->phone ?: 'Онлайн запис',
                        };
                      @endphp
                      <button
                        type="button"
                        class="master-option {{ (string) old('master_id') === (string) $master->id ? 'active' : '' }}"
                        data-master-id="{{ $master->id }}"
                        data-master-name="{{ $master->name }}"
                        {{ $masters->isEmpty() ? 'disabled' : '' }}
                      >
                        <strong>{{ $master->name }}</strong>
                        <div class="master-meta">
                          <span>{{ $masterPhone }}</span>
                        </div>
                      </button>
                    @endforeach
                  </div>
                </div>

                <div class="booking-block" id="services-block" {{ old('master_id') ? '' : 'hidden' }}>
                  <h4>2. Оберіть до 3 послуг</h4>
                  <div class="slot-hint" id="services-selection-hint">Можна одразу обрати 1-3 послуги. Перша послуга буде основною, інші додадуться до цього ж запису.</div>
                  <div class="services-picker" id="services-picker">
                    @foreach ($serviceCards as $service)
                      <button
                        type="button"
                        class="service-option {{ old('service') === ($service['key'] ?? '') ? 'active' : '' }}"
                        data-master-id="{{ $service['master_id'] ?? '' }}"
                        data-service-key="{{ $service['key'] ?? '' }}"
                        data-service-kind="{{ ! empty($service['uses_duration_picker']) ? 'apparatus' : 'regular' }}"
                        data-apparatus-base="{{ $service['apparatus_base'] ?? '' }}"
                        data-apparatus-variants='@json($service['variants'] ?? [])'
                        data-service-label="{{ $service['label'] ?? '' }}"
                        data-service-price="{{ $service['price'] ?? 0 }}"
                        data-service-duration="{{ $service['duration'] ?? '' }}"
                      >
                        <strong>{{ $service['display_label'] ?? $service['label'] ?? 'Послуга' }}</strong>
                        <span class="service-order" aria-hidden="true"></span>
                        <div class="service-meta">
                          <span>{{ ! empty($service['uses_duration_picker']) ? '1 хв - ' . ($service['price'] ?? 0) . ' грн' : number_format($service['price'] ?? 0, 0, ',', ' ') . ' грн' }}</span>
                          <span>{{ $service['duration'] ?? '' }}</span>
                          @if (! empty($service['badge']))
                            <span class="service-badge">{{ $service['badge'] }}</span>
                          @endif
                        </div>
                        <p>{{ $service['description'] ?? '' }}</p>
                      </button>
                    @endforeach
                  </div>
                  <div class="empty-state" id="services-empty" hidden>Для цього майстра послуги ще не додані.</div>
                  <div class="apparatus-duration-box" id="apparatus-duration-box" hidden>
                    <strong id="apparatus-duration-title">Оберіть тривалість апаратного масажу</strong>
                    <div class="apparatus-duration-options" id="apparatus-duration-options"></div>
                    <button type="button" class="apparatus-discuss-btn" id="apparatus-discuss-btn">Обговорити час з майстром на прийомі</button>
                    <small>Якщо обрати “обговорити час”, вікно буде заброньовано на 60 хв.</small>
                  </div>
                  <div id="additional-services-inputs"></div>
                  <div class="services-section-label" id="selected-services-label" hidden>Обрано</div>
                  <div class="selected-services-list" id="selected-services-list"></div>
                </div>

                <div class="booking-block" id="date-time-block" {{ old('master_id') && old('service') ? '' : 'hidden' }}>
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

                  <div class="slot-hint" id="slot-hint" style="margin-top: 14px;">Оберіть майстра, а потім послугу, щоб побачити доступний час.</div>

                  <div class="time-grid is-disabled" id="time-grid"></div>
                </div>

                <div class="booking-block" id="additional-services-block" {{ old('master_id') && old('service') ? '' : 'hidden' }}>
                  <div class="booking-block-header">
                    <h4 style="margin: 0;">4. Додаткові послуги</h4>
                    <button type="button" class="btn btn-secondary add-service-trigger" id="add-service-trigger">+ Додати ще послугу</button>
                  </div>

                  <div class="slot-hint" id="additional-services-hint">Після вибору часу ви зможете додати ще одну або кілька послуг до запису.</div>
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
                    <small></small>
                  </div>
                </div>

                <div class="booking-block">
                  <h4>Введіть Ваші данні для запису на послугу:</h4>
                  <div class="contact-fields">
                    <input type="text" name="client_name" placeholder="Введіть Ваше ім'я" value="{{ old('client_name') }}" autocomplete="name" minlength="2" maxlength="80" required />
                    <input type="tel" name="phone" placeholder="Введіть Ваш номер телефону для зв'язку з Вами" value="{{ old('phone', '+380') }}" autocomplete="tel" inputmode="tel" maxlength="19" data-phone-mask required />
                    <input type="text" name="social_contact" placeholder="Введіть Telegram / Instagram / Viber" value="{{ old('social_contact') }}" required />
                    <textarea name="message" placeholder="Коментар до запису: можливо, маєте питання або побажання">{{ old('message') }}</textarea>
                    <button class="btn btn-primary" type="submit" {{ $masters->isEmpty() ? 'disabled' : '' }}>Підтвердити запис</button>
                  </div>
                </div>
              </div>
            </form>

            <div class="message-popup" id="booking-message-popup" hidden role="dialog" aria-modal="true" aria-labelledby="booking-message-title">
              <div class="message-popup-backdrop" data-popup-close></div>
              <div class="message-popup-dialog">
                <strong id="booking-message-title">Повідомлення</strong>
                <p id="booking-message-text"></p>
                <div class="message-popup-actions" id="booking-message-actions">
                  <button type="button" class="btn btn-secondary" id="booking-message-confirm" hidden>Все вірно, записатись</button>
                  <button type="button" class="btn btn-primary" id="booking-message-close">Зрозуміло</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <button type="button" class="floating-booking-btn" data-booking-modal-open>
    Записатись
  </button>

  <div class="booking-modal" id="booking-modal" hidden role="dialog" aria-modal="true" aria-labelledby="booking-modal-title">
    <div class="booking-modal-backdrop" data-booking-modal-close></div>
    <div class="booking-modal-dialog">
      <button type="button" class="booking-modal-close" data-booking-modal-close aria-label="Закрити форму запису">×</button>
      <div class="booking-modal-slot" id="booking-modal-slot"></div>
    </div>
  </div>

  <div class="message-popup" id="client-request-popup" hidden role="dialog" aria-modal="true" aria-labelledby="client-request-title">
    <div class="message-popup-backdrop" data-client-request-close></div>
    <div class="message-popup-dialog review-popup-dialog">
      <button type="button" class="message-popup-close" data-client-request-close aria-label="Закрити форму консультації">×</button>
      <strong id="client-request-title">Отримати консультацію</strong>
      <small>Залиште контакти, і ми зателефонуємо, щоб допомогти обрати майстра та зручний час.</small>

      @if ($errors->clientRequest->any())
        <div class="review-form-errors">
          <ul>
            @foreach ($errors->clientRequest->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="review-form-errors" id="client-request-errors" hidden></div>

      <form class="review-form client-request-form" id="client-request-form" method="POST" action="{{ route('client-requests.store') }}">
        @csrf
        <label>
          Майстер
          <select name="master_id" required>
            <option value="">Оберіть майстра</option>
            @foreach ($masters as $master)
              <option value="{{ $master->id }}" @selected((string) old('master_id') === (string) $master->id)>{{ $master->name }}</option>
            @endforeach
          </select>
        </label>
        <label>
          Ім'я
          <input type="text" name="client_name" placeholder="Введіть Ваше ім'я" value="{{ old('client_name') }}" autocomplete="name" minlength="2" maxlength="80" required>
        </label>
        <label>
          Номер телефону
          <input type="tel" name="phone" placeholder="Введіть Ваш номер телефону для зв'язку з Вами" value="{{ old('phone', '+380') }}" autocomplete="tel" inputmode="tel" maxlength="19" data-phone-mask required>
        </label>
        <button type="submit" class="btn btn-primary" {{ $masters->isEmpty() ? 'disabled' : '' }}>Залишити запит на зворотний дзвінок</button>
      </form>
    </div>
  </div>

  <footer>
    <div class="container footer-box">
      <div>© 2026 Massage Tsruk. Всі права захищені.</div>
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
    const apparatusDiscussInput = document.getElementById('apparatus_discuss');
    const apparatusDurationInput = document.getElementById('apparatus_duration_minutes');
    const slotHint = document.getElementById('slot-hint');
    const servicesBlock = document.getElementById('services-block');
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
    const monthPicker = monthPrev.closest('.month-picker');
    const dateSlider = daysPrev.closest('.date-slider');
    const summaryService = document.getElementById('summary-service');
    const summaryAdditional = document.getElementById('summary-additional');
    const summaryMaster = document.getElementById('summary-master');
    const summaryPrice = document.getElementById('summary-price');
    const summaryDatetime = document.getElementById('summary-datetime');
    const summaryDuration = document.getElementById('summary-duration');

    const servicesByKey = Object.fromEntries(services.map((service) => [service.key, service]));

    const makeDate = (value) => new Date(`${value}T00:00:00`);
    const formatMonthKey = (date) => `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
    const formatDateKey = (date) => `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
    const minDate = makeDate(bookingConfig.minDate);
    const maxDate = makeDate(bookingConfig.maxDate);
    const monthKeys = [];
    const cursor = new Date(minDate.getFullYear(), minDate.getMonth(), 1);
    const lastMonth = new Date(maxDate.getFullYear(), maxDate.getMonth(), 1);

    while (cursor <= lastMonth) {
      monthKeys.push(formatMonthKey(cursor));
      cursor.setMonth(cursor.getMonth() + 1);
    }

    const initialDate = oldValues.service ? (oldValues.appointment_date || bookingConfig.minDate) : '';
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
          iso: formatDateKey(current),
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

    const renderServicesBlockVisibility = () => {
      servicesBlock.hidden = !state.masterId;
    };

    const renderDays = () => {
      setCalendarNavVisible(Boolean(state.service && state.masterId));

      if (!state.service || !state.masterId) {
        dayGrid.innerHTML = `<div class="empty-state" style="grid-column: 1 / -1;">${state.masterId ? 'Оберіть послугу, щоб побачити дату та час.' : 'Оберіть майстра.'}</div>`;
        daysPrev.disabled = true;
        daysNext.disabled = true;
        monthPrev.disabled = true;
        monthNext.disabled = true;
        slotHint.textContent = state.masterId ? 'Після вибору послуги відкриються доступні дати та час.' : 'Спочатку оберіть майстра.';
        return;
      }

      const allDays = getMonthDays(state.monthKey);
      const start = state.dayPage * pageSizeDays;
      const visibleDays = allDays.slice(start, start + pageSizeDays);
      const monthDate = getCurrentMonthDate();

      dayGrid.innerHTML = '';
      monthLabel.textContent = new Intl.DateTimeFormat('uk-UA', { month: 'long', year: 'numeric' }).format(monthDate);
      rangeLabel.textContent = `Доступно до ${bookingConfig.maxDate}`;

      if (!state.service) {
        dayGrid.innerHTML = '<div class="empty-state" style="grid-column: 1 / -1;">Спочатку оберіть послугу, щоб побачити правильні дати.</div>';
        daysPrev.disabled = true;
        daysNext.disabled = true;
        monthPrev.disabled = true;
        monthNext.disabled = true;
        slotHint.textContent = 'Дати та час відкриються після вибору послуги.';
        return;
      }

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

          clearBookingError();
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
      if (!state.service || !state.masterId) {
        timeGrid.classList.add('is-disabled');
        timeGrid.innerHTML = '';
        slotHint.textContent = state.masterId ? 'Після вибору послуги відкриється доступний час.' : 'Спочатку оберіть майстра.';
        renderAdditionalServices();
        return;
      }

      timeGrid.innerHTML = '';
      const consumedSlots = getConsumedSlots();

      if (!state.service) {
        timeGrid.classList.add('is-disabled');
        timeGrid.innerHTML = '<div class="empty-state" style="grid-column: 1 / -1;">Спочатку оберіть послугу.</div>';
        slotHint.textContent = 'Дати та час відкриються після вибору послуги.';
        renderAdditionalServices();
        return;
      }

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

      if (!state.service || !state.masterId) {
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
      if (!state.service || !state.masterId || !state.date) {
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

    priceMasterTabs.forEach((tab) => {
      tab.addEventListener('click', () => {
        renderPriceMasterGroups(tab.dataset.priceMaster || '');
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
      const initialService = servicesByKey[state.service];

      if (initialService?.apparatus_base) {
        const apparatusCard = [...serviceCards].find((element) => (
          element.dataset.masterId === state.masterId && element.dataset.apparatusBase === initialService.apparatus_base
        ));
        state.apparatusBase = initialService.apparatus_base;
        state.apparatusVariants = apparatusCard ? JSON.parse(apparatusCard.dataset.apparatusVariants || '[]') : [];
        state.apparatusDiscuss = apparatusDiscussInput.value === '1';
        setActiveCard(serviceCards, (element) => element === apparatusCard);
      } else {
        setActiveCard(serviceCards, (element) => element.dataset.serviceKey === state.service);
      }
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
    (() => {
      const pages = [...document.querySelectorAll('[data-review-page]')];
      const buttons = [...document.querySelectorAll('[data-review-page-btn]')];
      const prevButton = document.querySelector('[data-review-prev]');
      const nextButton = document.querySelector('[data-review-next]');
      let activeReviewPage = 0;

      const setReviewPage = (index) => {
        activeReviewPage = Math.max(0, Math.min(pages.length - 1, index));

        pages.forEach((page) => {
          page.hidden = Number(page.dataset.reviewPage) !== activeReviewPage;
        });

        buttons.forEach((button) => {
          button.classList.toggle('active', Number(button.dataset.reviewPageBtn) === activeReviewPage);
        });

        if (prevButton) {
          prevButton.disabled = activeReviewPage === 0;
        }

        if (nextButton) {
          nextButton.disabled = activeReviewPage === pages.length - 1;
        }
      };

      buttons.forEach((button) => {
        button.addEventListener('click', () => setReviewPage(Number(button.dataset.reviewPageBtn)));
      });

      prevButton?.addEventListener('click', () => setReviewPage(activeReviewPage - 1));
      nextButton?.addEventListener('click', () => setReviewPage(activeReviewPage + 1));
      setReviewPage(0);

      const reviewPopup = document.getElementById('review-popup');
      const reviewSuccessPopup = document.getElementById('review-success-popup');
      const reviewSuccessText = document.getElementById('review-success-text');
      const ratingInput = document.querySelector('[data-review-rating]');
      const ratingPicker = document.querySelector('[data-review-stars]');
      const ratingStars = [...document.querySelectorAll('[data-review-star]')];
      const ratingValue = document.querySelector('[data-review-rating-value]');
      const reviewSuccess = @json(session('review_success'));
      const hasReviewErrors = @json($errors->review->any());

      const openReviewPopup = () => {
        if (!reviewPopup) {
          return;
        }

        reviewPopup.hidden = false;
        reviewPopup.querySelector('input, textarea, button')?.focus();
      };

      const closeReviewPopup = () => {
        if (reviewPopup) {
          reviewPopup.hidden = true;
        }
      };

      const openReviewSuccess = (message) => {
        if (!reviewSuccessPopup || !reviewSuccessText) {
          return;
        }

        reviewSuccessText.textContent = message;
        reviewSuccessPopup.hidden = false;
        reviewSuccessPopup.querySelector('button')?.focus();
      };

      const closeReviewSuccess = () => {
        if (reviewSuccessPopup) {
          reviewSuccessPopup.hidden = true;
        }
      };

      const syncRating = () => {
        if (!ratingInput || !ratingValue) {
          return;
        }

        const rating = Number(ratingInput.value);

        ratingStars.forEach((star) => {
          const index = Number(star.dataset.reviewStar);
          const fill = Math.max(0, Math.min(1, rating - (index - 1)));
          star.style.setProperty('--fill', `${fill * 100}%`);
        });

        ratingValue.textContent = rating.toFixed(Number.isInteger(rating) ? 0 : 1);
        ratingPicker?.setAttribute('aria-label', `Оцінка ${ratingValue.textContent} з 5`);
      };

      const setRating = (rating) => {
        if (!ratingInput) {
          return;
        }

        const normalizedRating = Math.max(0, Math.min(5, Math.round(rating * 2) / 2));
        ratingInput.value = normalizedRating.toFixed(Number.isInteger(normalizedRating) ? 0 : 1);
        syncRating();
      };

      document.querySelectorAll('[data-review-open]').forEach((button) => {
        button.addEventListener('click', openReviewPopup);
      });

      document.querySelectorAll('[data-review-close]').forEach((element) => {
        element.addEventListener('click', closeReviewPopup);
      });

      document.querySelectorAll('[data-review-success-close]').forEach((element) => {
        element.addEventListener('click', closeReviewSuccess);
      });

      ratingStars.forEach((star) => {
        star.addEventListener('click', (event) => {
          const rect = star.getBoundingClientRect();
          const index = Number(star.dataset.reviewStar);
          const isLeftHalf = event.clientX - rect.left <= rect.width / 2;

          setRating(index - (isLeftHalf ? 0.5 : 0));
        });
      });

      ratingPicker?.addEventListener('keydown', (event) => {
        if (!['ArrowLeft', 'ArrowDown', 'ArrowRight', 'ArrowUp', 'Home', 'End'].includes(event.key)) {
          return;
        }

        event.preventDefault();
        const currentRating = Number(ratingInput?.value || 5);

        if (event.key === 'Home') {
          setRating(0);
        } else if (event.key === 'End') {
          setRating(5);
        } else if (event.key === 'ArrowLeft' || event.key === 'ArrowDown') {
          setRating(currentRating - 0.5);
        } else {
          setRating(currentRating + 0.5);
        }
      });

      syncRating();

      if (hasReviewErrors) {
        openReviewPopup();
      }

      if (reviewSuccess) {
        openReviewSuccess(reviewSuccess);
      }

      document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') {
          return;
        }

        closeReviewPopup();
        closeReviewSuccess();
      });
    })();
  </script>

  <script>
    (() => {
      document.querySelectorAll('.service-accordion').forEach((accordion) => {
        accordion.querySelectorAll('details').forEach((details) => {
          details.addEventListener('toggle', () => {
            if (!details.open) {
              return;
            }

            accordion.querySelectorAll('details[open]').forEach((opened) => {
              if (opened !== details) {
                opened.open = false;
              }
            });
          });
        });
      });
    })();
  </script>

  <script>
    (() => {
      document.querySelectorAll('[data-about-toggle]').forEach((toggle) => {
        const textId = toggle.getAttribute('aria-controls');
        const text = textId ? document.getElementById(textId) : null;

        if (!text) {
          return;
        }

        toggle.addEventListener('click', () => {
          const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
          toggle.setAttribute('aria-expanded', String(!isExpanded));
          text.classList.toggle('is-expanded', !isExpanded);
        });
      });
    })();
  </script>

  <script>
    (() => {
      const slider = document.querySelector('[data-gallery-slider]');

      if (!slider) {
        return;
      }

      const track = slider.querySelector('[data-gallery-track]');
      const slides = [...slider.querySelectorAll('.gallery-slide')];
      const prev = slider.querySelector('[data-gallery-prev]');
      const next = slider.querySelector('[data-gallery-next]');
      const dotsWrap = slider.querySelector('[data-gallery-dots]');
      let activeIndex = 0;

      const dots = slides.map((_, index) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = `gallery-dot${index === 0 ? ' active' : ''}`;
        dot.setAttribute('aria-label', `Фото ${index + 1}`);
        dot.addEventListener('click', () => setSlide(index));
        dotsWrap.appendChild(dot);
        return dot;
      });

      const setSlide = (index) => {
        activeIndex = (index + slides.length) % slides.length;
        track.style.transform = `translateX(-${activeIndex * 100}%)`;
        dots.forEach((dot, dotIndex) => {
          dot.classList.toggle('active', dotIndex === activeIndex);
        });
      };

      prev.addEventListener('click', () => setSlide(activeIndex - 1));
      next.addEventListener('click', () => setSlide(activeIndex + 1));
    })();
  </script>

  <script>
    (() => {
      const topbar = document.querySelector('.topbar');

      if (!topbar) {
        return;
      }

      const syncHeaderState = () => {
        const isCompact = topbar.classList.contains('is-compact');

        if (!isCompact && window.scrollY > 96) {
          topbar.classList.add('is-compact');
        } else if (isCompact && window.scrollY < 24) {
          topbar.classList.remove('is-compact');
        }
      };

      syncHeaderState();
      window.addEventListener('scroll', syncHeaderState, { passive: true });
    })();
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
    const serverMessages = {
      success: @json(session('booking_success')),
      clientRequestSuccess: @json(session('client_request_success')),
      openClientRequestPopup: @json((bool) session('open_client_request_popup')),
      errors: @json($errors->getBag('default')->all()),
    };

    const bookingForm = document.getElementById('bookingForm');
    const bookingCard = document.getElementById('booking');
    const bookingInlineSlot = document.getElementById('booking-inline-slot');
    const bookingModal = document.getElementById('booking-modal');
    const bookingModalSlot = document.getElementById('booking-modal-slot');
    const bookingModalOpenButtons = document.querySelectorAll('[data-booking-modal-open]');
    const bookingModalCloseButtons = document.querySelectorAll('[data-booking-modal-close]');
    const clientRequestPopup = document.getElementById('client-request-popup');
    const clientRequestOpenButtons = document.querySelectorAll('[data-client-request-open]');
    const clientRequestCloseButtons = document.querySelectorAll('[data-client-request-close]');
    const clientRequestForm = document.getElementById('client-request-form');
    const clientRequestPhoneInput = clientRequestForm?.querySelector('input[name="phone"]');
    const clientRequestErrors = document.getElementById('client-request-errors');
    const maskedPhoneInputs = document.querySelectorAll('[data-phone-mask]');
    const bookingMessagePopup = document.getElementById('booking-message-popup');
    const bookingMessageTitle = document.getElementById('booking-message-title');
    const bookingMessageText = document.getElementById('booking-message-text');
    const bookingMessageClose = document.getElementById('booking-message-close');
    const bookingMessageConfirm = document.getElementById('booking-message-confirm');
    const bookingMessageActions = document.getElementById('booking-message-actions');
    const serviceInput = document.getElementById('service_input');
    const masterInput = document.getElementById('master_id');
    const dateInput = document.getElementById('appointment_date');
    const timeInput = document.getElementById('appointment_time');
    const apparatusDiscussInput = document.getElementById('apparatus_discuss');
    const apparatusDurationInput = document.getElementById('apparatus_duration_minutes');
    const slotHint = document.getElementById('slot-hint');
    const servicesBlock = document.getElementById('services-block');
    const dateTimeBlock = document.getElementById('date-time-block');
    const additionalServicesBlock = document.getElementById('additional-services-block');
    const servicesEmpty = document.getElementById('services-empty');
    const apparatusDurationBox = document.getElementById('apparatus-duration-box');
    const apparatusDurationTitle = document.getElementById('apparatus-duration-title');
    const apparatusDurationOptions = document.getElementById('apparatus-duration-options');
    const apparatusDiscussBtn = document.getElementById('apparatus-discuss-btn');
    const serviceCards = document.querySelectorAll('.service-option');
    const masterCards = document.querySelectorAll('.master-option');
    const priceMasterTabs = document.querySelectorAll('.price-master-tab');
    const priceMasterGroups = document.querySelectorAll('[data-price-master-group]');
    const dayGrid = document.getElementById('days-grid');
    const daysPrev = document.getElementById('days-prev');
    const daysNext = document.getElementById('days-next');
    const monthPrev = document.getElementById('month-prev');
    const monthNext = document.getElementById('month-next');
    const monthLabel = document.getElementById('month-label');
    const timeGrid = document.getElementById('time-grid');
    const rangeLabel = document.getElementById('calendar-range-label');
    const monthPicker = monthPrev.closest('.month-picker');
    const dateSlider = daysPrev.closest('.date-slider');
    const summaryService = document.getElementById('summary-service');
    const summaryAdditional = document.getElementById('summary-additional');
    const summaryMaster = document.getElementById('summary-master');
    const summaryPrice = document.getElementById('summary-price');
    const summaryDatetime = document.getElementById('summary-datetime');
    const summaryDuration = document.getElementById('summary-duration');
    const servicesSelectionHint = document.getElementById('services-selection-hint');
    const addServiceTrigger = document.getElementById('add-service-trigger');
    const additionalServicesHint = document.getElementById('additional-services-hint');
    const additionalServicesInputs = document.getElementById('additional-services-inputs');
    const selectedServicesLabel = document.getElementById('selected-services-label');
    const selectedServicesList = document.getElementById('selected-services-list');
    const availableServicesLabel = document.getElementById('available-services-label');
    const additionalServicesPicker = document.getElementById('additional-services-picker');
    const additionalPickerList = document.getElementById('additional-picker-list');
    const clientNameInput = bookingForm.elements.client_name;
    const phoneInput = bookingForm.elements.phone;
    let isBookingConfirmed = false;

    const servicesByKey = Object.fromEntries(services.map((service) => [service.key, service]));
    const mastersById = Object.fromEntries(masters.map((master) => [String(master.id), master]));

    summaryDatetime.previousElementSibling.textContent = 'Час прийому';
    summaryAdditional.previousElementSibling.textContent = 'Обрані послуги';
    summaryDuration.nextElementSibling.textContent = '';

    const makeDate = (value) => new Date(`${value}T00:00:00`);
    const formatMonthKey = (date) => `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
    const formatDateKey = (date) => `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
    const minDate = makeDate(bookingConfig.minDate);
    const maxDate = makeDate(bookingConfig.maxDate);
    const monthKeys = [];
    const monthCursor = new Date(minDate.getFullYear(), minDate.getMonth(), 1);
    const lastMonth = new Date(maxDate.getFullYear(), maxDate.getMonth(), 1);

    while (monthCursor <= lastMonth) {
      monthKeys.push(formatMonthKey(monthCursor));
      monthCursor.setMonth(monthCursor.getMonth() + 1);
    }

    const maxSelectedServices = 3;

    const normalizeAdditionalServices = (values, primaryService) => {
      if (!Array.isArray(values)) {
        return [];
      }

      return [...new Set(
        values.filter((value) => typeof value === 'string' && value && servicesByKey[value] && value !== primaryService)
      )].slice(0, maxSelectedServices - 1);
    };

    const initialDate = oldValues.service ? (oldValues.appointment_date || bookingConfig.minDate) : '';
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
      hasLoadedAdditionalAvailability: false,
      availableDays: {},
      isAdditionalPickerOpen: false,
      apparatusBase: '',
      apparatusVariants: [],
      apparatusDiscuss: false,
      apparatusDurationMinutes: Number.parseInt(apparatusDurationInput.value || '0', 10) || 0,
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
      if (service?.is_apparatus && state.apparatusDurationMinutes) {
        return state.apparatusDurationMinutes;
      }

      const numericValue = Number.parseInt(String(service?.duration || '').replace(/[^\d]/g, ''), 10);
      return Number.isFinite(numericValue) ? numericValue : 0;
    };

    const getServicePrice = (service) => {
      if (!service) {
        return 0;
      }

      if (service.is_apparatus && state.apparatusDurationMinutes) {
        return (service.minute_price || service.price || 0) * state.apparatusDurationMinutes;
      }

      return service.price || 0;
    };

    const formatServiceSummaryName = (service) => {
      if (!service) {
        return 'Послугу ще не обрано';
      }

      if (state.apparatusDiscuss && service.apparatus_base) {
        return `${service.apparatus_base} (обговорити час з майстром, бронь 60 хв)`;
      }

      return service.badge ? `${service.label} (${service.badge} знижка)` : service.label;
    };

    const formatDurationValue = (minutes) => {
      if (!minutes) {
        return '0 хв';
      }

      const hours = Math.floor(minutes / 60);
      const restMinutes = minutes % 60;
      const parts = [];

      if (hours) {
        const hourWord = hours === 1 ? 'година' : (hours >= 2 && hours <= 4 ? 'години' : 'годин');
        parts.push(`${hours} ${hourWord}`);
      }

      if (restMinutes) {
        parts.push(`${restMinutes} хв`);
      }

      return parts.join(' ');
    };

    const addMinutesToTime = (time, minutes) => {
      if (!time) {
        return '';
      }

      const [hours, mins] = time.split(':').map(Number);
      const date = new Date(2000, 0, 1, hours, mins + minutes);

      return date.toLocaleTimeString('uk-UA', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false,
      });
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
          iso: formatDateKey(current),
          dayName: new Intl.DateTimeFormat('uk-UA', { weekday: 'short' }).format(current),
          dayNumber: new Intl.DateTimeFormat('uk-UA', { day: 'numeric' }).format(current),
          monthName: new Intl.DateTimeFormat('uk-UA', { month: 'short' }).format(current),
        });
        current.setDate(current.getDate() + 1);
      }

      return items;
    };

    const setCalendarNavVisible = (isVisible) => {
      [daysPrev, daysNext, monthPrev, monthNext].forEach((button) => {
        button.hidden = !isVisible;
      });

      monthPicker.classList.toggle('is-nav-hidden', !isVisible);
      dateSlider.classList.toggle('is-nav-hidden', !isVisible);
    };

    const setActiveCard = (collection, predicate) => {
      collection.forEach((element) => {
        element.classList.toggle('active', predicate(element));
      });
    };

    const getSelectedServiceKeys = () => [
      state.service,
      ...state.additionalServices,
    ].filter(Boolean);

    const renderServiceSelectionState = () => {
      const selectedKeys = getSelectedServiceKeys();

      serviceCards.forEach((card) => {
        const isApparatusCard = card.dataset.serviceKind === 'apparatus';
        const variantKeys = isApparatusCard
          ? JSON.parse(card.dataset.apparatusVariants || '[]').map((variant) => variant.key)
          : [];
        const apparatusOrder = selectedKeys.findIndex((serviceKey) => variantKeys.includes(serviceKey));
        const isSelected = isApparatusCard
          ? apparatusOrder >= 0
          : selectedKeys.includes(card.dataset.serviceKey || '');
        const order = isApparatusCard
          ? apparatusOrder
          : selectedKeys.indexOf(card.dataset.serviceKey || '');
        const orderBadge = card.querySelector('.service-order');

        card.classList.toggle('active', isSelected);

        if (orderBadge) {
          orderBadge.textContent = order >= 0 ? String(order + 1) : (isSelected ? '✓' : '');
        }
      });

      if (servicesSelectionHint) {
        const count = selectedKeys.length;
        servicesSelectionHint.textContent = count
          ? `Обрано ${count} з ${maxSelectedServices}. Перша послуга основна, наступні виконуються після неї в одному записі.`
          : 'Можна одразу обрати 1-3 послуги. Перша послуга буде основною, інші додадуться до цього ж запису.';
      }
    };

    const renderPriceMasterGroups = (masterId) => {
      const selectedMasterId = masterId || priceMasterTabs[0]?.dataset.priceMaster || '';

      priceMasterTabs.forEach((tab) => {
        tab.classList.toggle('active', tab.dataset.priceMaster === selectedMasterId);
      });

      priceMasterGroups.forEach((group) => {
        const isVisible = group.dataset.priceMasterGroup === selectedMasterId;
        group.hidden = !isVisible;
        group.style.display = isVisible ? '' : 'none';
      });
    };

    const setBlockVisible = (element, isVisible) => {
      if (!element) {
        return;
      }

      element.hidden = !isVisible;
      element.style.display = isVisible ? '' : 'none';
    };

    const renderBookingStepVisibility = () => {
      const hasMaster = Boolean(state.masterId);
      const hasMasterAndService = Boolean(state.masterId && state.service);

      setBlockVisible(servicesBlock, hasMaster);
      setBlockVisible(dateTimeBlock, hasMasterAndService);
      setBlockVisible(additionalServicesBlock, false);
    };

    const renderServicesForMaster = () => {
      let visibleCount = 0;

      serviceCards.forEach((card) => {
        const isVisible = Boolean(state.masterId && String(card.dataset.masterId) === String(state.masterId));

        card.hidden = !isVisible;
        card.style.display = isVisible ? '' : 'none';
        card.disabled = !isVisible;

        if (isVisible) {
          visibleCount++;
        }
      });

      servicesEmpty.hidden = !state.masterId || visibleCount > 0;
      renderServiceSelectionState();
    };

    const renderApparatusDurationPicker = () => {
      const shouldShow = Boolean(state.masterId && state.apparatusBase && state.apparatusVariants.length);

      apparatusDurationBox.hidden = !shouldShow;
      apparatusDurationBox.style.display = shouldShow ? 'grid' : 'none';
      apparatusDurationOptions.innerHTML = '';

      if (!shouldShow) {
        return;
      }

      apparatusDurationTitle.textContent = `${state.apparatusBase}: оберіть час процедури`;

      state.apparatusVariants.forEach((variant) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = `apparatus-duration-option${getSelectedServiceKeys().includes(variant.key) && !state.apparatusDiscuss ? ' active' : ''}`;
        button.textContent = `${variant.duration_minutes} хв - ${formatPrice(variant.price)}`;
        button.addEventListener('click', () => {
          selectApparatusVariant(variant, false);
        });
        apparatusDurationOptions.appendChild(button);
      });

      apparatusDiscussBtn.classList.toggle('active', Boolean(state.apparatusDiscuss));
    };

    const resetApparatusSelection = () => {
      state.apparatusBase = '';
      state.apparatusVariants = [];
      state.apparatusDiscuss = false;
      state.apparatusDurationMinutes = 0;
      apparatusDiscussInput.value = '';
      apparatusDurationInput.value = '';
      renderApparatusDurationPicker();
    };

    const resetSelectedDateTime = () => {
      state.date = '';
      dateInput.value = '';
      state.time = '';
      timeInput.value = '';
    };

    const selectServiceKey = (serviceKey) => {
      const serviceChanged = state.service !== serviceKey;
      state.service = serviceKey;
      serviceInput.value = serviceKey;
      state.additionalServices = normalizeAdditionalServices(state.additionalServices, state.service);

      if (serviceChanged) {
        resetSelectedDateTime();
      }

      syncAdditionalServiceInputs();
    };

    const applySelectedServiceKeys = (serviceKeys) => {
      const normalizedKeys = [...new Set(serviceKeys)]
        .filter((serviceKey) => serviceKey && servicesByKey[serviceKey] && String(servicesByKey[serviceKey].master_id) === state.masterId)
        .slice(0, maxSelectedServices);
      const previousKeys = getSelectedServiceKeys().join('|');
      const nextKeys = normalizedKeys.join('|');

      state.service = normalizedKeys[0] || '';
      state.additionalServices = normalizeAdditionalServices(normalizedKeys.slice(1), state.service);
      serviceInput.value = state.service;

      const hasSelectedApparatus = normalizedKeys.some((serviceKey) => servicesByKey[serviceKey]?.is_apparatus);

      if (!hasSelectedApparatus) {
        resetApparatusSelection();
      }

      if (previousKeys !== nextKeys) {
        resetSelectedDateTime();
      }

      syncAdditionalServiceInputs();
      renderServiceSelectionState();
    };

    const removeSelectedService = (serviceKey) => {
      applySelectedServiceKeys(getSelectedServiceKeys().filter((selectedKey) => selectedKey !== serviceKey));
      renderBookingStepVisibility();
      renderServicesForMaster();
      renderApparatusDurationPicker();
      renderAdditionalServices();
      updateSummary();
      loadMonthAvailability();
    };

    const toggleRegularService = (serviceKey) => {
      if (!serviceKey) {
        return;
      }

      const selectedKeys = getSelectedServiceKeys();

      if (selectedKeys.includes(serviceKey)) {
        removeSelectedService(serviceKey);
        return;
      }

      if (selectedKeys.length >= maxSelectedServices) {
        showBookingMessage('Можна обрати максимум 3 послуги в одному записі.', 'Ліміт послуг');
        return;
      }

      if (state.apparatusBase && !state.service) {
        resetApparatusSelection();
      }
      applySelectedServiceKeys([...selectedKeys, serviceKey]);
      renderBookingStepVisibility();
      renderServicesForMaster();
      renderApparatusDurationPicker();
      renderAdditionalServices();
      updateSummary();
      loadMonthAvailability();
    };

    function selectApparatusVariant(variant, discuss) {
      const selectedKeys = getSelectedServiceKeys();
      const previousDuration = state.apparatusDurationMinutes;
      const nextDuration = Number(variant.duration_minutes) || 60;
      const isAlreadySelected = selectedKeys.includes(variant.key);

      state.apparatusDiscuss = discuss;
      apparatusDiscussInput.value = discuss ? '1' : '';
      state.apparatusDurationMinutes = nextDuration;
      apparatusDurationInput.value = String(state.apparatusDurationMinutes);

      if (isAlreadySelected) {
        if (previousDuration !== nextDuration) {
          resetSelectedDateTime();
        }

        syncAdditionalServiceInputs();
      } else {
        applySelectedServiceKeys([...selectedKeys, variant.key]);
      }

      renderApparatusDurationPicker();
      renderBookingStepVisibility();
      renderAdditionalServices();
      renderServiceSelectionState();
      updateSummary();
      loadMonthAvailability();
    }

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
      if (getSelectedServiceKeys().length >= maxSelectedServices) {
        return [];
      }

      const remainingKeys = services
        .filter((service) => String(service.master_id) === state.masterId)
        .map((service) => service.key)
        .filter((serviceKey) => serviceKey !== state.service && !state.additionalServices.includes(serviceKey));

      if (state.time && state.service && state.hasLoadedAdditionalAvailability) {
        return services.filter((service) => (
          remainingKeys.includes(service.key) && state.availableAdditionalServiceKeys.includes(service.key)
        ));
      }

      return services.filter((service) => remainingKeys.includes(service.key));
    };

    const getRemainingAdditionalServices = () => services.filter((service) => (
      String(service.master_id) === state.masterId && service.key !== state.service && !state.additionalServices.includes(service.key)
    ));

    const resetAdditionalServices = () => {
      state.additionalServices = [];
      state.availableAdditionalServiceKeys = [];
      state.hasLoadedAdditionalAvailability = false;
      state.isAdditionalPickerOpen = false;
      syncAdditionalServiceInputs();
    };

    const appendServiceSelection = (params) => {
      if (state.service) {
        params.set('service', state.service);
      }

      if (state.apparatusDurationMinutes) {
        params.set('apparatus_duration_minutes', String(state.apparatusDurationMinutes));
      }

      state.additionalServices.forEach((serviceKey) => {
        params.append('additional_services[]', serviceKey);
      });
    };

    const normalizePhone = (value) => value.replace(/[\s\-()]/g, '');
    const formatPhoneForDisplay = (value) => {
      let digits = value.replace(/\D/g, '');

      if (!digits) {
        return '';
      }

      if (digits.startsWith('380')) {
        digits = digits.slice(3);
      } else if (digits.startsWith('80')) {
        digits = digits.slice(2);
      } else if (digits.startsWith('0')) {
        digits = digits.slice(1);
      }

      digits = digits.slice(0, 9);

      let formatted = '+380';
      const operator = digits.slice(0, 2);
      const first = digits.slice(2, 5);
      const second = digits.slice(5, 7);
      const third = digits.slice(7, 9);

      if (operator) {
        formatted += ` (${operator}`;
      }

      if (operator.length === 2) {
        formatted += ')';
      }

      if (first) {
        formatted += ` ${first}`;
      }

      if (second) {
        formatted += `-${second}`;
      }

      if (third) {
        formatted += `-${third}`;
      }

      return formatted;
    };
    const normalizePhoneForSubmit = (value) => {
      const digits = value.replace(/\D/g, '');

      if (!digits) {
        return '';
      }

      if (digits.startsWith('380')) {
        return `+${digits.slice(0, 12)}`;
      }

      if (digits.startsWith('80')) {
        return `+380${digits.slice(2, 11)}`;
      }

      if (digits.startsWith('0')) {
        return `+380${digits.slice(1, 10)}`;
      }

      return `+380${digits.slice(0, 9)}`;
    };
    const validNamePattern = /^[А-Яа-яЁёІіЇїЄєҐґ'’ʼ`\-\s]{2,80}$/u;
    const validPhonePattern = /^\+380\d{9}$/;

    const validateContacts = () => {
      const clientName = clientNameInput.value.trim().replace(/\s+/g, ' ');
      const phone = normalizePhoneForSubmit(phoneInput.value.trim());

      clientNameInput.value = clientName;
      phoneInput.value = phone;

      if (!validNamePattern.test(clientName)) {
        return 'Вкажіть ім’я українською або російською мовою. Можна використовувати літери, пробіли, апостроф і дефіс.';
      }

      if (!validPhonePattern.test(phone)) {
        return 'Вкажіть номер телефону у форматі +380XXXXXXXXX. Після +380 має бути рівно 9 цифр.';
      }

      return '';
    };

    const buildConfirmationMessage = () => [
      `Ім’я: ${clientNameInput.value}`,
      `Телефон: ${phoneInput.value}`,
      `Послуга: ${summaryService.textContent}`,
      `Майстер: ${summaryMaster.textContent.replace(/^Майстер:\s*/i, '')}`,
      `Дата і час: ${summaryDatetime.textContent}`,
      `Додатково: ${summaryAdditional.textContent}`,
      `Разом: ${summaryPrice.textContent}`,
      '',
      'Перевірте дані. Якщо все правильно, підтвердіть запис.',
    ].join('\n');

    const showBookingMessage = (message, title = 'Повідомлення', options = {}) => {
      bookingMessageTitle.textContent = title;
      bookingMessageText.textContent = message;
      bookingMessageConfirm.hidden = !options.confirm;
      bookingMessageClose.textContent = options.confirm ? 'Повернутися та змінити' : 'Зрозуміло';
      bookingMessageActions.classList.toggle('has-confirm', Boolean(options.confirm));
      bookingMessagePopup.hidden = false;
      (options.confirm ? bookingMessageConfirm : bookingMessageClose).focus();
    };

    const closeBookingMessage = () => {
      bookingMessagePopup.hidden = true;
      bookingMessageText.textContent = '';
      bookingMessageConfirm.hidden = true;
      bookingMessageClose.textContent = 'Зрозуміло';
      bookingMessageActions.classList.remove('has-confirm');
    };

    const clearBookingError = () => {
      closeBookingMessage();
    };

    const openBookingModal = () => {
      if (!bookingModal || !bookingCard || !bookingModalSlot) {
        return;
      }

      bookingModalSlot.appendChild(bookingCard);
      bookingModal.hidden = false;
      document.body.classList.add('is-booking-modal-open');
      bookingCard.querySelector('button, input, select, textarea, a')?.focus({ preventScroll: true });
    };

    const closeBookingModal = () => {
      if (!bookingModal || !bookingCard || !bookingInlineSlot) {
        return;
      }

      bookingInlineSlot.after(bookingCard);
      bookingModal.hidden = true;
      document.body.classList.remove('is-booking-modal-open');
    };

    const openClientRequestPopup = () => {
      if (!clientRequestPopup) {
        return;
      }

      clientRequestPopup.hidden = false;
      clientRequestPopup.querySelector('select, input, button')?.focus({ preventScroll: true });
    };

    const closeClientRequestPopup = () => {
      if (!clientRequestPopup) {
        return;
      }

      clientRequestPopup.hidden = true;
      if (clientRequestErrors) {
        clientRequestErrors.hidden = true;
        clientRequestErrors.textContent = '';
      }
    };

    const showClientRequestError = (message) => {
      if (!clientRequestErrors) {
        return;
      }

      clientRequestErrors.textContent = message;
      clientRequestErrors.hidden = false;
    };

    const checkSelectedSlotAvailability = async () => {
      const params = new URLSearchParams({
        master_id: state.masterId,
        date: state.date,
      });
      appendServiceSelection(params);

      if (state.time) {
        params.set('time', state.time);
      }

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
      state.hasLoadedAdditionalAvailability = Object.prototype.hasOwnProperty.call(payload, 'available_additional_services');

      return state.availableSlots.includes(state.time);
    };

    const updateSummary = () => {
      const selectedService = servicesByKey[state.service];
      const selectedAdditionalServices = state.additionalServices.map((serviceKey) => servicesByKey[serviceKey]).filter(Boolean);
      const selectedMaster = mastersById[state.masterId];
      const totalPrice = getServicePrice(selectedService) + selectedAdditionalServices.reduce((sum, service) => sum + getServicePrice(service), 0);
      const totalDuration = (selectedService ? getDurationMinutes(selectedService) : 0)
        + selectedAdditionalServices.reduce((sum, service) => sum + getDurationMinutes(service), 0);

      summaryMaster.textContent = selectedMaster ? `Майстер: ${selectedMaster.name}` : 'Оберіть майстра';
      summaryPrice.textContent = formatPrice(totalPrice);
      summaryService.textContent = selectedService ? 'Ваш запис' : 'Послугу ще не обрано';
      summaryAdditional.textContent = selectedService
        ? [formatServiceSummaryName(selectedService), ...selectedAdditionalServices.map((service) => service.label)]
          .map((label, index) => `${index + 1}. ${label}`)
          .join('\n')
        : 'Оберіть послуги';

      if (selectedService) {
        const durationLines = [
          `Основна процедура: ${selectedService.apparatus_base || selectedService.label} (${formatDurationValue(getDurationMinutes(selectedService))})`,
          ...selectedAdditionalServices.map((service) => (
            `Додаткова послуга: ${service.label} (${formatDurationValue(getDurationMinutes(service))})`
          )),
          `Загальний час процедур: ${formatDurationValue(totalDuration)}`,
        ];

        summaryDuration.textContent = durationLines.join('\n');
      } else {
        summaryDuration.textContent = 'Тривалість буде показана після вибору послуги';
      }
      // Detailed duration is rendered above.
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
      const hasUnavailableAdditionalServices = canAddServices
        && availableAdditionalServices.length === 0
        && remainingAdditionalServices.length > 0;

      addServiceTrigger.disabled = !canAddServices;
      addServiceTrigger.classList.toggle('is-unavailable', hasUnavailableAdditionalServices);
      addServiceTrigger.textContent = state.isAdditionalPickerOpen && canAddServices
        ? 'Закрити список послуг'
        : '+ Додати ще послугу';
      additionalServicesPicker.hidden = false;
      additionalServicesPicker.style.display = state.isAdditionalPickerOpen && canAddServices ? 'grid' : 'none';
      selectedServicesList.innerHTML = '';
      additionalPickerList.innerHTML = '';
      selectedServicesList.hidden = getSelectedServiceKeys().length === 0;
      selectedServicesLabel.hidden = getSelectedServiceKeys().length === 0;
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
        additionalServicesHint.textContent = 'На вибраний час не можна додати ще одну послугу, тому що салон зайнятий іншим клієнтом. Оберіть інший час для двох або більше процедур, або залиште запис тільки на основну процедуру.';
      }

      getSelectedServiceKeys()
        .map((serviceKey) => servicesByKey[serviceKey])
        .filter(Boolean)
        .forEach((service, index) => {
          const card = document.createElement('div');
          card.className = 'selected-service-card';
          card.innerHTML = `
            <div class="selected-service-head">
              <strong>${index + 1}. ${index === 0 ? formatServiceSummaryName(service) : service.label}</strong>
              <button type="button" class="remove-service-btn" data-remove-service="${service.key}" aria-label="Видалити послугу">×</button>
            </div>
            <div class="selected-service-meta">
              <span>${formatPrice(getServicePrice(service))}</span>
              <span>${formatDurationValue(getDurationMinutes(service))}</span>
            </div>
          `;
          selectedServicesList.appendChild(card);
        });

      selectedServicesList.querySelectorAll('[data-remove-service]').forEach((button) => {
        button.addEventListener('click', () => {
          removeSelectedService(button.dataset.removeService);
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
          state.additionalServices = normalizeAdditionalServices(state.additionalServices, state.service);
          state.isAdditionalPickerOpen = false;
          resetSelectedDateTime();
          syncAdditionalServiceInputs();
          renderServiceSelectionState();
          renderAdditionalServices();
          updateSummary();
          loadMonthAvailability();
        });
        additionalPickerList.appendChild(button);
      });
    };

    const renderDays = () => {
      setCalendarNavVisible(Boolean(state.service && state.masterId));

      if (!state.service || !state.masterId) {
        dayGrid.innerHTML = `<div class="empty-state" style="grid-column: 1 / -1;">${state.service ? 'Оберіть майстра, щоб побачити дату та час.' : 'Оберіть послугу та майстра.'}</div>`;
        daysPrev.disabled = true;
        daysNext.disabled = true;
        monthPrev.disabled = true;
        monthNext.disabled = true;
        slotHint.textContent = '';
        return;
      }

      const allDays = getMonthDays(state.monthKey);
      const start = state.dayPage * pageSizeDays;
      const visibleDays = allDays.slice(start, start + pageSizeDays);
      const monthDate = getCurrentMonthDate();

      dayGrid.innerHTML = '';
      monthLabel.textContent = new Intl.DateTimeFormat('uk-UA', { month: 'long', year: 'numeric' }).format(monthDate);
      rangeLabel.textContent = `Доступно до ${bookingConfig.maxDate}`;

      if (!state.service) {
        dayGrid.innerHTML = '<div class="empty-state" style="grid-column: 1 / -1;">Спочатку оберіть послугу, щоб побачити правильні дати.</div>';
        daysPrev.disabled = true;
        daysNext.disabled = true;
        monthPrev.disabled = true;
        monthNext.disabled = true;
        slotHint.textContent = 'Дати та час відкриються після вибору послуги.';
        return;
      }

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
      if (!state.service || !state.masterId) {
        timeGrid.classList.add('is-disabled');
        timeGrid.innerHTML = '';
        slotHint.textContent = '';
        renderAdditionalServices();
        return;
      }

      timeGrid.innerHTML = '';
      const consumedSlots = getConsumedSlots();

      if (!state.service) {
        timeGrid.classList.add('is-disabled');
        timeGrid.innerHTML = '<div class="empty-state" style="grid-column: 1 / -1;">Спочатку оберіть послугу.</div>';
        slotHint.textContent = 'Дати та час відкриються після вибору послуги.';
        renderAdditionalServices();
        return;
      }

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
        button.innerHTML = `<span>${slot}</span>`;
        button.disabled = isConsumed;

        if (slot === state.time) {
          const label = document.createElement('small');
          label.textContent = 'час вашого прийому';
          button.appendChild(label);
        }

        if (isConsumed) {
          const label = document.createElement('small');
          label.textContent = 'тривалість процедури';
          button.appendChild(label);
          button.title = 'Цей час входить у тривалість вашої процедури';
        }

        button.addEventListener('click', () => {
          if (isConsumed) {
            return;
          }

          clearBookingError();
          const previousTime = state.time;
          state.time = slot;
          timeInput.value = slot;

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

      if (!state.service || !state.masterId) {
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
        renderDays();
        renderTimes();
        slotHint.textContent = 'Не вдалося завантажити календар доступності. Оновіть сторінку або спробуйте ще раз.';
        showBookingMessage('Не вдалося завантажити календар доступності. Оновіть сторінку або спробуйте ще раз.', 'Помилка');
      }
    };

    const loadAvailability = async () => {
      if (!state.service || !state.masterId || !state.date) {
        state.availableSlots = [];
        state.availableAdditionalServiceKeys = [];
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
        state.hasLoadedAdditionalAvailability = Object.prototype.hasOwnProperty.call(payload, 'available_additional_services');

        if (!state.availableSlots.includes(state.time)) {
          state.time = '';
          timeInput.value = '';
        }

        renderTimes();
        updateSummary();
      } catch (error) {
        state.availableSlots = [];
        state.availableAdditionalServiceKeys = [];
        state.time = '';
        timeInput.value = '';
        renderTimes();
        slotHint.textContent = 'Сталася помилка під час завантаження слотів. Оновіть сторінку або спробуйте ще раз.';
        showBookingMessage('Сталася помилка під час завантаження слотів. Оновіть сторінку або спробуйте ще раз.', 'Помилка');
      }
    };

      serviceCards.forEach((card) => {
        card.addEventListener('click', () => {
          clearBookingError();
          const isApparatus = card.dataset.serviceKind === 'apparatus';

          if (isApparatus) {
            const selectedKeys = getSelectedServiceKeys();
            const variants = JSON.parse(card.dataset.apparatusVariants || '[]');
            const variantKeys = variants.map((variant) => variant.key);
            const isSelected = selectedKeys.some((serviceKey) => variantKeys.includes(serviceKey));

            if (!isSelected && selectedKeys.length >= maxSelectedServices) {
              showBookingMessage('Можна обрати максимум 3 послуги в одному записі.', 'Ліміт послуг');
              return;
            }

            state.apparatusBase = card.dataset.apparatusBase || '';
            state.apparatusVariants = variants;
            state.apparatusDiscuss = false;
            apparatusDiscussInput.value = '';
            renderServiceSelectionState();
            renderApparatusDurationPicker();
            renderBookingStepVisibility();
            renderAdditionalServices();
            updateSummary();
            return;
          }

        toggleRegularService(card.dataset.serviceKey || '');
      });
    });

    masterCards.forEach((card) => {
      card.addEventListener('click', () => {
        clearBookingError();
        const nextMasterId = card.dataset.masterId || '';
        const masterChanged = state.masterId !== nextMasterId;
        state.masterId = nextMasterId;
        masterInput.value = state.masterId;
        state.time = '';
        timeInput.value = '';

        if (masterChanged) {
          state.service = '';
          serviceInput.value = '';
          state.additionalServices = [];
          resetApparatusSelection();
          resetSelectedDateTime();
          syncAdditionalServiceInputs();
        }

        setActiveCard(masterCards, (element) => element.dataset.masterId === state.masterId);
        renderServiceSelectionState();
        renderBookingStepVisibility();
        renderServicesForMaster();
        renderApparatusDurationPicker();
        renderAdditionalServices();
        updateSummary();
        loadMonthAvailability();
      });
    });

    priceMasterTabs.forEach((tab) => {
      tab.addEventListener('click', () => {
        renderPriceMasterGroups(tab.dataset.priceMaster || '');
      });
    });

    apparatusDiscussBtn.addEventListener('click', () => {
      const sixtyMinuteVariant = state.apparatusVariants.find((variant) => Number(variant.duration_minutes) === 60)
        || state.apparatusVariants[state.apparatusVariants.length - 1];

      if (sixtyMinuteVariant) {
        selectApparatusVariant(sixtyMinuteVariant, true);
      }
    });

    document.querySelectorAll('[data-service-target]').forEach((button) => {
      button.addEventListener('click', () => {
        clearBookingError();
        const service = button.getAttribute('data-service-target');
        const apparatusTarget = button.getAttribute('data-apparatus-target') || '';
        const masterTarget = button.getAttribute('data-master-target') || '';

        if (masterTarget) {
          state.masterId = masterTarget;
          masterInput.value = masterTarget;
          setActiveCard(masterCards, (element) => element.dataset.masterId === state.masterId);
          renderPriceMasterGroups(masterTarget);
        }

        if (apparatusTarget) {
          renderServicesForMaster();
          const apparatusCard = [...serviceCards].find((card) => (
            card.dataset.masterId === state.masterId && card.dataset.apparatusBase === apparatusTarget
          ));

          if (apparatusCard) {
            apparatusCard.click();
          }

          return;
        }

        if (!service) {
          state.service = '';
          serviceInput.value = '';
          state.additionalServices = [];
          resetApparatusSelection();
          resetSelectedDateTime();
          syncAdditionalServiceInputs();
          renderBookingStepVisibility();
          renderServicesForMaster();
          renderAdditionalServices();
          updateSummary();
          return;
        }

        resetApparatusSelection();
        applySelectedServiceKeys([service]);
        renderBookingStepVisibility();
        renderServicesForMaster();
        renderAdditionalServices();
        updateSummary();
        loadMonthAvailability();
      });
    });

    addServiceTrigger.addEventListener('click', () => {
      clearBookingError();

      if (addServiceTrigger.disabled) {
        return;
      }

      if (!getAvailableAdditionalServices().length) {
        state.isAdditionalPickerOpen = false;
        renderAdditionalServices();
        showBookingMessage('На вибраний час не можна додати ще одну послугу, тому що салон зайнятий іншим клієнтом. Оберіть інший час для двох або більше процедур, або залиште запис тільки на основну процедуру.', 'Додаткова послуга недоступна');
        return;
      }

      state.isAdditionalPickerOpen = !state.isAdditionalPickerOpen;
      addServiceTrigger.textContent = state.isAdditionalPickerOpen ? 'Закрити список послуг' : '+ Додати ще послугу';
      renderAdditionalServices();
    });

    bookingModalOpenButtons.forEach((button) => {
      button.addEventListener('click', openBookingModal);
    });

    bookingModalCloseButtons.forEach((button) => {
      button.addEventListener('click', closeBookingModal);
    });

    maskedPhoneInputs.forEach((input) => {
      input.value = input.value.trim() ? formatPhoneForDisplay(input.value) : '';

      input.addEventListener('input', () => {
        input.value = formatPhoneForDisplay(input.value);
      });
    });

    clientRequestOpenButtons.forEach((button) => {
      button.addEventListener('click', openClientRequestPopup);
    });

    clientRequestCloseButtons.forEach((button) => {
      button.addEventListener('click', closeClientRequestPopup);
    });

    clientRequestForm?.addEventListener('submit', (event) => {
      const phone = normalizePhoneForSubmit(clientRequestPhoneInput?.value.trim() || '');

      if (clientRequestPhoneInput) {
        clientRequestPhoneInput.value = phone;
      }

      if (!validPhonePattern.test(phone)) {
        event.preventDefault();
        showClientRequestError('Вкажіть номер телефону у форматі +380XXXXXXXXX.');
      }
    });

    bookingForm.addEventListener('submit', async (event) => {
      event.preventDefault();
      clearBookingError();

      if (!state.service) {
        showBookingMessage('Оберіть послугу.', 'Зверніть увагу');
        return;
      }

      if (!state.masterId) {
        showBookingMessage('Оберіть майстра.', 'Зверніть увагу');
        return;
      }

      if (!state.date) {
        showBookingMessage('Оберіть дату запису.', 'Зверніть увагу');
        return;
      }

      if (!state.time) {
        showBookingMessage('Оберіть вільний час запису.', 'Зверніть увагу');
        return;
      }

      const contactError = validateContacts();

      if (contactError) {
        showBookingMessage(contactError, 'Перевірте контактні дані');
        return;
      }

      if (!isBookingConfirmed) {
        showBookingMessage(buildConfirmationMessage(), 'Перевірте запис', { confirm: true });
        return;
      }

      isBookingConfirmed = false;

      try {
        const isSelectedSlotAvailable = await checkSelectedSlotAvailability();
        renderTimes();
        renderAdditionalServices();
        updateSummary();

        if (!isSelectedSlotAvailable) {
          timeInput.value = '';
          state.time = '';
          showBookingMessage('Обраний час уже зайнятий або не підходить для тривалості запису. Оберіть інший час.', 'Час недоступний');
          renderTimes();
          renderAdditionalServices();
          updateSummary();
          return;
        }

        bookingForm.submit();
      } catch (error) {
        showBookingMessage('Не вдалося перевірити доступність часу. Оновіть сторінку або спробуйте ще раз.', 'Помилка');
      }
    });

    bookingMessageConfirm.addEventListener('click', () => {
      isBookingConfirmed = true;
      closeBookingMessage();
      bookingForm.requestSubmit();
    });
    bookingMessageClose.addEventListener('click', closeBookingMessage);
    document.querySelectorAll('[data-popup-close]').forEach((element) => {
      element.addEventListener('click', closeBookingMessage);
    });
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && !bookingMessagePopup.hidden) {
        closeBookingMessage();
        return;
      }

      if (event.key === 'Escape' && bookingModal && !bookingModal.hidden) {
        closeBookingModal();
        return;
      }

      if (event.key === 'Escape' && clientRequestPopup && !clientRequestPopup.hidden) {
        closeClientRequestPopup();
      }
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
      renderServiceSelectionState();
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
    renderPriceMasterGroups(state.masterId);
    renderBookingStepVisibility();
    renderServicesForMaster();
    renderApparatusDurationPicker();
    renderDays();
    renderAdditionalServices();
    updateSummary();
    loadMonthAvailability();

    if (serverMessages.success) {
      showBookingMessage(serverMessages.success, 'Готово');
    } else if (serverMessages.clientRequestSuccess) {
      showBookingMessage(serverMessages.clientRequestSuccess, 'Готово');
    } else if (Array.isArray(serverMessages.errors) && serverMessages.errors.length) {
      showBookingMessage(serverMessages.errors.join('\n'), 'Зверніть увагу');
    }

    if (serverMessages.openClientRequestPopup) {
      openClientRequestPopup();
    }
  </script>
</body>
</html>
