<?php include_once('functions.php'); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="x-ua-compatible" content="ie=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		
		<title>nWatch - NKN Node Monitoring</title>
		<link rel="stylesheet" href="core/css/bootstrap.min.css" />
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Francois+One&family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet"> 
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/r-2.2.7/datatables.min.css"/>
		
		<link rel="stylesheet" href="style.css" />
		
		<link rel="apple-touch-icon" sizes="180x180" href="core/favicons/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="core/favicons/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="core/favicons/favicon-16x16.png">
		<link rel="manifest" href="core/favicons/site.webmanifest">
		<link rel="mask-icon" href="core/favicons/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="theme-color" content="#ffffff">
		
		
	</head>
	
	<body>
		

		<nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
			
			<div class="container-fluid">
				
				<a class="navbar-brand" href="/">
					 <img src="core/img/nWatch.svg" alt="" width="30" height="30"> nWatch
				</a>
				
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
						
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="#">Nodes</a>
						</li>
			
						<li class="nav-item">
							<a class="nav-link" href="#">Wallets</a>
						</li>
					
					</ul>
			
					
				</div>
				
			</div>
		</nav>
		
		
		<div class="container-fluid header">
			
			<?php  
			
			$values = get_json('https://api.coingecko.com/api/v3/simple/token_price/ethereum?contract_addresses=0x5cf04716ba20127f1e2297addcf4b5035000c9eb&vs_currencies=eur,eth&include_market_cap=true&include_24hr_vol=true&include_24hr_change=true&include_last_updated_at=false'); 
			
			$block 		= get_json('https://openapi.nkn.org/api/v1/statistics/counts'); 
			$netStats 	= get_json('https://api.nknx.org/network/stats'); 
			$github 	= get_json('https://api.github.com/repos/nknorg/nkn/releases'); 
			$nodes 		= get_nodes($block['blockCount']); 
			
			?>
			
			<div class="container">
				
				<div class="row py-5">
					
					<div class="col-lg-6 mb-3">
						
						<div class="row">
							
							<div class="col-6">
								
								<h4 class="m-0 p-0"><?= perso_round($block['blockCount'],0, ' ') ?></h4>
								<p>Latest block</p>
								
								<h4 class="m-0 p-0"><?= perso_round($netStats['totalNodes'],0, ' ') ?></h4>
								<p>Nodes</p>
								
								<h4 class="m-0 p-0"><?= $github[0]['name'] ?></h4>
								<p>since <?= time_elapsed_string($github[0]['published_at']) ?></p>
								
							</div>
							
							<div class="col-6">
								
								<h4 class="m-0 p-0"><?= $nodes['total_nodes'] ?></h4>
								<p>Nodes</p>
								
								<h4 class="m-0 p-0"><?=  perso_round($nodes['max_relay'],0, ' ') ?></h4>
								<p>Max relay</p>
								
								<h4 class="m-0 p-0"><?= $nodes['total_proposals'] ?></h4>
								<p>Reward(s)</p>	
									
							</div>
							
							<div class="col-12">
								<button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#manager">Manage my nodes</button>
							</div>
							
						</div>
						
					</div>
					
					<div class="col-lg-6 text-center">
						<canvas style="margin-top:-.5rem;" class="mx-auto" id="myChart" height="105px"></canvas>
					</div>
					
				</div>
			
			</div>
		
		</div>
		
		<div class="container">
			
			<div class="row my-5">
			
				<table id="nodes" class="table">
					
					<thead>
						<tr>
							<th scope="col" data-priority="0">Node</th>
							<th scope="col" data-priority="1">IP</th>
							<th scope="col" data-priority="1">Status</th>
							<th scope="col">Current block</th>
							<th scope="col">Relayed Messages</th>
							<th scope="col">Relay / hour</th>
							<th scope="col">Version</th>
							<th scope="col">Reward</th>
							<th scope="col">Uptime</th>
						</tr>
						</thead>
					
					<tbody>
			
				</tbody>
				
			</table>			
		
		</div>
		
		<footer class="container-fluid">
			
			<div class="row copyrights">
				<div class="col-6 col-lg-2 order-2 order-lg-1">
					<p>© <?= date('Y') ?> AL</p>
				</div>
				<div class="col-12 col-lg-8 order-1 order-lg-2 text-center">
					<p>Do you enjoy nWatch? Feed the dev! Donate to <code>NKNQUttrQxNcY6cT9EmaKBT6ijshV1UZt4x2</code> </p>
				</div>
				<div class="col-6 col-lg-2 order-3 order-lg-3 text-end">
					<p>Made with ♥️ in 🇫🇮</p>
				</div>
			</div>
			
		</footer>


		<!-- Modal -->
		<div class="modal fade" id="manager" tabindex="-1" aria-labelledby="manager" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Node Manager</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
				<div class="modal-body">
					
					<form id="nodecfg">
						
						<div class="form-floating">
							<textarea class="form-control" id="nodetxt" name="nodetxt" style="height: 100px"><?= file_get_contents('nodes.txt') ?></textarea>
							<label for="floatingTextarea2">Your nodes</label>
						</div>
						
						<input type="hidden" name="form_type" value="nodes" />

					</form>
					
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary btn-nodecfg-js">Save changes</button>
				</div>
				
				</div>
			</div>
		</div>


			
		
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/r-2.2.7/datatables.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
		<script src="core/js/bootstrap.bundle.min"></script>
		
		<script>
			$(document).ready(function() {
				
				var table = $('#nodes').DataTable({
					"paging":   false,
					"responsive": true,
					"ajax": 'ajax.php',
					
					"aoColumnDefs": [ {
						"aTargets": [2],
						"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
							if ( sData.indexOf('WAIT FOR SYNCING') > -1 ) {
								$(nTd).addClass('bg-warning');
							}
							else if( sData.indexOf('SYNC STARTED') > -1 ){
								$(nTd).addClass('bg-start');
							}
							else if( sData.indexOf('SYNC FINISHED') > -1 ){
								$(nTd).addClass('bg-success');	
							}
							else if( sData.indexOf('PERSIST FINISHED') > -1 ){
								$(nTd).addClass('bg-success');	
							}
							else if( sData.indexOf('OFFLINE') > -1 ){
								$(nTd).addClass('bg-alert');	
							}
							else{
								$(nTd).addClass('bg-alert');	
							}
						}
					} ]
					
				});
				
				setInterval( function () {
					table.ajax.reload();
				}, 60000 );
				
				var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
				var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
				  return new bootstrap.Tooltip(tooltipTriggerEl)
				})
				
				$('.btn-nodecfg-js').click(function() {
					
					var datastring = $("#nodecfg").serialize();
					console.log(datastring);

					$.ajax({
						type: "POST",
						url: "ajax.php",
						data: datastring,
						success: function(data) {
							alert('Data send');
						}
					});
				
				});
			
			} );
		</script>
		
		<script>
		
		Chart.defaults.global.legend.display = false;
		
		var chartOptions = {
			  legend: {
				display: false 
			  },
			  elements: {
					arc: {
						borderWidth: 1,
						borderColor: 'rgba(255,255,255, 0.5)'
					}
				}
			};
		
		
		const data = {
			  labels: [
				'ERROR',
				'WAIT_FOR_SYNCING',
				'SYNC_STARTED',
				'SYNC_FINISHED',
				'PERSIST_FINISHED',
				'OFFLINE'
			  ],
			  datasets: [{
				label: 'My First Dataset',
				data: [<?= implode(', ', $nodes['stats'] ) ?>],
				backgroundColor: [
				  'rgb(243, 66, 19, 0.75)',
				  'rgb(244, 185, 66, 0.75)',
				  'rgb(111, 208, 140, 0.75)',
				  'rgb(111, 208, 140, 0.75)',
				  'rgb(172, 203, 225, 0.75)',
				  'rgb(255, 255, 255, 0.75)',
				],
				hoverOffset: 4
			  }]
			};
			
		const config = {
			  type: 'pie',
			  data: data,
			  options: chartOptions
			};
		
		var myChart = new Chart(
			document.getElementById('myChart'),
			config
		  );
			
			
		</script>
		
	</body>
</html>