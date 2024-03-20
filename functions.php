<?php

include 'config.php';

function getAllWorkouts() {
    global $conn;
    $result = $conn->query("SELECT * FROM workouts");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getAllRoutines() {
    global $conn;
    $result = $conn->query("SELECT * FROM routines");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getWorkoutsInRoutine($routineId) {
    global $conn;
    $stmt = $conn->prepare("SELECT workouts.* FROM workouts
        INNER JOIN routine_workouts ON workouts.workout_id = routine_workouts.workout_id
        WHERE routine_workouts.routine_id = ?");
    $stmt->bind_param("i", $routineId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function createRoutine($selectedWorkouts) {
    global $conn;

    // Create a new routine
    $routineName = 'Routine ' . date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO routines (routine_name) VALUES (?)");
    $stmt->bind_param("s", $routineName);
    $stmt->execute();
    $routineId = $conn->insert_id;

    // Check if routine creation is successful
    if (!$routineId) {
        // Handle error, perhaps log it
        return;
    }

    // Associate selected workouts with the routine
    foreach ($selectedWorkouts as $workoutId) {
        $stmt = $conn->prepare("INSERT INTO routine_workouts (routine_id, workout_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $routineId, $workoutId);
        $stmt->execute();
    }
}

function getRoutineName($routineId) {
    global $conn;
    $stmt = $conn->prepare("SELECT routine_name FROM routines WHERE routine_id = ?");
    $stmt->bind_param("i", $routineId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['routine_name'];
}

function getAllRoutinesForUser($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT routine_id, routine_name, user_id FROM routines WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function showStatistics() {
    global $conn;
    $result = $conn->query("SELECT workout_name, routine_workouts.volume as pr
                            FROM workouts
                            JOIN routine_workouts ON workouts.workout_id = routine_workouts.workout_id
                            ORDER BY pr DESC LIMIT 5");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getRoutineById($routineId) {
    global $conn;
    
    // Fetch routine details
    $stmt = $conn->prepare("SELECT routine_id, routine_name FROM routines WHERE routine_id = ?");
    $stmt->bind_param("i", $routineId);
    $stmt->execute();
    $result = $stmt->get_result();
    $routine = $result->fetch_assoc();
    
    // Fetch workout details for the routine
    $stmt = $conn->prepare("SELECT rw.*, w.workout_name FROM routine_workouts rw
                            INNER JOIN workouts w ON rw.workout_id = w.workout_id
                            WHERE rw.routine_id = ?");
    $stmt->bind_param("i", $routineId);
    $stmt->execute();
    $result = $stmt->get_result();
    $workouts = $result->fetch_all(MYSQLI_ASSOC);
    
    // Add workouts to the routine array
    $routine['workouts'] = $workouts;
    
    return $routine;
}

function getUserProfile($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT profile_picture FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result;
}

function getUserWorkouts($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT workouts.workout_name 
                           FROM routine_workouts 
                           INNER JOIN workouts ON routine_workouts.workout_id = workouts.workout_id
                           WHERE routine_workouts.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function addWorkoutToRoutine($routineId, $userId, $workoutId, $sets, $reps, $volume) {
    global $conn;

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO routine_workouts (routine_id, user_id, workout_id, workout_sets, reps, volume) VALUES (?, ?, ?, ?, ?, ?)");

    // Bind parameters and execute the statement
    $stmt->bind_param("iiiiii", $routineId, $userId, $workoutId, $sets, $reps, $volume);
    $success = $stmt->execute();

    // Close the statement
    $stmt->close();

    return $success;
}

function deleteWorkoutFromRoutine($routineId, $workoutId) {
    global $conn;

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM routine_workouts WHERE routine_id = ? AND workout_id = ?");

    // Bind parameters and execute the statement
    $stmt->bind_param("ii", $routineId, $workoutId);
    $success = $stmt->execute();

    // Close the statement
    $stmt->close();

    return $success;
}

?>
