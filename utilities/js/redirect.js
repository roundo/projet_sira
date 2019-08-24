"use strict";

document.getElementById('filtre').onchange = function(){
	
    window.location.href = this.children[this.selectedIndex].getAttribute('href');
}
