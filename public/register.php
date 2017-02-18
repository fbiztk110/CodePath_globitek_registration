<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
  $firstName = $lastName = $eMail = $userName = "";
  // if this is a POST request, process the form
  // Hint: private/functions.php can help

$errors = [];
  if(is_post_request()){
    // Confirm that POST values are present before accessing them.

    if(is_blank($_POST['firstName'])){
      $errors[] = "First name cannot be blank.";
    }
    else{
      $firstName = $_POST['firstName'];
      if(!has_length($_POST['firstName'],['min' => 2, 'max' => 255])){
        $errors[] = "First name must between 2 and 255 characters.";
      }
      if(!has_valid_name($firstName)){
        $errors[] = "First name could only contain letters, spaces, symbols: - , . '";
      }
    }
    if(is_blank($_POST['lastName'])){
      $errors[] = "Last name cannot be blank.";
    }
    else{
      $lastName = $_POST['lastName'];
      if(!has_length($_POST['lastName'],['min' => 2, 'max' => 255])){
        $errors[] = "Last name must be between 2 and 255 characters.";
      }
      if(!has_valid_name($lastName)){
        $errors[] = "Last name could only contain letters, spaces, symbols: - , . '";
      }
    }
    if(is_blank($_POST['eMail'])){
      $errors[] = "Email cannot be blank.";
    }
    else{
      $eMail = $_POST['eMail'];
      if(!has_valid_email_format($eMail)){
        $errors[] = "Email must be a valid format, could only contain letters, numbers, sybmols: _@";
      }
    }
    if(is_blank($_POST['userName'])){
      $errors[] = "Username cannot be blank.";
    }
    else{
      $userName = $_POST['userName'];
      if(!has_length($_POST['userName'],['min' => 7, 'max' => 255])){
        $errors[] = "Username must be at least 8 characters. --";
      }
      if(!has_valid_username($userName)){
        $errors[] = "Username could only contain letters, numbers, symbol: _";
      }
      if(user_already_exist($db,$userName)){
        $errors[] = $userName ." is already exist, please choose a new username";
      }
    }

    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // if there were no errors, submit data to database
    if(empty($errors)){
      // Write SQL INSERT statement
      // $sql = "INSERT INTO users (first_name, last_name, email, username，created_at)
      // VALUES ($firstName, $lastName,$eMail, $userName, NOW());";
      $sql = "INSERT INTO users "
          . "(first_name, last_name, email, username, created_at) VALUES"
          . "(\"$firstName\", \"$lastName\", \"$eMail\", \"$userName\", NOW());";
      // For INSERT statments, $result is just true/false
      $result = db_query($db, $sql);
      if($result) {
        db_close($db);
        // TODO redirect user to success page
        redirect_to("registration_success.php");
        exit;
      }
      else {
        // The SQL INSERT statement failed.
        // Just show the error, not the form
          echo db_error($db);
          db_close($db);
          exit;
      }
    }
  }
?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
     echo display_errors($errors);
  ?>

  <!-- TODO: HTML form goes here -->

  <form action="register.php" method="post">

    First name:<br>
    <input type="text" name="firstName" value="<?php echo $firstName; ?>"/><br />
    Last name:<br>
    <input type="text" name="lastName" value="<?php echo $lastName; ?>"/><br />
    Email:<br>
    <input type="text" name="eMail" value="<?php echo $eMail; ?>"/><br />
    Username:<br>
    <input type="text" name="userName" value="<?php echo $userName; ?>"><br />
    <br /><input type="submit" value="Submit" />
  </form>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
