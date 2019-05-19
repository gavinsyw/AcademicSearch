<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example that shows off a blog page with a list of posts.">
    <img src="<?php echo base_url('resources/');?>conferenceImage/<?php echo $conferenceName?>.jpg" style="margin-left: 600px; height:200px; width:400px">
    <title>Conference: <?php echo $conferenceName?></title>
    
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-" crossorigin="anonymous">
    
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-old-ie-min.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-min.css">
    <!--<![endif]-->
    
    
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/layouts/blog-old-ie.css">
        <![endif]-->
        <!--[if gt IE 8]><!-->
            <link rel="stylesheet" href="<?php echo base_url('resources/');?>css/layouts/blog.css">
        <!--<![endif]-->
</head>
<body>

<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
    var choice = 2;
    window.onload=function(){
        $("#authorButton").click(function(){
            choice = 1;
            loadDataByPageIndex(1);
        })

        $("#paperButton").click(function(){
            choice = 2;
            loadDataByPageIndex(1);
        });

        $("#graphButton").click(function(){
            loadgraph();
        });
    }
        var start_time = 0;
        var end_time = 1000;
        var pageIndex = 1;
        var conferenceID = "<?php echo $conferenceID?>"; // change the keyWord recieved by php into javascript format
        var conferenceName = "<?php echo $conferenceName?>";

        function loadDataByPageIndex(pageIndex) {
            $(".list").slideToggle(1000,function(){$(".loading").show();});
            start_time=Date.now();
            if(choice == 1){
                $.post("/index.php/page/show_conference_author", {
                pageIndex: pageIndex,
                conferenceID: conferenceID,
                conferenceName: conferenceName
                }, function (data) {
                $(".list").html(data);
                end_time=Date.now();
                console.log("Load was performed.", "Time: ", end_time - start_time);
                $(".loading").hide();
                $(".list").slideToggle(1000);
            });
            }
            if(choice == 2){
                $.post("/index.php/page/show_conference_paper", {
                pageIndex: pageIndex,
                conferenceID: conferenceID,
                conferenceName: conferenceName
                }, function (data) {
                $(".list").html(data);
                end_time=Date.now();
                console.log("Load was performed.", "Time: ", end_time - start_time);
                $(".loading").hide();
                $(".list").slideToggle(1000);
                });
            }
        }
        function loadgraph(){
            $.post("/index.php/page/show_conference_graph", {
                conferenceID: conferenceID,
                conferenceName: conferenceName
            }, function (data) {
                $(".list").html(data);
            });
        }

        function next() {
            loadDataByPageIndex(++pageIndex);
            console.log('NEXT', pageIndex);
        };

        function previous() {
            if (pageIndex > 1) {
                loadDataByPageIndex(--pageIndex);
            } else {

            }
            console.log('previous', pageIndex);
        };

        $(function() {
            loadDataByPageIndex(pageIndex);
        })

        function page()
        {
            var da=document.getElementById("select").value;
            pageIndex = da;
            loadDataByPageIndex(da);
            console.log("NEXT: ", da);
        }
</script>


<div id="layout" class="pure-g">
    <div class="sidebar pure-u-1 pure-u-md-1-4">
        <div class="header">
            <h1 class="brand-title"><?php echo $conferenceName?></h1>
            <h2 class="brand-tagline"><?php
                echo $paperNumber, " papers"?>
                <p style="font-size:18px"><?php
                echo "ID: ", $conferenceID
            ?></p></h2>

            <nav class="nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a class="pure-button" id="authorButton" href="#">Authors</a>
                    </li>
                    <li class="nav-item">
                        <a class="pure-button" id="paperButton" href="#">Papers</a>
                    </li>
                    <li class="nav-item">
                        <a class="pure-button" id="graphButton" href="#">Graph</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>


<!-- the part of displaying posiible authors -->
<div class="content">

<!-- style of the "previous" and "next" button -->
<style>
    .previous,
    .next {
        -webkit-touch-callout: none;
        /* iOS Safari */
        -webkit-user-select: none;
        /* Safari */
        -khtml-user-select: none;
        /* Konqueror HTML */
        -moz-user-select: none;
        /* Firefox */
        -ms-user-select: none;
        /* Internet Explorer/Edge */
        user-select: none;
        /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
        margin-left: 20px;
        display: inline-block;
        padding: 6px 9px;
        background: white;
    }
    #page,#select{
        -webkit-touch-callout: none;
        /* iOS Safari */
        -webkit-user-select: none;
        /* Safari */
        -khtml-user-select: none;
        /* Konqueror HTML */
        -moz-user-select: none;
        /* Firefox */
        -ms-user-select: none;
        /* Internet Explorer/Edge */
        user-select: none;
        /* Non-prefixed version, currently
        supported by Chrome and Opera */
        margin-left: 20px;
        display: inline-block;
        padding: 6px 9px;
        background: white;
    }
</style>

<!-- part of the author page -->
    <!-- part of the "previous" and "next" button -->
    <div class="loading" style="text-align: center"><br / ><img src="<?php echo base_url();?>loading.gif"></div>
    <div class="container">
        <div class="list">
        </div><br>
    </div>

</div>

<!-- end of the part displaying the authors -->





<script src="<?php echo base_url('resources/');?>js/ui.js"></script>

</body>
</html>



