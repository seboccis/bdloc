<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
	
	<link rel="stylesheet" href="<?= $this->assetUrl('css/reset.css') ?>">
</head>
<body>
	<div class="container">
		<header>
			<h1>BDLoc :: <?= $this->e($title) ?></h1>
		</header>

		<nav>
			<a href="<?php echo $this->url('home');?>">Accueil</a>
			<a href="<?php echo $this->url('catalog');?>">Catalogue</a>
		</nav>

		<section>
			<?= $this->section('main_content') ?>
		</section>

		<footer>
		</footer>
	</div>
</body>
</html>