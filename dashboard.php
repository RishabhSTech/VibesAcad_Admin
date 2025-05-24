<?php 

/*
if(isset($_GET['dev'])){
    // Establish database connection
    $servername = "localhost";
    $username = "mba";
    $password = "mba@123";
    $dbname = "mba";
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT mobile FROM leads GROUP BY mobile HAVING COUNT(*) > 1";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mobile = $row['mobile'];
            $sql2 = "SELECT id, final_status FROM leads WHERE mobile = ?";
            $stmt = $conn->prepare($sql2);
            $stmt->bind_param("s", $mobile);
            $stmt->execute();
            $result2 = $stmt->get_result();
            $data2 = array();
            while ($row2 = $result2->fetch_assoc()) {
                $data2[] = $row2;
            }
            
            // Printing $data2 for debugging
            // echo '<pre>'; print_r($data2);die();
            
            $first_id = '';
            $first_id_status = '';
            foreach ($data2 as $d2) {
                if ($d2['final_status'] == 1 || $d2['final_status'] == 2 || $d2['final_status'] == 3) {
                    $first_id_status = $d2['id'];
                } else {
                    $first_id = $d2['id'];
                   // break; // Exit loop after finding the first non-final_status record
                }
            }
            
            // Construct and execute the DELETE query
            if ($first_id_status != '') {
                $qry_del = "DELETE FROM leads WHERE mobile = ? AND id != ?";
                $stmt_del = $conn->prepare($qry_del);
                $stmt_del->bind_param("si", $mobile, $first_id_status);
                $stmt_del->execute();
            } elseif ($first_id != '') {
                $qry_del = "DELETE FROM leads WHERE mobile = ? AND id != ?";
                $stmt_del = $conn->prepare($qry_del);
                $stmt_del->bind_param("si", $mobile, $first_id);
                $stmt_del->execute();
            }
        }
    } else {
        echo "No results found.";
    }
    
    $conn->close();
    
}
    */

    
include ("inc/config.php");
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    
} else {
    
	header('Location: index.php');
}

include 'inc/function.php';
$allactions = new Actions();

/*
$calls = $allactions->getTotalCalls();
$closed = $allactions->getTotalClosed();
$enrolled = $allactions->getTotalEnrolled();

$failcalls = $allactions->getFailTotalCalls();
$failclosed = $allactions->getFailTotalClosed();
$failenrolled = $allactions->getFailTotalEnrolled();
*/


$monthenrolled = $allactions->getMonthenrolled();
$todayenrolled = $allactions->getTodayenrolled();
$todayenrolled[0]['total'];
$monthenrolled[0]['total'];

$uniqLeads = $allactions->getUniqTotal();
$uniqLeads2 = $allactions->getUniqTotal2();

$totaluniq = $uniqLeads[0]['total']+$uniqLeads2[0]['total'];


$uniqLeads_month = $allactions->getUniqTotal_month();
$uniqLeads2_month = $allactions->getUniqTotal2_month();

$totaluniq_month = $uniqLeads_month[0]['total']+$uniqLeads2_month[0]['total'];


$uniqLeads_follwup = $allactions->getUniqTotal_followup();
$uniqLeads2_follwup = $allactions->getUniqTotal_followup2();

$total_follwup_generate = $uniqLeads_follwup[0]['total']+$uniqLeads2_follwup[0]['total'];

$uniqLeads_follwup_call = $allactions->getUniqTotal_followup_call();
$uniqLeads2_follwup_call = $allactions->getUniqTotal_followup2_call();

$total_follwup_call = $uniqLeads_follwup_call[0]['total']+$uniqLeads2_follwup_call[0]['total'];

$uniqLeads_unique = $allactions->getUniqTotal_unique();
$uniqLeads2_unique = $allactions->getUniqTotal_unique2();

$total_uniqe_generate = $uniqLeads_unique[0]['total']+$uniqLeads2_unique[0]['total'];



$uniqLeads_unique_month = $allactions->getUniqTotal_unique_month();
$uniqLeads2_unique_month = $allactions->getUniqTotal_unique2_month();

$total_uniqe_generate_month = $uniqLeads_unique_month[0]['total']+$uniqLeads2_unique_month[0]['total'];

//$allfollwout = $allactions->getOutfollup_All();
//$abc_fllow_all = $allfollwout[0]['total']+$totaluniq;

$total_success_trans = $allactions->getTotalDirectSuccess();
$total_success_trans_manual = $allactions->getTotalDirectSuccessManual();

$total_success_trans_month = $allactions->getTotalDirectSuccess_month();
$total_success_trans_manual_month = $allactions->getTotalDirectSuccessManual_month();


$outcalls = $allactions->getOutallcalls();
$yet_call = $totaluniq - $outcalls[0]['total'];

$outcalls_month = $allactions->getOutallcalls_month();
$yet_call_month = $totaluniq_month - $outcalls_month[0]['total'];

$outcallsfailed = $allactions->getOutallcallsFailed();
$yet_callFailed = $uniqLeads2[0]['total'] - $outcallsfailed[0]['total'];


$outcallsfailed_month = $allactions->getOutallcallsFailed_month();
$yet_callFailed_month = $uniqLeads2_month[0]['total'] - $outcallsfailed_month[0]['total'];


$outcalls_follup = $allactions->getOutallcalls_folloup();
$yet_call_follup = $uniqLeads2[0]['total'] - $outcalls_follup[0]['total'];

$outclosed = $allactions->getOutClosed();

$outclosedFailed = $allactions->getOutClosedFailed();

$outclosed_month = $allactions->getOutClosed_month();

$outclosedFailed_month = $allactions->getOutClosedFailed_month();

$outfailattp = $allactions->getOutfailattpt();

$outfailattp_month = $allactions->getOutfailattpt_month();

$outfailattpFailed = $allactions->getOutfailattpt_failed();

$outfailattpFailed_month = $allactions->getOutfailattpt_failed_month();

$outfollup = $allactions->getOutfollup();

$outfollup_month = $allactions->getOutfollup_month();

$outfollupFailed = $allactions->getOutfollupFailed();

$outfollupFailed_month = $allactions->getOutfollupFailed_month();

$outenroll = $allactions->getOutenroll();

$outenroll_month = $allactions->getOutenroll_month();

$outenrollFailed = $allactions->getOutenrollFailed();

$outenrollFailed_month = $allactions->getOutenrollFailed_month();

$sumuniqLeads = $allactions->getSumUniqTotal();
$sumuniqLeads2 = $allactions->getSumUniqTotal2();

$sumtotaluniq = $sumuniqLeads[0]['total']+$sumuniqLeads2[0]['total'];


$sumuniqcall = $allactions->getSumUniqcallTotal();
$sumuniqcall2 = $allactions->getSumUniqcallTotal2();

$sumtotaluniqcalls = $sumuniqcall[0]['total']+$sumuniqcall2[0]['total'];

$yet_call_sum = $total_uniqe_generate - $sumtotaluniqcalls;



//--------------- innbound query


$inbound_uniqLeads = $allactions->getUniqTotal_In();
//$inbound_uniqLeads2 = $allactions->getUniqTotal2_In();

$inbound_totaluniq = $inbound_uniqLeads[0]['total'];//+$inbound_uniqLeads2[0]['total'];

$inbound_outcalls = $allactions->getOutallcalls_In();

$inbound_yet_call = $inbound_totaluniq - $inbound_outcalls[0]['total'];

$inbound_outclosed = $allactions->getOutClosed_In();
$inbound_outfailattp = $allactions->getOutfailattpt_In();

$inbound_outfollup = $allactions->getOutfollup_In();
$inbound_outenroll = $allactions->getOutenroll_In();



$inbound_sumuniqLeads = $allactions->getSumUniqTotal_In();
//$inbound_sumuniqLeads2 = $allactions->getSumUniqTotal2_In();

$inbound_sumtotaluniq = $inbound_sumuniqLeads[0]['total'];


$inbound_sumuniqcall = $allactions->getSumUniqcallTotal_In();
$inbound_sumuniqcall2 = $allactions->getSumUniqcallTotal2_In();

$inbound_sumtotaluniqcalls = $inbound_sumuniqcall[0]['total']+$inbound_sumuniqcall2[0]['total'];

$inbound_yet_call_sum = $inbound_sumtotaluniq - $inbound_sumtotaluniqcalls;


$today_active_caller = $allactions->getActiveCaller_today();
$month_active_caller = $allactions->getActiveCaller_month();

$today_active_caller_list = $allactions->getActiveCaller_list_today();
$month_active_caller_list = $allactions->getActiveCaller_list_month();


//------------- date filter function

if(isset($_GET['date']) && $_GET['date'] != ''){
    $custom_date = $_GET['date'];
    $outcalls = $allactions->getOutallcalls($custom_date);
    $outclosed = $allactions->getOutClosed($custom_date);
    $outfailattp = $allactions->getOutfailattpt($custom_date);
}

//------- end filter
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard - The Vibes Acadmy</title>
	<?php include ("inc/styles.php"); ?>
	<style>
           .dashboard table tr td {
             vertical-align: middle;
            text-align: center;
            font-size: 14px;
            font-weight: 400;
            line-height: 17px;
            border: 1px solid #b1b1b1;
            }
            .dashboard table tr th {
            vertical-align: middle;
            text-align: center;
            font-size: 14px;
            font-weight: 500;
            line-height: 17px;
            background: #f5e1da;
            border: 1px solid #b1b1b1;
            }
            .dashboard table  .last-td-color td {
           background: #f5e1da;
            }
             .dashboard table  .sub-td-color td {
           background: #f5dce0;
            }
            .expendicon:before{
              font-size: 16px;
              font-weight: 800 !important;
            }
            .showBody{
                display: none;
            }
            .showBody2{
                display: none;
            }
             .showBody3{
                display: none;
            }
            .title33{
                   font-size: 19px;
    font-weight: 600;
                
            }

	</style>
</head>

<body class="dashboard">
	<?php include ("inc/header.php"); ?>
	<section class="title-heading bg-danger-subtle text-center text-dark py-2" style="background-color: #f5e1da !important;">
		<h6 class="mb-0">Dashboard</h6>
	</section>
	
	
	<div class="container-fluid">
	      <div class="mt-5 title33">Day dashboard</div>   
	      
	      <!--input type="date" id="filter_date" value="<?php //if(isset($_GET['date']) && $_GET['date'] !=''){echo $_GET['date'];}?>"><button type="button" class="filter_action btn btn-dark">Go</button-->
	      
	    <table class="table table-bordered w-100 mt-1 px-5">
	        <thead>
	            <tr>
                    <th></th>
                    <th></th>
                    <th colspan="7">Summary</th>
                    <th colspan="3" rowspan="2">Leads Summary</th>
                    <th colspan="3" rowspan="2">Follow up Summary</th>
	            </tr>
	           <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="4">Calls update</th>
                    <th></th>
	            </tr>
	             <tr>
	                 <th></th>
                    <th class="text-start">Type</th>
                    <th>Total leads for calling (Unique + Follow up)</th>
                    <th>Total calls made</th>
                    <th>Closed</th>
                    <th>Call back/ failed attempt</th>
                    <th>Follow up</th>
                    <th>Enrolled</th>
                    <th>Yet to call leads</th>
                    <th>Unique leads generated</th>
                    <th>Unique leads calls made</th>
                    <th>Yet to action</th>
                    <th>Follow up leads</th>
                    <th>Follow up calls made</th>
                    <th>Yet to action</th>
	            </tr>
	            
	        </thead>
	        <tbody>
	            <tr>
	                <td></td>
                    <td class="text-start">Inbound</td>
                    <td><?php echo $inbound_totaluniq;?></td>
                    <td><?php echo $inbound_outcalls[0]['total'];?></td>
                    <td><?php echo $inbound_outclosed[0]['total'];?></td>
                    <td><?php echo $inbound_outfailattp[0]['total'];?></td>
                    <td><?php echo $inbound_outfollup[0]['total'];?></td>
                    <td><?php echo $inbound_outenroll[0]['total'];?></td>
                    <td><?php echo $inbound_yet_call;?></td>
                    
                    <td><?php echo $inbound_sumtotaluniq;?></td>
                    <td><?php echo $inbound_sumtotaluniqcalls;?></td>
                    <td><?php echo $inbound_yet_call_sum;?></td>
                    
                    <td><?php echo $inbound_outfollup[0]['total'];?></td>
                    <td>0</td>
                    <td><?php echo $inbound_outfollup[0]['total'];?></td>
	            </tr>
	           <tr>
	                <td><i class="bi bi-plus expendicon plusExp"></i></i></td>
                    <td class="text-start">Outbound</td>
                    <td><?php echo $totaluniq;?></td>
                    <td><?php echo $outcalls[0]['total'];?></td>
                    <td><?php echo $outclosed[0]['total'];?></td>
                    <td><?php echo $outfailattp[0]['total'];?></td>
                    <td><?php echo $outfollup[0]['total'];?></td>
                    <td><?php echo $todayenrolled[0]['total'];//$outenroll[0]['total']+$todayenrolled[0]['total'];?></td>
                    <td><?php echo $yet_call;?></td>
                    
                    
                    <td><?php echo $total_uniqe_generate;?></td>
                    <td><?php echo $sumtotaluniqcalls;?></td>
                    <td><?php echo $yet_call_sum;?></td>
                    
                    
                    <td><?php echo $totaluniq-$total_uniqe_generate;?></td>
                    <td><?php echo $outcalls[0]['total']- $sumtotaluniqcalls;?></td>
                    <td><?php echo ($totaluniq-$total_uniqe_generate)-($outcalls[0]['total']- $sumtotaluniqcalls);?></td>
	            </tr>
	            
	            <tr class="sub-td-color showBody">
	                <td rowspan="2"></td>
                    <td class="text-start">Failed</td>
                    <td><?php echo $uniqLeads2[0]['total'];?></td>
                    <td><?php echo $outcallsfailed[0]['total'];?></td>
                    <td><?php echo $outclosedFailed[0]['total'];?></td>
                    <td><?php echo $outfailattpFailed[0]['total'];?></td>
                    <td><?php echo $outfollupFailed[0]['total'];?></td>
                    <td><?php echo $outenrollFailed[0]['total'];?></td>
                    <td><?php echo $yet_callFailed;?></td>
                    
                    <td><?php echo $uniqLeads2_unique[0]['total'];?></td>
                    <td><?php echo $sumuniqcall2[0]['total'];?></td>
                    <td><?php echo $uniqLeads2_unique[0]['total']-$sumuniqcall2[0]['total'];?></td>
                    
                    <td><?php echo $uniqLeads2[0]['total']-$uniqLeads2_unique[0]['total'];?></td>
                    <td><?php echo $outcallsfailed[0]['total']- $sumuniqcall2[0]['total'];?></td>
                    <td><?php echo ($uniqLeads2[0]['total']-$uniqLeads2_unique[0]['total'])-($outcallsfailed[0]['total']- $sumuniqcall2[0]['total']);?></td>
	            </tr>
	            <tr class="sub-td-color showBody">
	         
                    <td class="text-start">Leads</td>
                    <td><?php echo $uniqLeads[0]['total'];?></td>
                    <td><?php echo $outcalls[0]['total']-$outcallsfailed[0]['total'];?></td>
                    <td><?php echo $outclosed[0]['total']-$outclosedFailed[0]['total'];?></td>
                    <td><?php echo $outfailattp[0]['total']-$outfailattpFailed[0]['total'];?></td>
                    <td><?php echo $outfollup[0]['total']-$outfollupFailed[0]['total'];?></td>
                    <td><?php echo $outenroll[0]['total']-$outenrollFailed[0]['total'];?></td>
                    <td><?php echo $yet_call-$yet_callFailed;?></td>
                    
                    <td><?php echo $total_uniqe_generate-$uniqLeads2_unique[0]['total'];?></td>
                    <td><?php echo $sumtotaluniqcalls-$sumuniqcall2[0]['total'];?></td>
                    <td><?php echo $yet_call_sum-($uniqLeads2_unique[0]['total']-$sumuniqcall2[0]['total']);?></td>
                    
                    <td><?php echo $uniqLeads[0]['total']-($total_uniqe_generate-$uniqLeads2_unique[0]['total']);?></td>
                    <td><?php echo $outcalls[0]['total']-$outcallsfailed[0]['total']-($sumtotaluniqcalls-$sumuniqcall2[0]['total']);?></td>
                    <td><?php echo ($uniqLeads[0]['total']-($total_uniqe_generate-$uniqLeads2_unique[0]['total']))-($outcalls[0]['total']-$outcallsfailed[0]['total']-($sumtotaluniqcalls-$sumuniqcall2[0]['total']));?></td>
	            </tr>
	            
	            <tr class="last-td-color">
	                <td></td>
                    <td>Total</td>
                    <td><?php echo $inbound_totaluniq+$totaluniq;?></td>
                    <td><?php echo $inbound_outcalls[0]['total']+$outcalls[0]['total'];?></td>
                    <td><?php echo $inbound_outclosed[0]['total']+$outclosed[0]['total'];?></td>
                    <td><?php echo $inbound_outfailattp[0]['total']+$outfailattp[0]['total'];?></td>
                    <td><?php echo $inbound_outfollup[0]['total']+$outfollup[0]['total'];?></td>
                    <td><?php echo $inbound_outenroll[0]['total']+$outenroll[0]['total'];?></td>
                    <td><?php echo $inbound_yet_call+$yet_call;?></td>
                    
                    <td><?php echo $inbound_sumtotaluniq+$total_uniqe_generate;?></td>
                    <td><?php echo $inbound_sumtotaluniqcalls+$sumtotaluniqcalls;?></td>
                    <td><?php echo $inbound_yet_call_sum+$yet_call_sum;?></td>
                    
                    <td><?php echo $inbound_outfollup[0]['total']+($totaluniq-$total_uniqe_generate);?></td>
                    <td><?php echo $outcalls[0]['total']- $sumtotaluniqcalls;?></td>
                    <td><?php echo $inbound_outfollup[0]['total']+($totaluniq-$total_uniqe_generate)-($outcalls[0]['total']- $sumtotaluniqcalls);?></td>
                    
	            </tr>

	            	            
	        </tbody>
	        
	    </table>
	    
	     <div class="row">
	         <div class="col-md-6">
	             <table class="table table-bordered w-100 mt-5 px-5">
    	        <thead>
    	            <tr>
    	                <th></th>
                        <th>Active callers</th>
                        <th>Average calls per caller</th>
    	            </tr>
    	        </thead>
    	        <tbody>
    	            <tr>
    	                <td><i class="bi bi-plus expendicon plusExp3"></i></i></td>
    	                <td><?php echo $today_active_caller[0]['total_active_users'];?></td>
    	                <td><?php
    	                
    	                if($inbound_outcalls[0]['total']+$outcalls[0]['total'] > 0){
    	               echo  round(($inbound_outcalls[0]['total']+$outcalls[0]['total'])/$today_active_caller[0]['total_active_users']);
    	                }else{
    	                    echo 0;
    	                }
    	                ?></td>
    	            </tr>
    	            <?php foreach($today_active_caller_list as $t_caller){ ?>
    	            <tr class="sub-td-color showBody3">
    	                  <td></td>
    	                <td><?php echo $t_caller['name']?></td>
    	                <td><?php echo $t_caller['total']?></td>
    	            </tr>
    	            <?php } ?>
    	        </tbody>
	        </table>
	         </div>
	         <div class="col-md-6">
	             <table class="table table-bordered w-100 mt-5 px-5">
    	        <thead>
    	            <tr>
    	                <th>Successful transaction</th>
                        <th>Manually Successful</th>
    	            </tr>
    	        </thead>
    	        <tbody>
    	            <tr>
    	                <td><?php echo $total_success_trans[0]['total']?></td>
    	                <td><?php echo $total_success_trans_manual[0]['total']?></td>
    	            </tr>
    	        </tbody>
	        </table>
	         </div>
	     </div>
	  
	  <div class="mt-5 title33">Month till date</div>      
	   <table class="table table-bordered w-100 mt-1  px-5">
	        <thead>
	            <tr>
                    <th></th>
                    <th></th>
                    <th colspan="7">Summary</th>
	            </tr>
	           <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="4">Calls update</th>
                    <th></th>
	            </tr>
	             <tr>
	                 <th></th>
                    <th class="text-start">Type</th>
                    <th>Total leads for calling (Unique + Follow up)</th>
                    <th>Total calls made</th>
                    <th>Closed</th>
                    <th>Call back/ failed attempt</th>
                    <th>Follow up</th>
                    <th>Enrolled</th>
                    <th>Unique leads generated</th>

	            </tr>
	            
	        </thead>
	        <tbody>
	            <tr>
	                <td></td>
                    <td class="text-start">Inbound</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
	            </tr>
	            <tr>
	                 <td><i class="bi bi-plus expendicon plusExp2"></i></i></td>
                    <td class="text-start">Outbound</td>
                    <td><?php echo $totaluniq_month;?></td>
                    <td><?php echo $outcalls_month[0]['total'];?></td>
                    <td><?php echo $outclosed_month[0]['total'];?></td>
                    <td><?php echo $outfailattp_month[0]['total'];?></td>
                    <td><?php echo $outfollup_month[0]['total'];?></td>
                    <td><?php echo $outenroll_month[0]['total']+$monthenrolled[0]['total'];?></td>
                    <td><?php echo $total_uniqe_generate_month;?></td>
	            </tr>
	           <tr class="sub-td-color showBody2">
	                <td rowspan="2"></td>
                    <td class="text-start">Failed</td>
                    <td><?php echo $uniqLeads2_month[0]['total'];?></td>
                    <td><?php echo $outcallsfailed_month[0]['total'];?></td>
                    <td><?php echo $outclosedFailed_month[0]['total'];?></td>
                    <td><?php echo $outfailattpFailed_month[0]['total'];?></td>
                    <td><?php echo $outfollupFailed_month[0]['total'];?></td>
                    <td><?php echo $outenrollFailed_month[0]['total'];?></td>
                    <td><?php echo $uniqLeads2_unique_month[0]['total'];?></td>
	            </tr>
	                 <tr class="sub-td-color showBody2">
	               
                    <td class="text-start">Leads</td>
                    <td><?php echo $uniqLeads_month[0]['total'];?></td>
                    <td><?php echo $outcalls_month[0]['total']-$outcallsfailed_month[0]['total'];?></td>
                    <td><?php echo $outclosed_month[0]['total']-$outclosedFailed_month[0]['total'];?></td>
                    <td><?php echo $outfailattp_month[0]['total']-$outfailattpFailed_month[0]['total'];?></td>
                    <td><?php echo $outfollup_month[0]['total']-$outfollupFailed_month[0]['total'];?></td>
                    <td><?php echo $outenroll_month[0]['total']-$outenrollFailed_month[0]['total'];?></td>
                    <td><?php echo $total_uniqe_generate_month-$uniqLeads2_unique_month[0]['total'];?></td>
	            </tr>
	            <tr class="last-td-color">
	                <td></td>
                    <td class="text-start">Total</td>
                    <td><?php echo $totaluniq_month;?></td>
                    <td><?php echo $outcalls_month[0]['total'];?></td>
                    <td><?php echo $outclosed_month[0]['total'];?></td>
                    <td><?php echo $outfailattp_month[0]['total'];?></td>
                    <td><?php echo $outfollup_month[0]['total'];?></td>
                    <td><?php echo $outenroll_month[0]['total'];?></td>
                    <td><?php echo $total_uniqe_generate_month;?></td>
	            </tr>
	            	            
	        </tbody>
	        
	    </table>
	    
	    <div class="row">
	        <div class="col-md-6">
	    	     <table class="table table-bordered w-100 mt-5 px-5">
    	        <thead>
    	            <tr>
                        <th>Active callers</th>
                        <th>Average calls per caller</th>
    	            </tr>
    	        </thead>
    	        <tbody>
    	            <tr>
    	                <td><?php echo $month_active_caller[0]['total_active_users'];?></td>
    	                <td><?php
    	                
    	               echo  round(($outcalls_month[0]['total'])/$month_active_caller[0]['total_active_users']);
    	                ?></td>
    	            </tr>
    	        </tbody>
	        </table>
	        </div>
	        <div class="col-md-6">
	             <table class="table table-bordered w-100 mt-5 px-5">
    	        <thead>
    	            <tr>
    	                <th>Successful transaction</th>
                        <th>Manually Successful</th>
    	            </tr>
    	        </thead>
    	        <tbody>
    	            <tr>
    	                <td><?php echo $total_success_trans_month[0]['total']?></td>
    	                <td><?php echo $total_success_trans_manual_month[0]['total']?></td>
    	            </tr>
    	        </tbody>
	        </table>
	         </div>
	    
	 </div>




	<?php include ("inc/footer.php"); ?>
	
    <script>
   /*
    $(".plusExp").click(function(){
        $(".showBody").slideDown();
        $( "tr" ).removeClass( "plusExp" )
    });
      $(".plusExp2").click(function(){
        $(".showBody2").slideDown();
        $( "tr" ).removeClass( "plusExp2" )
    });
     $(".plusExp3").click(function(){
        $(".showBody3").slideDown();
        $( "tr" ).removeClass( "plusExp3" )
    });
    */
    
    
    $(".plusExp").click(function(){
        $(".showBody").toggle(300);
        $(this).toggleClass("bi-plus bi-dash");
    });
    
    $(".plusExp2").click(function(){
        $(".showBody2").toggle(300);
        $(this).toggleClass("bi-plus bi-dash");
    });
    
    $(".plusExp3").click(function(){
        $(".showBody3").toggle(300);
        $(this).toggleClass("bi-plus bi-dash");
    });
    
    $(".filter_action").click(function(){
        var date = $("#filter_date").val();
        console.log(date);
        window.location.href = "https://admin.thevibes.academy/dashboard.php?date="+date;
    });
    </script>
</body>

</html>