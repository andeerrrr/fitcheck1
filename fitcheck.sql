-- Create Users table
CREATE TABLE Users (
    user_id INT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    pword VARCHAR(255) NOT NULL,
    fullName VARCHAR(255) NOT NULL
);

-- Insert sample values into Users table
INSERT INTO Users (user_id, username, fullName, pword) VALUES
(1, 'anderrr', 'Andre Louis Tanalgo', 'password'),
(2, 'admin', 'admin', 'password');

-- Create Workouts table with an additional column for image URLs
CREATE TABLE Workouts (
    workout_id INT PRIMARY KEY,
    workout_name VARCHAR(255) NOT NULL,
    workout_description TEXT,
    image_url VARCHAR(255) -- Add a column for image URLs
);

-- Insert sample values into Workouts table with image URLs
INSERT INTO Workouts (workout_id, workout_name, workout_description, image_url) VALUES
(1, 'Bench Press', 'Compound exercise targeting chest, triceps, and shoulders. Lie on back, unrack bar, lower to chest, and push back up.', 'images/bench_press.jpg'), 
(2, 'Deadlifts', 'Full-body exercise working posterior chain, including lower back, glutes, and hamstrings. Stand with barbell, bend at hips and knees, grasp bar, and lift by extending hips and knees.', 'images/deadlift.jpg'), 
(3, 'Squats', 'Fundamental lower-body exercise targeting quads, hamstrings, and glutes. Stand with feet shoulder-width apart, lower body by bending knees, and push back up.', 'images/squats.jpg'), 
(4, 'Bicep Curls', 'Isolate biceps. Hold dumbbell in each hand, keep elbows close to body, and curl weights toward shoulders, then lower them back down.', 'images/bicep_curls.jpg'), 
(5, 'Military Press', 'Work shoulders and triceps. Stand with feet shoulder-width apart, press barbell or dumbbells overhead, and lower them back down.', 'images/military_press.jpg'), 
(6, 'Lateral Raises', 'Target side delts. Hold dumbbells at sides, raise them laterally to shoulder height, and lower them back down.', 'images/lateral_raises.jpg'), 
(7, 'Quad Extensions', 'Isolate quadriceps. Sit on leg extension machine, lift weights by extending knees, and lower them back down.', 'images/quad_extensions.jpg'), 
(8, 'Hamstring Curls', 'Work hamstrings. Lie face down on hamstring curl machine, curl legs toward glutes, and then lower them back down.', 'images/hamstring_curls.jpg'),
(9, 'Leg Press', 'Target quads, hamstrings, and glutes. Sit on leg press machine, push platform away with feet, and then return to starting position.', 'images/leg_press.jpg'), 
(10, 'Chest Flyes', 'Isolate chest muscles. Lie on bench, hold dumbbells, and open arms wide, then bring weights back together over chest.', 'images/chest_flyes.jpg'), 
(11, 'Tricep Dips', 'Work triceps and shoulders. Use parallel bars, lower body by bending elbows, and then push back up.', 'images/chest_flyes.jpg'), 
(12, 'Pull-ups', 'Target upper back and biceps. Hang from bar with palms facing away, pull body upward, and lower it back down.', 'images/chest_flyes.jpg'), 
(13, 'Lat Pulldowns', 'Focus on upper back. Sit at cable machine, pull bar down to chest, and return it to starting position.', 'images/lat_pulldowns.jpg'), 
(14, 'Barbell Rows', 'Work mid-back. Bend at hips, grasp barbell, and pull it toward lower chest.', 'images/chest_flyes.jpg'), 
(15, 'Reverse Flyes', 'Target rear delts. Bend at hips, hold dumbbells, and lift arms laterally to shoulder height.', 'images/reverse_flyes.jpg'), 
(16, 'Romanian Deadlifts', 'Emphasize hamstrings and lower back. Hold barbell in front of thighs, hinge at hips, and lower barbell as far as flexibility allows.', 'images/romanian_deadlifts.jpg'), 
(17, 'Incline Bench Press', 'Target upper chest. Lie on incline bench, unrack bar, lower it to upper chest, and push it back up.', 'images/incline_bench_press.jpg'), 
(18, 'Hammer Curls', 'Work biceps and forearms. Hold dumbbells with palms facing body, curl weights toward shoulders, and lower them back down.', 'images/hammer_curls.jpg'), 
(19, 'Face Pulls', 'Target rear delts and upper traps. Attach rope to cable machine, pull it towards face, and squeeze shoulder blades together.', 'images/face_pulls.jpg'),
(20, 'Russian Twists', 'Target obliques. Sit on floor, lean back slightly, and rotate torso to touch ground on each side.', 'images/russian_twists.jpg'), 
(21, 'Leg Raises', 'Work lower abs. Lie on back, lift legs toward ceiling, and lower them back down without letting them touch the ground.', 'images/leg_raises.jpg'), 
(22, 'Calf Raises', 'Isolate calf muscles. Stand on raised surface, lift heels by pushing through toes, and lower them back down.', 'images/calf_raises.jpg'), 
(23, 'Close-Grip Bench Press', 'Emphasize triceps. Grip bar with hands close together, lower it to chest, and push it back up.', 'images/close_grip_bench_press.jpg'), 
(24, 'Seated Shoulder Press', 'Work deltoids. Sit on bench, press dumbbells overhead, and lower them back down.', 'images/seated_shoulder_press.jpg'), 
(25, 'Front Raises', 'Target front delts. Hold dumbbells, lift arms forward to shoulder height, and lower them back down.', 'images/front_raises.jpg'), 
(26, 'Dumbbell Lunges', 'Work legs. Step forward with one foot, lower body until both knees are bent, and return to starting position.', 'images/dumbbell_lunges.jpg'), 
(27, 'Skull Crushers', 'Focus on triceps. Lie on bench, hold an EZ curl bar, lower it toward forehead, and extend arms back up.', 'images/skull_crushers.jpg'), 
(46, 'Incline Dumbbell Bench Press', 'Target upper chest. Lie on incline bench, hold dumbbells in each hand, and press them upward.', 'images/incline_dumbbell_bench_press.jpg'), 
(29, 'Box Jumps', 'Plyometric exercise for leg power. Jump onto sturdy box, land softly, and step back down.', 'images/box_jumps.jpg'), 
(30, 'Bent Over Rows', 'Target mid-back. Bend at hips, hold dumbbells, and pull elbows back, squeezing shoulder blades together.', 'images/bent_over_rows.jpg');
-- Create UserRoutines table for the many-to-many relationship
CREATE TABLE Routines (
    routine_id INT PRIMARY KEY AUTO_INCREMENT,
    routine_name VARCHAR(255) NOT NULL,
    user_id INT,
    workout_id INT,
    workout_sets INT,
    reps INT,
    volume INT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (workout_id) REFERENCES Workouts(workout_id)
);

-- Insert sample values into UserRoutines table
INSERT INTO Routines (routine_name, user_id, workout_id, workout_sets, reps, volume) VALUES
('Routine 1', 1, 1, 3, 10, 30),
('Routine 2', 1, 2, 4, 8, 32),
('Routine 3', 2, 3, 3, 12, 36);
