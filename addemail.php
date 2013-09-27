<?php
  include 'includes.php';

  $name_first = Trim(stripslashes($_POST['firstname']));
  $name_last = Trim(stripslashes($_POST['lastname']));
  $email_address = Trim(stripslashes($_POST['emailaddr']));
  
  //Validation
  $validationOK=true;
        if (!$validationOK) {
            echo "Error";
            exit;
        }

        $queryEmailCheck = emailVerify($email_address, $DBH);
        
        if(!$queryEmailCheck) {
            $query = "INSERT INTO newsletter_emails (name_first, name_last, email_addr) VALUES (:first_name, :last_name, :email_address)";
            $params = array(
              ':first_name' => $name_first,
              ':last_name' => $name_last,
              ':email_address' => $email_address
            );
            $stmt = $DBH->prepare($query);
            $stmt->execute($params);
            echo 'Customer added.';
                
            }  
        else {
            echo 'Email address already signed up!';
        }
    


  $DBH = null;
?>