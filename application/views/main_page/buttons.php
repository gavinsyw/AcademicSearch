<div class="navigation" align="center">
		<?php if ($startPoint >= 10) echo "<button class='previous' onclick='previous()'>Previous</button>";
			if(($total-$startPoint)>10) echo "<button class='next' onclick='next()'>Next</button>";
		?>
</div>

<br / >
<center>
	<select id="select">
		<?php for($i=1;$i<=1+($total / 10);$i++){
		if ($i == $pageIndex)
			echo "<option value=".$i." selected>Page ".$i."</option>";
		else
  			echo "<option value=".$i.">Page ".$i."</option>";}?>
	</select>
	<input id="page" type="button" value="Turn to" onclick="page()"/>
</center>