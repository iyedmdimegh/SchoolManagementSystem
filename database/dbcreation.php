<?php
/*if (!isset($running_form)) {
    die('This script cannot be accessed directly');
}*/
require_once('fpdf/fpdf.php');

class ConnexionBD
{
    private static string $_dbname = "insatplatform";
    private static string $_user = "root";
    private static string $_pwd = "";
    private static string $_host = "localhost";
    private static $_bdd = null;
    private function __construct()
    {
        try {
            // Create the database if it doesn't exist
            self::createDatabase();

            // create database connexion
            self::$_bdd = new PDO("mysql:host=" . self::$_host . ";dbname=" . self::$_dbname .
                ";charset=utf8", self::$_user, self::$_pwd,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));

            // Rest of your code...
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }

        try {
            // create database connexion
            self::$_bdd = new PDO("mysql:host=" . self::$_host . ";dbname=" . self::$_dbname .
                ";charset=utf8", self::$_user, self::$_pwd,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));

            // create student table
            self::$_bdd ->query("create table if not exists student 
                    (id INT primary key auto_increment, firstname VARCHAR(50),
                    lastname VARCHAR(50), email VARCHAR(50), password VARCHAR(80),
                    phone INT(8), address VARCHAR(80), birthdate DATE, gender VARCHAR(10),
                    nationality VARCHAR(50), field VARCHAR(50), studylevel INT, class INT);"
            );

            //create request table
            self::$_bdd ->query("create table if not exists request 
                    (id INT primary key auto_increment, firstname VARCHAR(50),
                    lastname VARCHAR(50), email VARCHAR(50), 
                    phone INT(8), address VARCHAR(80), birthdate DATE, gender VARCHAR(10),
                    nationality VARCHAR(50), field VARCHAR(50), education VARCHAR(50), 
                    program VARCHAR(50), achievements TEXT, essay TEXT);"
            );

            //create teacher table
            self::$_bdd ->query("create table if not exists teacher 
                    (id INT primary key auto_increment, firstname VARCHAR(50),
                    lastname VARCHAR(50), email VARCHAR(50), password VARCHAR(80), 
                    phone INT(8), gender VARCHAR(10));"
            );

            //create course table
            self::$_bdd ->query("create table if not exists course 
                    (id INT primary key auto_increment, coursename VARCHAR(50), 
                     teacher INT, field VARCHAR(50), studylevel INT,
                    FOREIGN KEY(teacher) REFERENCES teacher(id));"
            );

            //create absence table
            self::$_bdd ->query("create table if not exists absence 
                    (student INT, course INT, 
                     absencedate DATE, 
                     PRIMARY KEY(student, course, absencedate),
                     FOREIGN KEY(student) REFERENCES student(id),
                    FOREIGN KEY(course) REFERENCES course(id));"
            );
            //create admin table
            self::$_bdd ->query("create table if not exists admin 
                    (id INT primary key auto_increment, username VARCHAR(50),email VARCHAR(50),
                    password VARCHAR(80));"
            );
            //create coursevideo table
            self::$_bdd ->query("create table if not exists coursevideo 
                    (id INT primary key auto_increment, title VARCHAR(150),url VARCHAR(150) ,description varchar(500),field VARCHAR(50), studylevel INT);"
            );
            // create schedule table
            self::$_bdd ->query("CREATE TABLE if not exists Schedule (
                schedule_id INT AUTO_INCREMENT PRIMARY KEY,
                course_id INT,
                start_date date,
                start_time TIME,
                end_time TIME,
                room VARCHAR(50),
                instructor INT,
                description VARCHAR(255),
                expiry_date DATETIME,
                field VARCHAR(50), 
                studylevel INT,
                FOREIGN KEY (course_id) REFERENCES Course(id),
                FOREIGN KEY (instructor) REFERENCES Teacher(id)
            );"
            );
            // Create the view after creating the tables
            self::$_bdd ->query("CREATE OR REPLACE VIEW user_auth AS
            SELECT id, email, password, 'student' AS type
            FROM student
            UNION ALL
            SELECT id, email, password, 'teacher' AS type
            FROM teacher
            UNION ALL
            SELECT id, email, password, 'admin' AS type
            FROM admin
            ");
            // Create a trigger that verifies when inserting or updating the absence table whether the student is enrolled in the course
            self::$_bdd ->query("
                CREATE OR REPLACE TRIGGER check_student_course
                BEFORE INSERT ON absence FOR EACH ROW
                BEGIN
                    DECLARE std_field VARCHAR(50);
                    DECLARE std_level INT;
                    DECLARE crs_field VARCHAR(50);
                    DECLARE crs_level INT;
                    SELECT field INTO std_field FROM student WHERE id = NEW.student;
                    SELECT studylevel INTO std_level FROM student WHERE id = NEW.student;
                    SELECT field INTO crs_field FROM course WHERE id = NEW.course;
                    SELECT studylevel INTO crs_level FROM course WHERE id = NEW.course;
                    IF (std_field != crs_field OR std_level != crs_level) THEN
                        SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'Student is not enrolled in the course';
                    END IF;
                END;
            ");

        
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    public static function getInstance()
    {
        if (!self::$_bdd) {
            new ConnexionBD();
        }
        return (self::$_bdd);
    }

    // Create the database if it doesn't exist
    public static function createDatabase(): void
    {
        try {
            // Connect to MySQL server
            $pdo = new PDO("mysql:host=" . self::$_host, self::$_user, self::$_pwd);

            // Check if the database already exists
            $stmt = $pdo->prepare("SHOW DATABASES LIKE :dbname");
            $stmt->execute(['dbname' => self::$_dbname]);

            if ($stmt->rowCount() == 0) {
                // Database does not exist, so create it
                $pdo->exec("CREATE DATABASE IF NOT EXISTS " . self::$_dbname);
                $running_db_creation = true;
                require_once('insertdemo.php');
            }
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //insert data into admin table
    public static function insertData_admin($data)
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("
                REPLACE INTO admin (id, username, email, password)
                    VALUES (:id, :username, :email, :password) 
                ");

            // Hash the password before storing
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['password'] = $hashedPassword;
            $stmt->execute($data);
            echo "Data inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }

    // insert data into the table etudiant
    public static function insertData_etudiant($data): void
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("
                REPLACE INTO student (id, firstname, lastname, email, password,
                                     phone, address, birthdate, nationality,
                                     gender, field, studylevel, class)
                    VALUES (:id, :firstname, :lastname, :email, :password,
                            :phone, :address, :birthdate, :nationality, 
                            :gender, :field, :studylevel, :class) 
            ");

            // Hash the password before storing
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['password'] = $hashedPassword;
            $stmt->execute($data);
            echo "Data inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }
    // insert data into the table prof
    public static function insertData_prof($data): void
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("
                REPLACE INTO teacher (id, firstname, lastname, email, password,phone,gender)
                    VALUES (:id, :firstname, :lastname, :email, :password,:phone,:gender) 
                ");

            // Hash the password before storing
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['password'] = $hashedPassword;
            $stmt->execute($data);
            echo "Data inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }
    // insert data into the table course
    public static function insertData_course($data): void
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("
                REPLACE INTO course (id, coursename, teacher, field, studylevel)
                    VALUES (:id, :coursename, :teacher, :field, :studylevel) 
                ");

            
            $stmt->execute($data);
            echo "Data inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }
    // insert data into the table abscence
    public static function insertData_abscence($data): void
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("
                REPLACE INTO absence ( student,course,absencedate)
                    VALUES (:student,:course,:absencedate) 
            ");
            $stmt->execute($data);
            echo "abscence is inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }
    // insert data into the table courseVideo
    public static function insertData_courseVideo($data): void
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("
                REPLACE INTO courseVideo (id, url,title,description,field , studylevel)
                    VALUES (:id,:url,:title,:description,:field,:studylevel) 
            ");
            $stmt->execute($data);
            echo "courseVideo is inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }
    // insert data into the table Schedule
    public static function insertData_schedule($data): void
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("
                REPLACE INTO schedule (schedule_id,course_id,start_date, start_time, end_time, room, instructor, description, expiry_date, field, studylevel)
                    VALUES (:schedule_id,:course_id,:start_date, :start_time, :end_time, :room, :instructor, :description, :expiry_date, :field, :studylevel) 
            ");
            $stmt->execute($data);
            echo "schedule is inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }

    // shows the data from a table in the database
    public static function showData($table)
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->query("SELECT * FROM $table");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            
            return $result;
        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
        }
    }

    public static function getStudents()
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->query("SELECT * FROM student;");
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result;

        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return null;
        }
    }

    public static function getTeachers()
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->query("SELECT * FROM teacher;");
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result;

        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return null;
        }
    }

    public static function getAbsences()
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->query("SELECT a.student AS studentID, CONCAT(s.firstname, ' ', s.lastname) AS studentname, 
                                    c.coursename, a.absencedate FROM absence a
                                    JOIN student s ON s.id = a.student
                                    JOIN course c ON c.id = a.course;");
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result;

        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return null;
        }
    }

    // get the VideoCourses of a student 
    public static function getVideosByLevel()
{
    try {
        $pdo = self::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM coursevideo WHERE (studylevel = :studylevel AND field = :field)");
        $stmt->bindParam(':studylevel', $_SESSION['studylevel'], PDO::PARAM_INT);
        $stmt->bindParam(':field', $_SESSION['field'], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    } catch (PDOException $e) {
        echo "Error fetching data: " . $e->getMessage();
        return null;
    }
}
    public static function getUserInfo($user_type)
    {
        try {

            $pdo = self::getInstance();
            if ($user_type == 'student') {
                $stmt = $pdo->query("SELECT id,firstname , lastname,email,phone,address,birthdate,gender,nationality,field,studylevel,class FROM student WHERE id = " . $_SESSION['user_id']);
            } elseif ($user_type == 'teacher') {
                $stmt = $pdo->query("SELECT id,firstname , lastname,email,phone, gender FROM teacher WHERE id = " . $_SESSION['user_id']);
            }
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return null;
        }
    }

    public static function getCoursesOfTeacher($id)
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->query("SELECT * FROM course WHERE teacher = ".$id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return null;
        }
    }
    public static function getScheduleTeacher()
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM schedule WHERE instructor = :instructor");
            $stmt->execute(array(':instructor' => $_SESSION['user_id']));
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return null;
        }
    }
    public static function getScheduleStudent()
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM schedule WHERE field = :field AND studylevel = :studylevel");
            $stmt->execute(array(':field' => $_SESSION['field'], ':studylevel' => $_SESSION['studylevel']));
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return null;
        }
    }

    public static function getStudentsByTeacher($teacherId) {
        // Connect to the database
        $pdo = self::getInstance();
        // Prepare the SQL query
        $sql = "SELECT s.*, CONCAT('(', c.id, ') ',c.coursename) AS enrolledcourse FROM student s
                    JOIN course c ON s.field = c.field AND s.studylevel = c.studylevel
                    JOIN teacher t ON c.teacher = t.id
                    WHERE c.teacher = :teacherId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':teacherId', $teacherId);
        // Execute the query
        $stmt->execute();
        // Fetch the results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function get_statistics(): ?array
    {
        try {
            $pdo = self::getInstance();
            $result = [];

            // 'studentsPerYear':
            $stmt = $pdo->query("SELECT studylevel,count(id) as nbStudents FROM student group by(studylevel);");
            $result[] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 'absencePerMonth':
            $stmt = self::getInstance()->query("SELECT absencedate,count(*) as nbAbsences FROM absence group by(absencedate);");
            $result[] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //'studentsPerGender':
            $stmt = self::getInstance()->query("SELECT gender,count(*) as nbStudents FROM student group by(gender);");
            $result[] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 'studentsPerField':
            $stmt = self::getInstance()->query("SELECT field,count(*) as nbStudents FROM student group by(field);");
            $result[] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 'teachersPerCourse':
            $stmt = self::getInstance()->query("SELECT coursename,count(teacher) as nbTeachers FROM course group by(coursename);");
            $result[] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return null;
        }
    }


    /**
     * * inserts the new submission in the request table
     */
    public static function add_submission($data): void
    {
        try {
            $pdo = self::getInstance();
            $numberOfSubmissions = $pdo->query("SELECT COUNT(*) FROM request")->fetchColumn();
            if ($numberOfSubmissions == 0) {
                $data = ["id" => 1] + $data;
            } else {
                $data = ["id" => $numberOfSubmissions + 1] + $data;
            }
            $stmt = $pdo->prepare("INSERT INTO request (id, firstname, lastname, email, phone,
                                                            address, birthdate, gender, nationality,
                                                            education, program, achievements, essay)
                                  VALUES (:id, :firstname, :lastname, :email, :phone, :address, 
                                          :birthdate, :gender, :nationality, :education, 
                                          :program, :achievements, :essay);
            ");
            $stmt->execute($data);
            echo "Data inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }

    /**
     * *deletes the submission that has the same email
     * @param email email associated to the submission
     */
    public static function delete_submission($email)
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("DELETE FROM request WHERE email = :email");
            $email = substr($email, 0, -4);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error deleting submission: " . $e->getMessage();
        }
    }
    
    /**
     * *generates a pdf file using the data given in the submission
     * @param data the data given in the submission
     */
    private static function generate_pdf($data)
{
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set font for title
    $pdf->SetFont('Arial', 'B', 16);
    
    // Set title color to red
    $pdf->SetTextColor(179, 0, 0);  // #B30000 in RGB

    // Add title
    $pdf->Cell(0, 10, 'Admission Application', 0, 1, 'C');
    $pdf->Ln(10);

    // Reset text color to black for other text
    $pdf->SetTextColor(0, 0, 0);

    // Add image at the top left
    $pdf->Image(__DIR__ . '/../dashboard/src/logo-insat.png', 1, 1, 20);  // Adjust path and dimensions as needed

    $pdf->SetFont('Arial', '', 12);

    foreach ($data as $key => $value) {
        // Set field label color to red
        $pdf->SetTextColor(179, 0, 0);  // #B30000 in RGB
        $pdf->Cell(50, 10, ucfirst(str_replace("_", " ", $key)) . ':', 0, 0);
        
        // Reset text color to black for field value
        $pdf->SetTextColor(0, 0, 0);
        
        $pdf->Cell(0, 10, $value, 0, 1);
    }

    // Save PDF to a file with the email address as the filename
    $pdfFileName = '../../admission/admission_pdf/' . $data['email'] . '.pdf';
    $pdf->Output($pdfFileName, 'F');
}


/**
 * Generates a pdf file for each submission in the database
 * Deletes all existing PDF files in the directory before generating new ones
 */
public static function generate_pdf_for_all_submissions()
{
    try {
        // Delete all existing PDF files in the directory
        $pdfDirectory = '../../admission/admission_pdf/';
        $files = glob($pdfDirectory . '*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }

        $pdo = self::getInstance();
        $stmt = $pdo->query("SELECT * FROM request");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            self::generate_pdf($row);
        }

        echo "PDF files generated successfully";
    } catch (PDOException $e) {
        echo "Error generating PDF: " . $e->getMessage();
    }
}

    /**
     * * adding new student to Student table using his email
     * @param email the email of the student to be added
     */
    public static function addStudent_byemail($email)
    {
        try {
            $pdo = self::getInstance();

            // Select the student with the given email
            $stmt = $pdo->prepare("SELECT * FROM request WHERE email = :email");
            $email = substr($email, 0, -4);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $student = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$student) {
                echo "No student found with the provided email.";
                return;
            }

            // Generate a random password
            $password = self::generateRandomPassword();

            // Selecting the class with the least number of students in the same field
            $stmt = $pdo->prepare("SELECT class, COUNT(*) as num_students 
                                    FROM student 
                                    WHERE field = :field 
                                    GROUP BY class 
                                    ORDER BY num_students ASC 
                                    LIMIT 1;");
            $stmt->execute($student['field']);

            $classInfo = $stmt->fetch(PDO::FETCH_ASSOC);
            $selectedClass = $classInfo['class'];

            // Use insertData_etudiant to add the student to the student table
            $data = [
                'firstname' => $student['firstname'],
                'lastname' => $student['lastname'],
                'email' => $student['email'],
                'password' => $password,
                'phone' => $student['phone'],
                'address' => $student['address'],
                'birthdate' => $student['birthdate'],
                'nationality' => $student['nationality'],
                'gender' => $student['gender'],
                'field' => $student['field'],
                'studylevel' => $student['studylevel'],
                'class' => $selectedClass
            ];

            // Send email to the student using PHPMailer
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);


            // Gmail SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@gmail.com'; // Your Gmail email address
            $mail->Password = 'your_password'; // Your Gmail password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('admin@school.com', 'School Administration');
            $mail->addAddress($student['email'], $student['firstname'] . ' ' . $student['lastname']);
            $mail->Subject = 'Welcome to Our School';
            $mail->Body    = "Dear " . $student['firstname'] . " " . $student['lastname'] . ",\n\n" .
                             "Congratulations! You have been accepted to our school.\n" .
                             "Your password is: " . $password . "\n\n" .
                             "Please keep this password secure and do not share it with anyone.\n\n" .
                             "Best regards,\n" .
                             "School Administration";

            $mail->send();

            echo "Email sent successfully.";

            self::insertData_etudiant($data);
            echo "Student added successfully.";
        } catch (PDOException $e) {
            echo "Error adding student: " . $e->getMessage();
        }
    }   

    /**
     * * generates a random password
     * @param length the length of the password with the default value of 8
     */
    private static function generateRandomPassword($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+{}|:<>?';
        $charactersLength = strlen($characters);
        $randomPassword = '';

        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomPassword;
    }

}