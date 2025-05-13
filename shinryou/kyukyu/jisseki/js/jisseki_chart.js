(function() {
	google.load('visualization', '1.0', {'packages': ['corechart']});
	$(function() {
		var drawChart = function() {
			let t_data = [];
			let i_data = [];
			let i_color = [];
			if ($('#chartTable').size()) {
				$('#chartTable').find('tr').each(function(i) {
					t_data[i] = [];
					$('th, td', $(this)).each(function(j) {
						t_data[i][j] = $(this).html();
					});
				}).end().find('.legend').each(function(i) {
					let this_color = $(this).data('color');
					$(this).prepend('<i>■</i>').find('i').css('color', this_color);
					return i_color[i] = this_color;
				});
				for (let i = 0; i < t_data[0].length; i++) {
					i_data[i] = [];
					i_data[i][0] = t_data[0][i];
					i_data[i][1] = isNaN(t_data[1][i]) ? t_data[1][i]: parseInt(t_data[1][i], 10);
				}
				let data = google.visualization.arrayToDataTable(i_data);
				let options = {
					chartArea: {
						width: '80%',
						height: '90%'
					},
					width: '100%',
					height: 420,
					legend: 'none',
					bar: {
						groupWidth: '35%'
					},
					isStacked: true,
					colors: i_color,
					hAxis: {
						showTextEvery: 1,
						minTextSpacing: 2
					}
				};
				let chart = new google.visualization.ColumnChart(document.getElementById('chartDiv'));
				chart.draw(data, options);
			}
		};
		google.setOnLoadCallback(drawChart);
	});
}).call(this);
