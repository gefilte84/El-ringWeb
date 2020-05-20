
		<?php
			//https://stackoverflow.com/questions/11219282/how-to-get-mysql-data-into-a-google-chart-using-php-loop
			//https://blog.programster.org/php-converting-data-for-google-charts
			include "dbh.php";
			//SQLQuery for å hente data
			$sql = mysqli_query($conn, "SELECT ePost, poeng FROM scoreboard");
			
			//Konverterer data strukturen
			$data = array();
			$epost = array();
			$poeng = array();
			$i = 0;
			
			while($rad = mysqli_fetch_array($sql)){
				$i += 1;
				//$data[] = $rad;
				//$ePost = $rad['ePost'];
				//$poeng = $rad['poeng'];
				
			 //echo "[' " .$rad["ePost"]." ', ".$rad["poeng"]." ], ";
			 array_push($epost," " .$rad["ePost"]." "); 
			 array_push($poeng, " ".$rad["poeng"].""); 
			 array_push($data," " .$rad["ePost"].", ".$rad["poeng"]." ");
			} 
		?> 
<html>
  <head>
  <link rel="stylesheet" type="text/css" href="dashboard.css">
  
  <!-- JavaScript for å hente google api og tabell -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);
	
	// her "tegner" vi tabellen med en string og et tall
      function drawTable() {
		
	/*Gjør om data til JavaScript*/
	var raw_data = <?php echo json_encode($data) ?>;
	
	/* Oppretter tabellen */
	var data = new google.visualization.DataTable(raw_data);
	data.addColumn('string', 'epost');
	data.addColumn('string', 'poeng');
	
	/* For-løkke for å gå gjennom arrayet og legge til alle radene i tabellen*/
	for (var i = 0; i < raw_data.length; i++){
		data.addRow([<?php echo json_encode($epost)?>[i], <?php echo json_encode($poeng)?>[i]]);}

		//Kobler tabellen til en div med id tabell
        var table = new google.visualization.Table(document.getElementById('tabell'));
		
		//Mailformat
		var formatter = new google.visualization.PatternFormat(
		'<a href="mailto:{1}">{0}</a>');
		
		formatter.format(data, [0,0]);
		
		//Her skriver vi ut data i tabellen og det henter vi fra funksjonen drawTable
		var view = new google.visualization.DataView(data);
		view.setColumns([0]);

        table.draw(data, {allowHtml: true, showRowNumber: true, width: '90%', height: '90%'});
      }
    </script>
  </head>
  <body>
	<div class="grid-container2">
		<main class="main">
		<div class="main-cards">
			
			<div class="score" id="tabell"></div>
			  
        </div>
		</main>
	
	
	            <!-- Sidemeny klassen-->

        <aside class="sidenav">
          <ul class="sidenav__list">
            <a href="dashboard med tabell.php"><li class="sidenav__list-item">Hjem</li></a>
            <li class="sidenav__list-item">Rapport</li>
            <a href="Scoreboard.php"><li class="sidenav__list-item">Scoreboard</li></a>
            <li class="sidenav__list-item">Kurs</li>
            <li class="sidenav__list-item">Instillinger</li>
            <li class="sidenav__list-item">Logg ut</li>
          </ul>
        </aside>	
	
	        <!--  Footer klassen-->
      <footer class="footer">
        <div class="footer__copyright">Wohoo LTM</div>
        <div class="footer__signature">2020</div></footer>
	</div>
	
  </body>
</html>
