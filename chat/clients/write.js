'use strict';

const connection = require('./mysql');

async function writesMessage(data, socket) {
    let ret = [];
    if (data.roomId !== undefined && data.userId !== undefined) {
        socket.to('roomId' + data.roomId).emit('writesMessage', {name: 'Вася'});
    }
}

module.exports = writesMessage;
