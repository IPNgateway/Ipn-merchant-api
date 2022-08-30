<?php 

require_once "config.php";

class API
{
	
 
    /**
    * common curl code to make api call
    */
   public static function callAPI($method, $url, $data,$headers){
            $curl = curl_init();
            switch ($method){
               case "POST":
                  curl_setopt($curl, CURLOPT_POST, 1);
                  if ($data)
                     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                  break;
               case "PUT":
                  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                  if ($data)
                     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
                  break;
               default:
                  if ($data)
                  $url = sprintf("%s?%s", $url, http_build_query($data));
            }
            
           /*  OPTIONS: */
            curl_setopt($curl, CURLOPT_URL, $url);
           
            /*   $headers = array(
                  'Accept: application/json',
                  'Authorization:Bearer {token}',
            ); */

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            /*  EXECUTE: */
            $result = curl_exec($curl);
            if(!$result){die("Connection Failure");}
            curl_close($curl);
            return json_decode($result,true);
   }
		
   /**
    * generate new access token
    * if refresh false then if token exist in session then return those session token
    * if refresh true then new token generate and those token will be stored on session
    */
   public static function generateAccessToken($refresh=true)
   {
      if($refresh==false){
         if(isset($_SESSION['access_token']) && !empty($_SESSION['access_token'])){
            return $_SESSION['access_token'];
         }
      }

      $headers = [
         'Accept: application/json',
      ];

      
      if(MERCHANT_PRIVATE_KEY=='' || MERCHANT_PUBLIC_KEY=='' || BASE_URL==''){
         echo "<h2>Something wrong, Please enter valid config on inc/config.php</h2>";
         exit;
      }

      $data = [
         'private_key'=>MERCHANT_PRIVATE_KEY,
         'public_key'=>MERCHANT_PUBLIC_KEY,
      ];

      $url = BASE_URL.'/generate-access-token';

      $response = API::callAPI('POST', $url, $data,$headers);
       
      if($response['success']==1){
         unset($_SESSION['access_token']);
         $_SESSION['access_token'] = $response['access_token'];

         return $response['access_token'];
      }else{
         echo '<h2>Something wrong while calling API -- Error- '.$response['message'].'</h2>';
         exit;
      }
      
   }

    /**
    * view api documentation for request parameter
    * need to pass access token which you got via generateAccessToken functions
    * once successfully saved it will return saved deposit details 
    */
    public static function retrivePaymentMethod($accessToken,$requestData)
    {
    
 
       $headers = [
          'Accept: application/json',
          'Authorization:Bearer '.$accessToken,
       ];
 
       
       if(MERCHANT_PRIVATE_KEY=='' || MERCHANT_PUBLIC_KEY=='' || BASE_URL==''){
          echo "<h2>Something wrong, Please enter valid config on inc/config.php</h2>";
          exit;
       }
 
       $data = $requestData;
 
       $url = BASE_URL.'/payment-methods';
 
       $response = API::callAPI('POST', $url, $data,$headers);
        
       if($response['success']==1){
          return $response;
       }else{
          echo '<h2>Something wrong while calling API -- Error- '.$response['message'].'</h2>';
          exit;
       }
       
    }


   /**
    * view api documentation for request parameter
    * need to pass access token which you got via generateAccessToken functions
    * once successfully saved it will return saved deposit details 
    */
    public static function saveDepositRequest($accessToken,$requestData)
    {
    
 
       $headers = [
          'Accept: application/json',
          'Authorization:Bearer '.$accessToken,
       ];
 
       
       if(MERCHANT_PRIVATE_KEY=='' || MERCHANT_PUBLIC_KEY=='' || BASE_URL==''){
          echo "<h2>Something wrong, Please enter valid config on inc/config.php</h2>";
          exit;
       }
 
       $data = $requestData;
 
       $url = BASE_URL.'/merchant-deposit-store';
 
       $response = API::callAPI('POST', $url, $data,$headers);
        
       if($response['success']==1){
          return $response;
       }else{
          echo '<h2>Something wrong while calling API -- Error- '.$response['message'].'</h2>';
          exit;
       }
       
    }


    /**
    * view api documentation for request parameter
    * need to pass access token which you got via generateAccessToken functions
    * once successfully retrived  it will return saved deposit details 
    */
    public static function retriveSavedDepositRequest($accessToken,$requestData)
    {
    
 
       $headers = [
          'Accept: application/json',
          'Authorization:Bearer '.$accessToken,
       ];
 
       
       if(MERCHANT_PRIVATE_KEY=='' || MERCHANT_PUBLIC_KEY=='' || BASE_URL==''){
          echo "<h2>Something wrong, Please enter valid config on inc/config.php</h2>";
          exit;
       }
 
       $data = $requestData;
 
       $url = BASE_URL.'/deposit-history';
 
       $response = API::callAPI('POST', $url, $data,$headers);
        
       if($response['success']==1){
          return $response;
       }else{
          echo '<h2>Something wrong while calling API -- Error- '.$response['message'].'</h2>';
          exit;
       }
       
    }
	

     /**
    * view api documentation for request parameter
    * need to pass access token which you got via generateAccessToken functions
    * once successfully saved it will return saved withdrawal details 
    */
    public static function saveWithdrawalRequest($accessToken,$requestData)
    {
    
 
       $headers = [
          'Accept: application/json',
          'Authorization:Bearer '.$accessToken,
       ];
 
       
       if(MERCHANT_PRIVATE_KEY=='' || MERCHANT_PUBLIC_KEY=='' || BASE_URL==''){
          echo "<h2>Something wrong, Please enter valid config on inc/config.php</h2>";
          exit;
       }
 
       $data = $requestData;
 
       $url = BASE_URL.'/withdrawal-request-store';
 
       $response = API::callAPI('POST', $url, $data,$headers);
        
       if($response['success']==1){
          return $response;
       }else{
          echo '<h2>Something wrong while calling API -- Error- '.$response['message'].'</h2>';
          exit;
       }
       
    }

      /**
    * view api documentation for request parameter
    * need to pass access token which you got via generateAccessToken functions
    * once successfully retrived  it will return saved withdrawal details 
    */
    public static function retriveSaveWithdrawalRequest($accessToken,$requestData)
    {
    
 
       $headers = [
          'Accept: application/json',
          'Authorization:Bearer '.$accessToken,
       ];
 
       
       if(MERCHANT_PRIVATE_KEY=='' || MERCHANT_PUBLIC_KEY=='' || BASE_URL==''){
          echo "<h2>Something wrong, Please enter valid config on inc/config.php</h2>";
          exit;
       }
 
       $data = $requestData;
 
       $url = BASE_URL.'/withdrawal-request-list';
 
       $response = API::callAPI('POST', $url, $data,$headers);
        
       if($response['success']==1){
          return $response;
       }else{
          echo '<h2>Something wrong while calling API -- Error- '.$response['message'].'</h2>';
          exit;
       }
       
    }
}
?>


  

   

  