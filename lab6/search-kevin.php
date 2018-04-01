<!DOCTYPE html>
<html>
	<head>
		<?php
		$servername = "www.watzekdi.net";
		$username = "watzekdi_cs393";
		$password = "KevinBac0n";
		$database = "watzekdi_imdb";
		$dbport = 3306;
		try {
		$db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8;port=$dbport", $username, $password);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$info = $_GET;
		$fn = $info['firstname'];
		$ln = $info['lastname'];
		$baconid= $db->query("SELECT * from actors a
							WHERE a.first_name = 'kevin' AND 
							a.last_name = 'bacon' ");
		$baconid = $baconid->fetch(PDO::FETCH_ASSOC);
		$baconid = $baconid['id'];

		$otherid = $db->query("SELECT DISTINCT * from actors a
							WHERE a.first_name LIKE ('%$fn%') AND 
							a.last_name LIKE ('%$ln%') ");
		$otherid = $otherid->fetch(PDO::FETCH_ASSOC);
		$otherid = $otherid['id'];

		//print($otherid);
		$rows = $db->query("SELECT m.name, m.year
							FROM movies m 
							JOIN roles r on r.movie_id = m.id 
							JOIN actors a on a.id = r.actor_id 
							AND (a.id = '$baconid' 
							OR a.id = '$otherid') 
							GROUP BY m.name 
							HAVING COUNT(m.name) > 1");
		}
		catch(PDOException $ex) {
		echo ("Sorry, the database isnt working, try again later. <br /> Error Message: {$ex->getMessage()}");
		} 

		?>
		<title>My Movie Database (MyMDb)</title>
		<meta charset="utf-8" />
		<link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" type="image/png" rel="shortcut icon" />

		<!-- Link to your CSS file that you should edit -->
		<link href="bacon.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		<div id="frame">
			<div id="banner">
				<a href="mymdb.php"><img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" alt="banner logo" /></a>
				My Movie Database
			</div>

			<div id="main">
				<?php
				$count = $rows->rowCount();
				if($count === 0){
					echo "No connections found in DataBase!</h1>";
				}else{
				?>
				<h1>(<?=($count)?>) Results for Movies with <?=$fn?> <?=$ln?></h1>
				<div>
					<table>
					<caption>
						Films with <?=$fn?> <?=$ln?> and Kevin Bacon</caption>
					<tr>
						<th>#</th>
						<th>Title</th> 
						<th>Year</th> 

					</tr>
					<?php 
					$i = 0;
					foreach ($rows as $r) {
						if($i % 2 == 0){
							$class = 'even';
						}else{
							$class = 'odd';
						}
						?>
					<tr class=<?=$class?>>
					<td><?=$i?></td> 
					<td><?=$r["name"]?></td> 
					<td><?=$r["year"]?></td>
					</tr>
					<?php $i++; } ?>
				</table>
				</div>
				<?php } ?>

			</div> <!-- end of #main div -->
			<!-- form to search for every movie by a given actor -->
				<form action="search-all.php" method="get">
					<fieldset>
						<legend>All movies</legend>
						<div>
							<input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" /> 
							<input name="lastname" type="text" size="12" placeholder="last name" /> 
							<input type="submit" value="go" />
						</div>
					</fieldset>
				</form>

				<!-- form to search for movies where a given actor was with Kevin Bacon -->
				<form action="search-kevin.php" method="get">
					<fieldset>
						<legend>Movies with Kevin Bacon</legend>
						<div>
							<input name="firstname" type="text" size="12" placeholder="first name" /> 
							<input name="lastname" type="text" size="12" placeholder="last name" /> 
							<input type="submit" value="go" />
						</div>
					</fieldset>
				</form>
			</div> <!-- end of #main div -->
		
			<div id="w3c">
				<a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5" /></a>
				<a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
			</div>
		</div> <!-- end of #frame div -->
	</body>
</html>
