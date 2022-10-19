<?php
require("../../config/settings.php");
if(isset($_POST['cancel'])){
	$cancel_order = new Orders($_POST['order_id']);
	$cancel_order = $cancel_order->updateStatusByAdmin($status = "anulata");
}

if(isset($_POST['approve'])){
	$cancel_order = new Orders($_POST['order_id']);
	$cancel_order = $cancel_order->updateStatusByAdmin($status = "achitata");
}
require("blocks/header.php");
?>

<div class="main-content">
	<nav class="navbar user-info-navbar"  role="navigation"><!-- User Info, Notifications and Menu Bar -->
		<ul class="user-info-menu left-links list-inline list-unstyled">
			<?php require("blocks/notifications.php"); ?>
		</ul>
		<?php require("blocks/user-settings.php"); ?>
	</nav>
	<div class="page-title">
		<div class="title-env">
			<?php 
			if(isset($_GET['edit'])) {
				$order = new Orders($_GET['edit']);
				?>
				<h1 class="title">Order: <?= $order->id ?> - <?= $order->status ?></h1>
				<p class="description">Add Date: <?= $order->date_added ?></p>
				<?php
			}
			?>
			
		</div> 
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">Detalii comanda</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group col-xs-6">
								
								<label class="control-label">Date client:</label><br>
								
								<?php
								if($order->user_id > 0) {
									$user = new User($order->user_id);
									echo "<strong>" . $user->email . "</strong><br>";
									echo "<strong>" . $user->name . ' ' . $user->last_name . "</strong><br>";
								}else{
									echo "<strong>" . $order->temp . " Lei</strong><br>";
									echo "<strong>" . $order->first_name . ' ' . $order->last_name . "</strong><br>";
								}
								
								?>
								<strong>0<?= $order->phone; ?></strong><br><br>
								<label class="control-label">Adresa livrare:</label><br>
								
                                <?php
                                    $address = new Address();
                                    $getAddress = $address->AllAddresses($order->user_id);
                                  
                                ?>
								<strong><?= $getAddress[0]->address; ?> <?= $getAddress[0]->town; ?> </strong><br>
							</div>
							<div class="form-group col-xs-6">
								<label class="control-label">Total:</label>
								<h3><?= Functions::FormatPrice($order->total); ?> Lei</h3>
							</div>
							<?php

							$products = $order->getProductsFromOrder($order->id);
							if (count($order) > 0) {
								?>
								<table class="table">
									<thead>
										<tr>
											<th>#</th>
											<th>Imagine</th>
											<th>Produs</th>
											<th>Cantitate</th>
											<th>Pret</th>

										</tr>
									</thead>
									<?php
									$cnt = 0;

									foreach ($products as $product_order) {
										$cnt++;  

										
                                        $product = new Product($product_order->product_id);
                                        $seasons = new Season();
                                        $season = $seasons->find($product->season_id);
            
                                        $widths = new Width();
                                        $width = $widths->find($product->width_id);
                                        
                                        $heights = new Height();
                                        $height = $heights->find($product->height_id);
                                       
                                        $diameters = new Diameter();
                                        $diameter = $diameters->find($product->diameter_id);
            
                                        $suppliers = new Supplier();
                                        $supplier = $suppliers->find($product->supplier_id);
                                      
										

										?>  
										<tr>
											<td><?= $cnt; ?></td>
											<td>
												
												
													<img class="mr-15" style="width: 100px" src="<?= $product->image ?>" /> 
									
											</td>
											<td>
                                            <?= "Anvelope " . $season->season_name[0] . " " . $width->width_name[0] . "/" . $height->height_name[0] . "/R" . $diameter->diameter_name[0] . " " . $product->product_name . " " . $supplier->supplier_name[0] . " " . $product->model ?><br>
												
											</td>

											<td>
												<?= $product_order->qnt;	?>
											</td>
											<td>
												<?= $product->price;	?>
											</td>


										</tr>
										<?php 
									}
									?>
								</table>
								<?php

							}else{
								?>
								<p>No info</p>
								<?php
							}
							?>

						</div>
					</div>

				</div>
			</div>

		</div> 

	</div>
	<?php
	require("blocks/footer.php");
	?>
</div>
