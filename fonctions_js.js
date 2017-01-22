function refuserToucheEntree(event)
{
	// A pour but d'éviter d'envoyer le forumulaire sur appui de la touche "Enter" depuis un Input (qui n'a pas l'attribut "submit")
	// Compatibilité IE / Firefox
	if(!event && window.event) {
		event = window.event;
	}
	// IE
	if(event.keyCode == 13) {
		event.returnValue = false;
		event.cancelBubble = true;
	}
	// DOM
	if(event.which == 13) {
		event.preventDefault();
		event.stopPropagation();
	}
}
