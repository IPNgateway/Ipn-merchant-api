<?php
    require_once "inc/functions.php";
    $tokenRefresh = false; /** if we pass false then it will return token which already generated previously and which saved on session */
    $accessToken =  API::generateAccessToken($tokenRefresh);

    echo '<h2>Access Token - '.$accessToken.'</h2>';

    /****************************/
    /** retrive suitable payment method */
    /****************************/ 
    $paymentMethodRequestData = [
        'amount'=>100,
        'payment_option'=>'upi'
    ];
    $paymentMethodData = API::retrivePaymentMethod($accessToken,$paymentMethodRequestData);
    echo '<h2>payment method response</h2>';
    echo '<pre>';
    print_r($paymentMethodData);
    echo '</pre>';


    /****************************/
        /** new deposit request */
    /****************************/
    $depositRequestData = [
        'amount'=>100,
        'payment_method_id'=>$paymentMethodData['payment_method']['id'],
        'remarks'=>'testing PHP'
    ];


    $depositSaveResponse = API::saveDepositRequest($accessToken,$depositRequestData);
    echo '<h2>save deposit response</h2>';
    echo '<pre>';
    print_r($depositSaveResponse);
    echo '</pre>';


    /****************************/
        /** retrive deposit request */
    /****************************/
    $requestData = [
            'deposit_id'=>$depositSaveResponse['saved_deposit_details']['deposit_id']
    ];
    $depositSavedResponse = API::retriveSavedDepositRequest($accessToken,$requestData);
    echo '<h2>Retrived saved deposit response</h2>';
    echo '<pre>';
    print_r($depositSavedResponse);
    echo '</pre>';


?>
