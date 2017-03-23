<?

?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<?php echo $this->Html->charset('utf-8'); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>

	<?php
		echo $this->Html->meta('icon');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

		#BEGIN GLOBAL MANDATORY STYLES
		echo $this->Html->css('assets/global/plugins/font-awesome/css/font-awesome.min.css');
		echo $this->Html->css('assets/global/plugins/simple-line-icons/simple-line-icons.min.css');
		echo $this->Html->css('assets/global/plugins/bootstrap/css/bootstrap.min.css');
		echo $this->Html->css('assets/global/plugins/uniform/css/uniform.default.css');
		echo $this->Html->css('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');
		#BEGIN THEME STYLES
		echo $this->Html->css('assets/global/css/components-rounded.css');
		echo $this->Html->css('assets/global/css/plugins.min.css');

		#BEGIN THEME LAYOUT STYLES
		echo $this->Html->css('assets/layouts/layout3/css/layout.min.css');
		echo $this->Html->css('assets/layouts/layout3/css/themes/default.min.css');
		echo $this->Html->css('assets/layouts/layout3/css/custom.min.css');

		#base js
		echo $this->Html->script('js/modernizr-2.6.2.min.js');
		#plugin js
		echo $this->Html->script('assets/global/plugins/jquery.min.js');
		echo $this->Html->script('assets/global/plugins/jquery-migrate.min.js');
		echo $this->Html->script('assets/global/plugins/jquery-ui/jquery-ui.min.js');
		echo $this->Html->script('assets/global/plugins/bootstrap/js/bootstrap.min.js');
		echo $this->Html->script('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js');
		echo $this->Html->script('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js');
		echo $this->Html->script('assets/global/plugins/jquery.blockui.min.js');
		echo $this->Html->script('assets/global/plugins/jquery.cokie.min.js');
		echo $this->Html->script('assets/global/plugins/uniform/jquery.uniform.min.js');
		echo $this->Html->script('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js');

		echo $this->Html->script('assets/global/scripts/app.min.js');
		echo $this->Html->script('assets/layouts/layout3/scripts/layout.min.js');
		echo $this->Html->script('assets/layouts/layout3/scripts/demo.min.js');
		echo $this->Html->script('assets/layouts/global/scripts/quick-sidebar.min.js');

	?>

</head>
<body>
	<div id="container">
		<div id="header">
			<div class="page-header">
				<!-- BEGIN HEADER TOP -->
				<div class="page-header-top">
					<div class="container">
						<!-- BEGIN LOGO -->
						<div class="page-logo">
							<?echo $this->Html->image('assets/layouts/layout3/img/logo-default.jpg', array('class' => 'logo-default', 'url'=>array('controller'=>'member_profiles', 'action'=>'index')));?>
						</div>
						<!-- END LOGO -->
						<!-- BEGIN RESPONSIVE MENU TOGGLER -->
						<a href="javascript:;" class="menu-toggler"></a>
						<!-- END RESPONSIVE MENU TOGGLER -->
						<!-- BEGIN TOP NAVIGATION MENU -->
						<div class="top-menu">
							<ul class="nav navbar-nav pull-right">
								<li class="droddown dropdown-separator">
									<span class="separator"></span>
								</li>
								<!-- BEGIN USER LOGIN DROPDOWN -->
								<li class="dropdown dropdown-user dropdown-dark">
									<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
										<?if(isset($myData)):?>
											<img src="<?echo $myData['MemberProfile']['photo'];?>" style="width: 40px;height: 40px;" class="img-circle">
										<?endif;?>
										<span class="username username-hide-mobile">
											<?if(isset($myData)):?>
												<?echo $myData['Member']['name'];?>
											<?endif;?>
										</span>
									</a>
									<ul class="dropdown-menu dropdown-menu-default">
										<li class="divider">
										</li>
										<li>
											<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'logout'));?>"'>
												<i class="icon-key"></i>ログアウト
											</a>
										</li>
									</ul>
								</li>
								<!-- END USER LOGIN DROPDOWN -->
							</ul>
						</div>
						<!-- END TOP NAVIGATION MENU -->
					</div>
				</div>
				<!-- END HEADER TOP -->
				<!-- BEGIN HEADER MENU -->
				<div class="page-header-menu">
					<div class="container">
						<div class="hor-menu ">
							<ul class="nav navbar-nav">
								<li>
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'index'));?>"'>
										ホーム
									</a>
								</li>
								<li class="menu-dropdown mega-menu-dropdown ">
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'view', '?' => array('month' => date(('Y-m')))));?>"' class="dropdown-toggle">
										給与確認
									</a>
								</li>
								<li class="menu-dropdown mega-menu-dropdown mega-menu-full ">
									<?$date = date('Y-m-d', strtotime('-1 day'));?>
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'daily_report', '?' => array('date' => $date)));?>"' class="dropdown-toggle">
										日別売上
									</a>
								</li>
								<li class="menu-dropdown mega-menu-dropdown mega-menu-full">
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'graph', '?' => array('location' => 1)));?>"' class="dropdown-toggle">
										売上比較
									</a>
								</li>
								<li class="menu-dropdown">
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'menu'));?>"'>
										メニュー比較
									</a>
								</li>
								<li class="menu-dropdown mega-menu-dropdown mega-menu-full">
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'cash', '?' => array('date' => date('Y-m', strtotime("-1 month")).'-01')));?>"' class="dropdown-toggle">
										買掛現金
									</a>
								</li>
								<li class="menu-dropdown mega-menu-dropdown mega-menu-full ">
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'report_card', '?' => array('date' => date('Y-m', strtotime("-1 month")).'-01')));?>"' class="dropdown-toggle">
										売上成績
									</a>
								</li>
								<li class="menu-dropdown">
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'export'));?>"'>
										エクセル出力
									</a>
								</li>
								<li class="menu-dropdown">
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'admin', 'action'=>'index'));?>"'>
										各種設定
									</a>
								</li>
							</ul>
						</div>
						<!-- END MEGA MENU -->
					</div>
				</div>
				<!-- END HEADER MENU -->
				<!--Modal View 1-->
				<!--
				<div id="responsive_1" class="modal fade in" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title">IDとパスワードを入力してください</h4>
							</div>
							<div class="modal-body">
								<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;"><div class="scroller" style="height: 300px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible1="1" data-initialized="1">
										<div class="row">
											<div class="col-md-12">
												<h4>ID</h4>
												<p>
													<input type="text" class="col-md-12 form-control" id="userId_1" autocomplete="off">
												</p>
												<h4>Password</h4>
												<p>
													<input type="text" class="col-md-12 form-control" id="userPass_1" autocomplete="off">
												</p>
												<p id="msg_1" style="color: #ff0000;"></p>
											</div>
										</div>
									</div><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 300px; background: rgb(187, 187, 187);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(234, 234, 234);"></div></div>
							</div>
							<div class="modal-footer">
								<button type="button" data-dismiss="modal" class="btn default">閉じる</button>
								<button type="button" class="btn green" id="checkButton_1">送信</button>
								<script>
									$(document).ready(function () {
										$('#checkButton_1').click(function () {
											//ID and Pass Check
											if($('#userId_1').val()=="<?if($location['Location']['name']=="池袋店"){echo 'sushikaz1324';}elseif($location['Location']['name']=="赤羽店"){echo 'sushi';}?>" && $('#userPass_1').val()=="<?if($location['Location']['name']=="池袋店"){echo '4884';}elseif($location['Location']['name']=="赤羽店"){echo '0050';}?>"){
												window.location.href = "<?echo $this->Html->url(array('controller'=>'attendances', 'action'=>'edit', '?' => array('date' => $date)));?>";
											}else{
												$('#msg_1').text("IDまたはパスワードが違います");
											}
										})
									})
								</script>
							</div>
						</div>
					</div>
				</div>
				-->
				<!--Modal1 End-->
				<!--Modal View 2-->
				<!--
				<div id="responsive_2" class="modal fade in" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title">IDとパスワードを入力してください</h4>
							</div>
							<div class="modal-body">
								<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;"><div class="scroller" style="height: 300px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible1="1" data-initialized="1">
										<div class="row">
											<div class="col-md-12">
												<h4>ID</h4>
												<p>
													<input type="text" class="col-md-12 form-control" id="userId_2" autocomplete="off">
												</p>
												<h4>Password</h4>
												<p>
													<input type="text" class="col-md-12 form-control" id="userPass_2" autocomplete="off">
												</p>
												<p id="msg_2" style="color: #ff0000;"></p>
											</div>
										</div>
									</div><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 300px; background: rgb(187, 187, 187);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(234, 234, 234);"></div></div>
							</div>
							<div class="modal-footer">
								<button type="button" data-dismiss="modal" class="btn default">閉じる</button>
								<button type="button" class="btn green" id="checkButton_2">送信</button>
								<script>
									$(document).ready(function () {
										$('#checkButton_2').click(function () {
											//ID and Pass Check
											if($('#userId_2').val()=="<?if($location['Location']['name']=="池袋店"){echo 'sushikaz1324';}elseif($location['Location']['name']=="赤羽店"){echo 'sushi';}?>" && $('#userPass_2').val()=="<?if($location['Location']['name']=="池袋店"){echo '35904884';}elseif($location['Location']['name']=="赤羽店"){echo '0050';}?>"){
												window.location.href = "<?echo $this->Html->url(array('controller'=>'members', 'action'=>'index'));?>";
											}else{
												$('#msg_2').text("IDまたはパスワードが違います");
											}
										})
									})
								</script>
							</div>
						</div>
					</div>
				</div>
				-->
				<!--Modal2 End-->
			</div>
		</div>

		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>

		<div id="footer">
			<div class="page-footer">
				<div class="container">
					2015 &copy; Riverside, INC. All Rights Reserved.
				</div>
			</div>
			<div class="scroll-to-top">
				<i class="icon-arrow-up"></i>
			</div>
		</div>

	</div>
</body>
</html>
