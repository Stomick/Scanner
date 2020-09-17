'use strict';

const connection = require('./mysql');


async function messageInRoom(data, io) {

}

async function joinToRoom(data, socket , io) {
    let ret = [];
    console.log('join', data);
    if (data.roomId !== undefined) {
        socket.join(data.roomId);
        var sql = "UPDATE `chat_user_to_rooms` SET `status`=1, `socketId`=\""+socket.id+"\" WHERE user_id=(SELECT id from musers where socketId=\""+socket.id+"\")" + " AND room_id=" + data.roomId;
        await connection.query(sql,function (err, result, fields) {
            if (err) {
                console.log(err)
            }
        });
        console.log('join', sql);
        await connection.query("SELECT musers.id, musers.online as usstatus, musers.logo, CONCAT(musers.firstname , \" \" , musers.lastname) as name," +
            " chat_message_to_rooms.date ," +
            " chat_message_to_rooms.text ,chat_message_to_rooms.photo , chat_message_to_rooms.file , chat_message_to_rooms.status , chat_message_to_rooms.message_id " +
            " from chat_message_to_rooms" +
            " INNER JOIN musers on musers.id=chat_message_to_rooms.id" +
//            " INNER JOIN chat_user_to_rooms chur on chur.id=chat_message_to_rooms.id AND chur.room_id=" + data.roomId + " " +
            " WHERE chat_message_to_rooms.room_id=" + data.roomId + " " +
            " ORDER by chat_message_to_rooms.message_id ASC" +
            " LIMIT 50 OFFSET 0",
            function (err, result, fields) {
                if (err) {
                    console.log(err)
                } else {
                    let ret = [];
                    let mread = [];
                    for (let i = 0; i < result.length; i++) {
                        if(result[i].id !== data.userId) {
                            sql = "UPDATE `chat_message_to_rooms` SET status=1 WHERE message_id=" + result[i].message_id ;
                            connection.query(sql);
                            result[i].status = 0;
                            mread.push(result[i]);
                        }
                        ret.push(result[i]);
                    }
                    if(mread.length > 0){
                        io.sockets.in(data.roomId).emit('mread' , mread );
                    }
                    socket.emit('message', {'messages' :ret})
                }
            });
    }
}

async function leaveFromRoom(data, socket) {
    let ret = [];
    if (data.roomId !== undefined && data.userId !== undefined) {
        socket.leave(data.roomId);
        var sql = "UPDATE `chat_user_to_rooms` SET `status`=0 WHERE id=" + data.userId + " AND room_id=" + data.roomId;
        connection.query(sql);
    }
}

async function connect(socket) {
    if (socket.handshake.query.token !== undefined) {
        let userId = socket.handshake.query.token;
        let sql = "UPDATE `musers` SET online=1 , socketId=\"" + socket.id + "\" WHERE token=\"" + userId + "\"";
        connection.query(sql , function (err, result, fields) {
            if (err) {
                console.log(err)
            }else {
                console.log(socket.id)
            }

        });
    }
}

async function disconnect(socket) {
    var sql = "UPDATE `musers` SET `online`=0  WHERE socketId=\"" + socket.id + "\"";
    connection.query(sql);
    sql = "UPDATE `chat_user_to_rooms` SET `status`=0 WHERE user_id=(SELECT id from musers where socketId=\""+socket.id+"\")";
    connection.query(sql);

}

module.exports = {joinToRoom, leaveFromRoom, messageInRoom, connect, disconnect};
