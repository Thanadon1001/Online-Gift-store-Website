<?php
require 'db.php'; // Include the database connection
session_start();
?>
<!DOCTYPE html>
<html>
   <head>
      <title>StyleSwap</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- FONTS      -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">  
      <!-- Font Awesome Bootstrap -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <!--Materialized CSS -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
      <!-- CSS -->
      <link rel="stylesheet" href="css/go_to.css">
 
      <link rel="stylesheet" href="css/style1.css">
 
      <style>
      h3,h5{
        font-weight:bold;
        color:black;
        margin:5%;
      }
      .anime-start-1 {
      opacity: 0;
      transform: translate3d(-100px, 0, 0);
      transition:2.5s;
      }
      .anime-end-1 {
      opacity: 1;
      transform: translate3d(0,0,0);
     }
     .anime-start-2 {
      opacity: 0;
      transform: translate3d(-100px, 0, 0);
      transition:2.1s;
    }
    .anime-end-2 {
      opacity: 1;
      transform: translate3d(0,0,0);
    }
    .anime-start-3 {
      opacity: 0;
      transform: translate3d(-100px, 0, 0);
      transition:1.7s;
    }
    .anime-end-3 {
      opacity: 1;
      transform: translate3d(0,0,0);
    }
    .anime-start-4 {
      opacity: 0;
      transform: translate3d(-100px, 0, 0);
      transition:1.2s;
    }
    .anime-end-4{
      opacity: 1;
      transform: translate3d(0,0,0);
    }
  

    .about {
        margin-top: 100vh; /* เพิ่มระยะห่างจากส่วนบน */
        padding: 60px 20px;
        background: #fff;
    }

    .about p {
        max-width: 1200px;
        margin: 0 auto;
        line-height: 1.8;
        text-align: justify;
    }
      </style>
   </head>
   
   <body>
    <!--navigation bar-->
      <div class="row navbar-fixed">
         <nav class="black">
            <div class="nav-wrapper">
               <a href="#" class="brand-logo">StyleSwap</a>
               <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
               <ul id="categories1" class="dropdown-content" databeloworigin="true"><!--for dropdown contents who has data activates as categories1 on desktop navigation bar-->
                  <li><a class="dropdown_link">Popular Rental</a></li>
                  <li><a class="dropdown_link">Bags</a></li>
                  <li><a class="dropdown_link">Pants</a></li>
                  <li><a class="dropdown_link">Shirts</a></li>
                  <li><a class="dropdown_link">Shoes</a></li>
                  <li><a class="dropdown_link">Accessories</a></li>
                  <li><a class="dropdown_link">Dresses</a></li>
                  <li><a class="dropdown_link">Crops</a></li>
 
               </ul>
               <ul id="categories2" class="dropdown-content" databeloworigin="true"><!--for dropdown contents who has data activates as categories2 on mobile sidenav-->
                  <li><a class="dropdown_link">Popular Rental</a></li>
                  <li><a class="dropdown_link">Bags</a></li>
                  <li><a class="dropdown_link">Pants</a></li>
                  <li><a class="dropdown_link">Shirts</a></li>
                  <li><a class="dropdown_link">Shoes</a></li>
                  <li><a class="dropdown_link">Accessories</a></li>
                  <li><a class="dropdown_link">Dresses</a></li>
                  <li><a class="dropdown_link">Crops</a></li>
 
               </ul>
 
               <ul id="nav-mobile" class="right hide-on-med-and-down"><!--for desktop-->
                <form action="search.php" method="POST"><!--for search function-->
                  <li><input type="text" name="search" placeholder="search"></li>
                  <?php
                    if(isset($_SESSION['userid'])){//navigation bar for user who has logged in
                    ?>
                          <li><a href="index.php" class="navlink">Home</a></li>
                          <li><a href="#" class="dropdown-trigger navlink" data-activates="categories1">Categories<i class="material-icons right">arrow_drop_down</i></a></li>
            
                          <li><a class="dropdown-button" data-beloworigin="true" href="#!" data-activates="dropdown2"><?php echo $_SESSION['userid']?><i class="material-icons right">arrow_drop_down</i></a></li>
                          <li><a href="shopping_cart.php" class="navlink"><i class="material-icons">shopping_cart</i></a></li>
                  <ul id="dropdown2" class="dropdown-content dropdown_link">
                    <li><a href="logout.php">Logout</a></li>
                  </ul>
                  <?php
                  }
                  else{//navigation bar for non logged in user
                  ?>
                  <li><a href="index.php" class="navlink">Home</a></li>
                  <li><a href="#" class="dropdown-trigger navlink" data-activates="categories1">Categories<i class="material-icons right">arrow_drop_down</i></a></li>
        
                  <li><a href="type.html" class="navlink">Login</a></li>
                  <li><a href="shopping_cart.php" class="navlink"><i class="material-icons">shopping_cart</i></a></li>
                  <?php
                      }
                  ?>
                </form>
               </ul>
               <ul class="side-nav" id="mobile-demo"><!--for mobiles-->
                <li><a href="index.php" class="side_logo left-align">StyleSwap</a></li>
                <hr>
                <li><a href="index.php" class="side_nav">Home</a></li>
                <li><a href="#" class="dropdown-trigger navlink" data-activates="categories2">Categories<i class="material-icons right">arrow_drop_down</i></a></li>
               
                <li><a href="type.html" class="side_nav">Login</a></li>
            </ul>
            </div>
         </nav>
        </div>
    <!--slider-->
    <div class="slider fullscreen slider_adjust">
        <ul class="slides">
          <li>
            <img src="img/646f35f259ac1008073501.jpg"> <!-- random image -->
            <div class="caption left-align">
              <h3 class="white-text">Welcome To The StyleSwap!</h3>
              <!-- <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5> -->
            </div>
          </li>
          <li>
            <img src="img/brooks-master-walk-in-albero-grigio-1.jpg"> <!-- random image -->
            <div class="caption right-align">
              <h3 class="black-text"> Get ready to Mix, Match and Shine!</h3>
              <!-- <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5> -->
            </div>
          </li>
          <li>
            <img src="img/about_img_1.png"> <!-- random image -->
            <div class="caption right-align">
              <h4 class="black-text" >Get Quick Delivery!</h4>
              <!-- <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5> -->
            </div>
          </li>
        </ul>
      </div>
 
     
      <!--About-->
      <div class="about">
    <p style="font-size:20px;">
        Welcome to StyleSwap, your go-to destination for fashion rentals. Instead of buying clothes you'll only wear a few times, rent stylish outfits for any occasion at a fraction of the cost. It's a smart, eco friendly way to stay fashionable while reducing waste.
        With secure payments, reliable delivery, and flexible rental periods, dressing up has never been easier. Simply choose, rent, and wear no long-term commitment needed.
        Refresh your wardrobe effortlessly. Start renting now at [StyleSwap Website]!
    </p>
</div>
    
    <div class="row" style="margin-left: -1px;">
      <div class="parallax-container" style="height:100%;">
        <div class="row" style="margin-top: 30px">
          <h4 class="center-align ฺblack-text">Cateogories</h4>
          <div class="col s12 m12 l3">
            <div class="card anime-start-1" data-as="true"  data-as-animation="anime-end-1"> <!--for onscroll animation-->
              <div class="card-image waves-effect waves-block waves-light">
                <img  src="img/womens-walk-in-closet.png">
              </div>
                <a href="category3.php">
                <div class="card-action center-align black white-text flow-text">
                Popular Rental
                </div>
              </a>
            </div>
          </div>
          <div class="col s12 m12 l3">
            <div class="card anime-start-2" data-as="true"  data-as-animation="anime-end-2">
              <div class="card-image waves-effect waves-block waves-light">
                <img  src="img/9161060097_833961269.jpg">
              </div>
              <a href="category2.php">
                <div class="card-action center-align black white-text flow-text">
                Bags
                </div>
              </a>
            </div>
          </div>
          <div class="col s12 m12 l3">
            <div class="card anime-start-3" data-as="true"  data-as-animation="anime-end-3">
              <div class="card-image waves-effect waves-block waves-light">
                <img  src="img/m_62f6810e4bd7602de1563d22.jpg">
              </div>
              <a href="category1.php">
                <div class="card-action center-align black white-text flow-text">
                Pants
                </div>
              </a>
            </div>
          </div>
          <div class="col s12 m12 l3">
            <div class="card anime-start-4" data-as="true"  data-as-animation="anime-end-4">
              <div class="card-image waves-effect waves-block waves-light">
                <img  src="img/แจ็คกเกต.jpg">
              </div>
              <a href="category4.php">
                <div class="card-action center-align black white-text flow-text">
                Shirts
                </div>
              </a>
            </div>
          </div>
        </div>
        <div class="parallax">
          <img src="images/space.jpg" class="responsive-img">
 
        </div>
      </div>
    </div>
    <h1> QUICK DELIVERY</h1>
      <p style="font-size:20px;">
      Welcome to StyleSwap, your go-to destination for fashion rentals. Instead of buying clothes you'll only wear a few times, rent stylish outfits for any occasion at a fraction of the cost. It's a smart, eco friendly way to stay fashionable while reducing waste.
With secure payments, reliable delivery, and flexible rental periods, dressing up has never been easier. Simply choose, rent, and wear no long-term commitment needed.
Refresh your wardrobe effortlessly. Start renting now at [StyleSwap Website]!  </p>
    <!--parallax Container 2-->
    <div class="row" style="margin-left: -1px; margin-top: 20px;">
      <div class="parallax-container" style="height:100%;">
        <div class="row" style="margin-top: 30px">
          <h4 class="center-align white-text">Cateogories</h4>
          <div class="col s12 m12 l3">
            <div class="card small anime-start-1" data-as="true"  data-as-animation="anime-end-1" style="opacity: 0.8;">
              <div class="card-image waves-effect waves-block waves-light">
                <img class="activator" src="img/21647801xlalt4.jpg">
              </div>
              <a href="category6.php">
                <div class="card-action center-align black white-text flow-text">
                Shoes
                </div>
              </a>
            </div>
          </div>
          <div class="col s12 m12 l3">
            <div class="card small anime-start-2" data-as="true"  data-as-animation="anime-end-2" style="opacity: 0.8;">
              <div class="card-image waves-effect waves-block waves-light">
                <img class="activator" src="img/bridal-earrings-feature-1.jpg">
              </div>
              <a href="category7.php">
                <div class="card-action center-align black white-text flow-text">
                Accessories
                </div>
              </a>
            </div>
          </div>
          <div class="col s12 m12 l3">
            <div class="card small anime-start-3" data-as="true"  data-as-animation="anime-end-3" style="opacity: 0.8;">
              <div class="card-image waves-effect waves-block waves-light">
                <img class="activator" src="img/เดรสขาว.jpg">
              </div>
              <a href="#">
                <div class="card-action center-align black white-text flow-text">
                Dresses
                </div>
              </a>
            </div>
          </div>
          <div class="col s12 m12 l3">
            <div class="card small anime-start-4" data-as="true"  data-as-animation="anime-end-4" style="opacity: 0.8;">
              <div class="card-image waves-effect waves-block waves-light">
                <img class="activator" src="img/เกาะอก.jpg">
              </div>
              <a href="#">
                <div class="card-action center-align black white-text flow-text">
                Crops
                </div>
              </a>
            </div>
          </div>
        </div>
        <div class="parallax">
          <img src="images/space.jpg" class="responsive-img">
 
        </div>
      </div>
    </div>
      <!-- Page Footer -->
      <div class="row" style="margin-top: -20px;">
         <footer class="page-footer black white-text">
            <div class="row center-align">
                <div class="col s12 m12 l12">
                  <h4><a href="index.php" class="footerlogo">StlyeSwap</a></h4>
                  <!-- <p class="white-text">Information will be provided soon.</p> -->
                </div>
            </div>
            <div class="row center-align">
              <div class="col s12 m12 l12">
                <a href="#" class="link"> Developed By Pasu</a>
              </div>
            </div>
             <div class="row center-align">
                <div class="col s12 m12 l12">
                  <a href="index.php" class="link">Home</a>
                  
                </div>
              </div>
              <div class="row center-align">
               <div id="social">
                  <a class="facebookBtn smGlobalBtn" href="#!"></a>
                  <a class="googleplusBtn smGlobalBtn" href="#!"></a>
               </div>
              </div>
            <div class="row center-align marginReduce footer-copyright" style="margin-bottom:-20px;">
               <div id="footertext" class="col s12 m12 l12">
                  &copy 2018 Copyright Text .All Rights reserved.
               </div>
            </div>
         </footer>
      </div>
      <!-- Preloader -->
      <div id="loader-wrapper">
         <div id="loader"></div>
 
         <div class="loader-section section-left"></div>
         <div class="loader-section section-right"></div>
 
      </div>
      <!-- Go To Top -->
      <div id="go-top" style="display: none;">
         <a title="Back to Top" href="#"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></a>
      </div>
 
   
  </footer>
   </body>
      <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
      <script src="js/jquery.validate.min.js"></script>
      <script src="js/additional-methods.min.js"></script>
      <script src="js/jquery.scrollme.js"></script><!--scroll me jquery plugin-->
      <script src="js/animate-scroll.js"></script><!--animate on scroll me jquery plugin for animation-->
      <script src="js/init.js"></script>
      <script>
        //Slider
        $(document).ready(function(){
          $('.slider').slider();
        });
         //Dropdown Trigger
         $(document).ready(function(){
            $('.dropdown-trigger').dropdown({
               belowOrigin:true
            });
         });
         $(document).ready(function(){
            $('#go-top').click(function(){
            $("html, body").animate({ scrollTop: 0 }, 600);
            return false;
          });
        });
 
        //parallax
        $(document).ready(function(){
          $('.parallax').parallax()
        })
         //Preloader
         $(document).ready(function() {
            $(window).load(function(){
                setTimeout(function(){
                    $('body').addClass('loaded');
                }, 1000);
            });
         });
         //Go Top
            var pxShow = 100; // height on which the button will show
            var fadeInTime = 400; // how slow/fast you want the button to show
            var fadeOutTime = 400; // how slow/fast you want the button to hide
 
            // Show or hide the sticky footer button
            jQuery(window).scroll(function() {
 
               if (jQuery(window).scrollTop() >= pxShow) {
                  jQuery("#go-top").fadeIn(fadeInTime);
               } else {
                  jQuery("#go-top").fadeOut(fadeOutTime);                  
               }
 
           });
           $(document).ready(function() {
             $('textarea#textarea2').characterCounter();
           });
      </script>
</html>
 