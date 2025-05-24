<?php
include 'inc/function.php';
$allactions = new Actions();
if($_GET['transation_type'] == 'lead'){
    
    $transationlist = $allactions->getLeadTransationsList();
    
}else if($_GET['transation_type'] == 'inbound_lead'){
    
    $transationlist = $allactions->getInboundLeadTransationsList();
    
}else if($_GET['transation_type'] == 'success'){
    
    //$transationlist = $allactions->getSuccessTransationsList();
    
    $transationlist = $allactions->getWhatsappfollowList();
    $transationlistLeads = $allactions->getWhatsappfollowListlead();
    
    $transationlist = array_merge($transationlist, $transationlistLeads);
    
    usort($transationlist, function($a, $b) {
        return strtotime($b['TXNdatetime']) - strtotime($a['TXNdatetime']);
    });
    
}else if($_GET['transation_type'] == 'whatsapp'){
    
    $transationlist = $allactions->getWhatsappfollowList();
    
}else{
    $transationlist = $allactions->getFailedTransationsList();
}


$mobile_array = array();
$i = 0;
foreach ($transationlist as $tran) {
    
    if($tran['call_attempt_count'] < 5){
                                 
        $mobile_no = preg_replace('/\s+/', '', $tran['mobile']);
            
        $text = $mobile_no;
        if (strpos($mobile_no, '0') === 0) {
            
            $text = substr($mobile_no, 1);
        } elseif (strpos($mobile_no, '91') === 0) {
            
            $text = substr($mobile_no, 2);
        }
        
        if(in_array($text,$mobile_array)){
            continue;
        } 
        
        $i++;
                                
        if($tran['call_attempt_count'] < 1){
            $calltype = 'New Lead';    
        }else{
            $calltype = 'Follow-up';
        }
        
        $string = (strlen($tran['CustName']) > 11) ? substr($tran['CustName'],0,10).'...' : $tran['CustName'];
        
        if($_GET['transation_type'] == 'lead' || $_GET['transation_type'] == 'inbound_lead' || $_GET['transation_type'] == 'whatsapp'){
            
            echo "<tr class='trans-row' data-name='" . $tran['CustName'] . "' data-id='" . $tran['id'] . "' data-email='" . $tran['email'] . "' data-phone='" . $mobile_no . "' data-u_location='" . $tran['UserIPLocation'] . "' data-u_ip='" . $tran['userIP'] . "' data-u_device='" . $tran['UserDevice'] . "' data-lastremark='" . $tran['id'] . "'  data-calloutcome='" . $tran['id'] . "'>";
            echo "<td class='text-center col-1'><a href='javascript:;'>" . $i . "</a></td>";
            echo "<td class='col-3'>" . $string . "</td>";
            echo "<td class='col-3'>" . $text . "</td>";
            echo "<td class='text-center col-2'>". $calltype."</td>";
            echo "<td class='text-center col-3'>" . $tran['TXNdatetime'] . "</td>";
            echo "</tr>";
        
        }else{
            
            $remarks = substr($tran['remarks'], -5);
            $date = date('d-m-y', strtotime($tran['TXNdatetime']));
            echo "<tr class='trans-row' data-name='" . $tran['CustName'] . "' data-id='" . $tran['id'] . "' data-email='" . $tran['email'] . "' data-phone='" . $mobile_no . "' data-u_location='" . $tran['UserIPLocation'] . "' data-u_ip='" . $tran['userIP'] . "' data-u_device='" . $tran['UserDevice'] . "' data-lastremark='" . $tran['id'] . "'  data-calloutcome='" . $tran['id'] . "'  data-txnid='" .$tran['txnID']."' data-amount='".$tran['Amount']."' data-datetime='".$date."' data-remarks='".$remarks."'>";
            echo "<td class='text-center col-1'><a href='javascript:;'>" . $i . "</a></td>";
            echo "<td class='col-3'>" . $string . "</td>";
            echo "<td class='col-3'>" . $text . "</td>";
            echo "<td class='text-center col-2'>". $calltype."</td>";
            echo "<td class='text-center col-3'>" . $tran['TXNdatetime'] . "</td>";
            echo "</tr>";
        }
        
    }
    
    $mobile_array[] = $text;
                                
} 

?>
