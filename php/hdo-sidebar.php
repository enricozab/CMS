<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="do-home.php">Case Management System</a>
	</div>
	<!-- /.navbar-header -->

	<ul class="nav navbar-top-links navbar-right">
		<li><b>Welcome, <?php echo $_SESSION['first_name']; ?>!</b></li>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-user">
				<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
				</li>
				<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
				</li>
				<li class="divider"></li>
				<li><a href="login.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
				<li class="sidebar-search">
					<div class="input-group custom-search-form">
						<input type="text" class="form-control" placeholder="Search...">
						<span class="input-group-btn">
						<button class="btn btn-default" type="button">
							<i class="fa fa-search"></i>
						</button>
					</span>
					</div>
					<!-- /input-group -->
				</li>
				<li>
					<a href="hdo-home.php"><i class="fa fa-bell fa-fw"></i> Case Notifications <span id="cn" class="badge"></span></a>
				</li>
				<li>
					<a href="do-apprehension.php"><i class="fa fa-plus fa-fw"></i> Apprehend</a>
				</li>
				<li>
					<a href="#"><i class="fa fa-bullseye fa-fw"></i> Case Tracker<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="do-active-cases.php">Active</a>
						</li>
						<li>
							<a href="do-closed-cases.php">Closed</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#"><i class="fa fa-folder-open  fa-fw"></i> Files<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="#">File 1</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#"><i class="fa fa-clipboard fa-fw"></i> Reports<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="#">Report 1</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="do-calendar.php"><i class="fa fa-calendar fa-fw"></i> Calendar</a>
				</li>
				<li>
					<a href="do-user-management.php"><i class="fa fa-users fa-fw"></i> User Management</a>
				</li>
				<li>
					<a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="../pages/panels-wells.html">Panels and Wells</a>
						</li>
						<li>
							<a href="../pages/buttons.html">Buttons</a>
						</li>
						<li>
							<a href="../pages/notifications.html">Notifications</a>
						</li>
						<li>
							<a href="../pages/typography.html">Typography</a>
						</li>
						<li>
							<a href="../pages/icons.html"> Icons</a>
						</li>
						<li>
							<a href="../pages/grid.html">Grid</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<!-- /.sidebar-collapse -->
	</div>
	<!-- /.navbar-static-side -->
</nav>
