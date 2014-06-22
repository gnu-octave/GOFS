<html> 
<link rel="stylesheet" type="text/css" href="main.css" />
<br />
<h2>GNU Octave Function Search</h2>
<br />
<form method="post" action="index.php">
Function: <input type="text" name="function">
<input class="button gray small" type="submit" name="Check" value=">> Search">
</form>
<?php
// options
$dbfile = 'fs.sql';

// inputs
$f = $_POST["function"];


// functionality
if (strlen($f) == 0) die('Database Version 2014.0615<br /><small><a href="https://github.com/octave-de/GOFS">Improve it!</a></small>');
if (strlen($f) > 64) die('Input is to long');
if (!preg_match('/^[a-zA-Z_0-9]+$/i',$f)) die('Illegal characters');

	$q = "SELECT host, package FROM fs WHERE func='$f'";
	$db = new SQLite3($dbfile);
	$result = $db->query($q);
	if (!$result) {
		echo "fuck this shit!<br >";
	} else {
		echo '<br /><ul>';
		if ($record = $result->fetchArray()) {
			if ( $record['host'] == "github" ) {
				echo '<li><p> <b>'. $f .'()</b> is available in '. $record['host'] .' package <a href="https://github.com/octave-de/octave-hub">'  .$record['package'] .'</a></p></li>';
			} elseif ( $record['host'] == "forge" ) {
				echo '<li> <b>'. $f .'()</b> is available in '. $record['host'] .' package <a href="http://octave.sf.net/'. $record['package'] .'/index.html">' .$record['package'] .'</a></p></li>';
			}
			while ($record = $result->fetchArray()) {
				if ( $record['host'] == "github" ) {
					echo '<li><p> <b>'. $f .'()</b> is available in '. $record['host'] .' package <a href="https://github.com/octave-de/octave-hub">' .$record['package'] .'</a></p></li>';
				} elseif ( $record['host'] == "forge" ) {
					echo '<li> <b>'. $f .'()</b> is available in '. $record['host'] .' package <a href="http://octave.sf.net/'. $record['package'] .'/index.html">' .$record['package'] .'</a></p></li>';
				}
			}
			echo '</ul>';
		} else { echo 'Not found :(<br />Note: Octave core functions are not indexd.'; }
	}
	$db->close();



?>
<br /> <br />
<small><a href="https://github.com/octave-de/GOFS">Improve it!</a></small>


