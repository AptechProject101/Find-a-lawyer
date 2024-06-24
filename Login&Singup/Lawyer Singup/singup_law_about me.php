<?php
session_start();
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile-image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate the image
    $check = getimagesize($_FILES["profile-image"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    // Validate file size
    if ($_FILES["profile-image"]["size"] > 500000) {
        die("Sorry, your file is too large.");
    }

    // Validate file format
    $allowedFormats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedFormats)) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Upload the file
    if (!move_uploaded_file($_FILES["profile-image"]["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
    }

    // Set session variables
    $_SESSION['profile-image'] = basename($_FILES["profile-image"]["name"]);
    $_SESSION['about-me'] = $_POST['about-me'];
    $_SESSION['languages_spoken'] = $_POST['languages_spoken'];


    // Ensure required session variables are set
    $required_fields = [
        'first-name', 'last-name', 'email', 'number', 'address', 'password',
        'bar_council_number', 'practicing_since', 'specialization', 'description',
        'degrees', 'universities', 'languages_spoken', 'availability','fee', 'profile-image', 'about-me'
    ];

    foreach ($required_fields as $field) {
        if (!isset($_SESSION[$field])) {
            die("Error: Missing required field $field.");
        }
    }

    // Retrieve data from session
    $firstName = $_SESSION['first-name'];
    $lastName = $_SESSION['last-name'];
    $email = $_SESSION['email'];
    $number = $_SESSION['number'];
    $address = $_SESSION['address'];
    $password = $_SESSION['password'];
    $barCouncil = $_SESSION['bar_council_number'];
    $since = $_SESSION['practicing_since'];
    $specialist = $_SESSION['specialization'];
    $description = $_SESSION['description'];
    $degree = $_SESSION['degrees'];
    $university = $_SESSION['universities'];
    $language = $_SESSION['languages_spoken'];
    $available = $_SESSION['availability'];
    $fee = $_SESSION['fee'];
    $aboutMe = $_SESSION['about-me'];
    $image = $_SESSION['profile-image'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO lawyer (`name`, `last name`, `email`, `number`, `address`, `password`, `bar council`, `since`, `specialist`, `description`, `degree`, `university`, `language`, `available`,`fee`, `image`, `about me`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssssssss", $firstName, $lastName, $email, $number, $address, $password, $barCouncil, $since, $specialist, $description, $degree, $university, $language, $available, $fee, $image, $aboutMe);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Clear session data
    session_unset();
    session_destroy();

    // Redirect to a thank you page
    header('Location: thank_you.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="../styles1.css">
</head>

<body>
    <div class="container">
        <div class="left-section">
            <div class="logo">
                <a href="index.html">Law<span>firm.</span></a>
            </div>
            <h1>Create a Lawyer Account</h1>
            <p>Upload your profile image and tell us about yourself.</p>
            <p class="instructions">Please upload a professional image and write a detailed description of your life and experience as a lawyer. Include information about your education, career achievements, and personal interests.</p>
        </div>
        <div class="right-section">
            <form method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <select id="languages_spoken" name="languages_spoken" class="custom-select" required>
                        <option value="" disabled selected>Select Languages Spoken</option>
                        <?php
                        $languages = [
                            "English", "Spanish", "French", "German", "Chinese", "Japanese", "Korean", "Italian", "Russian", "Portuguese", "Hindi", "Arabic", "Bengali", "Urdu", "Indonesian", "Turkish", "Vietnamese", "Thai", "Polish", "Dutch", "Swedish", "Greek", "Hebrew", "Norwegian", "Danish", "Finnish", "Czech", "Hungarian", "Romanian", "Slovak", "Bulgarian", "Croatian", "Serbian", "Slovenian", "Lithuanian", "Latvian", "Estonian", "Maltese", "Icelandic", "Irish", "Welsh", "Scottish Gaelic", "Basque", "Catalan", "Galician"
                        ];

                        foreach ($languages as $language) {
                            echo '<option value="' . htmlspecialchars($language) . '">' . htmlspecialchars($language) . '</option>';
                        }
                        ?>
                    </select>
                    <label for="languages_spoken" class="custom-label">Languages Spoken</label>
                </div>

                <div class="input-group">
                    <input type="file" id="profile-image" name="profile-image" required>
                    <label for="profile-image">Profile Image</label>
                </div>
                <div class="input-group">
                    <textarea id="about-me" name="about-me" placeholder=" " rows="5" required></textarea>
                    <label for="about-me">About Me</label>
                    <small class="condition">Describe your life and experience as a lawyer. Include details about your education, career achievements, and personal interests.</small>
                </div>
                <button type="button" class="previous-button" onclick="history.back()">Previous</button>
                <button type="submit">Finish</button>
            </form>
        </div>
    </div>
</body>

</html>