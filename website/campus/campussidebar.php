<html>
   <head>
      <style>
         /* Increase specificity */
         .sideBar .sticky {
          position:-webkit-sticky; 
         }
         app-sidebar.sideBar ul li:first-child {
         background-image: none;
         background-color: #fff;
         padding:0px 0px;
         text-transform: none; /* Remove uppercase transformation */
         }
    /*     .sideBar {*/
    /*width: 30%;*/
/*}*/
        .duration-intake p {
            color: #333333;
            margin-top: 4px;
            display: flex;
            justify-content: space-between;
            flex-wrap: nowrap;
        }
        @media only screen and (max-width: 968px) {
    .flexContainer .sticky {
        width: 360px;
    }
}
      </style>
   </head>
   <body>
      <app-sidebar  class="sideBar">
         <div class="sticky">
            <div>
               <ul>
                  <li>
                     Gallery Explore More
                  </li>
                  <li>        
                     <a href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php"> 
                     <i class="fa fa-long-arrow-right">
                     </i>
                     360 Virtual Tour
                     </a>
                  </li>
                  <li>
                    <div class="accordion">
                     <a data-toggle="collapse" target="#collapse" href="#collapse"
                        class="borAct collapsed" aria-expanded="false">
                     <i class="fa fa-long-arrow-right"></i>NSS
                     <span class="icon">
                     <i class="fa fa-angle-down">
                     </i>
                     </span>
                     </a>  
                     <div routerlinkactive="in" class="navSubDiv collapse"
                        id="collapse" aria-expanded="false" style="height: 0px;">
                        <ul class="navSub">
                           <li> 
                              <a href="<?php echo $base_url_website_campus; ?>about_nss.php">
                              <i class="fa fa-long-arrow-right">                                  
                              </i>
                              About NSS
                              </a> 
                           </li>
                           <li>
                              <a href="<?php echo $base_url_website_campus; ?>nss_unit.php">
                              <i class="fa fa-long-arrow-right">                                  
                              </i>
                              NSS Units and Program Officers 
                              </a>
                           </li>
                           <li> 
                              <a href="<?php echo $base_url_website_campus; ?>nss_advisory.php">
                              <i class="fa fa-long-arrow-right">
                              </i> 
                              Advisory committe
                              </a>
                           </li>
                           <li> 
                              <a href="<?php echo $base_url_website_campus; ?>nss.php">
                              <i class="fa fa-long-arrow-right">                                  
                              </i> 
                              Activities
                              </a>
                           </li>
                           <li> 
                              <a href="<?php echo $base_url_website_campus; ?>nss-gallary.php">
                              <i class="fa fa-long-arrow-right">
                              </i> 
                              NSS Gallery
                              </a>
                           </li>
                           <li>
                              <a href="<?php echo $base_url_website_campus; ?>contact_us.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Contact Us
                              </a>
                           </li>
                        </ul>
                     </div>
                  </li>
                  <li>
                     <a  href="<?php echo $base_url_website_campus; ?>gallery.php">
                     <i class="fa fa-long-arrow-right">
                     </i>
                     Gallery
                     </a>         
                  </li>
                  <li>
                     <a data-toggle="collapse" target="#collapse2" href="#collapse2"
                        class="borAct collapsed" aria-expanded="false">
                     <i class="fa fa-long-arrow-right"></i>Infrastructure
                     <span class="icon">
                     <i class="fa fa-angle-down">
                     </i>
                     </span>
                     </a>  
                     <div routerlinkactive="in" class="navSubDiv collapse"
                        id="collapse2" aria-expanded="false" style="height: 0px;">
                        <ul class="navSub">
                           <li>
                              <a href="<?php echo $base_url_website_campus; ?>modern_class_room.php" >
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Modern Class Room
                              </a>
                           </li>
                           <li>
                              <a href="<?php echo $base_url_website_campus; ?>advance-laboratories.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Advance Laboratories
                              </a>
                           </li>
                           <li>              
                              <a href="<?php echo $base_url_website_campus; ?>library.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Library
                              </a>              
                           </li>
                        </ul>
                     </div>
                  </li>
                  <li>
                     <a data-toggle="collapse" target="#collapse3" href="#collapse3"
                        class="collapsed" aria-expanded="false">
                     <i class="fa fa-long-arrow-right">
                     </i>
                     Facility
                     <span class="icon">
                     <i class="fa fa-angle-down">
                     </i>
                     </span>
                     </a>
                     <div routerlinkactive="in" class="navSubDiv collapse"
                        id="collapse3" aria-expanded="false" style="height: 0px;">
                        <ul class="navSub">
                           <li>
                              <a href="<?php echo $base_url_website_campus; ?>wi-fi_campus.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Wi-Fi Campus
                              </a>              
                           </li>
                           <li>              
                              <a href="<?php echo $base_url_website_campus; ?>cafeteria.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Careteria &amp; First Aid Room
                              </a>              
                           </li>
                            <li>              
                              <a href="<?php echo $base_url_website_campus; ?>box-cricket.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Box Cricket
                              </a>              
                           </li>
                           <li>              
                              <a href="<?php echo $base_url_website_campus; ?>transportation.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Transportation Facilities
                              </a>              
                           </li>
                        </ul>
                     </div>
                  </li>
                  <li>
                     <a data-toggle="collapse" target="#collapse4" href="#collapse4"
                        class="collapsed" aria-expanded="false">
                     <i class="fa fa-long-arrow-right">
                     </i>
                     Curriculum Activities
                     <span class="icon">
                     <i class="fa fa-angle-down">
                     </i>
                     </span>
                     </a>        
                     <div routerlinkactive="in" class="navSubDiv collapse"
                        id="collapse4" aria-expanded="false" style="height: 0px;">
                        <ul class="navSub">
                           <li>              
                              <a href="<?php echo $base_url_website_campus; ?>industryvisit.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Industry Visit
                              </a>              
                           </li>
                           <li>              
                              <a href="<?php echo $base_url_website_campus; ?>experttalk.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Expert Talk
                              </a>              
                           </li>
                           <!--<li>              -->
                           <!--   <a href=" #<?php //echo $base_url_website_campus; ?> ">-->
                           <!--   <i class="fa fa-long-arrow-right">-->
                           <!--   </i>-->
                           <!--   Internship Program-->
                           <!--   </a>              -->
                           <!--</li>-->
                           <li>              
                              <a href="<?php echo $base_url_website_campus; ?>iepprogram.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              IEP Program
                              </a>              
                           </li>
                           <li>              
                              <a href="<?php echo $base_url_website_campus; ?>project_exhibition.php ">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Project Exhibition
                              </a>              
                           </li>
                           <!--<li>              -->
                           <!--   <a href="#<?php //echo $base_url_website_campus; ?> ">-->
                           <!--   <i class="fa fa-long-arrow-right">-->
                           <!--   </i>-->
                           <!--   Skill Development Program (SDP)-->
                           <!--   </a>              -->
                           <!--</li>-->
                        </ul>
                     </div>
                  </li>
                  <li>
                     <a data-toggle="collapse" target="#collapse5" href="#collapse5"
                        class="collapsed" aria-expanded="false">
                     <i class="fa fa-long-arrow-right">
                     </i>
                     Extra Curriculum Activities
                     <span class="icon">
                     <i class="fa fa-angle-down">
                     </i>
                     </span>
                     </a>
                     <div routerlinkactive="in" class="navSubDiv collapse"
                        id="collapse5" aria-expanded="false" style="height: 0px;">
                        <ul class="navSub">
                           <!--<li>-->
                           <!--   <a href="<?php //echo $base_url_website_campus; ?>">-->
                           <!--   <i class="fa fa-long-arrow-right">-->
                           <!--   </i>-->
                           <!--   Student Club-->
                           <!--   </a>-->
                           <!--</li>-->
                           <!--<li>-->
                           <!--   <a href="<?php //echo $base_url_website_campus; ?>">-->
                           <!--   <i class="fa fa-long-arrow-right">-->
                           <!--   </i>-->
                           <!--   Social Connect-->
                           <!--   </a>-->
                           <!--</li>-->
                           <li>
                              <a href="<?php echo $base_url_website_campus; ?>mastermind.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Mastermind
                              </a>
                           </li>
                           <li>
                              <a href="<?php echo $base_url_website_campus; ?>sports.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Sports Activities
                              </a>
                           </li>
                           <li>
                              <a href="<?php echo $base_url_website_campus; ?>sports_report.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Sports Activities Report
                              </a>
                           </li>
                           <li>
                              <a href="<?php echo $base_url_website_campus; ?>culture.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Cultural Program
                              </a>
                           </li>
                            <li>
                              <a href="<?php echo $base_url_website_campus; ?>culture_report.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Cultural Activity Report
                              </a>
                           </li>
                           <li>
                              <a href="<?php echo $base_url_website_campus; ?>fdp.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Faculty Development Program
                              </a>
                           </li>
                           <li>
                              <a href="<?php echo $base_url_website_campus; ?>cwp.php">
                              <i class="fa fa-long-arrow-right">
                              </i>
                              Connect With Parents
                              </a>
                           </li>
                        </ul>
                     </div>
                  </li>
                  <!--<li>-->
                  <!--   <a href="<?php //echo $base_url_website_campus; ?>">-->
                  <!--   <i class="fa fa-long-arrow-right">-->
                  <!--   </i>-->
                  <!--   National / International Association-->
                  <!--   </a>-->
                  <!--</li>-->
                  <li>
                     <a href="<?php echo $base_url_website_campus; ?>academic_system.php">
                     <i class="fa fa-long-arrow-right">
                     </i>
                     Academic System
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </app-sidebar>
   </body>
</html>