
<?php
include './includes/preferences.php';
include HEADER;
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>Senior Youth</title>
        
        <!-- CSS -->
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/simplegrid.css">
        <link rel="stylesheet" href="css/icomoon.css">
        <link rel="stylesheet" href="css/lightcase.css">
        <link rel="stylesheet" href="style.css">

        <!-- Google Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,900' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

        <style>
            img{
                height:350px !important;
            }
        </style>

        </head>
        <body id="home">
            <!-- Header -->
            
            <!-- End Header -->

            <!-- HOME Section -->
            <div class="parallax-section parallax1">
                <div class="grid grid-pad">
                    <div class="col-1-1">
                         <div class="content content-header" >
                            <h2>Welcome 
                            <?php
                                if(isset($_SESSION['user_id'])){
                                    echo $_SESSION['full_name'];
                                }
                                else if(isset($_SESSION['y_user_id'])){
                                    echo $_SESSION['y_full_name'];
                                }
                                else{
                                    echo "Guest";
                                }
                            ?>
                            </h2>
                            <p>“Remain patient and give all your respect to our beloved seniors; they have earned their dignity through their lifetimes.”</p>
                            <a target="_blank" class="btn btn-ghost" href="http://localhost/SeniorYouth#aboutus">Find Out More</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Parallax Section -->
            
            
            <!-- CurveUp -->
          <!--  <svg class="curveUpColor" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z"></path>
            </svg>

            ABOUT US Section -->
            <div class="wrap services-wrap" id="aboutus">
                <section class="grid grid-pad">
                    <h2 align="center">About Us</h2>
                    <div class="col-1-4 service-box service-1" >
                        <div class="content">
                            <div class="service-icon">
                                <i class="circle-icon icon-heart4"></i>
                            </div>
                            <div class="service-entry">
                                <h3>User-Friendly</h3>
                                <p>Easy to use for everyone.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-1-4 service-box service-2" >
                        <div class="content">
                            <div class="service-icon">
                                <i class="circle-icon icon-star4"></i>
                            </div>
                            <div class="service-entry">
                                <h3>Home Services</h3>
                                <p>Services delivered at your Door-Step. You can order Groceries and Fruits.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-1-4 service-box service-3">
                        <div class="content">
                            <div class="service-icon">
                                <i class="circle-icon icon-display"></i>
                            </div>
                            <div class="service-entry">
                                <h3>Entertainment</h3>
                                <p>All types of Enterainment and Devotional Videos can be acessed.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-1-4 service-box service-4" >
                        <div class="content">
                            <div class="service-icon">
                                <i class="circle-icon icon-user6"></i>
                            </div>
                            <div class="service-entry">
                                <h3>Health Related Services</h3>
                                <p>You can contact the nearby medicals and hospitals for instant delivery of medicines and appointments.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- End ABOUTUS Section -->
            
            <!-- CurveDown -->
          <svg class="curveDownColor" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 0 C 50 100 80 100 100 0 Z"></path>
            </svg>

            <!-- Services Section -->
            <div class="wrap blog-grid grey" id="services">
                <div class="grid grid-pad">
                    <div class="content" >
                        <h2>Services</h2>
                        <div class="col-1-2" >
                            <article class="post-wrap">
                                <div class="post-img">
                                    <a href="#0"><img src="./images/work/groceries.jpg" alt=""></a>
                                </div>
                                <div class="post">
                                    <h2 class="entry-title"><a href="#0">Groceries and Fruits</a></h2>
                                    <div class="post-meta">
                                        <a href="#0">Food</a>
                                    </div>
                                    <!-- <p>Get Groceries and Fruits at your door step.
                                    </p> -->
                                    <a class="btn read-more" href="groceries.php">View</a>
                                </div>
                            </article>
                        </div>
                        <!-- <div class="col-1-2" >
                            <article class="post-wrap">
                                <div class="post-img">
                                    <a href="#0"><img src="images/work/fruits.avif" alt=""></a>
                                </div>
                                <div class="post">
                                    <h2 class="entry-title"><a href="#0">Fruits</a></h2>
                                    <div class="post-meta">
                                        <a href="#0">Food</a>
                                    </div>
                                    <p>Get Fruits at your door step.
                                    </p>
                                    <a class="btn read-more" href="#0">Order</a>
                                </div>
                            </article>
                        </div> -->
                          <div class="col-1-2" >
                            <article class="post-wrap">
                                <div class="post-img">
                                    <a href="#0"><img src="images/work/medicines1.jpg" alt=""></a>
                                </div>
                                <div class="post">
                                    <h2 class="entry-title"><a href="#0">Medicines</a></h2>
                                    <div class="post-meta">
                                        <a href="#0">Health</a>
                                    </div>
                                    <!-- <p>Check out tour plans.
                                    </p> -->
                                    <a class="btn read-more" href="./medicines.php">View</a>
                                </div>
                            </article>
                        </div>
                        <div class="col-1-2" >
                            <article class="post-wrap">
                                <div class="post-img">
                                    <a href="#0"><img src="images/work/doctor.webp" alt=""></a>
                                </div>
                                <div class="post">
                                    <h2 class="entry-title"><a href="#0">Hospitals And Health Care</a></h2>
                                    <div class="post-meta">
                                        <a href="#0">Health</a>
                                    </div>
                                    <!-- <p>Track nearby hospitals.
                                    </p> -->
                                    <a class="btn read-more" href="./hospitals.php">View</a>
                                </div>
                            </article>
                        </div>
                         <!-- <div class="col-1-2" >
                            <article class="post-wrap">
                                <div class="post-img">
                                    <a href="#0"><img src="images/work/tiffin.webp" alt=""></a>
                                </div>
                                <div class="post">
                                    <h2 class="entry-title"><a href="#0">Home-Made Tiffins</a></h2>
                                    <div class="post-meta">
                                        <a href="#0">Food</a>
                                    </div>
                                    <p>Get home-made tiffins at your door step.
                                    </p> -->
                                    <!-- <a class="btn read-more" href="#0">Order</a>
                                </div>
                            </article>
                        </div> -->
                        <div class="col-1-2" >
                            <article class="post-wrap">
                                <div class="post-img">
                                    <a href="#0"><img src="images/work/music.webp" alt=""></a>
                                </div>
                                <div class="post">
                                    <h2 class="entry-title"><a href="#0">Music, Yoga and Many More</a></h2>
                                    <div class="post-meta">
                                        <a href="#0">Entertainement</a>
                                    </div>
                                    <!-- <p>Listen to your favourite movie on a click.
                                    </p> -->
                                    <a class="btn read-more" href="./entertainment.php">Listen</a>
                                </div>
                            </article>
                        </div>
                        <!-- <div class="col-1-1"><a class="btn" href="#0">View All</a></div> -->
                    </div>
                </div>
            </div>
            <!-- End SERVICES Section -->

            <!-- CurveUp -->
           <svg class="curveUpColor" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z"></path>
            </svg>
            
                      <!-- Quotes Section -->
            <div class="wrap services-wrap services" >
                <section class="grid grid-pad">
                    <div class="col-1-1 service-box cl-client-carousel-container">
                        <div class="content">
                            <div class="cl-client-carousel">
                                
                                <div class="item client-carousel-item"><!-- Start of item -->
                                <div class="quotes-icon">
                                    <i class="icon-quotes-left"></i>
                                </div>
                                <p>Caring about others, running the risk of feeling, and leaving an impact on people, brings happiness!</p>
                                <h4> ― Harold Kushner</h4>
                                </div><!-- End of item -->
                                
                                <div class="item client-carousel-item"><!-- Start of item -->
                                <div class="quotes-icon">
                                    <i class="icon-quotes-left"></i>
                                </div>
                                <p>Nurturing is not complex. It's merely being tuned in to the thing or person before you and offering small gestures toward what it needs at that time.</p>
                                <h4> ― Mary Anne Radmacher</h4>
                                </div><!-- End of item -->
                                <div class="item client-carousel-item"><!-- Start of item -->
                                <div class="quotes-icon">
                                    <i class="icon-quotes-left"></i>
                                </div>
                                <p>We can all make a difference in the lives of others in need because it is the most simple of gestures that make the most significant of differences. </p>
                                <h4> ― Miya Yamanouchi</h4>
                                </div><!-- End of item -->
                                
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- End Quotes Section -->

                
<!-- CurveDown -->
<svg class="curveDownColor" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
    <path d="M0 0 C 50 100 80 100 100 0 Z"></path>
</svg>


                <!-- Contact Section -->
                <div class="wrap blog-grid grey" id="contact">
                    <div class="grid grid-pad" >
                        <h2 align="center">Contact</h2>
                        <div class="col-1-2" >
                            <div class="content address">
                                <h3>Talk to us</h3>
                                <p>Talk to us by contacting us by the given means of communication for any queries Or by sending us a message directctly by just filling out the form.</p>
                                <address>
                                    <div>
                                        <div class="box-icon">
                                            <i class="icon-location"></i>
                                        </div>
                                        <span>Address:</span>
                                        <p>Modern College, Shivajinagar - 05</p>
                                    </div>
                                    
                                    <div>
                                        <div class="box-icon">
                                            <i class="icon-clock"></i>
                                        </div>
                                        <span>Email:</span>
                                        <p>moderncollege@gmail.com</p>
                                    </div>
                                    
                                    <div>
                                        <div class="box-icon">
                                            <i class="icon-phone"></i>
                                        </div>
                                        <span>Phone:</span>
                                        <p>595 12 34 567</p>
                                    </div>                                  
                                </address>
                            </div>
                        </div>
                         <div class="col-1-2 pleft-25" >
                            <div class="content contact-form">
                                <form class="form">
                                    <input type="text" class="comment-name" placeholder="Name*" required>
                                    <input type="email" class="comment-email" placeholder="Email*" required>
                                    <input type="text" class="comment-subject" placeholder="Subject">
                                    <textarea class="required comment-text" placeholder="Message..." required></textarea>
                                    <input type="submit" value="Send Message" class="btn submit comment-submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Contact Section -->

                <!-- JS -->
                <script src="js/jquery.js"></script>
                <script src="js/main.js"></script>
                <script src="js/mixitup.js"></script>
                <script src="js/smoothscroll.js"></script>
                <script src="js/jquery.nav.js"></script>
                <!-- <script src="js/owl-carousel/owl.carousel.min.js"></script> -->
                <script src="https://maps.googleapis.com/maps/api/js"></script>
                <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
                <script src="js/jquery.counterup.min.js"></script>
                <script src="js/lightcase.min.js"></script>
            </body>
        </html>