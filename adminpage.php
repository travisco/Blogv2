<?php
    require_once('authorize.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd"
    >
<html lang="en">
<head>
    <title>Admin Page</title>
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
        <h3>Raven Consulting - Admin Page</h3>
    </div>
   
</body>
</html>