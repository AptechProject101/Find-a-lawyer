<?php
session_start();
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure the upload directories exist
    $target_dir_profile = "uploads/";
    $target_dir_cover = "cover_images/";
    
    if (!is_dir($target_dir_profile)) {
        mkdir($target_dir_profile, 0777, true);
    }
    
    if (!is_dir($target_dir_cover)) {
        mkdir($target_dir_cover, 0777, true);
    }

    // Handle profile image upload
    $target_file_profile = $target_dir_profile . basename($_FILES["profile-image"]["name"]);
    $imageFileType_profile = strtolower(pathinfo($target_file_profile, PATHINFO_EXTENSION));

    // Validate the profile image
    $check_profile = getimagesize($_FILES["profile-image"]["tmp_name"]);
    if ($check_profile === false) {
        die("Profile image is not valid.");
    }

    // Validate profile image size
    if ($_FILES["profile-image"]["size"] > 500000) {
        die("Sorry, your profile image is too large.");
    }

    // Validate profile image format
    $allowedFormats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType_profile, $allowedFormats)) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed for the profile image.");
    }

    // Upload the profile image
    if (!move_uploaded_file($_FILES["profile-image"]["tmp_name"], $target_file_profile)) {
        die("Sorry, there was an error uploading your profile image.");
    }

    // Handle cover image upload
    $target_file_cover = $target_dir_cover . basename($_FILES["cover-image"]["name"]);
    $imageFileType_cover = strtolower(pathinfo($target_file_cover, PATHINFO_EXTENSION));

    // Validate the cover image
    $check_cover = getimagesize($_FILES["cover-image"]["tmp_name"]);
    if ($check_cover === false) {
        die("Cover image is not valid.");
    }

    // Validate cover image size
    if ($_FILES["cover-image"]["size"] > 1000000) {  // Assuming a larger size limit for cover images
        die("Sorry, your cover image is too large.");
    }

    // Validate cover image format
    if (!in_array($imageFileType_cover, $allowedFormats)) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed for the cover image.");
    }

    // Upload the cover image
    if (!move_uploaded_file($_FILES["cover-image"]["tmp_name"], $target_file_cover)) {
        die("Sorry, there was an error uploading your cover image.");
    }

    // Set session variables
    $_SESSION['profile-image'] = basename($_FILES["profile-image"]["name"]);
    $_SESSION['cover-image'] = basename($_FILES["cover-image"]["name"]);
    // $_SESSION['about-me'] = $_POST['about-me'];
    // $_SESSION['languages_spoken'] = $_POST['languages_spoken'];

    // Ensure required session variables are set
    $required_fields = [
        'first-name', 'last-name', 'email', 'number', 'address', 'password',
        'bar_council_number', 'practicing_since', 'specialization', 'description',
        'degrees', 'universities', 'languages_spoken', 'availability','fee', 'profile-image', 'cover-image', 'about-me'
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
    $profileImage = $_SESSION['profile-image'];
    $coverImage = $_SESSION['cover-image'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO lawyer (`name`, `last name`, `email`, `number`, `address`, `password`, `bar council`, `since`, `specialist`, `description`, `degree`, `university`, `language`, `available`,`fee`, `image`, `cover image`, `about me`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssssss", $firstName, $lastName, $email, $number, $address, $password, $barCouncil, $since, $specialist, $description, $degree, $university, $language, $available, $fee, $profileImage, $coverImage, $aboutMe);

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
    <link rel="stylesheet" href="..//styles1.css">
    <!-- Include Bootstrap CSS -->
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Custom CSS for round input -->
    <style>
        .file-input-wrapper {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            background-color: gray;
            text-align: center;
            line-height: 100px;
            cursor: pointer;
            position: relative;
        }

        .file-input-wrapper::after {
            content: 'Upload';
            display: block;
            color: #6c757d;
            font-weight: bold;
        }

        .file-input-wrapper:hover {
            background-color: #e9ecef;
        }

        .file-input-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .file-input-wrapper input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        } 
    </style>
</head>

<body>
    <div class="container">
        <div class="left-section">
            <div class="logo">
                <a href="index.html">Law<span>firm.</span></a>
            </div>
            <h1>Create a Lawyer Account</h1>
            <p>Upload your profile image and tell us about yourself.</p>
            <p class="instructions">Please upload a professional profile image and a cover image. Write a detailed description of your life and experience as a lawyer, including information about your education, career achievements, and personal interests.</p>
        </div>
        <div class="right-section">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Profile Image</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="profile-image" name="profile-image" accept="image/*" required onchange="previewImage(event, 'profile-preview')">
                        <img id="profile-preview" src="#" alt="" style="display:none;">
                    </div>
                </div>

                <div class="form-group">
                    <label>Cover Image</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="cover-image" name="cover-image" accept="image/*" required onchange="previewImage(event, 'cover-preview')">
                        <img id="cover-preview" src="#" alt="" style="display:none;">
                    </div>
                </div>

                <button type="button" class="previous-button" onclick="history.back()">Previous</button>
                <button type="submit">Finish</button>
            </form>
        </div>
    </div>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function previewImage(event, id) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function () {
                const preview = document.getElementById(id);
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
