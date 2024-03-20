<?php
session_start();
include 'functions.php';

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Get user's profile information
$user_id = $_SESSION['user_id'];
$user_info = getUserProfile($user_id);
$profile_picture = $user_info['profile_picture'];
$user_workouts = getUserWorkouts($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>User Profile</h2>
    
    <!-- Display profile picture -->
    <div class="profile-picture">
        <img src="<?php echo $profile_picture; ?>" alt="Profile Picture">
    </div>

    <!-- Display user's workouts -->
    <h3>Workouts Done:</h3>
    <ul>
        <?php foreach ($user_workouts as $workout) : ?>
            <li><?php echo $workout['workout_name']; ?></li>
        <?php endforeach; ?>
    </ul>

    <a href="index.php">Go Back to Dashboard</a>

</body>
</html>
