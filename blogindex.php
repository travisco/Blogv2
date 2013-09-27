<?php
    require_once('authorize.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd"
    >
<html lang="en">
<head>
    <title>Newsletter Email List</title>
    <link rel="stylesheet" type="text/css" href="css/adminmenu.css" />
</head>
<body>
  <div class="header" style="width:100%; height: 125px;">
            <div id="headerTop"><h2>Administration Page</h2></div>
            
            <ul class="menu">

                <li><a href="#">My dashboard</a></li>
                <li><a href = "newsletter.php">Newsletter</a></li>
                <li><a href="emaillist.php">Manage Email List</a></li>
                <li><a href = "blogindex.php">Blog</a></li>
                    <ul>
                        <li><a href="#" class="documents">Documents</a></li>
                        <li><a href="#" class="messages">Messages</a></li>
                        <li><a href="#" class="signout">Sign Out</a></li>
                    </ul>
                </li>
                <li><a href = "index.html">Back to Main Website</a></li>
            </ul>
        </div>
     <div class="mainPage">
        <h3>Raven Consulting - Blog Index</h3>
<?php
    include 'includes.php';
    
    echo '<h3>-----------------------------------------------------</h3>';
    $blogPosts = GetBlogPosts("","",$DBH);

                foreach ($blogPosts as $post)
                {
                    echo "<div class='post'>";
                    echo "<h2>" . $post->title . "</h2>";
		    $body = substr($post->post, 0, 300);
                    echo "<span class='footer'>Posted By: " . $post->author . " Posted On: " . $post->datePosted . " Tags: " . $post->tags . "</span><br />";
		    echo "<p>" . nl2br($body) . "...</p>";
                    echo "<a href='post_view.php?id=" . $post->id . "'>View Full Post</a><br /> ";
                    echo "<a href='post_edit.php?id=" . $post->id . "'>Edit Post</a> | ";
                    echo "<a href='post_delete.php?id=" . $post->id . "'>Delete Post</a>";
                    
                    echo "</div><br /><br />";
                }
                $DBH = null;
echo <<<HTML
<a href="post_add.php">+ New Post</a>
HTML;
?>
        </div>
    </div></body></html>