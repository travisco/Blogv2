<?php
    require_once('authorize.php'); 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd"
    >
<html lang="en">
<head>
    <title>Newsletter Send</title>
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
        <h3>Raven Consulting - Send Newsletter</h3>
    <form method="post" action="sendnewsletter.php">
        <label for="subject">&nbsp; &nbsp; Subject:</label>
        <input type="text" id="subject" name="subject" size="60" /><br /><br />
        <label for="newsletterBody" >Message:</label>
        <textarea id="newsletterBody" name="newsletterBody" rows="8" cols="60"></textarea><br />
        <br />
        <input id="submitForm" type="submit" name="submit" value="submit" />
    </form>
</div>
</body>
</html>
