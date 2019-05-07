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
    console.log("Followed");
    //Get index
    let index = $(this).index() - 1;
    let channel = channels[index];
    let followerData = {
        'user_id': user.uid,
        'channel_id': channel.channel_id,
        'followed_on': new Date().toISOString().slice(0, 19).replace('T', ' '),
        'notification': 1,
        'role_id': 1,
    };
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/Community/Follow",
        data: { follower_data: JSON.stringify(followerData) }
    });
    this.innerHTML = 'Followed';
    $(this).on("click", unfollowEvent);
}

function unfollowEvent() {
    console.log("Unfollowed");
    let index = $(this).index() - 1;
    let channel = channels[index];
    let info = {
        user_id: user.uid,
        channel_id: channel.channel_id,
    };
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/Community/Unfollow",
        data: { info: JSON.stringify(info) }
    });
    this.innerHTML = 'Follow';
    $(this).on("click", followEvent);
}

function appendChannels() {
    //Gather all the channels and append to the list (ul)
    getChannelData()
        .done(function (data) {
            channels = data;
            channels.forEach(element => {
                list.append(renderChannel(element));
            });
        })
}

function getChannelData() {
    let json = $.getJSON("/Community/ChannelList/", { channel_name: input.value })
        .fail(function (data) {
            console.log('Error fetching channels');
            console.log('Response: ' + data.responseText);
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
        $(button).on("click", unfollowEvent);
        button.innerHTML = 'Followed';
    } else {
        $(button).on("click", followEvent)
    }
    console.log(data);
    return clone;
}

function clearList() {
    list.innerHTML = "";
}