<?php
    include 'config/functions.php';
    $amount = $_POST['amount'];
    $frecuencia = $_POST['frequency'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $maxAmount = $amount * 1.10;
    $token = generateToken();
    $sesion = generateSesion($amount, $token, $amount*1.10);
    $purchaseNumber = generatePurchaseNumber();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Integraciones VisaNet</title>
</head>
<body>
    <form id="frmVisaNet" action="<?php echo END_POINT;?>finalizar.php?amount=<?php echo $amount;?>&purchaseNumber=<?php echo $purchaseNumber?>&frecuencia=<?php echo $frecuencia;?>&maxAmount=<?php echo $maxAmount?>">
        <script src="<?php echo VISA_URL_JS?>" 
            data-sessiontoken="<?php echo $sesion;?>"
            data-channel="web"
            data-merchantid="<?php echo VISA_MERCHANT_ID?>"
            data-merchantname="INTEGRACIONES VISANET"
            data-purchasenumber="<?php echo $purchaseNumber;?>"
            data-amount="<?php echo $amount; ?>"
            data-expirationminutes="5"
            data-timeouturl="<?php echo END_POINT;?>"
            data-cardholdername="<?php echo $name;?>"
            data-cardholderlastname="<?php echo $lastname;?>"
            data-cardholderemail="<?php echo $email;?>"
            data-recurrence="true"
            data-recurrencefrequency="<?php echo $frecuencia;?>"
            data-recurrencetype="FIXED"
            data-recurrencemaxamount="<?php echo $maxAmount?>"
            data-recurrenceamount="<?php echo $amount;?>"
        ></script>
    </form>
</body>
</html>