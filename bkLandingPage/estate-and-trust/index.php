<!DOCTYPE html>
<html lang="en">
    <head>
        <title>MPOPC</title>
        <?php include '../data.php';
        $data=$d['estate-and-trust'];
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="https://mpopc.com/application/files/3215/0834/2903/mpo-new-16x16.png" type="image/x-icon"/>
        <link rel="icon" href="https://mpopc.com/application/files/3215/0834/2903/mpo-new-16x16.png" type="image/x-icon"/>
        <link rel="apple-touch-icon" href="https://mpopc.com/application/files/4415/0834/2902/mpo-new-57x57.png"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" media="only screen and (max-device-width: 813px)" href="../assets/css/mobile.css" />
    </head>  
    <body>

        <div class="container clmainbox">
            <div class="clearfix">
                <div class="logo col-md-4 col-lg-4 col-xs-4 col-sm-4"><a href="https://mpopc.com/">
                        <img  src="../assets/img/logo.png"></a></div>
                <div class="logphone col-md-4 col-lg-4 col-xs-4 col-sm-4 pull-right">
                    <h3><a href="tel:<?php echo $data['ph']; ?>"><?php echo $data['ph']; ?></a></h3> 

                </div>
            </div>
        </div>
        <div class="yellowtxt"><div class="container"><?php echo $data['ylhead']; ?></div></div>
        <div class="BgsDark">
            <div class="container">
                <div class="FormDatatext col-md-8 col-lg-8 col-xs-8 col-sm-8">
                    <h1><?php echo $data['h1']; ?><hr></h1>
                    <p><?php echo $data['h1sub']; ?></p>
                    <br><p><?php echo $data['h1subpera']; ?></p>
                    <br><ul>
                        <?php foreach ($data['h1subult'] as $p){ ?>
                        <li><?php echo $p; ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div id="formright" class=" col-md-4 col-lg-4 col-xs-4 col-sm-4 rightside">
                    <div class="FormDataShow">
                        <h2><?php echo $data['formheading']; ?><hr></h2>
                        <p><?php echo $data['formsubheading']; ?></p>
                        <section>
                            <form action="submit.php">
                                <label>First Name*<input required="true" name="YOURNAME"></label>
                                <label>Last Name*<input required="true" name="LNAME"></label>
                                <label>Email*<input type="email" required="true" name="YOUREMAILADDRESS"></label>
                                <label>Phone*<input required="true" name="YOURPHONENUMBER"></label>
                                <label>Tell us About your Case<textarea name="Comment"></textarea></label>
                                <input type="submit" class="btns" value="get Free case Evaluation">
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="BgDDrk">
            <div class="container">
                <ul>
                    <li><img src="../assets/img/best_law_firms-2020.png"></li>
                    <li><img src="../assets/img/Best_Law_Firm_2021.png"><br><br><br><img src="../assets/img/super_lawyers.png"></li>

                    <li><img src="../assets/img/best_lawyers_in_america.png"></li>
                </ul>
            </div>
        </div>
        <div class="BgFoot">
            <div class="container">
                <h2><?php echo $data['footheading']; ?></h2>
                <p><?php echo $data['footp1']; ?></p>
                <p><?php echo $data['footp2']; ?></p>
                <p class="hid">
                    <b>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</b></p>
                <div class="textboxdata hid">
                    <ul>
                        <li>Estate Planning</li>
                        <li>Estate and Trust Administration</li>
                        <li>Estate and Trust Litigation</li>
                        <li>General Litigation</li><li>Estate and Trust Litigation</li>
                        <li>General Litigation</li>
                        <li>Corporate and Commercial Planning</li>
                        <li>Taxation</li>
                        <li>Elder Law</li>
                    </ul>
                </div><br><br>
                <a href="#formright" class="btns">request a Free case Evaluation</a>
            </div>
        </div>
        <footer id="footer-theme-two">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 footer-legal">


                        <p style="text-align: center;">2901 S. Lynnhaven Road, Suite 120&nbsp; •&nbsp; Virginia Beach, VA 23452&nbsp; •&nbsp; <a href="tel:+17576878888">757.687.8888</a>&nbsp; •&nbsp; 757.687.8732 Facsimile&nbsp; •&nbsp; www.mpopc.com</p>



                        <div class="ccm-custom-style-container ccm-custom-style-main-2163">
                            <p style="text-align: justify;">The materials on this website were prepared by Midgett Preti Olansen PC. They are for informational purposes only. They are not intended to constitute, nor do they constitute, legal advice. Neither use of this website, nor an initial call or communication to an attorney is intended to create or creates an attorney-client relationship. The only way to become a Midgett Preti Olansen PC client is through mutual agreement. Do not act on any information on this website without first seeking professional advice.</p>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 footer-search">



                            <div id="ccm-block-social-links1711" class="ccm-block-social-links">
                                <ul class="list-inline">
                                    <li><a target="_blank" href="https://www.linkedin.com/company/379671/"><i class="fa fa-linkedin-square"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 footer-legal-two">


                            <p style="text-align: center;">© 2019&nbsp;Midgett&nbsp;Preti Olansen&nbsp; •&nbsp; Site Powered By&nbsp;<a href="http://www.studiocenter.com/" target="_blank">Studio Center</a></p>

                        </div>
                        <div class="col-sm-3 footer-social">


                            <form action="https://mpopc.com/search" method="get" class="custom-search">
                                <span class="fa fa-search"></span>
                                <input name="search_paths[]" type="hidden">
                                <input name="query" type="text" placeholder="Search..." aria-label="Search" value="">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
