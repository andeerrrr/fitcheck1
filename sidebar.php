<?php
include 'config.php';

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];

    $profile_picture_query = "SELECT profile_picture FROM users WHERE username = '$username' ";
    $profile_picture_result = $conn->query($profile_picture_query);

    if ($profile_picture_query->num_rows > 0){
        $row = $profile_picture_result ->fetch_assoc();
        $profile_picture_url = $row['profile_picture'];
    } else{
        $profile_picture_url = "images/pfp/default_pfp.jpg";

    }
} else{
    $profile_picture_url = "images/pfp/default_pfp.jpg";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sidebar_styles.css">
    <title>Side Menu Bar</title>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="logo.png" alt="Site Logo">
            <h1>Site Name</h1>
        </div>
        <ul class="menu">
            <li><a href="home.php">Home</a></li>
            <li><a href="index.php">Routines</a></li>
            <li><a href="exercises.php">Exercises</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
        <div class="footer">
            <img src="<?php echo $profile_picture_url; ?>" alt="Profile Picture">
            <a href="logout.php"><img src="images/logout.png" alt="Logout"></a>
        </div>
    </div>
</body>
</html>
