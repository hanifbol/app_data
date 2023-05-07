<!doctype html>
<html lang="en">
 
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Concept - Bootstrap 4 Admin Dashboard Template</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/libs/css/style.css">
	<link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
	<style>
	html,
	body {
		height: 100%;
	}

	body {
		display: -ms-flexbox;
		display: flex;
		-ms-flex-align: center;
		align-items: center;
		padding-top: 40px;
		padding-bottom: 40px;
	}
	</style>
</head>
<!-- ============================================================== -->
<!-- signup form  -->
<!-- ============================================================== -->

<body>
	<!-- ============================================================== -->
	<!-- signup form  -->
	<!-- ============================================================== -->
	<div class="container">
		<div class="row">
			<div class="m-auto col-md-8">
				<form id="registration-form">
					<div class="card">
						<div class="card-header">
							<h3 class="mb-1">Registrations Form</h3>
							<p>Please enter your user information.</p>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="username">Username</label>
										<input id="username" class="form-control form-control-lg" type="text" name="username" required="" autocomplete="off">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="phone">Phone Number</label>
										<input id="phone" class="form-control form-control-lg" type="text" name="phone" autocomplete="off">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="password">Password</label>
										<input id="password" class="form-control form-control-lg" type="password" name="password" required="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="confirm">Confirm Password</label>
										<input id="confirm" class="form-control form-control-lg" type="password" required="">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="firstname">First Name</label>
										<input id="firstname" class="form-control form-control-lg" type="text" name="firstname" required="" autocomplete="off">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="lastname">Last Name</label>
										<input id="lastname" class="form-control form-control-lg" type="text" name="lastname" autocomplete="off">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="address">Address</label>
										<textarea id="address" class="form-control form-control-lg" name="address" autocomplete="off"></textarea>
									</div>
								</div>
							</div>
							<div class="form-group pt-2">
								<input type="hidden" name="submit" value="register"> 
								<button class="btn btn-block btn-primary" type="submit">Register My Account</button>
							</div>
						</div>
						<div class="card-footer bg-white">
							<p>Already member? <a href="login.php" class="text-secondary">Login Here.</a></p>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- jquery 3.3.1 -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
	<!-- custom script -->
	<script>
		$("#registration-form").on("submit", function(e) {
			e.preventDefault();

			var values = $(this).serializeArray();
			$.ajax({
				type: 'POST',
				url: 'action/pengguna.php',
				data: values,
				encode: true,
				success: function(response) {
					window.location.href = "index.php"	
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus)
					console.log(errorThrown)
				}
			})
		})
	</script>
</body>

 
</html>