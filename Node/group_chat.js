'use strict';

var WebSocketServer = require('websocket').server;
var mysql = require('mysql');
var http = require('http');

var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : '',
  database : 'test'
});
 
connection.connect();

// Global Variables
// should follow: { username, group_chat, channel }
var clients = [];

var webSocketsServerPort = 1337;
var connection = null;

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
  connection = request.accept(null, request.origin);

  sLog('OK', `User has connected`);

  // This is the most important callback for us, we'll handle
  // all messages from users here.
  connection.on('message', function(message) {
    if (message.type === 'utf8') {
      // process WebSocket message
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
});

function sLog(level, msg){
  let date = new Date();
  let dateString = `${date.getDay()}/${date.getMonth()}/${date.getFullYear()} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
  console.log(`${dateString} = [${level}] ${msg}`);
}

function handleConnect(data){
  clients.push({
    username: data.username,
    channel: data.channel,
    groupChat: data.groupChat,
    img: data.img
  });
}

function handleDisconnect(data){
  //Think about changing it to a dictionary in the future
  clients = clients.filter(user => user.username === data.username);  
}

function handleMessage(data){
  //Log information
  //Send message back to other clients
  connection.send(JSON.stringify(data));
}