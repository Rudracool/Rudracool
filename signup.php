<?php require 'database/db_connection.php';?>
<?php require 'uploadimg/upload.php';?>

<?php 
  if(isset($_POST['submit'])){
     
    $name = mysqli_real_escape_string($con ,trim($_POST['name']));
    $email = mysqli_real_escape_string($con,trim($_POST['email']));
    $mobile = mysqli_real_escape_string($con,trim($_POST['mobile']));
    $password = mysqli_real_escape_string($con,trim($_POST['password']));
    // image upload section
     
       $avatar_name=  $_FILES['avatar']['name'] ;
       $avatar_name= preg_replace("/-+/","_",$avatar_name);
       $avatar_tmpname = $_FILES['avatar']['tmp_name'];
       $avatar_size= $_FILES['avatar']['size'];
       $avatar_type= $_FILES['avatar']['type'];
       $avatar_ext = pathinfo($avatar_name, PATHINFO_EXTENSION);
        $avatar_name= pathinfo($avatar_name, PATHINFO_FILENAME);
        $photo=  $avatar_name."_".date("mjYHis").".".$avatar_ext;


        // validation section
        $name_valid = $email_valid = $mobile_valid = $password_valid = $avatar_name_valid = false;
        //check name
       if (!empty($name)) {
            if(strlen($name) > 2 && strlen($name) <= 30){
                 if(!preg_match('/[^a-zA-z\s]/' ,$name)){
                         
                         //all test passed !!
                        $name_valid = true;
                        // echo "full name is ok !! <br>";

                 }else{/*Invalid characters*/ echo "Name can contain only alphabets <br>";}
            }else{/*Invalid length*/ echo "Name must be between 2 to 30 chars long. <br>";}
       }else{ /* blank input */ echo "Name can not be blank. <br> ";}
        
        //check email
       if(!empty($email)){
             if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                  
                  //all test passed !!
                 $email_valid = true;
                 // echo "Email is ok !!  <br>";

             }else{ /*Invalid email*/echo $email." is an invalid email adress. <br>";}
       }else{ /*Blank input*/ echo "Email can not be blank. <br>";}

        //Mobile number validation
        if(!empty($mobile)){
               if(strlen($mobile) === 10){
                
                   //all test passed !!
                   $mobile_valid = true;
                   // echo "Mobile number is ok !! <br>";

               }else{ /*Invalid Mobile number*/ echo "Enter a valid mobile number. <br>";}
        }else{ /*Blank Input*/ echo "mubile number is required. <br>";}

        //Password validation
        if(!empty($password)){
               if (strlen($password) >= 5 && strlen($password) <= 15) {
                   
                   //all test passed !!
                   $password_valid = true ;
                   // $password = md5($password);
                   // echo "Password is ok !! <br>";

               }else{/*Invalid length*/ echo $password." = password must be between 5 to 15 chars. <br>";}
        }else{ /*Blank input*/ echo "Password Can not be blank. <br>";}

        //photo validation
        if(!empty($avatar_name)){
                if($avatar_size < 1000000){
                      if($avatar_ext == "jpg" || $avatar_ext == "jpeg" || $avatar_ext == "png"){
                          //store image to following path

                          //all test passed !!
                          $avatar_name_valid = true;
                          $final_file = "uploadimg/images/".$photo;
                          $upload= move_uploaded_file($avatar_tmpname, $final_file);
                          if ($upload) {
                              // echo "file upload sucessfully !!";
                          }else{ /*upload a folder*/ echo "file not uploaded";}

                      }else{ /*format of the image*/ echo "Only Jpg , Jpeg , Png file are allowed to upload. <br>";}
                }else{/*size of a image*/ echo "image size is too large";}
        }else{ /*Blank input*/ echo "please select an image to upload. <br>";}

         
        $query = "INSERT INTO form_table(name,email,mobile,password,avatar_path) VALUES ('$name' , '$email' , '$mobile' , '$password' ,'$final_file' )";
        $fire = mysqli_query($con , $query) or die("data not inserted ".mysqli_error($con));

       if($fire){
         
            ?>
              <script>
                   alert('Sign up Sucessfully');
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
    <title>Sign up form</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet"  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    
    
    
</head>
<body>
    

   <div class="container">
     <div class="row">
       <div class="col-lg-12 ">
     
        <!-- signup form -->
         <div class="col-lg-4 col-lg-offset-4">
           <h3>Sign Up</h3>
           <hr>

           <form action="<?php $_SERVER['PHP_SELF']?> " method="POST" name="signup" id="signup" enctype="multipart/form-data">
             <div class="form-group">
             <label for="fullname">Name</label>
             <input type="text" name="name"  id="name"   class="form-control" placeholder="enter your name" required>
             </div>

             <div class="form-group">
               <label for="email">Email</label>
               <input type="email" name="email"  id="email"   class="form-control" placeholder="enter your email" required>
             </div>

             <div class="form-group">
                <label for="username">Mobile no</label>
                <input type="text" name="mobile"  id="mobile"   class="form-control" placeholder="enter your mobile no" required >
             </div>

             <div class="form-group">
                 <label for="password">Password</label>
                 <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
             </div>

             <div class="form-group">
                  <label for="avatar">upload your photo</label>
                  <input type="file" name="avatar" id="avatar" class="form-control" required>

             </div>

           <!--   <div class="form-group">
                    <input type="submit"  name="uploadimg" id="uploadimg" class="btn btn-primary" 
              value="upload image">
             </div> -->
              
              <div class="form-group">
                  <button name="submit" id="submit" class="btn btn-primary btn-block">Sign up</button>
              </div>          
           </form>
         </div> 
       </div>                  
     </div>
   </div>
</body>
</html>