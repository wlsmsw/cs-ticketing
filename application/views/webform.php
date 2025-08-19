<?php defined('BASEPATH') OR exit('No direct script access allowed.'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
  	
  	<!-- Tell the browser to be responsive to screen width -->
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  	<meta name="description" content="">
  	<meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=base_url('assets/img/msw-logo.png')?>" type="image/x-icon">
    <link rel="icon" href="<?=base_url('assets/img/msw-logo.png')?>" type="image/x-icon">

	<title>MSW CS Ticketing</title>

	<!-- font family -->
	<link rel="preconnect" href="//fonts.gstatic.com">
	<link href="//fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

	<!-- font awesome -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

	<!-- main css -->
	<link rel="stylesheet" href="<?=base_url('assets/css/webform.css')?>">
</head>
<body class="player-register">

	<?php $referer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';?>

		<div class="rty-register-wrapper">
			<div class="logo">
				<img src="<?=base_url('assets/img/msw-logo-white.png')?>">
				<p>CS<span>Ticketing</span></p>
			</div>

			<form id="frmRegister" enctype="multipart/form-data">

				<p class="note">Your issues, Our Priority</p>

				<div class="form-content">
					<div>

						<div class="form-group">
							<label>Category</label>
							<select name="channel" required>
								<option value=""></option>
								<option value="Deposit">Deposit</option>
								<option value="Withdrawal">Withdrawal</option>
								<option value="General Concern">General Concern</option>
								<option value="Account Concern">Account Concern</option>
								<option value="Complaint">Complaint</option>
								<option value="Suggestion">Suggestion</option>
								<option value="Commendation">Commendation</option>
							</select>
						</div>

						
						<div class="form-group">
							<label>Username</label>
							<input type="text" name="uname" autocomplete="off" minlength="6" maxlength="21" required>
						</div>

						

						<div class="form-group">
							<label>First Name</label>
							<input type="text" name="fname" autocomplete="off" required>
						</div>


						<div class="form-group">
							<label>Email Address</label>
							<input type="email" name="email" autocomplete="off" required>
						</div>

					</div>


					<div>
						<div class="form-group">
							<label>Channel</label>
							<select name="channel" required>
								<option value=""></option>
								<option value="Voice">Voice</option>
								<option value="Chat">Chat</option>
								<option value="Email">Email</option>
							</select>
						</div>

						<div class="form-group">
							<label>Last Name</label>
							<input type="text" name="lname" autocomplete="off" required>
						</div>

						<div class="form-group">
							<label>Middle Name</label>
							<input type="text" name="mname" autocomplete="off" required>
						</div>


						<div class="form-group">
							<label>Attachment</label>
							<input type="file" name="upload_id" autocomplete="off" placeholder="Upload ID" accept=".jpg, .jpeg, .png, .pdf, .csv, .xls, .xsls, .doc, .docx" required>
						</div>
		
					</div>

				</div>

				<div class="form-content-bottom">

						<div class="form-group">
							<label>Description</label>
							<textarea name="description" autocomplete="off" rows=3 required> </textarea>
						</div>
				</div>

				<div class="button-group">
					<button type="submit">SUBMIT</button>
				</div>

			</form>
		</div>


		<footer>
			<p style="color: #f1f1f1;">Copyright &copy; 2025 | Megasportsworld | All Rights Reserved</p>
		</footer>



		<!-- scripts -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	    <script type="text/javascript">var base_url = "<?=base_url()?>";</script>
		<script src="<?=base_url('assets/js/player.js')?>"></script>


</body>
</html>