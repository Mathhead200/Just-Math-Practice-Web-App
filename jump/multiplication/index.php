<?php
	if( !array_key_exists('num', $_GET) )
		$_GET['num'] = '1..12';
	if( !array_key_exists('lim', $_GET) )
		$_GET['lim'] = 12;
	if( !array_key_exists('liv', $_GET) )
		$_GET['liv'] = 3;
?>

<!DOCTYPE html>
<html>
<head>
	<title> Jakob's Math Practice - Multiplication </title>
	<?php echo "<script type=\"text/javascript\" src=\"math.js?num={$_GET['num']}&lim={$_GET['lim']}&liv={$_GET['liv']}\"></script>"; ?>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<form action="" method="GET" id="question">
		<input type="text" id="multiplicand" disabled="disabled" /> &cross;
		<input type="text" id="multiplier" disabled="disabled" /> =
		<input type="text" id="product" autocomplete="off" />
		<input type="submit" value="Done" /> <br />
		<table>
			<tr> <td>Score:</td> <td><input type="text" id="score" disabled="disabled" /></td> </tr>
			<tr> <td>Lives:</td> <td><input type="text" id="lives" disabled="disabled" /></td> </tr>
			<tr> <td>High Score:</td> <td><input type="text" id="high_score" disabled="disabled" /></td> </tr>
		</table>
	</form>
</body>
</html>