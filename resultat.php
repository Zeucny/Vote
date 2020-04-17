<?php
    $nbTotalVotant = count(json_decode(file_get_contents("./votants.json"), 1)["votants"]);
    $table=[];
    if (($handle = fopen("resultat.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $table[$data[0]][$data[1]]["vote"] = $data[2];
            $table[$data[0]][$data[1]]["justificatif"] = $data[3];
        }
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
    <title>Résultats</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <div class="container bg-light">
        <br>
        <h1>Résultat des votes</h1>
        <?php foreach($table as $intitulé => $votants){
            ksort($votants);
            $pour = 0;
            $contre = 0;
            $abs = 0;
            $npppav = 0;
            $nbVotant = 0;
        ?>
            <h2><?=$intitulé?></h2>
            <table  class="centered responsive-table highlight">
                <tr>
                    <td><b>Votant</b></td>
                    <td><b>Vote</b></td>
                    <td><b>Justificatif</b></td>
                </tr>
            <?php foreach($votants as $votant => $vote){
                $nbVotant++;
                switch ($vote["vote"]) {
                    case 'Pour':
                        $pour++;
                        break;
                    case 'Contre':
                        $contre++;
                        break;
                    case 'Abstention':
                        $abs++;
                        break;
                    case 'Ne prends pas part au vote':
                        $npppav++;
                        break;
                }
            ?>
                <tr><td><?=$votant?></td><td><?=$vote["vote"]?></td><td><?=$vote["justificatif"]?></td></tr>
            <?php } ?>
            </table>
            <ul class="flow-text">
                <li>Ne prends pas part au vote : <?=$npppav?></li>
                <li>Abstention : <?=$abs?></li>
                <li>Contre : <?=$contre?></li>
                <li>Pour : <?=$pour?></li>
                <li>Total : <?=$nbVotant?>/<?=$nbTotalVotant?></li>
            </ul>
        <?php } ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>

