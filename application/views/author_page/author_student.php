
    <div class="content pure-u-1 pure-u-md-3-4" id="MainContent">
        <!-- teacher student relationship -->
        <div class='posts'>
            <h1 class='content-subhead'>Students</h1>
            <div id="load" style="text-align:center; margin-top:200px"><img src="<?php echo base_url('resources/');?>loading.gif"></div>

                <style type="text/css">
                .node {
                    cursor: pointer;
                }

                .node circle {
                  fill: #fff;
                  stroke: steelblue;
                  stroke-width: 3px;
                }

                .node text { font: 12px sans-serif; }

                .link {
                  fill: none;
                  stroke: #ccc;
                  stroke-width: 2px;
                }
                
                </style>
                
                <!-- load the d3.js library --> 
                <script src="https://code.jquery.com/jquery-1.12.4.js"></script>    
                <script src="http://d3js.org/d3.v3.min.js"></script>
                    
                <script>
                var authorId = "<?php echo $authorId;?>";
                var totalNum = 100;
                var if_complete = false;
                $(document).ready(function(){
                    $.post("/index.php/page/get_author_student_backend", {
                        authorId: authorId,
                        authorName: "<?php echo $authorName;?>",
                    });
                    // wait for the php to run
                    setTimeout(function() {
                        d3.json("<?php echo base_url('resources/');?>tmp.json", function(error, treeData) {
                        $("#load").hide();
                        root = treeData[0];
                        update(root);
                        });
                    }, 10000);

                    // load the external data

                });

                // ************** Generate the tree diagram  *****************
                var margin = {top: 20, right: 120, bottom: 20, left: 600},
                    width = 1700 - margin.right - margin.left,
                    height = totalNum * 10 - margin.top - margin.bottom;
                    
                var i = 0;
                    duration = 750;

                var tree = d3.layout.tree()
                    .size([height, width]);

                var diagonal = d3.svg.diagonal()
                    .projection(function(d) { return [d.y, d.x]; });

                var svg = d3.select("body").append("svg")
                    .attr("width", width + margin.right + margin.left)
                    .attr("height", height + margin.top + margin.bottom)
                  .append("g")
                    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



                function update(source) {

                  // Compute the new tree layout.
                  var nodes = tree.nodes(root).reverse(),
                      links = tree.links(nodes);

                  // Normalize for fixed-depth.
                  nodes.forEach(function(d) { d.y = d.depth * 180; });

                  // Declare the nodes…
                  var node = svg.selectAll("g.node")
                      .data(nodes, function(d) { return d.id || (d.id = ++i); });

                  // Enter the nodes.
                  var nodeEnter = node.enter().append("g")
                      .attr("class", "node")
                      .attr("transform", function(d) { 
                          return "translate(" + d.y + "," + d.x + ")"; })
                      .on("click", click);

                   nodeEnter.append("circle")
                      .attr("r", function(d) { return d.value; })
                      .style("stroke", function(d) { return d.type; })
                      .style("fill", function(d) { return d._children ? d.level : "#fff"; });

                  nodeEnter.append("text")
                      .attr("x", function(d) { 
                          return d.children || d._children ? 
                          (d.value + 4) * -1 : d.value + 4 })
                      .attr("dy", ".35em")
                      .attr("text-anchor", function(d) { 
                          return d.children || d._children ? "end" : "start"; })
                      .text(function(d) { return d.name; })
                      .style("fill-opacity", 1);

                  // Transition nodes to their new position.
                  var nodeUpdate = node.transition()
                      .duration(duration)
                      .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });

                  nodeUpdate.select("circle")
                      .attr("r", 10)
                      .style("fill", function(d) { return d._children ? d.level : "#fff"; });

                  nodeUpdate.select("text")
                      .style("fill-opacity", 1);

                  // Transition exiting nodes to the parent's new position.
                  var nodeExit = node.exit().transition()
                      .duration(duration)
                      .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
                      .remove();

                  nodeExit.select("circle")
                      .attr("r", 1e-6);

                  nodeExit.select("text")
                      .style("fill-opacity", 1e-6);

                  // Update the links…
                  var link = svg.selectAll("path.link")
                      .data(links, function(d) { return d.target.id; });

                  // Enter any new links at the parent's previous position.
                  link.enter().insert("path", "g")
                      .attr("class", "link")
                      .style("stroke", function(d) { return d.target.level; })
                      .attr("d", function(d) {
                       var o = {x: source.x0, y: source.y0};
                        return diagonal({source: o, target: o});
                      });

                  // Transition links to their new position.
                  link.transition()
                      .duration(duration)
                      .attr("d", diagonal);

                  // Transition exiting nodes to the parent's new position.
                  link.exit().transition()
                      .duration(duration)
                      .attr("d", function(d) {
                        var o = {x: source.x, y: source.y};
                        return diagonal({source: o, target: o});
                      })
                      .remove();

                  // Stash the old positions for transition.
                  nodes.forEach(function(d) {
                    d.x0 = d.x;
                    d.y0 = d.y;
                  });
                }

                // Toggle children on click.
                function click(d) {
                  if (d.children) {
                    d._children = d.children;
                    d.children = null;
                  } else {
                    d.children = d._children;
                    d._children = null;
                  }
                  update(d);
                }
                </script>
        </div>
    </div>
  </div>
</body>