		<tfoot>
			<tr>
				<th colspan="6"><?php echo $Report_Footer_TotTickt; ?></th>
				<th colspan="2"><?php echo number_format($total); ?></th>
			</tr>
		</tfoot>
	</table>
	</div><br /><br />
	<center>
		<a style="color:blue; background-color:white;" onclick = "return confirm('<?php echo $Report_Footer_AreYouSure; ?>')" href="index.php"><?php echo $Report_Footer_ComingBk; ?></a>
	| 	<b><button style="color:blue; background-color:white;" onclick="printContent('div1')"><?php echo $Report_Footer_PrintRep; ?></button></b>
	</center>

<div class="container">
	<div class="row">
		<b><center><div class="btn-group pull-center" style=" padding: 10px;">
			<div class="dropdown">
				<button style="color:red" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
     				<span class="glyphicon glyphicon-th-list"></span> <?php echo $Report_Footer_ExportRe; ?>
   		   	<center></b>
   		   </button>
  				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li style="font-weight:bold;"><a href="#" onclick="$('#load_data').tableExport({type:'excel',escape:'false'});"> <img src="images/xls.png" width="50px"> Excel</a></li>
					<li style="font-weight:bold;"><a href="#" onclick="$('#load_data').tableExport({type:'doc',escape:'false'});"> <img src="images/word.png" width="50px"> Word</a></li>
				</ul>
			</div>
	</div>
</div>		
