<style>
    :root {
        --admin-mobile-radius: 14px;
        --admin-mobile-gap: 10px;
    }

    @media (max-width: 768px) {
        html {
            -webkit-text-size-adjust: 100%;
        }

        body {
            overscroll-behavior-y: contain;
        }

        .fi-main {
            padding-inline: 12px !important;
            padding-bottom: calc(24px + env(safe-area-inset-bottom)) !important;
            overflow-x: hidden !important;
        }

        .fi-page {
            gap: 14px !important;
        }

        .fi-header {
            gap: 12px !important;
        }

        .fi-header-heading {
            font-size: 24px !important;
            line-height: 1.15 !important;
        }

        .fi-header-actions,
        .fi-ta-header-toolbar,
        .fi-ta-actions {
            flex-wrap: wrap !important;
            gap: 8px !important;
        }

        .fi-header-actions .fi-btn,
        .fi-ta-header-toolbar .fi-btn,
        .fi-ta-actions .fi-btn {
            flex: 1 1 auto;
        }

        .fi-btn,
        .fi-icon-btn,
        .fi-link {
            min-height: 44px;
            touch-action: manipulation;
        }

        .fi-input-wrp,
        .fi-fo-field-wrp,
        .fi-ta-search-field,
        .fi-select-input,
        .fi-input,
        .fi-textarea {
            min-width: 0 !important;
            max-width: 100% !important;
        }

        .fi-input,
        .fi-select-input,
        .fi-textarea {
            font-size: 16px !important;
        }

        .fi-section,
        .fi-fo-component-ctn,
        .fi-ta-ctn {
            border-radius: var(--admin-mobile-radius) !important;
        }

        .fi-ta-content {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: var(--admin-mobile-radius);
        }

        .fi-ta-table {
            min-width: 560px;
        }

        .fi-ta-cell,
        .fi-ta-header-cell {
            padding-inline: 10px !important;
        }

        .fi-ta-text,
        .fi-ta-text-item,
        .fi-ta-col-wrp {
            overflow-wrap: anywhere;
        }

        .fi-ta-record-actions,
        .fi-ta-actions {
            white-space: nowrap;
        }

        .fi-ta-filters,
        .fi-ta-header-toolbar,
        .fi-ta-selection-indicator {
            border-radius: var(--admin-mobile-radius) !important;
        }

        .fi-sidebar-nav {
            padding-bottom: calc(16px + env(safe-area-inset-bottom)) !important;
        }

        .fi-sidebar-item-button,
        .fi-topbar-item {
            min-height: 46px !important;
        }

        .fi-dropdown-panel {
            max-width: calc(100vw - 16px) !important;
        }

        .fi-dropdown-list {
            padding: 6px !important;
        }

        .fi-dropdown-list-item {
            min-height: 44px !important;
            border-radius: 10px !important;
        }

        .fi-modal-window {
            width: calc(100vw - 24px) !important;
            max-width: calc(100vw - 24px) !important;
            max-height: calc(100dvh - 24px) !important;
            border-radius: 18px 18px 12px 12px !important;
        }

        .fi-modal-content {
            max-height: calc(100dvh - 150px);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .fi-modal-footer-actions {
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 8px !important;
        }

        .fi-modal-footer-actions .fi-btn {
            width: 100% !important;
            justify-content: center !important;
        }

        .fi-fo-component-ctn {
            gap: var(--admin-mobile-gap) !important;
        }

        .fi-fo-field-wrp-label {
            line-height: 1.25 !important;
        }

        .admin-site-link-wrapper {
            flex: 0 0 auto !important;
            padding-inline: 4px !important;
            max-width: 72px !important;
        }

        .admin-site-link {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 54px !important;
            min-height: 40px !important;
            padding: 8px 10px !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: clip !important;
            font-size: 0 !important;
            line-height: 1 !important;
        }

        .admin-site-link::after {
            content: 'Сайт';
            font-size: 13px;
            font-weight: 800;
        }
    }

    @media (max-width: 480px) {
        .fi-main {
            padding-inline: 8px !important;
        }

        .fi-header-heading {
            font-size: 22px !important;
        }

        .fi-ta-table {
            min-width: 500px;
        }

        .fi-ta-search-field,
        .fi-ta-filters .fi-input-wrp {
            width: 100% !important;
        }

        .fi-pagination {
            gap: 6px !important;
        }

        .fi-pagination .fi-btn,
        .fi-pagination .fi-icon-btn {
            min-width: 40px !important;
            padding-inline: 10px !important;
        }

        .fi-modal-window {
            width: 100vw !important;
            max-width: 100vw !important;
            max-height: 96dvh !important;
            margin-top: auto !important;
            border-radius: 18px 18px 0 0 !important;
        }
    }
</style>
