<?php
    require_once('authorize.php');
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd"
    >
<html lang="en">
<head>
    <title>Newsletter List</title>
    <link rel="stylesheet" type="text/css" href="css/adminmenu.css" />
</head>
<body>
    <div style="width: 100%;">
        <div class="header" style="width:100%; height:190px;">
            <img src="img/logo.png" style="float: left;"><h2 style="float: left; text-align: center;">Administration Page - Raven-Consulting</h2>
        </div>
        <div class="sidemenu" style="width:20%; height:400px; float: left; margin-right: 100px;" >
            <div class = "container">
                <ul class = "nice-menu">
                    <li class = "orange" id="home"><a href = "#">Home</a></li>
                    <li class = "red" id="manEmail"><a href = "emaillist.php">Manage Emails</a></li>
                    <li class = "green" id="newsLett"><a href = "newsletter.php">Newsletter</a></li>
                    <li class = "blue" id="blog"><a href = "#">Blog</a></li>
                    <li class = "bright" id="returnSite"><a href = "index.html">Back to Website</a></li>
                </ul>
            </div>
        </div>
    
    <div class="mainPage" style="width:auto; margin-left:100px;">
<?php

include 'connect.php';

    if (isset($_POST['submit'])) {
    $from = 'rwoodrume@yahoo.com';
    $subject = $_POST[subject];
    $text = $_POST['newsletterBody'];
    $output_form = false;
    
    if(empty($subject) && empty($newsletterBody)){
        echo 'You forgot the email subject and body. <br />';
        $output_form = true;
    }
    if(empty($subject) && (!empty($newsletterBody))) {
        echo 'You forgot the subject. <br />';
        $output_form = true;
    }
    if((!empty($subject)) && empty($newsletterBody)) {
        echo 'You forgot the newsletter body. <br />';
        $output_form = true;
    }
    if((!empty($subject)) && (!empty($newsletterBody))){
    
        $STH = $DBH->query('SELECT * FROM newsletter_info');
        $STH->setFetchMode(PDO::FETCH_ASSOC);
    
         while($row = $STH->fetch()) {
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
        
            $msg = "Dear $first_name $last_name, \n $text";
        
            $to = $row['email'];
        
            mail($to, $subject, $msg, 'From:' . $from);
        
            echo 'Email sent to: ' . $to . '<br />';
        }
    
        $DBH = null;
        }
        else {
            $output_form = true;
        }
        if($output_form) {
    ?>

        <form method="post" action="sendemail.php">
            <label for="subject">Subject of Email:</label><br />
            <input id="subject" name="subject" type="text" size="30" /><br />
            <label for="newsletterBody">Body of the Newsletter:</label><br />
            <textarea id="newsletterBody" name="newsletterBody" rows="8" cols="40"></textarea><br />
            <input type="submit" name="Submit" value="Submit" />
        </form>

    
?>

<?php
    }
?>
    </div>
</body>
</html>