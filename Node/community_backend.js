'use strict';
const mysql = require('mysql');
const server = require('http').createServer();
const io = require('socket.io')(server);
const mysqlEvents = require('mysql-events');

//Helper
const OK = `OK`;
const ERROR = `ERROR`;
function Log(level, msg) {
    let dateString = new Date().toLocaleTimeString();
    console.log(`${dateString} = [${level}] ${msg}`);
}

//MySQL
const dsn = {
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'test'
}

var sql = mysql.createPool(dsn);
var sqlWatcher = mysqlEvents(dsn);


//Socket.IO
var SocketToUser = {};

io.on('connection', socket => {
    Log(OK, 'client has connected ID: ' + socket.id)

    socket.on('disconnect', () => {
        Log(OK, 'client has disconnected ID: ' + socket.id);
        //Cleanup user that has left.
        socket.leaveAll();
        delete SocketToUser[socket.id];
        console.log(io.sockets.adapter.rooms);
    });

    socket.on('register_user', user => {
        Log(OK, 'Registering User ' + user.username);
        SocketToUser[socket.id] = user;
    });

    socket.on('retrieve_messages', group => {
        sql.getConnection((err, connection) => {
            let ioSocket = socket;
            connection.query(SQLMSGHistory, group.group_chat_id, (error, results, fields) => {
                //Send message history to the client who asked
                console.log('Sending history to: ' + ioSocket.id);
                ioSocket.emit('message_history', results);
            });
            connection.release();
        });
    });

    socket.on('get_online', channel => {
        let rooms = io.sockets.adapter.rooms;
        let _channel = rooms[channel];
        if (_channel) {
            let online = {};
            Object.keys(_channel.sockets).forEach(key => {
                if (SocketToUser[key]) {
                    let user_id = SocketToUser[key].user_id;
                    online[user_id] = true;
                }
            });
            socket.emit('online_users', online);
        }
    });

    //Sending back 
    socket.on('group-chat_message', msg => {
        sql.getConnection((err, connection) => {
            if (err) console.log(err);
            //Store message on server
            let queryString = `
            INSERT INTO group_message 
            (text, group_chat_id, created_on, user_id)
            VALUES (?, ?, ?, ?)`
            sql.query(queryString,
                [msg.text, msg.group_chat_id, msg.timestamp, msg.user_id],
                (error, results, fields) => {
                    if (error) Log(ERROR, 'Error occured while inserting into the database \n' + error)
                });
            connection.release();
        });
        socket.to(msg.group_chat).emit('message_recieved', msg);
    });

    socket.on('live-chat_message', msg => {
        socket.to(msg.group_chat).emit('message_recieved', msg);
    });

    socket.on('join_group-chat', group => {
        Log(OK, `Client ID: ${socket.id}: Joining Group ${group}`);
        socket.join(group);
    });

    socket.on('leave_group-chat', group => {
        Log(OK, `Client ID: ${socket.id}: Leaving Group ${group}`);
        socket.leave(group);
    });

    socket.on('join_channel', channel => {
        Log(OK, `Client ID: ${socket.id}: Joining Channel ${channel}`);
        socket.join(channel);
    });

    socket.on('leave_channel', channel => {
        Log(OK, `Client ID: ${socket.id}: Leaving Channel ${channel}`);
        socket.leave(channel);
    });
});
server.listen(3000);

const SQLMSGHistory = `
SELECT text, group_chat_id, username, path, 
group_message.created_on as 'timestamp'
FROM group_message
INNER JOIN user USING (user_id)
LEFT JOIN profile USING (user_id)
LEFT JOIN picture USING (picture_id)
WHERE group_chat_id = ?`;