<?php
    include 'config.inc.php';

    function generateToken() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => VISA_URL_SECURITY,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
            "Accept: */*",
            'Authorization: '.'Basic '.base64_encode(VISA_USER.":".VISA_PWD)
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function generateSesion($amount, $token, $maxAmount) {
        $session = array(
            'amount' => $amount,
            'antifraud' => array(
                'clientIp' => $_SERVER['REMOTE_ADDR'],
                'merchantDefineData' => array(
                    // Datos de ejemplo
                    // Código de comercio
                    'MDD1' => VISA_MERCHANT_ID,
                    // Nombre del comercio
                    'MDD2' => "Integraciones VisaNet",
                    // Producto
                    'MDD3' => 'web',
                    // Adicionalmente, agregar los siguientes MDD
                    // Email del donante
                    'MDD4' => 'integraciones.visanet@necomplus.com',
                    // Teléfono del donante
                    'MDD31' => '987654321',
                    // Código o ID del donante
                    'MDD31' => '87654321',
                    // Tipo de documento del donante
                    'MDD33' => 'DNI',
                    // Número de documento del donante
                    'MDD34' => '87654321',
                    // Teléfono ha sido confirmado (SÍ/NO)
                    'MDD37' => 'NO',
                    // Email ha sido confirmado (SÍ/NO)
                    'MDD70' => 'NO'                    
                ),
            ),
            'channel' => 'web',
            'recurrenceMaxAmount' => $maxAmount
        );
        $json = json_encode($session);
        $response = json_decode(postRequest(VISA_URL_SESSION, $json, $token));
        return $response->sessionKey;
    }

    function generateAuthorization($amount, $purchaseNumber, $transactionToken, $token, $maxAmount, $frecuencia) {
        $data = array(
            'antifraud' => null,
            'captureType' => 'manual',
            'channel' => 'web',
            'countable' => true,
            'order' => array(
                'amount' => $amount,
                'currency' => 'PEN',
                'purchaseNumber' => $purchaseNumber,
                'tokenId' => $transactionToken,
                'productId' => "00001",
                'externalTransactionId' => "NCP-PRB"
            ),
            'recurrence' => array(
                'amount' => $amount,
                'beneficiaryId' => $purchaseNumber,
                'maxAmount' => $maxAmount,
                'frequency' => $frecuencia,
                'type' => "FIXED"
            ),
            'cardHolder' => array(
                'documentType' => 0,
                'documentNumber' => "87654321"
            )
        );
        $json = json_encode($data);
        $session = json_decode(postRequest(VISA_URL_AUTHORIZATION, $json, $token));
        // var_dump($session);
        return $session;
    }

    function postRequest($url, $postData, $token) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                'Authorization: '.$token,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => $postData
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function generatePurchaseNumber(){
        $archivo = "assets/purchaseNumber.txt"; 
        $purchaseNumber = 222;
        $fp = fopen($archivo,"r"); 
        $purchaseNumber = fgets($fp, 100);
        fclose($fp); 
        ++$purchaseNumber; 
        $fp = fopen($archivo,"w+"); 
        fwrite($fp, $purchaseNumber, 100); 
        fclose($fp);
        return $purchaseNumber;
    }