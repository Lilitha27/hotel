<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- bootstrap link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- css link -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <!-- font link -->
    <link href="https://fonts.googleapis.com/css?family=Concert+One|Source+Sans+Pro&display=swap" rel="stylesheet"> 
    <title>Hotel Booking</title>
</head>
<body>
    <?php
        require_once "connect.php";

        $sql = "CREATE TABLE bookings (
            firstname VARCHAR(50),
            surname VARCHAR(50),
            hotelname VARCHAR(50),
            indate VARCHAR(30),
            outdate VARCHAR(30))";

        $conn->query($sql);
        echo $conn->error;
    ?>

<h1 class="head">Las Vegas hotel booking</h1>
    <main class="container hotel">
        <!-- the whole form -->
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="form">
            <div class="form-group col-md-6">
                <!-- input for firstname -->
                <label for="firstName">First name</label>
                <input type="text" class="form-control" placeholder="First name" name="firstname" required>
            </div>
            <br>
            <div class="form-group col-md-6">
                <!-- inut for lastname -->
                <label for="surname">Last name</label>
                <input type="text" class="form-control" placeholder="Last name" name="surname" required>
            </div>
            <br>
            <div class="form-group col-md-6">
                <!-- the 4 different hotels  -->
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
            <!-- the date in and out booking of the hotel -->
            <div class="form-group col-md-6">
                <label for="start">Start date :</label>
                <input type="date" class="form-control" name="indate" min="2018-01-01" max="2020-12-31" aria-label="Todo Date" aria-describedby="button-addon2">
                <label for="end">End date :</label>
                <input type="date" class="form-control" name="outdate" min="2018-01-01" max="2020-12-31" aria-label="Todo Date" aria-describedby="button-addon2">
             </div>
             <br>
                <!-- the submit button of the form -->
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
        <br>
                
        
    <?php
        // using session and post super-global to post the form
        if (isset($_POST['submit'])){
            $_SESSION['firstname'] = $_POST['firstname'];
            $_SESSION['surname'] = $_POST['surname'];
            $_SESSION['hotelname'] = $_POST['hotelname'];
            $_SESSION['indate'] = $_POST['indate'];
            $_SESSION['outdate'] = $_POST['outdate'];
            // subtracting the indate from the outdate
            $datetime1 = new DateTime ($_SESSION['indate']);
            $datetime2 = new DateTime ($_SESSION['outdate']);
            $interval = $datetime1->diff($datetime2);
            $daysBooked = $interval->format('%R%a days');
            $value;
        // using switch to calculate the total amount for bookings
        switch($_POST['hotelname']){
            case "The Orleans - R700 per night " ;
            // displaying the images of each hotel
            echo "<img src='images/orleans.jpg' id='images' >" . "<img src='images/orleans2.jpg' id='images' >" ;
            $value = $daysBooked * 700;
            break;

            case "Bellagio - R600 per night" :
            $value = $daysBooked * 600;
            echo "<img src='images/bel.jpg' id='images' >" . "<img src='images/bel2.jpg' id='images' >" ;
            
            break;

            case "The Four Queens - R700 per night" :
            echo "<img src='images/four.jpg' id='images' >" . "<img src='images/four2.jpg' id='images' >" ;
            $value = $daysBooked * 700;
            break;

            case "The Cosmopolitan - R800 per night" :
            echo "<img src='images/cosmo.jpg' id='images' >" . "<img src='images/cosmo2.jpg' id='images' >" ;
            $value = $daysBooked * 800;
            break;

            default :
            echo "Invalid Booking";
        }
        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];
        $result = mysqli_query($conn,"SELECT hotelname, indate, outdate, firstname, surname FROM bookings WHERE firstname='$firstname' && surname='$surname'");
        if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
                echo "<div class='duplicate'> You already have a booking. <br> Firstname: ". $row['firstname'] . "<br>
                Lastname: " . $row['surname'].
                "<br> Start Date: " . $row['indate'].
                "<br> End Date: " . $row['outdate'].
                "<br> Hotel Name: " . $row['hotelname'].
                "<br>" . $interval->format('%r%a days') . "<br> Total: R " . $value ."</div>" ."<br>";
        }
        }
                echo '<div class="return">'. "<br> Firstname:".  $_SESSION['firstname']."<br>".
                "surname:".  $_SESSION['surname']."<br>".
                "Start Date:". $_SESSION['indate']."<br>".
                "End Date:". $_SESSION['outdate']."<br>".
                "Hotel Name:". $_SESSION['hotelname']."<br>".
                "Total R" . $value ;
                echo "<form role='form' action=" . htmlspecialchars($_SERVER['PHP_SELF']) . " method='post'>
                <button type='submit' class='btn btn-primary' name='confirm'>Confirm</button></form>".'</div>';
                //echo "<form role='form' action=" . htmlspecialchars($_SERVER['PHP_SELF']) . " method='post'><input type='submit' name='confirm'>.'Confirm'.</form>";
        }
        if(isset($_POST['confirm'])){
        //Preparing and binding a statement
            $stmt=$conn->prepare("INSERT INTO bookings(firstname,surname,hotelname,indate,outdate) VALUES (?,?,?,?,?)");
            //binding the parametears
            $stmt->bind_param('sssss', $firstname,$surname,$hotelname,$indate,$outdate);
            //set the parameters and execute the statement
            $firstname=$_SESSION['firstname'];
            $surname=$_SESSION['surname'];
            $hotelname=$_SESSION['hotelname'];
            $indate=$_SESSION['indate'];
            $outdate=$_SESSION['outdate'];
            $stmt->execute();
            echo '<div id="confirmed">'."Booking successfully confirmed".'</div>';
        }
    
    ?>

</main>       
       
</body>
</html>