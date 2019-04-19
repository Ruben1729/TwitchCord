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

function errorLog(error, results, fields) {
  if (error)
    sLog(ERROR, `Error inserting chat log \n${error}`);
}

sql.connect();

//Websocket
io.on('connection', socket => {
  Log(OK, 'client has connected')

  socket.on('retrieve_messages', group => {
    let queryString = `
    SELECT text, group_chat_id, created_on, username, path FROM group_message
    INNER JOIN usermodel USING (user_id)
    LEFT JOIN picturemodel USING (picture_id)
    WHERE group_chat_id = ?`
    sql.query(queryString, group.group_chat_id,
      (error, results, fields) => {
        if (error)
          sLog(ERROR, `Error inserting chat log \n${error}`);
        socket.to(socket.id).emit('message_history', resutls);
      });
  });

  socket.on('group-chat_message', msg => {
    //Store message on server
    let queryString = `
    INSERT INTO group_message 
    (text, group_chat_id, created_on, user_id)
    VALUES (?, ?, ?, ?)`
    sql.query(queryString, [msg.content, msg.group_chat_id, data.timestamp, msg.user.user_id], errorLog);
    //Send message to all those who are connected to the group_chat
    socket.to(msg.group_chat).emit('message_recieved', msg)
  });

  socket.on('join_group-chat', group_chat => {
    Log(OK, `User joined: ${group_chat}`);
    socket.join(group_chat);
  });

});
server.listen(3000);

