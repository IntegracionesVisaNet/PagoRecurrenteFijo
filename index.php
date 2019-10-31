<?php
    include 'config/functions.php';
?>    
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Integraciones VisaNet</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

    <br>

    <div class="container">
        <h1 class="text-center">Pago Recurrente Fijo</h1>
        <hr>
        <form action="<?php echo END_POINT;?>boton.php" method="POST">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control" value="Integraciones">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="lastname">Apellido</label>
                        <input type="text" name="lastname" id="lastname" class="form-control" value="VisaNet">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="amount">Importe</label>
                        <input type="text" name="amount" id="amount" class="form-control" value="1">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Frecuencia</label>
                        <select class="form-control" name="frequency">
                            <option value="MONTHLY" selected>Mensual</option>
                            <option value="QUARTERLY">Trimestral</option>
                            <option value="BIANNUAL">Semestral</option>
                            <option value="ANNUAL">Anual</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" value="integraciones.visanet@necomplus.com">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <!-- <br> -->
                    <button type="submit" class="btn btn-primary">Generar</button>
                </div>
            </div>
        </form>
    </div>
    
</body>
<script src="assets/js/script.js"></script>
</html>