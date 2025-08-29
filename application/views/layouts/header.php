<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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

	<title>CS Ticketing - <?=strtoupper($page)?></title>

	<!-- font family -->
	<link rel="preconnect" href="//fonts.gstatic.com">
	<link href="//fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

	<!-- font awesome -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	
	<!-- Bootstrap -->
	<link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="<?=base_url('assets/css/jquery.datatables.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/dataTables.fontAwesome.min.css')?>">

	<!-- main css -->
	<link rel="stylesheet" href="<?=base_url('assets/css/main.css')?>">
</head>
<body class="rty" style="background-image: url('<?=base_url('assets/img/bg.jpg')?>');">
    <input type="hidden" id="current_page" name="current_page" value="<?=$page?>" >

    <main>
        <div class="topbar">
            <div class="logo-wrapper">
                <button type="button" class="mobile-menu">
                    <i class="fa fa-bars"></i>
                </button>

                <h2 class="logo">
                    <span>CS</span>
                    <span>Ticketing</span>
                </h2>
            </div>

            <div class="info">
				<p><?=(isset($_SESSION['name'])) ? $_SESSION['name'] : 'Unknown'?></p>
				<div class="profile-img" style="background-image: url('<?=(isset($_SESSION['img']) && file_exists($_SESSION['img'])) ? $_SESSION['img'] : base_url('assets/img/image-not-available.png')?>');"></div>
			</div>
        </div>


        <div class="body">
            <div class="sidebar">
                <ul class="nav">
                    <li>
                        <a href="<?=base_url()?>" <?=($page == 'issues') ? 'class="active"' : ''?>>
                            <i class="fa fa-ticket"></i>
                            <span>TICKETS</span>
                        </a>
                    </li>
                    <!--<li>
                        <a href="<?=base_url('reports')?>" <?=($page == 'reports') ? 'class="active"' : ''?>>
                            <i class="fa fa-bar-chart"></i>
                            <span>REPORTS</span>
                        </a>
                    </li>-->
                </ul>
            </div>


            <div class="content">