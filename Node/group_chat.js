'use strict';

var WebSocketServer = require('websocket').server;
var mysql = require('mysql');
var http = require('http');

var sql = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : '',
  database : 'test'
});
 
sql.connect();

// Global Variables
// should follow: { username, group_chat, channel }
var clients = [];

var webSocketsServerPort = 1337;

var server = http.createServer(function(request, response) {
  // process HTTP request. Since we're writing just WebSockets
  // server we don't have to implement anything.
});
server.listen(webSocketsServerPort, function() {
  sLog('START', `Server is listening on port ${webSocketsServerPort}`);
});

// create the server
let wsServer = new WebSocketServer({
  httpServer: server
});

// WebSocket server
wsServer.on('request', function(request) {
  var connection = request.accept(null, request.origin);
  sLog('OK', `User has connected`);

  //Store the index of the client's connection
  var index = clients.push(connection) - 1;
  var user = null;

  connection.on('message', function(message) {
    if (message.type === 'utf8') {
      let data = JSON.parse(message.utf8Data);
      switch(data.type){
        case 'connect':
          handleConnect(data);
        break;
        case 'disconnect':
          handleDisconnect(data);
        break;
        case 'message':
          handleMessage(data);
        break;
        default:
          sLog('ERROR', `Unknown type: ${data.type}`);
        break;
      }
    }
  });
  
  connection.on('close', function(connection) {
    // close user connection
    sLog('OK', `User ${connection} has left`);
  });

  function handleConnect(data){
    user ={
      username: data.username,
      user_id: data.user_id,
      channel: data.channel,
      groupChat: data.groupChat,
      img: data.img
    };
  }
  
  function handleDisconnect(data){
    //Think about changing it to a dictionary in the future
    clients = clients.filter(user => user.username === data.username);  
  }
  
  function handleMessage(data){
    //Log message
    // TODO: finalize the db columns, might need channel id
    sql.query(`INSERT INTO group_message 
              (text, group_chat_id, created_on, user_id)
              VALUES (?, ?, STR_TO_DATE(?, 'YYYY-MM-DD HH:mm:ss'), ?)`,
              [data.content, 0, data.date, user.user_id],
               function(error, results, fields){
                if(error)
                sLog('ERROR', `Error inserting chat log \n${error}`);
              });
    console.log(data.date);
    //Send message back to other clients
    let json = JSON.stringify(data);
    for (let i = 0; i < clients.length; i++) {
      //avoid sending the message back to the sender
      if(i == index)
        continue;
      clients[i].send(json);
    }
  }

});

function sLog(level, msg){
  let date = new Date();
  let dateString = `${date.getDay()}/${date.getMonth()}/${date.getFullYear()} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
  console.log(`${dateString} = [${level}] ${msg}`);
}