<?php  require 'database/db_connection.php';?>

<?php 
  
  if(isset($_POST['submit'])){
     $email = mysqli_real_escape_string( $con, trim($_POST['email']));
     $password = mysqli_real_escape_string( $con, trim($_POST['password']));

       //validation section 

       $email_valid = $password_valid = false ;

       // check email
        if(!empty($email)){
             if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                  
                  //all test passed !!
                 $email_valid = true;
                 // echo "Email is ok !!  <br>";

             }else{ /*Invalid email*/echo $email." is an invalid email adress. <br>";}
       }else{ /*Blank input*/ echo "Email can not be blank. <br>";}

       //check password 
         if(!empty($password)){
               if (strlen($password) >= 5 && strlen($password) <= 15) {
                   
                   //all test passed !!
                   $password_valid = true ;
                   // $password = md5($password);
                   // echo "Password is ok !! <br>";

               }else{/*Invalid length*/ echo $password." = password must be between 5 to 15 chars. <br>";}
        }else{ /*Blank input*/ echo "Password Can not be blank. <br>";}


        // check to database

        $query = "SELECT * FROM form_table WHERE email =  '$email'  AND  password = '$password'  ";
        $fire = mysqli_query($con , $query) or die("can not fetch the data to database".mysqli_error($con));
        if (mysqli_num_rows($fire) > 0) {
          
          ?>
            
            <script>
                 alert('Login sucessfully');
            </script>
          <?php
          
          header ('Location:database/db_connection.php');
        }else{

         
         ?>
           <script>
             alert('Incorrect Email id and Password');
           </script>
         <?php
           }



  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet"  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
</head>
<body>
    

   <div class="container">
     <div class="row">
       <div class="col-lg-12 ">
     
        <!-- signup form -->
         <div class="col-lg-4 col-lg-offset-4"  >
           <h3>Login</h3>
           <hr>

           <form action="<?php $_SERVER['PHP_SELF'] ?> " method="POST" name="signup" id="signup" enctype="multipart/form-data">
             <!-- <div class="form-group">
             <label for="fullname">Name</label>
             <input type="text" name="name"  id="name"   class="form-control" placeholder="enter your name" required>
             </div> -->

             <div class="form-group">
               <label for="email">Email</label>
               <input type="email" name="email"  id="email"   class="form-control" placeholder="enter your email" required>
             </div>

             <!-- <div class="form-group">
                <label for="username">Mobile no</label>
                <input type="text" name="mobile"  id="mobile"   class="form-control" placeholder="enter your mobile no" required >
             </div> -->

             <div class="form-group">
                 <label for="password">Password</label>
                 <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
             </div>

             <!-- <div class="form-group">
                  <label for="avatar">upload your photo</label>
                  <input type="file" name="avatar" id="avatar" class="form-control" required>

             </div> -->

           <!--   <div class="form-group">
                    <input type="submit"  name="uploadimg" id="uploadimg" class="btn btn-primary" 
              value="upload image">
             </div> -->
              
              <div class="form-group">
                  <button name="submit" id="submit" class="btn btn-primary btn-block">Login</button>
              </div>   

              <div class="form-group">
                <h5 >Don't have account ?  <a href="signup.php" >Sign up here</a></h5>
                
              </div>       
           </form>
         </div> 
       </div>                  
     </div>
   </div>
</body>
</html>