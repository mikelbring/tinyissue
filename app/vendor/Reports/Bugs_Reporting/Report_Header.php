<div style="text-align: center">
	<a style="color:blue; background-color:white;" onclick = "return confirm('<?php echo $Report_Footer_AreYouSure; ?>')" href="index.php"><?php echo $Report_Footer_ComingBk; ?></a>
	<br /><br />
	<div class = "form-inline">
		<label><center><?php echo $Report_Filter_Date; ?></label>
		<input type = "text" class = "form-control" placeholder = "<?php echo $Report_Filter_DateStr; ?>"  id = "date1"/>
		<label><?php echo $Report_Filter_To; ?></label>
		<input type = "text" class = "form-control" placeholder = "<?php echo $Report_Filter_DateEnd; ?>"  id = "date2"/>
		<button type = "button" class = "btn btn-primary" id = "btn_search"><span class = "glyphicon glyphicon-search"></span></button> 
		<button type = "button" id = "reset" class = "btn btn-success"><span class = "glyphicon glyphicon-refresh"><span></button>&nbsp;&nbsp;
		<span class="pull-right"><input type="text" class="search form-control" placeholder="<?php echo $Report_Filter_Search; ?>"></span>
	</div>
</div>
<br />
<div id="div1">
<center><img alt="" src="images/tinyissue.SVG"></center>
	<h1><b><?php echo $Report_Title; ?></b></h1><br />

	<table class="meta">
		<tr>
			<th><span><?php echo $Report_Header_Date; ?> : </span></th>
			<td><span><?php echo "" . date("Y/m/d") . "<br>";?></span></td>
		</tr>
	</table>
	<br />

