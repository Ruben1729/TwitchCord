/* Globals */
var input = document.querySelector("#chatbox-input");
//Record input's max height
var inputel = document.getElementById("input").firstElementChild;
var max = window.getComputedStyle(inputel).getPropertyValue("max-height");
max = parseInt(max);

function expand_textarea(element){
    element.style.height = "5px";
    element.style.height = clampMax((element.scrollHeight + 5), max) + "px";
}

function clampMax(a, max){
    return a > max ? max : a;
}

// Websocket Handling

window.onload = function(){
    window.WebSocket = window.WebSocket || window.MozWebSocket;

    let connection = new WebSocket('ws://127.0.0.1:1337');

    connection.onopen = function(){

    }

    connection.onerror = function(err){

    }

    connection.onmessage = function(message){

    }
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
    //Get user's details
    let data = {};
    data.imgsrc = "";
    data.username = user.username; 
    data.content = input.value;
    data.timestamp = new Date().toLocaleDateString();
    //Clear chatbox
    input.value = '';

    renderMsg(data);
}