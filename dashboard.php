<?php
$lock_page = true;
include_once "rfclass/check_login.php";
include_once "lib_THEsite.php";
require_once 'class.db.php';
require_once 'config.php';
include_once("lib_ebay.php");
?>
<!DOCTYPE HTML>
<!--
	MEGASELLERS by Pixelarity
	pixelarity.com @pixelarity
	License: pixelarity.com/license
-->
<html>
	<head>
                <title>MEGASELLERS - Dashboard</title>
		<?php echo getHTMLHead();?>
		<link rel="stylesheet" type="text/css" href="src/DataTables/datatables.min.css"/>
 
                
	</head>
	<body>
		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Header -->
					<header id="header">
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

				<!-- Main -->
					<article id="main">
						<header>
							<h2>Welcome back <?php echo $jakuser->getVar("first_name");?>!</h2>
							<p>Your Dashboard : Items Manager</p>
						</header>
						<section class="wrapper style5">

							<div class="inner">
                                                            
<a href="#inline_example" id="notifyWindow" style="display:none;" class="ilightbox" data-type="inline"></a>
<div id="inline_example" style="display:none;width:50%;height:80%;">Error Notification.</div>

                                                            <!-- Zozo Tabs Start-->
								<div id='tabbed-nav'>
									<ul>
										<li data-link="eBayItemsTab"><a>eBay Items</a></li>
                                                                                <li data-link="AmazonItemsTab"><a>Amazon Items</a></li>
										<li data-link="Settings"><a>Settings</a></li>

									</ul>
									<div>
										<div data-content-url='eBayItemsTab.php'></div>
                                                                                <div data-content-url='AmazonItemsTab.php'></div>
										<div data-content-url='settings.php'></div>
									</div>
								</div>
								<!-- Zozo Tabs End-->

							</div>
						</section>
					</article>

				<!-- Footer -->
					<?php echo getHTMLFooter();?>

			</div>

		<!-- Scripts -->
                    <?php echo getHTMLScriptsPart(); ?>
                    <script>
                        $('.ilightbox').iLightBox();
                    </script>
                    <!-- Zozo Tabs css -->
                    <link href="src/TABS/css/zozo.tabs.min.css" rel="stylesheet" />
                    <script>																	
                        jQuery(document).ready(function ($) {
                                $("#tabbed-nav").zozoTabs({
                                        theme: "white",
                                        size: "medium",
                                        position: "top-compact",
                                        delayAjax:350,
                                        orientation: "horizontal",
                                        deeplinking: true,
                                        rememberState: true,
                                        defaultTab: "eBayItemsTab"
                                })
                        });
                    </script>

                    <!-- Zozo Tabs js -->
                    <script src="src/TABS/js/zozo.tabs.min.js"></script>
                    
	</body>
</html>