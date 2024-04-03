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

function getRoutineById($routineId) {
    global $conn;
    
    // Fetch routine details
    $stmt = $conn->prepare("SELECT * FROM routines WHERE routine_id = ?");
    $stmt->bind_param("i", $routineId);
    $stmt->execute();
    $result = $stmt->get_result();
    $routine = $result->fetch_assoc();
    
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
}

function saveRoutineWorkout($routineWorkout) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM `routine_workouts` WHERE `routine_id`=? AND `workout_id`=?");
    $stmt->bind_param("ii", $routineWorkout['routine_id'], $routineWorkout['workout_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows==0) {
        $stmt = $conn->prepare("INSERT INTO `routine_workouts` (`routine_id`, `workout_id`, `rows`) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $routineWorkout['routine_id'], $routineWorkout['workout_id'], $routineWorkout['rows']);
        $success = $stmt->execute();
    } else {
        $stmt = $conn->prepare("UPDATE `routine_workouts` SET `rows`=? WHERE `routine_id`=? AND `workout_id`=?");
        $stmt->bind_param("iii", $routineWorkout['rows'], $routineWorkout['routine_id'], $routineWorkout['workout_id']);
        $success = $stmt->execute();
    }
    $stmt->close();
    return $success;
}

function saveWorkoutData($workoutData) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM `workout_data` WHERE `num`=? AND `routine_id`=? AND `user_id`=? AND `workout_id`=?");
    $stmt->bind_param("iiii", $workoutData['num'], $workoutData['routine_id'], $workoutData['user_id'], $workoutData['workout_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows==0) {
        $stmt = $conn->prepare("INSERT INTO `workout_data` (`num`, `routine_id`, `user_id`, `workout_id`, `reps`, `volume`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiiii", $workoutData['num'], $workoutData['routine_id'], $workoutData['user_id'], $workoutData['workout_id'], $workoutData['reps'], $workoutData['volume']);
        $success = $stmt->execute();
    } else {
        $stmt = $conn->prepare("UPDATE `workout_data` SET `reps`=?, `volume`=? WHERE `num`=? AND `routine_id`=? AND `user_id`=? AND `workout_id`=?");
        $stmt->bind_param("iiiiii", $workoutData['reps'], $workoutData['volume'], $workoutData['num'], $workoutData['routine_id'], $workoutData['user_id'], $workoutData['workout_id']);
        $success = $stmt->execute();
    }
    $stmt->close();
    return $success;
}

function getRoutineWorkouts($routineId) {
    global $conn;

    $stmt = $conn->prepare("SELECT `routine_id`, `workout_id`, `rows` FROM `routine_workouts` WHERE `routine_id`=?");
    $stmt->bind_param("i", $routineId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
function getWorkout($workoutId) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM `workouts` WHERE `workout_id`=?");
    $stmt->bind_param("i", $workoutId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getWorkoutData($routineId, $userId, $workoutId) {
    global $conn;

    $stmt = $conn->prepare("SELECT `num`, `workout_id`, `reps`, `volume` FROM `workout_data` WHERE `routine_id`=? AND `user_id`=? AND `workout_id`=? GROUP BY `num` ASC");
    $stmt->bind_param("iii", $routineId, $userId, $workoutId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function deleteRoutineWorkout($routineWorkout, $userId) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM `routine_workouts` WHERE `routine_id`=? AND `workout_id`=?");
    $stmt->bind_param("ii", $routineWorkout['routine_id'], $routineWorkout['workout_id']);
    $success = $stmt->execute();
    
    $stmt = $conn->prepare("DELETE FROM `workout_data` WHERE `routine_id`=? AND `workout_id`=? AND `user_id`=?");
    $stmt->bind_param("iii", $routineWorkout['routine_id'], $routineWorkout['workout_id'], $userId);
    $success = $stmt->execute();

    $stmt->close();
    return $success;
}

function deleteExcessRows($routineWorkout, $userId) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM `workout_data` WHERE `routine_id`=? AND `workout_id`=? AND `user_id`=? AND `num`>?");
    $stmt->bind_param("iiii", $routineWorkout['routine_id'], $routineWorkout['workout_id'], $userId, $routineWorkout['rows']);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

function deleteAllRows($routineId, $userId) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM `workout_data` WHERE `routine_id`=? AND `user_id`=?");
    $stmt->bind_param("ii", $routineWorkout['routine_id'], $userId);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}
?>
