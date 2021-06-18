<?php
    include 'server.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>AndyPost | Register</title>
        <link rel="stylesheet" type="text/css" href="assets/styles.css">
    </head>
    <body>
        <div class="header">
            <h2>Register</h2>
        </div>
        <form method="post" action="signup.php">
            <?php include('errors.php'); ?>
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="passwordOne">
            </div>
            <div class="input-group">
                <label>Confirm password</label>
                <input type="password" name="passwordTwo">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="regBtn">Register</button>
            </div>
            <p>
                Already a member? 
                <a href="login.php">Sign in</a>
            </p>
        </form>
    </body>
</html>