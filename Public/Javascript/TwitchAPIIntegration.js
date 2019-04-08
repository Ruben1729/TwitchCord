function getToken(code){
	let Http = new XMLHttpRequest();
	let tokenURL = "https://id.twitch.tv/oauth2/token?client_id=bo0nrcahpqfeh6i73cthasv3ysbz1r&client_secret=8bm969bpoi4c5lnma2o6ixu8hj9gmw&code=`{$code}`&grant_type=authorization_code&redirect_uri=http://localhost/Channel/Create"
	Http.open("POST", tokenURL);
	Http.send();
	Http.onreadystatechange=function(){
		if(this.readyState==4 &&this.status==200){
			console.log(Http.responseText);
		}
	}
}

function getUserName(token){
	let Http = new XMLHttpRequest();
	let url = 'https://api.twitch.tv/helix/users';
	Http.setRequestHeader('Authorization', "Bearer `{$token}`");
	Http.setRequestHeader('client-id', "bo0nrcahpqfeh6i73cthasv3ysbz1r");

	Http.open("GET", url);
	Http.send();
	Http.onreadystatechange=function(){
		if(this.readyState==4 &&this.status==200){
			console.log(Http.responseText);
		}
	}

}

/*POST https://id.twitch.tv/oauth2/revoke
    ?client_id=<your client ID>
    &token=<your OAuth token>*/
function revokeToken(clientID, token){

}

function refresh(clientID, clientSecret, token){

}