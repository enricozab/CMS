<!-- Navigation -->

<!-- Webpage Icon -->
<link rel="icon" href="../images/newlogo.png">

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="aulc-home.php">
			<div class="row">
				&nbsp; <img src="../images/newlogo.png" style="width: 30px; height: 30px;">&nbsp; Case Management System
			</div>
		</a>
	</div>
	<!-- /.navbar-header -->

	<ul class="nav navbar-top-links navbar-right">
	<li><b>Welcome, <?php echo $_SESSION['first_name']; ?>!</b></li>&nbsp;&nbsp;&nbsp;
		
		<!-- /.dropdown -->
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<span>
					<i class="fa fa-bell fa-2x" style="font-size: 18px; margin: -5px" aria-hidden="true"></i>
					<span id="notif-badge" class="badge badge-notify2"></span>
				<span>
			</a>
			<ul id="notifTable" class="dropdown-menu dropdown-alerts" style="width: 500px; overflow-y: scroll; max-height: 500px;">
			</ul>
			<!-- /.dropdown-alerts -->
		</li>
		<!-- /.dropdown -->

		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-user fa-fw" style="font-size: 18px; margin: -5px"></i>
			</a>
			<ul class="dropdown-menu dropdown-user">
				<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
				</li>
				<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
				</li>
				<li class="divider"></li>
				<li><a href="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://localhost/CMS"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
				</li>
			</ul>
			<!-- /.dropdown-user -->
		</li>
		<!-- /.dropdown -->
	</ul>
	<!-- /.navbar-top-links -->

	<div class="navbar-default sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
			<ul class="nav" id="side-menu">
				<li>
					<div style="text-align:center;padding:1em 0;"> 
						<iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=en&size=small&timezone=Asia%2FManila" width="100%" height="90" frameborder="0" seamless></iframe>
				</li>
				<li>
					<a href="aulc-home.php"><i class="fa fa-briefcase fa-fw"></i> Cases <span id="cn" class="badge badge-notify2"></span></a>
				</li>
				<li>
					<a href="aulc-calendar.php"><i class="fa fa-calendar fa-fw"></i> Calendar</a>
				</li>
				<li>
					<a href="aulc-gdrive.php"><i class="fa fa-folder-open  fa-fw"></i> Files</a>
				</li>
				<li>
					<a href="aulc-inbox.php"><i class="fa fa-inbox fa-fw"></i> Inbox</a>
				</li>
			</ul>
		</div>
		<!-- /.sidebar-collapse -->
	</div>
	<!-- /.navbar-static-side -->
</nav>

<style>
.badge-notify2{
   background: red;
   position: relative;
   top: -10px;
   left: 2px;
   margin: -10px;
}
</style>