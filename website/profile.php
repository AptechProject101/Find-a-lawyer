<?php
include('header.php');
include('connection.php');

// Check if 'id' parameter is set in the URL
if(isset($_GET['id'])) {
    // Fetch details for a specific lawyer based on 'id'
    $id = $_GET['id'];
    $sql = "SELECT *
            FROM lawyer
            JOIN categorie ON categorie.id = lawyer.specialist
            WHERE lawyer.id = '$id';";
    $res = mysqli_query($con, $sql);
    if(mysqli_num_rows($res) > 0) {
        $data = mysqli_fetch_assoc($res);
?>

<!-- HTML for displaying detailed lawyer information -->
<link rel="stylesheet" href="profile.css">
<div class="box">
    <div class="container-fluid" style="width: 500px; margin-left: 0px;">
        <img src="banner.webp" class="img-fluid" id="ban" alt="..." style="border-radius: 5px; max-width:800px; margin-left:0px;">
    </div>
    <div class="profile">
        <div class="image"><img src="<?php echo $data['image']?>" alt="" style="scale: 1.1;"></div>
        <h1><?php echo $data['name']?> <?php echo $data['last name']?></h1>  
        <p class="ex "><?php echo $data['since']?>yrs Experience</p><br>
    </div>
              
    <p class="bio"><?php echo $data['cat_name']?></p>
              
    <p class="add "><?php echo $data['address']?></p>
    <a href=""><button class="appoint">Appointment</button></a>

    <div class="about">
        <h2>About</h2>
        <p><?php echo $data['about me']?></p>
    </div><br>

    <div class="education">
        <h2>Services</h2>
        <ul>
            <li><?php echo $data['description']?></li>
        </ul>
    </div><br><br>

    <div class="education">
        <h2>Available Timings</h2>
        <ul>
            <li><?php echo $data['available']?></li>
        </ul>
    </div><br><br>

    <div class="education">
        <h2>Education</h2>
        <ul>
            <li>I have got the law degree from <?php echo $data['university']?></li>
        </ul>
    </div><br><br><br>
</div>

<?php
    } else {
        echo "<p>No lawyer found with ID: $id</p>";
    }
} else {
    // Display a list of lawyers or handle other cases
    // Example: Fetch list of lawyers and display links to their profiles
}
include('footer.php');
?>
