<?php

  // is_blank('abcd')
  function is_blank($value='') {
    return empty($value);
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    $length = strlen($value);
    if(($length >= $options['max']) || ($length<=$options['min'])){
      return false;
    }
    return true;
  }

  //has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    if(!preg_match("/^[_a-z0-9]+(\.[_a-z0-9]+)*@[_a-z0-9]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $value)){
      return false;
    }
    else {
      return true;
    }
  }
  //has_valid_name
  function has_valid_name($value){
    if(!preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $value)){
      return false;
    }
    else{
      return true;
    }
  }

  //has_valid_username
  function has_valid_username($value) {
    if(!preg_match("/^[_A-Za-z0-9]+$/", $value)){
      return false;
    }
    else{
      return true;
    }
  }
  //check user exist
  function user_already_exist($db,$value){
    $sql = "SELECT userName From users WHERE userName=\"$value\";";
    $query = mysqli_query($db, $sql);
    if(mysqli_num_rows($query)>0){
      return true;
    }
    else{
      return false;
    }
  }

?>
