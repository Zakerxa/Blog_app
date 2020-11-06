<?php
require '../config/config.php';
session_start();
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('location: login.php');
  
}
if($_POST){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        if(empty($_POST['role'])){
            $role = 0;
        }else{
            $role = 1;
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND id != :id");
        $stmt->execute(
            array(
                ':email'=> $email,
                ':id' => $id
            )
        );
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            echo"<script>alert('Email duplicated');window.location.href='user_edit.php';</script>";
        
        }else{
        $stmt = $pdo->prepare("UPDATE  users SET name='$name',email='$email',role='$role' WHERE id='$id'");
        $result=$stmt->execute();
        
        if($result){
            echo"<script>alert('Successfully Updated');window.location.href='user_list.php';</script>";

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
            <?php 
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id =".$_GET['id']);
                $stmt->execute();
                $output = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>  
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $output['id']?>">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" id="" class="form-control" value="<?php echo $output['name']?>">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" id="" class="form-control" value="<?php echo $output['email']?>">
                    </div>
                    <div class="form-group">
                        <label for="">Admin</label><br>
                        <input type="checkbox" name="role" id="" value="1"<?php echo $output['role'] == 1 ? 'checked':''?>>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Update" id="" class="btn btn-primary">
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
