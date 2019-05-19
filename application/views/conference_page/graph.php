<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title></title>
  <link href="<?php echo base_url('resources/');?>jqplot/jquery.jqplot.min.css" rel="stylesheet" />
  <script src="<?php echo base_url('resources/');?>jqplot/jquery.min.js"></script>
  <script src="<?php echo base_url('resources/');?>jqplot/jquery.jqplot.min.js"></script>
  <script src="<?php echo base_url('resources/');?>jqplot/excanvas.js"></script>
  <script src="<?php echo base_url('resources/');?>jqplot/plugins/jqplot.barRenderer.js"></script>
  <script src="<?php echo base_url('resources/');?>jqplot/plugins/jqplot.pointLabels.js"></script>
  <script src="<?php echo base_url('resources/');?>jqplot/plugins/jqplot.canvasAxisTickRenderer.js"></script>
  <script src="<?php echo base_url('resources/');?>jqplot/plugins/jqplot.cursor.js"></script>
  <script src="<?php echo base_url('resources/');?>jqplot/plugins/jqplot.highlighter.js"></script>
  <script src="<?php echo base_url('resources/');?>jqplot/plugins/jqplot.dateAxisRenderer.js"></script>
 
  <script src="<?php echo base_url('resources/');?>jqplot/plugins/jqplot.canvasTextRenderer.js"></script>
  <script src="<?php echo base_url('resources/');?>jqplot/plugins/jqplot.categoryAxisRenderer.js"></script>
<style type="text/css">
    p{
        color:white;
        font-family:"Microsoft Yahei";
        font-size:18px;
        margin:auto;
    }
    #a2{
    	text-decoration: none;
    	color:#AAFF88;
    	font-size:18px;
    }
    #a2:hover{
    	color:purple;
    	font-size: 20px
    }
    #tb{
        position:absolute
        left:300px;
		text-align:center;
		color:white;
		font-family:"Microsoft Yahei";
		font-size:18px;
		margin:auto;
		padding: 10px
    }
    #tr{
    	color:#FF8800;
    	font-size:22px; 
    	font-weight:bold; 
    	font-family:"Times New Roman";
    }
    #td1{
     	color:#FFFFFF;
    	font-size:22px; 
    	font-weight:bold; 
    	font-family:"Times New Roman";
    }
    #td2{
     	color:#66FF33;
    	font-size:22px; 
    	font-weight:bold; 
    	font-family:"Times New Roman";
    }
    .tip span{
 		display:none;
	}
	.tip:hover .popbox{
  		display:block;
  		position: absolute;
  		top:15px;
  		right:40px;
  		width:200px;
  		background-color:#424242;
  		color:#fff;
  		padding:10px;
	}

</style>
</head>

<body>
<canvas id="cv"></canvas>
<script type="text/javascript">
	$(document).ready(function(){
	var conferenceID='<?php echo $conferenceID ;?>';
    var data1 = '<?php echo urlencode(json_encode($information));?>';
    var cosPoints = eval(decodeURIComponent(data1));
   	var plot3= $.jqplot('chart3', [cosPoints], {
        title: conferenceID, //标题
        legend: { show: true, location: 'ne' }, //提示工具栏--show：是否显示,location: 显示位置 (e:东,w:西,s:南,n:北,nw:西北,ne:东北,sw:西南,se:东南) 
        //series: [{showMarker:true}],
        axesDefaults: { //轴的刻度值，字体大小，字体类型，字体角度
          tickRenderer: $.jqplot.CanvasAxisTickRenderer,
          // labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
          tickOptions: {
            //fontSize: '10pt',
            angle: 20
          }
        },
        seriesDefaults: {
          label: 'Conference Paper', //分类名称
          color: 'black', //分类在图标中表示（折现，柱状图等）的颜色
          //showLine: true, //是否显示图表中的折线（折线图中的折线） 
          //markerOptions: {
          //  show:true
          //}
          showMarker: true, //是否显示节点
          pointLabels: {
            show: true,//数据点标签
            // edgeTolerance:1
          }
        },
        axes: {
          xaxis: {
            label: 'year',
            renderer: $.jqplot.CategoryAxisRenderer,
            // readerer:$.jqplot.DateAxisRenderer,
 
            // tickInterval: 'lday',
            labelOptions: {
              //formatString:'%Y-%m-%d',
              fontSize: '10pt'
            }
          },
          yaxis: {
            label: 'The Number of Paepr',
            //autoscale: true,
            min: 0,
            tickOptions: { formatString: '%.2f', fontSize: '10pt' }
          }
        }
      });
   });
</script>
  <div id="chart3" style="height: 600px; width: 1000px;"></div>
  <br />
</body>


