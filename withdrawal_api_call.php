<?php
    require_once "inc/functions.php";
    $tokenRefresh = false; /** if we pass false then it will return token which already generated previously and which saved on session */
    $accessToken =  API::generateAccessToken($tokenRefresh);

    echo '<h2>Access Token - '.$accessToken.'</h2>';
    /****************************/
        /** new withdrawal request */
    /****************************/
    $withdrawalRequestData = [
        'amount'=>10,
        'payment_method'=>'upi',
        'upi_upi_id'=>'upi@upiTest', 
        'upi_name'=>'UPI Test',
        'remarks'=>'testing from PHP',
       /*  payment_method:upi
        bank_name:State bank of india
        bank_transaction_type:neft
        account_number:1234567890
        account_name:TEST ABC
        ifsc_code:FG56VBNJ
        googlepay_number:1234567
        google_pay_name:G Pay TestNAME
        google_pay_upi_id:test@sbi
        phonepay_number:1234567890
        phonepay_name:test
        phonepay_upi_id:upi@sbiphonepay
        paytm_number:123456789
        paytm_upi_id:upi@paytm.com
        paytm_name:paytmTest */
       
    ];


    $withdrawalSaveResponse = API::saveWithdrawalRequest($accessToken,$withdrawalRequestData);
    echo '<h2>save withdrawal API response</h2>';
    echo '<pre>';
    print_r($withdrawalSaveResponse);
    echo '</pre>';


    /****************************/
    /** retrive withdrawal request */
    /****************************/
    $requestData = [
            'withdrawal_id'=>$withdrawalSaveResponse['saved_withdrawal_details']['withdrawal_id']
    ];

    $withdrawalSavedResponse = API::retriveSaveWithdrawalRequest($accessToken,$requestData);
    echo '<h2>Retrived saved withdrawal API response</h2>';
    echo '<pre>';
    print_r($withdrawalSavedResponse);
    echo '</pre>';


?>
