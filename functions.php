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
    $stmt = $conn->prepare("SELECT * FROM routines WHERE routine_id = ?");
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

function getUserById($user_id) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `user_id`=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    return $user;
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

function saveRoutineWorkouts($routineWorkouts) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM `routine_workouts` WHERE `num`=? AND `routine_id`=? AND `user_id`=? AND `workout_id`=?");
    $stmt->bind_param("iiii", $routineWorkouts['num'], $routineWorkouts['routine_id'], $routineWorkouts['user_id'], $routineWorkouts['workout_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows==0) {
        $stmt = $conn->prepare("INSERT INTO `routine_workouts` (`num`, `routine_id`, `user_id`, `workout_id`, `reps`, `volume`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiiii", $routineWorkouts['num'], $routineWorkouts['routine_id'], $routineWorkouts['user_id'], $routineWorkouts['workout_id'], $routineWorkouts['reps'], $routineWorkouts['volume']);
        $success = $stmt->execute();
    } else {
        $stmt = $conn->prepare("UPDATE `routine_workouts` SET `reps`=?, `volume`=? WHERE `num`=? AND `routine_id`=? AND `user_id`=? AND `workout_id`=?");
        $stmt->bind_param("iiiiii", $routineWorkouts['reps'], $routineWorkouts['volume'], $routineWorkouts['num'], $routineWorkouts['routine_id'], $routineWorkouts['user_id'], $routineWorkouts['workout_id']);
        $success = $stmt->execute();
    }
    $stmt->close();
    return $success;
}

function getRoutineWorkouts($routineId) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM `routine_workouts` WHERE `routine_id`=?");
    $stmt->bind_param("i", $routineId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function deleteExtraRWRows($routineWorkouts) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM routine_workouts WHERE `num`>? AND `routine_id`=? AND `user_id`=? AND `workout_id`=?");
    $stmt->bind_param("iiii", $routineWorkouts['num'], $routineWorkouts['routine_id'], $routineWorkouts['user_id'], $routineWorkouts['workout_id']);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

function deleteExtraRWTables($routineWorkouts) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM routine_workouts WHERE `routine_id`=? AND `user_id`=? AND `workout_id`>?");
    $stmt->bind_param("iii", $routineWorkouts['routine_id'], $routineWorkouts['user_id'], $routineWorkouts['workout_id']);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}
?>
