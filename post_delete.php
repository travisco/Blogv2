<?php
    require_once 'authorize.php';
?>
<?php
    include 'includes.php';
    
    $sqlPostDelete = 'DELETE FROM blog_post WHERE id=:post_id LIMIT 1';
    
    $sqlTagDelete = 'DELETE FROM blog_post_tags WHERE blog_post_id=:post_id';
    
    
    try {
        $stmtdelete = $DBH->prepare($sqlDelete);
        $stmtdelete->execute(array(':post_id'=>$_GET['id']));
       
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
        die();
    }
    
    redirect('blogindex.php');
?>