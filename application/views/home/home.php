<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example that shows off a responsive product landing page.">
    <title>Search Scholar: Home</title>
    
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
            <link rel="stylesheet" href="<?php echo base_url('resources/');?>css/layouts/marketing.css">
        <!--<![endif]-->

    <!-- auto complete function -->
    <!--
    <link rel="stylesheet" href="jquery.ui.autocomplete.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="ui/jquery.ui.core.js"></script>
    <script type="text/javascript" src="ui/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="ui/jquery.ui.position.js"></script>
    <script type="text/javascript" src="ui/jquery.ui.autocomplete.js"></script>-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $( function() {
      $.widget( "custom.catcomplete", $.ui.autocomplete, {
         _create: function() {
             this._super();
             this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
         },
         _renderMenu: function( ul, items ) {
            var that = this;
            $.each( items, function( index, item ) {
                 var li = that._renderItemData( ul, item );
                 if ( item.category ) {
                     li.attr( item.label );
                 }

                 var div = li.children();
                 div.html('<strong>' + item.category + ': ' + '</strong> ' +
                        item.value + ' <small><i>' + item.id + '</i></small>');
             });
         }
        });
        $( function()
        {
            $( "#keyWord" ).catcomplete({
                source: "<?php echo base_url();?>hint.php",
                minLength: 2,
                autoFocus: false
            });
        });
    })
</script>
</head>
<body>






<div class="header">
    <div class="home-menu pure-menu pure-menu-horizontal pure-menu-fixed">
        <a class="pure-menu-heading" href="">Search Scholar</a>

        <ul class="pure-menu-list">
            <li class="pure-menu-item pure-menu-selected"><a href="#" class="pure-menu-link">Home</a></li>
            <li class="pure-menu-item"><a href="http://ieee.seiee.com/" target="_blank" class="pure-menu-link">Learn more</a></li>
            <li class="pure-menu-item"><a href="<?php echo site_url('page/show_donate_home');?>" class="pure-menu-link" target=_blank>Donate</a></li>
        </ul>
    </div>
</div>

<div class="splash-container" style="margin-top:-150px; height:900px">
    <div class="splash">
        <h1 class="splash-head">Search Scholar</h1>
        <p class="splash-subhead">
            <div style="color: yellow"><?php echo validation_errors(); ?></div>
            
            <?php echo form_open('page/create'); ?>
            <label for="keyWord">KeyWord</label>
            <input type="input" id="keyWord" name="keyWord" style="font-size:22px; font-family: Times New Roman; width:555px">
            <input type="submit" value="search" class="pure-button pure-button-primary" style="font-family:Microsoft Yahei; font-size:18px">
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
            <img width="300" alt="File Icons" class="pure-img-responsive" src="<?php echo base_url('resources/');?>img/common/file-icons.png">
        </div>
        <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-3-5">

            <h2 class="content-head content-head-ribbon"></h2>

            <p>
                Our website relys on a database with information of thousands of scholars and papers. With machine learning method, we can provide you with individuative information and recommendation. For more information, you can check the website http://acemap.sjtu.edu.cn/, where you can find greater amount of data.
            </p>
        </div>
    </div>

    <div class="footer l-box is-center">
        Click the "Donate" button to help us do better. 
    </div>

</div>




</body>
</html>
