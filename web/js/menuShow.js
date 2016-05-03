// First wait for the DOM to be ready
document.addEventListener('DOMContentLoaded', function(){
	// This function merely toggles the class
	function a(event) {
		event.stopPropagation();
		document.querySelector('body').classList.toggle('OffCanvas-Active');
	}
	function b() {
		document.querySelector('body').classList.remove('OffCanvas-Active');
	}
	// When the header is clicked we fire the function to toggle the class
	document.querySelector('.off-canvas-launcher').addEventListener('click', a );
	document.querySelector('.notNav').addEventListener('click', b );

});