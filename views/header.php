<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="assets/css/custom.css">
	</head>
	<body>
		<header>
			<a class="title" href="http://localhost/lemarche">Le Marché</a>
			<div id="bars" class="controls off">
			</div>
			<div class="menu">
				<div class="menu-wrapper">
					<h2>Menu</h2>
					<?php if(isset($_SESSION['id'])) { ?>
						<div class="account">
							<h3>Mohammed<span class="menu-icon"><img class="img-thumb" src="http://pre15.deviantart.net/2ecc/th/pre/f/2013/007/9/1/chibi_gon_2011_by_zat3am-d5qtl8s.jpg"></span></h3>
							<ul class="menu-list">
								<li>
									<a href="editprofil">Edit Profile<span class="menu-icon fa fa-cog"></span></a>
									</li>
								<li>
									<a href="history">View History<span class="menu-icon fa fa-history"></span></a>
								</li>
								<li>
									<a href="logout">Logout<span class="menu-icon fa fa-sign-out"></span></a>
								</li>
							</ul>
						</div>
						<div class="cart">
							<h3>Cart<span class="menu-icon fa fa-shopping-cart"></span></h3>
							<ul class="cart-list">
								<li>
									Product 1<div class="close-btn menu-icon"><span class="fa fa-times"></span></div>
								</li>
								<li>
									Product 2<div class="close-btn menu-icon"><span class="fa fa-times"></span></div>
								</li>
								<li>
									Product 3<div class="close-btn menu-icon"><span class="fa fa-times"></span></div>
								</li>
							</ul>
						</div>
					<?php } else { ?>
						<ul class="menu-list">
							<li>
								<a href="login">Login<span class="menu-icon fa fa-sign-in"></span></a>
								</li>
							<li>
								<a href="register">Register<span class="menu-icon fa fa-pencil"></span></a>
							</li>
						</ul>
					<?php }  ?>
				</div>
			</div>
		</header>
