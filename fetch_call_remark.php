<?php

include 'inc/function.php';
$allactions = new Actions();
$trans_id = $_GET['trans_id'];
$trans_type = $_GET['trans_type'];

$remark = $allactions->getLatestCallRemark($trans_id, $trans_type);

$res = array();

$res['call_outcome_id'] = $remark['call_outcome'];
if($remark['call_outcome'] == 1){
    $res['call_outcome'] = 'Not Interested';
}elseif($remark['call_outcome'] == 2){
    $res['call_outcome'] =  'Busy';
}elseif($remark['call_outcome'] == 6){
    $res['call_outcome'] =  'Call back';
}elseif($remark['call_outcome'] == 3){
    $res['call_outcome'] =  'Switch off';
}elseif($remark['call_outcome'] == 4){
    $res['call_outcome'] =  'Enrolled';
}elseif($remark['call_outcome'] == 5){
    $res['call_outcome'] =  'RNR';
}elseif($remark['call_outcome'] == 7){
    $res['call_outcome'] =  'Invalid/Wrong Number';
}elseif($remark['call_outcome'] == 8){
    $res['call_outcome'] =  'Follow up';
}elseif($remark['call_outcome'] == 9){
    $res['call_outcome'] =  'Whatsup Follow up';
}else{
    $res['call_outcome'] =  $remark['call_outcome'];
}


$res['call_remark'] =  $remark['call_remark'];

echo json_encode($res);

?>
