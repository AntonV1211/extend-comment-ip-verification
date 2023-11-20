document.addEventListener("DOMContentLoaded", function(){
	getIP();
});

function getIP() {
	fetch('https://ipapi.co/json/')
	  .then(data => data.json())
	  .then(data => setIP(data))
}

function setIP(ipJson) {
	let inputIpElement = document.querySelector("#client-ip");
	let ipUser = ipJson.ip;
	inputIpElement.value = ipUser;
}