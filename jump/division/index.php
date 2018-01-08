<?php
	if( !array_key_exists('max_q', $_GET) )
		$_GET['max_q'] = '12';
	if( !array_key_exists('div', $_GET) )
		$_GET['div'] = '1..12';
	if( !array_key_exists('liv', $_GET) )
		$_GET['liv'] = '3';
?>


<!DOCTYPE html>
<html>
<head>
	<title> Jakob's Math Practice - Division </title>
	<?php echo "<script type=\"text/javascript\" src=\"math.js?max_q={$_GET['max_q']}&div={$_GET['div']}&liv={$_GET['liv']}\"></script>"; ?>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<form action="" method="GET" id="question">
		<input type="text" id="dividend" disabled="disabled" /> &divide;
		<input type="text" id="divisor" disabled="disabled" /> =
		<input type="text" id="quotient" autocomplete="off" /> +
		<div id="fraction">
			<input type="text" id="numerator" autocomplete="off" />
			<input type="text" id="denominator" autocomplete="off" />
		</div>
		<input type="submit" value="Done" /> <br />
		<table>
			<tr> <td>Score:</td> <td><input type="text" id="score" disabled="disabled" /></td> </tr>
			<tr> <td>Lives:</td> <td><input type="text" id="lives" disabled="disabled" /></td> </tr>
			<tr> <td>High Score:</td> <td><input type="text" id="high_score" disabled="disabled" /></td> </tr>
		</table>
	</form>
</body>
</html>