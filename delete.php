<?php

include_once "includes/db.php";

if(isset($_GET['id']))
	$id = $_GET['id'];

if(isset($_GET['soort']))
	$soort = $_GET['soort'];

if(isset($_POST['id'], $_POST['password'], $_POST['soort']))
{
	$id = $_POST['id'];
	$soort = $_POST['soort'];
	$password = ($_POST['password'] == $password) ? true : false;
	
	
	if(!$password)
		header("Location: index.php");
	else
	{
		switch($soort)
		{
			case "voertuig":
				deleteVoertuig($id);
				break;
			case "decoder":
				deleteDecoder($id);
				break;
		}
	}
}

function deleteVoertuig($id)
{
	global $pdo;
	$deletePDO = $pdo->prepare("DELETE FROM voertuig WHERE id = :id");
	$deletePDO->bindValue(":id", $id);
	$deletePDO->execute();
	
	header("Location: index.php");
}

function deleteDecoder($id)
{
	global $pdo;
	$deletePDO = $pdo->prepare("DELETE FROM decoder WHERE id = :id");
	$deletePDO->bindValue(":id", $id);
	$deletePDO->execute();
	
	header("Location: index.php");
}


?>

<!DOCTYPE html>
<html>
	<head>
		<title>
			Verwijderen???
		</title>
		<meta charset="utf-8">
	</head>
	
	<body>
		<form action="delete.php" method="post">
			ID:
			<br>
			<input name="id" value="<?= isset($id)? $id: "Niks geselecteerd"; ?>" readonly>
			<br>
			Soort:
			<br>
			<input name="soort" value="<?= isset($soort)? $soort: "Niks geselecteerd"; ?>" readonly>
			<br>
			Wachtwoord:
			<br>
			<input type="password" name="password">
			<br>
			<input type="submit" value="verwijderen">
		</form>
	</body>
</html>