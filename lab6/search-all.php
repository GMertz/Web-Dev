<!DOCTYPE html>
<html>
	<head>
		<?php 
		$servername = "www.watzekdi.net";
		$username = "watzekdi_cs393";
		$password = "KevinBac0n";
		$database = "watzekdi_imdb";
		$dbport = 3306;

		$info = $_GET;
		$fn = $info['firstname'];
		$ln = $info['lastname'];
		$count = 0;
		try {
		$db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8;port=$dbport", $username, $password);
		//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$actor = $db->query("SELECT DISTINCT * from actors a
							WHERE a.first_name LIKE ('$fn%') AND 
							a.last_name = '$ln' ORDER BY a.id ASC, a.film_count DESC");
		$actor = $actor->fetch(PDO::FETCH_ASSOC);
		$actorid = $actor['id'];


		$rows = $db->query("SELECT name,year,rank,role 
							FROM movies m 
							JOIN roles r on m.id = r.movie_id
							JOIN actors a on a.id = r.actor_id
							WHERE a.id = '$actorid' ");


		
		$count = $rows->rowCount();

		}catch(PDOException $ex) {
		echo ("Sorry, the database isnt working, try again later. <br />");
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
				
				if($count === 0){
					echo "<h1>$fn $ln not found in DataBase</h1>";
				}else{ 
					$fn = $actor['first_name'];
					$ln = $actor['last_name'];
					?>
				<h1> Results for Movies with <?=$fn?> <?=$ln?></h1>
				<div>
					<caption>
						Films with <?=$fn?> <?=$ln?>
						</caption>
					<table>
						
					<tr>
						<th>#</th>
						<th>Movie</th> 
						<th>Year</th> 
					</tr>
					<?php 
					$i = 1;
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
				<?php } if($count > 0){?>
				<h2>Showing (<?=($count)?>) results</h2>
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
