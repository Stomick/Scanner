// firebase_subscribe.js

$(function () {
    subscribe();
});
firebase.initializeApp({
    apiKey: "AIzaSyB-_-Ts90mKWDbkaCBlW_PwYa31EM7UASM",
    authDomain: "hands-33ea9.firebaseapp.com",
    databaseURL: "https://hands-33ea9.firebaseio.com",
    projectId: "hands-33ea9",
    storageBucket: "hands-33ea9.appspot.com",
    messagingSenderId: "917642403764",
    appId: "1:917642403764:web:9593e70199f95f9dfe5ce1"
});

// браузер поддерживает уведомления
// вообще, эту проверку должна делать библиотека Firebase, но она этого не делает
if ('Notification' in window) {
    var messaging = firebase.messaging();

    // пользователь уже разрешил получение уведомлений
    // подписываем на уведомления если ещё не подписали
    if (Notification.permission === 'granted') {
        subscribe();
    }

}

function subscribe() {
    // запрашиваем разрешение на получение уведомлений
    messaging.requestPermission()
        .then(function () {
            // получаем ID устройства
            messaging.getToken()
                .then(function (currentToken) {

                    if (currentToken) {
                        sendTokenToServer(currentToken);
                    } else {
                        console.warn('Не удалось получить токен.');
                        setTokenSentToServer(false);
                    }
                })
                .catch(function (err) {
                    console.warn('При получении токена произошла ошибка.', err);
                    setTokenSentToServer(false);
                });
        })
        .catch(function (err) {
            console.warn('Не удалось получить разрешение на показ уведомлений.', err);
        });
}

// отправка ID на сервер
function sendTokenToServer(currentToken) {
    var url = '/settoken.html'; // адрес скрипта на сервере который сохраняет ID устройства
    var tok = $('input[name="_csrf"]');
    $.post(url, {_csrf:tok[0].value,
        userDate:{ token:currentToken,device:'web'}
    });
    if (!isTokenSentToServer(currentToken)) {
        setTokenSentToServer(currentToken);
    }
}

// используем localStorage для отметки того,
// что пользователь уже подписался на уведомления
function isTokenSentToServer(currentToken) {
    return window.localStorage.getItem('sentFirebaseMessagingToken') == currentToken;
}

function setTokenSentToServer(currentToken) {
    window.localStorage.setItem(
        'sentFirebaseMessagingToken',
        currentToken ? currentToken : ''
    );
}
