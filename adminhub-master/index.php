<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "green_cafee");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Total orders
$orderResult = $conn->query("SELECT COUNT(*) AS total_orders FROM orders");
$orderData = $orderResult->fetch_assoc();

// Total users
$userResult = $conn->query("SELECT COUNT(*) AS total_users FROM users");
$userData = $userResult->fetch_assoc();

// Total sales
$salesResult = $conn->query("SELECT SUM(total_amount) AS total_sales FROM orders WHERE status='Completed'");
$salesData = $salesResult->fetch_assoc();

// Recent orders
$recentOrders = $conn->query("SELECT o.*, u.name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.order_date DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Admin Dashboard | Green Cafee</title>
	<link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="style.css" />
</head>
<body>

<!-- SIDEBAR -->
<section id="sidebar">
	<a href="#" class="brand">
		<i class='bx bxs-plant'></i>
		<span class="text">Green Cafee</span>
	</a>
	<ul class="side-menu top">
		<li class="active"><a href="#"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
		<li><a href="#"><i class='bx bxs-shopping-bag-alt'></i><span class="text">My Store</span></a></li>
		<li><a href="#"><i class='bx bxs-doughnut-chart'></i><span class="text">Analytics</span></a></li>
	</ul>
	<ul class="side-menu">
		<li><a href="#"><i class='bx bxs-cog'></i><span class="text">Settings</span></a></li>
		<li><a href="#" class="logout"><i class='bx bxs-log-out-circle'></i><span class="text">Logout</span></a></li>
	</ul>
</section>

<!-- CONTENT -->
<section id="content">
	<nav>
		<i class='bx bx-menu'></i>
		<a href="#" class="nav-link">Categories</a>
		<form action="#"><div class="form-input"><input type="search" placeholder="Search..." /></div></form>
		<a href="#" class="profile"><img src="img/my.jpg" alt="Profile" /></a>
	</nav>

	<main>
		<div class="head-title">
			<div class="left">
				<h1>Dashboard</h1>
				<ul class="breadcrumb">
					<li><a href="#">Dashboard</a></li>
					<li><i class='bx bx-chevron-right'></i></li>
					<li><a class="active" href="#">Home</a></li>
				</ul>
			</div>
			<a href="#" class="btn-download"><i class='bx bxs-cloud-download'></i><span class="text">Download PDF</span></a>
		</div>

		<!-- Info Boxes -->
		<ul class="box-info">
			<li>
				<i class='bx bxs-calendar-check'></i>
				<span class="text">
					<h3><?= $orderData['total_orders'] ?></h3>
					<p>New Orders</p>
				</span>
			</li>
			<li>
				<i class='bx bxs-group'></i>
				<span class="text">
					<h3><?= $userData['total_users'] ?></h3>
					<p>Visitors</p>
				</span>
			</li>
			<li>
				<i class='bx bxs-dollar-circle'></i>
				<span class="text">
					<h3>Rs. <?= number_format($salesData['total_sales'], 2) ?></h3>
					<p>Total Sales</p>
				</span>
			</li>
		</ul>

		<div class="table-data">
			<!-- Orders Table -->
			<div class="order">
				<div class="head">
					<h3>Recent Orders</h3>
				</div>
				<table>
					<thead>
						<tr>
							<th>User</th>
							<th>Date</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = $recentOrders->fetch_assoc()): ?>
						<tr>
							<td><img src="img/people.png"><p><?= htmlspecialchars($row['name']) ?></p></td>
							<td><?= date("d-m-Y", strtotime($row['order_date'])) ?></td>
							<td><span class="status <?= strtolower($row['status']) ?>"><?= $row['status'] ?></span></td>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>

			<!-- To-Do List -->
			<div class="todo">
				<div class="head"><h3>To-dos</h3></div>
				<ul class="todo-list">
					<li class="completed"><p>Check stock</p></li>
					<li class="not-completed"><p>Reply to messages</p></li>
					<li class="completed"><p>Review analytics</p></li>
					<li class="not-completed"><p>Update store info</p></li>
				</ul>
			</div>
		</div>
	</main>
</section>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Admin Dashboard | Green Cafee</title>

	<!-- Boxicons CSS -->
	<link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
	<!-- Custom CSS -->
	<link rel="stylesheet" href="style.css" />
</head>
<body>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-plant'></i>
			<span class="text">Green Cafee</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="#">
					<i class='bx bxs-dashboard'></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-shopping-bag-alt'></i>
					<span class="text">My Store</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-doughnut-chart'></i>
					<span class="text">Analytics</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-message-dots'></i>
					<span class="text">Messages</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-group'></i>
					<span class="text">Team</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#">
					<i class='bx bxs-cog'></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="#" class="logout">
					<i class='bx bxs-log-out-circle'></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>

	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu'></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search..." />
					<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden />
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell'></i>
				<span class="num">8</span>
			</a>
			<a href="#" class="profile">
				<img src="img/my.jpg" alt="Profile" />
			</a>
		</nav>

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li><a href="#">Dashboard</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a class="active" href="#">Home</a></li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download'></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

			<!-- Info Boxes -->
			<ul class="box-info">
				<li>
					<i class='bx bxs-calendar-check'></i>
					<span class="text">
						<h3>1020</h3>
						<p>New Orders</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group'></i>
					<span class="text">
						<h3>2834</h3>
						<p>Visitors</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-dollar-circle'></i>
					<span class="text">
						<h3>Rs. 2543</h3>
						<p>Total Sales</p>
					</span>
				</li>
			</ul>

			<!-- Table and Todo -->
			<div class="table-data">
				<!-- Orders Table -->
				<div class="order">
					<div class="head">
						<h3>Recent Orders</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>User</th>
								<th>Date</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><img src="img/people.png"><p>John Doe</p></td>
								<td>01-10-2021</td>
								<td><span class="status completed">Completed</span></td>
							</tr>
							<tr>
								<td><img src="img/people.png"><p>Jane Smith</p></td>
								<td>03-10-2021</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td><img src="img/people.png"><p>Alex Green</p></td>
								<td>05-10-2021</td>
								<td><span class="status process">In Process</span></td>
							</tr>
						</tbody>
					</table>
				</div>

				<!-- To-Do List -->
				<div class="todo">
					<div class="head">
						<h3>To-dos</h3>
						<i class='bx bx-plus'></i>
						<i class='bx bx-filter'></i>
					</div>
					<ul class="todo-list">
						<li class="completed"><p>Check stock</p><i class='bx bx-dots-vertical-rounded'></i></li>
						<li class="not-completed"><p>Reply to messages</p><i class='bx bx-dots-vertical-rounded'></i></li>
						<li class="completed"><p>Review analytics</p><i class='bx bx-dots-vertical-rounded'></i></li>
						<li class="not-completed"><p>Update store info</p><i class='bx bx-dots-vertical-rounded'></i></li>
					</ul>
				</div>
			</div>
		</main>
	</section>

	<!-- JavaScript -->
	<script src="script.js"></script>
</body>
</html>
