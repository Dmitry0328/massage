@php
    $contentOverrides = collect($contentOverrides ?? [])->values();
    $canEditContent = (bool) ($canEditContent ?? false);
@endphp

@if ($canEditContent)
    <style>
        .content-edit-bar { position: fixed; z-index: 99990; right: 18px; bottom: 18px; display: flex; gap: 8px; align-items: center; border: 1px solid rgba(36, 29, 26, 0.14); border-radius: 999px; background: #241d1a; color: #fff; padding: 8px 10px 8px 14px; font: 700 13px/1.2 Arial, sans-serif; box-shadow: 0 18px 54px rgba(0, 0, 0, 0.22); }
        .content-edit-bar a { color: #fff; text-decoration: none; }
        .content-edit-pill { display: inline-flex; width: 10px; height: 10px; border-radius: 999px; background: #65d68c; box-shadow: 0 0 0 4px rgba(101, 214, 140, 0.18); }
        .content-edit-exit { border: 1px solid rgba(255, 255, 255, 0.22); border-radius: 999px; background: rgba(255, 255, 255, 0.08); color: #fff; padding: 6px 10px; font: inherit; cursor: pointer; }
        .content-edit-hover { outline: 2px solid #2f95ad !important; outline-offset: 3px !important; cursor: pointer !important; }
        .content-edit-modal { position: fixed; inset: 0; z-index: 99999; display: none; place-items: center; padding: 18px; font-family: Arial, sans-serif; }
        .content-edit-modal.is-open { display: grid; }
        .content-edit-backdrop { position: absolute; inset: 0; background: rgba(0, 0, 0, 0.42); }
        .content-edit-dialog { position: relative; width: min(620px, 100%); max-height: calc(100dvh - 36px); overflow: auto; border-radius: 16px; background: #fff; color: #241d1a; padding: 20px; box-shadow: 0 24px 90px rgba(0, 0, 0, 0.28); }
        .content-edit-title { margin: 0 0 12px; font-size: 22px; font-weight: 900; }
        .content-edit-field { display: grid; gap: 7px; margin-top: 12px; }
        .content-edit-label { color: #6b5148; font-size: 13px; font-weight: 800; }
        .content-edit-input, .content-edit-textarea { width: 100%; border: 1px solid #d8c0b4; border-radius: 12px; background: #fff; color: #241d1a; padding: 11px 12px; font: 500 15px/1.45 Arial, sans-serif; }
        .content-edit-textarea { min-height: 170px; resize: vertical; }
        .content-edit-actions { display: flex; flex-wrap: wrap; gap: 9px; justify-content: flex-end; margin-top: 16px; }
        .content-edit-button { border: 1px solid #2f95ad; border-radius: 999px; background: #2f95ad; color: #fff; padding: 10px 15px; font-weight: 900; cursor: pointer; }
        .content-edit-button.is-muted { border-color: #d8c0b4; background: #fff; color: #5d463f; }
        .content-edit-button.is-danger { border-color: #d3422f; background: #fff; color: #9b2d1f; }
        .content-edit-help { margin: 8px 0 0; color: #6b5148; font-size: 13px; line-height: 1.4; }
        @media (max-width: 560px) {
            .content-edit-bar { left: 10px; right: 10px; bottom: 10px; justify-content: space-between; }
            .content-edit-dialog { padding: 16px; border-radius: 14px; }
            .content-edit-actions, .content-edit-button { width: 100%; }
        }
    </style>

    <div class="content-edit-bar" data-content-editor-ui>
        <span class="content-edit-pill" aria-hidden="true"></span>
        <span>Edit mode увімкнено</span>
        <a class="content-edit-exit" href="{{ route('booking.index') }}">Вимкнути</a>
    </div>

    <div class="content-edit-modal" id="content-edit-modal" role="dialog" aria-modal="true" data-content-editor-ui>
        <button type="button" class="content-edit-backdrop" data-content-edit-close aria-label="Закрити"></button>
        <div class="content-edit-dialog">
            <h2 class="content-edit-title" id="content-edit-title">Редагування</h2>
            <form id="content-edit-form">
                <div class="content-edit-field" data-content-text-field>
                    <label class="content-edit-label" for="content-edit-value">Текст</label>
                    <textarea class="content-edit-textarea" id="content-edit-value"></textarea>
                </div>

                <div class="content-edit-field" data-content-image-field hidden>
                    <label class="content-edit-label" for="content-edit-image">Нове фото</label>
                    <input class="content-edit-input" id="content-edit-image" type="file" accept="image/*">
                    <label class="content-edit-label" for="content-edit-image-url">або URL фото</label>
                    <input class="content-edit-input" id="content-edit-image-url" type="url" placeholder="https://...">
                    <p class="content-edit-help">Після збереження фото заміниться на сайті для всіх відвідувачів.</p>
                </div>

                <div class="content-edit-actions">
                    <button type="button" class="content-edit-button is-danger" id="content-edit-reset">Скинути зміну</button>
                    <button type="button" class="content-edit-button is-muted" data-content-edit-close>Закрити</button>
                    <button type="submit" class="content-edit-button">Зберегти</button>
                </div>
            </form>
        </div>
    </div>
@endif

<script>
  window.ContentEditorConfig = {
    pageKey: 'home',
    enabled: @json($canEditContent),
    csrfToken: @json(csrf_token()),
    saveUrl: @json(route('content-overrides.store')),
    deleteUrl: @json(route('content-overrides.destroy')),
    overrides: @json($contentOverrides),
  };
</script>

<script>
(() => {
  const config = window.ContentEditorConfig || {};
  const overrides = Array.isArray(config.overrides) ? config.overrides : [];
  const editableTextSelector = 'h1,h2,h3,h4,h5,h6,p,span,a,button,label,strong,small,li,figcaption,blockquote';
  const ignoredSelector = 'script,style,noscript,svg,input,textarea,select,option,[data-content-editor-ui],[data-content-editor-ui] *,.fi-body,.fi-body *';
  let activeTarget = null;
  let activeInfo = null;

  const hash = (value) => {
    let result = 5381;
    const text = String(value || '');
    for (let index = 0; index < text.length; index += 1) {
      result = ((result << 5) + result) + text.charCodeAt(index);
      result &= result;
    }
    return String(result >>> 0);
  };

  const cssPath = (element) => {
    if (!element || element.nodeType !== 1) {
      return '';
    }

    const parts = [];
    let current = element;

    while (current && current.nodeType === 1 && current !== document.documentElement) {
      if (current.id && !current.id.includes(':')) {
        parts.unshift(`#${CSS.escape(current.id)}`);
        break;
      }

      const tag = current.tagName.toLowerCase();
      const parent = current.parentElement;

      if (!parent) {
        parts.unshift(tag);
        break;
      }

      const sameTagSiblings = Array.from(parent.children).filter((child) => child.tagName === current.tagName);
      const index = sameTagSiblings.indexOf(current) + 1;
      parts.unshift(sameTagSiblings.length > 1 ? `${tag}:nth-of-type(${index})` : tag);
      current = parent;
    }

    return parts.join(' > ');
  };

  const directText = (element) => Array.from(element.childNodes)
    .filter((node) => node.nodeType === Node.TEXT_NODE)
    .map((node) => node.textContent)
    .join('')
    .trim();

  const replaceDirectText = (element, value) => {
    const textNodes = Array.from(element.childNodes).filter((node) => node.nodeType === Node.TEXT_NODE);

    if (!textNodes.length) {
      element.textContent = value;
      return;
    }

    textNodes[0].textContent = value;
    textNodes.slice(1).forEach((node) => {
      node.textContent = '';
    });
  };

  const targetInfo = (element) => {
    if (!element || element.closest(ignoredSelector)) {
      return null;
    }

    if (element.matches('img')) {
      return {
        type: 'image',
        element,
        value: element.getAttribute('src') || '',
      };
    }

    const textElement = element.closest(editableTextSelector);

    if (!textElement || textElement.closest(ignoredSelector)) {
      return null;
    }

    const value = directText(textElement) || textElement.textContent.trim();

    if (!value) {
      return null;
    }

    return {
      type: 'text',
      element: textElement,
      value,
    };
  };

  const applyOverride = (override) => {
    const element = document.querySelector(override.selector);

    if (!element) {
      return;
    }

    if (override.type === 'image' && element.matches('img')) {
      element.setAttribute('src', override.value);
      return;
    }

    if (override.type === 'text') {
      replaceDirectText(element, override.value);
    }
  };

  overrides.forEach(applyOverride);

  if (!config.enabled) {
    return;
  }

  const modal = document.getElementById('content-edit-modal');
  const form = document.getElementById('content-edit-form');
  const title = document.getElementById('content-edit-title');
  const textField = document.querySelector('[data-content-text-field]');
  const imageField = document.querySelector('[data-content-image-field]');
  const textarea = document.getElementById('content-edit-value');
  const imageInput = document.getElementById('content-edit-image');
  const imageUrlInput = document.getElementById('content-edit-image-url');
  const resetButton = document.getElementById('content-edit-reset');
  let hoveredElement = null;

  const closeModal = () => {
    modal.classList.remove('is-open');
    activeTarget = null;
    activeInfo = null;
    form.reset();
  };

  const openModal = (info) => {
    activeTarget = info.element;
    activeInfo = {
      selector: cssPath(info.element),
      type: info.type,
      originalHash: hash(info.value),
    };

    title.textContent = info.type === 'image' ? 'Редагування фото' : 'Редагування тексту';
    textField.hidden = info.type !== 'text';
    imageField.hidden = info.type !== 'image';
    textarea.value = info.type === 'text' ? info.value : '';
    imageUrlInput.value = info.type === 'image' ? info.value : '';
    imageInput.value = '';
    modal.classList.add('is-open');

    if (info.type === 'text') {
      textarea.focus();
    } else {
      imageUrlInput.focus();
      imageUrlInput.select();
    }
  };

  const saveOverride = async (event) => {
    event.preventDefault();

    if (!activeInfo || !activeTarget) {
      return;
    }

    const body = new FormData();
    body.append('page_key', config.pageKey);
    body.append('selector', activeInfo.selector);
    body.append('type', activeInfo.type);
    body.append('original_hash', activeInfo.originalHash);

    if (activeInfo.type === 'image' && imageInput.files[0]) {
      body.append('image', imageInput.files[0]);
    } else {
      body.append('value', activeInfo.type === 'text' ? textarea.value : imageUrlInput.value);
    }

    const response = await fetch(config.saveUrl, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': config.csrfToken,
        'Accept': 'application/json',
      },
      body,
    });

    if (!response.ok) {
      alert('Не вдалося зберегти зміну. Онови сторінку та спробуй ще раз.');
      return;
    }

    const payload = await response.json();
    applyOverride(payload.override);
    closeModal();
  };

  const resetOverride = async () => {
    if (!activeInfo) {
      return;
    }

    const response = await fetch(config.deleteUrl, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': config.csrfToken,
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        page_key: config.pageKey,
        selector: activeInfo.selector,
        type: activeInfo.type,
        original_hash: activeInfo.originalHash,
      }),
    });

    if (!response.ok) {
      alert('Не вдалося скинути зміну.');
      return;
    }

    window.location.reload();
  };

  document.addEventListener('mouseover', (event) => {
    const info = targetInfo(event.target);

    if (hoveredElement && hoveredElement !== info?.element) {
      hoveredElement.classList.remove('content-edit-hover');
    }

    hoveredElement = info?.element || null;

    if (hoveredElement) {
      hoveredElement.classList.add('content-edit-hover');
    }
  });

  document.addEventListener('mouseout', (event) => {
    const info = targetInfo(event.target);

    if (info?.element) {
      info.element.classList.remove('content-edit-hover');
    }
  });

  document.addEventListener('click', (event) => {
    const info = targetInfo(event.target);

    if (!info) {
      return;
    }

    event.preventDefault();
    event.stopPropagation();
    openModal(info);
  }, true);

  document.querySelectorAll('[data-content-edit-close]').forEach((button) => {
    button.addEventListener('click', closeModal);
  });

  form.addEventListener('submit', saveOverride);
  resetButton.addEventListener('click', resetOverride);

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && modal.classList.contains('is-open')) {
      closeModal();
    }
  });
})();
</script>
