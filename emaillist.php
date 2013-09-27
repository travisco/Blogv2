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
    
    <div class="mainPage" style="width:auto; margin-left:100px; display: inline-block;">
    <p>Please select the email address(s) you would like to remove.</p>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    
<?php

    include 'includes.php';

    
 if (isset($_POST['submit'])) {
    foreach ($_POST['todelete'] as $delete_id) {
        $emailstmt = $DBH->prepare("DELETE FROM newsletter_emails WHERE email_addr = :delete_id");
        $emailstmt->bindParam(':delete_id', $delete_id);
        $emailstmt->execute();
    } 

    echo 'Customer(s) removed.<br />';
  }
    
    $emaillist = $DBH->query("SELECT * FROM newsletter_emails");
    $emaillist->execute();
    
    $result = $emaillist->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($result as $row) {
        echo '<input type="checkbox" value="' . $row['email_addr'] . '" name="todelete[]" />';
        
        echo $row['name_first'];
        
        echo ' ' . $row['name_last'];
        
        echo ' &nbsp; &nbsp; || &nbsp; &nbsp;' . $row['email_addr'];
        
        echo '<br />';
    }
    
    $DBH = null;
?>
    <br />
    <input type="submit" name="submit" value="Remove" />
    </form>
</div>
</body>
</html>
