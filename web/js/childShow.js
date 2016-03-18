// First wait for the DOM to be ready
document.addEventListener('DOMContentLoaded', function(){
	// This function merely toggles the class
	function a(event) {
		event.stopPropagation();
		document.querySelector('body').classList.toggle('Child-Active');
	}
	function b() {
		document.querySelector('body').classList.remove('Child-Active');
	}
	// When the header is clicked we fire the function to toggle the class
	document.querySelector('.nav-button').addEventListener('click', a );
	document.querySelector('.notNav').addEventListener('click', b );

});