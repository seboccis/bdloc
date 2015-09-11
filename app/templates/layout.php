
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
	<link rel="icon" type="image/png" href="<?= $this->assetUrl('img/icons/favicon.png') ?>" />
	<link rel="stylesheet" href="<?= $this->assetUrl('css/reset.css') ?>" />
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>" />
</head>
<body>
	<div class="container">
		<img class="banner" src="<?php echo $this->assetUrl('img/banner/paris.jpeg')?>" alt="Photo de Paris">
		<header class="default">
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