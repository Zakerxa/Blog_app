<?php
  require 'config/config.php';
  session_start();
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('location: login.php');
  }
  if($_SESSION['role'] != 0){
    header('location: login.php');
  }
  
  //for showing result
  $stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  //for comment
  $blogId = $_GET['id'];
  if($_POST){
  $comment = $_POST['comment'];

  $stmt = $pdo->prepare("INSERT INTO comments(content,author_id,post_id) VALUES(:content,:author_id,:post_id)");
        $result=$stmt->execute(
            array(
                ':content'=>$comment,
                ':author_id'=>$_SESSION['user_id'],
                ':post_id'=>$blogId
                )
            );
        
        if($result){
            header('location: blogdetail.php?id='.$_GET['id']);

        }
  }
  //for showing comments
  $stmtcmt = $pdo->prepare("SELECT * FROM comments WHERE post_id=$blogId");
  $stmtcmt->execute();
  $cmtOutput = $stmtcmt->fetchAll();
  
  $outputauth=[];
  if($cmtOutput){
  foreach($cmtOutput as $key =>$value){
    
  $authorId =$cmtOutput[$key]['author_id'];
  $stmtauth = $pdo->prepare("SELECT * FROM users WHERE id=$authorId");
  $stmtauth->execute();
  $outputauth[] = $stmtauth->fetchAll();
  
  }

  }

            
            
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blog Site</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <div class="">

        <div class="row">
          <div class="col-md-12">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <div class="card-title" style="text-align:center !important;float:none;">
                  <h4><?php echo $result['title']?></h4>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <img class="img-fluid pad" src="admin/images/<?php echo $result['image']?>" alt="Photo" width="100%">
                <br><br>
                <p><?php echo $result['content']?></p><hr>
                <h3>Comments</h3><hr>
                <a href="index.php" type="button" class="btn btn-default">Go Back</a>
              </div>
              <!-- /.card-body -->
              <div class="card-footer card-comments">
                <div class="card-comment">
                <?php
                  if($cmtOutput){
                ?>
                  <div class="comment-text" style="margin-left:0px !important;float:none;">
                  <?php foreach($cmtOutput as $key => $value){
                  ?>
                  <span class="username">
                      <?php echo $outputauth[$key][0]['name'];?>
                      <span class="text-muted float-right"><?php echo $value['created_at']?></span>
                    </span><!-- /.username -->
                    <?php echo $value['content']?>
                  <?php
                  }
                  ?>
                  </div>
                <?php
                  }
                ?>

                </div>
                <!-- /.card-comment -->
              </div>
              <!-- /.card-footer -->
              <div class="card-footer">
                <form action="" method="post">
                  <div class="img-push">
                    <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

 <!-- Main Footer -->
 <footer class="main-footer" style="margin-left:0px !important;">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline mb-2">
    <a href="logout.php" type="button" class="btn btn-default">Logout</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 <a href="https://adminlte.io">Sunshine</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
