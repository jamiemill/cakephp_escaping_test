/**
* TODO: would be nice to be able to hover and get a list of parent divs classes/IDs so you know where to start looking.
*/
var EscTest = {
	chk: function(name) {
		var warningText = 'Vulnerable field: '+name;
		throw (warningText);
		document.write('<div style="width:100%;min-height:2em;background-color:red;color:white;padding:0.5em">'+warningText+'</div>');
	}
}
