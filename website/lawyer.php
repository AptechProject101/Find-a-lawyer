<?php
include ('header.php');
include ('connection.php');

$q = "select * from lawyer join categorie on categorie.id=lawyer.specialist";

$res = mysqli_query($con, $q);
?>
    <style>
        .pro-card {
            border: 1px solid #03045e;
            margin-bottom: 20px;
            padding: 20px;
            overflow-wrap: break-word;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 20px;
            box-shadow: 5px 5px 10px lightgray;
            transition: 0.5s;
    }
    
    a .pro-card:hover {
        transform: translateY(-5px);
    }
    </style>
<link rel="stylesheet" href="lawyer.css">
    <div class="banner">
        <div class="content">
            <h2>Find A Lawyer</h2>
            <p><a href="index.php" style="text-decoration: none; color: #fff;">Home</a> -> Book A Table</p>
        </div>
</div><br><br>
<center>
    <div class="input-wrapper">
        <button class="icon" style="display:block;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="25px" width="25px">
                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#fff"
                    d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z">
                </path>
                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#fff" d="M22 22L20 20">
                </path>
            </svg>
        </button>
        <input placeholder="search.." class="input" name="text" type="text">
    </div><br><br>
</center>
<?php while ($data = mysqli_fetch_assoc($res)) { ?>
    <a href="profile.php?id=<?php echo $data['id'] ?>">
        <div class="card mb-3 pro-card" style="max-width: 800px; ">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?php echo $data['image'] ?>" class="img-fluid rounded-start" alt="..." style="width:100%;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title" style="font-size:30px;"><?php echo $data['name'] ?></h5>
                        <p class="card-text"><small class="text-muted"><?php echo $data['cat_name'] ?></small></p>
                        <p class="card-text"><?php echo $data['about me'] ?></p>
                        <p class="card-text"><b>Degree:</b> <?php echo $data['degree'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </a>
<?php } ?>
<?php
include ('footer.php');
?>