function getToken(code){
	let Http = new XMLHttpRequest();
	let tokenURL = `https://id.twitch.tv/oauth2/token?client_id=bo0nrcahpqfeh6i73cthasv3ysbz1r&client_secret=8bm969bpoi4c5lnma2o6ixu8hj9gmw&code=${code}&grant_type=authorization_code&redirect_uri=http://localhost/Channel/Create`
	Http.open("POST", tokenURL);
	Http.send();
	Http.onreadystatechange=function(){
		if(this.readyState==4 &&this.status==200){
			return getUserName(JSON.parse(Http.responseText)['access_token']);
		}
	}
}

function getUserName(token){
	let Http = new XMLHttpRequest();
	let url = 'https://api.twitch.tv/helix/users';
	Http.open("GET", url);

	Http.setRequestHeader('Authorization', `Bearer ${token}`);
	Http.setRequestHeader('client-id', "bo0nrcahpqfeh6i73cthasv3ysbz1r");

	Http.send();
	Http.onreadystatechange=function(){
		if(this.readyState==4 &&this.status==200){
 			console.log((JSON.parse(Http.responseText)['data'][0]['display_name']));
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