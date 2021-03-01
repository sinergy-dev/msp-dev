@extends('template.template_admin-lte')
@section('content')	
<section class="content-header">
	<h1>
		Personal Presence History
	</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{url('presence')}}">
				<i class="fa fa-clock-o"></i>Presence
			</a>
		</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-4 col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">My Attendance Summary</h3>			
				</div>
				<div class="box-body">
					<canvas id="pieChart" style="height:300px"></canvas>
				</div>
			</div>
		</div>
		<div class="col-md-8 col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">My Attendance Detail</h3>			
				</div>

				<div class="box-body table-responsive">
					<table class="table table-hover" id="table-presence">
						<thead>
							<tr>
								<th>Date</th>
								<th>Schedule</th>
								<th>Checkin</th>
								<th>Checkout</th>
								<th>Condition</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('script')
<script type="text/javascript">
	$("#table-presence").DataTable({
		"ajax":{
           "type":"GET",
           "url":"{{env('API_SIMS')}}/api/presence/history/personalMsp?nik={{Auth::User()->nik}}",
        },
        "columns": [
            {
              render: function ( data, type, row ) {
                return '<i>'+ row.date +'</i>';
              }
            },  
            // { "data": "name_product" },  
            {
              render: function ( data, type, row ) {
                 return '<i>'+ row.schedule +'</i>';
                
              }
            },  
            {
              render: function ( data, type, row ) {
                 return '<i>'+ row.checkin +'</i>';
                
              }
            },  
            {
              render: function ( data, type, row ) {
                 return '<i>'+ row.checkout +'</i>';
                
              }
            },  
            {
              render: function ( data, type, row ) {
              	if (row.condition == "On-Time") {
              		return '<span class="label label-success">' + row.condition + '</span>'
              	}else if (row.condition == "Injury-Time") {
              		return '<span class="label label-warning">' + row.condition + '</span>'
              	}else{
              		return '<span class="label label-danger">' + row.condition + '</span>'
              	}
                
              }
            },       
          ],
           "order": [[ 0, "desc" ]]
	});

	$.ajax({
		type:"GET",
		url:"{{env('API_SIMS')}}/api/presence/history/personalMsp?nik={{Auth::User()->nik}}",
		success:function(result){
			console.log(result)
			var config = {
			type: 'doughnut',
			data: {
				labels: result.datas2,
				datasets: [{
					data: result.datas3,
					backgroundColor: result.datas4
				}]
			},
			options: {
				responsive: true,
				legend: {
					position:'bottom',
					display: true,
					labels: {
						generateLabels: function(chart) {
							var data = chart.data;
							if (data.labels.length && data.datasets.length) {
								return data.labels.map(function(label, i) {
									var meta = chart.getDatasetMeta(0);
									var ds = data.datasets[0];
									var arc = meta.data[i];
									var custom = arc && arc.custom || {};
									var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
									var arcOpts = chart.options.elements.arc;
									var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
									var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
									var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

									// We get the value of the current label
									var value = chart.config.data.datasets[arc._datasetIndex].data[arc._index];

									return {
										// Instead of `text: label,`
										// We add the value to the string
										text: label + " : " + value,
										fillStyle: fill,
										strokeStyle: stroke,
										lineWidth: bw,
										hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
										index: i
									};
								});
							} else {
								return [];
							}
						}
					}
				}
			},
			centerText: {
				display: true,
				text: ""
			}
		};

		var ctx = document.getElementById("pieChart").getContext("2d");
		window.myDoughnut = new Chart(ctx, config);
		}
	})

</script>
@endsection