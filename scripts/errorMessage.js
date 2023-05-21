/** @format */

function getUrlParameter(name) {
	name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
	var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
	var results = regex.exec(location.search);
	return results === null
		? ''
		: decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Function to display error message
function displayErrorMessage() {
	var error = getUrlParameter('error');
	if (error !== '') {
		var errorElement = document.getElementById('error-message');
		errorElement.innerText = error;
		errorElement.style.display = 'block';
	}
}
