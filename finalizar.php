<?php
    include 'config/functions.php';
    $transactionToken = $_POST["transactionToken"];
    $email = $_POST["customerEmail"];
    $amount = $_GET["amount"];
    $purchaseNumber = $_GET["purchaseNumber"]; 
    $maxAmount = $_GET["maxAmount"];
    $frecuencia = $_GET["frecuencia"];

    $token = generateToken();

    $data = generateAuthorization($amount, $purchaseNumber, $transactionToken, $token, $maxAmount, $frecuencia);
	// echo $data;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Respuesta de pago</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

    <br>

    <div class="container">
        <?php 
            if (isset($data->dataMap)) {
                if ($data->dataMap->ACTION_CODE == "000") {
                    $c = preg_split('//', $data->dataMap->TRANSACTION_DATE, -1, PREG_SPLIT_NO_EMPTY);
                    ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $data->dataMap->ACTION_DESCRIPTION;?>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <b>Tarjeta: </b> <?php echo $data->dataMap->CARD." (".$data->dataMap->BRAND.")"; ?>
                            </div>
                        </div>
                    <?php
                }

                if ($data->dataMap->RECURRENCE_SRV_CODE == "000") {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $data->dataMap->RECURRENCE_SRV_MESSAGE;?>
                    </div>
                <?php
                }
            } else {
                $c = preg_split('//', $data->data->TRANSACTION_DATE, -1, PREG_SPLIT_NO_EMPTY);
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $data->data->ACTION_DESCRIPTION;?>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        <?php 
                            if ($data->data->RECURRENCE_SRV_CODE != "000") {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $data->data->RECURRENCE_SRV_MESSAGE;?>
                        </div>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                <?php
            }
        ?>
    </div>
    
</body>
</html>