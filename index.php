<?php
require_once('_assets/connect.php');
date_default_timezone_set("Asia/Bangkok");



$page=$_GET['action'];
if($page==login){
	session_start();
	$strSQL = "SELECT * FROM user WHERE Username = '".mysql_real_escape_string($_POST['Username'])."' 
	and Password = '".mysql_real_escape_string($_POST['Password'])."'";
	$objQuery = mysql_query($strSQL);
	$objResult = mysql_fetch_array($objQuery);
	if(!$objResult)
	{
		echo "<script type='text/javascript'>alert('ชื่อผู็ใช้ หรือ รหัสผ่านผิดพลาด');location.replace('index.php?page=login')</script>";
	}
	else
	{
		$_SESSION["UID"] = $objResult["UID"];



		{
			header("location:index.php");
		}
	}
	mysql_close();
}
?>
<?php 
require_once('_assets/connect.php');
$page=$_GET['action'];
if($page==register){


	if(trim($_POST["Username"]) == "")
	{
		echo "<script type='text/javascript'>alert('คุณไม่ได้ใส่ชื่อผู็ใช้');location.replace('index.php')</script>";		
		exit();	
	}
	
	if(trim($_POST["Password"]) == "")
	{
		echo "<script type='text/javascript'>alert('คุณไม่ได้ใส่รหัสผ่าน');location.replace('index.php')</script>";		
		exit();
	}	

	if($_POST["Password"] != $_POST["cPassword"])
	{
		echo "<script type='text/javascript'>alert('รหัสผ่านไม่ตรงกัน');location.replace('index.php')</script>";		
		exit();
	}
	$strSQL = "SELECT * FROM user WHERE Username = '".trim($_POST['Username'])."' ";
	$objQuery = mysql_query($strSQL);
	$objResult = mysql_fetch_array($objQuery);
	if($objResult)
	{
		echo "<script type='text/javascript'>alert('ชื่อผู็ใช้นี้ไม่สามารถสมัครสมาชิดได้กรุณาใช้ชื่อผู้ใช้อื่น');location.replace('index.php?page=register')</script>";		
	}
	else
	{	
		$us = $_POST["Username"];
		$re = $_POST["Password"];
		$sql = "INSERT INTO user (Username,Password,'date') VALUES ('$us','$re','0') ";
		mysql_query($sql);
		echo "<script type='text/javascript'>alert('สมัครสมาชิกเรียนร้อยเเล้ว');location.replace('index.php?page=login')</script>";				
		
	}

	mysql_close();
}
?>
<?php 
$page=$_GET['action'];
if($page==logout){
	session_start();
	session_destroy();;
	header("location:index.php");
}
?>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="_assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="_assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Autos-Like | ระบบไลค์อัตโนมัต</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

	<!--  Social tags      -->



	<link rel="stylesheet" href="css/normalize.css">
	<script src="js/prefixfree.min.js"></script>


</head>
<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href="_assets/css/like.css" />
<link rel="stylesheet" href="_assets/css/font-awesome.min.css" />

<!-- CSS Files -->
<link href="_assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="_assets/css/material-kit.css" rel="stylesheet"/>

<!-- CSS Just for demo purpose, don't include it in your project -->
<link href="_assets/css/demo.css" rel="stylesheet" />
<!--<script type="text/javascript" src='https://www.tmtopup.com/topup/3rdTopup.php?uid=77712'></script>-->

</head>

<nav class="navbar navbar-success">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-navbar-success">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Autos-Like | ระบบไลค์อัตโนมัต</a>
		</div>

		<div class="collapse navbar-collapse" id="example-navbar-success">
			<ul class="nav navbar-nav navbar-right">
				<?php
				$page=$_GET['page'];
				if($page!==news&&$page!==phone&&$page!==topup&&$page!==buy&&$page!==login&&$page!==register){
					?> 
					<li class="active">
						<?php 
					}
					else
					{
						?>
						<li>
							<?php
						}

						?>
						<a href="index.php">
							<i class="material-icons">home</i> หน้าเเรก
						</a>
					</li>
					<li>
						<?php
						$page=$_GET['page'];
						if($page==news){
							?> 
							<li class="active">
								<?php }?>
								<a href="?page=news">
									<i class="material-icons">announcement</i> ประกาศ
								</a>
							</li>
							<li>
								<?php
								$page=$_GET['page'];
								if($page==phone){
									?> 
									<li class="active">
										<?php }?>
										<a href="?page=phone">
											<i class="material-icons">settings_phone</i> ติดต่อเรา
										</a>
									</li><li>
									<?php
									session_start();
									if ($_SESSION["UID"] == '') {
										?>
										<button onclick="window.location.href='?page=login'" class="btn btn-raised btn-info"><i class="material-icons">supervisor_account</i> ล็อกอิน</button><button onclick="window.location.href='?page=register'" class="btn btn-raised btn-danger"><i class="material-icons">create</i> สมัครสมาชิก</button>
										<?php
									}
									else
									{
										?>
										<?php
										require_once('_assets/connect.php');
										$uid = $_SESSION['UID'];
										$sql = "SELECT * FROM user WHERE UID = '$uid'";
										$o = mysql_query($sql);
										$r = mysql_fetch_array($o);
										$date = date("z");
										$page=$_GET['action'];
										if($page==addid){
											$addid = $_POST['addid'];
											$ll = $r['like'];
											$uuuu = $r['Username'];
											if(trim($_POST["addid"]) == "")
											{
												echo "<script type='text/javascript'>location.replace('index.php')</script>";		
												exit();
											}
											$strSQL1 = "SELECT * FROM userid WHERE userid = '".trim($_POST['addid'])."' ";
											$objQuery1 = mysql_query($strSQL1);
											$objResult1 = mysql_fetch_array($objQuery1);
											if($objResult1)
											{
												$sql12 = "UPDATE userid SET userid = '$addid' WHERE Username = ".$r["Username"]."";
												mysql_query($sql12);	
											}
											else
											{
												$www = "INSERT INTO `userid` (`ID`, `userid`, `like`, `Status`, `Username`) VALUES (NULL, '$addid ', '$ll', 'yes', '$uuuu')";
												mysql_query($www);
												echo "<script type='text/javascript'>alert('เพิ่ม USERID $uuuu เรีนยร้อยเเล้ว');location.replace('index.php')</script>";
											}
										}
										$page=$_GET['action'];
										if($page==token){
											$token = $_POST['token'];
											$sql = "SELECT * FROM user WHERE UID = '$uid'";
											$o = mysql_query($sql);
											$r = mysql_fetch_array($o);
											preg_match("/#access_token=([[:word:]]+)/", $token, $matches);
											$ttt = $matches[1];
											if(trim($_POST["token"]) == "")
											{
												echo "<script type='text/javascript'>location.replace('index.php')</script>";		
												exit();
											}
											else
											{
												$sql = "INSERT INTO token (token) VALUES ('$ttt') ";
												mysql_query($sql);
												$sql1 = "UPDATE user SET token = 'yes' WHERE UID = ".$r["UID"]."";
												mysql_query($sql1);
												echo "<script type='text/javascript'>alert('ยืนยันเรียนร้อยเเล้ว');location.replace('index.php')</script>";
											}
										}       	
										$page=$_GET['page'];
										if($page==buy){
											?>

											<li class="active">
												<?php }?>
												<a href="?page=buy">
													<i class="material-icons">shopping_cart</i> เช่าระบบปั้มใลค์
												</a>
											</li><li>
											<?php
											$page=$_GET['page'];
											if($page==topup){
												?>

												<li class="active">
													<?php }?>
													<a href="?page=topup">
														<i class="material-icons">attach_money</i> เติมเงิน
													</a>
												</li>
												<li class="dropdown">

													<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">supervisor_account</i>ข้อมูลผู้ใช้
														<b class="caret"></b>
														<div class="ripple-container"></div></a>
														<ul class="dropdown-menu dropdown-menu-right">
															<li><a><i class="material-icons">label</i>ชื่อผู้ใช้: <?php echo $r["Username"];?></a></li>
															<li><a><i class="material-icons">attach_money</i>เงิน:<?php echo $r["coin"];?> บาท</a></li>
															<li><a><i class="material-icons">hourglass_empty</i>เวลาคงเหลือ:<?php if ($date < $r['date']) {
																$uunn = $r["Username"];
																$uuii = $r["UID"];
																$sqll1 = "SELECT * FROM userid WHERE Username = '$uunn'";
																$oo1 = mysql_query($sqll1);
																$rr1 = mysql_fetch_array($oo1);
																$usid = $rr1['ID'];
																echo $r['date'] - $date;
																echo "  วัน";
																$sql1 = "UPDATE `userid` SET `Status` = 'yes' WHERE `userid`.`ID` = '$usid'";
																mysql_query($sql1);
															}
															else
															{
																$sql = "SELECT * FROM user WHERE UID = '$uid'";
																$o = mysql_query($sql);
																$r = mysql_fetch_array($o);
																$uunn = $r["Username"];
																$uuii = $r["UID"];
																$sqll1 = "SELECT * FROM userid WHERE Username = '$uunn'";
																$oo1 = mysql_query($sqll1);
																$rr1 = mysql_fetch_array($oo1);
																$usid = $rr1['ID'];
																echo "หมดเวลา";
																$sql1 = "UPDATE `userid` SET `Status` = 'no' WHERE `userid`.`ID` = '$usid'";
																$sql2 = "UPDATE `user` SET `like` = '0' WHERE `user`.`UID` = '$uuii'";
																mysql_query($sql1);
																mysql_query($sql2);
															}
															?></a></li>
															<li><a href="?page=system"><i class="material-icons">settings</i>ตั้งค่าระบบปั้ม</a></li>
															<li class="divider"></li>
															<li><a href="?action=logout"><i class="material-icons">launch</i> ออกจากระบบ</a></li>
														</ul>
													</li>
													<?php
												}
												?>



											</ul>
										</div>
									</div>
								</nav>

								<?php
								$page=$_GET['page'];
								if($page==system){
									?> 
									<div class="row">
										<div class="col-md-12">

											<!-- Tabs with icons on Card -->
											<div class="card card-nav-tabs">
												<div class="header header-success">
													<!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
													<div class="nav-tabs-navigation">
														<div class="nav-tabs-wrapper">
															<ul class="nav nav-tabs" data-tabs="tabs">
																<li>
																	<a>
																		<i class="material-icons">add</i>
																		เพิ่มบัญชี Facebook
																		<div class="ripple-container"></div></a>
																	</li>
																</ul>
															</div>
														</div>
													</div>
													<div class="content">
														<div class="tab-content text-center">
															<div class="tab-pane active" id="profile">
																<p>เอา UserID Facebookมาใส่จากเว็บ <a href="http://findmyfbid.com/"> กดเลย!!</a></p>
																<form name="form1" method="post" action="?action=addid">
																	<div class="input-group">
																		<span class="input-group-addon">
																			<i class="material-icons">group</i>
																		</span>
																		<div class="form-group label-floating has-success"><input type="text" name="addid" id="addid" class="form-control" placeholder="UserID" required=""><span class="material-input"></span></div>
																	</div>
																	<button class="btn btn-raised btn-success"><i class="material-icons">create</i> สมัครสมาชิก</button>
																</form>
															</div>
														</div>
													</div>
												</div>
												<!-- End Tabs with icons on Card -->

<!--					</div>

					<div class="col-md-6">

						<div class="card card-nav-tabs">
							<div class="header header-success">
								<div class="nav-tabs-navigation">
									<div class="nav-tabs-wrapper">
										<ul class="nav nav-tabs" data-tabs="tabs">
											<li>
												<a>
													<i class="material-icons">build</i>
													ตั้งค่าระบบปั้มใลค์
												<div class="ripple-container"></div></a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="content">
								<div class="tab-content text-center">
									<div class="tab-pane active" id="profile">
<div class="col-sm-8">
<a onclick="window.location.href='?action=on'" class="btn btn-raised btn-success"><i class="material-icons">power_settings_new</i> เปิดระบบ</a><a onclick="window.location.href='?action=off'" class="btn btn-raised btn-danger"><i class="material-icons">power_settings_new</i> ปิดระบบ</a>
		                </div>
									</div>
									</div>
								</div>
							</div>
						</div>
					-->
				</div>

				<?php }?>
				<?php
				$page=$_GET['page'];
				if($page==news){
					require_once('_assets/connect.php');
					$sss = "SELECT * FROM news WHERE idn = '0'";
					$ss = mysql_query($sss);
					$s = mysql_fetch_array($ss);
					?> 
					<div class="col-md-12">
						<div class="card card-nav-tabs">
							<div class="content">
								<div class="tab-content text-center">
									<table class="table table-sm top">
										<thead class="thead-inverse">
											<tr>
												<th width="50%" class="text-center">ประกาศ</th>
											</tr>
										</thead>
										<tbody class="table-bordered text-center">
											<tr>
												<td><?php echo $s['news_1'];?></td>
											</tr>
											<tr>
												<td><?php echo $s['news_2'];?></td>
											</tr>
											<tr>
												<td><?php echo $s['news_3'];?></td>
											</tr>
										</tbody>
									</table>

								</div>
							</div>
						</div>
					</div>
					<?php }?>
					<?php
					$page=$_GET['page'];
					if($page==phone){
						?> 
						<div class="col-md-12">
							<div class="card card-nav-tabs">
								<div class="content">
									<div class="tab-content text-center">
										<table class="table table-sm top">
											<thead class="thead-inverse">
												<tr>
													<th width="50%" class="text-center">ติดต่อเรา</th>
												</tr>
											</thead>
											<tbody class="table-bordered text-center">
												<tr>
													<td><i class="material-icons">book</i> FaceBook:Chitwiphat T Suksri</td>
												</tr>
												<tr>
													<td><i class="material-icons">local_phone</i> โทรศัพท์:095-443-6969</td>
												</tr>
												<tr>
													<td><i class="material-icons">local_phone</i> Line:chaotts</td>
												</tr>
											</tbody>
										</table>

									</div>
								</div>
							</div>
						</div>
						<?php }?>

						<?php
						$page=$_GET['page'];
						if($page==buy){
							?> 
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<div class="card card-signup">
											<div class="content">
												<div class="typography">
													<div class="col-md-4 col-sm-4 col-xs-4" style="padding:10px;">
														<div class="thumbnail" style="border:2px #00AA00 solid;border-radius:0px;">
															<img src="_assets/img/bg2.jpeg" class="img-rounded"style="width:160px;height:160px;">
															<center>
																<div class="tab-content text-center">
																	<table class="table table-sm top">
																		<thead class="thead-inverse">
																			<tr>
																				<th width="50%" class="text-center"><i class="material-icons">thumb_up</i>ฟรี</th>
																			</tr>
																		</thead>
																		<tbody class="table-bordered text-center">
																			<tr>
																				<td><i class="material-icons">thumb_up</i> ปั้มใลค์อัตโนมัตครั้งละ : 30 ไลค์</td>
																			</tr>
																			<tr>
																				<td><i class="material-icons">thumb_up</i> ระยะเวลา : 7 วัน</td>
																			</tr>
																			<tr>
																				<td><i class="material-icons">thumb_up</i> ราคา : ฟรี</td>
																			</tr>
																		</tbody>
																	</table>

																</div>
																<center>
																	<a class="btn btn-raised btn-success" href="?action=buy&ID=1">ซื้อเลย!</a>
																</center></center></div>
															</div>
														</div>
														<div class="typography">
															<div class="col-md-4 col-sm-4 col-xs-4" style="padding:10px;">
																<div class="thumbnail" style="border:2px #00AA00 solid;border-radius:0px;">
																	<img src="_assets/img/bg2.jpeg" class="img-rounded"style="width:160px;height:160px;">
																	<center>
																		<div class="tab-content text-center">
																			<table class="table table-sm top">
																				<thead class="thead-inverse">
																					<tr>
																						<th width="50%" class="text-center"><i class="material-icons">thumb_up</i>ธรรมดา</th>
																					</tr>
																				</thead>
																				<tbody class="table-bordered text-center">
																					<tr>
																						<td><i class="material-icons">thumb_up</i> ปั้มใลค์อัตโนมัตครั้งละ : 150 ไลค์</td>
																					</tr>
																					<tr>
																						<td><i class="material-icons">thumb_up</i> ระยะเวลา : 30 วัน</td>
																					</tr>
																					<tr>
																						<td><i class="material-icons">thumb_up</i> ราคา : 200 บาท</td>
																					</tr>
																				</tbody>
																			</table>

																		</div>
																		<center>
																			<button class="btn btn-raised btn-success">ซื้อเลย!</button>
																		</center></center></div>
																	</div>
																</div>
																<div class="typography">
																	<div class="col-md-4 col-sm-4 col-xs-4" style="padding:10px;">
																		<div class="thumbnail" style="border:2px #00AA00 solid;border-radius:0px;">
																			<img src="_assets/img/bg2.jpeg" class="img-rounded"style="width:160px;height:160px;">
																			<center>
																				<div class="tab-content text-center">
																					<table class="table table-sm top">
																						<thead class="thead-inverse">
																							<tr>
																								<th width="50%" class="text-center"><i class="material-icons">thumb_up</i>ฟรีเมี่ยม</th>
																							</tr>
																						</thead>
																						<tbody class="table-bordered text-center">
																							<tr>
																								<td><i class="material-icons">thumb_up</i> ปั้มใลค์อัตโนมัตครั้งละ : 500 ไลค์</td>
																							</tr>
																							<tr>
																								<td><i class="material-icons">thumb_up</i> ระยะเวลา : 30 วัน</td>
																							</tr>
																							<tr>
																								<td><i class="material-icons">thumb_up</i> ราคา : 300 บาท</td>
																							</tr>
																						</tbody>
																					</table>

																				</div>
																				<center>
																					<button class="btn btn-raised btn-success">ซื้อเลย!</button>
																				</center></center></div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<?php }?>
													<?php
													$page=$_GET['page'];
													if($page==topup){
														?> 
														<div class="container">
															<div class="row">
																<div class="col-md-5 col-md-offset-4 col-sm-6 col-sm-offset-3">
																	<div class="card card-signup">
																		<div class="content">

																			<div class="input-group">
																				<span class="input-group-addon">
																					<i class="material-icons">attach_money</i>
																				</span>
																				<div class="form-group label-floating has-success"><input name="tmn_password" type="text"id="tmn_password" maxlength="14" class="form-control" placeholder="ใส่เลขบัตรทรูมันนี่ 14 หลัก" required=""><span class="material-input"></span></div>
																			</div>
																			<input name="ref1" type="hidden" id="ref1" disabled value="<?php echo $r["Username"];?>" />
																			<input name="ref2" type="hidden" id="ref2" disabled value="<?php echo $r["Username"];?>" />
																			<button type="button" onclick="submit_tmnc()"  class="btn btn-raised btn-success"><i class="material-icons">attach_money</i> เติมเงิน</button>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<?php }?>
											<?php
											$page=$_GET['page'];
											if($page==login){
												?> 
												<div class="container">
													<div class="row">
														<div class="col-md-5 col-md-offset-4 col-sm-6 col-sm-offset-3">
															<div class="card card-signup">
																<div class="content">
																	<form name="form1" method="post" action="?action=login">
																		<div class="input-group">
																			<span class="input-group-addon">
																				<i class="material-icons">group</i>
																			</span>
																			<div class="form-group label-floating has-success"><input type="text" name="Username" id="Username" class="form-control" placeholder="ชื่อผู้ใช้" required=""><span class="material-input"></span></div>
																		</div>
																		<div class="input-group">
																			<span class="input-group-addon">
																				<i class="material-icons">lock</i>
																			</span>
																			<div class="form-group label-floating has-success"><input type="Password" name="Password" id="Password" class="form-control" placeholder="รหัสผ่าน" required=""><span class="material-input"></span></div>
																		</div>
																		<button type="submit" class="btn btn-raised btn-info"><i class="material-icons">supervisor_account</i> ล็อกอิน</button></form>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<?php }?>
										<?php
										$page=$_GET['page'];
										if($page==register){
											?> 
											<div class="container">
												<div class="row">
													<div class="col-md-5 col-md-offset-4 col-sm-6 col-sm-offset-3">
														<div class="card card-signup">
															<div class="content">
																<form name="form1" method="post" action="?action=register">
																	<div class="input-group">
																		<span class="input-group-addon">
																			<i class="material-icons">group</i>
																		</span>
																		<div class="form-group label-floating has-success"><input type="text" name="Username" id="Username" class="form-control" placeholder="ชื่อผู้ใช้"required=""><span class="material-input"></span></div>
																	</div>
																	<div class="input-group">
																		<span class="input-group-addon">
																			<i class="material-icons">lock</i>
																		</span>
																		<div class="form-group label-floating has-success"><input type="Password" name="Password" id="Password" class="form-control" placeholder="รหัสผ่าน"required=""><span class="material-input"></span></div>
																	</div>
																	<div class="input-group">
																		<span class="input-group-addon">
																			<i class="material-icons">lock</i>
																		</span>
																		<div class="form-group label-floating has-success"><input type="Password" name="cPassword" id="cPassword" class="form-control" placeholder="รหัสผ่านอีกครั้ง"required=""><span class="material-input"></span></div>
																	</div>
																	&nbsp;<button class="btn btn-raised btn-danger"><i class="material-icons">create</i> สมัครสมาชิก</button>
																</form>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<?php }?>
								<?php
								$page=$_GET['page'];
								if($page!==news&&$page!==phone&&$page!==login&&$page!==register&&$page!==topup&&$page!==buy&&$page!==system){
									?> 
									<div class="section" id="carousel">
										<div class="container">
											<div class="row">
												<div class="col-md-12">

													<!-- Carousel Card -->
													<div class="card card-raised card-carousel">
														<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
															<div class="carousel slide" data-ride="carousel">

																<!-- Indicators -->
																<ol class="carousel-indicators">
																	<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
																	<li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
																	<li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
																</ol>

																<!-- Wrapper for slides -->
																<div class="carousel-inner">
																	<div class="item active">
																		<img src="_assets/img/bg2.jpeg" alt="Awesome Image">
																		<div class="carousel-caption">
																			<h4><i class="material-icons">thumb_up</i> Autos-Like | ระบบไลค์อัตโนมัต</h4>
																		</div>
																	</div>
																	<div class="item">
																		<img src="_assets/img/bg3.jpeg" alt="Awesome Image">
																		<div class="carousel-caption">
																			<h4><i class="material-icons">thumb_up</i> Autos-Like | ระบบไลค์อัตโนมัต</h4>
																		</div>
																	</div>
																	<div class="item">
																		<img src="_assets/img/bg4.jpeg" alt="Awesome Image">
																		<div class="carousel-caption">
																			<h4><i class="material-icons">thumb_up</i> Autos-Like | ระบบไลค์อัตโนมัต</h4>
																		</div>
																	</div>
																</div>

																<!-- Controls -->
																<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
																	<i class="material-icons">keyboard_arrow_left</i>
																</a>
																<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
																	<i class="material-icons">keyboard_arrow_right</i>
																</a>
															</div>
														</div>
													</div>
													<!-- End Carousel Card -->

												</div>
											</div>
										</div>
									</div>
									<?php
									if($r['token'] == 'no'){
										?> 
										<div class="col-md-12">
											<div class="card card-nav-tabs">
												<div class="content">
													<div class="col-sm-12">
														<form name="form1" method="post" action="?action=token">
															<div class="form-group label-floating has-success">
																<input type="text" name="token" placeholder="https://www.facebook.com/connect/login_success.html#access_token=EAAAACZAVC6ygBAKh1lH26cQJSTsUdBwlnbg57OUhra6jmyq5G3zUSp8B3Kvz5PM1Er26cWaLLDUcupIZBtBmTzpTCbPZAprVTpRiCXeMAOD7D3iIpS5rksfRkdZAmRVR4nREniC6pWfCcZC3l4yacGZBbEE98NDMcxxxxxxxxxx&expires_in=0" class="form-control">
																<span class="material-input"></span></div>
															</div><a target="_blank" href="https://www.facebook.com/dialog/oauth?redirect_uri=http%3A%2F%2Fwww.facebook.com%2Fconnect%2Flogin_success.html&scope=email%2Cpublish_actions%2Cuser_about_me%2Cuser_actions.music%2Cuser_actions.news%2Cuser_actions.video%2Cuser_activities%2Cuser_birthday%2Cuser_education_history%2Cuser_events%2Cuser_games_activity%2Cuser_groups%2Cuser_hometown%2Cuser_interests%2Cuser_likes%2Cuser_location%2Cuser_notes%2Cuser_photos%2Cuser_questions%2Cuser_relationship_details%2Cuser_relationships%2Cuser_religion_politics%2Cuser_status%2Cuser_subscriptions%2Cuser_videos%2Cuser_website%2Cuser_work_history%2Cfriends_about_me%2Cfriends_actions.music%2Cfriends_actions.news%2Cfriends_actions.video%2Cfriends_activities%2Cfriends_birthday%2Cfriends_education_history%2Cfriends_events%2Cfriends_games_activity%2Cfriends_groups%2Cfriends_hometown%2Cfriends_interests%2Cfriends_likes%2Cfriends_location%2Cfriends_notes%2Cfriends_photos%2Cfriends_questions%2Cfriends_relationship_details%2Cfriends_relationships%2Cfriends_religion_politics%2Cfriends_status%2Cfriends_subscriptions%2Cfriends_videos%2Cfriends_website%2Cfriends_work_history%2Cads_management%2Ccreate_event%2Ccreate_note%2Cexport_stream%2Cfriends_online_presence%2Cmanage_friendlists%2Cmanage_notifications%2Cmanage_pages%2Coffline_access%2Cphoto_upload%2Cpublish_checkins%2Cpublish_stream%2Cread_friendlists%2Cread_insights%2Cread_mailbox%2Cread_page_mailboxes%2Cread_requests%2Cread_stream%2Crsvp_event%2Cshare_item%2Csms%2Cstatus_update%2Cuser_online_presence%2Cvideo_upload%2Cxmpp_login&response_type=token&client_id=41158896424" class="btn btn-raised btn-danger"><i class="material-icons">report</i> 1.ยืนยันสืทธิ์</a><a target="_blank" href="view-source:https://www.facebook.com/dialog/oauth?redirect_uri=http%3A%2F%2Fwww.facebook.com%2Fconnect%2Flogin_success.html&scope=email%2Cpublish_actions%2Cuser_about_me%2Cuser_actions.music%2Cuser_actions.news%2Cuser_actions.video%2Cuser_activities%2Cuser_birthday%2Cuser_education_history%2Cuser_events%2Cuser_games_activity%2Cuser_groups%2Cuser_hometown%2Cuser_interests%2Cuser_likes%2Cuser_location%2Cuser_notes%2Cuser_photos%2Cuser_questions%2Cuser_relationship_details%2Cuser_relationships%2Cuser_religion_politics%2Cuser_status%2Cuser_subscriptions%2Cuser_videos%2Cuser_website%2Cuser_work_history%2Cfriends_about_me%2Cfriends_actions.music%2Cfriends_actions.news%2Cfriends_actions.video%2Cfriends_activities%2Cfriends_birthday%2Cfriends_education_history%2Cfriends_events%2Cfriends_games_activity%2Cfriends_groups%2Cfriends_hometown%2Cfriends_interests%2Cfriends_likes%2Cfriends_location%2Cfriends_notes%2Cfriends_photos%2Cfriends_questions%2Cfriends_relationship_details%2Cfriends_relationships%2Cfriends_religion_politics%2Cfriends_status%2Cfriends_subscriptions%2Cfriends_videos%2Cfriends_website%2Cfriends_work_history%2Cads_management%2Ccreate_event%2Ccreate_note%2Cexport_stream%2Cfriends_online_presence%2Cmanage_friendlists%2Cmanage_notifications%2Cmanage_pages%2Coffline_access%2Cphoto_upload%2Cpublish_checkins%2Cpublish_stream%2Cread_friendlists%2Cread_insights%2Cread_mailbox%2Cread_page_mailboxes%2Cread_requests%2Cread_stream%2Crsvp_event%2Cshare_item%2Csms%2Cstatus_update%2Cuser_online_presence%2Cvideo_upload%2Cxmpp_login&response_type=token&client_id=41158896424" class="btn btn-raised btn-info"><i class="material-icons">border_color</i> 2.รับลิงค์เข้าใช้งาน</a><button class="btn btn-raised btn-success"><i class="material-icons">thumb_up</i> 3.ตกลง</button></form>
														</div>
													</div>
												</div>

												<?php }?>
												<div class="col-md-6">
													<div class="card card-nav-tabs">
														<div class="content">
															<div class="tab-content text-center">
																<table class="table table-sm top">
																	<thead class="thead-inverse">
																		<tr>
																			<th width="50%" class="text-center">ระบบต่างๆ</th>
																			<th width="50%" class="text-center">สถานะ</th>
																		</tr>
																	</thead>
																	<tbody class="table-bordered text-center">
																		<tr>
																			<td><i class="material-icons">credit_card</i> TrueMoney</td>
																			<td class="table-success"><i class="fa fa-check"></i> ทำงาน</td>
																		</tr>
																		<tr>
																			<td><i class="material-icons">settings</i> ระบบปั้มอัตโนมัต</td>
																			<td class="table-success"><i class="fa fa-check"></i> ทำงาน</td>
																		</tr>
																		<tr>
																			<td><i class="material-icons">language</i> เว็ปไซต์</td>
																			<td class="table-success"><i class="fa fa-check"></i> ทำงาน</td>
																		</tr>
																	</tbody>
																</table>

															</div>
														</div>
													</div>
												</div>

												<div class="col-md-6">
													<div class="card card-nav-tabs">
														<div class="content">
															<div class="tab-content text-center">
																<p><div class="row"><div class="col-sm-12 col-md-12 for-whom-cont"><div class="personal"><h3>ใช้งานส่วนบุคคล</h3><p>เคยมั้ย? อยากได้ไลค์เยอะๆ ไม่ว่าจะเพื่อเหตุผลอะไรก็แล้วแต่ ในการโพสต์แต่ละครั้งคุณจำเป็นจะต้องเข้าเว็บปั๊มไลค์ทุกครั้งเพื่อปั๊มให้โพสต์ของคุณมียอดไลค์สูงสุด ลืมการกระทำพวกนั้นได้เลย ระบบของเราจัดการเองให้ทุกอย่าง</p></div><div class="mt50"><h3>ใช้งานสำหรับร้านค้าเเละเพจต่างๆ</h3><p>จากผลสำรวจ พบว่าลูกค้ากว่า 95% ที่ซื้อของออนไลน์ ดูความน่าเชื่อถือของร้านค้าจากยอดไลค์รวมของร้าน ระบบของเราจะช่วยให้ร้านค้าท่านมีความน่าเชื่อถือมากยิ่งขึ้น และที่สำคัญ<b>ช่วยให้ลูกค้าเห็นสินค้าของคุณมากขึ้น</b>อีกด้วย</p></div></div></div></p>
															</div>
														</div>
													</div>
												</div>

												<?php }?>

												<!--  End Modal -->
												<div class="container top text-center">
													<strong>2016-2017 © Auto-Like.net Developers By SkyStudio</strong>
												</div>

											</body>
											<!--   Core JS Files   -->
											<script src="_assets/js/jquery.min.js" type="text/javascript"></script>
											<script src="_assets/js/bootstrap.min.js" type="text/javascript"></script>
											<script src="_assets/js/material.min.js"></script>

											<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
											<script src="_assets/js/nouislider.min.js" type="text/javascript"></script>

											<!--  Plugin for the Datepicker, full documentation here: http://www.eyecon.ro/bootstrap-datepicker/ -->
											<script src="_assets/js/bootstrap-datepicker.js" type="text/javascript"></script>

											<!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
											<script src="_assets/js/material-kit.js" type="text/javascript"></script>

											<!-- Sharrre library just for Live Preview -->
											<script src="_assets/js/jquery.sharrre.js" type="text/javascript"></script>

											</html>
