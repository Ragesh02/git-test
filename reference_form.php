<?php

include('../pageheader_new.php');
include('../class_data_access.php');
$obj = new dataaccess();
$curr_user = $_SESSION['user_type'];
$user_level=$_SESSION['level'];
if($user_level!='S' || $user_level!='D')
{
	//    echo "<blink><center><br><b r><H3>You are not authorised to view this page.</H3></center></blink>";
	//    $url  =  "../home.php"; // target of the redirect
	//    $delay  =  "1"; // 50 second delay
	//    die( '<meta http-equiv = "refresh" content = "'.$delay.';url = '.$url.'">');
	//    exit;
} 

if((isset($_REQUEST['btn_save'])) && ($_REQUEST['btn_save']!=''))
{ 

	$db->autoCommit(false);
	$flag=0;
  
	$username = $_SESSION["username"];
	$ipaddress = $obj->getRealIpAddr();
	date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
	$upd_date = date("Y-m-d H:i:s");
    
	$edit_id=pg_escape_string(strip_tags($_REQUEST['edit_id']));
    $del_id=pg_escape_string(strip_tags($_REQUEST['del_id']));

    $fin_year=pg_escape_string(strip_tags($_REQUEST['fin_year']));
	$scheme=pg_escape_string(strip_tags($_REQUEST['scheme']));
	$fund_allocation_level=pg_escape_string(strip_tags($_REQUEST['fund_allocation_level']));
    $allocation_date=pg_escape_string(strip_tags($_REQUEST['allocation_date']));
    $proceeding_no=pg_escape_string(strip_tags($_REQUEST['proceeding_no']));
    $installment_no=pg_escape_string(strip_tags($_REQUEST['installment_no']));
    $transaction_type=pg_escape_string(strip_tags($_REQUEST['transaction_type']));
	if($transaction_type==2){
		$Fund_amount=pg_escape_string(strip_tags($_REQUEST['amount']));
		 $amount='-'.$Fund_amount;
	}else{
		$amount=pg_escape_string(strip_tags($_REQUEST['amount']));
	}
    

    if($edit_id!=''){
        $del_id=0;
    }else if($del_id!=''){
    $fin_year='0';
	$scheme=0;
	$fund_allocation_level=0;
    $allocation_date='now()';
    $proceeding_no='0';
    $installment_no=0;
    $amount=0;
    $transaction_type=0;
    $edit_id=0;
    }else if($edit_id=='' && $del_id=='' ){
        $del_id=0;
        $edit_id=0;
    }
    

     $save_query = "select public.sp_scheme_fund_allocation('$fin_year',$scheme,$fund_allocation_level,'$allocation_date','$proceeding_no',$installment_no,$amount,$transaction_type,'$username','$ipaddress',$edit_id,$del_id);"; 

    $flag = $obj->idufn($save_query, $db);
    $message='Successfully saved';

if($flag==0)
{
	unset($_POST);
	$db->commit();
	$db->autoCommit(true); 
	?>
		<script language='javascript'>
			alert('<?php echo $message; ?>');
			window.location.href='scheme_fund_allocation.php';
        </script>
    <?php
exit;
}
else 
{
	$db->autoCommit(false);
	?>
		<script language='javascript'>
	        alert('Not Saved');
			window.location.href='scheme_fund_allocation.php';
        </script>
    <?php
exit;		
}
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RD</title>

<link href="../includes/sort_freeze.css" rel="stylesheet" type="text/css" />
<link href="../includes/jquery-ui.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<link href="../includes/style.css" rel="stylesheet" type="text/css" />
<link href="../includes/CalendarControl.css" rel="stylesheet" media="screen"/> 
  <script type="text/javascript" src="../includes/checkDate.js"></script>
   <script type="text/javascript" src="../includes/CalendarControl.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <script src="jquery-3.7.1.min.js"></script>
</head>

<!-- <script src="../js/jquery-1.7.2.js" type="text/javascript"></script> -->
<script type="text/javascript" src="../js/jquery.tablesorter1.js"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.widgets1.js"></script>
 <script type="text/javascript">
$(document).ready(function(){

<?php if(!isset($_REQUEST['del_id'])){ ?>			
$(document).on('click',"#btn_save",function(){
	try {
		
		
if ($("#fin_year").val().length === 0) {
	throw {
		msg: "Select Financial year",
		foc: "#fin_year"
		}
	}
if ($("#scheme").val().length === 0) {
	throw {
		msg: "Select Scheme",
		foc: "#scheme"
		}
	}
if ($("#fund_allocation_level").val().length === 0) {
	throw {
		msg: "Select Fund Allocation Level",
		foc: "#fund_allocation_level"
		}
	}
if ($("#allocation_date").val().length === 0) {
	throw {
		msg: "Select Allocation Date",
		foc: "#allocation_date"
		}
	}
if ($("#proceeding_no").val().length === 0) {
	throw {
		msg: "Enter Proceeding Number",
		foc: "#proceeding_no"
		}
	}
if ($("#installment_no").val().length === 0) {
	throw {
		msg: "Enter Installment Number",
		foc: "#installment_no"
		}
	}
if ($("#amount").val().length === 0) {
	throw {
		msg: "Enter Amount",
		foc: "#amount"
		}
	}
if ($("#transaction_type").val().length === 0) {
	throw {
		msg: "Select Fund Transaction Type",
		foc: "#transaction_type"
		}
	}


// if ($("#cug_no").val().length != 10) {
// 	throw {
// 		msg: "Enter 10 Digit CUG No",
// 		foc: "#cug_no"
// 		}
// 	}


		return true;
    } catch (e) {
	alert(e.msg);
	$(e.foc).focus();
	return false;
 }
});
<?php } ?>		
});
	

</script>
<style>

.rd_form_table
{
	font: bold 10pt Verdana, Geneva, sans-serif;
}

.rd_form_report_table
{
	font: bold 10pt Verdana, Geneva, sans-serif;
}

.rd_report_table
{
	font: bold 10pt Verdana, Geneva, sans-serif;
}



.rd_form_table tbody td:nth-child(1) {  
  font-weight:bold;
  text-align:left; !important;
  /*width:50%;  !important; */
}

.rd_form_table thead tr:first-child{

background-color: #d6f9ff; // Old browsers
@include filter-gradient(#d6f9ff, #9ee8fa, horizontal); // IE6-9
@include background-image(linear-gradient(left, #d6f9ff 0%,#9ee8fa 100%)); 

	color:#000; !important;
	text-transform:capitalize !important;
	text-align:left !important;
}	



.rd_form_table thead tr:not(:first-child){
	
background-color: #d6f9ff; // Old browsers
@include filter-gradient(#d6f9ff, #9ee8fa, horizontal); // IE6-9
@include background-image(linear-gradient(left, #d6f9ff 0%,#9ee8fa 100%)); 

	color:#000; !important;
	text-transform:capitalize !important;
	text-align:center !important;

}



.rd_form_table tfoot{
	text-align:center !important;
}


.rd_form_report_table thead{

background-color: #d6f9ff; // Old browsers
@include filter-gradient(#d6f9ff, #9ee8fa, horizontal); // IE6-9
@include background-image(linear-gradient(left, #d6f9ff 0%,#9ee8fa 100%)); 
	
	color:#000; !important;
	text-transform:capitalize !important;
	text-align:center !important;
	vertical-align:top; !important;
}

.rd_form_report_table tfoot{
	text-align:center !important;
}

.no_record{
	text-align:center !important;
	color:#F00;
	font-weight:bold;
}


.rd_form_report_table thead tr:first-child{
	/*background-color: #34577b !important; */
	/*background-image: -moz-linear-gradient(top, #dcf4fe 25%, #b6eaff 80%);*/
background-color: #d6f9ff; // Old browsers
@include filter-gradient(#d6f9ff, #9ee8fa, horizontal); // IE6-9
@include background-image(linear-gradient(left, #d6f9ff 0%,#9ee8fa 100%)); 
	/*color:white; !important;*/
	color:#000; !important;
	text-transform:capitalize !important;
	text-align:left !important;
	/*font-size: 18px; !important;
	font-weight:bold;*/
}

.rd_form_report_table thead tr:not(:first-child){
	/*background-color: #3b6de4 #6f96bf !important;*/
	/*background-image: -moz-linear-gradient(top, #dcf4fe 25%, #b6eaff 80%);*/
background-color: #d6f9ff; // Old browsers
@include filter-gradient(#d6f9ff, #9ee8fa, horizontal); // IE6-9
@include background-image(linear-gradient(left, #d6f9ff 0%,#9ee8fa 100%)); 
	/*color:white; !important;*/
	color:#000; !important;
	text-transform:capitalize !important;
	text-align:center !important;
	font-size: 14px; !important;
	vertical-align:text-top;
	font-weight:bold;
}

.rd_form_report_table thead th {
	/*background-color: #3b6de4 #6f96bf !important;*/
	/*background-image: -moz-linear-gradient(top, #dcf4fe 25%, #b6eaff 80%);*/
background-color: #d6f9ff; // Old browsers
@include filter-gradient(#d6f9ff, #9ee8fa, horizontal); // IE6-9
@include background-image(linear-gradient(left, #d6f9ff 0%,#9ee8fa 100%)); 
	/*color:white; !important;*/
	color:#000; !important;
	text-transform:capitalize !important;
	text-align:center !important;
	font-size: 14px; !important;
	vertical-align:text-top;
	font-weight:bold;
}



.rd_form_report_table tfoot tr td{
	text-align:right !important;
	font-size: 14px; !important;
	font-weight:bold;
}

.rd_form_report_table th,td
{
	padding:10px;	
}

.rd_form_report_table th,td
{
	padding:10px;	
}

.rd_form_report_table th,td
{
	padding:10px;	
}


.hidden_field_element
{
	display:none;
}


.cmbstyle {
	width:50%;
	height:100%;

}
.text_box {
	width:50%;
	height:100%;

}

.button_save{
width:100px;
height:30px;
background-color: #007bff;
border-color: #007bff;
font-weight:bolder;
color:#FFF;
}

.button_update{
width:100px;
height:30px;
background-color: #ffc107;
border-color: #ffc107;
font-weight:bolder;
color:#FFF;
}

.button_delete{
width:100px;
height:30px;
background-color: #dc3545;;
border-color: #dc3545;;
font-weight:bolder;
color:#FFF;
}

.button_cancel{
width:100px;
height:30px;
background-color: #17a2b8;;
border-color: #17a2b8;;
font-weight:bolder;
color:#FFF;
}
.width_p{
	width:80% !important;
	}
#example_wrapper{ padding: 0 20% 0 20%;}
</style>
</head>
<body>
<div class="container" style="    padding: 1px 103px 0 123px;
">	

<form method="post" action="" autocomplete="OFF">
<?php 
$submit_btn_value='Save';
$submit_btn_class='button_save';
if((isset($_REQUEST['edit_id']) && $_REQUEST['edit_id']!='') || isset($_REQUEST['del_id']) && $_REQUEST['del_id']!='')
{
	if($_REQUEST['edit_id']!='')
	{
		$fund_allocation_id=base64_decode($_REQUEST['edit_id']);
		$submit_btn_value='Update';
		$submit_btn_class='button_update';
	}
	else if($_REQUEST['del_id']!='')
	{
		$fund_allocation_id=base64_decode($_REQUEST['del_id']);
		$submit_btn_value='Delete';
		$submit_btn_class='button_delete';	
	}
	
   $sel_edit="select fund_allocation_id,fin_year,scheme_id,fund_allocation_level_id,allocation_date,proceeding_no,installment_no,amount,transaction_type from public.t_scheme_fund_allocation where del_flag is null and fund_allocation_id=$fund_allocation_id";

    $res_edit=$obj->selonefn($sel_edit, $db);
}

?>
<table width="60%" border="1" cellpadding="0" cellspacing="0" bordercolor="#5FC1F5" 
style="border-collapse:collapse; font: bold 10pt Verdana, Geneva, sans-serif; color:#000;" align="center" valign="middle" class="rd_form_report_table" >
<thead>
<tr align="center" bgcolor="#FFFFFF" style="background-image: -moz-linear-gradient(top, #dcf4fe 25%, #b6eaff 80%); ">
<td colspan="2"   align="center">Scheme Fund Allocation</td>
</tr>
</thead>
<tbody>

<tr>
<td height="35"  align="left">Financial year</td>
<td height="35" align="left">
<select id="fin_year" name="fin_year" class="width_p" <?php if($_REQUEST['del_id']!=''){ ?>disabled<?php } ?> >
<option value="">Select Financial year</option>
<?php 
  $sel_finyear = "SELECT fin_yearid,fin_year FROM master.m_fin_year WHERE isactive=1 and fin_yearid<=(select public.sp_fin_year_id_from_date(current_date)) AND del_flag IS NULL order by fin_year desc";
  $res_fin_year=$obj->selfn($sel_finyear, $db);
  foreach($res_fin_year as $fin){?>
    <option value="<?php echo $fin['fin_year'];?>"><?php echo $fin['fin_year'];?></option>
  <?php }
?>
</select>
<script>document.getElementById('fin_year').value="<?php echo $res_edit['fin_year']; ?>" </script>
</td>
</tr>

<tr>
<td height="35"  align="left">Scheme</td>
<td height="35" align="left">
<select id="scheme" name="scheme" class="width_p" <?php if($_REQUEST['del_id']!=''){ ?>disabled<?php } ?>>
<option value="">Select Scheme</option>
<?php 
$cond="";
if((isset($_REQUEST['edit_id']) && $_REQUEST['edit_id']!='') || isset($_REQUEST['del_id']) && $_REQUEST['del_id']!='')
{
    $fin_year=$res_edit['fin_year'];
    $cond="where fin_year='$fin_year'";   
}
  $sel_scheme = "select b.scheme_seq_id, b.scheme_group_code, b.scheme_name from
  (SELECT * FROM public.m_finyear_scheme_link  $cond)as a
  left join
  ( SELECT m_scheme.scheme_seq_id, m_scheme.scheme_group_code, m_scheme.scheme_name FROM m_scheme  )as b
  on b.scheme_seq_id=a.scheme_id";
  $res_scheme=$obj->selfn($sel_scheme, $db);
  foreach($res_scheme as $scheme){?>
    <option value="<?php echo $scheme['scheme_seq_id'];?>"><?php echo $scheme['scheme_name'];?></option>
  <?php }
?>
</select>
<script>document.getElementById('scheme').value="<?php echo $res_edit['scheme_id']; ?>" </script>
</td>
</tr>


<tr>
<td height="35"  align="left">Fund Allocation Level</td>
<td height="35" align="left">
<select id="fund_allocation_level" name="fund_allocation_level" class="width_p" <?php if($_REQUEST['del_id']!=''){ ?>disabled<?php } ?>>
<option value="">Select Fund Allocation Level</option>
<?php 
  $sel_fund_level = "select fund_allocation_level_id,fund_allocation_level_name from public.m_fund_allocation_level where del_flag is null";
  $res_fund_level=$obj->selfn($sel_fund_level, $db);
  foreach($res_fund_level as $fund_level){?>
    <option value="<?php echo $fund_level['fund_allocation_level_id'];?>"><?php echo $fund_level['fund_allocation_level_name'];?></option>
  <?php }
?>
</select>
<script>document.getElementById('fund_allocation_level').value="<?php echo $res_edit['fund_allocation_level_id']; ?>" </script>
</td>
</tr>


<tr>
<td height="35"  align="left">Allocation Date</td>
<td height="35" align="left">
<?php if($_REQUEST['del_id']==''){ ?>
<input type="text" name="allocation_date" id="allocation_date" readonly="true" value="<?php echo $res_edit['allocation_date']; ?>" size="10"/>
&nbsp;<img src="../images/calendar.gif" 
                     onclick="showCalendarControl(document.getElementById('allocation_date'));"
                     alt="Show Calendar" align="top" /> 
                     <?php }else{ ?>
                        <?php echo $res_edit['allocation_date']; ?>
<?php
  } ?>
</td>
</tr>


<tr>
<td height="35"  align="left">Proceeding Number</td>
<td height="35" align="left">
<?php if($_REQUEST['del_id']==''){ ?>
<input type="text" name="proceeding_no" id="proceeding_no"  value="<?php echo $res_edit['proceeding_no']; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" <?php if($_REQUEST['del_id']!=''){ ?>disabled<?php } ?> maxlength="10"/>
<?php }else{ ?>
                        <?php echo $res_edit['proceeding_no']; ?>
<?php
  } ?>
 
</td>
</tr>

<tr>
<td height="35"  align="left">Installment Number</td>
<td height="35" align="left">
<?php if($_REQUEST['del_id']==''){ ?> 
<input type="text" name="installment_no" id="installment_no"  value="<?php echo $res_edit['installment_no']; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" <?php if($_REQUEST['del_id']!=''){ ?>disabled<?php } ?> maxlength="6"/>
<?php }else{ ?>
                        <?php echo $res_edit['installment_no']; ?>
<?php
  } ?>
</td>
</tr>

<tr>
<td height="35"  align="left">Amount</td>
<td height="35" align="left">
<?php if($_REQUEST['del_id']=='' & $_REQUEST['edit_id']==''){ ?>    
<input type="text" name="amount" id="amount"  value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" <?php if($_REQUEST['del_id']!=''){ ?>disabled<?php } ?> maxlength="10"/>
<?php }else if($_REQUEST['del_id']!=''){ ?>
                        <?php echo abs($res_edit['amount']); ?>
<?php
  }else if($_REQUEST['edit_id']!=''){
	?>
<input type="text" name="amount" id="amount"  value="<?php echo abs($res_edit['amount']); ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" <?php if($_REQUEST['del_id']!=''){ ?>disabled<?php } ?> maxlength="10"/>	
	<?php
  } ?>
</td>
</tr>

<tr>
<td height="35"  align="left">Fund Transaction Type</td>
<td height="35" align="left">
<select id="transaction_type" name="transaction_type" class="width_p" <?php if($_REQUEST['del_id']!=''){ ?>disabled<?php } ?>>
<option value="">Select Fund Transaction Type</option>
<?php 
  $sel_transaction_type = "select transaction_type,transaction_type_name from public.m_fund_transaction_type where del_flag is null";
  $res_transaction_type=$obj->selfn($sel_transaction_type, $db);
  foreach($res_transaction_type as $transaction_type){?>
    <option value="<?php echo $transaction_type['transaction_type'];?>"><?php echo $transaction_type['transaction_type_name'];?></option>
  <?php }
?>
</select>
<script>document.getElementById('transaction_type').value="<?php echo $res_edit['transaction_type']; ?>" </script>
</td>
</tr>
<?php
if($_GET['edit_id']!=''){
    ?>
<input type="hidden" id="edit_id" name="edit_id" value="<?php echo $res_edit['fund_allocation_id']; ?>" >
<?php } ?>
<?php
if($_GET['del_id']!=''){
    ?>
<input type="hidden"  id="del_id" name="del_id" value="<?php echo $res_edit['fund_allocation_id']; ?>" >
<?php } ?>
</tbody>
<tfoot>
<tr>
<td colspan="2" align="center" >
<input type="submit" id="btn_save" name="btn_save" value="<?php echo $submit_btn_value; ?>" class="<?php echo $submit_btn_class; ?>" />
<input type="button" id="btn_cancel" name="btn_cancel" value="Cancel" class="button_cancel" onClick="window.location='scheme_fund_allocation.php';" />
</td>
</tr>
</tfoot>
</table>


<br />


<div class="down">

<table width="80%"  border="1" cellpadding="0" cellspacing="0" bordercolor="#5FC1F5" 
style="border-collapse:collapse; font: bold 10pt Verdana, Geneva, sans-serif; color:#000;" align="center" valign="middle" class="rd_form_report_table" >

<thead>

    <tr align="center" bgcolor="#FFFFFF" style="background-image: -moz-linear-gradient(top, #dcf4fe 25%, #b6eaff 80%); ">
    <th align="center">Sl.No.</th>
    <th align="center">Financial year</th>
    <th align="center">Scheme</th>
    <th align="center">Fund Allocation Level </th> 
    <th  align="center">Allocation Date</th>
    <th  align="center">Proceeding Number</th>
    <th  align="center">Installment Number</th>
    <th  align="center">Amount </th>
    <th  align="center">Fund Transaction Type </th>
    <th  align="center">Action </th>
    </tr>
</thead>
<tbody>
<?php
 $sel_fund_allocation ="select a.fund_allocation_id,a.fin_year,a.scheme_id,a.fund_allocation_level_id,a.allocation_date,a.proceeding_no,a.installment_no,a.amount,a.transaction_type,b.fund_allocation_level_name,c.transaction_type_name,d.scheme_name from
(select fund_allocation_id,fin_year,scheme_id,fund_allocation_level_id,allocation_date,proceeding_no,installment_no,amount,transaction_type from public.t_scheme_fund_allocation where del_flag is null)as a
left join
(select fund_allocation_level_id,fund_allocation_level_name from public.m_fund_allocation_level where del_flag is null)as b on a.fund_allocation_level_id=b.fund_allocation_level_id
left join
(select transaction_type,transaction_type_name from public.m_fund_transaction_type where del_flag is null)as c on a.transaction_type=c.transaction_type
left join
(SELECT scheme_seq_id, scheme_group_code,scheme_name FROM public.m_scheme )as d on d.scheme_seq_id=a.scheme_id
 order by fund_allocation_id "; 

$result_sel_fund_allocation = $obj->selfn($sel_fund_allocation,$db);

if(count($result_sel_fund_allocation)>0)
{

	foreach($result_sel_fund_allocation as $sel_fund_key=>$sel_fund_row)
	{
	
	?>
	<tr>
	<td align="center"><?php echo $sel_fund_key+1; ?></td>
    <td align="left"><?php echo $sel_fund_row['fin_year'];?></td>
    <td align="left"><?php echo $sel_fund_row['scheme_name'];?></td>
    <td align="left"><?php echo $sel_fund_row['fund_allocation_level_name'];?></td>
    <td align="left"><?php echo $sel_fund_row['allocation_date'];?></td>
    <td align="left"><?php echo $sel_fund_row['proceeding_no'];?></td>
    <td align="left"><?php echo $sel_fund_row['installment_no'];?></td>
    <td align="left"><?php echo abs($sel_fund_row['amount']);?></td>
    <td align="left"><?php echo $sel_fund_row['transaction_type_name'];?></td>
    <td align="left">
	<input type="button"  name="edit_id" value="Edit" class="button_update" onClick="window.location='scheme_fund_allocation.php?edit_id=<?php echo base64_encode($sel_fund_row['fund_allocation_id']); ?>';" />

	<input type="button" id="del_id" name="del_id" value="Delete" class="button_delete" onClick="window.location='scheme_fund_allocation.php?del_id=<?php echo base64_encode($sel_fund_row['fund_allocation_id']); ?>';" />

    </td>	
	</tr>
	<?php
	}
}
else
{
?>
<tr>
	<td colspan="10" class="no_record">Record Not Found</td>
</tr>
<?php	
}
?>
</tbody>
</div>
</table>
<br /><br />
</form>
</div>

<script type="text/javascript">
$(document).ready(function(){

    $('#fin_year').change(function() {
		
		var fin_year = btoa($('#fin_year').val()); 
		$.ajax({
				url :"scheme_fund_allocation_ajax.php",
				data:{fin_year:fin_year,command:btoa(1)},
				success:function(data){
					
					$("#scheme").html(data);
				},
				dataType: "html"
			});
 		});
        });
    </script>

</body>
</html>

