<?php
class Actions{
	private $host  = 'localhost';
    private $user  = 'mba';
    private $password   = "mba@123";
    private $database  = "mba";   
	public $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }	
    
    private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}
	
	public function storeUser($username,$password,$role){
			$sql = "INSERT INTO admin_users (username, password, role) VALUES ('$username', '$password', '$role')";
			if (mysqli_query($this->dbConnect, $sql)) {
			  return "New record created successfully";
			} else {
			  return "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
	}
	
	public function getEmployeeList(){
		$sqlQuery = "SELECT * FROM `admin_users` where id !='1' ORDER BY id DESC";
		return  $this->getData($sqlQuery);
	}
	
	public function getStudentNotEdList(){
		$sqlQuery = "SELECT * FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND is_edmingle_std = '0' AND DATE(TXNdatetime) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND DATE(TXNdatetime) <= CURDATE() ORDER BY TXNdatetime DESC";
	    return  $this->getData($sqlQuery);
	}
	
	public function getEmployeedata($id){
		
		$sqlQuery = "SELECT * FROM admin_users WHERE id = '".$id."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}
	
	public function getSettingdata(){
		
		$sqlQuery = "SELECT * FROM general_setting";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}
	
	public function getFailedTransationsList_oldbk(){
	
        $sqlQuery = "SELECT *, (SELECT COUNT(*) FROM call_attempt WHERE trans_id = payments.id AND trans_type = 'failed') AS call_attempt_count FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND in_whatspp != 1 AND (final_status IS NULL OR final_status NOT IN ('2', '3')) AND id NOT IN (SELECT trans_id FROM call_attempt WHERE  trans_type = 'failed' AND DATE(created_at) = CURDATE()) AND TXNdatetime IS NOT NULL AND TXNdatetime <= DATE_SUB(NOW(), INTERVAL 10 MINUTE) ORDER BY id DESC";

		return  $this->getData($sqlQuery);
	}
	
	public function getFailedTransationsList(){
        $sqlQuery = "
        SELECT 
            p.*, 
            (SELECT COUNT(*) 
             FROM call_attempt 
             WHERE trans_id = p.id AND trans_type = 'failed') AS call_attempt_count,
            ca.call_outcome
        FROM payments p
        LEFT JOIN (
            SELECT 
                trans_id, 
                call_outcome
            FROM call_attempt 
            WHERE trans_type = 'failed' 
            ORDER BY id DESC
            LIMIT 1
        ) ca ON ca.trans_id = p.id
        WHERE p.PaymentStatus != 'PAYMENT_SUCCESS' 
            AND p.in_whatspp != 1 
            AND (p.final_status IS NULL OR p.final_status NOT IN ('2', '3')) 
            AND p.id NOT IN (SELECT trans_id FROM call_attempt WHERE trans_type = 'failed' AND DATE(created_at) = CURDATE()) 
            AND p.TXNdatetime IS NOT NULL 
            AND p.TXNdatetime <= DATE_SUB(NOW(), INTERVAL 10 MINUTE)
        ORDER BY p.id DESC";
        
        return $this->getData($sqlQuery);
    }

	
	
	public function getCallattept(){
	
        $sqlQuery = "SELECT trans_id,trans_type,count(*) FROM call_attempt GROUP BY trans_id HAVING COUNT(*) > 4";

		return  $this->getData($sqlQuery);
	}
	
	
	public function getallLeads(){
	
        $sqlQuery = "SELECT id FROM leads";

		return  $this->getData($sqlQuery);
	}
	
	public function getallPayements(){
	
        $sqlQuery = "SELECT id FROM payments";

		return  $this->getData($sqlQuery);
	}
	
	public function getSuccessTransationsList(){
		
        $sqlQuery = "SELECT *, (SELECT COUNT(*) FROM call_attempt WHERE trans_id = payments.id AND trans_type = 'success') AS call_attempt_count FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND in_whatspp != 1 AND (final_status IS NULL OR final_status NOT IN ('2', '3')) AND id NOT IN (SELECT trans_id FROM call_attempt WHERE  trans_type = 'success' AND DATE(created_at) = CURDATE()) ORDER BY id DESC";

		return  $this->getData($sqlQuery);
	}
	
	public function getLeadTransationsList(){
		
        $sqlQuery = "SELECT *, (SELECT COUNT(*) FROM call_attempt WHERE trans_id = leads.id AND trans_type = 'lead') AS call_attempt_count FROM leads WHERE lead_type='website' AND in_whatspp != 1 AND (final_status IS NULL OR final_status NOT IN ('2', '3')) AND id NOT IN (SELECT trans_id FROM call_attempt WHERE trans_type = 'lead' AND DATE(created_at) = CURDATE()) ORDER BY id DESC";

		return  $this->getData($sqlQuery);
	}
	
	public function getInboundLeadTransationsList(){
		
        $sqlQuery = "SELECT *, (SELECT COUNT(*) FROM call_attempt WHERE trans_id = leads.id AND trans_type = 'inbound') AS call_attempt_count FROM leads WHERE lead_type='inbound' AND in_whatspp != 1 AND (final_status IS NULL OR final_status NOT IN ('2', '3')) AND id NOT IN (SELECT trans_id FROM call_attempt WHERE trans_type = 'inbound' AND DATE(created_at) = CURDATE()) ORDER BY id DESC";

		return  $this->getData($sqlQuery);
	}
	
	public function getWhatsappfollowList(){
		
        //$sqlQuery = "SELECT *, (SELECT COUNT(*) FROM call_attempt WHERE trans_id = leads.id AND trans_type = 'lead') AS call_attempt_count FROM leads WHERE lead_type='website' AND (final_status IS NULL OR final_status NOT IN ('2', '3')) AND id IN (SELECT trans_id FROM call_attempt WHERE trans_type = 'lead' AND call_outcome = '9' AND whtup_sent = '0') ORDER BY id DESC";
        
       // $sqlQuery = "SELECT *, (SELECT COUNT(*) FROM call_attempt WHERE trans_id = leads.id) AS call_attempt_count FROM leads WHERE  (final_status IS NULL OR final_status NOT IN ('2', '3')) AND id IN (SELECT latest_ca.trans_id FROM (SELECT trans_id, MAX(id) AS latest_id FROM call_attempt WHERE call_outcome = '9' GROUP BY trans_id) AS latest_ca JOIN call_attempt ca ON ca.trans_id = latest_ca.trans_id AND ca.id = latest_ca.latest_id WHERE ca.whtup_sent = '0') ORDER BY id DESC";
        
        $sqlQuery = "SELECT *, (SELECT COUNT(*) FROM call_attempt WHERE trans_id = payments.id) AS call_attempt_count, (SELECT trans_type FROM call_attempt WHERE trans_id = payments.id limit 1) AS trans_type FROM payments WHERE in_whatspp = 1 AND (final_status IS NULL OR final_status NOT IN ('2', '3')) AND id NOT IN (SELECT trans_id FROM call_attempt WHERE DATE(created_at) = CURDATE()) ORDER BY id DESC";

		return  $this->getData($sqlQuery);
	}
	
	public function getWhatsappfollowListlead(){
		
        $sqlQuery = "SELECT *, (SELECT COUNT(*) FROM call_attempt WHERE trans_id = leads.id) AS call_attempt_count, (SELECT trans_type FROM call_attempt WHERE trans_id = leads.id limit 1) AS trans_type FROM leads WHERE in_whatspp = 1 AND (final_status IS NULL OR final_status NOT IN ('2', '3')) AND id NOT IN (SELECT trans_id FROM call_attempt WHERE DATE(created_at) = CURDATE()) ORDER BY id DESC";

		return  $this->getData($sqlQuery);
	}
	
	public function getLatestCallRemark($trans_id, $trans_type) {
        $sqlQuery = "SELECT call_remark,call_outcome FROM call_attempt WHERE trans_type = '".$trans_type."' AND trans_id = $trans_id ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        $data = array();
        $data['call_outcome'] = $row['call_outcome'] ?? "No outcome available";
        $data['call_remark'] = $row['call_remark'] ?? "No remark available";
        return $data;
    }
    
    public function getCallRemarkTransids($trans_type) {
        $sqlQuery = "SELECT trans_id FROM call_attempt WHERE trans_type = '".$trans_type."' AND call_outcome = '6' ";
        return  $this->getData($sqlQuery);
    }
    
	public function generateLeadExcel($start_date,$end_date){
	 	$sqlQuery = "SELECT * FROM leads WHERE lead_type='website' AND DATE(TXNdatetime) BETWEEN '$start_date' AND '$end_date'";
		return  $this->getData($sqlQuery);
	}
	
	public function generateInboundExcel($start_date,$end_date){
	 	$sqlQuery = "SELECT * FROM leads WHERE lead_type='inbound' AND DATE(TXNdatetime) BETWEEN '$start_date' AND '$end_date'";
		return  $this->getData($sqlQuery);
	}
	
	public function generateFailedExcel($start_date,$end_date){
	 	$sqlQuery = "SELECT * FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND DATE(TXNdatetime) BETWEEN '$start_date' AND '$end_date'";
		return  $this->getData($sqlQuery);
	}
	
	public function generateSuccessExcel($start_date,$end_date){
	 	$sqlQuery = "SELECT * FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND DATE(TXNdatetime) BETWEEN '$start_date' AND '$end_date'";
		return  $this->getData($sqlQuery);
	}
	
	//---- dashboard queries
	
	public function getTotalCalls(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type='lead' AND DATE(created_at) = CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getTotalClosed(){
	    $sqlQuery = "SELECT count(*) as total FROM leads WHERE lead_type='inbound' AND final_status = '2' AND DATE(updated_at) = CURDATE()";
	    return  $this->getData($sqlQuery);
	}
	
	public function getTotalEnrolled(){
	    $sqlQuery = "SELECT count(*) as total FROM leads WHERE lead_type='inbound' AND final_status = '3' AND DATE(updated_at) = CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getFailTotalCalls(){
	    
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type='failed' AND DATE(created_at) = CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getFailTotalClosed(){
	    
	    $sqlQuery = "SELECT count(*) as total FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND final_status = '2' AND DATE(updated_at) = CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getFailTotalEnrolled(){
	    $sqlQuery = "SELECT count(*) as total FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND final_status = '3' AND DATE(updated_at) = CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getUniqTotal(){
	    $sqlQuery = "SELECT count(*) as total FROM leads WHERE lead_type='website' AND (final_status IS NULL OR final_status NOT IN ('2', '3'))";
		return  $this->getData($sqlQuery);
	}
	public function getUniqTotal2(){
	    $sqlQuery = "SELECT count(*) as total FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND (final_status IS NULL OR final_status NOT IN ('2', '3'))";
		return  $this->getData($sqlQuery);
	}
	
	public function getUniqTotal_month(){
	    $sqlQuery = "SELECT count(*) as total FROM leads WHERE lead_type='website' AND MONTH(TXNdatetime) = MONTH(CURRENT_DATE()) AND YEAR(TXNdatetime) = YEAR(CURRENT_DATE())";
		return  $this->getData($sqlQuery);
	}
	public function getUniqTotal2_month(){
	    $sqlQuery = "SELECT count(*) as total FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND MONTH(TXNdatetime) = MONTH(CURRENT_DATE()) AND YEAR(TXNdatetime) = YEAR(CURRENT_DATE())";
		return  $this->getData($sqlQuery);
	}
	
	public function getUniqTotal_unique(){
	    $sqlQuery = "SELECT count(*) as total FROM leads WHERE lead_type !='inbound' AND DATE(TXNdatetime) = CURDATE()";
	   
	   //$sqlQuery = "SELECT count(*) as total FROM leads WHERE lead_type !='inbound' AND (final_status IS NULL OR final_status NOT IN ('2', '3') AND id NOT IN (SELECT trans_id FROM call_attempt)";
	   
	    return  $this->getData($sqlQuery);
	}
	
	public function getUniqTotal_unique2(){
	    $sqlQuery = "SELECT count(*) as total FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND DATE(TXNdatetime) = CURDATE()";
	    
	    // $sqlQuery = "SELECT count(*) as total FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND final_status != 2 AND final_status != 3 AND id NOT IN (SELECT trans_id FROM call_attempt)";
	    return  $this->getData($sqlQuery);
	}
	
	public function getUniqTotal_unique_month(){
	    $sqlQuery = "SELECT count(*) as total FROM leads WHERE lead_type !='inbound' AND MONTH(TXNdatetime) = MONTH(CURRENT_DATE()) AND YEAR(TXNdatetime) = YEAR(CURRENT_DATE())";
	    return  $this->getData($sqlQuery);
	}
	
	public function getUniqTotal_unique2_month(){
	    $sqlQuery = "SELECT count(*) as total FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND MONTH(TXNdatetime) = MONTH(CURRENT_DATE()) AND YEAR(TXNdatetime) = YEAR(CURRENT_DATE())";
	    return  $this->getData($sqlQuery);
	}
	
	public function getUniqTotal_followup_old(){ 
	   $sqlQuery = "SELECT count(*) as total FROM leads WHERE lead_type !='inbound' AND final_status != 2 AND final_status != 3 AND id IN (SELECT trans_id FROM call_attempt)";
	   
	    return  $this->getData($sqlQuery);
	}
	
	public function getUniqTotal_followup2_old(){
	     $sqlQuery = "SELECT count(*) as total FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND final_status != 2 AND final_status != 3 AND id IN (SELECT trans_id FROM call_attempt)";
	    return  $this->getData($sqlQuery);
	}
	
	public function getUniqTotal_followup(){ 
	   //$sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_id IN (SELECT id FROM leads WHERE lead_type='website' AND (final_status IS NULL OR final_status NOT IN ('2', '3'))) GROUP BY trans_id";
	   
	   $sqlQuery = "SELECT COUNT(*) AS total FROM ( SELECT * FROM call_attempt WHERE trans_id IN ( SELECT id FROM leads WHERE lead_type='website' AND (final_status IS NULL OR final_status NOT IN ('2', '3')) ) GROUP BY trans_id ) AS subquery";
	    return  $this->getData($sqlQuery);
	}
	
	public function getUniqTotal_followup2(){
	     $sqlQuery = "SELECT COUNT(*) AS total FROM ( SELECT * FROM call_attempt WHERE trans_id IN ( SELECT id FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND (final_status IS NULL OR final_status NOT IN ('2', '3')) ) GROUP BY trans_id ) AS subquery";
	    return  $this->getData($sqlQuery);
	}
	
	
	public function getUniqTotal_followup_call(){ 
	   $sqlQuery = "SELECT count(*) as total FROM leads WHERE lead_type !='inbound' AND final_status != 2 AND final_status != 3 AND id IN (SELECT trans_id FROM call_attempt WHERE DATE(created_at) = CURDATE())";
	   
	    return  $this->getData($sqlQuery);
	}
	
	public function getUniqTotal_followup2_call(){
	     $sqlQuery = "SELECT count(*) as total FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND final_status != 2 AND final_status != 3 AND id IN (SELECT trans_id FROM call_attempt WHERE DATE(created_at) = CURDATE())";
	    return  $this->getData($sqlQuery);
	}
	
	
	public function getOutallcalls($custom_date = ''){
	    if($custom_date == ''){
	        $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND DATE(created_at) = CURDATE()";
	    }else{
	        $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND trans_type != 'success' AND DATE(created_at) = '$custom_date'";
	    }
		return  $this->getData($sqlQuery);
	}
	
	public function getOutallcalls_month(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
		return  $this->getData($sqlQuery);
	}
	
	public function getOutallcallsFailed(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'failed' AND DATE(created_at) = CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getOutallcallsFailed_month(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'failed' AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
		return  $this->getData($sqlQuery);
	}
	
	public function getOutallcalls_folloup(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND DATE(created_at) != CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getOutClosed($custom_date = ''){
	    if($custom_date == ''){
	        $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND final_status = '2' AND DATE(created_at) = CURDATE()";
	    }else{
	        $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND final_status = '2' AND DATE(created_at) = '$custom_date'";
	    }
		return  $this->getData($sqlQuery);
	}
	
	public function getOutClosed_month(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND final_status = '2' AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutClosedFailed(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'failed' AND final_status = '2' AND DATE(created_at) = CURDATE()";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutClosedFailed_month(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'failed' AND final_status = '2' AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutfailattpt($custom_date = ''){
	    if($custom_date == ''){
	        $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND final_status != '2' AND `call_outcome` in (1,2,6,3,5,7) AND DATE(created_at) = CURDATE()";
	    }else{
	        $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND final_status != '2' AND `call_outcome` in (1,2,6,3,5,7) AND DATE(created_at) = '$custom_date'";
	    }
		return  $this->getData($sqlQuery);
	}
	
	public function getOutfailattpt_month(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND final_status != '2' AND `call_outcome` in (1,2,6,3,5,7) AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutfailattpt_failed(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'failed' AND final_status != '2' AND `call_outcome` in (1,2,6,3,5,7) AND DATE(created_at) = CURDATE()";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutfailattpt_failed_month(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'failed' AND final_status != '2' AND `call_outcome` in (1,2,6,3,5,7) AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
	    
		return  $this->getData($sqlQuery);
	}
	
	
	public function getOutfollup(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND final_status != '2' AND `call_outcome` in (8,9) AND DATE(created_at) = CURDATE()";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutfollup_month(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND final_status != '2' AND `call_outcome` in (8,9) AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutfollupFailed(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'failed' AND final_status != '2' AND `call_outcome` in (8,9) AND DATE(created_at) = CURDATE()";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutfollupFailed_month(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'failed' AND final_status != '2' AND `call_outcome` in (8,9) AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutenroll(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND call_outcome = '4' AND final_status = '3' AND DATE(created_at) = CURDATE()";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutenroll_month(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND call_outcome = '4' AND final_status = '3' AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutenrollFailed(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'failed' AND call_outcome = '4' AND final_status = '3' AND DATE(created_at) = CURDATE()";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutenrollFailed_month(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'failed' AND call_outcome = '4' AND final_status = '3' AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getSumUniqTotal(){
	    $sqlQuery = "SELECT count(*) as total FROM leads WHERE lead_type='lead' AND final_status != '2' AND DATE(TXNdatetime) = CURDATE() AND id NOT IN (SELECT trans_id FROM call_attempt)";
		return  $this->getData($sqlQuery);
	}
	public function getSumUniqTotal2(){
	    $sqlQuery = "SELECT count(*) as total FROM payments WHERE DATE(TXNdatetime) = CURDATE() AND (final_status IS NULL OR final_status != 2)  AND id NOT IN (SELECT trans_id FROM call_attempt)";
		return  $this->getData($sqlQuery);
	}
	
	public function getSumUniqcallTotal(){
	    
	    //$sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND DATE(created_at) = CURDATE() AND trans_id IN (SELECT id FROM leads WHERE DATE(TXNdatetime) = CURDATE() AND (final_status IS NULL OR final_status != 2))";
	    
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE DATE(created_at) = CURDATE() AND trans_id IN (SELECT id FROM leads WHERE lead_type !='inbound' AND DATE(TXNdatetime) = CURDATE())";
	    
		return  $this->getData($sqlQuery);
	}
	public function getSumUniqcallTotal2(){
	    
	    //$sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type != 'inbound' AND DATE(created_at) = CURDATE() AND trans_id IN (SELECT id FROM payments WHERE DATE(TXNdatetime) = CURDATE() AND (final_status IS NULL OR final_status != 2))";
	    
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE DATE(created_at) = CURDATE() AND trans_id IN (SELECT id FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND DATE(TXNdatetime) = CURDATE())";
	    
	    
		return  $this->getData($sqlQuery);
	}
	
	
	
	//------------------ inbound
	
	
	public function getUniqTotal_In(){
	    $sqlQuery = "SELECT count(*) as total FROM leads WHERE lead_type = 'inbound' AND (final_status IS NULL OR final_status != 2) AND DATE(TXNdatetime) = CURDATE()";
		return  $this->getData($sqlQuery);
	}
	public function getUniqTotal2_In(){
	    $sqlQuery = "SELECT count(*) as total FROM payments WHERE DATE(TXNdatetime) = CURDATE() AND (final_status IS NULL OR final_status != 2)";
		return  $this->getData($sqlQuery);
	}
	
	public function getOutallcalls_In(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'inbound' AND DATE(created_at) = CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getOutClosed_In(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'inbound' AND final_status = '2' AND DATE(created_at) = CURDATE()";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutfailattpt_In(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'inbound' AND final_status != '2' AND DATE(created_at) = CURDATE()";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutfollup_In(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'inbound' AND (final_status IS NULL OR final_status != 2)";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getOutenroll_In(){
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'inbound' AND call_outcome = '4' AND final_status = '3' AND DATE(created_at) = CURDATE()";
	    
		return  $this->getData($sqlQuery);
	}
	
	public function getSumUniqTotal_In(){
	    $sqlQuery = "SELECT count(*) as total FROM leads WHERE lead_type='lead' AND final_status != '2' AND DATE(TXNdatetime) = CURDATE() AND id NOT IN (SELECT trans_id FROM call_attempt)";
		return  $this->getData($sqlQuery);
	}
	public function getSumUniqTotal2_In(){
	    $sqlQuery = "SELECT count(*) as total FROM payments WHERE DATE(TXNdatetime) = CURDATE() AND (final_status IS NULL OR final_status != 2)  AND id NOT IN (SELECT trans_id FROM call_attempt)";
		return  $this->getData($sqlQuery);
	}
	
	public function getSumUniqcallTotal_In(){
	    
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'inbound' AND DATE(created_at) = CURDATE() AND trans_id IN (SELECT id FROM leads WHERE DATE(TXNdatetime) = CURDATE() AND (final_status IS NULL OR final_status != 2))";
		return  $this->getData($sqlQuery);
	}
	public function getSumUniqcallTotal2_In(){
	    
	    $sqlQuery = "SELECT count(*) as total FROM call_attempt WHERE trans_type = 'inbound' AND DATE(created_at) = CURDATE() AND trans_id IN (SELECT id FROM payments WHERE DATE(TXNdatetime) = CURDATE() AND (final_status IS NULL OR final_status != 2))";
		return  $this->getData($sqlQuery);
	}
	
	
	public function getActiveCaller_today(){ 
	   $sqlQuery = "SELECT COUNT(DISTINCT added_by) AS total_active_users FROM call_attempt WHERE trans_type != 'success' AND DATE(created_at) = CURDATE()";
	   
	    return  $this->getData($sqlQuery);
	}
	
	public function getActiveCaller_month(){ 
	   $sqlQuery = "SELECT COUNT(DISTINCT added_by) AS total_active_users FROM call_attempt WHERE trans_type != 'success' AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
	   
	    return  $this->getData($sqlQuery);
	}
	
	public function getActiveCaller_list_today(){ 
	   $sqlQuery = "SELECT call_attempt.added_by, count(call_attempt.added_by) as total, admin_users.name FROM `call_attempt` JOIN admin_users ON call_attempt.added_by = admin_users.id WHERE DATE(call_attempt.created_at) = CURDATE() GROUP BY call_attempt.added_by";
	   
	    return  $this->getData($sqlQuery);
	}
	
	public function getActiveCaller_list_month(){ 
	   $sqlQuery = "SELECT call_attempt.added_by, count(call_attempt.added_by) as total, admin_users.name FROM `call_attempt` JOIN admin_users ON call_attempt.added_by = admin_users.id WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) GROUP BY call_attempt.added_by";
	   
	    return  $this->getData($sqlQuery);
	}
	
	public function getTotalDirectSuccess(){
	    
	    $sqlQuery = "SELECT count(*) as total FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND manual_mark = 0 AND DATE(TXNdatetime) = CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getTotalDirectSuccessManual(){
	    
	    $sqlQuery = "SELECT count(*) as total FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND manual_mark = 1 AND DATE(TXNdatetime) = CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getTotalDirectSuccess_month(){
	    
	    $sqlQuery = "SELECT count(*) as total FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND manual_mark = 0 AND MONTH(TXNdatetime) = MONTH(CURRENT_DATE()) AND YEAR(TXNdatetime) = YEAR(CURRENT_DATE())";
		return  $this->getData($sqlQuery);
	}
	
	public function getTotalDirectSuccessManual_month(){
	    
	    $sqlQuery = "SELECT count(*) as total FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND manual_mark = 1 AND MONTH(TXNdatetime) = MONTH(CURRENT_DATE()) AND YEAR(TXNdatetime) = YEAR(CURRENT_DATE())";
		return  $this->getData($sqlQuery);
	}
	
	public function getTodayfailed(){
	    
	    $sqlQuery = "SELECT * FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND DATE(TXNdatetime) >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND DATE(TXNdatetime) <= CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getLastDayfailed(){
	    //$sqlQuery = "SELECT id,mobile FROM payments WHERE PaymentStatus != 'PAYMENT_SUCCESS' AND failed_sent IS NULL AND DATE(TXNdatetime) >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND DATE(TXNdatetime) <= CURDATE()";
	    $sqlQuery = "SELECT id, mobile, CustName FROM payments 
             WHERE PaymentStatus != 'PAYMENT_SUCCESS' 
             AND failed_sent IS NULL 
             AND DATE(TXNdatetime) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
		return  $this->getData($sqlQuery);
	}
	
	public function getTodaySuccess(){
	    
	    $sqlQuery = "SELECT * FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND DATE(TXNdatetime) >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND DATE(TXNdatetime) <= CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getUnregisteredStudent(){
	    
	    $sqlQuery = "SELECT * FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND is_student_registration = '0' AND DATE(TXNdatetime) >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND DATE(TXNdatetime) <= CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getFailedMail(){
	    
	    $sqlQuery = "SELECT * FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND is_sent = '0' AND DATE(TXNdatetime) >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND DATE(TXNdatetime) <= CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getTodaywhatsapp(){
	    
	    $sqlQuery = "SELECT id,mobile,CustName FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND congratulations_sent IS NULL AND is_sent = '1' AND DATE(TXNdatetime) >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND DATE(TXNdatetime) <= CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getTodayenrolled(){
	    $sqlQuery = "SELECT count(*) as total FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND DATE(TXNdatetime) = CURDATE() AND id IN (SELECT trans_id FROM call_attempt)";
		return  $this->getData($sqlQuery);
	}
	public function getMonthenrolled(){
	    $sqlQuery = "SELECT COUNT(*) AS total FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND MONTH(TXNdatetime) = MONTH(CURDATE()) AND YEAR(TXNdatetime) = YEAR(CURDATE()) AND id IN (SELECT trans_id FROM call_attempt);
";
		return  $this->getData($sqlQuery);
	}
	 
	
	public function getTodaystudent(){
	    
	    $sqlQuery = "SELECT * FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND is_enrolled IS NULL AND student_id IS NOT NULL AND student_id != '' AND is_edmingle_std = '1' AND DATE(TXNdatetime) >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND DATE(TXNdatetime) <= CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getNotregistrationStudents(){
	    
	    $sqlQuery = "SELECT * FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND is_student_registration = '0' AND DATE(TXNdatetime) >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND DATE(TXNdatetime) <= CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	public function getTodaystudent1(){
	    
	    $sqlQuery = "SELECT * FROM payments WHERE PaymentStatus = 'PAYMENT_SUCCESS' AND is_edmingle_std = '1' AND DATE(TXNdatetime) >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND DATE(TXNdatetime) <= CURDATE()";
		return  $this->getData($sqlQuery);
	}
	
	
	public function generateEarningCalculatorExcel($start_date,$end_date){
	 	
	 	$servername = "localhost";
        $username = "thevibesbuzz";
        $password = "7XmPzhGJGGKTyRRr";
        $dbname = "thevibesbuzz";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "SELECT * FROM user_insta_profile WHERE DATE(created_at) BETWEEN '$start_date' AND '$end_date'";
        $result = $conn->query($sql);

		return  $result;
	}
	
	public function generateAbandonedCartExcel($start_date,$end_date){
	 	
	 	$servername = "localhost";
        $username = "thevibesbuzz";
        $password = "7XmPzhGJGGKTyRRr";
        $dbname = "thevibesbuzz";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "SELECT * FROM abandoned_cart WHERE DATE(created_at) BETWEEN '$start_date' AND '$end_date'";
        $result = $conn->query($sql);

		return  $result;
	}
	
}
?>