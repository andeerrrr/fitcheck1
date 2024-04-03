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
    $author = getUserById($routine['user_id']);
    if (!$routine) {
        // Handle routine not found error
        echo "Routine not found.";
        exit();
    }

    $routineWorkouts = getRoutineWorkouts($routineId);
} else {
    // Redirect to some error page or handle the error accordingly
    echo "Routine ID is not provided.";
    exit();
}

// Fetch available workouts from the database
$workouts = getAllWorkouts();

// Handle adding a new workout to the routine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $workoutTitles = [];
    $workoutTables = [];

    $tempIndex = 0;
    while(isset($_POST['title'.$tempIndex])) {
        $workoutTitles[] = $_POST['title'.$tempIndex];
        $tempIndex++;
    }

    for($i = 0; $i<count($workoutTitles); $i++) {
        $tableData = [];
        $tempIndex = 1;
        while(isset($_POST['table'.$i.'reps'.$tempIndex])) {
            $dataReps = $_POST['table'.$i.'reps'.$tempIndex];
            $dataVolumes = $_POST['table'.$i.'volume'.$tempIndex];
            $tableData[] = [$dataReps, $dataVolumes];
            $tempIndex++;
        }
        $workoutTables[] = $tableData;
    }

    for($i = 0; $i<count($workoutTitles); $i++) {
        $routineWorkouts = array(
            'num' => count($workoutTables[$i]),
            'routine_id' => $routineId,
            'user_id' => $userId,
            'workout_id' => 0,
        );
        deleteExtraRWRows($routineWorkouts);
        
        for($j = 0; $j<count($workoutTables[$i]); $j++) {
            if(!isset($_GET['routine_id'])) {
    
            }
    
            $routineWorkouts = array(
                'num' => ($j + 1),
                'routine_id' => $routineId,
                'user_id' => $userId,
                'workout_id' => 0,
                'reps' => $workoutTables[$i][$j][0],
                'volume' => $workoutTables[$i][$j][1]
            );
            saveRoutineWorkouts($routineWorkouts);
        }
    }
    $routineWorkouts = array(
        'routine_id' => $routineId,
        'user_id' => $userId,
        'workout_id' => 0,
    );
    deleteExtraRWTables($routineWorkouts);

    $routineWorkouts = getRoutineWorkouts($routineId);
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
        <script>
            var conts = [];
            var tables = [];
            var tableIndex = 0;
            var tableTitles = [];
            var reps = [];
            var volumes = [];

            //Initialization
            var routineWorkouts = [<?php
                $filteredGroup = [];
                foreach($routineWorkouts as $workout) {
                    $filteredGroup[$workout['workout_id']][] = $workout;
                }

                for($i = 0; $i<sizeof($filteredGroup); $i++) {
                    if($i>0) {echo ", ";}
                    echo "[";
                    for($j = 0; $j<sizeof($filteredGroup[$i]); $j++) {
                        if($j>0) {echo ", ";}
                        echo "[";
                        echo $filteredGroup[$i][$j]['reps'].", ".$filteredGroup[$i][$j]['volume'];
                        echo "]";
                    }
                    echo "]";
                }
            ?>];
            function initialize() {
                for(var i = 0; i<routineWorkouts.length; i++) {
                    newWorkOut();
                    var tempTable = document.getElementById("table" + i);
                    for(var j = 0; j<routineWorkouts[i].length; j++) {
                        if(j>0) {addRow(tempTable);}
                        var tempInput = document.getElementById("table" + i + "reps" + (j+1));
                        tempInput.value = routineWorkouts[i][j][0];
                        var tempInput = document.getElementById("table" + i + "volume" + (j+1));
                        tempInput.value = routineWorkouts[i][j][1];
                    }
                }
            }

            function newWorkout(workoutName, workoutId) {
                var targCont = document.getElementById("workOuts");
                //Title, Table, and Button Container
                var tempCont = document.createElement("div");
                tempCont.style.border = "1px solid black";
                targCont.appendChild(tempCont);
                conts.push(tempCont);

                //Title
                var tempPrgph = document.createElement("p");
                var tempBold = document.createElement("b");
                tempBold.textContent = workoutName;
                //Hidden input(For form)
                var tempTitle = document.createElement("input");
                tempTitle.type = "hidden";
                tempTitle.value = workoutId;
                tempTitle.name = "title" + tableIndex;
                tableTitles.push(tempTitle);
                tempPrgph.appendChild(tempBold);
                tempPrgph.appendChild(tempTitle);
                tempCont.appendChild(tempPrgph);

                //Table
                var tempTable = document.createElement("table");
                tempTable.id = "table" + tableIndex;
                targCont.appendChild(tempTable);
                for(var i = 0; i<2; i++) {
                    //Table Row
                    var tempRow = tempTable.insertRow();
                    for(var j = 0; j<4; j++) {
                        //Row Cell
                        var tempCell = tempRow.insertCell();
                        tempCell.id = "table" + tableIndex + "r" + i + "c" + j;

                        //Column Name
                        if(i==0&&j==1) {tempCell.textContent = "Reps";}
                        if(i==0&&j==2) {tempCell.textContent = "Volume";}

                        //Numbering Column
                        if(i==1&&j==0) {tempCell.textContent = "1";}

                        //Input Columns
                        if(i==1&&(j==1||j==2)) {
                            var tempInput = document.createElement("input");
                            tempInput.type = "number";
                            tempCell.appendChild(tempInput);
                            if(j==1) {
                                reps.push([tempInput]); 
                                tempInput.name = "table" + tableIndex + "reps" + i;
                                tempInput.id = "table" + tableIndex + "reps" + i;
                            }
                            if(j==2) {
                                volumes.push([tempInput]); 
                                tempInput.name = "table" + tableIndex + "volume" + i;
                                tempInput.id = "table" + tableIndex + "volume" + i;
                            }
                        }
                    }
                }
                tempCont.appendChild(tempTable);
                tables.push(tempTable);
                tableIndex++;

                //Button for adding more rows
                var tempButton = document.createElement("Button");
                tempButton.type ="button";
                tempButton.textContent = "Add Row";
                tempButton.addEventListener('click', (function(var1) {return function() {addRow(var1)};})(tempTable));
                tempCont.appendChild(tempButton);

                //Button for deleting the table
                var tempButton = document.createElement("Button");
                tempButton.type ="button";
                tempButton.textContent = "Delete Table";
                tempButton.addEventListener('click', (function(var1, var2) {return function() {deleteTable(var1, var2)};})(tempCont, workoutId));
                tempCont.appendChild(tempButton);
            }

            function addRow(targTable) {
                //Adds new row
                var tempRow = targTable.insertRow();
                var tempIndex = tables.indexOf(targTable);
                for(var i = 0; i<4; i++) {
                    //Adds cells/columns to the row
                    var tempCell = tempRow.insertCell();
                    tempCell.id = "table" + tempIndex + "r" + (targTable.rows.length - 1) + "c" + i;

                    //Display the row's number
                    if(i==0) {tempCell.textContent = targTable.rows.length - 1;}

                    //Adds input fields
                    if(i==1||i==2) {
                        var tempInput = document.createElement("input");
                        tempInput.type = "number";
                        tempCell.appendChild(tempInput);
                        if(i==1) {
                            reps[tempIndex].push(tempInput); 
                            tempInput.name = "table" + tempIndex + "reps" + (targTable.rows.length - 1);
                            tempInput.id = "table" + tempIndex + "reps" + (targTable.rows.length - 1);
                        }
                        if(i==2) {
                            volumes[tempIndex].push(tempInput); 
                            tempInput.name = "table" + tempIndex + "volume" + (targTable.rows.length - 1);
                            tempInput.id = "table" + tempIndex + "volume" + (targTable.rows.length - 1);
                        }
                    }
                    //Adds delete row button
                    if(i==3) {
                        var tempButton = document.createElement("button");
                        tempButton.type = "button";
                        tempButton.textContent = "X";
                        tempButton.addEventListener('click', (function(var1, var2) {return function() {deleteRow(var1, var2)};})(tempRow, targTable));
                        tempCell.append(tempButton);
                    }
                }
            }

            function deleteRow(targRow, targTable) {
                //Identifies the row index of target row
                var rowIndex = -1;
                for(var i = 0; i<targTable.rows.length; i++) {
                    if(targTable.rows[i]===targRow) {rowIndex = i-1; break;}
                }
                var tempIndex = tables.indexOf(targTable);
                reps[tempIndex].splice(rowIndex, 1);
                volumes[tempIndex].splice(rowIndex, 1);
                targRow.remove();

                for(var i = 0; i<targTable.rows.length; i++) {
                    if(i!=0) {
                        //Rewrites the numbering column
                        targTable.rows[i].cells[0].textContent = i;
                        //Rewrites input ids and names
                        reps[tempIndex][i-1].name = "table" + tempIndex + "reps" + i;
                        reps[tempIndex][i-1].id = "table" + tempIndex + "reps" + i;
                        volumes[tempIndex][i-1].name = "table" + tempIndex + "volume" + i;
                        volumes[tempIndex][i-1].id = "table" + tempIndex + "volume" + i;
                    }
                    for(var j = 0; j<4; j++) {
                        //Rewrites cell ids
                        targTable.rows[i].cells[j].id = "table" + tempIndex + "r" + i + "c" + j;
                    }
                }
            }

            function deleteTable(targCont, workoutId) {
                var tempButton = document.getElementById('workout' + workoutId);
                tempButton.style.display = "";

                var tempIndex = conts.indexOf(targCont);
                if(tempIndex!==-1) {
                    targCont.remove();
                    conts.splice(tempIndex, 1);
                    titles.splice(tempIndex, 1);
                    tables.splice(tempIndex,1);
                    reps.splice(tempIndex, 1);
                    volumes.splice(tempIndex, 1);
                    tableIndex--;

                    //Rewrites table and title indexes
                    for(var i = 0; i<tables.length; i++) {
                        var targTable = tables[i];
                        targTable.id = "table" + i;
                        tableTitles[i].name = "title" + i;
                        for(var j = 0; j<targTable.rows.length; j++) {
                            for(var k = 0; k<4; k++) {
                                targTable.rows[j].cells[k].id = "table" + i + "r" + j + "c" + k;
                            }
                        }
                    }
                }
            }

            function hideButton(tempButton, workoutName, workoutId) {
                tempButton.style.display = "none";
                newWorkout(workoutName, workoutId);
            }

            window.onload = initialize;
        </script>
    </head>
    <body>
        <div class="routineDiv">
            <h3>Routine Name: <?php echo $routine['routine_name']; ?></h3>
            <h4>By: <?php echo $author['firstname'] . " " . $author['lastname']; ?></h4>
            <h4>Description: <?php echo $routine['routine_description']; ?></h4>
            
            <h4>Workouts:</h4>
            <form action="" method="post">
                <div id="workOuts">
                </div>
                <?php
                    if($userId==$routine['user_id']) {
                        echo "<input type='submit' value='Save' name='submit'>";
                    }
                ?>
            </form>
            <a href="index.php">Go Back to Dashboard</a>    
        </div>
        <div class="workoutsDiv">
            <div class="filterDiv">
                <p>Muscle Groups:</p>
                <select name="workoutsFilter" id="workoutsFilter" title="workoutsFilter">
                    <option value="">All Muscle Groups</option>
                    <?php
                    // Fetch distinct muscle groups from the database
                    $muscle_groups = array_unique(array_column($workouts, 'workout_muscle_group'));
                    foreach ($muscle_groups as $muscle_group) {
                        echo "<option value='$muscle_group'>$muscle_group</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="workoutsInnerDiv">
                <?php
                    // Filter workouts based on selected category and muscle group
                    $filtered_workouts = $workouts; // Initialize with all workouts
                    foreach ($filtered_workouts as $workout) {
                        $tempString = "<button class='workout' id='workout".$workout['workout_id']."' onclick='hideButton(this, \"".$workout['workout_name']."\", ".$workout['workout_id'].")'>"
                            .$workout['workout_name']
                            ."</button>";
                        echo $tempString;
                    }
                    ?>
            </div>
        </div>
    </body>
</html>
