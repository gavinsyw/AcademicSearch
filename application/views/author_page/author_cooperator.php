

    <div class="content pure-u-1 pure-u-md-3-4" id="MainContent">
    <!-- cooperator relationship -->
        <div class='posts'>
            <h1 class='content-subhead'>Cooperators</h1>
            <div id="load" style="text-align:center; margin-top:70px"><img src="<?php echo base_url('resources/');?>loading.gif"></div>

            <style type="text/css">
                .links line {
                stroke: #888;
                stroke-opacity: 0.6;
                }

                .nodes circle {
                stroke: #fff;
                stroke-width: 1.5px;
                }
            </style>

            <svg width="760" height="400"></svg>
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>    
            <script src="https://d3js.org/d3.v4.min.js"></script>

            <script>
                var authorId = "<?php echo $authorId;?>";
                $(document).ready(function(){
                    $.post("/page/get_author_cooperator_backend", {
                        authorId: authorId,
                        authorName: "<?php echo $authorName;?>",
                    });
                });
                    

                    // load the external data

                var svg = d3.select("svg"),
                    width = +svg.attr("width"),
                    height = +svg.attr("height");

                var color = d3.scaleOrdinal(d3.schemeCategory20);

                var simulation = d3.forceSimulation()
                    .force("link", d3.forceLink().id(function(d) { return d.id; }))
                    .force("charge", d3.forceManyBody())
                    .force("center", d3.forceCenter(width / 2, height / 2));

                // wait for the php to run

                setTimeout(function() {
                    $("#load").hide();
                    d3.json("<?php echo base_url('resources/');?>tmp1.json", function(error, graph) {
                        if (error) throw error;

                      var link = svg.append("g")
                          .attr("class", "links")
                        .selectAll("line")
                        .data(graph.links)
                        .enter().append("line")
                          .attr("stroke-width", function(d) { return Math.sqrt(d.value); });

                      var node = svg.append("g")
                          .attr("class", "nodes")
                        .selectAll("circle")
                        .data(graph.nodes)
                        .enter().append("circle")
                          .attr("r", 5)
                          .attr("fill", function(d) { return color(d.group); })
                          .call(d3.drag()
                              .on("start", dragstarted)
                              .on("drag", dragged)
                              .on("end", dragended));

                      node.append("title")
                          .text(function(d) { return d.id; });

                      simulation
                          .nodes(graph.nodes)
                          .on("tick", ticked);

                      simulation.force("link")
                          .links(graph.links);

                      function ticked() {
                        link
                            .attr("x1", function(d) { return d.source.x; })
                            .attr("y1", function(d) { return d.source.y; })
                            .attr("x2", function(d) { return d.target.x; })
                            .attr("y2", function(d) { return d.target.y; });

                        node
                            .attr("cx", function(d) { return d.x; })
                            .attr("cy", function(d) { return d.y; });
                      }
                });
                }, 5000);
                function dragstarted(d) {
                  if (!d3.event.active) simulation.alphaTarget(0.3).restart();
                  d.fx = d.x;
                  d.fy = d.y;
                }

                function dragged(d) {
                  d.fx = d3.event.x;
                  d.fy = d3.event.y;
                }

                function dragended(d) {
                  if (!d3.event.active) simulation.alphaTarget(0);
                  d.fx = null;
                  d.fy = null;
                }
            </script>

        </div>
    </div>
</div>
</body>
