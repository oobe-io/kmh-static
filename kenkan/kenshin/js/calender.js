/* 日本語対応 */
/* Japanese initialisation for the jQuery UI date picker plugin. */
/* Written by Kentaro SATO (kentaro@ranvis.com). */
( function( factory ) {
	"use strict";

	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define( [ "../widgets/datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
} )( function( datepicker ) {
"use strict";

datepicker.regional.ja = {
	closeText: "閉じる",
	prevText: "&#x3C;前",
	nextText: "次&#x3E;",
	currentText: "今日",
	monthNames: [ "1月", "2月", "3月", "4月", "5月", "6月",
	"7月", "8月", "9月", "10月", "11月", "12月" ],
	monthNamesShort: [ "1月", "2月", "3月", "4月", "5月", "6月",
	"7月", "8月", "9月", "10月", "11月", "12月" ],
	dayNames: [ "日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日" ],
	dayNamesShort: [ "日", "月", "火", "水", "木", "金", "土" ],
	dayNamesMin: [ "日", "月", "火", "水", "木", "金", "土" ],
	weekHeader: "週",
	dateFormat: "yy/mm/dd",
	firstDay: 0,
	isRTL: false,
	showMonthAfterYear: true,
	yearSuffix: "年" };
datepicker.setDefaults( datepicker.regional.ja );

return datepicker.regional.ja;

} );

// 非表示設定
$(function() {
	$(".datepicker").datepicker({
		dateFormat: 'yy/mm/dd(D)',
		//firstDay: 1,
		minDate: 14,
		maxDate: '+1y',
		showOtherMonths: true,
		selectOtherMonths: true,
		changeYear: true,
		changeMonth: true,
		// showButtonPanel: true,
		// closeText: false,
		beforeShowDay: function (date) {
			var ymd = date.getFullYear() + ('0' + (date.getMonth() + 1)).slice(-2) + ('0' +  date.getDate()).slice(-2);
			if (holidays.indexOf(ymd) != -1) {
				// 祝日
				return [false, 'ui-state-disabled'];
			} else if (date.getDay() == 0 || date.getDay() == 6) {
				// 土・日休診日
				return [false, 'ui-state-disabled'];
			} else {
				// 平日
				return [true, ''];
			}
		}
	});
	$("#birthday").change(function() {
		if($("#birthday").val() != '') {
			var birthday = ($("#birthday").val()).split('-');
			var today = new Date();
			var year = birthday[0];
			var month = birthday[1];
			var day = birthday[2];
			//今年の誕生日
			var thisYearsBirthday = new Date(today.getFullYear(), month - 1, day);
			//年齢
			var age = today.getFullYear() - year;
			if(today < thisYearsBirthday) age--;
			$('#age').val(age);
		}
		else {
			$('#age').val('');
		}
	});
});