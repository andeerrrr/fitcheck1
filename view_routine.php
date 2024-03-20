<?php
include 'functions.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Get the user ID from the session
$userId = $_SESSION['user_id'];

// Check if routine_id is provided in the URL
if (isset($_GET['routine_id'])) {
    $routineId = $_GET['routine_id'];

    // Get routine details
    $routine = getRoutineById($routineId);
    if (!$routine) {
        // Handle routine not found error
        echo "Routine not found.";
        exit();
    }
} else {
    // Redirect to some error page or handle the error accordingly
    echo "Routine ID is not provided.";
    exit();
}

// Fetch available workouts from the database
$workouts = getAllWorkouts();

// Handle adding a new workout to the routine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveWorkout'])) {
    // Retrieve form data
    $selectedWorkoutId = $_POST['workoutId'];
    $newWorkoutSets = $_POST['sets'];
    $newWorkoutReps = $_POST['reps'];
    $newWorkoutVolume = $_POST['volume'];

    // Validate form data (you can add more validation as needed)

    // Add the new workout to the routine
    $success = addWorkoutToRoutine($routineId, $userId, $selectedWorkoutId, $newWorkoutSets, $newWorkoutReps, $newWorkoutVolume);

    if ($success) {
        // Refresh the page to reflect the changes
        header("Location: view_routine.php?routine_id=$routineId");
        exit();
    } else {
        echo "Failed to add the workout to the routine.";
        // Handle the error accordingly
    }
}

// Handle deleting a workout from the routine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteWorkout'])) {
    // Retrieve workout ID to be deleted
    $deleteWorkoutId = $_POST['deleteWorkoutId'];

    // Delete the workout from the routine
    $success = deleteWorkoutFromRoutine($routineId, $deleteWorkoutId);

    if ($success) {
        // Refresh the page to reflect the changes
        header("Location: view_routine.php?routine_id=$routineId");
        exit();
    } else {
        echo "Failed to delete the workout from the routine.";
        // Handle the error accordingly
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Routine</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        form.inline {
            display: inline;
        }
    </style>
</head>
<body>
    <h2>View Routine</h2>
    <h3>Routine Name: <?php echo $routine['routine_name']; ?></h3>
    
    <h4>Workouts:</h4>
    <table>
        <tr>
            <th>Workout Name</th>
            <th>Sets</th>
            <th>Reps</th>
            <th>Volume</th>
            <th>Action</th>
        </tr>
        <?php
        // Loop through each workout in the routine
        foreach ($routine['workouts'] as $workout) {
            echo "<tr>";
            echo "<td>{$workout['workout_name']}</td>";
            echo "<td>{$workout['workout_sets']}</td>";
            echo "<td>{$workout['reps']}</td>";
            echo "<td>{$workout['volume']}</td>";
            echo "<td>
                    <form class='inline' action='' method='post'>
                        <input type='hidden' name='deleteWorkoutId' value='{$workout['workout_id']}'>
                        <button type='submit' name='deleteWorkout'>Delete</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
    
    <!-- Form to add a new workout -->
    <h4>Add Workout:</h4>
    <form id="addWorkoutForm" action="" method="post">
    <!-- Remove unnecessary hidden input -->
    
    <label for="workoutId">Select Workout:</label>
    <select name="workoutId" id="workoutId" required>
        <?php foreach ($workouts as $workout) { ?>
            <option value="<?php echo $workout['workout_id']; ?>"><?php echo $workout['workout_id'] . ' - ' . $workout['workout_name']; ?></option>
        <?php } ?>
    </select><br><br>
    
    <label for="sets">Sets:</label>
    <input type="number" name="sets" id="sets" required><br><br>
    
    <label for="reps">Reps:</label>
    <input type="number" name="reps" id="reps" required><br><br>
    
    <label for="volume">Volume:</label>
    <input type="number" name="volume" id="volume" required><br><br>
    
    <button type="submit" name="saveWorkout">Save Workout</button>
</form>
    
    <a href="index.php">Go Back to Dashboard</a>
</body>
</html>

