'use strict';
const serverAddress = 'ws://127.0.0.1:1337'

/* Globals */
var groupchats = ['test group']; // get from php 
var curGroupChat = groupchats[0]; 
var connection = null;

window.onload = function(){
    //Start the websocket connection
    WS();
}; 

function WS(){
    window.WebSocket = window.WebSocket || window.MozWebSocket;

    connection = new WebSocket(serverAddress);

    connection.onopen = function(){
        //send client data
        connection.send(clientData('connect'));
    }

    connection.onerror = function(err){
        //TODO: error message popup

    }

    connection.onmessage = function(message){
        let data = JSON.parse(message.data);
        renderMsg(data);
    }

    connection.onclose = function(){
        setTimeout(() => {
            WS();
            console.log('Attemping to reconnect to server');
        }, 2000);
    }
}

function clientData(type){
    let data = {
        type: type,
        img: user.img,
        username: user.username,
        user_id: user.user_id,
        channel: channel,
        groupChat: curGroupChat
    };
    return JSON.stringify(data);
}

function renderMsg(msgData){
    let template = document.getElementsByTagName("template")[0];
    let clone = template.content.cloneNode(true);

    let img = clone.querySelector(".msg-img");
    let username = clone.querySelector(".username");
    let content = clone.querySelector(".msg-content");
    let timestamp = clone.querySelector(".timestamp");

    img.src = msgData.imgsrc;
    username.innerHTML = msgData.username;
    content.innerHTML = msgData.content;
    timestamp.innerHTML = new Date(msgData.date).timestamp();

    addToChat(clone);
}

function addToChat(element){
    let window = document.getElementById("window");
    let list = window.querySelector("ul");
    list.appendChild(element);
}

function sendMsg(){
    var input = document.querySelector("#chatbox-input");
    //Get user's details
    let data = {
        type: 'message',
        imgsrc: '',
        username: user.username,
        content: input.value,
        date: new Date().toISOString().slice(0, 19).replace('T', ' ')
    };
    //Clear chatbox
    input.value = '';
    //Send to server
    connection.send(JSON.stringify(data));
    renderMsg(data);
}

Date.prototype.timestamp = function(){
    return ((this.getHours() % 11) + 1).toString().padStart(2, '0') 
    + this.getMinutes().toString().padStart(2, '0')
    + this.getHours() <= 12 ? 'AM' : 'PM';
    
}