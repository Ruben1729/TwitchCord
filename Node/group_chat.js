'use strict';
const mysql = require('mysql');
const server = require('http').createServer();
const io = require('socket.io')(server);

//Helper
const OK = `OK`;
const ERROR = `ERROR`;
function Log(level, msg) {
  let dateString = new Date().toLocaleTimeString();
  console.log(`${dateString} = [${level}] ${msg}`);
}

//MySQL
var sql = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'test'
});

sql.connect();

//Websocket
io.on('connection', socket => {
  Log(OK, 'client has connected')

  socket.on('group-chat message', msg => {
    console.log(msg);
    socket.to(msg.group_chat).emit('message_recieved', msg)
  });

  socket.on('join group-chat', group_chat => {
    Log(OK, `User joined: ${group_chat}`);
    socket.join('room');
  });

});
server.listen(3000);

