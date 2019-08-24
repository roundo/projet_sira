	"use strict";

	function message ()
	{
		if( document.getElementById('sendMessage') != null )
			document.getElementById('sendMessage').classList.toggle('hide');
	}

	function chrono()
	{
		setTimeout(message, 4000);
	}

	document.addEventListener( "DOMContentLoaded", chrono ); 