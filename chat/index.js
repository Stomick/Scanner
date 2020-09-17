var express = require('express');
var fs = require('fs');
var app = express();
var options = {
    key: fs.readFileSync('/etc/letsencrypt/live/test.jobscanner.online/privkey.pem'), // PRIVATE KEY
    cert: fs.readFileSync('/etc/letsencrypt/live/test.jobscanner.online/fullchain.pem') // CERTIFICATE
};
var server = require('https').createServer(options,app);

const io = require('socket.io').listen(server),
    Rooms = require('./clients/rooms'),
    Message = require('./clients/chat'),
    Chat  = require('./clients/join'),
    port = process.env.PORT || 3000,
    log4js = require('log4js'), // Подключаем наш логгер
    logger = log4js.getLogger();


logger.debug('Script has been started...'); // Логгируем.
/*
app.get('/', function (req, res) {
//    respons.json(chat.getRooms(1));
    //res.sendFile(__dirname + '/public/index.html');
});


 */
users = [];
connections = [];
io.on('connection', function (socket) {
    Chat.connect(socket);

    socket.on('getRooms', async function (data) {
        await Rooms.getRooms(data , socket);
    });

    socket.on('getRoom' , async function (data) {
        await Rooms.getRoom(data , socket );
    });

    socket.on('joinToRoom', async function (data) {
        Chat.joinToRoom(data , socket , io);
    });

    socket.on('leaveFromRoom', async function (data) {
        await Chat.leaveFromRoom(data);
    });

    socket.on('message', async function (data) {
        await Message.addMessage(data , socket, io);
    });

    socket.on('writes' , async function (data) {
        await Message.writesMessage(data , socket, io );
        console.log(data);
    });

    socket.on('disconnect', async function () {
       await Chat.disconnect(socket);
    });

});

server.listen(port, function () {
    console.log('listening on *:' + port);
});
