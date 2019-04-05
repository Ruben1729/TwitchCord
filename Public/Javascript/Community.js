'use strict';

/* Globals */
var groupchats = ['test group']; // get from php 
var curGroupChat = groupchats[0]; 
var connection = null;

// Websocket Handling
window.onload = function(){
    window.WebSocket = window.WebSocket || window.MozWebSocket;

    connection = new WebSocket('ws://127.0.0.1:1337');

    connection.onopen = function(){
        //send client data
        connection.send(clientData('connect'));
    }

    connection.onerror = function(err){
        //TODO: error message popup
    }

    connection.onmessage = function(message){
        let data = JSON.parse(message);
        renderMsg(data);
    }
}

function clientData(type){
    let data = {
        type: type,
        img: user.img,
        username: user.username,
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
    timestamp.innerHTML = msgData.timestamp;

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
        timestamp: new Date().toLocaleTimeString()
    };
    //Clear chatbox
    input.value = '';
    //Send to server
    connection.send(JSON.stringify(data));
    renderMsg(data);
}