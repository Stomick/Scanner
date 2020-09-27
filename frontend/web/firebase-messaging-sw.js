importScripts('https://www.gstatic.com/firebasejs/7.21.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.21.0/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyB-_-Ts90mKWDbkaCBlW_PwYa31EM7UASM",
    authDomain: "hands-33ea9.firebaseapp.com",
    databaseURL: "https://hands-33ea9.firebaseio.com",
    projectId: "hands-33ea9",
    storageBucket: "hands-33ea9.appspot.com",
    messagingSenderId: "917642403764",
    appId: "1:917642403764:web:9593e70199f95f9dfe5ce1"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(payload)
    if (typeof payload.data.time != 'undefined') {
        var time = new Date(payload.data.time * 1000);
        var now = new Date();

        if (time < now) { // истек срок годности уведомления
            return null;
        }

        var diff = Math.round((time.getTime() - now.getTime()) / 1000);

        // показываем реальное время в уведомлении
        // будет сгенерировано сообщение вида: "Начало через 14 минут, в 21:00"
        payload.data.body = 'Начало через ' +
            Math.round(diff / 60) + ' минут, в ' + time.getHours() + ':' +
            (time.getMinutes() > 9 ? time.getMinutes() : '0' + time.getMinutes())
        ;
    }

    // Сохраяем data для получения пареметров в обработчике клика
    payload.data.data = payload.data;

    // Показываем уведомление
    return self.registration.showNotification(payload.data.title, payload.data);
});

// свой обработчик клика по уведомлению
self.addEventListener('notificationclick', function(event) {
    // извлекаем адрес перехода из параметров уведомления
    const target = event.notification.data.click_action || '/';
    event.notification.close();

    // этот код должен проверять список открытых вкладок и переключатся на открытую
    // вкладку с ссылкой если такая есть, иначе открывает новую вкладку
    event.waitUntil(clients.matchAll({
        type: 'window',
        includeUncontrolled: true
    }).then(function(clientList) {
        // clientList почему-то всегда пуст!?
        for (var i = 0; i < clientList.length; i++) {
            var client = clientList[i];
            if (client.url == target && 'focus' in client) {
                return client.focus();
            }
        }

        // Открываем новое окно
        return clients.openWindow(target);
    }));
});