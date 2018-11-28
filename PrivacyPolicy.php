<?php
$lock_page = true;
include_once "lib_THEsite.php";
include_once "rfclass/check_login.php";
require_once 'class.db.php';
require_once 'config.php';

$jakdb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$jakdb->set_charset("utf8");
?>
<!DOCTYPE HTML>
<!--
	MEGASELLERS by Pixelarity
	pixelarity.com @pixelarity
	License: pixelarity.com/license
-->
<html>
	<head>
                <title>MEGASELLERS - Privacy Policy</title>
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
							<p>A Privacy Policy Information</p>
						</header>
						<section class="wrapper style5">

							<div class="inner">
								<h3>Policy</h3>
								<p>This privacy policy has been compiled to better serve those who are concerned with how their 'Personally identifiable information' (PII) is being used online. PII, as used in US privacy law and information security, is information that can be used on its own or with other information to identify, contact, or locate a single person, or to identify an individual in context. Please read our privacy policy carefully to get a clear understanding of how we collect, use, protect or otherwise handle your Personally Identifiable Information in accordance with our website.</p>
                                                                <hr />
                                                                
								<p>When ordering or registering on our site, as appropriate, you may be asked to enter your name, email address, mailing address or other details to help you with your experience.</p>
								<hr />

								<h4>Collection</h4>
								<p>We collect information from you when you register on our site, place an order, subscribe to a newsletter or enter information on our site.</p>
                                                                <hr />
                                                                
                                                                <h4>Use and Retention</h4>
								<p>We may use the information we collect from you when you register, make a purchase, sign up for our newsletter, respond to a survey or marketing communication, surf the website, or use certain other site features in the following ways:

                                                                    <br>• To personalize user's experience and to allow us to deliver the type of content and product offerings in which you are most interested.
                                                                <br>• To improve our website in order to better serve you.
                                                                <br>• To allow us to better service you in responding to your customer service requests.
                                                                <br>• To quickly process your transactions.</p>
                                                                <hr />
                                                                
                                                                <h4>Do we use 'cookies'?</h4>
								<p>Yes. Cookies are small files that a site or its service provider transfers to your computer's hard drive through your Web browser (if you allow) that enables the site's or service provider's systems to recognize your browser and capture and remember certain information. For instance, we use cookies to help us remember and process the items in your shopping cart. They are also used to help us understand your preferences based on previous or current site activity, which enables us to provide you with improved services. We also use cookies to help us compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future.</p>
                                                                <hr />
                                                                
                                                                <h4>We use cookies to:</h4>
                                                                <p> • Understand and save user's preferences for future visits.<br>
                                                                    You can choose to have your computer warn you each time a cookie is being sent, or you can choose to turn off all cookies. You do this through your browser (like Internet Explorer) settings. Each browser is a little different, so look at your browser's Help menu to learn the correct way to modify your cookies.</p>
                                                                <hr />
                                                                
                                                                <h4>If users disable cookies in their browser:</h4>
								<p>If you disable cookies off, some features will be disabled It will turn off some of the features that make your site experience more efficient and some of our services will not function properly.
                                                                    <br>However, you can still place orders
                                                                    <br>all
                                                                </p>
                                                                <hr />
                                                                
                                                                <h4>Third Party Disclosure</h4>
								<p>We do not include or offer third party products or services on our website.</p>
                                                                <hr />
                                                                
                                                                <h4>Google</h4>
								<p>Google's advertising requirements can be summed up by Google's Advertising Principles. They are put in place to provide a positive experience for users. https://support.google.com/adwordspolicy/answer/1316548?hl=en 
                                                                    <br>We have not enabled Google AdSense on our site but we may do so in the future.</p>
                                                                <hr />
                                                                
                                                                <h4>California Online Privacy Protection Act</h4>
								<p>CalOPPA is the first state law in the nation to require commercial websites and online services to post a privacy policy. The law's reach stretches well beyond California to require a person or company in the United States (and conceivably the world) that operates websites collecting personally identifiable information from California consumers to post a conspicuous privacy policy on its website stating exactly the information being collected and those individuals with whom it is being shared, and to comply with this policy. - See more at: http://consumercal.org/california-online-privacy-protection-act-caloppa/#sthash.0FdRbT51.dpuf</p>
                                                                <hr />
                                                                
                                                                <h4>According to CalOPPA we agree to the following:</h4>
								<p>Users can visit our site anonymously
                                                                    <br>Once this privacy policy is created, we will add a link to it on our home page, or as a minimum on the first significant page after entering our website.
                                                                    <br>Our Privacy Policy link includes the word 'Privacy', and can be easily be found on the page specified above.
                                                                       <br>
                                                                        <br>Users will be notified of any privacy policy changes:
                                                                         <br>• On our Privacy Policy Page
                                                                        <br>Users are able to change their personal information:
                                                                            <br>• By logging in to their account</p>
                                                                <hr />
                                                                
                                                                <h4>How does our site handle do not track signals?</h4>
								<p>We honor do not track signals and do not track, plant cookies, or use advertising when a Do Not Track (DNT) browser mechanism is in place.</p>
                                                                <hr />
                                                                
                                                                <h4>Does our site allow third party behavioral tracking?</h4>
								<p>It's also important to note that we allow third party behavioral tracking.</p>
                                                                <hr />
                                                                
                                                                <h4>COPPA (Children Online Privacy Protection Act)</h4>
								<p>When it comes to the collection of personal information from children under 13, the Children's Online Privacy Protection Act (COPPA) puts parents in control. The Federal Trade Commission, the nation's consumer protection agency, enforces the COPPA Rule, which spells out what operators of websites and online services must do to protect children's privacy and safety online.
                                                                <br>We do not specifically market to children under 13.</p>
                                                                <hr />
                                                                
                                                                <h4>Fair Information Practices</h4>
								<p>The Fair Information Practices Principles form the backbone of privacy law in the United States and the concepts they include have played a significant role in the development of data protection laws around the globe. Understanding the Fair Information Practice Principles and how they should be implemented is critical to comply with the various privacy laws that protect personal information.</p>
                                                                <hr />
                                                                
                                                                <h4>In order to be in line with Fair Information Practices we will take the following responsive action, should a data breach occur:</h4>
								<p>We will notify the users via email
                                                                    <br>• Within 7 business days
                                                                    <br>We will notify the users via in site notification
                                                                    <br>• Within 7 business days
                                                                    <br><br>
                                                                
                                                                    We also agree to the individual redress principle, which requires that individuals have a right to pursue legally enforceable rights against data collectors and processors who fail to adhere to the law. This principle requires not only that individuals have enforceable rights against data users, but also that individuals have recourse to courts or a government agency to investigate and/or prosecute non-compliance by data processors.</p>
                                                                <hr />
                                                                
                                                                <h4>CAN SPAM Act</h4>
								<p>The CAN-SPAM Act is a law that sets the rules for commercial email, establishes requirements for commercial messages, gives recipients the right to have emails stopped from being sent to them, and spells out tough penalties for violations.</p>
                                                                <hr />
                                                                
                                                                <h4>We collect your email address in order to:
                                                                    <br>To be in accordance with CANSPAM we agree to the following:
                                                                    <br>If at any time you would like to unsubscribe from receiving future emails, you can email us at</h4>
								<p>and we will promptly remove you from ALL correspondence.
                                                                    <br>If there are any questions regarding this privacy policy you may contact us using the information below.</p>
                                                                <hr />
                                                                
                                                                
								<p>Last Edited on 2015-10-02</p>
                                                                <hr />

							</div>
						</section>
					</article>

				<!-- Footer -->
					<footer id="footer">
						<ul class="icons">
							<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
							<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
							<li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
						</ul>
						<ul class="copyright">
							<li>&copy; Untitled</li>
						</ul>
					</footer>

			</div>

		<!-- Scripts -->
                    <?php echo getHTMLScriptsPart(); ?>
	</body>
</html>