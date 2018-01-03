<?php 
include_once "BugsRepConfig.php";
include 'includes/fetch_records.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Shop Managent System">
        <meta name="author" content="Bwire Charles Mashauri">

        <link rel="shortcut icon" href="../img/favicon_1.ico">

        <title>Bugs - Admin Dashboard</title>
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/ionicon/css/ionicons.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="assets/morris/morris.css">
        <link href="assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/helper.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet" />


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','../../../www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62751496-1', 'auto');
  ga('send', 'pageview');

</script>

    </head>


    <body>

     
        <aside class="left-panel">

       
            <div class="logo">
                <a href="./" class="logo-expanded">
                    <img src="img/single-logo.png" alt="logo">
                    <span class="nav-label">Bugs Reporting</span>
                </a>
            </div>

            <nav class="navigation">
                <ul class="list-unstyled">
                    <li class="has-submenu active"><a href="#"><i class="ion-home"></i> <span class="nav-label">Home</span></a>
                        <ul class="list-unstyled">
                            <li class="active"><a href="./">Dashboard</a></li>
                      
                        </ul>
                    </li>
                   
                    <li class="has-submenu"><a href="#"><i class="ion-bag"></i> <span class="nav-label">Reports</span></a>
                        <ul class="list-unstyled">
                            <li><a href="report.php">General Issue Reports</a></li>
							<li><a href="#">Pending Issues Reports</a></li>
							<li><a href="#">Closed Issues Reports</a></li>
							<li><a href="#">Reassignment Issues Reports</a></li></ul>
                    </li>
                    
            </nav>
                
        </aside>

        <section class="content">
            
          
            

            <div class="wraper container-fluid">

                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 bg-success">
                            <i class="ion-android-contacts"></i> 
                            <h2 class="m-0 counter"><?php echo number_format($system_users); ?></h2>
                            <div>System Users</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 bg-purple">
                            <i class="ion-ios7-cart"></i> 
                            <h2 class="m-0 counter"><?php echo number_format($tickets); ?></h2>
                            <div>Total Tickets</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 bg-danger">
                            <i class="ion-close-circled"></i> 
                            <h2 class="m-0 counter"><?php echo number_format($open); ?></h2>
                            <div>Open Tickets</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 bg-warning">
                            <i class="ion-alert-circled"></i> 
                            <h2 class="m-0 counter"><?php echo number_format($closed); ?></h2>
                            <div>Closed Tickets</div>
                        </div>
                    </div>
                </div> 


               
            <footer class="footer">
                <?php echo date('Y'); ?> © Developed by Wycliffe Onyiego.
            </footer>
        </section>
		<script type="text/javascript">
	</script>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/modernizr.min.js"></script>
        <script src="js/pace.min.js"></script>
        <script src="js/wow.min.js"></script>
        <script src="js/jquery.scrollTo.min.js"></script>
        <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="assets/chat/moment-2.2.1.js"></script>
        <script src="js/waypoints.min.js" type="text/javascript"></script>
        <script src="js/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="assets/easypie-chart/easypiechart.min.js"></script>
        <script src="assets/easypie-chart/jquery.easypiechart.min.js"></script>
        <script src="assets/easypie-chart/example.js"></script>
        <script src="assets/c3-chart/d3.v3.min.js"></script>
        <script src="assets/c3-chart/c3.js"></script>
        <script src="assets/morris/morris.min.js"></script>
        <script src="assets/morris/raphael.min.js"></script>
        <script src="assets/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/sparkline-chart/chart-sparkline.js" type="text/javascript"></script> 
        <script src="assets/sweet-alert/sweet-alert.min.js"></script>
        <script src="assets/sweet-alert/sweet-alert.init.js"></script>
        <script src="js/jquery.app.js"></script>
        <script src="js/jquery.chat.js"></script>
        <script src="js/jquery.dashboard.js"></script>
        <script src="js/jquery.todo.js"></script>
		 <script src="js/canvasjs.min.js"></script>


        <script type="text/javascript">

            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });
            });
        </script>
    

    </body>

</html>
