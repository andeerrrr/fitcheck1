<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <form action="login.php" method="post">
        <?php if(isset($_GET['error'])){ ?>
            <p class = "error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <label for="textbox"></label>
        <input type="text" name="uname" placeholder="Username" >
        <label for="textbox"></label>
        <input type="password" name="password" placeholder="Password">
        <button type = "submit">Log in</button>
        <a href="">Don't have an account?</a>
    </form>
</body>
</html>