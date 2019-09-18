<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <!-- css link -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
  <!-- font link -->
<link href="https://fonts.googleapis.com/css?family=Concert+One|Source+Sans+Pro&display=swap" rel="stylesheet"> 
  <!-- bootstrap link -->

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
                
        
<?php
    if (isset($_POST['submit'])){
        $_SESSION['firstname'] = $_POST['firstname'];
        $_SESSION['surname'] = $_POST['surname'];
        $_SESSION['hotelname'] = $_POST['hotelname'];
        $_SESSION['indate'] = $_POST['indate'];
        $_SESSION['outdate'] = $_POST['outdate'];

        $datetime1 = new DateTime ($_SESSION['indate']);
        $datetime2 = new DateTime ($_SESSION['outdate']);
        $interval = $datetime1->diff($datetime2);
        $daysBooked = $interval->format('%R%a days');
        $value;

    switch($_POST['hotelname']){
        case "The Orleans - R700 per night " ;
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
            <button name='confirm' type='submit'> Confirm </button> </form>".'</div>';
            //echo "<form role='form' action=" . htmlspecialchars($_SERVER['PHP_SELF']) . " method='post'><input type='submit' name='confirm'>.'Confirm'.</form>";
    }
    if(isset($_POST['confirm'])){
    //Preparing and binding a statement
        $stmt=$conn->prepare("INSERT INTO bookings(firstname,surname,hotelname,indate,outdate) VALUES (?,?,?,?,?)");
        //set the parameters and execute the statement
        $stmt->bind_param('sssss', $firstname,$surname,$hotelname,$indate,$outdate);
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