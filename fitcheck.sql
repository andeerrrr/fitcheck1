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
(1, 'Bench Press', 'Chest', 'Upper Body', 'Compound exercise targeting chest, triceps, and shoulders. Lie on back, unrack bar, lower to chest, and push back up.', 'images/workout_images/00251201-Barbell-Bench-Press_Chest.gif'),
(2, 'Deadlifts', 'Full Body', 'Lower Body', 'Full-body exercise working posterior chain, including lower back, glutes, and hamstrings. Stand with barbell, bend at hips and knees, grasp bar, and lift by extending hips and knees.', 'images/workout_images/00321201-Barbell-Deadlift_Hips-FIX.gif'),
(3, 'Squats', 'Legs', 'Lower Body', 'Fundamental lower-body exercise targeting quads, hamstrings, and glutes. Stand with feet shoulder-width apart, lower body by bending knees, and push back up.', 'images/workout_images/11971201-Squat-m_Thighs.gif'),
(4, 'Bicep Curls', 'Biceps', 'Upper Body', 'Isolate biceps. Hold dumbbell in each hand, keep elbows close to body, and curl weights toward shoulders, then lower them back down.', 'images/workout_images/02941201-Dumbbell-Biceps-Curl_Upper-Arms.gif'),
(5, 'Military Press', 'Shoulders', 'Upper Body', 'Work shoulders and triceps. Stand with feet shoulder-width apart, press barbell or dumbbells overhead, and lower them back down.', 'images/workout_images/11651201-Barbell-Standing-Military-Press-(without-rack)_Shoulders.gif'),
(6, 'Lateral Raises', 'Shoulders', 'Upper Body', 'Target side delts. Hold dumbbells at sides, raise them laterally to shoulder height, and lower them back down.', 'images/workout_images/03341201-Dumbbell-Lateral-Raise_shoulder.gif'),
(7, 'Quad Extensions', 'Quadriceps', 'Lower Body', 'Isolate quadriceps. Sit on leg extension machine, lift weights by extending knees, and lower them back down.', 'images/workout_images/05851201-Lever-Leg-Extension_Thighs.gif'),
(8, 'Hamstring Curls', 'Hamstrings', 'Lower Body', 'Work hamstrings. Lie face down on hamstring curl machine, curl legs toward glutes, and then lower them back down.', 'images/workout_images/05861201-Lever-Lying-Leg-Curl_Thighs.gif'),
(9, 'Leg Press', 'Legs', 'Lower Body', 'Target quads, hamstrings, and glutes. Sit on leg press machine, push platform away with feet, and then return to starting position.', 'images/workout_images/07391201-Sled-45-Leg-Press_Hips.gif'),
(10, 'Chest Flyes', 'Chest', 'Upper Body', 'Isolate chest muscles. Lie on bench, hold dumbbells, and open arms wide, then bring weights back together over chest.', 'images/workout_images/03081201-Dumbbell-Fly_Chest.gif'),
(11, 'Tricep Dips', 'Triceps', 'Upper Body', 'Work triceps and shoulders. Use parallel bars, lower body by bending elbows, and then push back up.', 'images/workout_images/08141201-Triceps-Dip_Upper-Arms.gif'),
(12, 'Pull-ups', 'Back, Biceps', 'Upper Body', 'Target upper back and biceps. Hang from bar with palms facing away, pull body upward, and lower it back down.', 'images/workout_images/06521201-Pull-up_Back.gif'),
(13, 'Lat Pulldowns', 'Back, Biceps', 'Upper Body', 'Focus on upper back. Sit at cable machine, pull bar down to chest, and return it to starting position.', 'images/workout_images/01501201-Cable-Bar-Lateral-Pulldown_Back.gif'),
(14, 'Reverse Flyes', 'Back', 'Upper Body', 'Target rear delts. Bend at hips, hold dumbbells, and lift arms laterally to shoulder height.', 'images/workout_images/06021201-Lever-Seated-Reverse-Fly_Shoulders.gif'),
(15, 'Romanian Deadlifts', 'Hamstrings, Lower Back', 'Lower Body', 'Emphasize hamstrings and lower back. Hold barbell in front of thighs, hinge at hips, and lower barbell as far as flexibility allows.', 'images/workout_images/22131201-Barbell-Romanian-Deadlift-(female)_Hips.gif'),
(16, 'Incline Bench Press', 'Chest', 'Upper Body', 'Target upper chest. Lie on incline bench, unrack bar, lower it to upper chest, and push it back up.', 'images/workout_images/00471201-Barbell-Incline-Bench-Press_Chest.gif'),
(17, 'Hammer Curls', 'Biceps, Forearms', 'Upper Body', 'Work biceps and forearms. Hold dumbbells with palms facing body, curl weights toward shoulders, and lower them back down.', 'images/workout_images/03121201-Dumbbell-Hammer-Curl-(version-2)_Upper-Arms.gif'),
(18, 'Face Pulls', 'Rear Delts, Upper Traps', 'Upper Body', 'Target rear delts and upper traps. Attach rope to cable machine, pull it towards face, and squeeze shoulder blades together.', 'images/workout_images/08961101-Band-face-pull_Shoulders_small.jpg'),
(19, 'Skull Crushers', 'Triceps', 'Upper Body', 'Focus on triceps. Lie on bench, hold an EZ curl bar, lower it toward forehead, and extend arms back up.', 'images/workout_images/00351101-Barbell-Decline-Close-Grip-To-Skull-Press_Upper-Arms_small.jpg'),
(20, 'Close-Grip Bench Press', 'Triceps', 'Upper Body', 'Emphasize triceps. Grip bar with hands close together, lower it to chest, and push it back up.', 'images/workout_images/00301201-Barbell-Close-Grip-Bench-Press_Upper-Arms.gif'),
(21, 'Seated Shoulder Press', 'Shoulders', 'Upper Body', 'Work deltoids. Sit on bench, press dumbbells overhead, and lower them back down.', 'images/workout_images/04051201-Dumbbell-Seated-Shoulder-Press_Shoulders.gif'),
(22, 'Front Raises', 'Front Delts', 'Upper Body', 'Target front delts. Hold dumbbells, lift arms forward to shoulder height, and lower them back down.', 'images/workout_images/03101201-Dumbbell-Front-Raise_Shoulders.gif'),
(23, 'Dumbbell Lunges', 'Legs', 'Lower Body', 'Work legs. Step forward with one foot, lower body until both knees are bent, and return to starting position.', 'images/workout_images/03361201-Dumbbell-Lunge_Hips.gif'),
(24, 'Barbell Squats', 'Legs', 'Lower Body', 'Compound lower body exercise targeting quads, hamstrings, and glutes. Stand with barbell on upper back, lower body into a squat position, and return to standing.', 'images/workout_images/00431201-Barbell-Full-Squat_Thighs.gif'),
(25, 'Bent Over Rows', 'Back', 'Upper Body', 'Target mid-back. Bend at hips, hold dumbbells, and pull elbows back, squeezing shoulder blades together.', 'images/workout_images/02931201-Dumbbell-Bent-Over-Row_Back.gif'),

(27, 'Calf Raises', 'Calves', 'Lower Body', 'Isolate calf muscles. Stand on raised surface, lift heels by pushing through toes, and lower them back down.', 'images/workout_images/13731101-Bodyweight-Standing-Calf-Raise_Calves_small.jpg'),
(28, 'Cable Crunches', 'Abdominals', 'Upper Body', 'Target abdominal muscles. Sit at cable machine, grasp rope attachment, and crunch forward, squeezing abs.', 'images/workout_images/01751201-Cable-Kneeling-Crunch_Waist.gif'),
(29, 'Russian Twists', 'Obliques', 'Upper Body', 'Target oblique muscles. Sit on floor, lean back slightly, and rotate torso to touch ground on each side.', 'images/workout_images/06871201-Russian-Twist_waist.gif'),
(30, 'Dumbbell Bench Press', 'Chest', 'Upper Body', 'Compound exercise targeting chest, shoulders, and triceps. Lie on bench, hold dumbbells, and press them upward.', 'images/workout_images/02891201-Dumbbell-Bench-Press_Chest.gif'),
(31, 'Plank', 'Core', 'Upper Body', 'Isometric exercise targeting core muscles. Hold a push-up position with the body straight from head to heels.', 'images/workout_images/04631201-Front-Plank-m_waist.gif'),
(32, 'Walking Lunges', 'Legs', 'Lower Body', 'Dynamic exercise targeting quads, hamstrings, and glutes. Step forward with one leg, lower body, and repeat with the other leg.', 'images/workout_images/14601201-Walking-Lunge-Male_Hips.gif'),
(33, 'Bent Over Reverse Flyes', 'Rear Delts', 'Upper Body', 'Isolation exercise for rear deltoids. Bend at the waist, hold dumbbells, and lift arms out to the sides.', 'images/workout_images/24871101-Dumbbell-Rear-Delt-Fly-(female)_Shoulders_small.jpg'),
(34, 'Tricep Kickbacks', 'Triceps', 'Upper Body', 'Isolate triceps. Hold dumbbells, hinge at the waist, and extend arms straight back behind the body.', 'images/workout_images/03331201-Dumbbell-Kickback_Upper-Arms.gif'),
(35, 'Push-ups', 'Chest, Triceps', 'Upper Body', 'Strengthen chest and triceps. Start in plank position, lower body until chest nearly touches the ground, and push back up.', 'images/workout_images/06621201-Push-up-m_Chest.gif'),
(36, 'Dips', 'Triceps, Chest', 'Upper Body', 'Work triceps and chest. Use parallel bars, lower body by bending elbows, and then push back up.', 'images/workout_images/02511201-Chest-Dip_Chest.gif'),
(37, 'Chin-ups', 'Biceps, Back', 'Upper Body', 'Engage biceps and upper back. Hang from bar with palms facing toward you, pull body upward, and lower it back down.', 'images/workout_images/13261201-Chin-Up_Back (1).gif'),
(38, 'Tricep Extensions', 'Triceps', 'Upper Body', 'Isolate triceps. Hold dumbbell overhead with both hands, lower it behind head, and extend arms back up.', 'images/workout_images/03621201-Dumbbell-One-Arm-Triceps-Extension-(on-bench)_Upper-Arms.gif'),
(39, 'Decline Bench Press', 'Chest, Shoulders, Triceps', 'Upper Body', 'Target lower chest, shoulders, and triceps. Lie on decline bench, unrack bar, lower it to lower chest, and push it back up.', 'images/workout_images/51251613_decline_dumbbell.gif'),
(40, 'Reverse Lunges', 'Quadriceps, Hamstrings, Glutes', 'Lower Body', 'Dynamic lower-body exercise. Step backward with one foot, lower body until both knees are bent, and return to starting position.', 'images/workout_images/03811201-Dumbbell-Rear-Lunge_Thighs.gif'),
(41, 'Hack Squats', 'Quadriceps, Glutes', 'Lower Body', 'Target quads and glutes. Stand with back against machine, lower body by bending knees, and push back up.', 'images/workout_images/hack_squats_81251259.gif'),
(42, 'Side Plank', 'Obliques, Core', 'Upper Body', 'Engage obliques and core. Start in side plank position, lower hips toward floor, and raise them back up.', 'images/workout_images/sideplank_1188512.png'),
(43, 'Leg Press Calf Raises', 'Calves', 'Lower Body', 'Isolate calf muscles. Sit on leg press machine, place balls of feet on bottom of platform, and perform calf raises.', 'images/workout_images/videoframe_4016_CalfRaiseLegPress.png'),
(44, 'Arnold Press', 'Shoulders', 'Upper Body', 'Work shoulders and triceps. Sit with dumbbells at shoulder height, rotate palms outward as pressing overhead, then rotate palms inward as lowering.', 'images/workout_images/0957122_arnold_press.gif'),
(45, 'Preacher Curls', 'Biceps', 'Upper Body', 'Isolate biceps. Sit at preacher curl bench, curl barbell or dumbbells toward shoulders, and lower them back down.', 'images/workout_images/1421577_preacher_curls.gif'),
(46, 'Tricep Rope Pushdowns', 'Triceps', 'Upper Body', 'Isolate triceps. Attach rope to cable machine, push it down until arms are fully extended, and return to starting position.', 'images/workout_images/tricep_rope_pushdowns.jpg');

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

CREATE TABLE admin(

    admin_username VARCHAR(225),
    admin_password VARCHAR(225)
);

INSERT INTO admin(admin_username, admin_password)
VALUES("admin","123");
