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
        booked INT(4)
    )";

    $conn->query($sql);
    echo $conn->error;
    ?>

<div class="container">
        <div class="row">
            <div class="col" >
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group">
                        <label for="firstName">First name</label>
                        <input type="text" class="form-control" placeholder="First name" name="firstname" required>
                </div>
                <br>
                <div class="form-group">
                        <label for="surname">Last name</label>
                        <input type="text" class="form-control" placeholder="Last name" name="surname" required>
                </div>
                <br>
                <label for="hotels">Select a hotel below :</label>
                <select class="form-control form-control-lg" name="hotelname" id="hotelName" required>
                        <option value="The Orleans">The Orleans </option>
                        <option value="Bellagio">Bellagio </option>
                        <option value="The Four Queens">The Four Queens</option>
                        <option value="The Cosmopolitan">The Cosmopolitan </option>
                        
                </select>
                <br>
                <br>
                <input type="date" class="form-control" name="indate" min="2018-01-01" max="2020-12-31" aria-label="Todo Date" aria-describedby="button-addon2">
                <input type="date" class="form-control" name="outdate" min="2018-01-01" max="2020-12-31" aria-label="Todo Date" aria-describedby="button-addon2">

                <!-- <div class="form-group">
                        <label for="numberOfDays">NUMBER OF DAYS</label>
                        <input type="number" class="form-control" placeholder="Number Of Days" min=1 name="numberOfDays" id="nums" required>
                </div> -->
                <br>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>
                <br>
                
           
            </div>
           
        </div>
    </div>

    </body>
</html>