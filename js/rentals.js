function loadGoogleMap(lat, lng) {
	var pos = new google.maps.LatLng(lat, lng);
	var mapOptions = {
		center: pos, /* set in serverside template */
		zoom: 13,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var google_map = new google.maps.Map(document.getElementById('js-rentals-location-map'), mapOptions);
	var google_map_marker = new google.maps.Marker({
		position: pos,
		map: google_map
	});
}

function doReverseGeocode(lat, lng, dom_id) {
	$.get('https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&language=no', function(r) {
		if (typeof r.status != "undefined" && r.status == "OK") {
			$(dom_id).text(r.results[0].formatted_address)
		}
	}, 'json');
}

function loadDateRangePicker(car_dates_unavailable, overridden_price_dates, changeCallback) {
	$('#page-rentals-create').find('.input-daterange').datepicker({
		format: "dd.mm.yyyy",
		language: "nb",
		calendarWeeks: true,
		startDate: new Date(),
		weekStart: 1,
		beforeShowDay: function (date) {
			var d = moment(date).format('YYYY-MM-DD');
			if (car_dates_unavailable.indexOf(d) > -1) {
				return false;
			}
			if (overridden_price_dates[d]) {
				return {
					tooltip: 'Utleie pris denne datoen er ' + overridden_price_dates[d] + ' poeng',
					classes: 'override_price'
				}
			}
			// There is a bug in Bootstrap Datepicker that causes the previously set tooltip to persist across dates
			// unless explictly set to a non-null/false value. As a hack, set tooltip to a space, which is not displayed in
			// most(?) browsers.
			return {
				tooltip: ' ',
				classes: ''
			};
		}
	})
	.on('changeDate', changeCallback);
}

function handleDateChange(e, car_dates_unavailable, overridden_price_dates, weekday_price, weekend_price, dates_dom_id, price_dom_id, ajaxtgt) {
	var nothing_selected_html = '<em>Ingen periode valgt</em>',
		$tgt = $(dates_dom_id);

	// FIXME! This should be injected
	$('input[name="from_date"]').val('');
	$('input[name="to_date"]').val('');

	if (typeof e.date == "undefined") {
		$tgt.html(nothing_selected_html);
		return;
	}
	var which = $(e.target).attr('name');

	$tgt.data(which, e.date);

	// Do we have both dates?
	if ($tgt.data("from") && $tgt.data("to")) {
		var from = moment($tgt.data("from")).format('YYYY-MM-DD'),
			to = moment($tgt.data("to")).format('YYYY-MM-DD'),
			invalid_html = '<span class="invalid">Bilen er ikke tilgjengelig i hele den valgte perioden. Vennligst velg dato på nytt</span>';

		// Check if this is a valid range by checking if this range overlaps any dates in the
		// car_dates_unavailable ("CDU") range.

		// Make a copy of CDU, insert the from and to dates, and sort the list. If the indexOf
		// from and to aren't adjacent, and they're not the same date, they overlap CDU dates, and is invalid
		var cdu = $.extend([], car_dates_unavailable);
		cdu.push(to);
		cdu.push(from);
		cdu.sort();
		if (to != from && cdu.indexOf(to) != cdu.indexOf(from) + 1) {
			$tgt.html(invalid_html);
		}
		else {
			$tgt.html(getRentalHtml(from, to, weekday_price, weekend_price, overridden_price_dates, dates_dom_id));
			$(price_dom_id).load(ajaxtgt, { from_date: from, to_date: to});
		}
	}
	else {
		$tgt.html(nothing_selected_html);
	}
}

function getRentalHtml(from, to, weekday_price, weekend_price, overridden_price_dates, tgt_dom_id) {
	var $tgt = $(tgt_dom_id);
	var mfrom = moment(from);
	var mto = moment(to);

	var days = [];

	// Utility function to display a date locale formatted. Will show year if not the current year.
	var getDisplayDate = function(mdate) {
		return mdate.year() == (new Date()).getYear()
				? mfrom.format("D. MMMM")
				: mfrom.format("D. MMMM YYYY");
	};
	// Checks if theres a override price for the given date, if not returns either
	// weekend or weekday price given the date
	var getPrice = function(mdate, weekday_price, weekend_price, overridden_price_dates) {
		var d = mfrom.format('YYYY-MM-DD');
		if (typeof overridden_price_dates[d] != "undefined") {
			return parseInt(overridden_price_dates[d]);
		}
		// 6 == Saturday, 0 == Sunday
		return mfrom.day() == 6 || mfrom.day() == 0
			? parseInt(weekend_price)
			: parseInt(weekday_price);
	};

	// Build an array of dates and its price
	var price, total = 0;
	while (mfrom.diff(mto) - 86400000) {
		price = getPrice(mfrom, weekday_price, weekend_price, overridden_price_dates);
		days.push([
			getDisplayDate(mfrom),
			price
		]);
		total += price;
		mfrom.add(1, 'days');
	}

	var prices_html = '<dl class="breakdown">';
	$.each(days, function(i) {
		prices_html += '<dt>' + days[i][0] + '</dt><dd><span class="points">'+ days[i][1] +'</span></dd>';
	});
	prices_html += "</dl>";

	$tgt.html(prices_html);

	// FIXME! This should be injected
	$('input[name="from_date"]').val(moment(from).format('YYYY-MM-DD'));
	$('input[name="to_date"]').val(moment(to).format('YYYY-MM-DD'));
}