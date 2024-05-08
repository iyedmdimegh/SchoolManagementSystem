<?php
session_start();
// Include the dbcreation.php file
require_once('../database/dbcreation.php');

// Get an instance of the PDO connection
$pdo = ConnexionBD::getInstance();



$students = [
    [1, 'Amir', 'Ben Ali', 'amir.benali@example.com', 'pass123', 12345678, '123 Avenue Habib Bourguiba, Tunis', '1995-05-15', 'Male', 'Tunisian', 'GL', 2, 2],
    [2, 'Sara', 'Dridi', 'sara.dridi@example.com', 'pass456', 23456789, '45 Rue Mohamed V, Sousse', '1998-08-20', 'Female', 'Tunisian', 'RT', 3, 3],
    [3, 'Mohamed', 'Karray', 'mohamed.karray@example.com', 'pass789', 34567890, '21 Rue Farhat Hached, Sfax', '1997-02-10', 'Male', 'Tunisian', 'IIA', 2, 1],
    [4, 'Yasmine', 'Gharbi', 'yasmine.gharbi@example.com', 'passabc', 45678901, '17 Rue Habib Thameur, Bizerte', '1996-11-25', 'Female', 'Tunisian', 'IMI', 4, 3],
    [5, 'Karim', 'Mabrouk', 'karim.mabrouk@example.com', 'passdef', 56789012, '8 Avenue Mohamed Ali, Nabeul', '1999-04-05', 'Male', 'Tunisian', 'CH', 3, 2],
    [6, 'Ines', 'Ben Amor', 'ines.benamor@example.com', 'pass123', 67890123, '55 Rue Tahar Haddad, Hammamet', '1994-07-12', 'Female', 'Tunisian', 'BIO', 5, 1],
    [7, 'Mehdi', 'Saidi', 'mehdi.saidi@example.com', 'pass456', 78901234, '32 Avenue Habib Bourguiba, Tunis', '1997-09-30', 'Male', 'Tunisian', 'MPI', 1, 1],
    [8, 'Lina', 'Nouri', 'lina.nouri@example.com', 'pass789', 89012345, '29 Rue Ibn Khaldoun, Sousse', '1998-03-18', 'Female', 'Tunisian', 'CBA', 1, 3],
    [9, 'Anis', 'Ferjani', 'anis.ferjani@example.com', 'passabc', 90123456, '14 Avenue Habib Thameur, Sfax', '1995-12-03', 'Male', 'Tunisian', 'GL', 3, 1],
    [10, 'Hiba', 'Salhi', 'hiba.salhi@example.com', 'passdef', 12345678, '6 Rue Farhat Hached, Gabes', '1996-10-22', 'Female', 'Tunisian', 'RT', 4, 2],
    [11, 'Yassine', 'Mejri', 'yassine.mejri@example.com', 'pass123', 23456789, '19 Rue Mohamed V, Djerba', '1999-01-09', 'Male', 'Tunisian', 'IIA', 2, 2],
    [12, 'Aya', 'Hamdi', 'aya.hamdi@example.com', 'pass456', 34567890, '27 Avenue Habib Bourguiba, Nabeul', '1997-06-27', 'Female', 'Tunisian', 'IMI', 5, 1],
    [13, 'Ali', 'Guesmi', 'ali.guesmi@example.com', 'pass789', 45678901, '35 Rue Habib Thameur, Bizerte', '1994-04-14', 'Male', 'Tunisian', 'CH', 3, 3],
    [14, 'Salma', 'Ben Ahmed', 'salma.benahmed@example.com', 'passabc', 56789012, '11 Rue Tahar Haddad, Hammamet', '1998-11-01', 'Female', 'Tunisian', 'BIO', 4, 2],
    [15, 'Oussama', 'Rekik', 'oussama.rekik@example.com', 'passdef', 67890123, '23 Avenue Mohamed Ali, Sfax', '1996-02-28', 'Male', 'Tunisian', 'MPI', 1, 2],
    [16, 'Fatma', 'Trabelsi', 'fatma.trabelsi@example.com', 'pass123', 78901234, '39 Rue Ibn Khaldoun, Gabes', '1995-08-07', 'Female', 'Tunisian', 'CBA', 1, 1],
    [17, 'Hamza', 'Saied', 'hamza.saied@example.com', 'pass456', 89012345, '4 Avenue Habib Thameur, Tunis', '1997-03-16', 'Male', 'Tunisian', 'GL', 2, 3],
    [18, 'Lamia', 'Ksouri', 'lamia.ksouri@example.com', 'pass789', 90123456, '25 Rue Farhat Hached, Sousse', '1994-12-24', 'Female', 'Tunisian', 'RT', 3, 1],
    [19, 'Nadir', 'Zoghlami', 'nadir.zoghlami@example.com', 'passabc', 12345678, '18 Rue Mohamed V, Sfax', '1999-10-11', 'Male', 'Tunisian', 'IIA', 2, 3],
    [20, 'Amina', 'Masmoudi', 'amina.masmoudi@example.com', 'passdef', 23456789, '3 Avenue Habib Bourguiba, Bizerte', '1996-07-29', 'Female', 'Tunisian', 'IMI', 4, 2],
    [21, 'Mounir', 'Bouzidi', 'mounir.bouzidi@example.com', 'pass123', 34567890, '7 Rue Habib Thameur, Gabes', '1998-04-03', 'Male', 'Tunisian', 'CH', 3, 1],
    [22, 'Rania', 'Khalifa', 'rania.khalifa@example.com', 'pass456', 45678901, '22 Rue Tahar Haddad, Nabeul', '1997-01-14', 'Female', 'Tunisian', 'BIO', 5, 3],
    [23, 'Marwen', 'Farhat', 'marwen.farhat@example.com', 'pass789', 56789012, '16 Avenue Mohamed Ali, Hammamet', '1995-06-02', 'Male', 'Tunisian', 'MPI', 1, 3],
    [24, 'Safa', 'Nasri', 'safa.nasri@example.com', 'passabc', 67890123, '31 Rue Ibn Khaldoun, Sfax', '1994-09-21', 'Female', 'Tunisian', 'CBA', 1, 2],
    [25, 'Khaled', 'Ben Salah', 'khaled.bensalah@example.com', 'passdef', 78901234, '10 Avenue Habib Thameur, Tunis', '1998-02-18', 'Male', 'Tunisian', 'GL', 2, 1],
    [26, 'Houda', 'Sassi', 'houda.sassi@example.com', 'pass123', 89012345, '5 Rue Farhat Hached, Sousse', '1995-05-10', 'Female', 'Tunisian', 'RT', 4, 3],
    [27, 'Anwar', 'Garaali', 'anwar.garaali@example.com', 'pass456', 90123456, '2 Avenue Mohamed Ali, Sfax', '1996-12-01', 'Male', 'Tunisian', 'IIA', 2, 2],
    [28, 'Nour', 'Hamza', 'nour.hamza@example.com', 'pass789', 12345678, '9 Rue Habib Thameur, Bizerte', '1999-08-08', 'Female', 'Tunisian', 'IMI', 3, 1],
    [29, 'Wassim', 'Harrabi', 'wassim.harrabi@example.com', 'passabc', 23456789, '13 Rue Tahar Haddad, Nabeul', '1997-04-17', 'Male', 'Tunisian', 'CH', 3, 2],
    [30, 'Sabrine', 'Mejri', 'sabrine.mejri@example.com', 'passdef', 34567890, '20 Avenue Mohamed Ali, Hammamet', '1994-11-22', 'Female', 'Tunisian', 'BIO', 4, 1],
    [31, 'Imen', 'Bouzidi', 'imen.bouzidi@example.com', 'pass123', 45678901, '28 Rue Ibn Khaldoun, Gabes', '1996-06-19', 'Female', 'Tunisian', 'MPI', 1, 2],
    [32, 'Fares', 'Gharsalli', 'fares.gharsalli@example.com', 'pass456', 56789012, '37 Avenue Habib Thameur, Tunis', '1999-03-02', 'Male', 'Tunisian', 'CBA', 1, 3],
    [33, 'Amani', 'Mabrouk', 'amani.mabrouk@example.com', 'pass789', 67890123, '30 Rue Farhat Hached, Sousse', '1994-10-13', 'Female', 'Tunisian', 'GL', 2, 1],
    [34, 'Radhouane', 'Bennaceur', 'radhouane.bennaceur@example.com', 'passabc', 78901234, '15 Rue Mohamed V, Sfax', '1997-07-30', 'Male', 'Tunisian', 'RT', 3, 2],
    [35, 'Hayfa', 'Saad', 'hayfa.saad@example.com', 'passdef', 89012345, '24 Avenue Habib Bourguiba, Bizerte', '1995-02-11', 'Female', 'Tunisian', 'IIA', 2, 3],
    [36, 'Achraf', 'Dhaouadi', 'achraf.dhaouadi@example.com', 'pass123', 90123456, '36 Rue Habib Thameur, Nabeul', '1998-09-29', 'Male', 'Tunisian', 'IMI', 5, 2],
    [37, 'Rym', 'Khadhraoui', 'rym.khadhraoui@example.com', 'pass456', 12345678, '1 Rue Tahar Haddad, Hammamet', '1996-04-26', 'Female', 'Tunisian', 'CH', 3, 1],
    [38, 'Nizar', 'Ammar', 'nizar.ammar@example.com', 'pass789', 23456789, '26 Avenue Mohamed Ali, Sousse', '1999-11-03', 'Male', 'Tunisian', 'BIO', 4, 3],
    [39, 'foulen', 'fouleni','demo@insat.com', 'demo1234', 12345678, '5 Rue de la Liberté Tunis', '1999-01-01', 'Male', 'Tunisian', 'GL',  2,   2]
];

$teachers = [
    [1, 'Hichem', 'Ben Ali', 'hichem.benali@example.com', 'pass123', 23456789, 'Male'],
    [2, 'Noura', 'Chaabane', 'noura.chaabane@example.com', 'pass456', 34567890, 'Female'],
    [3, 'Khaled', 'Dhahri', 'khaled.dhahri@example.com', 'pass789', 45678901, 'Male'],
    [4, 'Amira', 'Guesmi', 'amira.guesmi@example.com', 'passabc', 56789012, 'Female'],
    [5, 'Mohamed', 'Khelifi', 'mohamed.khelifi@example.com', 'passdef', 67890123, 'Male'],
    [6, 'Ines', 'Mabrouk', 'ines.mabrouk@example.com', 'pass123', 78901234, 'Female'],
    [7, 'Sami', 'Nasri', 'sami.nasri@example.com', 'pass456', 89012345, 'Male'],
    [8, 'Yosra', 'Ouni', 'yosra.ouni@example.com', 'pass789', 90123456, 'Female'],
    [9, 'Adel', 'Rahmani', 'adel.rahmani@example.com', 'passabc', 12345678, 'Male'],
    [10, 'Lina', 'Saidi', 'lina.saidi@example.com', 'pass123', 23456789, 'Female'],
    [11, 'Ahmed', 'Trabelsi', 'ahmed.trabelsi@example.com', 'pass456', 34567890, 'Male'],
    [12, 'Amina', 'Zouari', 'amina.zouari@example.com', 'pass789', 45678901, 'Female'],
    [13, 'Raouf', 'Ammar', 'raouf.ammar@example.com', 'passabc', 56789012, 'Male'],
    [14, 'Fatma', 'Brahmi', 'fatma.brahmi@example.com', 'pass123', 67890123, 'Female'],
    [15, 'Wassim', 'Chaieb', 'wassim.chaieb@example.com', 'pass456', 78901234, 'Male'],
];

$courses = [
    [1, 'IT Fundamentals', 3, 'GL', 2],
    [2, 'Networking Basics', 7, 'RT', 3],
    [3, 'Introduction to Physics', 10, 'IIA', 4],
    [4, 'Advanced Physics', 12, 'IIA', 3],
    [5, 'Database Management', 5, 'IMI', 4],
    [6, 'Software Development', 14, 'IMI', 5],
    [7, 'Chemistry Fundamentals', 8, 'CH', 3],
    [8, 'Biochemistry', 9, 'BIO', 1],
    [9, 'Microbiology', 13, 'BIO', 1],
    [10, 'Organic Chemistry', 11, 'CH', 4],
    [11, 'Advanced IT', 3, 'GL', 3],
    [12, 'Web Development', 7, 'RT', 4],
    [13, 'Advanced Mathematics', 5, 'MPI', 2],
    [14, 'Statistics', 5, 'MPI', 3],
    [15, 'Bioinformatics', 9, 'CBA', 2],
    [16, 'Genetics', 9, 'CBA', 3],
    [17,'Python', 4, 'GL', 2],
];

$absences = [
    [1,1,'2024-01-10'],
    [1,1,'2024-01-15'],
    [1,1,'2024-02-15'],
    [1,1,'2024-03-22'],
    [1,1,'2024-04-01'],
    [2,2,'2024-01-15'],
    [2,2,'2024-02-20'],
    [2,2,'2024-04-03'],
    [4,5,'2024-01-20'],
    [4,5,'2024-04-09'],
    [13,7,'2024-04-05'],
    [33,1,'2024-02-10'],
    [36,6,'2024-04-09'],
    [39,1,'2024-04-10'],
    [39,17,'2024-04-10'],
    [39,17,'2024-04-11'],
    [39,17,'2024-04-12'],
];

$courseVideos=[
    [1,'https://www.youtube.com/watch?v=-uleG_Vecis','Computer Science Concepts Explained','Learn the fundamentals of Computer Science with a quick breakdown of jargon that every software engineer should know. Over 100 technical concepts from the CS curriculum are explained to provide a foundation for programmers.','GL',2],
    [2,'https://www.youtube.com/watch?v=oHQvWa6J8dU','Introduction to Networking Basics','This video introduces the basics of Networking','RT',3],
    [3,'https://www.youtube.com/watch?v=JwSS70SZdyM','Introduction to Python','This video introduces the basics of Python','RT',4],
    [4,'https://www.youtube.com/watch?v=oHQvWa6J8dU','Introduction to Networking Basics','This video introduces the basics of Networking','GL',2],
    [5,'https://www.youtube.com/watch?v=JwSS70SZdyM','Introduction to Python','This video introduces the basics of Python','GL',2],
    [6, 'https://www.youtube.com/watch?v=abc123', 'Physics Fundamentals', 'Explore the basic principles of physics, covering topics such as mechanics, thermodynamics, and electromagnetism.', 'IMI', 3],
    [7, 'https://www.youtube.com/watch?v=def456', 'Introduction to Electronics', 'Learn about electronic components, circuits, and devices.', 'IIA', 3],
    [8, 'https://www.youtube.com/watch?v=ghi789', 'Biology Basics', 'Discover the basics of biology, including cells, genetics, and ecology.', 'BIO', 4],
    [9, 'https://www.youtube.com/watch?v=jkl012', 'Chemistry Essentials', 'An essential overview of key concepts in chemistry.', 'CH', 4],
    [10, 'https://www.youtube.com/watch?v=mno345', 'Introduction to Statistics', 'Learn the basics of statistics, including data analysis and probability.', 'MPI', 1],
    [11, 'https://www.youtube.com/watch?v=pqr678', 'Software Development Principles', 'Explore the principles of software development, including design patterns and best practices.', 'GL', 3],
    [12, 'https://www.youtube.com/watch?v=stu901', 'Web Development Basics', 'Learn the basics of web development, including HTML, CSS, and JavaScript.', 'GL', 2],
    [13, 'https://www.youtube.com/watch?v=vwx234', 'Introduction to Databases', 'Discover the fundamentals of database management, including SQL and data modeling.', 'RT', 2],
    [14, 'https://www.youtube.com/watch?v=yzab56', 'Introduction to Bioinformatics', 'Learn about bioinformatics, including genomics, proteomics, and computational biology.', 'BIO', 2],
    [15, 'https://www.youtube.com/watch?v=def456', 'Introduction to Electronics', 'Learn about electronic components, circuits, and devices.', 'IMI', 2],
    [16, 'https://www.youtube.com/watch?v=ghi789', 'Biology Basics', 'Discover the basics of biology, including cells, genetics, and ecology.', 'CH', 4],
    [17, 'https://www.youtube.com/watch?v=jkl012', 'Chemistry Essentials', 'An essential overview of key concepts in chemistry.', 'CH', 4],
    [18, 'https://www.youtube.com/watch?v=mno345', 'Introduction to Statistics', 'Learn the basics of statistics, including data analysis and probability.', 'MPI', 1],
    [19, 'https://www.youtube.com/watch?v=pqr678', 'Software Development Principles', 'Explore the principles of software development, including design patterns and best practices.', 'RT', 3],
    [20, 'https://www.youtube.com/watch?v=stu901', 'Web Development Basics', 'Learn the basics of web development, including HTML, CSS, and JavaScript.', 'MPI', 1],
    [21, 'https://www.youtube.com/watch?v=vwx234', 'Introduction to Databases', 'Discover the fundamentals of database management, including SQL and data modeling.', 'GL', 2],
    [22, 'https://www.youtube.com/watch?v=123xyz', 'Algebra Basics', 'Introduction to fundamental algebra concepts and operations.', 'MPI', 1],
    [23, 'https://www.youtube.com/watch?v=456abc', 'Geometry Fundamentals', 'Explore basic geometry principles and shapes.', 'MPI', 1],
    [24, 'https://www.youtube.com/watch?v=789def', 'Introduction to Biology', 'An overview of basic biology concepts and life sciences.', 'CBA', 1],
    [25, 'https://www.youtube.com/watch?v=xyz123', 'Chemistry Essentials', 'Foundational concepts in chemistry, including atoms, molecules, and chemical reactions.', 'CBA', 1]
];
$Schedule=[
    [1, 1,  '2024-04-29' , '09:00:00', '11:00:00', 'Room A', 1, 'Introduction to Programming', '2024-04-22 00:00:00', 'GL', 2],
    [2, 2,  '2024-04-29' ,'13:00:00', '15:00:00', 'Room B', 2, 'Database Management', '2024-04-23 00:00:00', 'GL', 2],
    [3, 3,  '2024-04-30' ,'14:00:00', '16:00:00', 'Room C', 3, 'Network Security', '2024-04-24 00:00:00', 'GL', 2],
    [4, 4,  '2024-04-30' ,'09:00:00', '11:00:00', 'Room D', 4, 'Web Development', '2024-04-25 00:00:00', 'GL', 2],
    [5, 5,  '2024-05-01' ,'08:00:00', '10:00:00', 'Room E', 5, 'Computer Architecture', '2024-04-26 00:00:00', 'GL', 2],
    [6, 6,  '2024-05-01' ,'14:00:00', '16:00:00', 'Room F', 6, 'Software Engineering', '2024-04-29 00:00:00', 'GL', 2],
    [7, 7,  '2024-05-02' ,'09:00:00', '11:00:00', 'Room G', 7, 'Operating Systems', '2024-04-30 00:00:00', 'GL', 2],
    [8, 8,  '2024-05-02' ,'13:00:00', '15:00:00', 'Room H', 8, 'Data Structures', '2024-05-01 00:00:00', 'GL', 2],
    [9, 9,  '2024-05-03' ,'10:00:00', '12:00:00', 'Room I', 9, 'Cybersecurity Fundamentals', '2024-05-02 00:00:00', 'GL', 2],
    [10,10,  '2024-05-04' ,'09:00:00', '11:00:00', 'Room J', 10, 'Software Testing', '2024-05-03 00:00:00', 'GL', 2],
    [11,11,  '2024-05-05' ,'11:00:00', '13:00:00', 'Room K', 11, 'Computer Networks', '2024-05-06 00:00:00', 'GL', 2],
    [12,12,  '2024-05-05' ,'14:00:00', '16:00:00', 'Room L', 12, 'Information Security', '2024-05-07 00:00:00', 'GL', 2],
    [13,13,  '2024-05-06' ,'08:00:00', '10:00:00', 'Room M', 13, 'Artificial Intelligence', '2024-05-08 00:00:00', 'GL', 2],
    [14,14,  '2024-05-06' ,'13:00:00', '15:00:00', 'Room N', 14, 'Mobile App Development', '2024-05-09 00:00:00', 'GL', 2],
    [15, 5,  '2024-05-01' ,'10:00:00', '12:00:00', 'Room E', 5, 'Computer Architecture', '2024-04-26 00:00:00', 'GL', 2],
    [16, 5,  '2024-05-01' ,'14:00:00', '16:00:00', 'Room E', 5, 'Computer Architecture', '2024-04-26 00:00:00', 'GL', 3],
    [17,5,  '2024-05-03' ,'08:00:00', '10:00:00', 'Room M', 5, 'Artificial Intelligence', '2024-05-08 00:00:00', 'GL', 2],
    [18,5,  '2024-05-03' ,'10:00:00', '11:30:00', 'Room M', 5, 'Artificial Intelligence', '2024-05-08 00:00:00', 'GL', 1],
    [19,5,  '2024-05-03' ,'14:00:00', '16:00:00', 'Room M', 5, 'Artificial Intelligence', '2024-05-08 00:00:00', 'GL', 3],

];

$admins = [
    [1, 'adminuser', 'admin@example.com', 'admin123']
];


function insert($keys, $table, $db, $func)
{
    foreach ($table as $element) {
        $associative_element = array_combine($keys, $element);
        $db::$func($associative_element);
    }
}




// uncomment these to run
// in dbcreation, i replaced 'INSERT INTO TABLE' with 'REPLACE INTO TABLE'
// so even if u leave it uncommented it's fine 





insert(['id', 'firstname', 'lastname', 'email', 'password', 'phone',
    'address', 'birthdate', 'gender', 'nationality', 'field', 'studylevel', 'class'],
    $students, 'ConnexionBD', 'insertData_etudiant');

insert(['id', 'firstname', 'lastname', 'email', 'password', 'phone', 'gender'],
    $teachers, 'ConnexionBD', 'insertData_prof');

insert(['id', 'coursename', 'teacher', 'field', 'studylevel'],
    $courses, 'ConnexionBD', 'insertData_course');

insert(['student', 'course', 'absencedate'],
    $absences, 'ConnexionBD', 'insertData_abscence');

insert(['id', 'username', 'email', 'password'],
    $admins, 'ConnexionBD', 'insertData_admin');

insert(['id','url','title','description','field','studylevel'],
$courseVideos, 'ConnexionBD', 'insertData_coursevideo');


insert(['schedule_id','course_id','start_date', 'start_time', 'end_time', 'room', 'instructor', 'description', 'expiry_date', 'field', 'studylevel'],
$Schedule, 'ConnexionBD', 'insertData_schedule');







/////////////////// old db ////////////////////////////////////////////





// ConnexionBD::insertData_etudiant(array('firstname' => 'foulen', 'lastname' => 'fouleni',
//         'email' => 'demo@insat.com', 'password' => 'demo1234', 'phone' => 12345678,
//         'address' => '5 Rue de la Liberté Tunis', 'birthdate' => '1999-01-01', 'gender' => 'M',
//     'nationality' => 'Tunisian', 'field' => 'GL', 'studylevel' => 2, 'class' => 2));


// // insert demo prof

// ConnexionBD::insertData_prof(array('firstname' => 'prof name', 'lastname' => 'prof lastname',
//         'email' => 'profdemo@insat.com', 'password' => 'profdemo1234', 'phone' => 12345678,
//          'gender' => 'Male'));
// ConnexionBD::insertData_prof(array('firstname' => 'profdemo', 'lastname' => 'prof lastname2','email' => 'prof.demo@insat.com', 'password' => 'prof1234', 'phone' => 0123456, 'gender' => 'F'));


// // insert demo course
// ConnexionBD::insertData_course(array('coursename' => 'web', 'teacher' => '1'));
// ConnexionBD::insertData_course(array('coursename' => 'java', 'teacher' => '1'));
// ConnexionBD::insertData_course(array('coursename' => 'python', 'teacher' => '4'));
// ConnexionBD::insertData_course(array('coursename' => 'english', 'teacher' => '5'));


// // insert demo abscence for our student demo (foulene fouleni ) with the id 24
// ConnexionBD::insertData_abscence(array('student' => '24', 'course' => '1', 'absencedate' => '2021-05-01'));
// ConnexionBD::insertData_abscence(array('student' => '24', 'course' => '1', 'absencedate' => '2021-05-02'));
// ConnexionBD::insertData_abscence(array('student' => '24', 'course' => '2', 'absencedate' => '2024-04-01'));
// ConnexionBD::insertData_abscence(array('student' => '19', 'course' => '3', 'absencedate' => '2024-03-22'));
// ConnexionBD::insertData_abscence(array('student' => '19', 'course' => '4', 'absencedate' => '2024-03-22'));
// ConnexionBD::insertData_abscence(array('student' => '17', 'course' => '3', 'absencedate' => '2024-03-22'));
// ConnexionBD::insertData_abscence(array('student' => '18', 'course' => '4', 'absencedate' => '2024-03-26'));
// ConnexionBD::insertData_abscence(array('student' => '17', 'course' => '4', 'absencedate' => '2024-03-28'));


// //insert admin
// ConnexionBD::insertData_admin(array('username' => 'admin', 'email' => 'admin.admin@ucar.tn','password' => 'admin1234'));
