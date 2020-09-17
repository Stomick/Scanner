'use strict';

const connection = require('./mysql');

async function getRooms(data, socket) {
    let ret = [];
    if (data.userId !== undefined) {
        await connection.query("SELECT chutr.room_id , user2.id as userId , chmtr.text, chmtr.date, chmtr.status , CONCAT(user.first_name , \" \" , user.last_name) as name," +
            " user2.avatar," +
            " (SELECT count(message_id) FROM chat_message_to_rooms WHERE room_id=chutr.room_id AND status=0 AND user_id !="+data.userId+") as newmess " +
            " FROM chat_user_to_rooms chutr" +
            " LEFT JOIN chat_message_to_rooms chmtr on chmtr.room_id=chutr.room_id AND chmtr.message_id=(SELECT max(message_id) FROM chat_message_to_rooms WHERE chat_message_to_rooms.room_id=chutr.room_id)" +
            " INNER JOIN user on user.user_id=chmtr.user_id" +
            " INNER JOIN user user2 on user2.id=(SELECT chat_user_to_rooms.user_id FROM chat_user_to_rooms WHERE chat_user_to_rooms.room_id=chutr.room_id AND chat_user_to_rooms.user_id!=" + data.userId + ")" +
            " where chutr.user_id=(SELECT user_id FROM `musers` WHERE socketId=\"" + socket.id + "\")", function (err, result, fields) {
            if (err){
                console.log(err)
            }else {

                for (let i = 0; i < result.length; i++) {
                    ret.push(result[i]);
                }
                socket.emit('getRooms', {rooms : ret});
            }
        });
    }
}

async function getRoom(data, socket) {
    let sqlstr = "SELECT chr.room_id as roomId, " +
        " CONCAT(user.firstname , \" \" , user.lastname) as name , user_details.userAvatar " +
        " FROM chat_rooms as chr" +
        " INNER JOIN chat_user_to_rooms cur1 on cur1.room_id=chr.room_id" +
        " INNER JOIN chat_user_to_rooms cur2 on cur2.room_id=chr.room_id" +
        " INNER JOIN user on user.user_id=" +data.userTo+
        " INNER JOIN user_details on user.user_id=" +data.userTo+
        " WHERE cur1.user_id="+data.userTo+" AND cur2.user_id=(SELECT user_id FROM `musers` WHERE socketId=\"" + socket.id + "\")";
    connection.query( sqlstr, function (err, result, fields) {
        if (err){
            console.log(err)
        }
        if (result.length === 0) {
            let sql = "INSERT INTO `chat_rooms` (`type`,`type_id`) VALUES ('user' , 0)";
            connection.query(sql, function (err, result, fields) {
                if (err) {
                    console.log(err);
                } else {
                    var roomIds = result.insertId;
                    var sql = "INSERT INTO `chat_user_to_rooms` (`user_id`,`room_id`) VALUES ("+data.userTo+","+roomIds+"); ";
                    connection.query(sql);
                    sql = "INSERT INTO `chat_user_to_rooms` (`user_id`,`room_id`) VALUES ((SELECT user_id FROM `musers` WHERE socketId=\"" + socket.id + "\"),"+roomIds+"); ";
                    connection.query(sql);
                    /*
                    sql = "INSERT INTO `chat_message_to_rooms` (`room_id`, `user_id`, `text`) VALUES ("+roomIds+", "+data.userFrom+", \""+data.text+"\"); ";
                    connection.query(sql);

                     */
                    connection.query(sqlstr,function (err, result, fields){
                        socket.emit('getRoom', result[0])
                    });
                }
            })
        }else {
            let roomIds = result[0].room_id;
            socket.emit('getRoom', result[0])

        }
    });
}

module.exports = {getRooms , getRoom};
