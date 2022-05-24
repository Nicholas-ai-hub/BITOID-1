<?php
     
if($_SERVER["REQUEST_METHOD"] === "POST"){

   //მივიღოთ ყველა გადაცემული(დასაბმითებული) მონაცემი ფორმიდან
   $image = $_FILES["image"]["name"];
   $saxeliErr = "";
   $gvariErr = "";


    //თუ ღილაკ Submit-ს არის დაჭერილი, მაშინ...
   
    if(isset($_POST["upload"])){
        //გზა ატვირთული სურათის შესანახად
        $target = "images/". basename($_FILES["image"]["name"]);

        //მონაცემთა ბაზასთან კავშირი
        $db = mysqli_connect('localhost', 'root', '', 'photos');

        //მივიღოთ ყველა გადაცემული(დასაბმითებული) მონაცემი ფორმიდან
        $image = $_FILES["image"]["name"];
        $saxeli = $_POST['saxeli'];
        $gvari = $_POST['gvari'];
     
                //რატომ მიჩვენებს test_input-ზე ერორს ვერ გავარკვიე
                // if(empty($_POST["saxeli"])){
                //     $saxeliErr = "შეავსეთ სახელის ველი";
                // }else{
                //     $saxeli = test_input($_POST["saxeli"]);
                //     if (!preg_match("/^[a-zA-Z-' ]*$/",$saxeli)) {
                //         $saxeliErr = "only letters required";
                //     }
                // }

                // if (empty($_POST["gvari"])) {
                //     $gvariErr = "შეავსეთ გვარის ველი";
                // } else {
                //     $gvari = test_input($_POST["gvari"]);
                //     if (!preg_match("/^[a-zA-Z-' ]*$/",$gvari)) {
                //     $gvariErr = "only letters required";
                //     }
                // }
        $sql = "INSERT INTO images (image, saxeli, gvari) VALUES('$image','$saxeli', '$gvari')";
        mysqli_query($db, $sql); //ინახავს დასაბმითებულ მონაცემებს მონაცემთა ბაზის ცხრილში სახელად images

        //გადავამისამართოთ სურათი ფოლდერში სახელად images
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
            $msg = "სურათი აიტვირთა წარმატებით";
        }else{
            $msg = "დაფიქსირდა შეცდომა სურათის ატვირთვისას";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="content">
        <?php

            $db = mysqli_connect("localhost", "root", "", "photos");
            $sql = "SELECT * FROM images";
            $result = mysqli_query($db, $sql);
            while($row = mysqli_fetch_array($result)){
                echo "<div id='img_div'>";
                echo "<img src='images/".$row['image']."' >";
                echo "<p>" .$row['saxeli']. '<br>'.$row['gvari'] ."</p>";
                echo "</div>";
            }


        ?>
        <form action="index.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="size" value="100000">
            <div>
                <label for="surati">პროფილის სურათი: </label>
                <input type="file" name="image">
            </div>
            <div>
                <label>სახელი: </label>
                <input type="text" name="saxeli"><br>
                <label>გვარი: </label>
                <input type="text" name="gvari">

            </div>
            <div>
                <input type="submit" name="upload" value="შედეგის ნახვა">
            </div>
        </form>
    </div>


</body>
</html>