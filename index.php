<?php

include_once "includes/db.php";

if(isset($_GET['id']))
	$id = $_GET['id'];

if(isset($_GET['decoder']))
	$decoder = $_GET['decoder'];

if(isset($_GET['categorie']))
	$categorie = $_GET['categorie'];

$voertuigPDO = $pdo->query("SELECT * FROM voertuig");
$voertuigData = $voertuigPDO->fetchAll(PDO::FETCH_ASSOC);

$decoderPDO = $pdo->query("SELECT * FROM decoder");



$decoderData = $decoderPDO->fetchAll(PDO::FETCH_ASSOC);

if(isset($id, $categorie) || isset($id, $decoder) || isset($categorie, $decoder) || isset($id, $decoder, $categorie))
	unset($id, $categorie, $decoder);

if(isset($_GET['nieuwvoertuig']) || isset($_GET['nieuwedecoder']))
{
	if(isset($_GET['nieuwvoertuig']))
	{
		$nieuwVoertuigPDO = $pdo->prepare("INSERT INTO voertuig (naam) VALUES (:naam)");
		$nieuwVoertuigPDO->bindValue(":naam", "Nieuw Voertuig");
		$nieuwVoertuigPDO->execute();

		header("Location: ./index.php");
	} else
	{
		$nieuwVoertuigPDO = $pdo->prepare("INSERT INTO decoder (naam) VALUES (:naam)");
		$nieuwVoertuigPDO->bindValue(":naam", "Nieuwe Decoder");
		$nieuwVoertuigPDO->execute();

		header("Location: ./index.php");
	}
}

if(sizeof($_POST) != 0)
{
	$updatePDO = $pdo->prepare("UPDATE voertuig SET drierail = :drierail, bagageWagen = :bagageWagen, geluid = :geluid, naam = :naam, soort = :soort, nummer = :nummer, numAsses = :numAsses, gewichtGrootSpoor = :gewichtGrootSpoor, gewichtModelSpoor = :gewichtModelSpoor, type = :type, omschrijving = :omschrijving, kleur = :kleur, lengteGrootSpoor = :lengteGrootSpoor, tijdperk = :tijdperk, staat = :staat, projectAfgerond = :projectAfgerond, producent = :producent, artiekelnummer = :artiekelnummer, toegelatenLanden = :toegelatenLanden, doos = :doos, digitaal = :digitaal, adres = :adres, decoderType = :decoderType, brandstof = :brandstof, vermogen = :vermogen, vrachtType = :vrachtType, maximaalGewicht = :maximaalGewicht, numPasagiers = :numPasagiers WHERE id = :id");
	$updatePDO->bindvalue(":id", $_POST['id']);
	$updatePDO->bindvalue(":naam", $_POST['naam']);
	$updatePDO->bindvalue(":soort", $_POST['soort'] == ""?null:$_POST['soort']);
	$updatePDO->bindvalue(":nummer", $_POST['nummer'] == ""?null:$_POST['nummer']);
	$updatePDO->bindvalue(":numAsses", $_POST['numAsses'] == ""?null:$_POST['numAsses']);
	$updatePDO->bindvalue(":gewichtGrootSpoor", $_POST['gewichtGrootSpoor'] == ""?null:$_POST['gewichtGrootSpoor']);
	$updatePDO->bindvalue(":gewichtModelSpoor", $_POST['gewichtModelSpoor'] == ""?null:$_POST['gewichtModelSpoor']);
	$updatePDO->bindvalue(":type", $_POST['type'] == ""?null:$_POST['type']);
	$updatePDO->bindvalue(":omschrijving", $_POST['omschrijving'] == ""?null:$_POST['omschrijving']);
	$updatePDO->bindvalue(":kleur", $_POST['kleur'] == ""?null:$_POST['kleur']);
	$updatePDO->bindvalue(":lengteGrootSpoor", $_POST['lengteGrootSpoor'] == ""?null:$_POST['lengteGrootSpoor']);
	$updatePDO->bindvalue(":tijdperk", $_POST['tijdperk'] == ""?null:$_POST['tijdperk']);
	$updatePDO->bindvalue(":staat", $_POST['staat'] == ""?null:$_POST['staat']);

	$updatePDO->bindvalue(":producent", $_POST['producent'] == ""?null:$_POST['producent']);
	$updatePDO->bindvalue(":artiekelnummer", $_POST['artiekelnummer'] == ""?null:$_POST['artiekelnummer']);
	$updatePDO->bindvalue(":toegelatenLanden", $_POST['toegelatenLanden'] == ""?null:$_POST['toegelatenLanden']);
	$updatePDO->bindvalue(":doos", $_POST['doos'] == ""?null:$_POST['doos']);

	$updatePDO->bindvalue(":adres", $_POST['adres'] == ""?null:$_POST['adres']);
	$updatePDO->bindvalue(":decoderType", $_POST['decoderType'] == ""?null:$_POST['decoderType']);
	$updatePDO->bindvalue(":brandstof", $_POST['brandstof'] == ""?null:$_POST['brandstof']);
	$updatePDO->bindvalue(":vermogen", $_POST['vermogen'] == ""?null:$_POST['vermogen']);
	$updatePDO->bindvalue(":vrachtType", $_POST['vrachtType'] == ""?null:$_POST['vrachtType']);
	$updatePDO->bindvalue(":maximaalGewicht", $_POST['maximaalGewicht'] == ""?null:$_POST['maximaalGewicht']);
	$updatePDO->bindvalue(":numPasagiers", $_POST['numPasagiers'] == ""?null:$_POST['numPasagiers']);

	$updatePDO->bindvalue(":digitaal", isset($_POST['digitaal'])?1:0);
	$updatePDO->bindvalue(":projectAfgerond", isset($_POST['projectAfgerond'])?1:0);
	$updatePDO->bindvalue(":geluid", isset($_POST['projectAfgerond'])?1:0);
	$updatePDO->bindValue(":bagageWagen", isset($_POST['bagageWagen'])?1:0);
	$updatePDO->bindValue(":drierail", isset($_POST['drierail'])?1:0);

    try
    {
        $updatePDO->execute();
        header("Location: index.php");
    } catch(Exception $e)
    {
        echo $e;
    }

} else
{?>

<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php
			$titel = "TrainBase ";
			if(isset($id) || isset($categorie))
			{
				if(isset($id))
				{
					foreach($voertuigData as $voertuig)
					{
						if($voertuig['id'] == $id)
							echo $titel . "- " . $voertuig['naam'];
					}
				}
				if(isset($categorie))
					echo $titel . "- " . $categorie;
			}
			?>
		</title>
		<meta charset="utf-8">
		<meta content="nl" http-equiv="Content-Language">
		<script src="includes/sorttable.js"></script>
		<link rel="stylesheet" href="futura.css" />
		<style>
			* {
				font-family: 'futura-pt';
			}
		</style>
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

		if((!isset($id)) || (isset($categorie)))
		{
			if(isset($categorie))
				echo "<p>Selectie van de categorie: " . $categorie . "</p>";
		?>

		<table class="sortable">
			<thead>
				<tr>
					<th>
						ID
					</th>
					<th>
						Naam
					</th>
					<th>
						Nummer
					</th>
					<th>
						Type
					</th>
					<th>
						tijdperk
					</th>
					<th>
						Afgerond Project
					</th>
					<th>
						Verwijderen
					</th>
				</tr>
			</thead>
			<tbody>

		<?php
		}

		if(!(isset($id) || isset($categorie)))
		{
			foreach($voertuigData as $voertuig)
			{
				$echoData = "<tr>";
				$echoData .= "<td>" . $voertuig['id'] . "</td>";
				$echoData .= "<td><a href=\"index.php?id=" . $voertuig['id'] . "\">" . $voertuig['naam'] . "</a></td>";
				$echoData .= "<td>" . $voertuig['nummer'] . "</td>";
				$echoData .= "<td>" . $voertuig['type'] . "</td>";
				$echoData .= "<td>" . $voertuig['tijdperk'] . "</td>";
				$echoData .= "<td>" . ($voertuig['projectAfgerond'] == 1? "ja": "nee") . "</td>";
				$echoData .= "<td><a href=\"delete.php?soort=voertuig&id=" . $voertuig['id'] . "\">Verwijderen</a></td>";
				$echoData .= "</tr>";

				echo $echoData;
			}
		} elseif(isset($id))
		{
			foreach($voertuigData as $voertuig)
			{
				if($voertuig['id'] == $id)
					$geselecteerdVoertuig = $voertuig;
			}
			$voertuig = $geselecteerdVoertuig;
			if(isset($geselecteerdVoertuig))
			{
				$form = '<form action="index.php" method="post">';
				$form .= 'ID:<br><input name="id" value="' . $voertuig['id'] . '" readonly><br>';
				$form .='Naam:<br><input maxlength="250" name="naam" type="text" value="' . $voertuig['naam'] . '"><br>';

				switch($voertuig['soort'])
				{
				case "GoederenWagon":
					$form .= 'Soort:<br><select name="soort"><option>Lokomotief</option><option selected>PersonenWagon</option><option selected>GoederenWagon</option><option></option></select><br>';
					break;
				case "PersonenWagon":
					$form .= 'Soort:<br><select name="soort"><option>Lokomotief</option><option selected>PersonenWagon</option><option>GoederenWagon</option><option></option></select><br>';
					break;
				case "Lokomotief":
					$form .= 'Soort:<br><select name="soort"><option selected>Lokomotief</option><option>PersonenWagon</option><option>GoederenWagon</option><option></option></select><br>';
					break;
				default:
					$form .= 'Soort:<br><select name="soort"><option>Lokomotief</option><option selected>PersonenWagon</option><option>GoederenWagon</option><option selected></option></select><br>';
					break;
				}

				$form .= 'Nummer:<br><input name="nummer" value="' . $voertuig['nummer'] . '"><br>';
				$form .= 'Aantal assen:<br><input name="numAsses" value="' . $voertuig['numAsses'] . '"><br>';
				$form .= 'Gewicht grootspoor:<br><input name="gewichtGrootSpoor" value="' . $voertuig['gewichtGrootSpoor'] . '"><br>';
				$form .= 'Gewicht modelspoor:<br><input name="gewichtModelSpoor" value="' . $voertuig['gewichtModelSpoor'] . '"><br>';
				$form .= 'Type:<br><input maxlength="50" name="type" value="' . $voertuig['type'] . '"><br>';
				$form .= 'Omschrijving:<br>';
				$form .= '<textarea name="omschrijving">' . $voertuig['omschrijving'] . '</textarea><br>';
				$form .= 'Kleur<br><input maxlength="50" name="kleur" value="' . $voertuig['kleur'] . '"><br>';
				$form .= 'Lengte grootspoor:<br><input name="lengteGrootSpoor" value="' . $voertuig['lengteGrootSpoor'] . '"><br>';
				$form .= 'Tijdperk:<br><input maxlength="4" name="tijdperk" value="' . $voertuig['tijdperk'] . '"><br>';

				switch($voertuig['staat'])
				{
				case "perfect":
					$form .= 'Staat:<br><select name="staat"><option selected>perfect</option><option>zeergoed</option><option>goed</option><option>matig</option><option>slecht</option><option>zeerslecht</option></select><br>';
					break;
				case "zeergoed":
					$form .= 'Staat:<br><select name="staat"><option>perfect</option><option selected>zeergoed</option><option>goed</option><option>matig</option><option>slecht</option><option>zeerslecht</option></select><br>';
					break;
				case "goed":
					$form .= 'Staat:<br><select name="staat"><option>perfect</option><option>zeergoed</option><option selected>goed</option><option>matig</option><option>slecht</option><option>zeerslecht</option></select><br>';
					break;
				case "matig":
					$form .= 'Staat:<br><select name="staat"><option>perfect</option><option>zeergoed</option><option>goed</option><option selected>matig</option><option>slecht</option><option>zeerslecht</option></select><br>';
					break;
				case "slecht":
					$form .= 'Staat:<br><select name="staat"><option>perfect</option><option>zeergoed</option><option>goed</option><option>matig</option><option selected>slecht</option><option>zeerslecht</option></select><br>';
					break;
				case "zeerslecht":
					$form .= 'Staat:<br><select name="staat"><option>perfect</option><option>zeergoed</option><option>goed</option><option>matig</option><option>slecht</option><option selected>zeerslecht</option></select><br>';
					break;
				default:
					$form .= 'Staat:<br><select name="staat"><option>perfect</option><option>zeergoed</option><option>goed</option><option selected>matig</option><option>slecht</option><option>zeerslecht</option></select><br>';
					break;
				}

				$form .= '<input name="drierail" type="checkbox"' . (($voertuig['drierail'])? " checked" : "") . '>Drierail<br>';
				$form .= '<input name="projectAfgerond" type="checkbox"' . (($voertuig['projectAfgerond'])? " checked" : "") . '>Project afgerond<br>';
				$form .= 'Fabrikant<br><input maxlength="150" name="producent" value="' . $voertuig['producent'] . '"><br>';
				$form .= 'Artiekelnummer:<br><input name="artiekelnummer" value="' . $voertuig['artiekelnummer'] . '"><br>';
				$form .= 'Toegelaten landen:<br><input maxlength="1000" name="toegelatenLanden" value="' . $voertuig['toegelatenLanden'] . '"><br>';
				$form .= 'Verpaking in doos:<br><input name="doos" value="' . $voertuig['doos'] . '"><br>';
				$form .= '<input name="digitaal" type="checkbox"' . (($voertuig['digitaal'])? " checked" : "") . '>Digitaal<br>';
				$form .= 'Adres:<br><input name="adres" value="' . $voertuig['adres'] . '"><br>';

				$form .= 'Decoder type:<br><select name="decoderType">';

				$decoderPDO = $pdo->query("SELECT * FROM decoder");
				$decoderData = $decoderPDO->fetchAll(PDO::FETCH_ASSOC);

				if($voertuig['digitaal'])
				{
					foreach($decoderData as $decoder)
					{
						if($decoder['id'] == $voertuig['decoderType'])
							$form .= "<option value=\"" . $decoder['id'] . "\" selected>" . $decoder['naam'] . "</option>";
						else
							$form .= "<option value=\"" . $decoder['id'] . "\">" . $decoder['naam'] . "</option>";
					}
				}
				else
				{
					foreach($decoderData as $decoder)
					{
						$form .= "<option value=\"" . $decoder['id'] . "\">" . $decoder['naam'] . "</option>";
					}
				}

				$form .= "</select><br>";

				switch($voertuig['brandstof'])
				{
				case "Diesel":
					$form .= 'Aandrijftype:<br><select name="brandstof"><option selected>Diesel</option><option>Benzine</option><option>Electriciteit</option><option>Stoom (kolen)</option><option>Stoom (olie)</option><option>Stoom (stoomketel)</option><option>geen</option></select><br>';
					break;
				case "Benzine":
					$form .= 'Aandrijftype:<br><select name="brandstof"><option>Diesel</option><option selected>Benzine</option><option>Electriciteit</option><option>Stoom (kolen)</option><option>Stoom (olie)</option><option>Stoom (stoomketel)</option><option>geen</option></select><br>';
					break;
				case "Electriciteit":
					$form .= 'Aandrijftype:<br><select name="brandstof"><option>Diesel</option><option>Benzine</option><option selected>Electriciteit</option><option>Stoom (kolen)</option><option>Stoom (olie)</option><option>Stoom (stoomketel)</option><option>geen</option></select><br>';
					break;
				case "Stoom (kolen)":
					$form .= 'Aandrijftype:<br><select name="brandstof"><option>Diesel</option><option>Benzine</option><option>Electriciteit</option><option selected>Stoom (kolen)</option><option>Stoom (olie)</option><option>Stoom (stoomketel)</option><option>geen</option></select><br>';
					break;
				case "Stoom (olie)":
					$form .= 'Aandrijftype:<br><select name="brandstof"><option>Diesel</option><option>Benzine</option><option>Electriciteit</option><option>Stoom (kolen)</option><option selected>Stoom (olie)</option><option>Stoom (stoomketel)</option><option>geen</option></select><br>';
					break;
				case "Stoon (stoomketel)":
					$form .= 'Aandrijftype:<br><select name="brandstof"><option>Diesel</option><option>Benzine</option><option>Electriciteit</option><option>Stoom (kolen)</option><option>Stoom (olie)</option selected><option>Stoom (stoomketel)</option><option>geen</option></select><br>';
					break;
				default:
					$form .= 'Aandrijftype:<br><select name="brandstof"><option>Diesel</option><option>Benzine</option><option>Electriciteit</option><option>Stoom (kolen)</option><option>Stoom (olie)</option><option>Stoom (stoomketel)</option><option selected>geen</option></select><br>';
					break;
				}

				$form .= 'Vermogen:<br><input name="vermogen" value="' . $voertuig['vermogen'] . '"><br>';
				$form .= '<input name="geluid" type="checkbox"' . (($voertuig['geluid'])? " checked" : "") . '>Geluid<br>';
				$form .= 'Vrachttype:<br><input maxlength="1000" name="vrachtType" value="' . $voertuig['vrachtType'] . '"><br>';
				$form .= 'Maximaal gewicht:<br><input name="maximaalGewicht" value="' . $voertuig['maximaalGewicht'] .'"><br>';
				$form .= '<input name="bagageWagen" type="checkbox"' . (($voertuig['bagageWagen'])? " checked" : "") . '>Bagagewagen<br>';
				$form .= 'Aantal passagiers:<br><input name="numPasagiers" value="' . $voertuig['numPasagiers'] .'"><br>';

				$form .= '<input type="submit" value="opslaan"><input type="reset"></form>';
				echo $form;
			}
			else
				echo "<h3>Fout 1!</h3><p>Er is geen object met dit id gevonden</p>";
		} elseif(isset($categorie))
		{
			$voertuigSelectie = [];
			$itterator = 0;
			foreach($voertuigData as $voertuig)
			{
				if($voertuig['soort'] == $categorie)
					$voertuigSelectie[$itterator] = $voertuig;
				$itterator++;
			}

			foreach($voertuigSelectie as $voertuig)
			{
				$echoData = "<tr>";
				$echoData .= "<td>" . $voertuig['id'] . "</td>";
				$echoData .= "<td><a href=\"index.php?id=" . $voertuig['id'] . "\">" . $voertuig['naam'] . "</a></td>";
				$echoData .= "<td>" . $voertuig['nummer'] . "</td>";
				$echoData .= "<td>" . $voertuig['type'] . "</td>";
				$echoData .= "<td>" . $voertuig['tijdperk'] . "</td>";
				$echoData .= "<td>" . ($voertuig['projectAfgerond'] == 1? "ja": "nee") . "</td>";
				$echoData .= "</tr>";

				echo $echoData;
			}

		} else
		{
			echo "<h3>Fout 2!</h3><p>Kon geen data laden.</p>";
		}

		if((!isset($id)) || (isset($categorie)))
		{?>
			</tbody>
		</table>
		<?php
		}

		if((!isset($id)) || (isset($categorie)))
		{
			if(isset($categorie))
				echo "<p>Selectie van de categorie: " . $categorie . "</p>";
		?>

		<table class="sortable">
			<thead>
				<tr>
					<th>
						ID
					</th>
					<th>
						Naam
					</th>
					<th>
						Producent
					</th>
					<th>
						Aantal Functies
					</th>
					<th>
						Geluid
					</th>
					<th>
						Effecten
					</th>
					<th>
						Verwijderen
					</th>
				</tr>
			</thead>
			<tbody>

		<?php
		}

		if(!(isset($id) || isset($categorie)))
		{
			foreach($decoderData as $decoder)
			{
				$echoData = "<tr>";
				$echoData .= "<td>" . $decoder['id'] . "</td>";
				$echoData .= "<td><a href=\"decoder.php?id=" . $decoder['id'] . "\">" . $decoder['naam'] . "</a></td>";
				$echoData .= "<td>" . $decoder['producent'] . "</td>";
				$echoData .= "<td>" . $decoder['numFuncties'] . "</td>";
				$echoData .= "<td>" . ($decoder['geluid'] == 1? "ja": "nee") . "</td>";
				$echoData .= "<td>" . ($decoder['effecten'] == 1? "ja": "nee") . "</td>";
				$echoData .= "<td><a href=\"delete.php?soort=decoder&id=" . $decoder['id'] . "\">Verwijderen</a></td>";
				$echoData .= "</tr>";

				echo $echoData;
			}
		} else
		{
			if(!isset($id))
				echo "<h3>Fout 3!</h3><p>Kon geen data laden.</p>";
		}

		if((!isset($id)) || (isset($categorie)))
		{?>
			</tbody>
		</table>
		<?php
		}
		?>

	</body>
</html>
<?php } ?>
