<body>
<div id="layout" class="pure-g">
    <div class="sidebar pure-u-1 pure-u-md-1-4">
        <div class="header">
            <h1 class="brand-title"><?php echo $authorName?></h1>
            <h2 class="brand-tagline"><?php
                echo "ID: ", $authorId;?>
                <p style="font-size:18px"><?php
                if (strcmp($affiliationName, "Ibm") == 0)
                    echo "IBM";
                else
                    echo ucwords($affiliationName);
            ?></p></h2>

            <nav class="nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a class="pure-button" href="<?php echo site_url('page/show_more_author')?>?authorId=<?php echo $authorId?>&authorName=<?php echo $authorName?>">Papers</a>
                    </li>
                    </br>
                    <li class="nav-item">
                        <a class="pure-button" href="<?php echo site_url('page/show_author_student')?>?authorId=<?php echo $authorId?>&authorName=<?php echo $authorName?>">Student</a>
                    </li>
                    </br>
                    <li class="nav-item">
                        <a class="pure-button" href="<?php echo site_url('page/show_author_cooperator')?>?authorId=<?php echo $authorId?>&authorName=<?php echo $authorName?>">Cooperator</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>