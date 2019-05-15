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
        console.log(SocketToUser);
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

    function getUsers(room) {
        let rooms = io.sockets.adapter.rooms;
        let _channel = rooms[room];
        if (_channel) {
            let online = {};
            for (let key in _channel.sockets) {
                let user = SocketToUser[key];
                online[user.user_id] = {
                    user_id: user.user_id,
                    username: user.username,
                    socket_id: key,
                };
            }
            return online;
        }
    }

    socket.on('get_online', channel => {
        let users = getUsers(channel);
        Log(OK, 'Sending online user list');
        socket.emit('online_users', users);
    });

    //Sending back 
    socket.on('group-chat_message', msg => {
        sql.getConnection((err, connection) => {
            if (err) console.log(err);
            //Store message on server
            let queryString = `
            INSERT INTO group_message 
            (text, group_chat_id, created_on, user_id)
            VALUES (?, ?, ?, ?)`;
            sql.query(queryString,
                [msg.text, msg.group_chat_id, msg.timestamp, msg.user_id],
                (error, results, fields) => {
                    if (error) Log(ERROR, 'Error occured while inserting into the database \n' + error)
                });
            connection.release();
        });
        socket.to(msg.group_chat).emit('message_recieved', msg);
    });

    function findSocket(user_id) {
        for (const key in SocketToUser) {
            if (SocketToUser.hasOwnProperty(key)) {
                const user = SocketToUser[key];
                if (user.user_id == user_id) {
                    return key;
                }
            }
        }
    }

    function yeet_user(query, config) {
        sql.getConnection((err, connection) => {
            if (err) console.log(err);
            sql.query(query, [config.user_id, config.channel_id], (error, results, fields) => {
                if (error) Log(ERROR, 'Error occured \n' + error)
            });
            connection.release();
        });
        //Find the user's socket
        let _socket = findSocket(config.user_id);
        if (_socket) {
            socket.to(_socket).emit('user_channel_out', config.channel_name);
        }
    }

    socket.on('kick-user', config => {
        yeet_user('DELETE FROM follower WHERE user_id = ? AND channel_id = ?', config);
    });

    socket.on('ban-user', config => {
        yeet_user(`DELETE FROM follower WHERE user_id = ? AND channel_id = ?`, config);
        //Ban the user from joining again
        sql.getConnection((err, connection) => {
            if (err) console.log(err);
            sql.query('INSERT INTO banned (user_id, channel_id) VALUES (?, ?)',
                [config.user_id, config.channel_id],
                (error, results, fields) => {
                    if (error) Log(ERROR, 'Error occured \n' + error);
                });
            connection.release();
        });
    });

    socket.on('live-chat_message', msg => {
        socket.to(msg.group_chat).emit('live_chat_message', msg);
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

    //Voice Chat Signalling
    socket.on('join_voice', voice => {
        //Send the users who are in the chat
        let room = voice.group_chat;

        Log(OK, `Client ID: ${socket.id}: Joining voice ${room}`);

        //Send back the user's in the room.
        let users = getUsers(room);
        socket.emit('recieve_peers', users);

        //Finally join the voice_chat room
        socket.join(room);
    });

    socket.on('leave_voice', voice => {
        Log(OK, `Client ID: ${socket.id}: Leaving Voice ${voice}`);
        socket.leave(voice);
    });

    socket.on('new_ICE_candidate', config => {
        Log(OK, `Client ID: ${socket.id}: Sending ICE Candidate`);
        socket.to(config.socket_id).emit('new_ICE_candidate', {
            user_id: config.user_id,
            candidate: config.candidate,
        });
    });

    socket.on('voice_chat_offer', config => {
        Log(OK, `Client ID: ${socket.id}: Sending Voice chat offer`);
        console.log(config);
        socket.to(config.socket_id).emit('voice_chat_offer', {
            user_id: config.user_id,
            my_socket_id: config.my_socket_id,
            socket_id: config.socket_id,
            sdp: config.sdp,
        })
    });

    socket.on('voice_chat_answer', config => {
        Log(OK, `Client ID: ${socket.id}: Sending Voice chat answer`);
        socket.to(config.socket_id).emit('voice_chat_answer', {
            sdp: config.sdp,
            user_id: config.user_id,
            socket_id: config.socket_id,
        });
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