<?php
  //Message Vars
  $msg = '';
  $msgClass = '';
  if(filter_has_var(INPUT_POST, 'submit')) {
    //Get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    //Check required fields
    if(!empty($email) && !empty($name) && !empty($message)) {
      //Passed
      //Check email
      if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $msg = 'Please use a valid email';
        $msgClass = 'alert-danger';
      } else {
        $toEmail = 'pol@polmilian.com';
        $subject = 'Contact Request From '.$name;
        $body = '<h2>Contact Request</h2>
                 <h4>Name</h4><p>'.$name.'</p>
                 <h4>Email</h4><p>'.$email.'</p>
                 <h4>Message</h4><p>'.$message.'</p> 
                ';
        //Email headers        
        $headers = "MIME-Version: 1.0" ."\r\n";
        $headers .="Content-Type:text/html;charset=UTF-8" . "\r\n";
        //Additional headers
        $headers .= "From:" .$name. "<".$email.">". "\r\n";
        
        if(mail($toEmail, $subject, $body, $headers)) {
          $msg = 'Your email has been sent';
          $msgClass = 'alert-success';
        } else {
          $msg = 'Your email was not sent';
          $msgClass = 'alert-success';
        }
      }
    } else {
      //Failed
      $msg = 'Please fill in all fields';
      $msgClass = 'alert-danger';
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Contact Form</title>
  <link rel="stylesheet" href="https://bootswatch.com/4/cosmo/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
  <h1 class="mb-4">PHP Form</h1>
  <?php if($msg != ''): ?>
    <div class="alert <?php echo $msgClass; ?>">
      <?php echo $msg; ?>
    </div>
  <?php endif; ?>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="form-group">
      <label>Name</label>
      <input type="text" class="form-control" name="name" value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="email" class="form-control" name="email" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
    </div>
    <div class="form-group">
      <label>Message</label>
      <textarea class="form-control" name="message"><?php echo isset($_POST['message']) ? $message : ''; ?></textarea>
    </div>
    <br>
    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
  </form>
</div>
 
</body>
</html>