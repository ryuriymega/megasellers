<?php
function getItems($countOfItems, $CountOfItemsOnPage,$jakuser){

}


function getHTMLHeader($pageID="",$jakuser){
	$classSelectedForIndex='';
	$classSelectedForAboutUs='';

	if($pageID=="index"){
		$classSelectedForIndex='class="current_page_item"';
	}
	if($pageID=="My Profile"){
		$classSelectedForMyProfile='class="current_page_item"';
	}

	if($pageID=="AboutUs"){
		$classSelectedForAboutUs='class="current_page_item"';
	}


	$header=$header.'<script>'.
			//for setup coockie
			'function setupCoockie(paramName,value){
				//variables for coockies
				var d = new Date(),
					exdays=30;//how mnay days for coockie
					d.setTime(d.getTime() + (exdays*24*60*60*1000));
					var expires = "expires="+d.toUTCString();

				//setup coockie for viewType
					document.cookie = paramName + "=" + value + "; " + expires;
			} '.
			//window for log in
			'function logInWnd(goToSite,loginUrl){'.
				'$.iLightBox(
					[{url: loginUrl, type: \'iframe\',
					options: { height: 750, width: 500 }}]
				  ,
				  {
					skin: \'light\',
				  }
				);'.
			'} '.
			//window for signUp
			'function signUpWnd(){'.
				'$.iLightBox(
					[{url: "loginForm.php?page=register", type: \'iframe\',
					options: { height: 750, width: 500 }}]
				  ,
				  {
					skin: \'light\',
				  }
				);'.
			'}'.
			'</script>';

	if(preg_match("{^(?:\s+)?$}siu",$jakuser->getVar("id"))){
	$header=$header.'<header id="header">
									<div class="inner">

										<!-- Logo -->
											<h1><a href="index.php" id="logo">Your WholeSale</a></h1>

										<!-- Nav -->
											<nav id="nav">
												<ul>
													<li '.$classSelectedForIndex.'><a href="index.php">Home</a></li>
													<li '.$classReservedForLaterChanges.'>
														<a href="#">Dropdown</a>
														<ul>
															<li><a href="#">Lorem ipsum dolor</a></li>
															<li><a href="#">Magna phasellus</a></li>
															<li>
																<a href="#">Phasellus consequat</a>
																<ul>
																	<li><a href="#">Lorem ipsum dolor</a></li>
																	<li><a href="#">Phasellus consequat</a></li>
																	<li><a href="#">Magna phasellus</a></li>
																	<li><a href="#">Etiam dolore nisl</a></li>
																</ul>
															</li>
															<li><a href="#">Veroeros feugiat</a></li>
														</ul>
													</li>
													<li '.$classSelectedForAboutUs.'><a href="AboutUs.php">Who We Are?</a></li>
													<li '.$classReservedForLaterChanges.'><a href="right-sidebar.html">Right Sidebar</a></li>
													<li>'.
														//LOGIN
														'<a onClick="logInWnd(\'no\',\'loginForm.php?page=login\');" style="cursor:pointer;">Log In</a>'.
														//SIGN UP
														'<a onClick="signUpWnd();"" style="cursor:pointer;">SIGN UP</a>'.
													'</li>
												</ul>
											</nav>

									</div>
								</header>';
	}else{
		
		$userFirstName=$jakuser->getVar('first_name');
		
		///cut first name if it more than 10 characters	
		//$charset = 'SJIS';//only for JAPAN	
		$charset = 'UTF-8';	
		$length = 10;
		if(mb_strlen($userFirstName, $charset) > $length) {
		  $userFirstName = mb_substr($userFirstName, 0, $length, $charset);
		}
		
		$userFirstName = $userFirstName."...";
		
		$header=$header.'<header id="header">
									<div class="inner">

										<!-- Logo -->
											<h1><a href="index.php" id="logo">Welcome, '.$userFirstName.'</a></h1>

										<!-- Nav -->
											<nav id="nav">
												<ul>
													<li '.$classSelectedForIndex.'><a href="index.php">Home</a></li>
													<li '.$classReservedForLaterChanges.'>
														<a href="#">Dropdown</a>
														<ul>
															<li><a href="#">Lorem ipsum dolor</a></li>
															<li><a href="#">Magna phasellus</a></li>
															<li>
																<a href="#">Phasellus consequat</a>
																<ul>
																	<li><a href="#">Lorem ipsum dolor</a></li>
																	<li><a href="#">Phasellus consequat</a></li>
																	<li><a href="#">Magna phasellus</a></li>
																	<li><a href="#">Etiam dolore nisl</a></li>
																</ul>
															</li>
															<li><a href="#">Veroeros feugiat</a></li>
														</ul>
													</li>
													<li '.$classSelectedForAboutUs.'><a href="AboutUs.php">Who We Are?</a></li>
													<li '.$classReservedForLaterChanges.'><a href="right-sidebar.html">Right Sidebar</a></li>'.
													//MY PROFILE
													'<li '.$classSelectedForMyProfile.'>'.
														'<a href="MyProfile.php" style="cursor:pointer;">My Profile</a>'.
														'<ul>
															<li><a href="MyProfile.php#Orders">Orders</a></li>
															<li><a href="MyProfile.php#Messages">Messages</a></li>
															<li><a href="MyProfile.php#Settings">Settings</a></li>
															<li><a href="MyProfile.php#Favorites">Favorites</a></li>
															<li>
																<a href="#">Phasellus consequat</a>
																<ul>
																	<li><a href="#">Lorem ipsum dolor</a></li>
																	<li><a href="#">Phasellus consequat</a></li>
																	<li><a href="#">Magna phasellus</a></li>
																	<li><a href="#">Etiam dolore nisl</a></li>
																</ul>
															</li>
															<li><a href="#">Veroeros feugiat</a></li>
														</ul>'.
													'</li>'.
													//LOGOUT
													'<li>'.
														'<a href="loginForm.php?page=logout" style="cursor:pointer;">Log Out</a>'.
													'</li>'.	
												'</ul>
											</nav>

									</div>
								</header>';
	}

	return $header;
}

function getHTMLFooter(){
	$footer=
                '<footer id="footer">'.
                        '<img class="scrollBackToTop" src="images/arrow.png">'.
                        '<ul class="icons">'.
                                '<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>'.
                                '<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>'.
                                '<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>'.
                                '<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>'.
                                '<li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>'.
                        '</ul>'.
                        '<ul class="copyright">'.
                                '<li>&copy; Untitled</li>'.
                        '</ul>'.
                '</footer>';			
return $footer;
}

function getHTMLScriptsPart(){
	return
		'<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>'.
                '<script type="text/javascript" src="/src/js/jquery.requestAnimationFrame.js"></script>'.
		'<script type="text/javascript" src="/src/js/jquery.mousewheel.js"></script>'.
		'<script type="text/javascript" src="/src/js/ilightbox.packed.js"></script>'.
		
		//all custom scripts here
		'<script>'.
		//window for favorites, share with check by index for which purposes you need
		' function showModalWnd(indx,sku,Title){
                            //indx
                            //0 = login form
                            //1 = shareFormadd auction item
                            //2 = add product item
                            //3 = get quotations
                            heightWnd=300;
                            widthWnd=600;
                            var contentTxt="";
                            if(indx==0){
                                    typeWnd=\'iframe\';
                                    contentLnk="loginForm.php?page=login";
                                    heightWnd=750;
                                    widthWnd=500;
                                    $.iLightBox(
                                            [{URL: contentLnk, type: typeWnd,options: { height: heightWnd, width: widthWnd }}]
                                      ,			  
                                      {
                                            skin: \'light\'
                                      }
                                    );
                            }
                            if(indx==1){
                                    typeWnd=\'iframe\';
                                    contentLnk="shareForm.php?sku="+sku;
                                    $.iLightBox(
                                            [{URL: contentLnk, type: typeWnd,options: { height: heightWnd, width: widthWnd }}]
                                      ,			  
                                      {
                                            skin: \'light\'
                                      }
                                    );
                            }
                            if(indx==2){
                                    addItemFavorites("'.FULL_SITE_DOMAIN.'/itemDetails.php?title="+Title+"sku="+sku);
                            }
                            if(indx==3){
                                    $.iLightBox(
                                            [{url: "Quotation.php?sku="+sku, type: \'iframe\',
                                            options: { height: 800, width: 1200 }}]
                                      ,
                                      {
                                            skin: \'light\',
                                      }
                                    );
                            }
			} '.
		'function isNormalInteger(str){
			str=str.replace(",",".");
			var floatN = parseFloat(str);
			isNumber= !isNaN(floatN) && isFinite(str) && floatN > 0
				  && floatN % 1 == 0;
			return isNumber;
		} '.
                '//scroll to top
			jQuery(document).ready(function() {
				var offset = 220;
				var duration = 500;
				jQuery(window).scroll(function() {
					if (jQuery(this).scrollTop() > offset) {
						jQuery(\'.scrollBackToTop\').fadeIn(duration);						
					} else {
						jQuery(\'.scrollBackToTop\').fadeOut(duration);
					}
				});
				
				jQuery(\'.scrollBackToTop\').click(function(event) {
					event.preventDefault();
					jQuery(\'html, body\').animate({scrollTop: 0}, duration);
					return false;
				})
			});'.
		'</script>'
	;
}

function getHTMLHead(){
		return 
		'<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />'.
                '<link rel="stylesheet" type="text/css" href="/src/css/ilightbox.css"/>'.
		'<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->';
}

function getCurrencies($currency){
	require_once 'class.db.php';
	$mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
	$mysqlidb->set_charset("utf8");
	
	//by default for currencies
	if($currency=="USD_JPY"){
		$amount="150";
	}
	if($currency=="EUR_JPY"){
		$amount="170";
	}
	if($currency=="GBP_JPY"){
		$amount="200";
	}
	
	$query='SELECT * FROM generalSettings WHERE name="'.$mysqlidb->real_escape_string($currency).'"';
	$result=$mysqlidb->query($query);
	if(mysqli_num_rows($result)>0){
		while($row = $result->fetch_array()){
			//check if it's number
			if(preg_match("{^[0-9]+\.[0-9]+$}siu",$row['value'])){
				$amount=$row['value'];
			}
		}
	}
		
	return $amount;
}

function getPayPalFee(){
	require_once 'class.db.php';
	$mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
	$mysqlidb->set_charset("utf8");
	
	//by default = 3.2%
	$payPalFee="3.2";
	
	$query='SELECT * FROM generalSettings WHERE name="PayPal Fee"';
	$result=$mysqlidb->query($query);
	if(mysqli_num_rows($result)>0){
		while($row = $result->fetch_array()){
			//check if it's number
			if(preg_match("{^[0-9]+\.[0-9]+$}siu",$row['value'])){
				$payPalFee=$row['value'];
			}
		}
	}
		
	return $payPalFee;
}
//////////////////////////////////////////////////////////////////////
//Must be in YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
//////////////////////////////////////////////////////////////////////
function dateDifference($date_2 , $differenceFormat = '%hh %im' )
{
    $datetime1 = date_create();
    $datetime2 = date_create($date_2);
    
    $interval = date_diff($datetime1, $datetime2);
    
    return $interval->format($differenceFormat);
    
}

function randomPassword() {
    $alphabet = "abcdefghijklmn~!@#$?%^&*()_+[]=pqrstuwxyzABCD4XYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 12; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////social auth////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
function checkIfUserInDB($fbID,$first_name,$last_name,$email,$pass,$mysqlidb,$jakuserlogin){
                $result=$mysqlidb->query('SELECT * FROM user WHERE email="'.$mysqlidb->real_escape_string($email).'"');
                if($result->num_rows>0){
                        //first get data for login
                        while($row = $result->fetch_array()){
                                $username = $row['username'];
                                $userpass = $row['password'];
                        }
		
		//user already created
		//make user logged in
		// Check if user is logged in
			$jakuserlogin = new JAK_userlogin();
			$jakuserrow = $jakuserlogin->jakCheckLogged();
			$jakuser = new JAK_user($jakuserrow);
			if ($jakuser) {
				$_SESSION['rfUserid'] = $jakuser->getVar("id");
				$valid_agent = filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRING);
				$valid_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
				
				// Write the log file each time someone tries to login before
				$jakuserlogin->jakWriteloginlog($username, $_SERVER['REQUEST_URI'], $valid_ip, $valid_agent, 0);
						 
				
				
				
				$user_check = $jakuserlogin->jakCheckuserdataMYFUNCCHECKcryptData($username, $userpass);
			echo $userpass;	
				if ($user_check == true) {
			
					// Now login in the user
					$jakuserlogin->jakLoginMYFUNCCHECKcryptData($user_check, $userpass, $_POST['lcookies']);
				
					// Write the log file each time someone login after to show success
					$jakuserlogin->jakWriteloginlog($username, '', $valid_ip, '', 1);
					
				}
			}
			
	}else{
		//if need to make new user
		//create new user and //make it logged in
		//die("create new user and //make it logged in");
		// First the query
		
		//?? if 1 then === registered and have access to the site
		$uaccess = 1;
		$getuniquecode = time();
		//??
			
			$sessionPID=htmlspecialchars($_COOKIE["PHPSESSID"]);
			
	   		$result = $mysqlidb->query('INSERT INTO '.DB_PREFIX.'user SET 
	   		username = "'.smartsql($fbID).'",
	   		first_name = "'.smartsql($first_name).'",
	   		last_name = "'.smartsql($last_name).'",
	   		session = "'.smartsql($sessionPID).'",
	   		email = "'.smartsql($email).'",
	   		password = "'.hash_hmac('sha256', $pass, DB_PASS_SALT).'",
	   		access = '.$uaccess.',
	   		activatenr = "'.$getuniquecode.'",
	   		time = NOW()');
                        
                        checkAndCreateRequiredTables($mysqlidb->insert_id);
                        
	   		$username = smartsql($fbID);
			$userpass = smartsql($pass);
	   		
	   		
	   		// Check if user is logged in
			$jakuserlogin = new JAK_userlogin();
			$jakuserrow = $jakuserlogin->jakCheckLogged();
			$jakuser = new JAK_user($jakuserrow);
			if ($jakuser) {
				$_SESSION['rfUserid'] = $jakuser->getVar("id");
                                
				//makeLogin($jakuserlogin,$fbID,$pass);
				// Security for user agend and remote addr
				$valid_agent = filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRING);
				$valid_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
				
				// Write the log file each time someone tries to login before
				$jakuserlogin->jakWriteloginlog($username, $_SERVER['REQUEST_URI'], $valid_ip, $valid_agent, 0);
						 
				$user_check = $jakuserlogin->jakCheckuserdata($username, $userpass);
				if ($user_check == true) {
			
					// Now login in the user
					$jakuserlogin->jakLogin($user_check, $userpass, "1");
					
					// Write the log file each time someone login after to show success
					$jakuserlogin->jakWriteloginlog($username, '', $valid_ip, '', 1);
				}
			}
	}
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	////REDIRECT///////////////
	jak_redirect(FULL_SITE_DOMAIN.'/dashboard.php');
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
}

function getUsersMessages($userID){
	
	require_once 'class.db.php';
	$mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
	$mysqlidb->set_charset("utf8");
	
	$query='SELECT messages.*, user.first_name, user.username FROM messages '.
	'LEFT JOIN user ON user.id=messages.user_id '.
	'WHERE messages.user_id='.$mysqlidb->real_escape_string($userID).
	' ORDER BY messages.time DESC';

	$content="";
	$result=$mysqlidb->query($query);
	if(mysqli_num_rows($result)>0){
		while($row = $result->fetch_array()){
			$user_id=$row['user_id'];
			$time=$row['time'];
			$message=$row['message'];
			$id=$row['id'];
			$first_name=$row['first_name'];
			$username=$row['username'];
			
			
			//////////////////////////////////////////
			////first get if there are answers for this question
			//////////////////////////////////////////
				$query1='SELECT * FROM answersMessages '.
				'WHERE message_id='.$mysqlidb->real_escape_string($id).
				' ORDER BY time DESC';
				$result1=$mysqlidb->query($query1);
				if(mysqli_num_rows($result1)>0){
					while($row1 = $result1->fetch_array()){
						//
						$answer=$row1['message'];
						$timeAnswer=$row['time'];
						$content=$content.
							'<div style="margin-top:120px;">'.
								 '<strong style="margin-right:25px;padding:10px;font-size:26px;font-weight:900;background-color:#111111;color:white;">SUPPORT TEAM</strong>'.
								 '<div style="margin-top:25px;margin-left:45px;color:#948f8f;">'.$timeAnswer.'</div>'.
								 '<div style="margin-left:45px;padding-top:8.5px; font-size:15px;">'.$answer.'</div>'.
								 '</div>';
					}
				}
			//////////////////////////////////////////
			
			
			//show all messages
				if($first_name==""){
					$name=$username;
				}else{
					$name=$first_name;
				}

				$content=$content.
					'<div style="margin-top:120px;">'.
						 '<strong style="margin-right:25px;padding:10px;font-size:26px;font-weight:900;background-color:#31803a;color:white;">'.$name.'</strong>'.
						 '<div style="margin-top:25px;margin-left:45px;color:#948f8f;">'.$time.'</div>'.
						 '<div style="margin-left:45px;padding-top:8.5px; font-size:15px;">'.$message.'</div>'.
						 '</div>';
			//
		}
	}else{
		$content="!!!Error, User not found!!!";
		$content="";
	}
	
	return $content;
}

function getUsersFavoritesLists($userID){
	
	require_once 'class.db.php';
	require_once 'config.php';
	$mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
	$mysqlidb->set_charset("utf8");
	
	$query='SELECT * FROM FavoritesItems '.
	'WHERE user_id='.$mysqlidb->real_escape_string($userID);

	$content="";
	$result=$mysqlidb->query($query);
	if(mysqli_num_rows($result)>0){
		while($row = $result->fetch_array()){
			
			$mysqlidb1 = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, "AutoSales", DB_PORT);
			$mysqlidb1->set_charset("utf8");
			
			$sku=$row['item_id'];
			
			$query1='SELECT * FROM ITEMS '.
				'WHERE sku="'.$mysqlidb1->real_escape_string($sku).'"';
			$result1=$mysqlidb1->query($query1);
			if(mysqli_num_rows($result1)>0){
				while($row1 = $result1->fetch_array()){
					$img1=SITE_ADDRESS.$row1['img'];
					$Title=$row1['title'];
					///cut title if it more than 200 characters					
					$charset = 'UTF-8';
					
					$length = 500;
					if(mb_strlen($Title, $charset) > $length) {
					  $Title = mb_substr($Title, 0, $length, $charset);
					}
					
					$Title = $Title."...";
					
					$arr = explode( " " , $Title );
					$arr = array_unique( $arr );
					$Title = implode(" " , $arr);
					$Price=$row1['cheapest_price'];
					
					
						/////ALL options for select which exactly item to buy
						$optionsData="";
						$Alloptions=$row1['Alloptions'];
						if(
							($Alloptions!="")
							AND($Alloptions!="|-0-|")
							){
							$countOfOptions=0;
							$optionsData="<select id='optionForSelect".$sku."' style='margin-left:10px;margin-top:30px;border: 1px solid #000;font-size: 16px;color: #fff;background: #444;padding: 5px;'>";
							if(preg_match_all("{[0-9]+{\"id\"=\"(.*?)\",[0-9]+\"name\"=\"(.*?)\"}next[0-9]+}siu",$Alloptions,$arrayOptions,PREG_SET_ORDER)){
								foreach($arrayOptions as $option){
									$countOfOptions++;
									//if name of option too long
									//for example like this -> Size___Color_Option 
										$nameOption=$option[1];
										///cut if it too long
										//$charset = 'SJIS';//only for JAPAN
										$charset = 'UTF-8';							
										$length = 13;
										if(mb_strlen($nameOption, $charset) > $length) {
										  $nameOption = mb_substr($nameOption, 0, $length, $charset);
										  $nameOption = $nameOption."...";
										}
										
										$valueOption=$option[2];
										///cut if it too long
										//$charset = 'SJIS';//only for JAPAN
										$charset = 'UTF-8';							
										$length = 13;
										if(mb_strlen($valueOption, $charset) > $length) {
										  $valueOption = mb_substr($valueOption, 0, $length, $charset);
										  $valueOption = $valueOption."...";
										}
										
									//
											$optionsData=$optionsData.
											'<option value="'.$valueOption.'">'.$nameOption.' : '.$valueOption.'</option>';
								}
								$optionsData=$optionsData."</select>";
							}else{
								//die("error preg_all for Alloptions");
							}
						}else{
							$optionsData="<input type='hidden' value='' id='optionForSelect".$sku."'>";
						}
						
				}
			}
			
			//build content for show all watchlist items 
				$content=$content.
						'<span id="'.$sku.'">'.
						 '<div class="itemFavoriteItemsList">'.
							 '<a href="../ItemDetails.php?title='.$Title.'&sku='.$sku.'" style="color: purple;text-decoration: none" target="_blank">'.
								'<div class="favoritesItemImage" style="width: 140px; height: 120px; background: url(\''.$img1.'\') center center; background-size: cover;"></div>'.
							'</a>'.
							 '<div class="txtFavoriteList">'.
								 '<div>Item ID : <a href="../ItemDetails.php?title='.$Title.'&sku='.$sku.'" style="color: purple;text-decoration: none" target="_blank">'.$sku.'</a></div>'.
								 '<div>Seller : <a style="color: purple; text-decoration: none" target="_blank">Electronics Accessories Wholesale</a></div>'.
								 '<div onclick="window.open(\'../ItemDetails.php?title='.$Title.'&sku='.$sku.'\');" style="cursor:pointer;font-size:21px;font-weight:400;margin-top:30px">'.$Title.'</div>'.
							 '</div>'.
							 $optionsData.
							 '<div class="priceFavoriteList">$'.round($Price,0).'</div>'.
								'<div style="width:100px;">'.
									'<div style="width:100px;">'.
										'Quantity : '.
										'<input '.
											'id="qtyEdit'.$sku.'" style="font-size: 12px;padding:5px;margin-top:10px;margin-right:5px;margin-bottom:5px;width:30px;"'.
										' type="text" value="1" >'.
									'</div>'.
									//button add to cart
									'<input '.
									'style="font-size: 12px;padding:5px;margin-bottom:5px;"'.
									' type="button" value="Add To Cart" '.
									'onclick="addToCart(\''.$sku.'\',document.getElementById(\'qtyEdit'.$sku.'\').value,document.getElementById(\'optionForSelect'.$sku.'\').value);">'.
									//button delete from favorites
									'<input '.
									'style="font-size: 12px;padding:5px;"'.
									' type="button" value="Delete from Favorites" '.
									'onclick="deleteFromFavorites(\''.$sku.'\');">'.
								'</div>'.
						 '</div>'.
						 '</span>';
			//
		}
	}else{
		$content="!!!Error, watchlist item not found!!!";
		$content="";
	}
	
	return $content;
}

function getUsersCart($userID){

}

function getCategories($jakuser=""){
	require_once 'class.db.php';
	require_once 'config.php';
	$mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
	$mysqlidb->set_charset("utf8");
	
	/*$query='SELECT DISTINCT (material_type)
		FROM  `ITEMS` 
		WHERE '.
		'sku LIKE  "CNVa\_%" OR '.
		'sku LIKE  "CB\_%" OR '.
		'sku LIKE  "usbnggdiph4cs\_%" OR '.
		'sku LIKE  "usbnggdiph6cs\_%" OR '.
		'sku LIKE  "usbnggdipdcs\_%" OR '.
		'sku LIKE  "usbnggdiph5cs\_%" ';*/
	
	if($jakuser==""){
		$query='SELECT * FROM  `generalFilterPresets`';
	}elseif(!preg_match("{^(?:\s+)?$}siu",$jakuser->getVar("id"))){
		$query='SELECT * FROM  `usersFilterPresets` WHERE userID='.$jakuser->getVar("id");
	}
		
	$categories=$categories."[";
	
	$i=0;
	
	$result=$mysqlidb->query($query);
		if(mysqli_num_rows($result)>0){
			while($row = $result->fetch_array()){
				if($i==0){
					$categories=$categories."'".str_replace("'","\'",$row['name'])."'";
					$i++;
				}else{
					$categories=$categories.","."'".str_replace("'","\'",$row['name'])."'";
					$i++;
				}
			}
		}
	$categories=$categories."]";
	return $categories;
}

function createNewOrder($userID,$ZipCode,$State,
					$Country,$City,$Address,$LastName,
					$FirstName,$addressID,$Phone,$buyerNotes){
	require_once 'class.db.php';
	require_once 'config.php';
	$mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
	$mysqlidb->set_charset("utf8");
	
	
	//////////////////////////////////////////////////////
	/////if new address then add new address into a DB
		  if($addressID=="new"){
			////////////////////
			////check if the same address exists
			$query="SELECT * FROM usersAddresses WHERE ".
			"userID=\"".$mysqlidb->real_escape_string($userID)."\" AND ".
			"firstName=\"".$mysqlidb->real_escape_string($FirstName)."\" AND ".
			"lastName=\"".$mysqlidb->real_escape_string($LastName)."\" AND ".
			"countryName=\"".$mysqlidb->real_escape_string($Country)."\" AND ".
			"city=\"".$mysqlidb->real_escape_string($City)."\" AND ".
			"streetAddress=\"".$mysqlidb->real_escape_string($Address)."\" AND ".
			"state=\"".$mysqlidb->real_escape_string($State)."\" AND ".
			"zipcode=\"".$mysqlidb->real_escape_string($ZipCode)."\" AND ".
			"phone=\"".$mysqlidb->real_escape_string($Phone)."\"";
			$result=$mysqlidb->query($query);
			if($result->num_rows>0){
				while($row = $result->fetch_array()){
					$addressID=$row['id'];
					$returnAnswer=$returnAnswer."<br><font color=\"PURPLE\">the same address already created addressID = ".$addressID."!</font><br>";
				}
			}else{//else create new address 
				////  
				$query="INSERT INTO `usersAddresses`(`userID`, `firstName`, 
						`lastName`, `countryName`, `city`, `streetAddress`, `state`,
						`zipcode`, `phone`) ".
						"VALUES (".
						"\"".$mysqlidb->real_escape_string($userID)."\",".
						"\"".$mysqlidb->real_escape_string($FirstName)."\",".
						"\"".$mysqlidb->real_escape_string($LastName)."\",".
						"\"".$mysqlidb->real_escape_string($Country)."\",".
						"\"".$mysqlidb->real_escape_string($City)."\",".
						"\"".$mysqlidb->real_escape_string($Address)."\",".
						"\"".$mysqlidb->real_escape_string($State)."\",".
						"\"".$mysqlidb->real_escape_string($ZipCode)."\",".
						"\"".$mysqlidb->real_escape_string($Phone)."\"".
						")";
				$mysqlidb->query($query);
				$addressID=$mysqlidb->lastId();
				$returnAnswer=$returnAnswer."<br><font color=\"PURPLE\">addressID = ".$addressID." New Address saved!</font><br>";
			}
		}
	//////////////////////////////////////////////////////
	//////////////////////////////////////////////////////
	
		
	$query='SELECT * FROM Cart '.
	'WHERE userID='.$mysqlidb->real_escape_string($userID);
	
	$totalWeight=0.0;
	$totalItemsPrice=0.0;
	$totalShippingPrice=0.0;
	$All_CB_items=0;//for calc. discounts for cb items shipping
	$All_usbnggd_items=0;//for calc. discounts for usbnggdiph5cs items shipping
	
	$All_CNVa_items=0;//for calc. discounts for cnva items shipping
	$result=$mysqlidb->query($query);
	$FullAmount=-1;
	if(mysqli_num_rows($result)>0){
		
			/////////////
			//Create a package
			$mysqlidb->query('INSERT INTO `Packages`(`totalItemsPrice`, `totalShippingPrice`, `usersAddress`, `userID`, `totalWeight`, buyerNotes) '.
			'VALUES ('.
			$totalItemsPrice.','.
			$totalShippingPrice.','.
			$addressID.','.
			$userID.','.
			$totalWeight.','.
			'"'.$mysqlidb->real_escape_string($buyerNotes).'"'.
			')');
			$packageID=$mysqlidb->lastId();			
			/////////////
		
		while($row = $result->fetch_array()){
			
			$mysqlidb1 = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, "AutoSales", DB_PORT);
			$mysqlidb1->set_charset("utf8");
			
			$sku=$row['sku'];
			$qty=$row['qty'];
			$selectedOption=$row['selectedOption'];
			
			$query1='SELECT * FROM ITEMS '.
				'WHERE sku="'.$mysqlidb1->real_escape_string($sku).'"';
			$result1=$mysqlidb1->query($query1);
			if(mysqli_num_rows($result1)>0){
				while($row1 = $result1->fetch_array()){
					$img1=$row1['img'];
					$Title=$row1['title'];
					///cut title if it more than 200 characters					
					$charset = 'UTF-8';
					
					$length = 500;
					if(mb_strlen($Title, $charset) > $length) {
					  $Title = mb_substr($Title, 0, $length, $charset);
					}
					
					$Title = $Title."...";
					
					$arr = explode( " " , $Title );
					$arr = array_unique( $arr );
					$Title = implode(" " , $arr);
					$Price=$row1['cheapest_price'];
					
					$totalItemsPrice=$totalItemsPrice+round($Price,0);
					$weight=round($row1['shipping_weight'],2);
					$totalWeight=$totalWeight+(round($row1['shipping_weight'],2)*$qty);
					
					////////////////////////////
						//
						//--------------------------------------------------------
						//--------------------------------------------------------
						///////////////////////////////////////////////////////////////////////////
							////settings for sipping method///////////////////////////////////////
									//and price
									if($Price<100){
										if(preg_match("{^CB\_(?:.*?)$}siu",$sku)){
											
											$All_CB_items++;
											
											$shipping_method="<strong>Shipping Method : </strong> Standard Worldwide Shipping (Tracking + Insurance)";
											
											//3 shipping from chinebuye
											//+3(+1 my extra) for insurance from china
											//=7
											//+5 my extra
											//+3 for extra shipping options from Chinabuye
											//=15
											if($All_CB_items==1){
												$shipping_price=15;
											}else{
												$shipping_price=15/2;
											}
										}
										if(preg_match("{^usbnggd(?:.*?)$}siu",$sku)){
											
											$All_usbnggd_items++;
											
											$shipping_method="<strong>Shipping Method : </strong> Standard Worldwide Shipping (Tracking + Insurance)";
											
											//3 shipping from banggood
											//+3(+1 my extra) for insurance from china
											//=7
											//+5 my extra
											//+3 for extra shipping options from Chinabuye
											//=15
											if($All_usbnggd_items==1){
												$shipping_price=15;
											}else{
												$shipping_price=15/2;
											}
										}
									}
									
									if($Price>99){
										if(preg_match("{^CB\_(?:.*?)$}siu",$sku)){
											
											$All_CB_items++;
											
											$shipping_method="<strong>Shipping Method : </strong> Eexpedited Worldwide Shipping (Tracking + Insurance)";
											
											//3 shipping from chinebuye
											//+24(+3 my extra) for insurance from china
											//=27
											//+5 my extra
											//+3 for extra shipping options from Chinabuye
											//=35
											if($All_CB_items==1){
												$shipping_price=35;
											}else{
												$shipping_price=35/2;
											}
										}
										if(preg_match("{^usbnggd(?:.*?)$}siu",$sku)){
											
											$All_usbnggd_items++;
											
											$shipping_method="<strong>Shipping Method : </strong> Eexpedited Worldwide Shipping (Tracking + Insurance)";
											
											//3 shipping from banggood
											//+24(+3 my extra) for insurance from china
											//=27
											//+5 my extra
											//+3 for extra shipping options from Chinabuye
											//=35
											if($All_usbnggd_items==1){
												$shipping_price=35;
											}else{
												$shipping_price=35/2;
											}
										}
									}
									
									if(preg_match("{^CNVa\_(?:.*?)$}siu",$sku)){
										
										$All_CNVa_items++;
										
											$shipping_method="<strong>Shipping Method : </strong> [~2-5days] Expedited Worldwide Shipping (Tracking + Insurance)";
											
											//weight < 1 kg
											if($weight<1){
												$shipping_price=40;
											}
											//weight from 1 to 2 kg
											if(
												($weight>1)
												AND
												($weight<=2)
												){
												$shipping_price=70;
											}
											//weight from 2 to 3 kg
											if(
												($weight>2)
												AND
												($weight<=3)
												){
												$shipping_price=90;
											}
											//weight from 3 to 4 kg
											if(
												($weight>3)
												AND
												($weight<=4)
												){
												$shipping_price=110;
											}
											//weight from 4 to 5 kg
											if(
												($weight>4)
												AND
												($weight<=5)
												){
												$shipping_price=120;
											}
											//weight from 5 to 6 kg
											if(
												($weight>5)
												AND
												($weight<=6)
												){
												$shipping_price=150;
											}
											//weight from 6 to 7 kg
											if(
												($weight>6)
												AND
												($weight<=7)
												){
												$shipping_price=170;
											}
											//weight from 7 to 9 kg
											if(
												($weight>7)
												AND
												($weight<=9)
												){
												$shipping_price=190;
											}
											//weight from 9 to 11 kg
											if(
												($weight>9)
												AND
												($weight<=11)
												){
												$shipping_price=210;
											}
											//weight from 11 to 13 kg
											if(
												($weight>11)
												AND
												($weight<=16)
												){
												$shipping_price=290;
											}
											//weight from 16 to 20 kg
											if(
												($weight>16)
												AND
												($weight<=20)
												){
												$shipping_price=330;
											}					
											//weight from 20 to 24 kg
											if(
												($weight>20)
												AND
												($weight<=24)
												){
												$shipping_price=370;
											}
											
											//weight from 24 to 38 kg
											if(
												($weight>24)
												AND
												($weight<=38)
												){
												$shipping_price=500;
											}
											
											//weight from 38 to 70 kg
											if(
												($weight>38)
												AND
												($weight<=70)
												){
												$shipping_price=1500;
											}
											
											if($All_CNVa_items==1){
												$shipping_price=$shipping_price+5;
											}else{
												$shipping_price=($shipping_price+5)/2;
											}
										}
									/////////////////////////////////////////////////
									////////////////////////////////////////////////////			
						//--------------------------------------------------------
						//--------------------------------------------------------
						//--------------------------------------------------------

						////--------------------------------------------------------
						////////////////////////////			

						if(($qty>1)&&($weight<5)){
							$totalShippingPrice=$totalShippingPrice+(($shipping_price*$qty)/3);
						}else if((qty>1)&&(weight>5)){
							$totalShippingPrice=$totalShippingPrice+(($shipping_price*$qty)/2);
						}else if((qty>1)&&(weight>10)){
							$totalShippingPrice=$totalShippingPrice+(($shipping_price*$qty)/1.5);
						}else{
							$totalShippingPrice=$totalShippingPrice+($shipping_price*$qty);
						}
						
					///INSERT
					//ITEM
					//INTO
					//ORDERS Table
					$query='INSERT INTO `ORDERS`(packageID, sku, qty, userID, selectedOption) '.
					'VALUES ('.
					$packageID.','.
					'"'.$sku.'",'.
					$qty.','.
					$userID.','.
					'"'.$selectedOption.'"'.
					')';
					
					$mysqlidb->query($query);
					
				}//end of while for ITEMS
			}
		}//end of while for CART
		
		/////////////
		//Edit TOTALS in a package
		$query='UPDATE `Packages`'.
		' SET `totalItemsPrice`='.$totalItemsPrice.','.
		' `totalShippingPrice`='.$totalShippingPrice.','.
		' `totalWeight`='.$totalWeight.''.
		' WHERE id='.$packageID;
		$mysqlidb->query($query);
		/////////////
		
		//remove all from cart
		$mysqlidb->query('DELETE FROM Cart WHERE userID="'.$userID.'"');
		//
		$FullAmount=$totalItemsPrice+$totalShippingPrice;
	}
	return $FullAmount."||".$packageID;
}

function getExistingAddresses($userID){
	require_once 'class.db.php';
	require_once 'config.php';
	$mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
	$mysqlidb->set_charset("utf8");
	
	$result=$mysqlidb->query("SELECT * FROM usersAddresses WHERE userID=".$mysqlidb->real_escape_string($userID));
												 
	while($row = $result->fetch_array()){
		$selectOptions=$selectOptions.'<option value="'.$row['id'].'" id="'.$row['countryName'].'">'.$row['firstName'].' '.$row['lastName'].' - '.$row['streetAddress'].' - '.$row['countryName'].' - '.$row['city'].' - '.$row['zipcode'].'</option>';
    }
	
	$selectOptions=$selectOptions.'<option value="new">create new address</option>';
	
	return $selectOptions;
}

function getAllCountries(){
	require_once 'class.db.php';
	require_once 'config.php';
	$mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
	$mysqlidb->set_charset("utf8");
	
	$result=$mysqlidb->query("SELECT DISTINCT(name) FROM shipping_zones ORDER BY name");
	$index=0;
	while($row = $result->fetch_array()){
			//$allZones=$allZones.'<option value="'.$row['name'].'">';
			$allZones=$allZones.'<option value=\''.$row['name'].'\'>'.$row['name'].'</option>';
			$index++;
	}
	//$allZones=$allZones.'</datalist>';
	return $allZones;
}

function checkIfCountryExistInDB($Country){
	$isExist=false;
	
	require_once 'class.db.php';
	require_once 'config.php';
	$mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
	$mysqlidb->set_charset("utf8");
    
	//check if country exitst in our DB;
	$query="SELECT DISTINCT(name) FROM `shipping_zones` WHERE name=\"".$mysqlidb->real_escape_string($Country)."\"";
	$result=$mysqlidb->query($query);
	if($result->num_rows>0){
	   $isExist=true;
	}
   
	return $isExist;
}


function getTableEbayItemsData($userID){
    require_once 'class.db.php';
    $mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    $mysqlidb->set_charset("utf8");
        
    $returnData='{
                    "data": [';
    
    
    $indxCount=0;
    
    $query="SELECT * FROM ebay_table_tmpl_$userID";
    $result=$mysqlidb->query($query);
    if(mysqli_num_rows($result)>0){
        while($row = $result->fetch_array()){
            
            $indxCount++;
            
                 $ebayID=$row['ebayID'];
                 $sku=$row['sku'];
                 $title=$row['title'];
                 $img=$row['img'];
                 $other_img1=$row['other-img1'];
                 $other_img2=$row['other-img2'];
                 $other_img3=$row['other-img3'];
                 $other_img4=$row['other-img4'];
                 $other_img5=$row['other-img5'];
                 $other_img6=$row['other-img6'];
                 $other_img7=$row['other-img7'];
                 $other_img8=$row['other-img8'];
                 $other_img9=$row['other-img9'];
                 $other_img10=$row['other-img10'];
                 $country=$row['country'];
                 $currency=$row['currency'];
                 $postalcode=$row['postalcode'];
                 $paymentmethods=$row['paymentmethods'];
                 $PayPalEmailAddress=$row['PayPalEmailAddress'];
                 $categoryID=$row['categoryID'];
                 $quantity=$row['quantity'];
                 $price=$row['price'];
                 $ShippingType=$row['ShippingType'];
                 $ShippingService=$row['ShippingService'];
                 $ShippingServiceCost=$row['ShippingServiceCost'];
                 $ShippingServiceAdditionalCost=$row['ShippingServiceAdditionalCost'];
                 $BuyItNowPrice=$row['BuyItNowPrice'];
                 $ListingDuration=$row['ListingDuration'];
                 $ListingType=$row['ListingType'];
                 $Description=$row['Description'];
                 $status=$row['status'];
                 $statusMessage=$row['statusMessage'];
                 $Template=$row['Template'];
                 $ListingStatus=$row['ListingStatus'];
                 
            $itemData=json_encode($price).',
                        '.json_encode($currency).',
                        '.json_encode('<img src='.$img.' style="width:150px;height:150px;">').',
                        '.json_encode('<div class="button" style="background-color:#caf8f3;" onclick="linkToASINWnd(\''.$ebayID.'\');">Link_To_ASIN</div>').',
                        '.json_encode($title).',
                        '.json_encode($sku).',
                        '.json_encode($ebayID).',
                        '.json_encode($BuyItNowPrice).',
                        '.json_encode($ListingStatus).',
                        '.json_encode($ListingDuration).',
                        '.json_encode($categoryID);
                    
            if($indxCount>1){
                $returnData=$returnData.',[
                        '.$itemData.'
                    ]';
           }else{
               $returnData=$returnData.'[
                        '.$itemData.'
                    ]';
           }
        }
    }
    
    $returnData=$returnData.
            "]
       }";
    
    return $returnData;
}

function saveUser_Token_SessionID_ebayID_ToDB($eBayAuthToken,$ebayUserID,$SessionID,$userID){
    require_once 'class.db.php';
    $mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    $mysqlidb->set_charset("utf8");
    
    $query='UPDATE user SET '.
            'eBayAuthToken="'.$mysqlidb->real_escape_string($eBayAuthToken).'", '.
            'SessionID="'.$mysqlidb->real_escape_string($SessionID).'", '.
            'ebayUserID="'.$mysqlidb->real_escape_string($ebayUserID).'" '.
            'WHERE id='.$mysqlidb->real_escape_string($userID);
    $result=$mysqlidb->query($query);
}

function removeAllEbayItemsFromDB($userID){
    require_once 'class.db.php';
    $mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    $mysqlidb->set_charset("utf8");
    
    $query='DELETE FROM `ebay_table_tmpl_'.$userID.'`';
    $result=$mysqlidb->query($query);
}

function getUserTokenFromDB($userID){
    require_once 'class.db.php';
    $mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    $mysqlidb->set_charset("utf8");
    
    $query='SELECT eBayAuthToken FROM user WHERE id='.$mysqlidb->real_escape_string($userID);
    $result=$mysqlidb->query($query);
    if(mysqli_num_rows($result)>0){
            while($row = $result->fetch_array()){
                 $eBayAuthToken=$row['eBayAuthToken'];
            }
    }
    
    return $eBayAuthToken;
}

function geteBayUserIDFromDB($userID){
    require_once 'class.db.php';
    $mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    $mysqlidb->set_charset("utf8");
    
    $query='SELECT ebayUserID FROM user WHERE id='.$mysqlidb->real_escape_string($userID);
    $result=$mysqlidb->query($query);
    if(mysqli_num_rows($result)>0){
            while($row = $result->fetch_array()){
                 $ebayUserID=$row['ebayUserID'];
            }
    }    
    return $ebayUserID;
}

function checkAndCreateRequiredTables($userID){
    if($userID!=""){
        require_once 'class.db.php';
        $mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        $mysqlidb->set_charset("utf8");		
        
        //check ebay items table
        $query="show tables like \"ebay_table_tmpl_$userID\"";
        $result=$mysqlidb->query($query);
        if(mysqli_num_rows($result)==0){
                 $query=" CREATE  TABLE  `ebay_table_tmpl_$userID` (".
                   "`ebayID` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`sku` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`oldSku` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`title` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`img` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`other-img1` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                                        ."`other-img2` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                                        ."`other-img3` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                                        ."`other-img4` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                                        ."`other-img5` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                                        ."`other-img6` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                                        ."`other-img7` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                                        ."`other-img8` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                                        ."`other-img9` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                                        ."`other-img10` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`country` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`currency` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`postalcode` INT NOT NULL, "
                   ."`paymentmethods` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`PayPalEmailAddress` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`categoryID` INT NOT NULL, "
                   ."`quantity` DECIMAL(12,4) NOT NULL, "
                   ."`price` DECIMAL(12,4) NOT NULL, "
                   ."`ShippingType` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`ShippingService` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`ShippingServiceCost` DECIMAL(12,4) NOT NULL, "
                   ."`ShippingServiceAdditionalCost` DECIMAL(12,4) NOT NULL, "
                   ."`BuyItNowPrice` DECIMAL(12,4) NOT NULL, "
                   ."`ListingDuration` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`ListingType` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`Description` TEXT NOT NULL, "
                   ."`status` VARCHAR(50) NOT NULL, "
                   ."`statusMessage` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`Template` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`ListingStatus` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  'Active', "
                   ."`Alloptions` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                   ."`noUpdate` VARCHAR( 3 ) NOT NULL DEFAULT  'no', "
                   ."`LISTEDINCOUNTRY` VARCHAR( 100 ) NOT NULL DEFAULT  'USA', "
                   ."`LISTEDINCOUNTRYID` INT NOT NULL DEFAULT  '0', "
                   ."UNIQUE (`ebayID`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci";
                 $result=$mysqlidb->query($query);
                }
                
              //check amazon to ebay link items table
                $query="show tables like \"amazon_to_ebay_$userID\"";
                        $result=$mysqlidb->query($query);
                        if(mysqli_num_rows($result)==0){
                                 $query=" CREATE  TABLE  `amazon_to_ebay_$userID` (".
                                   "`id` INT NOT NULL AUTO_INCREMENT, ".      
                                   "`ebayID` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, ".
                                   "`ASIN` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, ".
                                   "`comment` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, "
                                   ."UNIQUE (`id`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci";
                                         
                                 $result=$mysqlidb->query($query);                
                }
        }
}
?>
