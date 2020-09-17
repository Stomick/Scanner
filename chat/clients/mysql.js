'use strict';

const mysql = require('mysql');
const uuidv4 = require('uuid/v4');

var connection = mysql.createConnection({
    host: "localhost",
    port: 3306,
    user: "scanner",
    password: "Zaqwsx123!",
    database: "scanner"
});
connection.connect();
module.exports = connection;
