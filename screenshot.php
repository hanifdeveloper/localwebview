<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Screenshot</title>
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/16117713bf.js"></script>
	<style>
		* {box-sizing: border-box}
		body {
			padding-top: 5rem;
		}
		.starter-template {
			padding: 3rem 1.5rem;
			text-align: center;
		}
		/* Container needed to position the overlay. Adjust the width as needed */
		.web-thumbnail{
			position: relative;
			padding: 4px;
			border: 1px solid #ddd;
			border-radius: 4px;
			margin-bottom: 10px;
		}
		.loader{
			width: 320px;
			height: 179px;
			background-image: url("https://cdnjs.cloudflare.com/ajax/libs/timelinejs/2.25/css/loading.gif");
			background-repeat: no-repeat;
			background-position: center;
		}
		/* Make the image to responsive */
		.image {
			display: block;
			width: 100%;
			height: auto;
		}
		/* The overlay effect - lays on top of the container and over the image */
		.caption {
			position: absolute;
			left: 0;
			top: 0;
			bottom: 0;
			background: rgb(0, 0, 0);
			background: rgba(0, 0, 0, 0.5); /* Black see-through */
			color: #f1f1f1;
			width: 100%;
			transition: .5s ease;
			opacity:0;
			color: white;
			font-size: 20px;
			padding: 20px;
			text-align: center;
		}
		.action {
			position: absolute;
			margin: 10px;
			display: none;
		}
		.action.demo {
			left: 0;
			bottom: 0;
		}
		.action.download {
			right: 0;
			bottom: 0;
		}
		/* When you mouse over the container, fade in the overlay title */
		.web-thumbnail:hover .caption {
			opacity: 1;
		}
		.web-thumbnail:hover .action {
			display: block;
		}
	</style>
</head>
<body>
	<?php
	$templateUrl = require_once 'database.php';
	// Get Screenshot via PHP
	function getScreenShootUrl($data){
		if(filter_var($data[1], FILTER_VALIDATE_URL)){
			// Google API Screen Shot
			$sc = file_get_contents('https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url='.$data[1].'&screenshot=true');
			$sc = json_decode($sc, true);
			$sc = $sc['screenshot']['data'];
			$sc = str_replace(array('_','-'), array('/','+'), $sc);
			echo '<div class="col-md-4">';
			echo '	<div class="web-thumbnail">';
			echo '		<a href="'.$data[1].'" target="_blank">';
			echo '			<img class="image img-responsive img-thumbnails" src="data:image/jpeg;base64,'.$sc.'" />';
			echo '			<div class="caption"><p>'.$data[0].'</p></div>';
			echo '		</a>';
			echo '	</div>';
			echo '</div>';
		}else{
			echo 'Not valid url';
		}
	}
	?>
	
	<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
		<a class="navbar-brand" href="#">Dashboard</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active"><a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a></li>
				<li class="nav-item"><a class="nav-link" href="#">Link</a></li>
				<li class="nav-item"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a></li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
					<div class="dropdown-menu" aria-labelledby="dropdown01">
						<a class="dropdown-item" href="#">Action</a>
						<a class="dropdown-item" href="#">Another action</a>
						<a class="dropdown-item" href="#">Something else here</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>

	<main role="main" class="container">
		<div class="starter-template">
			<h1>Bootstrap Online Shop Template</h1>
			<p class="lead">By Hanif Muhammad</p>
			<?php
			echo '<div class="container" style="margin: 10px;">';
			echo '	<div class="row">';
			foreach ($templateUrl as $key => $value) {
				// getScreenShootUrl($value);
				echo '<div class="col-md-4">';
				echo '	<div class="web-thumbnail" data-template="'.base64_encode(json_encode($value)).'">';
				echo '		<div class="loader"></div>';
				echo '	</div>';
				echo '</div>';
			}
			echo '	</div>';	
			echo '</div>';
			?>
		</div>
	</main>
	
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script>
		$(".web-thumbnail").each(function(key, value){
			console.log($(value).children(0).html());
			var template = JSON.parse(window.atob($(value).data("template")));
			var linkUrl = "https://www.googleapis.com/pagespeedonline/v2/runPagespeed?screenshot=true&url="+template[1];
			$.get(linkUrl, function(data){
				// Get the screenshot data.
				var screenshot = data.screenshot;
				// Convert the Google's Data to Data URI scheme.
				var imageData = screenshot.data.replace(/_/g, "/").replace(/-/g, "+");
				// Build the Data URI.
				var dataURI = "data:" + screenshot.mime_type + ";base64," + imageData;
				var content = $("<div>");
				$("<img>", {class: "image img-responsive img-thumbnails", src: dataURI}).appendTo(content);
				$("<span>", {class: "caption", html: "<p>"+template[0]+"</p>"}).appendTo(content);
				$("<a>", {class: "action demo btn btn-primary", href: template[1], target: "_blank", text: "Demo"}).appendTo(content);
				$("<a>", {class: "action download btn btn-success", href: "assets/"+template[2], text: "Download"}).appendTo(content);
				$(value).html(content);
			});		
		});
	</script>
</body>
</html>