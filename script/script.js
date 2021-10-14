var head = document.getElementsByTagName('HEAD')[0];  
var meta = document.createElement('meta');
meta.name = 'viewport';
meta.content = 'width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=0';
head.appendChild(meta);

var thisScript = document.currentScript;

var element = document.getElementById('text');

try{
	console.log(window.location.hostname);
	var imported = document.createElement('script'); 

	imported.src = 'https://ventureby.com/shopify_popup_app/script/desktop.js?v1='+Date.now();
	
	document.head.appendChild(imported);

}
catch(err) {
	console.error(err);
	window.stop(); 
}