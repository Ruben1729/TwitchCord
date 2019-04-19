var list = document.querySelector("#channel-list > ul");
var input = document.querySelector("#channel-list > #channel-input");
var channels;

const defaultPicturePath = "/Pictures/default.png";

//Setup event listeners
$(document).ready(function () {
    appendChannels();
    $("#channel-list > #search-button").click(function () {
        //Clear past results
        clearList();
        appendChannels();
    });
});

function followEvent() {
    //Get index
    let index = $(this).index() - 1;
    let channel = channels[index];
    let followerData = {
        'user_id': user.uid,
        'channel_id': channel.channel_id,
        'followed_on': new Date().toISOString().slice(0, 19).replace('T', ' '),
        'notification': 1,
        'role_id': 1,
    }
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/Community/Follow",
        data: { follower_data: JSON.stringify(followerData) }
    });
    disableFollowButton(this);
}

function followNotLogged() {
    window.location.href = "/User/Register";
}

function appendChannels() {
    //Gather all the channels and append to the list (ul)
    getChannelData()
        .done(function (data) {
            channels = data;
            channels.forEach(element => {
                list.append(renderChannel(element));
            });
            //Setup event listeners
            $(list).find(".follow-button").on("click", user.uid ? followEvent : followNotLogged);
        })
}

function getChannelData() {
    let json = $.getJSON("/Community/ChannelList/", { channel_name: input.value })
        .fail(function (data) {
            console.log('Error fetching channels');
            console.log('Response: ' + data.responseText);
            //Default item
        });
    return json;
}

function renderChannel(data) {
    let template = document.getElementsByTagName("template")[0];
    let clone = template.content.cloneNode(true);

    let user_img = clone.querySelector(".img-user");
    let username = clone.querySelector(".username");
    let button = clone.querySelector(".follow-button");

    user_img.src = data.path || defaultPicturePath;
    username.innerHTML = data.channel_name;
    //If the user_id is returned with the data, assume that they've already followed them
    if (data.isFollowed) {
        disableFollowButton(button);
    }
    console.log(data);
    return clone;
}

function clearList() {
    list.innerHTML = "";
}

function disableFollowButton(button) {
    button.disabled = true;
    button.innerHTML = 'Followed';
}