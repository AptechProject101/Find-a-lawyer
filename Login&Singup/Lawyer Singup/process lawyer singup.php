<?php
include "..//conn.php";
session_start();

// Ensure required session variables are set
$required_fields = [
    'first-name', 'last-name', 'email', 'number', 'address', 'password',
    'bar_council_number', 'practicing_since', 'specialization', 'description',
    'degrees', 'universities', 'languages_spoken', 'availability', 'fee', 'about-me', 'profile-image'
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
$password = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
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

// Debugging: Print session variables
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

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
?>
