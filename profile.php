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

    <nav id="navbar">
        <header>
            <span>
                <img id="logo" src="Assets/logo.png">
            </span>
        </header>

        <div class="menu">
            <ul>
                <li>
                    <a href="#">
                        <div class="hover"></div>
                        <img src="Assets/home-icon.png">
                        <span>Feed</span>
                    </a>
                </li><br>
                <li>
                    <a href="#">
                        <div class="hover" id="workout"></div>
                        <img src="Assets/workout-icon.png">
                        <span>Workout</span>
                    </a>
                </li><br>
                <li>
                    <a href="#">
                        <div class="hover" id="exercises"></div>
                        <img src="Assets/exercise-icon.png">
                        <span>Exercises</span>
                    </a>
                </li><br>
                <li>
                    <a href="#">
                        <div class="active"></div>
                        <img src="Assets/profile-icon.png">
                        <span>Profile</span>
                    </a>
                </li><br>
            </ul>
        </div>

        <div id="bottom">
            <br><br><br>
            <ul>
                <li>
                    <a href="#">
                        <div class="hover"></div>
                        <img src="Assets/logout-icon.png">
                        <span>Logout</span>
                    </a>
                </li><br>
            </ul>
        </div>
    </nav>

    <div class="prof_section">
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
    </div>
</body>
</html>
