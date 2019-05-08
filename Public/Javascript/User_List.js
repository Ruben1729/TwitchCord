var list = document.querySelector("#user-list > ul");
var input = document.querySelector("#user-list > #user-input");
var users;

const defaultPicturePath = "/Pictures/default.png";

//Setup event listeners
$(document).ready(function () {
    appendUsers();
    $("#user-list > #search-button").click(function () {
        //Clear past results
        clearList();
        appendUsers();
    });
});

function addEvent(event) {
    let userData = event.target.id;

    $.ajax({
        type: "POST",
        dataType: "text",
        url: "/Relation/Add/",
        data: { userData: userData }
    });

    disableAddButton(this);
}

function appendUsers() {
    //Gather all the users and append to the list (ul)
    getUserData()
        .done(function (data) {
            users = data;
            users.forEach(element => {
                list.append(renderUser(element));
            });
            //Setup event listeners
            $(list).find(".add-button").on("click", addEvent);
        })
}

function getUserData() {
    let json = $.getJSON("/Relation/SearchUser/", { username : input.value })
        .fail(function (data) {
            console.log('Error fetching users');
            console.log('Response: ' + data.responseText);
            //Default item
        });
    return json;
}

function renderUser(data) {
    let template = document.getElementsByTagName("template")[0];
    let clone = template.content.cloneNode(true);

    let user_img = clone.querySelector(".img-user");
    let username = clone.querySelector(".username");
    let button = clone.querySelector(".add-button");

    user_img.src = data.path || defaultPicturePath;
    username.innerHTML = data.username;
    button.id = data.user_id;
    //If the user_id is returned with the data, assume that they've already added them
    if (data.isAdded) {
        disableAddButton(button);
    }
    return clone;
}

function clearList() {
    list.innerHTML = "";
}

function disableAddButton(button) {
    button.disabled = true;
    button.innerHTML = 'Friend Added';
}