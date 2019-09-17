<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
    require_once "connect.php";

    $sql = "CREATE TABLE bookings (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(50),
        surname VARCHAR(50),
        hotelname VARCHAR(50),
        indate VARCHAR(30),
        outdate VARCHAR(30),
      
    )";

    $conn->query($sql);
    echo $conn->error;
    ?>

<h1>Las Vegas hotel booking</h1>
<main class="container hotel">

  
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="form">
                <div class="form-group col-md-6">
                        <label for="firstName">First name</label>
                        <input type="text" class="form-control" placeholder="First name" name="firstname" required>
                </div>
                <br>
                <div class="form-group col-md-6">
                        <label for="surname">Last name</label>
                        <input type="text" class="form-control" placeholder="Last name" name="surname" required>
                </div>
                <br>
                <div class="form-group col-md-6">
                <label for="hotels">Select a hotel below :</label>
                <select class="form-control form-control-lg" name="hotelname" id="hotelName" required>
                        <option value=" ">  </option>
                        <option value="The Orleans - R700 per night">The Orleans - R700 per night</option>
                        <option value="Bellagio - R600 per night">Bellagio - R600 per night </option>
                        <option value="The Four Queens - R700 per night">The Four Queens - R700 per night</option>
                        <option value="The Cosmopolitan - R800 per night">The Cosmopolitan - R800 per night </option>
                        
                </select>
                </div>
                <br>
                <br>
                <div class="form-group col-md-6">
                <label for="start">Start date :</label>
                <input type="date" class="form-control" name="indate" min="2018-01-01" max="2020-12-31" aria-label="Todo Date" aria-describedby="button-addon2">
                <label for="end">End date :</label>
                <input type="date" class="form-control" name="outdate" min="2018-01-01" max="2020-12-31" aria-label="Todo Date" aria-describedby="button-addon2">
             </div>
                <!-- <div class="form-group">
                        <label for="numberOfDays">NUMBER OF DAYS</label>
                        <input type="number" class="form-control" placeholder="Number Of Days" min=1 name="numberOfDays" id="nums" required>
                </div> -->
                <br>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>
                <br>
                
        
</main>       
       

    </body>
</html>