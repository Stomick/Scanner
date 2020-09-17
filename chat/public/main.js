socket.on('firstname', function(firstname){ // Создаем прослушку 'firstname' и принимаем переменную name в виде аргумента 'firstname'
    console.log('You\'r firstname is => ' + firstname); // Логгирование в консоль браузера
    $('textarea').val($('textarea').val() + 'You\'r firstname => ' + firstname + '\n'); // Выводим в поле для текста оповещение для подключенного с его ником
});

socket.on('newUser', function(firstname){ // Думаю тут понятно уже =)
    console.log('New user has been connected to chat | ' + firstname); // Логгирование
    $('textarea').val($('textarea').val() + firstname + ' connected!\n'); // Это событие было отправлено всем кроме только подключенного, по этому мы пишем другим юзерам в поле что 'подключен новый юзер' с его ником
});
socket.on('messageToClients', function(msg, name){
    console.log(name + ' | => ' + msg); // Логгирование в консоль браузера
    $('textarea').val($('textarea').val() + name + ' : '+ msg +'\n'); // Добавляем в поле для текста сообщение типа (Ник : текст)
});
$(document).on('click', 'button', function(){ // Прослушка кнопки на клик
    var message = $('input').val(); // Все что в поле для ввода записываем в переменную
    socket.emit('message', message); // Отправляем событие 'message' на сервер c самим текстом (message)- как переменная
    $('input').val(null); // Заполняем поле для ввода 'пустотой'
});