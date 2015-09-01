
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
	<style type="text/css">
			html {
				height: 100%
			}
			body {
				height: 100%;
				margin: 0;
				padding: 0
			}
			section{
				height: 70%;
				width: 50%;
				position: absolute;
				top: 50%;
				left: 50%;
				-webkit-transform: translateX(-50%)translateY(-50%);
				-ms-transform: translateX(-50%)translateY(-50%);
				-o-transform: translateX(-50%)translateY(-50%);
				transform: translateX(-50%)translateY(-50%);
			}
			#mapDeliveryPlacesChoice {
				height: 100%
			}
			#validateChoicedDeliveryPlace{
				display: none;
			}
		</style>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link rel="icon" type="image/png" href="<?= $this->assetUrl('img/icons/favicon.png') ?>" />
	<link rel="stylesheet" href="<?= $this->assetUrl('css/reset.css') ?>" />
</head>
<body>
	<div class="container">
		<header>
			<h1>BDLoc :: <?= $this->e($title) ?></h1>
		</header>

		<section>
			<?= $this->section('main_content') ?>
		</section>

		<footer>
		</footer>
	</div>
</body>
</html>