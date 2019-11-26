<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
	header('location:login.php');
} else {
	if (isset($_GET['id'])) {
		mysqli_query($con, "delete from orders  where userId='" . $_SESSION['id'] . "' and paymentMethod is null and id='" . $_GET['id'] . "' ");;
	}
	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="keywords" content="MediaCenter, Template, eCommerce">
		<meta name="robots" content="all">
		<title>Pending Order History</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="assets/css/green.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.2/owl.transitions.css">
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css">
		<link rel="stylesheet" href="assets/css/config.css">
		<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
		<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
		<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
		<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
		<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
		<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="assets/images/favicon.ico">
	</head>

	<body class="cnt-home">
		<header class="header-style-1">
			<?php include('includes/top-header.php'); ?>
			<?php include('includes/main-header.php'); ?>
			<?php include('includes/menu-bar.php'); ?>
		</header>
		<div class="breadcrumb">
			<div class="container">
				<div class="breadcrumb-inner">
					<ul class="list-inline list-unstyled">
						<li><a href="#">Home</a></li>
						<li class='active'>Shopping Cart</li>
					</ul>
				</div>
			</div>
			<div class="body-content outer-top-xs">
				<div class="container">
					<div class="row inner-bottom-sm">
						<div class="shopping-cart">
							<div class="col-md-12 col-sm-12 shopping-cart-table ">
								<div class="table-responsive">
									<form name="cart" method="post">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th class="cart-romove item">#</th>
													<th class="cart-description item">Image</th>
													<th class="cart-product-name item">Product Name</th>
													<th class="cart-qty item">Quantity</th>
													<th class="cart-sub-total item">Price Per unit</th>
													<th class="cart-sub-total item">Shiping Charge</th>
													<th class="cart-total">Grandtotal</th>
													<th class="cart-total item">Payment Method</th>
													<th class="cart-description item">Order Date</th>
													<th class="cart-total last-item">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php $query = mysqli_query($con, "select products.productImage1 as pimg1,products.productName as pname,products.id as c,orders.productId as opid,orders.quantity as qty,products.productPrice as pprice,products.shippingCharge as shippingcharge,orders.paymentMethod as paym,orders.orderDate as odate,orders.id as oid from orders join products on orders.productId=products.id where orders.userId='" . $_SESSION['id'] . "' and orders.paymentMethod is null");
													$cnt = 1;
													$num = mysqli_num_rows($query);
													if ($num > 0) {
														while ($row = mysqli_fetch_array($query)) {
															?>
														<tr>
															<td><?php echo $cnt; ?></td>
															<td class="cart-image">
																<a class="entry-thumbnail" href="detail.html">
																	<img src="admin/productimages/<?php echo $row['proid']; ?>/<?php echo $row['pimg1']; ?>" alt="" width="84" height="146">
																</a>
															</td>
															<td class="cart-product-name-info">
																<h4 class='cart-product-description'><a href="product-details.php?pid=<?php echo $row['opid']; ?>">
																		<?php echo $row['pname']; ?></a></h4>
															</td>
															<td class="cart-product-quantity">
																<?php echo $qty = $row['qty']; ?>
															</td>
															<td class="cart-product-sub-total"><?php echo $price = $row['pprice']; ?> </td>
															<td class="cart-product-sub-total"><?php echo $shippcharge = $row['shippingcharge']; ?> </td>
															<td class="cart-product-grand-total"><?php echo (($qty * $price) + $shippcharge); ?></td>
															<td class="cart-product-sub-total"><?php echo $row['paym']; ?> </td>
															<td class="cart-product-sub-total"><?php echo $row['odate']; ?> </td>
															<td><a href="pending-orders.php?id=<?php echo $row['oid']; ?> ">Delete</td>
														</tr>
													<?php $cnt = $cnt + 1;
															} ?>
													<tr>
														<td colspan="9">
															<div class="cart-checkout-btn pull-right">
																<button type="submit" name="ordersubmit" class="btn btn-primary"><a href="payment-method.php">PROCCED To Payment</a></button>
															</div>
														</td>
													</tr>
												<?php } else { ?>
													<tr>
														<td colspan="10" align="center">
															<h4>No Result Found</h4>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
								</div>
							</div>
						</div>
					</div>
					</form>
					<?php echo include('includes/brands-slider.php'); ?>
				</div>
			</div>
			<?php include('includes/footer.php'); ?>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-hover-dropdown/2.0.11/bootstrap-hover-dropdown.min.js"></script>
			<script src="assets/js/owl.carousel.min.js"></script>
			<script src="assets/js/echo.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
			<script src="assets/js/bootstrap-slider.min.js"></script>
			<script src="assets/js/jquery.rateit.min.js"></script>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/0.1.12/wow.min.js"></script>
			<script src="assets/js/scripts.js"></script>
			<script src="switchstylesheet/switchstylesheet.js"></script>
			<script>
				$(document).ready(function() {
					$(".changecolor").switchstylesheet({
						seperator: "color"
					});
					$('.show-theme-options').click(function() {
						$(this).parent().toggleClass('open');
						return false;
					});
				});
				$(window).bind("load", function() {
					$('.show-theme-options').delay(2000).trigger('click');
				});
			</script>
	</body>

	</html>
<?php } ?>