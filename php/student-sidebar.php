<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="student-home.php">Case Management System</a>
	</div>
	<!-- /.navbar-header -->

	<ul class="nav navbar-top-links navbar-right">
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-messages">
				<li>
					<a href="#">
						<div>
							<strong>John Smith</strong>
							<span class="pull-right text-muted">
								<em>Yesterday</em>
							</span>
						</div>
						<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="#">
						<div>
							<strong>John Smith</strong>
							<span class="pull-right text-muted">
								<em>Yesterday</em>
							</span>
						</div>
						<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="#">
						<div>
							<strong>John Smith</strong>
							<span class="pull-right text-muted">
								<em>Yesterday</em>
							</span>
						</div>
						<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a class="text-center" href="#">
						<strong>Read All Messages</strong>
						<i class="fa fa-angle-right"></i>
					</a>
				</li>
			</ul>
			<!-- /.dropdown-messages -->
		</li>
		<!-- /.dropdown -->
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-alerts">
				<li>
					<a href="#">
						<div>
							<i class="fa fa-comment fa-fw"></i> New Comment
							<span class="pull-right text-muted small">4 minutes ago</span>
						</div>
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="#">
						<div>
							<i class="fa fa-twitter fa-fw"></i> 3 New Followers
							<span class="pull-right text-muted small">12 minutes ago</span>
						</div>
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="#">
						<div>
							<i class="fa fa-envelope fa-fw"></i> Message Sent
							<span class="pull-right text-muted small">4 minutes ago</span>
						</div>
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="#">
						<div>
							<i class="fa fa-tasks fa-fw"></i> New Task
							<span class="pull-right text-muted small">4 minutes ago</span>
						</div>
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="#">
						<div>
							<i class="fa fa-upload fa-fw"></i> Server Rebooted
							<span class="pull-right text-muted small">4 minutes ago</span>
						</div>
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a class="text-center" href="#">
						<strong>See All Alerts</strong>
						<i class="fa fa-angle-right"></i>
					</a>
				</li>
			</ul>
			<!-- /.dropdown-alerts -->
		</li>
		<!-- /.dropdown -->
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
					<a href="student-home.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
				</li>
				<li>
					<a href="#"><i class="fa fa-bullseye fa-fw"></i> Case Tracker<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="activecases.php">Active</a>
						</li>
						<li>
							<a href="closedcases.php">Closed</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#"><i class="fa fa-file-text-o fa-fw"></i> Files<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="#">File 1</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="student-calendar.php"><i class="fa fa-calendar fa-fw"></i> Calendar</a>
				</li>
			</ul>
		</div>
		<!-- /.sidebar-collapse -->
	</div>
	<!-- /.navbar-static-side -->
</nav>
