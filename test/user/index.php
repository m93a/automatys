<!DOCTYPE html>
<html>
<head>

<link rel="apple-touch-icon" sizes="57x57" href="../favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="../favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="../favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="../favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="../favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="../favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="../favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="../favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="../favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="../favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="../favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
<link rel="manifest" href="../favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="../favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

	<link rel="stylesheet" type="text/css" href="../style.css">
	<link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
	<title>AUTOMAT</title>
	<style type="text/css">
		ul{
    		list-style-type: none;
		}
		li p{
    		font-size: 3em;
    		margin-bottom: 5px;
		}
		a:link {
    		color: grey;
		}
		a:visited {
    		color: grey;
		}
		#puvodni_cena{
			color: grey;
			margin-top: -10%;
			text-decoration: line-through;
			font-size: 2em;
		}
	</style>
</head>
<body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-93298002-1', 'auto');
  ga('send', 'pageview');

</script>

<div id="container">
<header>
	AUTOMAT
</header>
<div class="notification">
Na této stránce budete online informování o stavu Vaší objednávky.
</div>

<div id="hlaska">
<?php
	If(isset($_GET['id'])){
		$unique_key = $_GET['id'];
		require '../connect.inc.php';
		$sql = "SELECT * FROM Objednavky WHERE unique_key = '$unique_key'";

		if ($result =  $mysqli->query($sql)) {
			if ($result->num_rows == 1) {
				while ( $row = $result->fetch_assoc()) {
					echo "<ul>";
						if($row['storno'] == 1){
							echo "<li><p>Čas doručení<br><s>". date("d.m.Y \** H:i:s", $row["time_delivery"])."</s><p></li>";
							echo "<li><p><s>Cena: ". $row['price']." Kč</s></p></li>";
						}else{
							echo "<li><p>Čas doručení<br>". date("d.m.Y \** H:i:s", $row["time_delivery"])."<p></li>";
								If($row['price_puvodni'] > 0){
								echo "<li>	<p>Cena: ".$row['price'].' Kč</p><br />
											<p id="puvodni_cena">'.$row['price_puvodni']." Kč</p></li>";	
								}else{
								echo "<li><p>Cena: ". $row['price']." Kč</p></li>";	
								}
						}

						If(!empty($row['promo_code'])){
								echo "Promo kód přijat";
								echo "<p>".$row['promo_msg']."</p>";
								If($row['promo_discount'] !=0)echo "<p> Sleva na celý nákup ".$row['promo_discount']." %</p>";	
						}


						
						if($row['done'] == 0 && $row['storno'] == 0){
							echo "<li><p>Stav: Nevyřízeno</p></li>";
							echo '<li><p><a href="del.php?a=1&id='.$row["unique_key"].'">STORNOVAT</a></p></li>';
						}
						if($row['storno'] == 1){
							echo "<li><p>Stav: Stornováno</p></li>";
						}
						if ($row['done'] == 1 && $row['storno'] == 0) {
							echo "<li><p>Stav: Vyřízeno</p></li>";
						}
					
					echo '<li><p><a href="/">Zpět do automatu</a></p></li>';
					echo "</ul>";
				}
		 }
	}
}
?>
</div>

<iframe class="add"><endora></iframe>
</body>
</html>