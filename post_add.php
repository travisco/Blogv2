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
    <link rel="stylesheet" type="text/css" href="css/jquery.tagsinput.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>
    
    <script src="js/jquery.tagsinput.js"></script>
    	<script type="text/javascript">
		function onAddTag(tag) {
			alert("Added a tag: " + tag);
		}
		function onRemoveTag(tag) {
			alert("Removed a tag: " + tag);
		}
		
		function onChangeTag(input,tag) {
			alert("Changed a tag: " + tag);
		}
		
		$(function() {

			$('#tags').tagsInput({width:'auto'});
			$('#tags_2').tagsInput({
				width: 'auto',
				onChange: function(elem, elem_tags)
				{
					var languages = ['php','ruby','javascript'];
					$('.tag', elem_tags).each(function()
					{
						if($(this).text().search(new RegExp('\\b(' + languages.join('|') + ')\\b')) >= 0)
							$(this).css('background-color', 'yellow');
					});
				}
			});
			$('#tags_3').tagsInput({
				width: 'auto',

				//autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
				autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
			});
			

// Uncomment this line to see the callback functions in action
//			$('input.tags').tagsInput({onAddTag:onAddTag,onRemoveTag:onRemoveTag,onChange: onChangeTag});		

// Uncomment this line to see an input with no interface for adding new tags.
//			$('input.tags').tagsInput({interactive:false});
		});
	
	</script>
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
        <h3>Raven Consulting - Add Blog Post</h3>
<?php
if(isset($_POST)){
//If the post is not empty, continue
    if(!empty($_POST)) {
        include 'includes.php';
        $sql = 'INSERT INTO blog_post (title,post,author_id,date_posted) VALUES (?,?,?,?)';
        $params = array($_POST['title'], $_POST['post'], $_POST['author'], time());
        $poststmt = $DBH->prepare($sql);
        $poststmt->execute($params);
         
        //Grab the new blog ID
        $blogPostId = $DBH->lastInsertId('blog_post');
           
        //Grab the tags and compare
        if(!empty($_POST['tags'])){
            //Select the tags from the database and store an id if found
            $sqlTag = 'SELECT id FROM tags WHERE name= ?';
            $tagstmt = $DBH->prepare($sqlTag);
            $tagString = str_replace(' ', '', strtolower($_POST['tags']));
            $tags = array();
            $tagPostition = 0;
                
            //Take the tag's from the form input and explode them into an array after each comma
            foreach (explode(',', $tagString) as $tag){
                $tagstmt->execute(array($tag));
                $tagId = $tagstmt->fetch(PDO::FETCH_COLUMN,0);
                $tagstmt->closeCursor();
   
                if (!$tagId){
                    $tagInputInsert = 'INSERT INTO tags SET name = :tag_name';
                    $inserttagstmt = $DBH->prepare($tagInputInsert);
                    $inserttagstmt->execute(array(':tag_name' => $tag));    
                    $newTagIds = $DBH->lastInsertId('tags');
                    $tags[] = $newTagIds;
 
                    //Insert tag and blog tag id into the blog_post_tags table
                    $blogTagNewInsert = 'INSERT INTO blog_post_tags (blog_post_id, tag_id) VALUES (:blog_post_id, :tag_id)';
                    $blogTagNewstmt = $DBH->prepare($blogTagNewInsert);
                    $blogTagNewstmt->execute(array(':blog_post_id' => $blogPostId, ':tag_id' => $tags[$tagPostition]));
                    $tagPostition++;
                    }
                else {
                    //If ID found insert into blog post
                    $blogTagInsert = 'INSERT INTO blog_post_tags (blog_post_id , tag_id) VALUES (:blog_post_id, :tag_id)';
                    $blogTagstmt = $DBH->prepare($blogTagInsert);
                    $blogTagstmt->execute(array(':blog_post_id' => $blogPostId, ':tag_id' => $tagId));
                }
            }
        }
     echo 'Entry posted. <a href="post_view.php?id='. $blogPostId .'">View</a>';
    }
} else {
        echo 'No Post';
    }
    
    
?>

<form name="blogPostAdd" method="post">
    <table>
        <tr>
            <td><label for="title" >Title:</label></td>
            <td><input name="title" id="title" style="width:20em;"/></td>
        </tr>
        <tr>
            <td><label for="author" >Author:</label></td>
            <td><select name="author" id="author">
            <?php
            include 'includes.php';
            
                $sql = "SELECT * FROM people";
                $stmt = $DBH->query($sql);
                $stmt->execute(array());
                foreach($stmt as $row) {
                    echo "<option value=" . $row['id'] . ">" . $row['first_name'] . " " . $row['last_name'] . "</option>"; 
                }
                $DBH = null;
            ?>
            </td>

        </tr>
        <tr>
            <td><label for="tags">Tags:</label></td>
            <td><input name="tags" id="tags" class="tags" style="width:20em;"/></td>
        </tr>
        <tr>
            <td><label for="post">Body:</label></td>
            <td><textarea name="post" id="post" style="width:30em; height:20em;"></textarea></td> 
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Post" /></td>
        </tr>
    </table>
</form>
        </div></div></body></html>