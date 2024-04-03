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
$user = getUserById($user_id);
$profile_picture = $user['profile_picture'];
$completedWorkouts = getCompletedWorkouts($user_id);
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
                <img id="logo" src="images/assets/logo.png">
            </span>
        </header>

        <div class="menu">
            <ul>
                <li>
                    <a href="#">
                        <div class="hover"></div>
                        <img src="images/assets/home-icon.png">
                        <span>Feed</span>
                    </a>
                </li><br>
                <li>
                    <a href="#">
                        <div class="hover" id="workout"></div>
                        <img src="images/assets/workout-icon.png">
                        <span>Workout</span>
                    </a>
                </li><br>
                <li>
                    <a href="#">
                        <div class="hover" id="exercises"></div>
                        <img src="images/assets/exercise-icon.png">
                        <span>Exercises</span>
                    </a>
                </li><br>
                <li>
                    <a href="#">
                        <div class="active"></div>
                        <img src="images/assets/profile-icon.png">
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
                        <img src="images/assets/logout-icon.png">
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
            <div>
                <p><?php echo $user['firstname']." ".$user['lastname'] ?></p>
                <div class="personalDetails">
                    <p><b>Birthday: </b><?php echo $user['dob']; ?></p>
                    <p><b>Gender: </b><?php echo $user['sex']; ?></p>
                </div>
            </div>

            <!-- Display user's workouts -->
            <br>
            <h3>Workouts Done:</h3>
            <ul>
                <?php foreach ($completedWorkouts as $workout) : ?>
                    <li><?php echo $workout['workout_name']; ?></li>
                <?php endforeach; ?>
            </ul>

        <a href="index.php">Go Back to Dashboard</a>
    </div>
</body>
</html>
