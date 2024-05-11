<?php

include 'components/connect.php';

session_start();

// Initialize user_id variable
$user_id = null;

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   // If user_id is not set in the session, set it to an empty string
   $user_id = '';
}

if(isset($_POST['send'])){
   // Retrieve user_id from the form
   $user_id = $_POST['user_id'];
   // Sanitize user_id input
   $user_id = filter_var($user_id, FILTER_SANITIZE_STRING);

   // Retrieve other form inputs
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   // Prepare and execute the SQL query
   $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
   $insert_message->execute([$user_id, $name, $email, $number, $msg]);

   // Check if the message was inserted successfully
   if($insert_message) {
      $message[] = 'Message sent successfully!';
   } else {
      $message[] = 'Failed to send message!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">

   <form action="" method="post">
      <h3>Get in touch.</h3>
      <!-- Add user_id input field -->
      <input type="text" name="user_id" placeholder="enter your id" required maxlength="20" class="box">
      <input type="text" name="name" placeholder="enter your name" required maxlength="20" class="box">
      <input type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
      <input type="number" name="number" min="0" max="9999999999" placeholder="enter your number" required onkeypress="if(this.value.length == 10) return false;" class="box">
      <textarea name="msg" class="box" placeholder="enter your message" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" name="send" class="btn">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
