<!DOCTYPE html>
<html>
<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="canvasjs.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
</head>
<body>
<div style="height: 300px;">
<div id="chartContainer" style="height: 300px; width: 50%;"></div>
</div>
<div align="center">
	<button id="ch_pdf1" class="btn btn-xl btn-danger">GET PDF</button>
</div>
<div id="chartContainer1" style="height: 300px; width: 50%;"></div>
<div align="center">
	<button id="ch_pdf2" class="btn btn-xl btn-danger">GET PDF </button>
</div>
<div id="chartContainer2" style="height: 300px; width: 50%;"></div>
<div align="center">
	<button id="ch_pdf3" class="btn btn-xl btn-danger">GET PDF </button>
</div>

<script type="text/javascript">

	function showGraph(){
		{
			
			$.getJSON("DatabaseData_money.php", function (data_points) {
		
				$.getJSON("DatabaseData_id.php", function(projects_points){
				console.log(projects_points);
				console.log(data_points);

				var len=data_points.length;
				var lenp=projects_points.length;
				var data_object={};
				var x_position={};
				var y_position={};
				var data=[];
				var selected_project=[];
			
				for(var i in projects_points){
					selected_project.push(projects_points[i].id);
				}

				var selected_length=selected_project.length;
		
				var output="";
				var groupBy = function (xs, key) {
    				return xs.reduce(function (rv, x) {
        			(rv[x[key]] = rv[x[key]] || []).push(x);
        				return rv;
    				},{});
				};

				var groubedByids = groupBy(data_points, 'ids')
				output = JSON.parse(output +  JSON.stringify( groubedByids, null, 2 ));

// for selecting purpose
				for(var i=0; i<selected_length; i++){
					x_position['project'+[selected_project[i]]]=x_position['project'+[selected_project[i]]] || [];
					for(var j in output[selected_project[i]]){
						x_position['project'+[selected_project[i]]].push(new Date(output[selected_project[i]][j].x_p));
					}	     
				}	

// for selecting purpose
				for (var i=0; i<selected_length; i++){
					y_position['project'+[selected_project[i]]]=y_position['project'+[selected_project[i]]] || [];
					for(var j in output[selected_project[i]]){
						y_position['project'+[selected_project[i]]].push((output[selected_project[i]][j].y_p));
					}	     
				}

// for selecting purpose
				for(var i=0; i<selected_length; i++){
					data_object['project'+[selected_project[i]]] = data_object['project'+[selected_project[i]]] || [];
					var position_len1=x_position['project'+[selected_project[i]]].length;
						for(var j=0; j<position_len1; j++){
							data_object['project'+[selected_project[i]]].push({
								x:x_position['project'+[selected_project[i]]][j],
								y:y_position['project'+[selected_project[i]]][j]
							});
						}
				}
	
// for selecting purpose
				for(var l=0;l<selected_length;l++){
					data.push({
						type:"line",
						name: "project"+[selected_project[l]],
						showInLegend: true,
						dataPoints: data_object['project'+[selected_project[l]]]
					});
				}

				console.log(data);
	
		var chart = new CanvasJS.Chart("chartContainer", 
		{				
				title:{
				text: "MONEY SPENT" 
				},
				axisX:{
				title: "Date",
				labelFormatter: function (e) {
				return CanvasJS.formatDate( e.value, "DD-MMM-YY");
	},
				},

				axisY: {
				title: "Money Spent"
				},
				
		   data: data
		});
		chart.render();
		// chart for pdf
		var canvas = $("#chartContainer .canvasjs-chart-canvas").get(0);
		var dataURL = canvas.toDataURL();
		console.log(dataURL);

		$("#ch_pdf1").click(function(){
    		var pdf = new jsPDF();
    		pdf.addImage(dataURL, 'JPEG', 0, 20);
    		pdf.save("line_chart.pdf");
		});
		//
			});
	});
		}
	}

	function showGraph1(){
		{
			
			$.getJSON("DatabaseData_impact.php", function (data_points) {
		
				$.getJSON("DatabaseData_id.php", function(projects_points){
				console.log(projects_points);
				console.log(data_points);

				var len=data_points.length;
				var lenp=projects_points.length;
				var data_object={};
				var x_position={};
				var y_position={};
				var data=[];
				var selected_project=[];
			
				for(var i in projects_points){
					selected_project.push(projects_points[i].id);
				}

				var selected_length=selected_project.length;
		
				var output="";
				var groupBy = function (xs, key) {
    				return xs.reduce(function (rv, x) {
        			(rv[x[key]] = rv[x[key]] || []).push(x);
        				return rv;
    				},{});
				};

				var groubedByids = groupBy(data_points, 'ids')
				output = JSON.parse(output +  JSON.stringify( groubedByids, null, 2 ));

// for selecting purpose
				for(var i=0; i<selected_length; i++){
					x_position['project'+[selected_project[i]]]=x_position['project'+[selected_project[i]]] || [];
					for(var j in output[selected_project[i]]){
						x_position['project'+[selected_project[i]]].push(new Date(output[selected_project[i]][j].x_p));
					}	     
				}	

// for selecting purpose
				for (var i=0; i<selected_length; i++){
					y_position['project'+[selected_project[i]]]=y_position['project'+[selected_project[i]]] || [];
					for(var j in output[selected_project[i]]){
						y_position['project'+[selected_project[i]]].push((output[selected_project[i]][j].y_p));
					}	     
				}

// for selecting purpose
				for(var i=0; i<selected_length; i++){
					data_object['project'+[selected_project[i]]] = data_object['project'+[selected_project[i]]] || [];
					var position_len1=x_position['project'+[selected_project[i]]].length;
						for(var j=0; j<position_len1; j++){
							data_object['project'+[selected_project[i]]].push({
								x:x_position['project'+[selected_project[i]]][j],
								y:y_position['project'+[selected_project[i]]][j]
							});
						}
				}
	
// for selecting purpose
				for(var l=0;l<selected_length;l++){
					data.push({
						type:"line",
						name: "project"+[selected_project[l]],
						showInLegend: true,
						dataPoints: data_object['project'+[selected_project[l]]]
					});
				}

				console.log(data);
	
		var chart = new CanvasJS.Chart("chartContainer1", 
		{				
				title:{
				text: "PEOPLE IMPACTED" 
				},
				axisX:{
				title: "Date",
				labelFormatter: function (e) {
				return CanvasJS.formatDate( e.value, "DD-MMM-YY");
	},
				},

				axisY: {
				title: "people impact"
				},
				
		   data: data
		});
		chart.render();
		//
		var canvas = $("#chartContainer1 .canvasjs-chart-canvas").get(0);
		var dataURL = canvas.toDataURL();
		console.log(dataURL);

		$("#ch_pdf2").click(function(){
    		var pdf = new jsPDF();
    		pdf.addImage(dataURL, 'JPEG', 0, 20);
    		pdf.save("line_chart.pdf");
		});
		//
			});
	});
		}
	}

	function showGraph2(){
		{
			
			$.getJSON("DatabaseData_revenue.php", function (data_points) {
		
				$.getJSON("DatabaseData_id.php", function(projects_points){
				console.log(projects_points);
				console.log(data_points);

				var len=data_points.length;
				var lenp=projects_points.length;
				var data_object={};
				var x_position={};
				var y_position={};
				var data=[];
				var selected_project=[];
			
				for(var i in projects_points){
					selected_project.push(projects_points[i].id);
				}

				var selected_length=selected_project.length;
		
				var output="";
				var groupBy = function (xs, key) {
    				return xs.reduce(function (rv, x) {
        			(rv[x[key]] = rv[x[key]] || []).push(x);
        				return rv;
    				},{});
				};

				var groubedByids = groupBy(data_points, 'ids')
				output = JSON.parse(output +  JSON.stringify( groubedByids, null, 2 ));

// for selecting purpose
				for(var i=0; i<selected_length; i++){
					x_position['project'+[selected_project[i]]]=x_position['project'+[selected_project[i]]] || [];
					for(var j in output[selected_project[i]]){
						x_position['project'+[selected_project[i]]].push(new Date(output[selected_project[i]][j].x_p));
					}	     
				}	

// for selecting purpose
				for (var i=0; i<selected_length; i++){
					y_position['project'+[selected_project[i]]]=y_position['project'+[selected_project[i]]] || [];
					for(var j in output[selected_project[i]]){
						y_position['project'+[selected_project[i]]].push((output[selected_project[i]][j].y_p));
					}	     
				}

// for selecting purpose
				for(var i=0; i<selected_length; i++){
					data_object['project'+[selected_project[i]]] = data_object['project'+[selected_project[i]]] || [];
					var position_len1=x_position['project'+[selected_project[i]]].length;
						for(var j=0; j<position_len1; j++){
							data_object['project'+[selected_project[i]]].push({
								x:x_position['project'+[selected_project[i]]][j],
								y:y_position['project'+[selected_project[i]]][j]
							});
						}
				}
	
// for selecting purpose
				for(var l=0;l<selected_length;l++){
					data.push({
						type:"line",
						name: "project"+[selected_project[l]],
						showInLegend: true,
						dataPoints: data_object['project'+[selected_project[l]]]
					});
				}

				console.log(data);
	
		var chart = new CanvasJS.Chart("chartContainer2", 
		{				
				title:{
				text: "REVENUE GENERATED" 
				},
				axisX:{
				title: "Date",
				labelFormatter: function (e) {
				return CanvasJS.formatDate( e.value, "DD-MMM-YY");
	},
				},

				axisY: {
				title: "revenue generated"
				},
				
		   data: data
		});
		chart.render();
		//
		var canvas = $("#chartContainer2 .canvasjs-chart-canvas").get(0);
		var dataURL = canvas.toDataURL();
		console.log(dataURL);

		$("#ch_pdf3").click(function(){
    		var pdf = new jsPDF();
    		pdf.addImage(dataURL, 'JPEG', 0, 20);
    		pdf.save("line_chart.pdf");
		});
		//
		
			});
	});
		}
	}

</script>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		showGraph();
		showGraph1();
		showGraph2();
	});
</script>