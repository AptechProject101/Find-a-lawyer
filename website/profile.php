<?php
include('header.php');
?>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
<link rel="stylesheet" href="profile.css">
<div class="box">
    <div class="container-fluid" style="width: 500px; margin-left: 0px;">
        <img src="banner.webp" class="img-fluid" id="ban" alt="..." style="border-radius: 5px; max-width:800px; margin-left:0px;">
    </div>
    <div class="profile">
        <div class="image"><img src="ammar.jpeg" alt="" style="scale: 1.1;"></div>
        <h1>Ammar Motan</h1>
        <p class="ex ">5yrs Experience</p><br>
    </div>

    <p class="bio">Divorce & Murder lawyer | Frontend Developer | Backend Developer</p>

    <p class="add ">Karachi Division Sindh Pakistan</p>
    <a href=""><button class="appoint">Appointment</button></a>

    <div class="about">
        <h2>About</h2>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nostrum eaque sunt cumque ducimus delectus optio, quis facilis perspiciatis, incidunt dolores rem pariatur mollitia nam neque vero libero veritatis dolore aliquid nobis a dolorem ipsam quaerat totam sit. Explicabo ea, iure ut temporibus architecto, quam exercitationem porro magni minus, ad vel unde voluptates voluptatibus illo sed cumque obcaecati! Id hic eum nostrum commodi. Magni, illo consectetur officia, minima ut recusandae voluptatibus cupiditate sit facere odit dolorum similique molestiae libero hic! Possimus cum dolore id nihil impedit consequatur assumenda aut recusandae illum, beatae qui voluptas a? Laboriosam blanditiis exercitationem odit eum cumque!</p>
    </div><br>


    <div class="education">
        <h2>Services</h2>
        <p>
        <ul>
            <li>2yrs Experice in High Court as a Murder Lawyer</li>
        </ul>
        </p>
        <p>
        <ul>
            <li>3yrs Experience in Supreme Court as a Divorce Lawyer</li>
        </ul>
        </p>
    </div><br><br>

    <div class="education">
        <h2>Experience</h2>
        <p>
        <ul>
            <li>2yrs Experience in High Court as a Murder Lawyer</li>
        </ul>
        </p>
        <p>
        <ul>
            <li>3yrs Experience in Supreme Court as a Divorce Lawyer</li>
        </ul>
        </p>
    </div><br><br>

    <div class="education">
        <h2>Education</h2>
        <p>
        <ul>
            <li>St PAUL'S English High School</li>
        </ul>
        </p>
        <p>
        <ul>
            <li>St PAUL'S English High School</li>
        </ul>
        </p>
    </div><br><br><br>
</div>



<?php
include('footer.php');
?>
=======
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
        <div class="image"><img src="<?php echo $data['image'] ?>" alt="" style="scale: 1.1;"></div>
        <h1><?php echo $data['name'] ?> <?php echo $data['last name'] ?></h1>
        <p class="ex "><?php echo $data['since'] ?>yrs Experience</p><br>
    </div>

    <p class="bio"><?php echo $data['cat_name'] ?></p>

    <p class="add "><?php echo $data['address'] ?></p>
    <a href=""><button class="appoint">Appointment</button></a>

    <div class="about">
        <h2>About</h2>
        <p><?php echo $data['about me'] ?></p>
    </div><br>

    <div class="education">
        <h2>Services</h2>
        <ul>
            <li><?php echo $data['description'] ?></li>
        </ul>
    </div><br><br>

    <div class="education">
        <h2>Available Timings</h2>
        <ul>
            <li><?php echo $data['available'] ?></li>
        </ul>
    </div><br><br>

    <div class="education">
        <h2>Education</h2>
        <ul>
            <li>I have got the law degree from <?php echo $data['university'] ?></li>
        </ul>
    </div><br><br><br>
</div>

<?php
include('footer.php');
?>