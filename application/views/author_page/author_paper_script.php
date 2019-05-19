

    <div class="content pure-u-1 pure-u-md-3-4" id="MainContent">
        <!-- the part of displaying all the papers -->
        <div>
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

            <!-- part of the paper page -->
                <!-- part of the "previous" and "next" button -->
                <!--<div class="loading" style="text-align: center"><br / ><img src="loading.gif"></div>-->
                <div class="container">
                    <div class="list">
                    </div><br>
                </div>
                <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.4.min.js"></script>
                <script>

                    var start_time = 0;
                    var end_time = 1000;
                    var pageIndex = 1;
                    var authorName = "<?php echo $authorName?>"; 
                    var authorID = "<?php echo $authorId?>";// change the keyWord recieved by php into javascript format

                    function loadDataByPageIndex(pageIndex) {
                        $(".list").slideToggle(1000,function(){});
                        start_time=Date.now();

                        $.post("/index.php/page/show_author_paper", {
                                pageIndex: pageIndex,
                                authorName:authorName,
                                authorId: authorID
                            }, function (data) {
                                $(".list").html(data);
                                end_time=Date.now();
                                console.log("Load was performed.", "Time: ", end_time - start_time);
                                $(".list").slideToggle(1000);
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

            </div>
        </div>
        <!-- end of the part of displaying all the papers -->
</div>




</body>
</html>
