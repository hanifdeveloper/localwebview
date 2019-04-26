<!DOCTYPE html>
<html lang="en">
<head>
<title>Local Web View</title>
</head>
<body>
<style>
/* Variables */
:root {
	--thumbnail-width: 1280px;
	--thumbnail-height: 720px;
	--thumbnail-zoom: 0.23;
}

/* Basic CSS Reset */
* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
}

/* Demo-specific styling */
body {
	text-align: center;
	margin-top: 50px;
}

/* This container helps the thumbnail behave as if it were an unscaled IMG element */
.thumbnail-container {
	width: calc(var(--thumbnail-width) * var(--thumbnail-zoom));
	height: calc(var(--thumbnail-height) * var(--thumbnail-zoom));
	display: inline-block;
	overflow: hidden;
	position: relative;
	background: #f9f9f9;
	margin: 10px;
	/* margin-top: 0px; */
	float: left;
}

/* Image Icon for the Background */
.thumbnail-container::before {
	position: absolute;
	left: 45%;
	top: 40%;
	opacity: 0.2;
	display: block;
	-ms-zoom: 1;
	-o-transform: scale(2);
	-moz-transform: scale(2);
	-webkit-transform: scale(2);
	content: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDMyIDMyIiBoZWlnaHQ9IjMycHgiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMycHgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxnIGlkPSJwaG90b18xXyI+PHBhdGggZD0iTTI3LDBINUMyLjc5MSwwLDEsMS43OTEsMSw0djI0YzAsMi4yMDksMS43OTEsNCw0LDRoMjJjMi4yMDksMCw0LTEuNzkxLDQtNFY0QzMxLDEuNzkxLDI5LjIwOSwwLDI3LDB6ICAgIE0yOSwyOGMwLDEuMTAyLTAuODk4LDItMiwySDVjLTEuMTAzLDAtMi0wLjg5OC0yLTJWNGMwLTEuMTAzLDAuODk3LTIsMi0yaDIyYzEuMTAyLDAsMiwwLjg5NywyLDJWMjh6IiBmaWxsPSIjMzMzMzMzIi8+PHBhdGggZD0iTTI2LDRINkM1LjQ0Nyw0LDUsNC40NDcsNSw1djE4YzAsMC41NTMsMC40NDcsMSwxLDFoMjBjMC41NTMsMCwxLTAuNDQ3LDEtMVY1QzI3LDQuNDQ3LDI2LjU1Myw0LDI2LDR6ICAgIE0yNiw1djEzLjg2OWwtMy4yNS0zLjUzQzIyLjU1OSwxNS4xMjMsMjIuMjg3LDE1LDIyLDE1cy0wLjU2MSwwLjEyMy0wLjc1LDAuMzM5bC0yLjYwNCwyLjk1bC03Ljg5Ni04Ljk1ICAgQzEwLjU2LDkuMTIzLDEwLjI4Nyw5LDEwLDlTOS40NCw5LjEyMyw5LjI1LDkuMzM5TDYsMTMuMDg3VjVIMjZ6IE02LDE0LjZsNC00LjZsOC4wNjYsOS4xNDNsMC41OCwwLjY1OEwyMS40MDgsMjNINlYxNC42eiAgICBNMjIuNzQsMjNsLTMuNDI4LTMuOTU1TDIyLDE2bDQsNC4zNzlWMjNIMjIuNzR6IiBmaWxsPSIjMzMzMzMzIi8+PHBhdGggZD0iTTIwLDEzYzEuNjU2LDAsMy0xLjM0MywzLTNzLTEuMzQ0LTMtMy0zYy0xLjY1OCwwLTMsMS4zNDMtMywzUzE4LjM0MiwxMywyMCwxM3ogTTIwLDhjMS4xMDIsMCwyLDAuODk3LDIsMiAgIHMtMC44OTgsMi0yLDJjLTEuMTA0LDAtMi0wLjg5Ny0yLTJTMTguODk2LDgsMjAsOHoiIGZpbGw9IiMzMzMzMzMiLz48L2c+PC9zdmc+");
}

/* This is a masking container for the zoomed iframe element */
.thumbnail {
  -ms-zoom: var(--thumbnail-zoom);
  -moz-transform: scale(var(--thumbnail-zoom));
  -moz-transform-origin: 0 0;
  -o-transform: scale(var(--thumbnail-zoom));
  -o-transform-origin: 0 0;
  -webkit-transform: scale(var(--thumbnail-zoom));
  -webkit-transform-origin: 0 0;
}

/* This is our screen sizing */
.thumbnail, .thumbnail iframe {
	width: var(--thumbnail-width);
	height: var(--thumbnail-height);
	overflow: hidden;
}

/* This facilitates the fade-in transition instead of flicker. It also helps us maintain the illusion that this is an image, since some webpages will have a preloading animation or wait for some images to download */
.thumbnail iframe {
	opacity: 0;
	transition: all 300ms ease-in-out;
}

/* This pseudo element masks the iframe, so that mouse wheel scrolling and clicking do not affect the simulated "screenshot" */
.thumbnail:after {
	content: "";
	display: block;
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
}

.bottomleft {
  position: absolute;
  bottom: 8px;
  left: 16px;
  font-size: 18px;
}
</style>
<?php
define('ROOT', dirname(__FILE__) . '/');
$files = getDirContents(ROOT);
echo '<h1>LOCAL WEBVIEW</h1>';
echo '<div style="text-align: center;">';
foreach ($files as $key => $value) {
	$documentation = preg_match('/documentation\b/i', $value);
	$indexHtml = preg_match('/index.html\b/i', $value);
	if(!$documentation && $indexHtml){
		$url = explode(ROOT, $value);
		$link = end($url);
		$label = explode('/', $link);
		echo '<a href="'.$link.'" target="_blank" title="'.reset($label).'">';
		echo '<div class="thumbnail-container">';
		echo '<div class="thumbnail">';
		echo '<iframe src="'.$link.'" frameborder="0" scrolling="no" onload="this.style.opacity = 1"></iframe>';
		echo '</div>';
		echo '</div>';
		echo '</a>';
	}
}
echo '<div>';

function getDirContents($path) {
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
    $files = array(); 
    foreach ($rii as $file) if (!$file->isDir()) $files[] = $file->getPathname();
    return $files;
}

function output($value){
	echo '<pre>';
	print_r($value);
	echo '</pre>';
}
?>
</body>
</html>