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
var sql = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'test'
});

function errorLog(error, results, fields) {
  if (error)
    Log(ERROR, `Error inserting chat log \n${error}`);
}

//Websocket
io.on('connection', socket => {
  Log(OK, 'client has connected ID: ' + socket.id)

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


  //Sending back 
  socket.on('group-chat_message', msg => {
    sql.getConnection((err, connection) => {
      //Store message on server
      let queryString = `
      INSERT INTO group_message 
      (text, group_chat_id, created_on, user_id)
      VALUES (?, ?, ?, ?)`
      sql.query(queryString, [msg.text, msg.group_chat_id, msg.timestamp, msg.user_id], errorLog);
      connection.release();
    });
    socket.to(msg.group_chat).emit('message_recieved', msg);
  });

  socket.on('join_group-chat', group_chat => {
    Log(OK, `User joined: ${group_chat}`);
    socket.join(group_chat);
  });

});
server.listen(3000);

const SQLMSGHistory = `
SELECT text, group_chat_id, username, path, 
group_message.created_on as 'timestamp'
FROM group_message
INNER JOIN usermodel USING (user_id)
LEFT JOIN profilemodel USING (user_id)
LEFT JOIN picturemodel USING (picture_id)
WHERE group_chat_id = ?`;