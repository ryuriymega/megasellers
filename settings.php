<?php
$lock_page = true;
include_once('rfclass/check_login.php');
include_once "lib_THEsite.php";

$isNewsSend="";
$isOutbidSend="";
$isWinSend="";
$isLoseSend="";
$is15MinWatchEndSend="";
$isPayConfirmSend="";
$isMsgOrdersSend="";

if($jakuser->getVar("isNewsSend")=="1"){
	$isNewsSend="checked";
}
if($jakuser->getVar("isOutbidSend")=="1"){
	$isOutbidSend="checked";
}
if($jakuser->getVar("isWinSend")=="1"){
	$isWinSend="checked";
}
if($jakuser->getVar("isLoseSend")=="1"){
	$isLoseSend="checked";
}
if($jakuser->getVar("is15MinWatchEndSend")=="1"){
	$is15MinWatchEndSend="checked";
}
if($jakuser->getVar("isPayConfirmSend")=="1"){
	$isPayConfirmSend="checked";
}
if($jakuser->getVar("isMsgOrdersSend")=="1"){
	$isMsgOrdersSend="checked";
}

?>	
		
		<!-- window for personal info change notify -->
		<div class="personal_info" style="display:none">
			<div id="personal_info">
				<div align='center' style="padding:20px;margin:30px;">You changed personal information</div>
				<div style="padding:10px;margin-left:20px;margin-top:100px;font-size:30px;">Press Esc to close</div>
			 </div>
		</div>
		
		<!-- window for notify settings changes notify -->
		<div class="notify_settings" style="display:none">
			<div id="notify_settings">
				<div align='center' style="padding:20px;margin:30px;">You changed notification settings</div>
				<div style="padding:10px;margin-left:20px;margin-top:100px;font-size:30px;">Press Esc to close</div>
			 </div>
		</div>
		
		<!-- window for password change notify -->
		<div class="password_info" style="display:none">
			<div id="password_info">
				<div align='center' id="changePassMessage" style="padding:20px;margin:30px;"></div>
				<div style="padding:10px;margin-left:20px;margin-top:100px;font-size:30px;">Press Esc to close</div>
			 </div>
		</div>
		
		

								<!-- Content -->
									<div>
										<header class="major">
											<h2>Settings</h2>
										</header>
																				
										<div  class="settingsCntrls">
											Language:
											<select id="langs">
											  <option value='English'>English</option>
											</select>
										</div>
										
                                                                            
										<div  class="settingsCntrls">
											<input type="checkbox" id="isNewsSend" class="settingsCntrls" style="cursor:pointer;" <?php echo $isNewsSend;?>>
											<strong onclick="isCheckBoxSel('isNewsSend');" style="cursor:pointer;">Send me news updates</strong>
										</div>
										
                                                                            <?php /*
										<div  class="settingsCntrls">
											<input type="checkbox" id="isOutbidSend" class="settingsCntrls" style="cursor:pointer;" <?php echo $isOutbidSend;?>>
											<strong onclick="isCheckBoxSel('isOutbidSend');" style="cursor:pointer;">Send me e-mail notification when I have been outbid</strong>
										</div>
										
										<div  class="settingsCntrls">
											<input type="checkbox" id="isWinSend" class="settingsCntrls" style="cursor:pointer;" <?php echo $isWinSend;?>>
											<strong onclick="isCheckBoxSel('isWinSend');" style="cursor:pointer;">Send me e-mail notification when I win an auction</strong>
										</div>
										
										<div  class="settingsCntrls">
											<input type="checkbox" id="isLoseSend" class="settingsCntrls" style="cursor:pointer;" <?php echo $isLoseSend;?>>
											<strong onclick="isCheckBoxSel('isLoseSend');" style="cursor:pointer;">Send me e-mail notification when I lose an auction</strong>
										</div>
										 
										<div  class="settingsCntrls">
											<input type="checkbox" id="is15MinWatchEndSend" class="settingsCntrls" style="cursor:pointer;" <?php echo $is15MinWatchEndSend;?>>
											<strong onclick="isCheckBoxSel('is15MinWatchEndSend');" style="cursor:pointer;">Notify me via email 15 minutes before auction from Watchlist ends</strong>
										</div>
										
										<div  class="settingsCntrls">
											<input type="checkbox" id="isPayConfirmSend" class="settingsCntrls" style="cursor:pointer;" <?php echo $isPayConfirmSend;?>>
											<strong onclick="isCheckBoxSel('isPayConfirmSend');" style="cursor:pointer;">Send payment confirmation to e-mail</strong>
										</div>
										
										<div  class="settingsCntrls">
											<input type="checkbox" id="isMsgOrdersSend" class="settingsCntrls" style="cursor:pointer;" <?php echo $isMsgOrdersSend;?>>
											<strong onclick="isCheckBoxSel('isMsgOrdersSend');" style="cursor:pointer;">Send me e-mail notification when I receive new messages regarding my orders</strong>
										</div>
										 
										<input type="button" value="Save" onclick="saveNotifySettings();" style="margin-top:10px;">
										*/?>
										
                                                                            
                                                                            
                                                                            
										<div class="settingsBigTitle">Password change</div>
										
										<div class="txtPassChng">Current Password :</div>
										<input type="password" id="current_pass" width="150px" class="inputText">
										
										
										<div class="txtPassChng">New Password :</div>
										<input type="password" id="new_pass" width="150px" class="inputText" onblur="checkNewPass();">
										<div id="NewPassError" style="font-size:10px;color:red;"></div>
										
										<div class="txtPassChng">Confirm New Password :</div>
										<input type="password" id="confirm_new_pass" width="150px" class="inputText"  onblur="checkConfirmPass();">
										<div id="ConfirmPassError" style="font-size:10px;color:red;"></div>
										
										<input type="button" value="Change Password" onclick="changePass();" style="margin-top:10px;">
										
										
										
										<div class="settingsBigTitle">Personal information</div>
										
										<div class="txtPassChng">First Name :</div>
										<input type="text" value="<?php echo $jakuser->getVar("first_name");?>" id="first_name" width="150px" class="inputText">
										
										<div class="txtPassChng">Last Name :</div>
										<input type="text" value="<?php echo $jakuser->getVar("last_name");?>" id="last_name" width="150px" class="inputText">
										
										<input type="button" value="Save" style="margin-top:10px;" onclick="savePersonalInfo();">
										
									</div>
                
                
                
<script>
			function isCheckBoxSel(idElem){
				
				if(document.getElementById(idElem).checked==true){
					document.getElementById(idElem).checked = false;
				}else{
					document.getElementById(idElem).checked = true;
				}
			}
			
			function checkNewPass(){
				if(document.getElementById("new_pass").value.length<8){
					document.getElementById("NewPassError").innerHTML="New password should be more than 8 characters";
				}else{
					document.getElementById("NewPassError").innerHTML="";
				}
			}
			
			function checkConfirmPass(){
				if(document.getElementById("confirm_new_pass").value==document.getElementById("new_pass").value){
					document.getElementById("ConfirmPassError").innerHTML="";
				}else{
					document.getElementById("ConfirmPassError").innerHTML="Password and Confirmation should match";
				}
			}
			
			function changePass(){
				if(document.getElementById("new_pass").value.length<8){
					document.getElementById("NewPassError").innerHTML="New password should be more than 8 characters";
				}else if(document.getElementById("confirm_new_pass").value!==document.getElementById("new_pass").value){
					document.getElementById("ConfirmPassError").innerHTML="Password and Confirmation should match";
				}else{
					if (window.XMLHttpRequest)
						  {// code for IE7+, Firefox, Chrome, Opera, Safari
							xmlhttp=new XMLHttpRequest();
						  }
						else
						  {// code for IE6, IE5
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						  }
						 xmlhttp.onreadystatechange=function(){
							if(xmlhttp.readyState==4 && xmlhttp.status==200){
								  
								  var responseStr=xmlhttp.responseText;
								  //
								  ///HERE WE GET AN ANSWER FROM a Script
								  //
								  document.getElementById('changePassMessage').innerHTML=responseStr;
								  showNotifyWnd(3);
								  
							}
						 }

						///execute script for send message
						xmlhttp.open("POST","changeUserPass.php",true);
						xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
						xmlhttp.send(
								"current_pass="+document.getElementById("current_pass").value+
								"&new_pass="+document.getElementById("new_pass").value
							);
				}
			}
			
			function showNotifyWnd(indx){
				//indx
				//1 = personal info changed
				//2 = notify settings
				//3 = password info
				var contentTxt="";
				if(indx==1){
					contentLnk=".personal_info";
				}
				if(indx==2){
					contentLnk=".notify_settings";
				}
				if(indx==3){
					contentLnk=".password_info";
				}
				$.iLightBox(
						[{URL: contentLnk, type: 'inline',options: { height: 300, width: 600 }}]
					  ,			  
					  {
						skin: 'light'
					  }
					);
			}
			
			function savePersonalInfo(){
				if(
					(document.getElementById("first_name").value=="")
						||
					(document.getElementById("last_name").value=="")
				){
					window.alert("please enter a data for save");
				}else{/////////////////HERE SEND NEW USER PERSONAL INFO
						if (window.XMLHttpRequest)
						  {// code for IE7+, Firefox, Chrome, Opera, Safari
							xmlhttp=new XMLHttpRequest();
						  }
						else
						  {// code for IE6, IE5
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						  }
						 xmlhttp.onreadystatechange=function(){
							if(xmlhttp.readyState==4 && xmlhttp.status==200){
								  
								  var responseStr=xmlhttp.responseText;
								  //
								  ///HERE WE GET AN ANSWER FROM changeUserInfo Script
								  //
								  if(responseStr.search("info changed")!=-1){									  
									  showNotifyWnd(1);
								  }else{
									  window.alert(responseStr);
								  }
								  
							}
						 }

						///execute script for send message
						xmlhttp.open("POST","changeUserInfo.php",true);
						xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
						xmlhttp.send("first_name="+document.getElementById("first_name").value+"&last_name="+document.getElementById("last_name").value);
				}
			}
			
			
			function saveNotifySettings(){				
						if (window.XMLHttpRequest)
						  {// code for IE7+, Firefox, Chrome, Opera, Safari
							xmlhttp=new XMLHttpRequest();
						  }
						else
						  {// code for IE6, IE5
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						  }
						 xmlhttp.onreadystatechange=function(){
							if(xmlhttp.readyState==4 && xmlhttp.status==200){
								  
								  var responseStr=xmlhttp.responseText;
								  //
								  ///HERE WE GET AN ANSWER FROM a Script
								  //
								  if(responseStr.search("info changed")!=-1){									  
									  showNotifyWnd(2);
								  }else{
									  window.alert(responseStr);
								  }
								  
							}
						 }

						///execute script for send message
						xmlhttp.open("POST","changeUserNotifySettings.php",true);
						xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
						xmlhttp.send(
								"isNewsSend="+document.getElementById("isNewsSend").checked+
								"&isOutbidSend="+document.getElementById("isOutbidSend").checked+
								"&isWinSend="+document.getElementById("isWinSend").checked+
								"&isLoseSend="+document.getElementById("isLoseSend").checked+
								"&is15MinWatchEndSend="+document.getElementById("is15MinWatchEndSend").checked+
								"&isPayConfirmSend="+document.getElementById("isPayConfirmSend").checked+
								"&isMsgOrdersSend="+document.getElementById("isMsgOrdersSend").checked
							);
			}
</script>