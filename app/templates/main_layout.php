<!DOCTYPE html>
<html lang="fr">
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
	<meta charset="UTF-8">
	<title>BDLoc :: <?= $this->e($title) ?></title>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/jQuery.min.js') ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/markerIconsLibrary.js'); ?>"></script>
	<link rel="icon" type="image/png" href="<?= $this->assetUrl('img/icons/favicon.png') ?>" />
	<link rel="stylesheet" href="<?= $this->assetUrl('css/reset.css') ?>" />
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>" />
</head>
<body>
	<div class="container">
		<header>
			<h1>BDLoc :: <?= $this->e($title) ?></h1>
			<div class="logInfo">
				<h2><?= $w_user['username'] ?></h2>
				<a href="<?= $this->url('logout')?>">Se déconnecter</a>
			</div>
				
			<nav>
				<a href="<?php echo $this->url('catalog');?>">Catalogue</a>
				<a href="<?php echo $this->url('cart');?>">Mon Panier <em id="numberBooksInCart" data-ajax-main-countBooksInCart="<?php echo $this->url('ajax_main_countBooksInCart'); ?>"></em></a>
				<a href="<?php echo $this->url('account');?>">Mon Compte</a>
			</nav>
		</header>


		<section>
			<?= $this->section('main_content') ?>
		</section>

		<footer>
		</footer>
		
		<div id='shadow'>
			<div id="lightBox" data-ajax-catalog-getDetail-path="<?php echo $this->url('ajax_catalog_detail'); ?>"></div>
		</div>

		<script type="text/javascript" src="<?= $this->assetUrl('js/main.js') ?>"></script>
		
	</div>
</body>
</html>