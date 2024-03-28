-- Create Users table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    pword VARCHAR(255) NOT NULL,
    sex VARCHAR(6) NOT NULL,
    dob DATE,
    profile_picture VARCHAR(255) -- Add column for profile picture
);


-- Insert sample values into Users table
INSERT INTO users (firstname, lastname, username, pword, sex, dob) VALUES
('andre', 'tanalgo', 'admin','123','male','1990-01-01');

-- Create Workouts table with an additional column for image URLs
CREATE TABLE workouts (
    workout_id INT PRIMARY KEY,
    workout_name VARCHAR(255) NOT NULL,
    workout_muscle_group VARCHAR(255) NOT NULL,
    workout_category VARCHAR(255) NOT NULL,
    workout_description TEXT,
    image_url VARCHAR(255)
);

-- Insert sample values into Workouts table with image URLs
INSERT INTO workouts (workout_id, workout_name, workout_muscle_group, workout_category, workout_description, image_url)
VALUES 
(1, 'Bench Press', 'Chest', 'Upper Body', 'Compound exercise targeting chest, triceps, and shoulders. Lie on back, unrack bar, lower to chest, and push back up.', 'images/bench_press.jpg'),
(2, 'Deadlifts', 'Full Body', 'Lower Body', 'Full-body exercise working posterior chain, including lower back, glutes, and hamstrings. Stand with barbell, bend at hips and knees, grasp bar, and lift by extending hips and knees.', 'images/deadlift.jpg'),
(3, 'Squats', 'Legs', 'Lower Body', 'Fundamental lower-body exercise targeting quads, hamstrings, and glutes. Stand with feet shoulder-width apart, lower body by bending knees, and push back up.', 'images/squats.jpg'),
(4, 'Bicep Curls', 'Biceps', 'Upper Body', 'Isolate biceps. Hold dumbbell in each hand, keep elbows close to body, and curl weights toward shoulders, then lower them back down.', 'images/bicep_curls.jpg'),
(5, 'Military Press', 'Shoulders', 'Upper Body', 'Work shoulders and triceps. Stand with feet shoulder-width apart, press barbell or dumbbells overhead, and lower them back down.', 'images/military_press.jpg'),
(6, 'Lateral Raises', 'Shoulders', 'Upper Body', 'Target side delts. Hold dumbbells at sides, raise them laterally to shoulder height, and lower them back down.', 'images/lateral_raises.jpg'),
(7, 'Quad Extensions', 'Quadriceps', 'Lower Body', 'Isolate quadriceps. Sit on leg extension machine, lift weights by extending knees, and lower them back down.', 'images/quad_extensions.jpg'),
(8, 'Hamstring Curls', 'Hamstrings', 'Lower Body', 'Work hamstrings. Lie face down on hamstring curl machine, curl legs toward glutes, and then lower them back down.', 'images/hamstring_curls.jpg'),
(9, 'Leg Press', 'Legs', 'Lower Body', 'Target quads, hamstrings, and glutes. Sit on leg press machine, push platform away with feet, and then return to starting position.', 'images/leg_press.jpg'),
(10, 'Chest Flyes', 'Chest', 'Upper Body', 'Isolate chest muscles. Lie on bench, hold dumbbells, and open arms wide, then bring weights back together over chest.', 'images/chest_flyes.jpg'),
(11, 'Tricep Dips', 'Triceps', 'Upper Body', 'Work triceps and shoulders. Use parallel bars, lower body by bending elbows, and then push back up.', 'images/chest_flyes.jpg'),
(12, 'Pull-ups', 'Back, Biceps', 'Upper Body', 'Target upper back and biceps. Hang from bar with palms facing away, pull body upward, and lower it back down.', 'images/chest_flyes.jpg'),
(13, 'Lat Pulldowns', 'Back, Biceps', 'Upper Body', 'Focus on upper back. Sit at cable machine, pull bar down to chest, and return it to starting position.', 'images/lat_pulldowns.jpg'),
(14, 'Barbell Rows', 'Back', 'Upper Body', 'Work mid-back. Bend at hips, grasp barbell, and pull it toward lower chest.', 'images/chest_flyes.jpg'),
(15, 'Reverse Flyes', 'Back', 'Upper Body', 'Target rear delts. Bend at hips, hold dumbbells, and lift arms laterally to shoulder height.', 'images/reverse_flyes.jpg'),
(16, 'Romanian Deadlifts', 'Hamstrings, Lower Back', 'Lower Body', 'Emphasize hamstrings and lower back. Hold barbell in front of thighs, hinge at hips, and lower barbell as far as flexibility allows.', 'images/romanian_deadlifts.jpg'),
(17, 'Incline Bench Press', 'Chest', 'Upper Body', 'Target upper chest. Lie on incline bench, unrack bar, lower it to upper chest, and push it back up.', 'images/incline_bench_press.jpg'),
(18, 'Hammer Curls', 'Biceps, Forearms', 'Upper Body', 'Work biceps and forearms. Hold dumbbells with palms facing body, curl weights toward shoulders, and lower them back down.', 'images/hammer_curls.jpg'),
(19, 'Face Pulls', 'Rear Delts, Upper Traps', 'Upper Body', 'Target rear delts and upper traps. Attach rope to cable machine, pull it towards face, and squeeze shoulder blades together.', 'images/face_pulls.jpg'),
(20, 'Skull Crushers', 'Triceps', 'Upper Body', 'Focus on triceps. Lie on bench, hold an EZ curl bar, lower it toward forehead, and extend arms back up.', 'images/skull_crushers.jpg'),
(21, 'Close-Grip Bench Press', 'Triceps', 'Upper Body', 'Emphasize triceps. Grip bar with hands close together, lower it to chest, and push it back up.', 'images/close_grip_bench_press.jpg'),
(22, 'Seated Shoulder Press', 'Shoulders', 'Upper Body', 'Work deltoids. Sit on bench, press dumbbells overhead, and lower them back down.', 'images/seated_shoulder_press.jpg'),
(23, 'Front Raises', 'Front Delts', 'Upper Body', 'Target front delts. Hold dumbbells, lift arms forward to shoulder height, and lower them back down.', 'images/front_raises.jpg'),
(24, 'Dumbbell Lunges', 'Legs', 'Lower Body', 'Work legs. Step forward with one foot, lower body until both knees are bent, and return to starting position.', 'images/dumbbell_lunges.jpg'),
(25, 'Barbell Squats', 'Legs', 'Lower Body', 'Compound lower body exercise targeting quads, hamstrings, and glutes. Stand with barbell on upper back, lower body into a squat position, and return to standing.', 'images/barbell_squats.jpg'),
(26, 'Bent Over Rows', 'Back', 'Upper Body', 'Target mid-back. Bend at hips, hold dumbbells, and pull elbows back, squeezing shoulder blades together.', 'images/bent_over_rows.jpg'),
(27, 'Pull-ups', 'Back, Biceps', 'Upper Body', 'Target upper back and biceps. Hang from bar with palms facing away, pull body upward, and lower it back down.', 'images/pullups.jpg'),
(28, 'Hammer Curls', 'Biceps, Forearms', 'Upper Body', 'Work biceps and forearms. Hold dumbbells with palms facing body, curl weights toward shoulders, and lower them back down.', 'images/hammer_curls.jpg'),
(29, 'Leg Press', 'Legs', 'Lower Body', 'Target quads, hamstrings, and glutes. Sit on leg press machine, push platform away with feet, and then return to starting position.', 'images/leg_press.jpg'),
(30, 'Barbell Rows', 'Back', 'Upper Body', 'Work mid-back. Bend at hips, grasp barbell, and pull it toward lower chest.', 'images/chest_flyes.jpg'),
(31, 'Leg Extensions', 'Quadriceps', 'Lower Body', 'Isolate quadriceps. Sit on leg extension machine, extend knees to lift weights, and then lower them back down.', 'images/leg_extensions.jpg'),
(32, 'Calf Raises', 'Calves', 'Lower Body', 'Isolate calf muscles. Stand on raised surface, lift heels by pushing through toes, and lower them back down.', 'images/calf_raises.jpg'),
(33, 'Cable Crunches', 'Abdominals', 'Upper Body', 'Target abdominal muscles. Sit at cable machine, grasp rope attachment, and crunch forward, squeezing abs.', 'images/cable_crunches.jpg'),
(34, 'Russian Twists', 'Obliques', 'Upper Body', 'Target oblique muscles. Sit on floor, lean back slightly, and rotate torso to touch ground on each side.', 'images/russian_twists.jpg'),
(35, 'Dumbbell Bench Press', 'Chest', 'Upper Body', 'Compound exercise targeting chest, shoulders, and triceps. Lie on bench, hold dumbbells, and press them upward.', 'images/dumbbell_bench_press.jpg'),
(36, 'Plank', 'Core', 'Upper Body', 'Isometric exercise targeting core muscles. Hold a push-up position with the body straight from head to heels.', 'images/plank.jpg'),
(37, 'Walking Lunges', 'Legs', 'Lower Body', 'Dynamic exercise targeting quads, hamstrings, and glutes. Step forward with one leg, lower body, and repeat with the other leg.', 'images/walking_lunges.jpg'),
(38, 'Bent Over Reverse Flyes', 'Rear Delts', 'Upper Body', 'Isolation exercise for rear deltoids. Bend at the waist, hold dumbbells, and lift arms out to the sides.', 'images/bent_over_reverse_flyes.jpg'),
(39, 'Tricep Kickbacks', 'Triceps', 'Upper Body', 'Isolate triceps. Hold dumbbells, hinge at the waist, and extend arms straight back behind the body.', 'images/tricep_kickbacks.jpg'),
(40, 'Step-Ups', 'Legs', 'Lower Body', 'Dynamic exercise targeting quads, hamstrings, and glutes. Step onto a raised platform with one foot, then step down and repeat with the other foot.', 'images/step_ups.jpg');


-- Create UserRoutines table for the many-to-many relationship
CREATE TABLE routines (
    routine_id INT AUTO_INCREMENT PRIMARY KEY,
    routine_name VARCHAR(255) NOT NULL,
    routine_description TEXT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Insert sample values into UserRoutines table
INSERT INTO routines (routine_id, routine_name,routine_description,user_id) VALUES
(1,'WEIGHTLOSS PROGRAM','Revolutionize your weight loss journey with our personalized program. Say goodbye to fad diets and hello to sustainable results. Lets transform together!',1),
(2,'MOBILITY PROGRAM', 'Unlock freedom with our mobility program. Tailored exercises and expert guidance help you move better and live stronger. Say hello to a more agile you!',1),
(3,'BODYBUILDING PROGRAM', 'Transform your physique with our bodybuilding program. Customized workouts and expert guidance help you pack on muscle and reach your goals. Lets build together!',1),
(4,'CARDIOVASCULAR ENDURANCE', 'Boost your endurance with our cardio program. Tailored workouts and expert guidance enhance your stamina and vitality. Ready to conquer any challenge!',1);

CREATE TABLE routine_workouts(
    routine_id INT,
    user_id INT,
    workout_id INT,
    reps INT,
    volume INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (routine_id) REFERENCES routines(routine_id),
    FOREIGN KEY (workout_id) REFERENCES workouts(workout_id)
);

-- Insert sample data into routine_workouts
INSERT INTO routine_workouts (routine_id, user_id, workout_id, reps, volume, created_at) 
VALUES (1, 1, 1, 10, 20, DEFAULT);

-- Select data from routine_workouts with corresponding workout names
SELECT routine_workouts.*, workouts.workout_name 
FROM routine_workouts 
JOIN workouts ON routine_workouts.workout_id = workouts.workout_id;
