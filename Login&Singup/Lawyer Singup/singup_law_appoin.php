<?php
include "../conn.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $availability = [];

    foreach ($_POST['availability'] as $day => $times) {
        if (isset($times['enabled'])) {
            $availability[] = [
                'day' => $day,
                'start' => date("g:i A", strtotime($times['start'])),
                'end' => date("g:i A", strtotime($times['end']))
            ];
        }
    }

    $_SESSION['availability'] = json_encode($availability);
    $_SESSION['fee'] = $_POST['fee'];
    header("Location: singup_law_about me.php"); 
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="left-section">
            <div class="logo">
                <a href="index.html">Law<span>firm.</span></a>
            </div>
            <h1>Create a Lawyer Account</h1>
            <p>Enter your Professional Background</p>
            <p class="instructions">Please enter the languages you speak and your availability.</p>
        </div>
        <div class="right-section">
            <form action="" method="POST">
            <div class="input-group">
                    <input type="number" id="fee" name="fee" placeholder=" " required>
                    <label for="fee">Fee</label>
                </div>

                <div class="availability-section">
                    <h2>Availability</h2>
                    <?php
                    $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                    foreach ($days as $day) {
                        echo '<div class="day-group">';
                        echo '<label>' . $day . '</label>';
                        echo '<input type="checkbox" name="availability[' . $day . '][enabled]" value="1">';
                        echo '<input type="time" name="availability[' . $day . '][start]" class="time-input">';
                        echo '<input type="time" name="availability[' . $day . '][end]" class="time-input">';
                        echo '</div>';
                    }
                    ?>
                </div>
                <button type="button" class="previous-button" onclick="history.back()">Previous</button>
                <button type="submit">Next</button>
            </form>
        </div>
    </div>
</body>

</html>
