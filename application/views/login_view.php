<!DOCTYPE html>
<html>
<head>
	<title>Sira login</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/img/poa.png')?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="Easy Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel='stylesheet' type='text/css'>
</head>
<style type="text/css">
	.form-signin
	{
	    max-width: 330px;
	    padding: 15px;
	    margin: 0 auto;
	}
	.form-signin .form-signin-heading, .form-signin .checkbox
	{
	    margin-bottom: 10px;
	}

	.form-signin .form-control
	{
	    position: relative;
	    font-size: 16px;
	    height: auto;
	    padding: 10px;
	    -webkit-box-sizing: border-box;
	    -moz-box-sizing: border-box;
	    box-sizing: border-box;
	}
	.form-signin .form-control:focus
	{
	    z-index: 2;
	}

	.account-wall
	{
	    margin-top: 20px;
	    padding: 40px 0px 20px 0px;
	    background-color: #f7f7f7;
	    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	}
	.login-title
	{
	    color: #555;
	    font-size: 18px;
	    font-weight: 400;
	    display: block;
	}
	.profile-img
	{
	    width: 96px;
	    height: 96px;
	    margin: 0 auto 10px;
	    display: block;
	    -moz-border-radius: 50%;
	    -webkit-border-radius: 50%;
	    border-radius: 50%;
	}

	.new-account
	{
	    display: block;
	    margin-top: 10px;
	}
</style>
<body>
	<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Inicio de Sesion SIRA</h1>
            <div id="result"></div>
            <div class="account-wall">
                <img class="profile-img" src="<?php echo base_url('assets/img/profile-pictures.png')?>"
                    alt="">
                <div class="form-signin">
                <input type="text" class="form-control" placeholder="USUARIO" name="nomUsu" id="nomUsu" autofocus>
                <span class="help-block"></span>
                <br>
                <input type="password" class="form-control" placeholder="CONTRASEÑA" id="pasWord" name="pasWord" >
                <span class="help-block"></span>
                <br>
                <button class="btn btn-lg btn-primary btn-block" id="btnLogin">
                    Iniciar Sesion</button>
                </div>
            </div>
            <a href="<?php echo base_url('index.php/recuperacion')?>" class="text-center new-account">Olvido su Contraseña? </a>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/js/jquery-1.10.2.min.js')?>"></script>

<script type="text/javascript">
    
	function cerrarAlerta(){
	    $("#result").removeClass("alert alert-danger");
	    $('#result').text('');
	}

    $('#btnLogin').click(function () {
    	var nom = $('#nomUsu').val();
		var pass = $('#pasWord').val();
		$.ajax({
	        url : "<?php echo site_url('login/iniciar_sesion')?>",
	        type: "POST",
	        data: {nomUsu:nom, pasWord:pass},
	        dataType: "JSON",
	        success: function(data)
	        {
	            if(data.status) 
	            {
	                location.href = 'http://localhost:8888/Sira/index.php/home'; 
	            }
	            else
	            {
	                for (var i = 0; i < data.inputerror.length; i++) 
	                {
	                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
	                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
	                }
	            } 
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            $("#result").addClass("alert alert-danger");
	            $('#result').text('Nombre de usuario y/o contraseña incorrectos'); 
	            setTimeout("cerrarAlerta()",3000);
	 
	        }
    	});

	});	
</script>
</body>
</html>	