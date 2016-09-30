;(function () {
	'use strict';

	//To instantiate FastClick on the body, which is the recommended method of use
	window.addEventListener('load', function() {
	    new FastClick(document.body);
			console.log('FastClick initiated.');
	}, false);

}());
