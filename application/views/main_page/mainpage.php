<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Search Result</title>
    
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-" crossorigin="anonymous">
    
    
    
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
        <![endif]-->
        <!--[if gt IE 8]><!-->
            <link rel="stylesheet" href="<?php echo base_url('resources/');?>css/layouts/side-menu.css">
        <!--<![endif]-->

</head>
<body>



<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
    var choice = 2;
    window.onload=function(){
        $("#homeButton").click(function(){
            $("li").removeClass();
            $("#homeButton").addClass("pure-menu-item menu-item-divided pure-menu-selected");
            $("#authorButton").addClass("pure-menu-item");
            $("#conferenceButton").addClass("pure-menu-item");
            $("#paperButton").addClass("pure-menu-item");
            $("#donate").addClass("pure-menu-item");
            choice = 1;
            
            loadDataByPageIndex(1);
        })

        $("#authorButton").click(function(){
            $("li").removeClass();
            $("#homeButton").addClass("pure-menu-item");
            $("#authorButton").addClass("pure-menu-item menu-item-divided pure-menu-selected");
            $("#conferenceButton").addClass("pure-menu-item");
            $("#paperButton").addClass("pure-menu-item");
            $("#donate").addClass("pure-menu-item");
            choice = 2;
            
            loadDataByPageIndex(1);
        });
        $("#conferenceButton").click(function(){
            $("li").removeClass();
            $("#homeButton").addClass("pure-menu-item");
            $("#authorButton").addClass("pure-menu-item");
            $("#conferenceButton").addClass("pure-menu-item menu-item-divided pure-menu-selected");
            $("#paperButton").addClass("pure-menu-item");
            $("#donate").addClass("pure-menu-item");
            choice  = 3;
            
            loadDataByPageIndex(1);
        });
        $("#paperButton").click(function(){
            $("li").removeClass();
            $("#homeButton").addClass("pure-menu-item");
            $("#authorButton").addClass("pure-menu-item");
            $("#conferenceButton").addClass("pure-menu-item");
            $("#paperButton").addClass("pure-menu-item menu-item-divided pure-menu-selected");
            $("#donate").addClass("pure-menu-item");
            choice = 4;
            
            loadDataByPageIndex(1);
        });
        $("#donateButton").click(function(){
            $("li").removeClass();
            $("#homeButton").addClass("pure-menu-item");
            $("#authorButton").addClass("pure-menu-item");
            $("#conferenceButton").addClass("pure-menu-item");
            $("#paperButton").addClass("pure-menu-item");
            $("#donate").addClass("pure-menu-item menu-item-divided pure-menu-selected");
            choice = 5;
            
            loadDataByPageIndex(1);
        });
    }
        var start_time = 0;
        var end_time = 800;
        var pageIndex = 1;
        var keyWord = "<?php echo $keyWord?>"; // change the keyWord recieved by php into javascript format
        //setTimeout(loadDataByPageIndex,1000);
        function loadDataByPageIndex(pageIndex) {
            if (choice==5 && $("#header")[0].style.display!="none"){$("#header").slideToggle(500);}
            //alert($("#header")[0].style.display) ;
            if (choice!=5 && $("#header")[0].style.display=="none"){$("#header").slideToggle(500);}
            $("#results").slideToggle(800,function(){$(".loading").show();});
            start_time=Date.now();
            if(choice == 2){
                $.post("/index.php/page/show_authors", {
                pageIndex: pageIndex,
                scholarName: keyWord
                }, function (data) {
                $("#results").html(data);
                end_time=Date.now();
                console.log("Load was performed.", "Time: ", end_time - start_time);
                $(".loading").hide();
                $("#results").slideToggle(800);
            });
            }
            if(choice == 3){
                $.post("/index.php/page/show_conferences", {
                pageIndex: pageIndex,
                conferenceName: keyWord
                }, function (data) {
                $("#results").html(data);
                end_time=Date.now();
                console.log("Load was performed.", "Time: ", end_time - start_time);
                $(".loading").hide();
                $("#results").slideToggle(800);
            });
            }
            if(choice == 4){
                $.post("/index.php/page/show_papers", {
                pageIndex: pageIndex,
                paperName: keyWord
                }, function (data) {
                $("#results").html(data);
                end_time=Date.now();
                console.log("Load was performed.", "Time: ", end_time - start_time);
                $(".loading").hide();
                $("#results").slideToggle(800);
            });
            }
            if(choice == 5){
                setTimeout(function(){
                $.post("/index.php/page/show_donate", 
                    function (data) {
                $("#results").html(data);
                end_time=Date.now();
                console.log("Load was performed.", "Time: ", end_time - start_time);
                $(".loading").hide();
                $("#results").slideToggle(800);
            });}, 800);
            }
        }

        function next() {
            loadDataByPageIndex(++pageIndex);
            console.log('NEXT', pageIndex);
        };

        function previous() {
            if (pageIndex > 1) {
                loadDataByPageIndex(--pageIndex);
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

<!-- highlight the selected menu button -->


<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="#">Search<br \ >Scholar
            </a>
        </div>

            <ul class="pure-menu-list">
                <li class="pure-menu-item" id="homeButton"><a href="<?php echo site_url('page/create');?>" class="pure-menu-link">Home</a></li>
                <li class="pure-menu-item menu-item-divided pure-menu-selected" id="authorButton">
                    <a class="pure-menu-link">Author</a>
                </li>
                <li class="pure-menu-item" id="conferenceButton"><a class="pure-menu-link">Conference</a></li>

                <li class="pure-menu-item" id="paperButton"><a class="pure-menu-link">Paper</a></li>

                <li class="pure-menu-item" id="donateButton"><a class="pure-menu-link">Donate</a></li>
            </ul>
    </div>
</div>

<div class="header" id="header">
    <h1><?php echo $keyWord?></h1>
    <h2>You are searching for ...? <h2>
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
    <div class="loading" style="text-align: center"><br / ><img src="<?php echo base_url('resources/');?>loading.gif"></div>
    <div class="container">
        <div id ='results'>
        </div>
    </div>

</div>

<!-- end of the part displaying the authors -->


<script src="<?php echo base_url('resources/');?>js/ui.js"></script>

</body>
</html>
