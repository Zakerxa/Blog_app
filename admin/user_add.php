<?php
require '../config/config.php';
session_start();
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('location: login.php');
  
}
if($_SESSION['role'] != 1){
    header('location: login.php');
}
if($_POST){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        if(empty($_POST['role'])){
            $role = 0;
        }else{
            $role = 1;
        }
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(':email',$email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            echo"<script>alert('Email duplicated');window.location.href='user_add.php';</script>";
        
        }else{
        $stmt = $pdo->prepare("INSERT INTO users(name,email,password,role) VALUES(:name,:email,:password,:role)");
        $result=$stmt->execute(
            array(
                ':name'=>$name,
                ':email'=>$email,
                ':password'=>$password,
                ':role'=>$role
                )
            );
        
        if($result){
            echo"<script>alert('Successfully added');window.location.href='user_list.php';</script>";

            }
            
    
        }
       
    
}


?>

<?php include('header.php')?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              
            <div class="card-body">
                <form action="user_add.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" id="" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" id="" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" id="" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Admin</label><br>
                        <input type="checkbox" name="role" id="" value="1">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Create" id="" class="btn btn-success">
                        <a href="user_list.php" type="button" class="btn btn-warning">Back</a>
                    </div>
                </form>
            </div>
              
            </div>
            <!-- /.card -->

            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('footer.html')?>
