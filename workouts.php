<?php
session_start();
include 'functions.php';

//Check if the user is logged in
if (!isset($_SESSION['login'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
} 

// Handle routine creation form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createRoutine'])) {
    if (isset($_POST['selectedWorkouts']) && !empty($_POST['selectedWorkouts'])) {
        $selectedWorkouts = $_POST['selectedWorkouts'];
        createRoutine($selectedWorkouts);
    }
}

// Get all workouts
$workouts = getAllWorkouts();

// Get all saved routines for the logged-in user
$routines = getAllRoutinesForUser($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workouts and Routines</title>
    <link rel="stylesheet" href="styles.css">

    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            text-align: center;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

</head>
<body>
    <h2>Workouts</h2>
    <h1><?php echo $_SESSION['firstname']; ?></h1>
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
    <!-- Filter form for workouts -->
    <form action="" method="post">
        <label for="muscle_group">Filter by Muscle Group:</label>
        <select name="muscle_group" id="muscle_group">
            <option value="">All Muscle Groups</option>
            <?php
            // Fetch distinct muscle groups from the database
            $muscle_groups = array_unique(array_column($workouts, 'workout_muscle_group'));
            foreach ($muscle_groups as $muscle_group) {
                echo "<option value='$muscle_group'>$muscle_group</option>";
            }
            ?>
        </select>
        <button type="submit">Filter</button>
    </form>

    <form action="" method="post">
        <ul>
            <?php
            // Filter workouts based on selected category and muscle group
            $filtered_workouts = $workouts; // Initialize with all workouts
            if (isset($_POST['category']) && $_POST['category'] !== '') {
                $category_filter = $_POST['category'];
                $filtered_workouts = array_filter($filtered_workouts, function ($workout) use ($category_filter) {
                    return $workout['workout_category'] === $category_filter;
                });
            }
            if (isset($_POST['muscle_group']) && $_POST['muscle_group'] !== '') {
                $muscle_group_filter = $_POST['muscle_group'];
                $filtered_workouts = array_filter($filtered_workouts, function ($workout) use ($muscle_group_filter) {
                    return $workout['workout_muscle_group'] === $muscle_group_filter;
                });
            }

            foreach ($filtered_workouts as $workout) {
                echo "<div class='workout'>";
                echo "<img src='{$workout['image_url']}' alt='{$workout['workout_name']}'>";
                echo "<h3>{$workout['workout_name']}</h3>";
                echo "<p>{$workout['workout_description']}</p>";
                echo "<span class='muscle-group'>{$workout['workout_muscle_group']}</span>";
                echo "<span class='category'>{$workout['workout_category']}</span>";
                // Add button with data attribute to store workout details
                echo "<button class='add-button' type='button'>+</button>";
                echo "</div>";
            }
            ?>
        </ul>
    </form>
    <footer><a href="logout.php">logout</a></footer>
    <!-- Modal -->
    <div id="modal-container">
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="workout-details"></div>
                <img id="workout-image" src="" alt="Workout Image">
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Function to handle click event on add button
            $(".add-button").click(function() {
                var workoutName = $(this).siblings("h3").text();
                var workoutDescription = $(this).siblings("p").text();
                var workoutMuscleGroup = $(this).siblings(".muscle-group").text();
                var workoutCategory = $(this).siblings(".category").text();
                var workoutImage = $(this).siblings("img").attr("src");

                // Display workout details in modal
                $("#workout-details").html("<h3>" + workoutName + "</h3>" +
                    "<p>Description: " + workoutDescription + "</p>" +
                    "<p>Muscle Group: " + workoutMuscleGroup + "</p>" +
                    "<p>Category: " + workoutCategory + "</p>");
                $("#workout-image").attr("src", workoutImage);
                $("#myModal").css("display", "block");
            });

            // Close modal when close button or outside modal is clicked
            $(".close").click(function() {
                $("#myModal").css("display", "none");
            });

            $(window).click(function(event) {
                if (event.target == $("#myModal")[0]) {
                    $("#myModal").css("display", "none");
                }
            });
        });
    </script>


</body>
</html>
