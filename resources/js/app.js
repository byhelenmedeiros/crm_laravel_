import './bootstrap';
import '../css/app.css';

import { Ziggy } from './ziggy';  
window.Ziggy = Ziggy;

 window.toast = function (message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} shadow-lg fixed top-5 right-5 z-50 w-64`;
    toast.innerHTML = `
        <span>${message}</span>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
};

 window.authUser = JSON.parse(
    document.querySelector('meta[name="auth-user"]')?.content || 'null'
);
