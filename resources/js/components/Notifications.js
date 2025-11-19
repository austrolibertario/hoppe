// ===========================================
// resources/js/components/Notifications.js
// Sistema de notificações
// ===========================================

import axios from 'axios';

let notificationInterval = null;

export function initNotifications() {
    const badge = document.querySelector('.notification-badge');
    if (!badge) return;

    // Verificar notificações a cada 60 segundos
    checkNotifications();
    notificationInterval = setInterval(checkNotifications, 60000);
}

async function checkNotifications() {
    if (!window.Config || !window.Config.routes?.notificationsCount) return;
    if (!window.Config.user_id) return;

    try {
        const response = await axios.get(window.Config.routes.notificationsCount);
        updateBadge(response.data.count);
    } catch (error) {
        console.error('Failed to fetch notifications:', error);
    }
}

function updateBadge(count) {
    const badge = document.querySelector('.notification-badge');
    if (!badge) return;

    if (count > 0) {
        badge.textContent = count > 99 ? '99+' : count;
        badge.style.display = 'inline-block';
    } else {
        badge.style.display = 'none';
    }
}

export function clearNotificationInterval() {
    if (notificationInterval) {
        clearInterval(notificationInterval);
    }
}
