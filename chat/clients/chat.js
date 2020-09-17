require('mysql');

const uuidv4 = require('uuid/v4'),
    fs = require('fs');

var connection = require('./mysql');
var stripTags = require('strip-tags');


/*Download the base64 image in the server and returns the filename and path of image.*/
function saveImage(baseImage, dir) {
    /*path of the folder where your project is saved. (In my case i got it from config file, root path of project).*/
    const uploadPath = "/home/jobscaner/www/server/frontend/web/img/chat";
    //path of folder where you want to save the image.
    const localPath = `${uploadPath}/` + dir;

    //Find extension of file
    const ext = baseImage.substring(baseImage.indexOf("/") + 1, baseImage.indexOf(";base64"));
    const fileType = baseImage.substring("data:".length, baseImage.indexOf("/"));
    //Forming regex to extract base64 data of file.
    const regex = new RegExp(`^data:${fileType}\/${ext};base64,`, 'gi');
    //Extract base64 data.
    const base64Data = baseImage.replace(regex, "");
    const filename = `${uuidv4()}.${ext}`;

    //Check that if directory is present or not.
    if (!fs.existsSync(localPath)) {
        fs.mkdirSync(localPath, 0x777, function (err) {
            if (err) {
                console.log(err);
                // echo the result back
                //response.send("ERROR! Can't make the directory! \n");
            }
        });
    }
    fs.writeFileSync(localPath + '/' + filename, base64Data, 'base64');
    try {
        const fd = fs.openSync(localPath + '/' + filename, "r");
        fs.fchmodSync(fd, 0x777);
        console.log("File permission change succcessful");
    } catch (error) {
        console.log(error);
    }
    return filename;

}

async function addMessage(data, socket, io) {
    let text = data.text !== undefined ? stripTags(data.text.trim()) : null;
    let photo = null;
    let roomIds = data.roomId;
    let test = '';
    let type = 'answer';
    let texIsset = "SELECT COUNT(message_id) as conM FROM `chat_message_to_rooms` WHERE room_id=" + data.roomId;

    connection.query(texIsset, function (err, result, fields) {
        if (result[0].conM > 0) {
            type = 'message';
        }else {
            type = 'answer';
        }
        console.log(type)
        let sql = "INSERT INTO `chat_message_to_rooms` (`room_id`,  `text` , `status`,`id` ,`type`  ) " +
            "VALUES (" + roomIds + ", \"" + text.replace(/"/g,"'") + "\" , 0 ,(SELECT id FROM `musers` WHERE socketId=\"" + socket.id + "\")," +
            " \"" + type + "\")";
        if (data.photo != undefined) {
            //photo = data.photo;
            test = saveImage(data.photo, roomIds);
            photo = '/img/chat/' + roomIds + '/' + test;
            console.log(photo)
            sql = "INSERT INTO `chat_message_to_rooms` (`room_id`, `photo` , `status` , `id`,`type` )" +
                " VALUES (" + roomIds + ", \"" + photo + "\" , 0 ,(SELECT id FROM `musers` WHERE socketId=\"" + socket.id + "\")) "+
                " \"" + type + "\")";
        }
        connection.query(sql, function (err, result, fields) {
            if (err) {
                console.log(err);
            } else {
                let sql = "SELECT musers2.socketId , musers.id, musers.online as usstatus, musers.logo, CONCAT(musers.firstname , \" \" , musers.lastname) as name," +
                    " chat_message_to_rooms.date ," +
                    " chat_message_to_rooms.text ,chat_message_to_rooms.photo, chr.type , chat_message_to_rooms.file , chat_message_to_rooms.status , chat_message_to_rooms.message_id " +
                    " from chat_message_to_rooms" +
                    " INNER JOIN musers on musers.id=chat_message_to_rooms.id" +
                    " INNER JOIN chat_rooms chr on chr.room_id=" + data.roomId + " " +
                    " INNER JOIN chat_user_to_rooms cutr on cutr.room_id=chat_message_to_rooms.room_id" +
                    " INNER JOIN musers musers2 on musers2.id=cutr.user_id AND musers2.id!=musers.id AND musers2.id!=0" +
                    ' WHERE `message_id`=' + result.insertId;
                connection.query(sql, function (err, result, fields) {
                    if (err) {
                        console.log(err);
                    } else {
                        let ret = [];
                        console.log(result)
                        ret.push(result[0]);
                        if (result[0].usstatus == 0) {
                            socket.to(result[0].socketId).emit('newmess', {'type': result[0].type});
                        }
                        io.sockets.in(roomIds).emit('message', {messages: ret});
                    }
                })
            }
        });
    });
}

async function writesMessage(date, socket, io) {

    let sql = 'SELECT CONCAT(musers.firstname , " " , musers.lastname) as name ,  musers.id FROM `musers` ' +
        'INNER JOIN chat_user_to_rooms chtr on musers.id=chtr.user_id AND chtr.room_id=' + date.roomId + ' WHERE musers.socketId="' + socket.id + '"';

    connection.query(sql, function (err, result, fields) {
        if (err) {
            console.log(err);
        } else {
            console.log(result);
            io.sockets.in(date.roomId).emit('writes', result[0])
        }
    })
}

async function getOldMessage(data, socket, io) {
    let ret = [];
    if (data.roomId !== undefined && undefined && data.offset) {
        await connection.query("SELECT musers.id, musers.online as usstatus, musers.avatar, CONCAT(musers.first_name , \" \" , musers.last_name) as name , chat_message_to_rooms.date ," +
            " chat_message_to_rooms.text ,chat_message_to_rooms.photo,chat_message_to_rooms.file , chat_message_to_rooms.status , chat_message_to_rooms.message_id " +
            " from chat_message_to_rooms" +
            " INNER JOIN user on musers.id=chat_message_to_rooms.id" +
            " INNER JOIN chat_user_to_rooms chur on chur.id=chat_message_to_rooms.id AND chur.room_id=" + data.roomId + " " +
            " WHERE chat_message_to_rooms.room_id=" + data.roomId + " " +
            " LIMIT 20 OFFSET " + parseInt(data.offset) * 20 +
            " ORDER by chat_message_to_rooms.message_id ASC",
            function (err, result, fields) {
                if (err) {
                    console.log(err)
                } else {
                    for (let i = 0; i < result.length; i++) {
                        if (result[i].id !== data.userId) {
                            var sql = "UPDATE `chat_message_to_rooms` SET status=1 WHERE message_id=" + result[i].message_id + " AND id=" + data.userId + "AND room_id=" + data.roomId;
                        }
                        ret.push(result[i]);
                    }
                    socket.emit('oldmessage', {message: ret})
                }
            });
    }
}

module.exports = {addMessage, writesMessage, getOldMessage};
