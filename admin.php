<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="https://fedeb.net/wp-content/uploads/2018/03/FEDEB-Logo.png">
    <link rel="apple-touch-icon" href="https://fedeb.net/wp-content/uploads/2018/03/FEDEB-Logo.png"/>
    <title>Administration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <div class="container bg-light">
    <?php
        if (count($_POST)){
            $_POST["vote"] = str_replace(";", ",", $_POST["vote"]);
            file_put_contents("vote.txt", $_POST["vote"]);?>
				<div class="row">
					<div class="col s12 m6  m6 offset-m3">
						<div class="card blue darken-1">
							<div class="card-content white-text">
								<p>Changement validé !</p>
							</div>
						</div>
					</div>
				</div>
        <?php } ?>
        <h1>Changement de vote</h1>
        <form action="admin.php" method="post">
            <div class="form-group">
                <label for="vote">Intitulé du vote</label>
                <input type="text" class="form-control" id="vote" name="vote">
            </div>
            <input class="btn btn-primary" type="submit" value="changer">
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>