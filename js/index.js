$(document).ready(function () {
	// Live Clock
	var clockElement = $("#currentDate")[0];

	function clock() {
		clockElement.innerHTML = new Date().toLocaleString("en-US");
	}

	setInterval(clock, 1000);
});
