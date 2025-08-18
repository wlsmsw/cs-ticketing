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

	<title>Error - Update Contact Details</title>

	<!-- font family -->
	<link href="//fonts.googleapis.com/css?family=Poppins:400,500" rel="stylesheet">
    
	<!-- css files -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style type="text/css">
    	*,
    	*::before,
    	*::after {
    		text-decoration: none;
    		box-sizing: border-box;
    	}

    	body {
		  	background: white;
		  	background: linear-gradient(135deg, white 0%, #f3f6ff 100%);
		  	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#f3f6ff',GradientType=1 );
		  	font-family: "Poppins", sans-serif;
		  	text-align: center;
		  	position: relative;
		  	min-height: 100vh;
		  	display: block;
		  	margin: 0;
		}

		main {
			position: absolute;
		    left: 50%;
		    top: 50%;
		    transform: translate(-50%, -50%);
		}

		.wrapper {
		  	-webkit-animation: wrapperAni 230ms ease-in 200ms forwards;
          	animation: wrapperAni 230ms ease-in 200ms forwards;
		  	background: white;
		  	border: 1px solid rgba(0, 0, 0, 0.15);
		  	border-radius: 4px;
		  	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		  	display: inline-block;
		  	margin: 0;
		    height: 500px;
		    width: 350px;
		  	opacity: 0;
		  	position: relative;
		  	vertical-align: top;
		}

		.header__wrapper {
		  	height: 200px;
		  	overflow: hidden;
		  	position: relative;
		 	width: 100%;
		}

		.header {
		  	-webkit-animation: headerAni 230ms ease-in 430ms forwards;
          	animation: headerAni 230ms ease-in 430ms forwards;
		  	border-radius: 0;
		  	height: 700px;
		  	left: -200px;
		  	opacity: 0;
		  	position: absolute;
		  	top: -500px;
		  	width: 750px;
		}
		.header .sign {
		  	-webkit-animation: signAni 430ms ease-in 660ms forwards;
          	animation: signAni 430ms ease-in 660ms forwards;
		  	border-radius: 50%;
		  	bottom: 50px;
		  	display: block;
		  	height: 100px;
		  	left: calc(50% - 50px);
		  	opacity: 0;
		  	position: absolute;
		  	width: 100px;
		}

		h1,
		p {
		  	margin: 0;
		}

		.content h1 {
		  	color: rgba(0, 0, 0, 0.8);
		  	font-size: 3rem;
		  	font-weight: 700;
		  	margin-bottom: 10px;
		  	padding-top: 50px;
		}

		.content p {
		  	color: rgba(0, 0, 0, 0.7);
		  	font-size: 1.2rem;
    		padding: 0 1rem;
		  	line-height: 1.4em;
		}

		a {
		  	background: white;
		  	border: 1px solid rgba(0, 0, 0, 0.15);
		  	border-radius: 20px;
		  	bottom: -20px;
		  	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		  	cursor: pointer;
		  	font-family: inherit;
		  	font-weight: 600;
	  	    font-size: 1rem;
		    height: auto;
		    width: auto;
		    padding: 10px 2.5rem;
		    left: calc(50% - 60px);
		  	outline: none;
		  	position: absolute;
		  	-webkit-transition: all 170ms ease-in;
		  	transition: all 170ms ease-in;
			text-decoration: none;
			color: rgba(0, 0, 0, 0.7);
		}

		/*
		 * COLOR SPECIFIC
		*/
		.red .header {
		  	background-color: #ffb3b3;
		}
		.red .sign {
		  	background-color: #ff3535;
		  	box-shadow: 0 0 0 15px #ff8282, 0 0 0 30px #ffa2a2;
		}
		.red .sign:before, .red .sign:after {
		  	background: white;
		  	border-radius: 2px;
		  	content: "";
		  	display: block;
		  	height: 40px;
		  	left: calc(50% - 2px);
		  	position: absolute;
		  	top: calc(50% - 20px);
		  	width: 5px;
		}
		.red .sign:before {
		  	-webkit-transform: rotate(45deg);
          	transform: rotate(45deg);
		}
		.red .sign:after {
		  	-webkit-transform: rotate(-45deg);
          	transform: rotate(-45deg);
		}
		.red a:hover {
		  	border-color: #ff3535;
		}
		.red a:focus {
		  	background-color: #ffb3b3;
		  	border-color: #ff3535;
		}

		/*
		 * ANIMATIONS
		*/
		@-webkit-keyframes wrapperAni {
		  	0% {
		    	opacity: 0;
		    	-webkit-transform: scale(0.95) translateY(40px);
	            transform: scale(0.95) translateY(40px);
		  	}
		  	100% {
		    	opacity: 1;
		    	-webkit-transform: scale(1) translateY(0);
	            transform: scale(1) translateY(0);
		  	}
		}
		@keyframes wrapperAni {
		  	0% {
		    	opacity: 0;
		    	-webkit-transform: scale(0.95) translateY(40px);
	            transform: scale(0.95) translateY(40px);
		  	}
		  	100% {
		    	opacity: 1;
		    	-webkit-transform: scale(1) translateY(0);
	            transform: scale(1) translateY(0);
		  	}
		}
		@-webkit-keyframes headerAni {
		  	0% {
		    	border-radius: 0;
		    	opacity: 0;
		    	-webkit-transform: translateY(-100px);
	            transform: translateY(-100px);
		  	}
		  	100% {
		    	border-radius: 50%;
		    	opacity: 1;
		    	-webkit-transform: translateY(0);
	            transform: translateY(0);
		  	}
		}
		@keyframes headerAni {
		  	0% {
		    	border-radius: 0;
		    	opacity: 0;
		    	-webkit-transform: translateY(-100px);
	            transform: translateY(-100px);
		  	}
		  	100% {
		    	border-radius: 50%;
		    	opacity: 1;
		    	-webkit-transform: translateY(0);
	            transform: translateY(0);
		  	}
		}
		@-webkit-keyframes signAni {
		  	0% {
		    	opacity: 0;
		    	-webkit-transform: scale(0.3) rotate(180deg);
	            transform: scale(0.3) rotate(180deg);
		  	}
		  	60% {
		    	-webkit-transform: scale(1.3);
	            transform: scale(1.3);
		  	}
		  	80% {
		    	-webkit-transform: scale(0.9);
	            transform: scale(0.9);
		  	}
		  	100% {
		    	opacity: 1;
		    	-webkit-transform: scale(1) rotate(0);
	            transform: scale(1) rotate(0);
		  	}
		}
		@keyframes signAni {
		  	0% {
		    	opacity: 0;
		    	-webkit-transform: scale(0.3) rotate(180deg);
	            transform: scale(0.3) rotate(180deg);
		  	}
		  	60% {
		    	-webkit-transform: scale(1.3);
	            transform: scale(1.3);
		  	}
		  	80% {
		    	-webkit-transform: scale(0.9);
	            transform: scale(0.9);
		  	}
		  	100% {
		    	opacity: 1;
		    	-webkit-transform: scale(1) rotate(0);
	            transform: scale(1) rotate(0);
		  	}
		}

		/*
		 * responsive design
		*/
		@media (min-width: 321px) and (max-width: 375px) {
			main, .wrapper {
				width: 100%;
    			height: 100%;
			    border: none;
    			box-shadow: none;
			}
			.header__wrapper {
				height: 300px;
			}
			.header {
			    width: 800px;
			    height: 760px;
			    left: -205px;
			}
			.header .sign {
	            height: 135px;
			    width: 135px;
			    bottom: 60px;
			    left: calc(50% - 75px);
			    box-shadow: 0 0 0 20px #ff8282, 0 0 0 40px #ffa2a2;
			}
			.red .sign:before, 
			.red .sign:after {
				height: 75px;
			    width: 10px;
			    top: calc(50% - 38px);
			    left: calc(50% - 4px);
			}

			.content {
			    position: absolute;
			    left: 50%;
			    top: 50%;
			    transform: translate(-50%, -50%);
			    width: 100%;
			}
			a {
				bottom: 5%;
			}
		}
		@media only screen and (max-width: 320px) {
			main, .wrapper {
				width: 100%;
    			height: 100%;
			    border: none;
    			box-shadow: none;
			}
			.header .sign {
			    left: calc(50% - 60px);
			}
			.content h1 {
				font-size: 2.5rem;
				margin-bottom: 0;
			}
			.content p {
			    font-size: 1.1rem;
    			line-height: 1.2;
			}
			a {
				bottom: 5%;
			}
		}
    </style>
	
</head>
<body>
	<main>
		<div class="wrapper red">
			<div class="header__wrapper">
				<div class="header">
					<div class="sign"><span></span></div>
				</div>
			</div>
			
			<div class="content">
				<h1>Oops!</h1>
				<p><?=$message?></p>
			</div>
		</div>
	</main>

</body>
</html>