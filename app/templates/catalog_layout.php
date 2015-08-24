<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Catalogue</title>
	<script type="text/javascript" src="<?= $this->assetUrl('js/jQuery.min.js') ?>"></script>
	<link rel="stylesheet" href="<?= $this->assetUrl('css/reset.css') ?>">
</head>
<body>
	<div class="container" value="<?= $this->url('ajax_catalog');?>">
		<header>
			<h1>BDLoc :: <?= $this->e($title) ?></h1>
		</header>

		<nav>
			<a href="<?php echo $this->url('home');?>">Accueil</a>
			<a href="<?php echo $this->url('catalog');?>">Catalogue</a>
		</nav>

		<section id='showBooks'>
			<?= $this->section('main_content') ?>
		</section>

		<footer>
		</footer>
		<script type="text/javascript" src="<?= $this->assetUrl('js/catalog.js') ?>"></script>
	</div>
</body>
</html>