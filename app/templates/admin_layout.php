
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
	<link rel="icon" type="image/png" href="<?= $this->assetUrl('img/icons/favicon.png') ?>" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/reset.css') ?>" />
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>" />
</head>
<body>
	<div class="container">
		
	<header>
			<h1>BDLoc :: <?= $this->e($title) ?></h1>
			<div class="logInfo">
				<a href="<?= $this->url('catalog') ?>">Retour au site</a>
				<a href="<?= $this->url('logout')?>">Se déconnecter</a>
			</div>
				
			<nav>
				<a href="<?= $this->url('show_all_orders') ?>">Voir toutes les commandes des utilisateurs</a>
				<a href="<?= $this->url('confirm_order_return') ?>">Valider le retour d'une commande</a>
			</nav>

		</header>
	
		<section>
			<?= $this->section('main_content') ?>
		</section>

	</div>
</body>
</html>