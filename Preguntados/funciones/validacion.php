<?php

function validarRegistracion(array $datos)
{
	$errores = [];

	if(isset($datos['nombre']) == '')
	{
		$errores['nombre'] = 'Debe ingresar un nombre';
	}

	if(isset($datos['email']) == '')
	{
		$errores['email'] = 'Debe ingresar un email';
	}
	elseif(!filter_var($datos['email'], FILTER_VALIDATE_EMAIL))
	{
		$errores['email'] = 'Debe ingresar un email válido';
	}


	return $errores;
}

function checkearUsuario()
{
	return isset($_SESSION['user']);
}
