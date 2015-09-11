<?php $this->layout('layout', ['title'=>'forgot_password']) ?>

<?php $this->start('main_content') ?>


	<div class="navigation navigation-email">

		<form action="" method="post">
			<div class="form-group">
				<label for="email">Votre email</label>
					<input type="email" name="email" id="email">
					<div class="help-block text-danger"><?= $this->e($errorEmail) ?></div>
			</div>

			<div class="link">
				<button>Envoyer l'email</button>
				<a class="btn btn-danger" href="<?= $this->url('home') ?>">Retour</a>
			</div>
			
		</form>
	</div>
	
<?php $this->stop('main_content') ?>