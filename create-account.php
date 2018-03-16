<?php
  include('classes/DB.php');
//   include('classes/Mail.php');

//variables
$type = "";
if(isset($_POST['member'])){
  $type = $_POST['member'];

}

  if(isset($_POST['create_acc'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $admin_no = $_POST['admission_number'];


  if(!DB::query('SELECT username FROM users WHERE username = :username', array(':username'=>$username))){
    if(strlen($username)>=4 && strlen($username)<=32){
        if (preg_match('/[a-zA-z0-9_]+/', $username)) {
          if(filter_var($email,FILTER_VALIDATE_EMAIL)) {
            if(!(DB::query('SELECT email FROM users WHERE email=:email',array(':email'=>$email)))){

            if (strlen($password)>=6 && strlen($password)<=60) {
              DB::query('INSERT INTO users (username,password,email) VALUES (:username,:password,:email)',array(':username'=>$username,':password'=>password_hash($password,PASSWORD_BCRYPT),':email'=>$email));
              //Mail::sendMail('Welcome to Sambandh Matrimony', 'Your account has been created!', $email);
              echo "success";
            }
            else {
              echo "invalid password length";
            }
          }
          else {
            echo "email address already exist";
          }

        }
        else {
          echo "invalid email";
        }
      }

        else {
          echo "invalid username";
        }
      }
      else {
        echo "username length should be 4-32";
      }
    }
  else {
    echo "user already exist!";
  }
}
?>
<h1>Register</h1>
<form class="" action="create-account.php" method="post"><p />
    <select name="member" id="">
        <option disabled selected value> -- select an option -- </option>
        <option value="student">Student</option>
        <option value="Company">Company</option>
        <option value="Staff">Staff</option>
    </select>
  <input type="text" name="username" placeholder="Username ..."><p />
  <?php if($type=='Student') {echo '<input type="text" name="admission_number" placeholder="Admission No ..."><p />';}
    else if($type=='Staff') {echo '<input type="text" name="staffID" placeholder="Staff id ..."><p />';}
  ?>
  <!-- <input type="text" name="admission_number" placeholder="Admission No ..."><p /> -->
  <input type="password" name="password" placeholder="Password ..."><p />
  <input type="email" name="email" placeholder="email@ddress ..."><p />
  <input type="submit" name="create_acc" value="Create Account">
</form>


// TODO Create a validation for duplicate email using queries
