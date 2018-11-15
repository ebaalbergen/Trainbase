<?php

include_once "includes/db.php";

if(isset($_GET['id']))
{
	$id = $_GET['id'];
	$decoderQuery = "SELECT * FROM decoder WHERE id = " . $id;
}
else
	$decoderQuery = "SELECT * FROM decoder";

$decoderPDO = $pdo->query($decoderQuery);
$decoderData = $decoderPDO->fetchAll(PDO::FETCH_ASSOC);

if(sizeof($_POST) != 0)
{
	$updatePDO = $pdo->prepare("UPDATE decoder SET `naam` = :naam, `producent` = :producent, `artiekelnummer` = :artiekelnummer, `numFuncties` = :numFuncties, `functieDecoder` = :functieDecoder, `numLogicFuncties` = :numLogicFuncties, `functiesMappable` = :functiesMappable, `effecten` = :effecten, `geluid` = :geluid WHERE `id` = :id;");
	$updatePDO->bindvalue(":id", $_POST['id']);
	$updatePDO->bindvalue(":naam", $_POST['naam']);
	$updatePDO->bindvalue(":producent", $_POST['producent']);
	$updatePDO->bindvalue(":artiekelnummer", $_POST['artiekelnummer']);
	$updatePDO->bindvalue(":numFuncties", $_POST['numFuncties']);
	$updatePDO->bindvalue(":functieDecoder", isset($_POST['functieDecoder']));
	$updatePDO->bindvalue(":numLogicFuncties", $_POST['numLogicFuncties']);
	$updatePDO->bindvalue(":functiesMappable", isset($_POST['functiesMappable']));
	$updatePDO->bindvalue(":effecten", isset($_POST['effecten']));
	$updatePDO->bindvalue(":geluid", isset($_POST['geluid']));

	$updatePDO->execute();

	header("Location: index.php");
} else
{?>

<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php
			$titel = "TrainBase ";
			if(isset($id))
			{
				foreach($decoderData as $decoder)
				{
					echo $titel . "- " . $decoder['naam'];
				}
			}
			?>
		</title>
		<meta charset="utf-8">
		<meta content="nl" http-equiv="Content-Language">
		<script src="includes/sorttable.js"></script>
	</head>
	<body>
		<h1><a href="./"><?=$titel?></a></h1>
		<p>
			Met dit simpele programmaatje kunt u heel simpel een database van modeltreinen en decoders bijhouden.
		</p>
		<a href="./index.php?nieuwvoertuig">
			Nieuw Voertuig Toevoegen
		</a>
		<br>
		<a href="./index.php?nieuwedecoder">
			Nieuwe Decoder Toevoegen
		</a>

		<?php
		if(isset($id))
		{
			$decoder = $decoderData[0];
			if(isset($decoder))
			{
				$form = '<form action="decoder.php" method="post">';
				$form .= 'ID:<br><input type="number" name="id" value="' . $decoder['id'] . '" readonly><br>';
				$form .='Naam:<br><input maxlength="200" name="naam" type="text" value="' . $decoder['naam'] . '"><br>';

				$form .= 'Producent:<br><input maxlength=\"200\" name="producent" value="' . $decoder['producent'] . '"><br>';
				$form .= 'Artiekelnummer:<br><input type="number" maxlength\"9\" name="artiekelnummer" value="' . $decoder['artiekelnummer'] . '"><br>';
				$form .= 'Aantal functies:<br><input type="number" name="numFuncties" maxlength=\"4\" value="' . $decoder['numFuncties'] . '"><br>';
				$form .= '<input name="functieDecoder" type="checkbox"' . (($decoder['functieDecoder'])? " checked" : "") . '>Functiedecoder<br>';
				$form .= 'Aantal logische functies:<br><input type="number" name="numLogicFuncties" maxlength=\"4\" value="' . $decoder['numLogicFuncties'] . '"><br>';
				$form .= '<input name="functiesMappable" type="checkbox"' . (($decoder['functiesMappable'])? " checked" : "") . '>Functies Mappable<br>';
				$form .= '<input name="effecten" type="checkbox"' . (($decoder['effecten'])? " checked" : "") . '>Effecten<br>';
				$form .= '<input name="geluid" type="checkbox"' . (($decoder['geluid'])? " checked" : "") . '>Geluid<br>';

				$form .= '<input type="submit" value="opslaan"><input type="reset"></form>';
				echo $form;
			}
			else
				echo "<h3>Fout!</h3><p>Er is geen object met dit id gevonden</p>";
		} else
		{
			echo "<h3>Fout!</h3><p>Geen Decoder geselecteerd.</p><a href=\"./\">terug naar het overzicht</a>";
		} ?>
	</body>
</html>
<?php } ?>