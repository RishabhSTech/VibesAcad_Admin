<?php
    
    if(isset($_POST["submit"])) {
        
        die('stopped');
        
        if($_FILES["fileToUpload"]["error"] == 0) {
            
            $fileName = $_FILES["fileToUpload"]["tmp_name"];

            $file = fopen($fileName, "r");

            fgetcsv($file);

            include 'inc/function.php';
            $allactions = new Actions();
        
            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                $email = $data[0];
                $call_outcome = $data[1];
                $final_status = $data[2];

               $sqlQuery = "UPDATE `payments` SET `final_status`='".$final_status."' WHERE email = '".$email."'";
               $result = mysqli_query($allactions->dbConnect, $sqlQuery);
               
               if ($result) {
               
                    $sqlQuery2 = "SELECT id FROM `payments` WHERE email = '$email'";
                    $result2 = mysqli_query($allactions->dbConnect, $sqlQuery2);
               
                    if ($result2 && mysqli_num_rows($result2) > 0) {
               
                        while ($row = mysqli_fetch_assoc($result2)) {
                            
                            $sqlQuery = "UPDATE `call_attempt` SET `call_outcome`='".$call_outcome."' WHERE trans_id = ".$row['id'];
                            $result = mysqli_query($allactions->dbConnect, $sqlQuery);
                            
                        }
                    }
                } 
            }

            fclose($file);
            echo "CSV file imported successfully!";
        } else {
            echo "Error uploading file!";
        }
    }
?>
    
    
    <h2>Import CSV File</h2>
    <form action="import.php" method="post" enctype="multipart/form-data">
        Select CSV file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload" required="">
        <input type="submit" value="Upload CSV" name="submit">
    </form>

    

