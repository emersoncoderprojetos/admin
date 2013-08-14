<!-- INICIO # CONTEÚDO -->
<div class="container-fluid">

    <!-- INICIO # CONTEÚDO CENTRAL -->
    <div class="row-fluid">
    
	    <!-- INICIO # MENU LATERAL ESQUERDO -->
	    <?php $this->load->view('admin/elementos/menu_site', $dados_menu); ?>
	    <!-- FIM # MENU LATERAL ESQUERDO -->

	    <div class="span9">

	        <div class="hero-unit" style="height:180px;">
	            <h1>Rodrigo Transportes</h1>
				<p>AdminSystem</p>
				
				<div style="float:left;" id='chart_div'></div>

			</div>

		</div>

	</div>
	<!-- FIM # CONTEÚDO CENTRAL -->

	<script type='text/javascript' src='https://www.google.com/jsapi'></script>
	<script type='text/javascript'>

		google.load('visualization', '1', { packages : ['gauge'] });

		google.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Label', 'Value'],
				['Conteúdo', <?php echo $total_conteudo;?>]
			]);

			var options = {
				width      : 400,
				height     : 120,
				redFrom    : 90, 
				redTo      : 100,
				yellowFrom : 75, 
				yellowTo   : 90,
				minorTicks : 5
			};

			var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

			chart.draw(data, options);

		}
		
		$(function(){

			$('.topo_site').addClass('active');

		});
		
	</script>	