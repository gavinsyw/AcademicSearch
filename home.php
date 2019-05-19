<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example that shows off a responsive product landing page.">
    <title>Landing Page &ndash; Layout Examples &ndash; Pure</title>
    
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-" crossorigin="anonymous">
    
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-old-ie-min.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-min.css">
    <!--<![endif]-->
    
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/layouts/marketing-old-ie.css">
        <![endif]-->
        <!--[if gt IE 8]><!-->
            <link rel="stylesheet" href="css/layouts/marketing.css">
        <!--<![endif]-->

    <!-- auto complete function -->
    <link rel="stylesheet" href="jquery.ui.autocomplete.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="ui/jquery.ui.core.js"></script>
    <script type="text/javascript" src="ui/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="ui/jquery.ui.position.js"></script>
    <script type="text/javascript" src="ui/jquery.ui.autocomplete.js"></script>
    <script>
    $( function()
    {
        $( "#keyWord" ).autocomplete({
            source: "hint.php",
            minLength: 2,
            autoFocus: false
        });
    });
</script>
</head>
<body>









<div class="header">
    <div class="home-menu pure-menu pure-menu-horizontal pure-menu-fixed">
        <a class="pure-menu-heading" href="">Search Scholar</a>

        <ul class="pure-menu-list">
            <li class="pure-menu-item pure-menu-selected"><a href="#" class="pure-menu-link">Home</a></li>
            <li class="pure-menu-item"><a href="learnMore.php" class="pure-menu-link">Learn more</a></li>
            <li class="pure-menu-item"><a href="donate.php?keyWord= " class="pure-menu-link">Donate</a></li>
        </ul>
    </div>
</div>

<div class="splash-container">
    <div class="splash">
        <h1 class="splash-head">Search Scholar</h1>
        <p class="splash-subhead">
            <form action="index.php" method="get" style="font-size:20px">

            <input type="text" id="keyWord" name="keyWord" style="font-size:22px; font-family: Times New Roman; width:555px">
            <p>
            <a type="submit" class="pure-button pure-button-primary" style="font-family:Microsoft Yahei; font-size:18px">Search</a>
            </p>

            </form>
        </p>
        <p>
            <!--<a href="http://purecss.io" class="pure-button pure-button-primary">Get Started</a>-->
        </p>
    </div>
</div>

<div class="content-wrapper">
    <div class="content">
        <h2 class="content-head is-center">Various options for search.</h2>

        <div class="pure-g">
            <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-3">

                <h3 class="content-subhead">
                    <i class="fa fa-rocket"></i>
                    Authors
                </h3>
                <p>
                    The website provides basic informations about the authors, as well as his relationship with other authors.
                </p>
            </div>
            <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-3">
                <h3 class="content-subhead">
                    <i class="fa fa-mobile"></i>
                    Conferences
                </h3>
                <p>
                    We have collected 13 famous conferences in the field. You can acquire information of papers or authors quickly via it.
                </p>
            </div>
            <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-3">
                <h3 class="content-subhead">
                    <i class="fa fa-th-large"></i>
                    Papers
                </h3>
                <p>
                    You can acquire necessary information about the papers in our database. Paper recommendation are made for you. 
                </p>
            </div>
        </div>
    </div>

    <div class="ribbon l-box-lrg pure-g">
        <div class="l-box-lrg is-center pure-u-1 pure-u-md-1-2 pure-u-lg-2-5">
            <img width="300" alt="File Icons" class="pure-img-responsive" src="img/common/file-icons.png">
        </div>
        <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-3-5">

            <h2 class="content-head content-head-ribbon"></h2>

            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor.
            </p>
        </div>
    </div>

    <div class="content">
        <h2 class="content-head is-center">Dolore magna aliqua. Uis aute irure.</h2>

        <div class="pure-g">
            <div class="l-box-lrg pure-u-1 pure-u-md-2-5">
                <form class="pure-form pure-form-stacked">
                    <fieldset>

                        <label for="name">Your Name</label>
                        <input id="name" type="text" placeholder="Your Name">


                        <label for="email">Your Email</label>
                        <input id="email" type="email" placeholder="Your Email">

                        <label for="password">Your Password</label>
                        <input id="password" type="password" placeholder="Your Password">

                        <button type="submit" class="pure-button">Sign Up</button>
                    </fieldset>
                </form>
            </div>

            <div class="l-box-lrg pure-u-1 pure-u-md-3-5">
                <h4>Contact Us</h4>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat.
                </p>

                <h4>More Information</h4>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua.
                </p>
            </div>
        </div>

    </div>

    <div class="footer l-box is-center">
        Click the "Donate" button to help us do better. 
    </div>

</div>




</body>
</html>
