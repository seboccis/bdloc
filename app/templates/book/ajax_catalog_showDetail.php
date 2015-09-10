<?php ?>

	<div class="table">
		<div class="row">

			<div class="cell cell-left">
				
				<img src="<?php echo $this->assetUrl('img/covers/'.$book['cover']);?>">
			
			</div>
			
			<div class="cell cell-right">

				<form id="detailsOnBook">

					<fieldset>

						<legend>Informations détaillées sur cette BD</legend>

						<h1><?php echo $this->e($book['title'])?></h1>
						<p>
							Scénariste : 
							<?php 
								if (empty($this->e($book['scenaristAka']))) {
									echo $this->e($book['scenaristFirstName']) . " " . $this->e($book['scenaristLastName']);
								} else {
									echo $this->e($book['scenaristAka']);
								}
							?>		
						</p>
						<p>
							Illustrateur : 
							<?php
								if (empty($this->e($book['illustratorAka']))) {
									echo $this->e($book['illustratorFirstName']) . " " . $this->e($book['illustratorLastName']) ;
								} else {
									echo $this->e($book['illustratorAka']);
								}
							?>
						</p>
						<p>
							Coloriste : 
							<?php
								if (empty($this->e($book['coloristAka']))) {
									echo $this->e($book['coloristFirstName']) . " " . $this->e($book['coloristLastName']) ;
								} else {
									echo $this->e($book['coloristAka']);
								}
							?>
						</p>

						<?php if ($book['isBookInCart'] == 0 && $book['quantity_available'] != 0){	 ?>		

							<button class="addToCart btn btn-success" data-bookId="<?= $book['id'] ?>"><i class="fa fa-cart-plus"></i> Ajouter au panier</button>

						<?php }else if($book['isBookInCart'] == 1){									 ?>

							<p>Ajouté au panier !</p>
						<?php }																		?>
						<p id="cartError"></p>

					</fieldset>
							
				</form>

				<form id="detailsOnSerie">

					<fieldset>

						<legend>Série : <?php echo $serieTitle; ?></legend>

						<div id="carousel">

							<button id="btnCarouselPrev" class="btnCarousel"><span>&lsaquo;</span></button>

							<div id="carouselWindow" data-numberBooksInSerie="<?php echo $numberBooksInSerie; ?>" data-carouselPosition="1">

								<div id="spriteCarousel">

<?php 	foreach($booksCarousel as $bookC){													?>

									<a href="" class="newDetail" data-bookId="<?php echo $bookC['id']; ?>">

										<figure class="cardCarousel">
											<div class="coverCardCarousel">
												<img src="<?php echo $this->assetUrl('img/mini-covers/'.$bookC['cover']); ?>" alt="<?php echo $bookC['title']; ?>">
											</div>
											<figcaption>
												<p><?php echo $bookC['num']; ?> : <?php echo $bookC['title']; ?></p>
											</figcaption>
										</figure>

									</a>

<?php 	}																					?>				
				    
								</div>

							</div>

<?php if($numberBooksInSerie != 1){															?>

							<button id="btnCarouselNext" class="btnCarousel"><span>&rsaquo;</span></button>

<?php }																						?>

							<div id="carouselIndicators">

								<span>

<?php 	if($numberBooksInSerie > 1){														?>

									<a href="" class="carouselIndicator" data-carouselPosition="1"><i class="fa fa-circle"></i></a>

<?php 		for($index = 2; $index <= $numberBooksInSerie; $index++){						?>

									<a href="" class="carouselIndicator" data-carouselPosition="<?= $index; ?>"><i class="fa fa-circle-thin"></i></a>

<?php 		}
		}																					?>
								</span>

							</div>

						</div>

					</fieldset>

				</form>
				
			</div>

		</div>
		
		<button id='closeLightBox'><span>&times;</span></button>

	</div>	
