<?php
require("../../config/settings.php");
require("blocks/header.php");
if(isset($_POST['cancel'])){
	$cancel_order = new Orders($_POST['order_id']);
	$cancel_order = $cancel_order->updateStatusByAdmin($status = "anulata");
}

if(isset($_POST['approve'])){
	$cancel_order = new Orders($_POST['order_id']);
	$cancel_order = $cancel_order->updateStatusByAdmin($status = "preluata");
}



if(isset($_POST['delete'])){
	$delete_order = new Orders;
	$delete_order->delete($_POST['order_id']);

	$_SESSION['succes'] = "The order was deleted!";
}
?>

<div class="main-content">
	<nav class="navbar user-info-navbar"  role="navigation">
	<!-- User Info, Notifications and Menu Bar -->
		<ul class="user-info-menu left-links list-inline list-unstyled">
			<?php require("blocks/notifications.php"); ?>
		</ul>
		<?php require("blocks/user-settings.php"); ?>
	</nav>
	<div class="page-title">
		<div class="title-env">
			<h1 class="title">Comenzi</h1>
			<p class="description">Gestionare comenzi</p>
		</div> 
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">Comenzi recente</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
						<?php
							
							$orders = new Orders;        
							$orders = $orders->getOrders();          
							
							if (count($orders) > 0) {
								?>
								<table class="table">
									<thead>
										<tr>
											<th>#</th>
											<th>Data comanda</th>
											<th>Status</th>
											
											<th>Detalii</th>
	
											<th>Optiuni</th>
										</tr>
									</thead>
									<?php
									$cnt = 0;
									$orders = Orders::Paginate();
									foreach ($orders as $order) : 
										$cnt++;  
										?>  
										<tr>
											<td><?= $cnt; ?></td>
											<td><?= $order->date_added; ?></td>
											<td><?= $order->status; ?></td>
											
											<td><?= $order->name; ?> - 0<?= $order->phone; ?> </td>
											
											<td>
												<a style="float: left; margin-right: 10px;" class="btn btn-icon btn-warning" href="order-details.php?action=order&edit=<?= $order->id ?>">
													<i class="fa-eye"></i>
												</a>
												<a class="btn btn-icon btn-info options-images" onclick="jQuery('#approveModal_<?=$order->id?>').modal('show', {backdrop: 'true'});">
													<i class="fa-check"></i>
												</a>
												<a style="float: left; margin-right: 10px;" class="btn btn-icon btn-red" onclick="jQuery('#cancelModal_<?=$order->id?>').modal('show', {backdrop: 'true'});">
													<i class="fa-remove"></i>
												</a>
												<a style="float: left; margin-right: 10px;" class="btn btn-icon btn-red" onclick="jQuery('#deleteModal_<?=$order->id?>').modal('show', {backdrop: 'true'});">
													<i class="fa-trash"></i>
												</a>
												<div id="deleteModal_<?= $order->id ?>" class="modal fade">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Delete</h4>
															</div>
															<div class="modal-body">
																<p>Really delete ?</p>
															</div>
															<div class="modal-footer">
																<form id="delete" method="post" action="">
																	<input type="hidden" name="order_id" value="<?= $order->id; ?>"/> 
																	 
																	<input type="hidden" name="delete" value="true"/>
																	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																	<button id="remove" type="submit" value="Delete" class="btn btn-danger">Delete</button>
																</form>
															</div>
														</div>
													</div>
												</div>
												<?php 
													if($order->status == "preluata") {
														?>

														<?php
													} else if ($order->status == "asteptare"){
														?>
														<div id="approveModal_<?= $order->id ?>" class="modal fade">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">Approve</h4>
																</div>
																<div class="modal-body">
																	<p>Really approve <?= $order->id; ?>?</p>
																</div>
																<div class="modal-footer">
																	<form id="delete" method="post" action="">
																		<input type="hidden" name="order_id" value="<?= $order->id; ?>"/> 
																		<input type="hidden" name="approve" value="true"/>
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																		<button id="remove" type="submit" value="Delete" class="btn btn-danger">Approve</button>
																	</form>
																</div>
															</div>
														</div>
													</div>
													<?php
													}
												?>
												
												<div id="cancelModal_<?= $order->id ?>" class="modal fade">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Cancel</h4>
															</div>
															<div class="modal-body">
																<p>Really cancel <?= $order->id; ?>?</p>
															</div>
															<div class="modal-footer">
																<form id="delete" method="post" action="">
																	<input type="hidden" name="order_id" value="<?= $order->id; ?>"/> 
																	<input type="hidden" name="cancel" value="true"/>
																	<input type="hidden" name="delete" value="true"/>
																	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																	<button id="remove" type="submit" value="Delete" class="btn btn-danger">Cancel</button>
																</form>
															</div>
														</div>
													</div>
												</div>    
											</td>

										</tr>
									<?php endforeach; ?>
								</table>
								<?= Orders::Links(); 

							}else{
								?>
								<p>Momentan, nu sunt comenzi efectuate</p>
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
