<?php
    include 'includes.php';
    
    $postviewsql = "SELECT * FROM blog_post WHERE id = :post_id LIMIT 1";
    $poststmt = $DBH->prepare($postviewsql);
    $poststmt->execute(array(':post_id' => $_GET['id']));
    
    
    if(!($poststmt->rowCount())) {
        echo 'Post #' . $_GET['id'] . ' not found';
        $DBH = null;
    }
    else
    {
        $blogPost = GetBlogPosts(":post_id","",$DBH);
            foreach ($blogPost as $post)
            {
                echo "<div class='post'>";
                echo "<h2>" . $post->title . "</h2>";
		$body = substr($post->post, 0, 300);
                echo "<span class='footer'>Posted By: " . $post->author . " Posted On: " . $post->datePosted . " Tags: " . $post->tags . "</span><br />";
		echo "<p>" . $body . "</p>";
                echo "</div><br /><br />";
            }
            $row = $poststmt->fetch(PDO::FETCH_ASSOC);
            echo '<h2>' . $row['title'] . '</h2>';
            echo '<em>Posted ' . date('F j<\s\up>S</\s\up>, Y', $row['date_posted']). '</em><br />';
            echo nl2br($row['post']). '<br />';
            echo '<a href="post_edit.php?id=' . $_GET["id"] . '>Edit</a> | <a href="post_delete.php?id=' . $_GET['id'] . '">Delete</a> | <a href="blogindex.php">View All</a>';
    }
   
    ?>