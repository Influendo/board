;(function() {

	window.Locale = {
		months: [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ],
		weekdays: [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ]
	}

	if (!window.Intl || typeof window.Intl !== 'object') {
		return;
	}

	let _lcf = function(str) {
		return str.charAt(0).toUpperCase() + str.slice(1);
	}

	window.Locale.months = [];
    for (var i = 0; i < 12; i++) {
        let val = new Date(2000, 0 + i, 10).toLocaleString(undefined, { month: 'long' });
        val = _lcf(val);

        window.Locale.months.push(val);
    }

    window.Locale.weekdays = [];
    for (var i = 0; i < 7; i++) {
        let val = new Date(2000, 0, 10 + i).toLocaleString(undefined, { weekday: 'long' });
        val = _lcf(val);

        window.Locale.weekdays.push(val);
    }

})();
