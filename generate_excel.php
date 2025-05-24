<?php include_once 'inc/config.php'; 

if (isset($_POST['generate_excel'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $trx_type = $_POST['trx_type'];

	include 'inc/function.php';
    $allactions = new Actions();
	
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename="transations.csv"');
	$output = fopen('php://output', 'w');
	
	if($trx_type == 'LeadCalling'){
	    
	    $leadlist = $allactions->generateLeadExcel($start_date,$end_date);
    	
    	$header = ['Name','Email','Mobile','TXN Datetime','user IP','User Device','User IPLocation','utm Source','utm Medium','utm Campaign','Final Status'];
    	fputcsv($output, $header);
    
    	foreach($leadlist as $lead) {
    		$CustName = $lead['CustName'];
    		$email = $lead['email'];
    		$mobile = $lead['mobile'];
    		$TXNdatetime = $lead['TXNdatetime'];
    		$userIP = $lead['userIP'];
    		$UserDevice = $lead['UserDevice'];
    		$UserIPLocation = $lead['UserIPLocation'];
    		$utm_source = $lead['utm_source'];
    		$utm_medium = $lead['utm_medium'];
    		$utm_campaign = $lead['utm_campaign'];
    		$final_status = ($lead['final_status']) ? $lead['final_status'] : 'N/A';
    		
    		fputcsv($output, [$lead['CustName'], $lead['email'], $lead['mobile'], $lead['TXNdatetime'], $lead['userIP'], $lead['UserDevice'], $lead['UserIPLocation'], $lead['utm_source'], $lead['utm_medium'], $lead['utm_campaign'],$final_status]);
    	}
	    
	    
	}else if($trx_type == 'InboundCalling'){
	    
	    $leadlist = $allactions->generateInboundExcel($start_date,$end_date);
    	
    	$header = ['Name','Email','Mobile','TXN Datetime','user IP','User Device','User IPLocation','utm Source','utm Medium','utm Campaign','Final Status'];
    	fputcsv($output, $header);
    
    	foreach($leadlist as $lead) {
    		$CustName = $lead['CustName'];
    		$email = $lead['email'];
    		$mobile = $lead['mobile'];
    		$TXNdatetime = $lead['TXNdatetime'];
    		$userIP = $lead['userIP'];
    		$UserDevice = $lead['UserDevice'];
    		$UserIPLocation = $lead['UserIPLocation'];
    		$utm_source = $lead['utm_source'];
    		$utm_medium = $lead['utm_medium'];
    		$utm_campaign = $lead['utm_campaign'];
    		$final_status = ($lead['final_status']) ? $lead['final_status'] : 'N/A';
    		
    		fputcsv($output, [$lead['CustName'], $lead['email'], $lead['mobile'], $lead['TXNdatetime'], $lead['userIP'], $lead['UserDevice'], $lead['UserIPLocation'], $lead['utm_source'], $lead['utm_medium'], $lead['utm_campaign'],$final_status]);
    	}
	    
	    
	}else if($trx_type == 'FailedTransaction'){
	    
	    $leadlist = $allactions->generateFailedExcel($start_date,$end_date);
    	
    	$header = ['Name','Email','Mobile','Customer ID','txn ID','Payment Status','Amount','TXN Datetime','Remarks','userIP','UserDevice','UserIPLocation','utm Source','utm Medium','utm Campaign', 'utm Content','Final Status'];
    	fputcsv($output, $header);
    
    	foreach($leadlist as $lead) {
    		$CustName = $lead['CustName'];
    		$email = $lead['email'];
    		$mobile = $lead['mobile'];
    		$customerID = $lead['customerID'];
    		$txnID = $lead['txnID'];
    		$PaymentStatus = $lead['PaymentStatus'];
    		$Amount = $lead['Amount'];
    		$TXNdatetime = $lead['TXNdatetime'];
    		$remarks = $lead['remarks'];
    		$userIP = $lead['userIP'];
    		$UserDevice = $lead['UserDevice'];
    		$UserIPLocation = $lead['UserIPLocation'];
    		$utm_source = $lead['utm_source'];
    		$utm_medium = $lead['utm_medium'];
    		$utm_campaign = $lead['utm_campaign'];
    		$utm_content = $lead['utm_content'];
    		$final_status = ($lead['final_status']) ? $lead['final_status'] : 'N/A';
    		
    		fputcsv($output, [$lead['CustName'], $lead['email'], $lead['mobile'],$lead['customerID'], $lead['txnID'], $lead['PaymentStatus'],$lead['Amount'], $lead['TXNdatetime'],$lead['remarks'], $lead['userIP'], $lead['UserDevice'], $lead['UserIPLocation'], $lead['utm_source'], $lead['utm_medium'], $lead['utm_campaign'], $lead['utm_content'], $final_status]);
    	}
	    
	    
	}else if($trx_type == 'SuccessfulTransaction'){
	    
	    $leadlist = $allactions->generateSuccessExcel($start_date,$end_date);
	    
	    $header = ['Name','Email','Mobile','Customer ID','txn ID','Payment Status','Amount','TXN Datetime','Remarks','userIP','UserDevice','UserIPLocation','utm Source','utm Medium','utm Campaign', 'utm Content','Final Status'];
    	fputcsv($output, $header);
    
    	foreach($leadlist as $lead) {
    		$CustName = $lead['CustName'];
    		$email = $lead['email'];
    		$mobile = $lead['mobile'];
    		$customerID = $lead['customerID'];
    		$txnID = $lead['txnID'];
    		$PaymentStatus = $lead['PaymentStatus'];
    		$Amount = $lead['Amount'];
    		$TXNdatetime = $lead['TXNdatetime'];
    		$remarks = $lead['remarks'];
    		$userIP = $lead['userIP'];
    		$UserDevice = $lead['UserDevice'];
    		$UserIPLocation = $lead['UserIPLocation'];
    		$utm_source = $lead['utm_source'];
    		$utm_medium = $lead['utm_medium'];
    		$utm_campaign = $lead['utm_campaign'];
    		$utm_content = $lead['utm_content'];
    		$final_status = ($lead['final_status']) ? $lead['final_status'] : 'N/A';
    		
    		fputcsv($output, [$lead['CustName'], $lead['email'], $lead['mobile'],$lead['customerID'], $lead['txnID'], $lead['PaymentStatus'],$lead['Amount'], $lead['TXNdatetime'],$lead['remarks'], $lead['userIP'], $lead['UserDevice'], $lead['UserIPLocation'], $lead['utm_source'], $lead['utm_medium'], $lead['utm_campaign'], $lead['utm_content'], $final_status]);
    	}
	}else if($trx_type == 'EarningCalculator'){
	    
	    $earninglist = $allactions->generateEarningCalculatorExcel($start_date,$end_date);
	    
	    $header = ['Id','User Name','Mobile','Store content','About content','Something about','Name','Pincode','Whatsapp mobile','Total views','Total follower', 'Reels Count', 'Login username', 'Insta Username', 'Account Category', 'Total likes2', 'Earning Amount', 'Last Post Date', 'Avg view rate', 'Engagement rate', 'Post per week', 'Avg video duration', 'Total comments', 'paid_collaboration', 'interested_barter_collabs', '	interested_affiliate_collabs', 'audience_gender', 'content_youtubet', 'your_gender', 'content_language', 'your_age', 'Created At'];
    	fputcsv($output, $header);
    
    	while($row = $earninglist->fetch_assoc()) {
    		$EarningAmount = str_replace('₹','',$row['EarningAmount']);
    		fputcsv($output, [$row['id'], $row['user_name'], $row['mobile'], $row['storecontent'], $row['aboutcontent'], $row['somethingabout'], $row['cap_name'], $row['cap_pincode'], $row['cap_whatsapp_num'], $row['totalviews'], $row['totalfollower'], $row['ReelsCount'], $row['loginusername'], $row['insta_username'], $row['AccountCategory'], $row['totallikes2'], $EarningAmount, $row['last_post_date'], $row['avg_view_rate'], $row['engagement_rate'], $row['postperweek'], $row['avgvideoduration'], $row['totalcomment'], $row['paid_collaboration'], $row['interested_barter_collabs'],$row['interested_affiliate_collabs'],$row['audience_gender'],$row['content_youtube'],$row['your_gender'],$row['your_gender'],$row['content_language'], $row['your_age'], $row['created_at']]);
    	}
	}else if($trx_type == 'AbandonedCart'){
	    
	    $abandonedlist = $allactions->generateAbandonedCartExcel($start_date,$end_date);
	    
	    $header = ['Id','Insta Username','Mobile', 'Created At'];
    	fputcsv($output, $header);
    
    	while($row = $abandonedlist->fetch_assoc()) {
    		
    		fputcsv($output, [$row['id'], $row['insta_username'], $row['mobile'], $row['created_at']]);
    	}
	}
	
	fclose($output);
}
exit;


?>