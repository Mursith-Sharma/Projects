  <?php

   class register 
   {
    public static function testregister()
    {
        include("database.php");

        $connection = Database::getconnection(); 

        if(isset($_POST['submit']))
        {
        $name = $_POST['fullname'];
        $email = $_POST['email'];
        $contact = $_POST['mobile'];                                 // athil idum data inai post method valiyaga nam create panna variable $number.. etc il save aagum
        $nic = $_POST['nic'];
        $dob = $_POST['Dob'];
        $occup = $_POST['occupation'];
        $gender = $_POST['gender'];

        $sql = "INSERT INTO resident (id, full_name, dob, nic, address, phone,  email, occupation, gender, registered_date) VALUES ('', '$name', '$dob', '$nic', '' , '$contact', '$email' ,'$occup' ,'$gender', '')";
 

        //$result = mysqli_query($connection ,"insert into users values('', '$name','$email', '$password', '$number' )");     you can use this

        $result = mysqli_query($connection ,$sql);      
        if($result)
        {
          echo "user registration succesfully, you can login now";
        }
        else
        {
          echo "registration failed, somthing went wrong!!";
        }
        mysqli_close ($connection);

      }
    }
   }
   register::testregister();

  ?>
