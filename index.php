<?php
  require 'config/config.php';
  session_start();
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('location: login.php');
  }
  if($_SESSION['role'] != 0){
    header('location: login.php');
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
    <section class="content-header">
      <div class="container-fluid">
        <h1 style="text-align:center !important;">Blog Site</h1><br>
      </div>
        <?php 
          if(!empty($_GET['pageno'])){
            $pageno = $_GET['pageno'];
          }else{
            $pageno = 1;
          }
            $numOfrecords = 6;
            $offest = ($pageno-1)*$numOfrecords;

            $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
            $stmt->execute();
            $rawOutput = $stmt->fetchAll();
            $total_pages = ceil(count($rawOutput)/$numOfrecords);

            $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offest,$numOfrecords");
            $stmt->execute();
            $output = $stmt->fetchAll();
        ?>  
        <div class="row">
          <?php
            foreach($output as $item){
          ?>
          <div class="col-md-4">
            <div class="card card-widget">
              <div class="card-header">
                <div class="card-title" style="text-align:center !important;float:none;">
                    <h4 ><?php echo $item['title'];?></h4>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="blogdetail.php?id=<?php echo $item['id']?>"><img class="img-fluid pad" src="admin/images/<?php echo $item['image'];?>" alt="Photo" style="width :100% !important;height:200px !important;"></a>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <?php
            }
          ?>
            </div>
            <div class="row"  style="float:right; margin-right:0px;">
              <nav aria-label="Page navigation example">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <= 1){echo'disabled';}?>">
                    <a class="page-link" href="<?php if($pageno <= 1){echo "#";}else{ echo "?pageno=".($pageno-1);}?>">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno;?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages){echo'disabled';}?>">
                    <a class="page-link" href="<?php if($pageno >= $total_pages){echo "#";}else{ echo "?pageno=".($pageno+1);}?>">Next</a></li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages;?>">Last</a></li>
                  </ul>
              </nav>
            </div><br>
            
      </div>
            <!-- /.card -->
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

< <!-- Main Footer -->
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
