import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.togglePassword = function (inputId, iconId) {

    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (!input || !icon) {
        return;
    }

    if (input.type === 'password') {

        input.type = 'text';

        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.458 12 C2.732 16.057 6.523 19 11 19 c1.61 0 3.12-.365 4.467-1.014" />

            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.228 6.228A10.45 10.45 0 0111 5 c4.477 0 8.268 2.943 9.542 7 a10.48 10.48 0 01-1.507 3.037" />

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M14.121 14.121a3 3 0 01-4.242-4.242" />

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 3l18 18" />
        `;

    } else {

        input.type = 'password';

        icon.innerHTML = `
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5
                   c4.477 0 8.268 2.943 9.542 7
                   -1.274 4.057-5.065 7-9.542 7
                   -4.477 0-8.268-2.943-9.542-7z" />
        `;
    }
};  