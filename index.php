<?php
include_once "lib_THEsite.php";
include_once "rfclass/check_login.php";
if(preg_match("{^(?:\s+)?$}siu",$jakuser->getVar("id"))){
    $goToDashboard="showModalWnd(0,'','');";
}else{
    $goToDashboard="window.open('dashboard.php','_self');";
}
?>

<!DOCTYPE HTML>
<!--
	MEGASELLERS by Pixelarity
	pixelarity.com @pixelarity
	License: pixelarity.com/license
-->
<html>
	<head>
		<title>MEGASELLERS</title>
		<?php echo getHTMLHead();?>
	</head>
	<body class="landing">

		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Header -->
					<header id="header" class="alt">
						<h1><a href="index.php">MEGASELLERS</a></h1>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
											<li><a href="index.php">Home</a></li>
                                                                                        <li><a href="dashboard.php">Dashboard</a></li>
                                                                                        <li><a href="PrivacyPolicy.php">Privacy Policy</a></li>
											<li><a href="elements.php">Elements</a></li>
											<li><a href="#">Sign Up</a></li>
											<li><a href="#">Log In</a></li>
										</ul>
									</div>
								</li>
							</ul>
						</nav>
					</header>

				<!-- Banner -->
					<section id="banner">
						<div class="inner">
							<h2>MEGASELLERS</h2>
							<p>The most advanced tool for eBay sellers.<br />
							Automate your eBay things.<br />
							Automate your Business</p>
							<ul class="actions">
								<li><a class="button1 special" onclick="<?php echo $goToDashboard;?>">Your Dashboard</a></li>
							</ul>
						</div>
						<a href="#one" class="more scrolly">Learn More</a>
					</section>

				<!-- One -->
					<section id="one" class="wrapper style1 special">
						<div class="inner">
							<header class="major">
								<h2>Automate your eBay things.</h2>
								<p>MEGASELLERS automatically updates your listings based on the supply <br />
								and availability of your suppliers and competitors.</p>
							</header>
							<ul class="icons major">
								<li><span class="icon fa-diamond major style1"><span class="label">Lorem</span></span></li>
								<li><span class="icon fa-heart-o major style2"><span class="label">Ipsum</span></span></li>
								<li><span class="icon fa-code major style3"><span class="label">Dolor</span></span></li>
							</ul>
						</div>
					</section>

				<!-- Two -->
					<section id="two" class="wrapper alt style2">
						<section class="spotlight">
							<div class="image"><img src="images/pic01.jpg" alt="" /></div><div class="content">
								<h2>Monitor Supplier Price</h2>
								<p>Do you dropship from a supplier with rapidly changing prices? When supplier prices change, MEGASELLERS can automatically revise the price on your eBay listing according to your pricing formula.</p>
							</div>
						</section>
						<section class="spotlight">
							<div class="image"><img src="images/pic02.jpg" alt="" /></div><div class="content">
								<h2>Availability Rules</h2>
								<p>MEGASELLERS can be set to consider items on preorder, backorder, minimum-order-quantity, and more to be out of stock. Set it to increase your price, modify handling time, or hard-delist your corresponding listing.</p>
							</div>
						</section>
						<section class="spotlight">
							<div class="image"><img src="images/pic03.jpg" alt="" /></div><div class="content">
								<h2>Management Dashboard</h2>
								<p>Our powerful account management dashboard allows you to monitor pricing updates in real-time, configure your pricing rules, set exceptions for individual listings, and more.</p>
							</div>
						</section>
					</section>

				<!-- Three -->
					<section id="three" class="wrapper style3 special">
						<div class="inner">
							<header class="major">
								<h2>Our Happy User Said:</h2>
								<p>If you want to be in a game, then you need this system.</p>
							</header>
							<ul class="features">
								<li class="icon fa-paper-plane-o">
									<h3>Quantity Maintenance</h3>
									<p>MEGASELLERS can automatically increase your item quantity after sales to hold it at a fixed level.</p>
								</li>
								<li class="icon fa-laptop">
									<h3>Easy Setup</h3>
									<p>After linking your eBay account, we'll schedule a brief call to help you configure your account to optimize your business. Then sit back and relax as MEGASELLERS automatically and intelligently maintains your listings!</p>
								</li>
								<li class="icon fa-code">
									<h3>Obsessive Support</h3>
									<p>Have a question, problem, or request? Reach us anytime by phone, email or chat. We love our customers, and we're constantly making improvements and additions based on feedback.</p>
								</li>
								<li class="icon fa-headphones">
									<h3>Mauris Imperdiet</h3>
									<p>Augue consectetur sed interdum imperdiet et ipsum. Mauris lorem tincidunt nullam amet leo Aenean ligula consequat consequat.</p>
								</li>
								<li class="icon fa-heart-o">
									<h3>Aenean Primis</h3>
									<p>Augue consectetur sed interdum imperdiet et ipsum. Mauris lorem tincidunt nullam amet leo Aenean ligula consequat consequat.</p>
								</li>
								<li class="icon fa-flag-o">
									<h3>Tortor Ut</h3>
									<p>Augue consectetur sed interdum imperdiet et ipsum. Mauris lorem tincidunt nullam amet leo Aenean ligula consequat consequat.</p>
								</li>
							</ul>
						</div>
					</section>

				<!-- CTA -->
					<section id="cta" class="wrapper style4">
						<div class="inner">
							<header>
								<h2>Let's Automate your Business!</h2>
								<p>Contact us now to discuss how MEGASELLERS can take your eBay business to the next level.</p>
							</header>
							<ul class="actions vertical">
								<li><a class="button1 fit special" onclick="showModalWnd(0,'','');">Your Dashboard</a></li>
								<li><a href="#" class="button1 fit">Learn More</a></li>
							</ul>
						</div>
					</section>

				<!-- Footer -->
					<?php echo getHTMLFooter();?>

			</div>

		<!-- Scripts -->
			<?php echo getHTMLScriptsPart(); ?>

	</body>
</html>