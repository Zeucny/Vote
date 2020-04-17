<?php

    //GET DATAS
    $votants = json_decode(file_get_contents("./votants.json"), 1)["votants"];
    $vote = file_get_contents("./vote.txt");
    $table=[];
    if (($handle = fopen("resultat.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
            $table[$data[0]][$data[1]] = $data[2];
        fclose($handle);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="https://fedeb.net/wp-content/uploads/2018/03/FEDEB-Logo.png">
    <link rel="apple-touch-icon" href="https://fedeb.net/wp-content/uploads/2018/03/FEDEB-Logo.png"/>
    <title>Vote</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>
	<nav>
    <div class="nav-wrapper blue">
      <div class="container">
      <a href="#" class="brand-logo center">
        <img src="https://fedeb.net/wp-content/uploads/2018/03/FEDEB-Logo.png" width="55" height="auto" alt="">
      </a>
      <ul id="nav-mobile" class="left">
      <li><a href="index.php">Voter</a></li>
        <li><a href="resultat.php">Résultat</a></li>
      </ul>
      <a class="btn-floating btn-large halfway-fab waves-effect waves-light amber" href="javascript:window.location.reload()">
        <i class="material-icons">cached</i>
      </a>
      </div>
    </div>
  </nav>
    <div class="container">

<?php
    if (count($_POST)){
        //sécurité
        if ($_POST["id"] != file_get_contents("./vote.txt")){?>
						<div class="row">
							<div class="col s12 m6 offset-m3">
								<div class="card blue darken-1">
									<div class="card-content white-text">
										<span class="card-title">Card Title</span>
										<p>Ce vote est déjà passé ou vous avez eu un problème, rechargez la page</p>
									</div>
									<div class="card-action">
										<a href="index.php">Recharger</a>
										<a href="resultat.php">Resultat</a>
									</div>
								</div>
							</div>
						</div>
            <?php exit;
        }
        if (!in_array($_POST["votant"], $votants)){?>
						<div class="row">
							<div class="col s12 m6 offset-m3">
								<div class="card blue darken-1">
									<div class="card-content white-text">
										<p>Ce votant n'existe pas ou vous avez eu un problème, rechargez la page</p>
									</div>
									<div class="card-action">
										<a href="index.php">Recharger</a>
										<a href="resultat.php">Resultat</a>
									</div>
								</div>
							</div>
						</div>
            <?php exit;
        }
        if (!in_array($_POST["vote"], ["Pour", "Contre", "Abstention", "Ne prends pas part au vote"])){?>
						<div class="row">
							<div class="col s12 m6 offset-m3">
								<div class="card blue darken-1">
									<div class="card-content white-text">
										<p>Cette option de vote n'existe pas ou vous avez eu un problème, rechargez la page</p>
									</div>
									<div class="card-action">
										<a href="index.php">Recharger</a>
										<a href="resultat.php">Resultat</a>
									</div>
								</div>
							</div>
						</div>
            <?php exit;
        }
        if (isset($table[$vote][$_POST["votant"]])){?>
						<div class="row">
							<div class="col s12 m6  m6 offset-m3">
								<div class="card blue darken-1">
									<div class="card-content white-text">
										<p>Vous avez déjà voté !</p>
									</div>
									<div class="card-action">
										<a href="index.php">Recharger</a>
										<a href="resultat.php">Resultat</a>
									</div>
								</div>
							</div>
						</div>
            <?php exit;
        }

        $_POST["justificatif"] = str_replace(";", ",", $_POST["justificatif"]);

        file_put_contents("resultat.csv", $_POST["id"].";".$_POST["votant"].";".$_POST["vote"].";".$_POST["justificatif"]."\n", FILE_APPEND | LOCK_EX);
        header('Location: resultat.php');
        exit;
    }
?>
        <h1>Intitulé du vote : <?=$vote?></h1>
        <form action="index.php" method="post">
            <input type="hidden" id="id" name="id" value="<?=$vote?>"> 
            <div class="input-field col s12">
                <p>Votant</p>
                <select class="browser-default" name="votant" id="votant">
                    <?php foreach ($votants as $votant) {
                        echo('<option value="'.$votant.'">'.$votant.'</option>');
                    }?>
                </select>
            </div>
            <div class="col s12">
            <p>
              <label>
                <input type="radio" id="npppav" name="vote" value="Ne prends pas part au vote" checked="checked">
                <span>Ne prends pas part au vote</span>
              </label>
            </p>
            <p>
              <label>
                <input type="radio" id="abstention" name="vote" value="Abstention">
                <span>Abstention</span>
              </label>
            </p>
            <p>
              <label>
                <input type="radio" id="contre" name="vote" value="Contre">
                <span>Contre</span>
              </label>
            </p>
            <p>
              <label>
                <input type="radio" id="pour" name="vote" value="Pour">
                <span>Pour</span>
            	</label>
            </p>
            </div>
            <div class="form-group">
                <label for="justificatif">Justificatif de vote (facultatif)</label>
                <textarea class="materialize-textarea" maxlength="500" data-length="500" name="justificatif" id="justificatif"></textarea>
            </div>
            <input class="btn btn-primary" type="submit" value="Voter"></p>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>