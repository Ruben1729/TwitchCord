var list = document.querySelector("#channel-list > ul");
var input = document.querySelector("#channel-list > #channel-input");

const defaultPicturePath = "/Pictures/default.png";

//Setup event listeners
$(document).ready(function(){
    appendChannels();
    $("#channel-list > #search-button").click(function(){
        //Clear past results
        list.innerHTML = "";
        console.log("fetching channels");
        appendChannels();
        console.log("finished");
    });
});

function appendChannels(){
    //Gather all the channels and append to the list (ul)
    getChannelData()
    .done(function(data){
        data.forEach(element => {
            list.append(renderChannel(element));
        });
    })
    .fail(function(){

    });
}

function getChannelData(){
    let json = $.getJSON("/Community/ChannelList/" + input.value)
    .done(function(data){
        return data;
    })
    .fail(function(data){
        console.log('Error fetching channels');
        console.log('Response: ' + data.responseText);
        //Default item
    });
    return json;
}

function renderChannel(data){
    let template = document.getElementsByTagName("template")[0];
    let clone = template.content.cloneNode(true);

    let user_img = clone.querySelector(".img-user");
    let username = clone.querySelector(".username"); 

    user_img.src = data.imgsrc || defaultPicturePath;
    username.innerHTML = data.channel_name;
    return clone;
}