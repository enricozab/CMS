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
		<a class="navbar-brand" href="sdfod-dashboard.php">
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
				<li><a href="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://localhost/CMS" id="logout_button"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
					<a href="sdfod-dashboard.php" id="sidebar_dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</span></a>
				</li>
				<li>
					<a href="sdfod-home.php" id="sidebar_cases"><i class="fa fa-briefcase fa-fw"></i> Cases <span id="cn" class="badge badge-notify2"></span></a>
				</li>
				<li>
					<a href="sdfod-incident-reports.php" id="sidebar_reports"><i class="fa fa-file-text-o fa-fw"></i> Incident Reports <span id="ir" class="badge badge-notify2"></span></a>
				</li>
				<li>
					<a href="sdfod-calendar.php" id="sidebar_calendar"><i class="fa fa-calendar fa-fw"></i> Calendar</a>
				</li>
				<li>
					<a href="sdfod-gdrive.php" id="sidebar_drive"><i class="fa fa-folder-open  fa-fw"></i> Files</a>
				</li>
				<li>
					<a href="sdfod-inbox.php" id="sidebar_inbox"><i class="fa fa-inbox fa-fw"></i> Inbox</a>
				</li>
				<li>
					<a id="sidebar_sysmanagement"><i class="fa fa-users fa-fw"></i> System Management<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="sdfod-system-management.php" id="sidebar_sysmanagement">Management</a>
						</li>
						<li>
							<a href="sdfod-system-audit.php" id="sidebar_sysaudit">Audit Trail</a>
						</li>
					</ul>
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