<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="UTF-8">
	
	<!-- Remove this line if you use the .htaccess -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="viewport" content="width=device-width">
	
	<title>BLOG // Raven-Consulting</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<link rel="shortcut icon" type="image/png" href="favicon.png">
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css">
	
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="http://code.jquery.com/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>')</script>
</head>


<body>
<!-- Prompt IE 7 users to install Chrome Frame -->
<!--[if lt IE 8]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

<div class="container">

<header id="navtop">
		<a href="index.html" class="logo fleft"><img src="img/logo.png" alt="Raven-Consulting"></a>
		<nav class="fright">
		<ul>
				<li><a href="index.html">Home</a></li>
		</ul>
		<ul>
            	<li>
				<a href="services.html">Services</a>
		</li>
		</ul>
		<ul>
				<li>
						<a href="blog.html" class="navactive">Blog</a>
				</li>
		</ul>
		<ul>
				<li>
						<a href="contact.html">Contact</a>
				</li>
		</ul>
		</nav>
</header>


	<div class="blog-page main grid-wrap">

		<header class="grid col-full">
			<hr>
			<p class="fleft">Blog</p>
		</header>

				
		<section class="grid col-three-quarters mq2-col-two-thirds mq3-col-full">
<?php
		include "includes.php";   
						

				
		$blogPosts = GetBlogPosts("","",$DBH);

                foreach ($blogPosts as $post)
                {
                    echo "<div class='post'>";
                    echo "<h2>" . $post->title . "</h2>";
		    $body = substr($post->post, 0, 300);
		    echo "<p>" . nl2br($body) . "... <a href='post_view.php?id=" . $post->id . "'>View Full Post</a><br /></p>";
                    echo "<span class='footer'><strong>Posted By:</strong> " . $post->author . " <strong>Posted On:</strong> " . $post->datePosted . " <strong>Tags:</strong> " . $post->tags . "</span><br />";
                    echo "</div>";
                }
		
?>	
		</section>
	


		<aside class="grid col-one-quarter mq2-col-one-third mq3-col-full blog-sidebar">
			<div class="widget">
				<h2>Newsletter Sign Up</h2>
				<form method="post" action="addemail.php">
						<ul>
								<li>
										<label for="firstname">First Name:</label>
										<input id="firstname" type="text" name="firstname"  required class="required"/>
								</li>
								<li>
										<label for="lastname">Last Name:</label>
										<input id="lastname" type="text" name="lastname" required class="required"/>
								</li>
								<li>
										<label for="emailaddr">Email:</label>
										<input id="emailaddr" type="email" name="emailaddr" placeholder="JohnDoe@gmail.com" class="required email" />
								</li>
								<input id="newsbutton" type="submit" name="Submit" value="Signup">
						</ul>
				</form>
			</div>


			
			
			
				<div class="widget">
		<?php
				
				echo '<h2>Tags</h2>';
				echo '<ul>';
				getTagCount($DBH);
				echo '</ul>';
				$DBH = null;
		?>
			</div>
		</aside>

		
		
		
	</div> <!--main-->

<div class="divide-top">
	<footer class="grid-wrap">
		<ul class="grid col-one-third social">
			<li><a href="https://twitter.com/RavenAssociates">Twitter</a></li>
			<li><a href="http://www.linkedin.com/profile/view?id=97848519&trk=nav_responsive_tab_profile">LinkedIn</a></li>
		</ul>
	
		<div class="up grid col-one-third ">
			<a href="#navtop" title="Go back up">&uarr;</a>
		</div>
		
		<nav class="grid col-one-third ">
			<ul>
				<li><a href="index.html">Home</a></li>
				<li><a href="services.html">Services</a></li>
				<li><a href="blog.html">Blog</a></li>
				<li><a href="contact.html">Contact</a></li>
				<li><a href="adminpage.php">Admin</a></li>
			</ul>
		</nav>
	</footer>
</div>

</div>

<!-- Javascript - jQuery -->
<script src="http://code.jquery.com/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>')</script>

<!--[if (gte IE 6)&(lte IE 8)]>
<script src="js/selectivizr.js"></script>
<![endif]-->

<script src="js/scripts.js"></script>

</body>
</html>