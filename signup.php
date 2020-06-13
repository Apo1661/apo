<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="scss/style.css" rel="stylesheet">
</head>
<body  class="main">

<div> 

<?php
    require"db.php";

    $data = $_POST;
    if( isset($data['do_signup'] ) )
    {
        //здесь регистрируем

        if( trim($data['login']) == '' )
        {
            $errors[] = '
            Enter login!';
        }

        if( trim($data['email']) == '' )
        {
            $errors[] = 'Enter Email!';
        }

        if( trim($data['password']) == '' )
        {
            $errors[] = 'Enter password';
        }

        if( trim($data['password_2']) != $data['password'] )
        {
            $errors[] = 'Password mismatch!';
        }

        if( R::count('users', "login = ?", array($data['login'])) > 0 )
        {
            $errors[] = 'This login is already taken!';
        }
        
        if( R::count('users', "email = ?", array($data['email'])) > 0 )

        {
            $errors[] = 'This email is already taken!';
        }

        if( empty($errors) )
        {
            //ok
            $user = R::dispense('users');
            $user->login = $data['login'];
            $user->email = $data['email'];
            $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
            R::store($user);
            echo '<div style="color:#000000 ;margin-left:700px;position:absolute; top:400px; font-size:40px;">You have successfully registered!</div>';
        }
        else
        {
            echo '<div style="color:red;margin-left:700px;position:absolute; top:400px; font-size:40px;" class="EnterLogin!">'.array_shift($errors).'</div>';
        }
        
    }
    

?>

<form action="/signup.php" method="POST">

<p>
  <p>  <strong class="login">Create a username:
</strong></p>
  <input type="text" name="login" value="<?php echo @$data['login'];?>"class="logininput" autofocus placeholder="Login">
</p>

<p>
  <p>  <strong class="account">Create an account:</strong></p>
  <input type="email" name="email" value="<?php echo @$data['email'];?> "  class="accountinput" autofocus placeholder="Account">
</p>

<p>
  <p>  <strong class="password">Pick a password:</strong></p>
  <input type="password" name="password" value="<?php echo @$data['password'];?>" class="passwordinput" autofocus placeholder="Password">
</p>

<p>
  <p>  <strong class="password_2">Confirm password:</strong></p>
  <input type="password" name="password_2" value="<?php echo @$data['password_2'];?>"  class="password_2input" autofocus placeholder="Repeat password" >
</p>

<p><button type="submit" name="do_signup" class="signup">Sign up
</button></p>

</form>
    </div>
</body>
</html>







