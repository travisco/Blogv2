<?php

$config['db'] = array(
        'host'          => 'localhost',
        'username'      => '',
        'password'      => '',
        'dbname'        => 'nettuts_blog'
    );


    try {
        $DBH = new PDO('mysql:host=' . $config['db']['host']. ';dbname=' .$config['db']['dbname'], $config['db']['username'], $config['db']['password']);
        $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $DBH->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $DBH->exec('SET CHARACTER SET utf8');
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

    
function redirect($uri) {
        header('location:'.$uri);
        exit;
    }
    
    
function GetBlogPosts($inId=null, $inTagId=null, $DBH)
{
    if (!empty($inId))
    {
        $blogstmt = $DBH->prepare("SELECT * FROM blog_post WHERE id = :blog_id ORDER BY id DESC");
        $blogstmt->bindParam(":blog_id", $inId, PDO::PARAM_INT);
        $blogstmt->execute();
        
    }
    else if(!empty($inTagId))
    {
        $blogstmt = $DBH->prepare("SELECT blog_post.* FROM blog_post_tags LEFT JOIN (blog_post) ON (blog_post_tags.blog_post_id = blog_post.id) WHERE blog_post_tags.tagID = :tag_id ORDER BY blog_post.id DESC");
        $blogstmt->bindParam(":tag_id", $inTagId, PDO::PARAM_INT);
        $blogstmt->execute();
    }
    else
    {
        $blogstmt = $DBH->query("SELECT * FROM blog_post ORDER BY id DESC");
    }

    $postArray = array();
    
    $results = $blogstmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($results as $row){
        $myPost = new BlogPost($row["id"], $row['title'], $row['post'], $row['author_id'], $row['date_posted'], $DBH);
        array_push($postArray, $myPost);
    }
        return $postArray;
}


function getTagCount($DBH) {
    
    //Make the connection and grab all the tag's TAG TABLE HAS TWO FIELDS id and name
            $stmt = $DBH->query("SELECT * FROM tags");
            $stmt->execute();
            
            //For each row pulled do the following
            foreach ($stmt->fetchAll() as $row){
                //set the tagId and tagName to the id and name fields from the tags table
                $tagId = $row['id'];
                $tagName = ucfirst($row['name']);
                
                //Next grab the list of used tags BLOG_POST_TAGS TABLE HAS TWO FILEDS blog_post_id and tag_id
                $stmt2 = $DBH->query("SELECT count(*) FROM blog_post_tags WHERE tag_id = " . $tagId);
                $stmt2->execute();
                $tagCount = $stmt2->fetchColumn();
                
                //Print the following list 
                echo '<li><a href="popular_tags.php?=' . $tagId . '" title="' . $tagName . '">' . $tagName . '(' . $tagCount . ')</a></li>';
            //End of loop - start again
            }
            
}

    
    
class BlogPost {
        public $id;
        public $title;
        public $post;
        public $author;
        public $tags;
        public $datePosted;
        public $comments;
        
        


        function __construct($inId=null, $inTitle=null, $inPost=Null, $inAuthorId=null, $inDatePosted=null, $DBH)
        {
            if (!empty($inId))
            {
                $this->id = $inId;
            }
            if (!empty($inTitle))
            {
                $this->title = $inTitle;
            }
            if (!empty($inPost))
            {
                $this->post = $inPost;
            }

            if(!empty($inDatePosted))
            {
                
                $this->datePosted = gmdate('F j, Y, g:i a', $inDatePosted);
            }

            if(!empty($inAuthorId))
            {
                
                $authorstmt = $DBH->prepare("SELECT first_name, last_name FROM people WHERE id = :author_id");
                $authorstmt->bindParam(':author_id', $inAuthorId);
                $authorstmt->execute();
                $row = $authorstmt->fetch(PDO::FETCH_ASSOC);
                $this->author = ucfirst($row["first_name"]) . " " . ucfirst($row["last_name"]);
            }

            $postTags = "No Tags";
            if (!empty($inId))
            {
                
                $tagstmt = $DBH->prepare("SELECT tags.* FROM blog_post_tags LEFT JOIN (tags) ON (blog_post_tags.tag_id = tags.id) WHERE blog_post_tags.blog_post_id = :post_id");
                $tagstmt->bindParam(":post_id", $inId);
                $tagstmt->execute();
                $tagArray = array();
                $tagIDArray = array();
                
                while($row = $tagstmt->fetch(PDO::FETCH_ASSOC))
                {
                    array_push($tagArray, ucfirst($row["name"]));
                    array_push($tagIDArray, $row["id"]);
                }
                if (sizeof($tagArray) > 0)
                {
                    foreach ($tagArray as $tag)
                    {
                        if ($postTags == "No Tags")
                        {
                            $postTags = $tag;
                        }
                        else
                        {
                            $postTags = $postTags . ", " . $tag;
                        }
                    }
                }
            }
            $this->tags = $postTags;
            

        }
    }
    
    function emailVerify($email_address, $DBH)
    {
        $sql = "SELECT COUNT(*) FROM newsletter_emails WHERE email_addr = :email_address";
        $params = array(':email_address' => $email_address);
        $stmt = $DBH->prepare($sql);
        if ($stmt->execute($params)) {
            if ($stmt->fetchColumn() > 0) {
                return true;
            }
            else {
                return false;
            }
        }
        
        
    }

?>

