<?php
    $conn = mysqli_connect("localhost","root","","andyPost") or die ('cannot connect to database' . mysqli_error());
    session_start(); 
    if (!isset($_SESSION['email'])) {
        $_SESSION['msg'] = "You must log in first";
        ?>
            <script type="text/javascript">
                window.location = 'login.php';
            </script>
        <?php
    }else{
        $email=$_SESSION['email'];
        $member_query = mysqli_query($conn,"SELECT * from accounts where email = '$email'")or die(mysqli_error());
        $member_row = mysqli_fetch_array($member_query);
        $username = $member_row['username'];
        $user_id = $member_row['id'];
        $regdate = $member_row['date'];
    }
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['email']);
        ?>
            <script type="text/javascript">
                window.location = 'login.php';
            </script>
        <?php
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>AndyPost</title>
        <link rel="stylesheet" type="text/css" href="assets/styles.css">
    </head>
    <body>
        <div class="header">
            <h2>Home Page</h2>
        </div>
        <div class="content">
            <!-- notification message -->
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="error success" >
                    <h3>
                        <?php 
                            echo $_SESSION['success']; 
                            unset($_SESSION['success']);
                        ?>
                    </h3>
                </div>
            <?php endif ?>
            <?php  if (isset($_SESSION['email'])) : ?>
                <p>
                    Welcome 
                    <strong>
                        <?php echo $username; ?>
                    </strong> | 
                    <a href="index.php?logout='1'" style="color: red;">
                         logout
                    </a> 
                </p>
            <?php endif ?>
            <br><hr>
            <form method="post" style="width: 80%; border: none;"> 
                <div class="input-group">
                    <label>Post Title</label>
                    <input type="text" name="post_title" placeholder="Post Title" required>
                </div>
                <div class="input-group">
                    <label>Post content</label>
                    <textarea name="post_content" style="" placeholder="Post content" required style="resize: none;"></textarea>
                </div>                
                <br>
                <div class="input-group">
                    <button type="submit" class="btn" name="post">
                        Post
                    </button>
                </div>
                <hr>
            </form>
            <?php   
                $query = mysqli_query($conn,"SELECT *,UNIX_TIMESTAMP() - date_created AS TimeSpent from post LEFT JOIN accounts on accounts.id = post.user_id order by post_id DESC")or die(mysqli_error());
                while($post_row=mysqli_fetch_array($query)){
                $post_id = $post_row['post_id'];    
                $user_id = $post_row['user_id'];   
                $posted_by = $post_row['username'];
            ?>
            <div style="border: .5px solid #00000070; padding: 10px; border-radius: 10px; margin-bottom: 10px;">
                <h3>
                    <?php echo $post_row['post_title']; ?>
                </h3>
                <article>
                    <?php echo $post_row['content']; ?>
                </article>
                <footer>
                    <small>
                        <hr>
                        Posted by: <a href="#"> <?php echo $posted_by; ?></a> | 
                        <?php
                        $days = floor($post_row['TimeSpent'] / (60 * 60 * 24));
                        $remainder = $post_row['TimeSpent'] % (60 * 60 * 24);
                        $hours = floor($remainder / (60 * 60));
                        $remainder = $remainder % (60 * 60);
                        $minutes = floor($remainder / 60);
                        $seconds = $remainder % 60;
                        if($days > 0)
                            echo date('F d, Y - H:i:sa', $post_row['date_created']);
                        elseif($days == 0 && $hours == 0 && $minutes == 0)
                            echo "A few seconds ago";       
                        elseif($days == 0 && $hours == 0)
                            echo $minutes.' minutes ago';
                    ?>
                    </small>
                </footer>
            </div>
            <?php 
                }
            ?>
            <?php
                if (isset($_POST['post'])){
                    $post_title  = $_POST['post_title'];
                    $post_content  = $_POST['post_content'];

                    mysqli_query($conn,"INSERT into post (post_title,content,date_created,user_id) values ('$post_title','$post_content','".strtotime(date("Y-m-d h:i:sa"))."','$user_id') ")or die(mysqli_error());
                    ?>
                        <script type="text/javascript">
                            window.location = 'index.php';
                        </script>
                    <?php
                }
            ?>
        </div>
    </body>
</html>