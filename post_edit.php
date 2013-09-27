<?php
    require_once('authorize.php');
?>
<?php
    
    include 'includes.php';
    
    $blogPost = GetBlogPosts($_GET['id'],"",$DBH);

                foreach ($blogPost as $post)
                {
                    echo "<div class='post'>";
                    echo "<h2>" . $post->title . "</h2>";
		    echo "<p>" . $post->post . "</p>";
                    echo "<span class='footer'><strong>Posted By:</strong> " . $post->author . " <strong>Posted On:</strong> " . $post->datePosted . " <strong>Tags:</strong> " . $post->tags .        "</span><br />";
                    echo "<a href='post_delete.php?id=" . $post->id . "'>Delete Post</a>";
                    echo '</div><br /><br />';
                }
                
    if (isset($_POST['submit'])) {
        if(!empty($_POST))
        {
            $poststmt = $DBH->prepare('UPDATE blog_post SET title=:titlePost, post=:bodyPost WHERE id=:idPost');
            $poststmt->execute(array(':titlePost'=> $post->title, ':bodyPost'=>$post->post, ':idPost'=>$post->id));
            redirect('post_view.php?id=' . $post->id);
        }
        else
        {
            echo "\nPDO::errorInfo();\n";
            print_r($DBH->errorInfo());
        }
    }
 
    elseif(!$blogPost) {
        echo 'Post #' . $post->id . ' Not Found';
        exit;
    }
    
    
    echo <<<HTML
    <form method="post">
        <table>
            <tr>
                <td><label for="title">Title</label></td>
                <td><input name="title" id="title" value="$post->title" style="width:20em;"/></td>
            <tr>
                <td><label for="body">Body</label></td>
                <td><textarea name="bodyPost" id="bodyPost" style="width:30em; height:20em;"/>$post->post</textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit"  name="submit" value="Save" /></td>
            </tr>
        </table>
    </form>
HTML;
?>