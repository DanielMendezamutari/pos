/*Author: Ing. Ruben D. Chirinos R. Tlf: +58 0414-7225970, email: elsaiya@gmail.com


/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/
$('document').ready(function() {
						   
	$("#formlogin").validate({
          rules:
	     {
			usuario: { required: true },
			password: { required: true },
	     },
          messages:
	     {
		    usuario:{ required: "Ingrese Usuario de Acceso" },
			password:{ required: "Ingrese Clave de Acceso" },
          },
	     submitHandler: function(form) {
                     		
		var data = $("#formlogin").serialize();
			
		$.ajax({
		type : 'POST',
		url  : 'index.php',
		async : false,
		data : data,
		beforeSend: function()
		{	
			$("#login").fadeOut();
			$("#btn-login").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
		          {						
			     if(data==1){ 
							 
			$("#login").fadeIn(1000, function(){ 
		
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000 });
		     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
			    
				     });
		   
                    } else if(data==2){
								 
			$("#login").fadeIn(1000, function(){
		
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL USUARIO INGRESADO NO FUE ENCONTRADO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000 });
		$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
			 
			          }); 
		   
			     } else if(data==3){
								 
			$("#login").fadeIn(1000, function(){
		
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA SUCURSAL A LA QUE DESEA ACCEDER SE ENCUENTRA ACTUALMENTE INACTIVA, DEBE DE COMUNICARSE CON EL ADMINISTRADOR DE SUCURSALES...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000 });
		$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
			 
			          }); 
		   
			    } else if(data==4){

			$("#login").fadeIn(1000, function(){
		
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE USUARIO SE ENCUENTRA ACTUALMENTE INACTIVO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000 });
		$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
			 
			          }); 
		   
			    } else if(data==5){
								 
			$("#login").fadeIn(1000, function(){
		
	     var n = noty({
          text: "<span class='fa fa-warning'></span> EL PASSWORD INGRESADO NO FUE ENCONTRADO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000 });
		$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
			 
			          }); 
			
			     } else {
								
          $("#login").fadeIn(1000, function(){
	     $("#formlogin")[0].reset();
		setTimeout(' window.location.href = "panel.php"; ',100);
		$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 
				          });  
					}
			     }
		     });
		    return false;
		}
	     /* login submit */
     }); 
});
/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/


/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/
$('document').ready(function()
{ 				   
	$("#lockscreen").validate({
          rules:
	     {
			usuario: { required: true },
			password: { required: true },
	     },
          messages:
	     {
		     usuario:{ required: "Ingrese Usuario de Acceso" },
			password:{ required: "Ingrese Clave de Acceso" },
          },
	     submitHandler: function(form) {
                     		
		var data = $("#lockscreen").serialize();
			
		$.ajax({
		type : 'POST',
		url  : 'lockscreen.php',
		async : false,
		data : data,
		beforeSend: function()
		{	
			$("#login").fadeOut();
			$("#btn-login").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(response)
		          {						
			     if(response==1){ 
							 
			$("#login").fadeIn(1000, function(){ 
		
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000 });
		$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
			    
				     });
		   
                    } else if(response==2){
								 
			$("#login").fadeIn(1000, function(){
		
		var n = noty({
          text: "<span class='fa fa-warning'></span> LOS DATOS INGRESADOS NO EXISTEN, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000 });
		$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
			 
			          });
		   
			     } else if(response==3){
								 
			$("#login").fadeIn(1000, function(){
		
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA SUCURSAL A LA QUE DESEA ACCEDER SE ENCUENTRA ACTUALMENTE INACTIVA, DEBE DE COMUNICARSE CON EL ADMINISTRADOR DE SUCURSALES...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000 });
		$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
			 
			          }); 
		   
			     } else if(response==4){
								 
			$("#login").fadeIn(1000, function(){
		
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE USUARIO SE ENCUENTRA ACTUALMENTE INACTIVO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000 });
		$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
			 
			          }); 
		   
			     } else if(data==5){
								 
			$("#login").fadeIn(1000, function(){
		
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL PASSWORD INGRESADO NO FUE ENCONTRADO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000 });
		$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
			 
			          }); 
			
			     } else {
								  
			$("#login").fadeIn(1000, function(){
			
		$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
		setTimeout(' window.location.href = "panel.php"; ',500);
				 
				          });  
					}
			     }
		     });
			return false;
	     }
	     /* login submit */
     }); 
});
/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/



/* FUNCION JQUERY PARA RECUPERAR CONTRASE—A DE USUARIOS */	 
$('document').ready(function()
{ 
     /* validation */
	$("#formrecover").validate({
          rules:
	     {
			email: { required: true,  email: true  },
	     },
          messages:
 	     {
			email:{ required: "Ingrese su Correo Electronico", email: "Ingrese un Correo Electronico Valido" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#formrecover").serialize();
		
		$.ajax({
		type : 'POST',
		url  : 'index.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#recover").fadeOut();
			$("#btn-recuperar").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#recover").fadeIn(1000, function(){ 
	
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000, });
	     $("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Password');
		    
			          });																			
				}
				else if(data==2) {
							
			$("#recover").fadeIn(1000, function(){ 
	
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL CORREO INGRESADO NO FUE ENCONTRADO ACTUALMENTE...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000, });
	     $("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Password');
		    
			          });
				}
				else if(data==3) {
							
			$("#recover").fadeIn(1000, function(){ 
	
		var n = noty({
          text: "<span class='fa fa-warning'></span> SU NUEVA CLAVE DE ACCESO NO PUDO SER ENVIADA A SU CORREO, INTENTE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000, });
	     $("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Password');
		    
			          });
				} else {
								
			$("#recover").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> &nbsp; '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		$("#formrecover")[0].reset();
		$("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Password');	
			                                
						});
					}
				}
			});
			return false;
		}
	   /* form submit */
     }); 
});
/*  FIN DE FUNCION PARA RECUPERAR CONTRASE—A DE USUARIOS */
 
 
/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONTRASE—A */	 
$('document').ready(function()
{ 						
     /* validation */
	$("#updatepassword").validate({
          rules:
	     {
			usuario: {required: true },
			password: {required: true, minlength: 8},  
               password2:   {required: true, minlength: 8, equalTo: "#txtPassword"}, 
	     },
          messages:
	     {
               usuario:{ required: "Ingrese Usuario de Acceso" },
               password:{ required: "Ingrese su Nuevo Password", minlength: "Ingrese 8 caracteres como minimo" },
		     password2:{ required: "Repita su Nuevo Password", minlength: "Ingrese 8 caracteres como minimo", equalTo: "Este Password no coincide" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#updatepassword").serialize();
		
		$.ajax({
		type : 'POST',
		url  : 'password.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#error").fadeOut();
			$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#error").fadeIn(1000, function(){ 
	
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000, });
	     $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
		    
			          });									
				}
				else if(data==2){
							
			$("#error").fadeIn(1000, function(){ 
	
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO PUEDE USAR LA CLAVE ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000, });
	     $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
		    
			          });
				} else {
								
			$("#error").fadeIn(1000, function(){
								
		$("#updatepassword")[0].reset();
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');	
		setTimeout(' window.location.href = "logout"; ',5000);
				 
						});									
				     }
				}
			});
			return false;
		}
	   /* form submit */
     }); 
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONTRASE—A */


















/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONFIGURACION GENERAL */	 
$('document').ready(function()
{ 
     /* validation */
	$("#configuracion").validate({
          rules:
	     {
			documsucursal: { required: false },
			cuit: { required: true, digits: false },
			nomsucursal: { required: true },
			tlfsucursal: { required: true,  digits : false },
			correosucursal: { required: true,  email : true },
			id_provincia: { required: false },
			id_departamento: { required: false },
			direcsucursal: { required: true },
			documencargado: { required: false },
			dniencargado: { required: true, number: true },
			nomencargado: { required: true, lettersonly: true },
			tlfencargado: { required: true,  digits : false },
			codmoneda: { required: false },
	     },
          messages:
	     {
               documsucursal:{ required: "Seleccione Tipo de Documento" },
               cuit:{ required: "Ingrese N&deg; de Empresa", digits: "Ingrese solo digitos para N&deg; de Empresa" },
			nomsucursal:{ required: "Ingrese Nombre de Empresa" },
			tlfsucursal: { required: "Ingrese N&deg; de Tel&eacute;fono de Empresa", digits: "Ingrese solo digitos para Tel&eacute;fono" },
			correosucursal: { required: "Ingrese Email de Empresa", email: "Ingrese un Correo v&aacute;lido" },
			direcsucursal: { required: "Ingrese Direcci&oacute;n de Empresa" },
			id_provincia:{ required: "Seleccione Provincia" },
			id_departamento:{ required: "Seleccione Departamento" },
			documencargado:{ required: "Seleccione Tipo de Documento" },
               dniencargado: { required: "Ingrese N&deg; de Documento de Gerente", number: "Ingrese solo numeros" },
			nomencargado:{ required: "Ingrese Nombre de Gerente", lettersonly: "Ingrese solo letras para Nombres" },
			tlfencargado: { required: "Ingrese N&deg; de Tel&eacute;fono de Gerente", digits: "Ingrese solo digitos para Tel&eacute;fono" },
			codmoneda:{ required: "Seleccione Tipo de Moneda" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#configuracion").serialize();
		var formData = new FormData($("#configuracion")[0]);
		
		$.ajax({
		type : 'POST',
		url  : 'configuracion.php',
	     async : false,
		data : formData,
		//necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
		beforeSend: function()
		{	
			$("#error").fadeOut();
			$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#error").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'error',
          timeout: 5000, });
		$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
		 
		                }); 
				} else { 
						     
			$("#error").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'success',
          timeout: 5000, });
		$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');	
				                                
						});
					}
				}
			});
		     return false;
	     }
	     /* form submit */	   
     }); 
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONFIGURACION GENERAL */
 
















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE USUARIOS */	 
$('document').ready(function()
{ 
    jQuery.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-zA-ZÒ—·ÈÌÛ˙¡…Õ”⁄,. ]+$/i.test(value);
    });

    /* validation */
	$("#saveuser").validate({
          rules:
	     {
			dni: { required: true,  digits : false, minlength: 7 },
			nombres: { required: true, lettersonly: true },
			sexo: { required: true },
			direccion: { required: true },
			telefono: { required: true },
			email: { required: true, email: true },
			usuario: { required: true },
			password: {required: true, minlength: 8},  
               password2:   {required: true, minlength: 8, equalTo: "#password"}, 
			nivel: { required: true },
			status: { required: true },
			comision: { required: true,  number : true },
			codsucursal: { required: true },
	     },
          messages:
	     {
               dni:{ required: "Ingrese N&deg; de Documento", digits: "Ingrese solo d&iacute;gitos para N&deg; de Documento", minlength: "Ingrese 7 d&iacute;gitos como m&iacute;nimo" },
			nombres:{ required: "Ingrese Nombre de Usuario", lettersonly: "Ingrese solo letras para Nombres" },
               sexo:{ required: "Seleccione Sexo de Usuario" },
               direccion:{ required: "Ingrese Direcci&oacute;n Domiciliaria" },
               telefono:{ required: "Ingrese N&deg; de Tel&eacute;fono" },
			email:{ required: "Ingrese Email de Usuario", email: "Ingrese un Email V&aacute;lido" },
			usuario:{ required: "Ingrese Usuario de Acceso" },
			password:{ required: "Ingrese Password de Acceso", minlength: "Ingrese 8 caracteres como m&iacute;nimo" },
		     password2:{ required: "Repita Password de Acceso", minlength: "Ingrese 8 caracteres como m&iacute;nimo", equalTo: "Este Password no coincide" },
			nivel:{ required: "Seleccione Nivel de Acceso" },
			status:{ required: "Seleccione Status de Acceso" },
			comision:{ required: "Ingrese Comisi&oacute;n por Ventas", number: "Ingrese solo numeros con dos decimales" },
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#saveuser").serialize();
		var formData = new FormData($("#saveuser")[0]);
		
		$.ajax({
		type : 'POST',
		url  : 'usuarios.php',
	     async : false,
		data : formData,
		//necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> USTED NO PUEDE ASIGNARSE UNA SUCURSAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}     
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> DEBE DE ASIGNARLE UNA SUCURSAL A ESTE USUARIO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}  
				else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE UN USUARIO CON ESTE N&deg; DE DNI, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else if(data==5){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE CORREO ELECTR&Oacute;NICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
					});
				}
				else if(data==6){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE USUARIO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
          $('#myModalUser').modal('hide');
		$("#saveuser")[0].reset();
          $("#proceso").val("save");	
		$('#codigo').val("");
		$('#usuarios').html("");
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
		$('#usuarios').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
		setTimeout(function() {
		 	$('#usuarios').load("consultas?CargaUsuarios=si");
		}, 200);

						});
					}
				}
			});
			return false;
		}
	    /* form submit */	 
     });   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE USUARIOS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PROVINCIAS */	 
$('document').ready(function()
{ 
     /* validation */
	$("#saveprovincias").validate({
          rules:
	     {
			provincia: { required: true },
	     },
          messages:
	     {
               provincia:{ required: "Ingrese Nombre de Provincia" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#saveprovincias").serialize();
		
		$.ajax({
		type : 'POST',
		url  : 'provincias.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE ESTE NOMBRE DE PROVINCIA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		$("#saveprovincias")[0].reset();
          $("#proceso").val("save");
		$('#id_provincia').val("");		
		$('#provincias').html("");
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
		$('#provincias').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
		setTimeout(function() {
		 	$('#provincias').load("consultas?CargaProvincias=si");
		}, 200);
										
						});
					}
				}
			});
			return false;
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PROVINCIAS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE DEPARTAMENTOS */	 
$('document').ready(function()
{ 
     /* validation */
	$("#savedepartamentos").validate({
          rules:
	     {
			departamento: { required: true },
			id_provincia: { required: true },
	     },
          messages:
	      {
               departamento:{ required: "Ingrese Nombre de Departamento"},
               id_provincia:{ required: "Seleccione Provincia para Departamento"},
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savedepartamentos").serialize();
		
		$.ajax({
		type : 'POST',
		url  : 'departamentos.php',
	    async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
			     {						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE ESTE DEPARTAMENTO PARA LA PROVINCIA SELECCIONADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		$("#savedepartamentos")[0].reset();
          $("#proceso").val("save");	
		$('#id_departamento').val("");
		$('#departamentos').html("");
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
		$('#departamentos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
		setTimeout(function() {
		 	$('#departamentos').load("consultas?CargaDepartamentos=si");
		}, 200);
										
						});
					}
				}
			});
			return false;
		}
	     /* form submit */	
     });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE DEPARTAMENTOS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TIPOS DE DOCUMENTOS */	 
$('document').ready(function()
{ 
     /* validation */
	$("#savedocumentos").validate({
          rules:
	     {
			documento: { required: true },
			descripcion: { required: true },
	     },
          messages:
	     {
			documento:{ required: "Ingrese Nombre de Documento" },
               descripcion:{ required: "Ingrese Descripci&oacute;n de Documento" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savedocumentos").serialize();
		
		$.ajax({
		type : 'POST',
		url  : 'documentos.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE NOMBRE DE DOCUMENTO YA EXISTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		$("#savedocumentos")[0].reset();
          $("#proceso").val("save");
		$('#coddocumento').val("");
		$('#documentos').html("");	
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
		$('#documentos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
          setTimeout(function() {
          $('#documentos').load("consultas?CargaDocumentos=si");
          }, 200);				
						});
					}
				}
			});
			return false;
		}
	    /* form submit */	   
     }); 
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE TIPOS DE DOCUMENTOS */

















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TIPOS DE MONEDA */	 
$('document').ready(function()
{ 
     /* validation */
     $("#savemonedas").validate({
          rules:
	     {
			moneda: { required: true },
			siglas: { required: true },
			simbolo: { required: true },
	     },
          messages:
	     {
			moneda:{ required: "Ingrese Nombre de Moneda" },
               siglas:{ required: "Ingrese Siglas de Moneda" },
               simbolo:{ required: "Ingrese Simbolo de Moneda" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savemonedas").serialize();
		
		$.ajax({
		type : 'POST',
		url  : 'monedas.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE NOMBRE DE MONEDA YA EXISTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		$("#savemonedas")[0].reset();
          $("#proceso").val("save");
		$('#codmoneda').val("");
		$('#monedas').html("");	
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
		$('#monedas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
          setTimeout(function() {
          $('#monedas').load("consultas?CargaMonedas=si");
          }, 200);
										
						});
					}
				}
			});
			return false;
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE TIPOS DE MONEDA */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TIPOS DE CAMBIO */	 
$('document').ready(function()
{ 
     /* validation */
	$("#savecambio").validate({
          rules:
	     {
			descripcioncambio: { required: true },
			montocambio:{ required: true, number : true},
			montocambio: { required: true },
			codmoneda: { required: true },
			fechacambio: { required: true },
			codsucursal: { required: true },
	     },
          messages:
	     {
			descripcioncambio:{ required: "Ingrese Descripci&oacute;n de Cambio" },
			montocambio:{ required: "Ingrese Monto de Cambio", number: "Ingrese solo digitos con 2 decimales" },
			codmoneda:{ required: "Seleccione Tipo de Moneda" },
			fechacambio:{ required: "Ingrese Fecha de Registro" },
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savecambio").serialize();
          var TipoUsuario = $('#tipousuario').val();
          var CodSucursal = $('#codsucursal').val();
          var Proceso = $('#proceso').val();
		var montocambio = $('#montocambio').val();

          if (montocambio==0.00 || montocambio==0) {
       
		    $("#montocambio").focus();
		    $('#montocambio').css('border-color','#ff7676');
		    swal("Oops", "POR FAVOR INGRESE UN MONTO DE CAMBIO VALIDO!", "error");

          } else {

		$.ajax({
		type : 'POST',
		url  : 'cambios.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE UN TIPO DE CAMBIO EN LA FECHA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		if(Proceso == 'update'){
		$('body').removeClass('modal-open');
		$('#myModalTipoCambio').modal('hide');
	     }
		$("#savecambio")[0].reset();
          $("#proceso").val("save");
		$('#codcambio').val(""); 
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
          if(TipoUsuario == '1'){
          	$('#codsucursal').val(CodSucursal);
               $("#BotonBusqueda").trigger("click");
          } else {
			$('#cambios').html("");		
			$('#cambios').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
	          setTimeout(function() {
	               $('#cambios').load("consultas?CargaCambios=si");
	          }, 200);
          }					
							});
						}
					}
				});
				return false;
			}
		}
	     /* form submit */	
     });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE TIPOS DE CAMBIO */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE MEDIOS DE PAGOS */	 
$('document').ready(function()
{ 
    /* validation */
	$("#savemedio").validate({
          rules:
	     {
			mediopago: { required: true },
			codsucursal: { required: true },
	     },
          messages:
	     {
			mediopago:{ required: "Ingrese Nombre Forma de Pago" },
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savemedio").serialize();
          var TipoUsuario = $('#tipousuario').val();
          var CodSucursal = $('#codsucursal').val();
          var Proceso = $('#proceso').val();
		
		$.ajax({
		type : 'POST',
		url  : 'medios.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE ESTE MEDIO DE PAGO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}  
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		if(Proceso == 'update'){
		$('body').removeClass('modal-open');
		$('#myModalMedioPago').modal('hide');
	     }
		$("#savemedio")[0].reset();
          $("#proceso").val("save");
		$('#codmediopago').val(""); 
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
          if(TipoUsuario == '1'){
          	$('#codsucursal').val(CodSucursal);
               $("#BotonBusqueda").trigger("click");
          } else {
			$('#mediospagos').html("");		
			$('#mediospagos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
	          setTimeout(function() {
	               $('#mediospagos').load("consultas?CargaMediosPagos=si");
	          }, 200);
          }				
						});
				    }
				}
		    });
		    return false;
		}
	     /* form submit */	
     });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE MEDIOS DE PAGOS */



















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE IMPUESTOS */	 
$('document').ready(function()
{ 
    /* validation */
	$("#saveimpuesto").validate({
          rules:
	     {
			nomimpuesto: { required: true },
			valorimpuesto: { required: true, number : true},
			statusimpuesto: { required: true },
			fechaimpuesto: { required: true },
			codsucursal: { required: true },
	     },
          messages:
	     {
			nomimpuesto:{ required: "Ingrese Nombre de Impuesto" },
			valorimpuesto:{ required: "Ingrese Valor de Impuesto", number: "Ingrese solo digitos con 2 decimales" },
			statusimpuesto: { required: "Seleccione Status de Impuesto" },
			fechaimpuesto:{ required: "Ingrese Fecha de Registro" },
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#saveimpuesto").serialize();
          var TipoUsuario = $('#tipousuario').val();
          var CodSucursal = $('#codsucursal').val();
          var Proceso = $('#proceso').val();
		
		$.ajax({
		type : 'POST',
		url  : 'impuestos.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
			     }   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE UN IMPUESTO ACTIVO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}  
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE UN IMPUESTO CON ESTE NOMBRE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		if(Proceso == 'update'){
		$('body').removeClass('modal-open');
		$('#myModalImpuesto').modal('hide');
	     }
		$("#saveimpuesto")[0].reset();
          $("#proceso").val("save");
		$('#codimpuesto').val(""); 
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
          if(TipoUsuario == '1'){
          	$('#codsucursal').val(CodSucursal);
               $("#BotonBusqueda").trigger("click");
          } else {
			$('#impuestos').html("");		
			$('#impuestos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
	          setTimeout(function() {
	               $('#impuestos').load("consultas?CargaImpuestos=si");
	          }, 200);
          }						
						});
				    }
				}
		    });
		    return false;
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE IMPUESTOS */












/* FUNCION JQUERY PARA VALIDAR REGISTRO DE BANCOS */	 
$('document').ready(function()
{ 
    /* validation */
	$("#savebanco").validate({
          rules:
	     {
			nombanco: { required: true },
			codsucursal: { required: true },
	     },
          messages:
	     {
			nombanco:{ required: "Ingrese Nombre de Banco" },
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savebanco").serialize();
          var TipoUsuario = $('#tipousuario').val();
          var CodSucursal = $('#codsucursal').val();
          var Proceso = $('#proceso').val();
		
		$.ajax({
		type : 'POST',
		url  : 'bancos.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE ESTE NOMBRE DE BANCO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}  
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		if(Proceso == 'update'){
		$('body').removeClass('modal-open');
		$('#myModalBanco').modal('hide');
	     }
		$("#savebanco")[0].reset();
          $("#proceso").val("save");
		$('#codbanco').val(""); 
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
          if(TipoUsuario == '1'){
          	$('#codsucursal').val(CodSucursal);
               $("#BotonBusqueda").trigger("click");
          } else {
			$('#bancos').html("");		
			$('#bancos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
	          setTimeout(function() {
	               $('#bancos').load("consultas?CargaBancos=si");
	          }, 200);
          }				
						});
				     }
				}
		    });
		    return false;
		}
	     /* form submit */	
     });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE BANCOS */














/* FUNCION JQUERY PARA VALIDAR REGISTRO DE SUCURSALES */	 
$('document').ready(function()
{ 
    jQuery.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-zA-ZÒ—·ÈÌÛ˙¡…Õ”⁄,. ]+$/i.test(value);
    });

    /* validation */
	$("#savesucursal").validate({
          rules:
	     {
			documsucursal: { required: true },
			cuitsucursal: { required: true, digits: false },
			nomsucursal: { required: true },
			id_provincia: { required: false },
			id_departamento: { required: false },
			direcsucursal: { required: true },
			correosucursal: { required: true,  email : true },
			tlfsucursal: { required: true,  digits : false },
               inicioticket:   {required: true, digits : false },
               iniciofactura:   {required: true, digits : false },
               inicioguia:   {required: true, digits : false },
               inicionotaventa:   {required: true, digits : false },
               inicionotacredito:   {required: true, digits : false },
			nroactividadsucursal: { required: true },
			fechaautorsucursal: { required: true },
			llevacontabilidad: { required: true },
			documencargado: { required: true },
			dniencargado: { required: true, number: true },
			nomencargado: { required: true, lettersonly: true },
			tlfencargado: { required: false,  digits : false },
			descsucursal: { required: true,  number : true },
			porcentaje: { required: true,  number : true },
			codmoneda: { required: true },
			codmoneda2: { required: false },
			membrete: { required: true },
	     },
          messages:
	     {
            
			documsucursal:{ required: "Seleccione Tipo de Documento" },
               cuitsucursal:{ required: "Ingrese N&deg; de Registro", digits: "Ingrese solo digitos para N&deg; de Cuit/Ruc" },
			nomsucursal:{ required: "Ingrese Nombre de Sucursal" },
			id_provincia:{ required: "Seleccione Provincia" },
			id_departamento:{ required: "Seleccione Departamento" },
			direcsucursal: { required: "Ingrese Direcci&oacute;n de Sucursal" },
			correosucursal: { required: "Ingrese Correo Electronocio", email: "Ingrese un Correo v&aacute;lido" },
			tlfsucursal: { required: "Ingrese N&deg; de Tel&eacute;fono", digits: "Ingrese solo digitos para Tel&eacute;fono" },
			inicioticket:{ required: "Ingrese N&deg; Inicio de Boleta", digits: "Ingrese solo digitos para N&deg; Inicio de Boleta" },
			iniciofactura:{ required: "Ingrese N&deg; Inicio de Factura", digits: "Ingrese solo digitos para N&deg; Inicio de Factura" },
			inicioguia:{ required: "Ingrese N&deg; Inicio de Guia", digits: "Ingrese solo digitos para N&deg; Inicio de Guia" },
			inicionotaventa:{ required: "Ingrese N&deg; Inicio Nota Venta", digits: "Ingrese solo digitos para N&deg; Inicio de Nota Venta" },
			inicionotacredito:{ required: "Ingrese N&deg; Inicio Nota Credito", digits: "Ingrese solo digitos para N&deg; Inicio Nota Credito" },
			nroactividadsucursal:{ required: "Ingrese N&deg; de Actividad", digits: "Ingrese solo digitos para N&deg; de Actividad" },
			fechaautorsucursal:{ required: "Ingrese Fecha de Autorizaci&oacute;n de Sucursal" },
			llevacontabilidad:{ required: "Seleccione si lleva Contabilidad" },
			documencargado:{ required: "Seleccione Tipo de Documento" },
			dniencargado: { required: "Ingrese N&deg; de Documento", number: "Ingrese solo numeros para N&deg de Documento" },
			nomencargado:{ required: "Ingrese Nombre de Encargado", lettersonly: "Ingrese solo letras para Nombres" },
			tlfencargado: { required: "Ingrese N&deg; de Tel&eacute;fono", digits: "Ingrese solo digitos para Tel&eacute;fono" },
			descsucursal:{ required: "Ingrese Descuento General en Ventas", number: "Ingrese solo numeros con dos decimales para Desc. General en Ventas" },
			porcentaje:{ required: "Ingrese Porcentaje Calculo Precio Venta", number: "Ingrese solo numeros con dos decimales para Porcentaje Precio en Ventas" },
			codmoneda:{ required: "Seleccione Moneda Nacional" },
			codmoneda2:{ required: "Seleccione Moneda para Cambio" },
			membrete:{ required: "Ingrese Informaci&oacute;n para Membrete" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savesucursal").serialize();
		var formData = new FormData($("#savesucursal")[0]);
		
		$.ajax({
		type : 'POST',
		url  : 'sucursales.php',
	     async : false,
		data : formData,
		//necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				} 
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE CORREO ELECTR&Oacute;NICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
					});
				}
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE UNA SUCURSAL CON ESTE N&deg; DE REGISTRO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
          $('#myModalSucursal').modal('hide');
		$("#savesucursal")[0].reset();
          $("#proceso").val("save");
		$('#codsucursal').val("");
		$('#id_departamento').html("<option value=''>-- SIN RESULTADOS --</option>");	
		$('#sucursales').html("");
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
		$('#sucursales').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
		setTimeout(function() {
		 	$('#sucursales').load("consultas?CargaSucursales=si");
		}, 200);
										
						});
					}
				}
			});
			return false;
		}
	     /* form submit */	   
     }); 
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE SUCURSALES */





















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE FAMILIAS */	 
$('document').ready(function()
{ 
     /* validation */
	$("#savefamilia").validate({
          rules:
	     {
			nomfamilia: { required: true },
			codsucursal: { required: true },
	     },
          messages:
	     {
               nomfamilia:{ required: "Ingrese Nombre de Familia" },
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savefamilia").serialize();
          var TipoUsuario = $('#tipousuario').val();
          var CodSucursal = $('#codsucursal').val();
          var Proceso = $('#proceso').val();
		
		$.ajax({
		type : 'POST',
		url  : 'familias.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE ESTE NOMBRE DE FAMILIA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		if(Proceso == 'update'){
		$('body').removeClass('modal-open');
		$('#myModalFamilia').modal('hide');
	     }
		$("#savefamilia")[0].reset();
          $("#proceso").val("save");
		$('#codfamilia').val(""); 
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
          if(TipoUsuario == '1'){
          	$('#codsucursal').val(CodSucursal);
               $("#BotonBusqueda").trigger("click");
          } else {
			$('#familias').html("");		
			$('#familias').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
	          setTimeout(function() {
	               $('#familias').load("consultas?CargaFamilias=si");
	          }, 200);
          }							
						});
					}
				}
			});
			return false;
		}
	     /* form submit */	 
     });   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE FAMILIAS */

















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE SUBFAMILIAS */	 
$('document').ready(function()
{ 
     /* validation */
	$("#savesubfamilia").validate({
          rules:
	     {
			nomsubfamilia: { required: true },
			codfamilia: { required: true },
			codsucursal: { required: true },
	     },
          messages:
	     {
               nomsubfamilia:{ required: "Ingrese Nombre de Subfamilia"},
               codfamilia:{ required: "Seleccione Familia para Subfamilia"},
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savesubfamilia").serialize();
          var TipoUsuario = $('#tipousuario').val();
          var CodSucursal = $('#codsucursal').val();
          var Proceso = $('#proceso').val();
		
		$.ajax({
		type : 'POST',
		url  : 'subfamilias.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
			     else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE ESTA SUBFAMILIA PARA LA FAMILIA SELECCIONADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		if(Proceso == 'update'){
		$('body').removeClass('modal-open');
		$('#myModalSubfamilia').modal('hide');
	     }
		$("#savesubfamilia")[0].reset();
          $("#proceso").val("save");
		$('#codsubfamilia').val(""); 
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
          if(TipoUsuario == '1'){
          	$('#codsucursal').val(CodSucursal);
               $("#BotonBusqueda").trigger("click");
          } else {
			$('#subfamilias').html("");		
			$('#subfamilias').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
	          setTimeout(function() {
	               $('#subfamilias').load("consultas?CargaSubfamilias=si");
	          }, 200);
          }	
						});
					}
				}
			});
			return false;
		}
	     /* form submit */	  
     });  
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE SUBFAMILIAS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE MARCAS */	 
$('document').ready(function()
{ 
     /* validation */
	$("#savemarca").validate({
          rules:
	     {
			nommarca: { required: true },
			codsucursal: { required: true },
	     },
          messages:
	     {
               nommarca:{ required: "Ingrese Nombre de Marca" },
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savemarca").serialize();
          var TipoUsuario = $('#tipousuario').val();
          var CodSucursal = $('#codsucursal').val();
          var Proceso = $('#proceso').val();
		
		$.ajax({
		type : 'POST',
		url  : 'marcas.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE ESTE NOMBRE DE MARCA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		if(Proceso == 'update'){
		$('body').removeClass('modal-open');
		$('#myModalMarca').modal('hide');
	     }
		$("#savemarca")[0].reset();
          $("#proceso").val("save");
		$('#codmarca').val(""); 
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
          if(TipoUsuario == '1'){
          	$('#codsucursal').val(CodSucursal);
               $("#BotonBusqueda").trigger("click");
          } else {
			$('#marcas').html("");		
			$('#marcas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
	          setTimeout(function() {
	               $('#marcas').load("consultas?CargaMarcas=si");
	          }, 200);
          }	
						});
					}
				}
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE MARCAS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE MODELOS */	 
$('document').ready(function()
{ 
     /* validation */
	$("#savemodelo").validate({
          rules:
	     {
			nommodelo: { required: true },
			codmarca: { required: true },
			codsucursal: { required: true },
	     },
          messages:
	     {
               nommodelo:{ required: "Ingrese Nombre de Modelo"},
               codmarca:{ required: "Seleccione Marca para Modelo"},
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savemodelo").serialize();
          var TipoUsuario = $('#tipousuario').val();
          var CodSucursal = $('#codsucursal').val();
          var Proceso = $('#proceso').val();
		
		$.ajax({
		type : 'POST',
		url  : 'modelos.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE ESTE MODELO PARA LA MARCA SELECCIONADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		if(Proceso == 'update'){
		$('body').removeClass('modal-open');
		$('#myModalModelo').modal('hide');
	     }
		$("#savemodelo")[0].reset();
          $("#proceso").val("save");
		$('#codmodelo').val(""); 
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
          if(TipoUsuario == '1'){
          	$('#codsucursal').val(CodSucursal);
               $("#BotonBusqueda").trigger("click");
          } else {
			$('#modelos').html("");		
			$('#modelos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
	          setTimeout(function() {
	               $('#modelos').load("consultas?CargaModelos=si");
	          }, 200);
          }							
						});
					}
				}
			});
			return false;
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE MODELOS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PRESENTACIONES */	 
$('document').ready(function()
{ 
     /* validation */
	$("#savepresentacion").validate({
          rules:
	     {
			nompresentacion: { required: true },
			codsucursal: { required: true },
	     },
          messages:
	     {
               nompresentacion:{ required: "Ingrese Nombre de Presentaci&oacute;n" },
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savepresentacion").serialize();
          var TipoUsuario = $('#tipousuario').val();
          var CodSucursal = $('#codsucursal').val();
          var Proceso = $('#proceso').val();
		
		$.ajax({
		type : 'POST',
		url  : 'presentaciones.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE ESTE NOMBRE DE PRESENTACI&Oacute;N, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		if(Proceso == 'update'){
		$('body').removeClass('modal-open');
		$('#myModalPresentacion').modal('hide');
	     }
		$("#savepresentacion")[0].reset();
          $("#proceso").val("save");
		$('#codpresentacion').val(""); 
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
          if(TipoUsuario == '1'){
          	$('#codsucursal').val(CodSucursal);
               $("#BotonBusqueda").trigger("click");
          } else {
			$('#presentaciones').html("");		
			$('#presentaciones').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
	          setTimeout(function() {
	               $('#presentaciones').load("consultas?CargaPresentaciones=si");
	          }, 200);
          }						
						});
					}
				}
			});
			return false;
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PRESENTACIONES */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE COLORES */	 
$('document').ready(function()
{ 
     /* validation */
	$("#savecolor").validate({
          rules:
	     {
			nomcolor: { required: true },
			codsucursal: { required: true },
	     },
          messages:
	     {
               nomcolor:{ required: "Ingrese Nombre de Color" },
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savecolor").serialize();
          var TipoUsuario = $('#tipousuario').val();
          var CodSucursal = $('#codsucursal').val();
          var Proceso = $('#proceso').val();
		
		$.ajax({
		type : 'POST',
		url  : 'colores.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE ESTE NOMBRE DE COLOR, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		if(Proceso == 'update'){
		$('body').removeClass('modal-open');
		$('#myModalColor').modal('hide');
	     }
		$("#savecolor")[0].reset();
          $("#proceso").val("save");
		$('#codcolor').val(""); 
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
          if(TipoUsuario == '1'){
          	$('#codsucursal').val(CodSucursal);
               $("#BotonBusqueda").trigger("click");
          } else {
			$('#colores').html("");		
			$('#colores').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
	          setTimeout(function() {
	               $('#colores').load("consultas?CargaColores=si");
	          }, 200);
          }						
						});
					}
				}
			});
			return false;
		}
	     /* form submit */	
     });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE COLORES */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE ORIGENES */	 
$('document').ready(function()
{ 
     /* validation */
	$("#saveorigen").validate({
          rules:
	     {
			nomorigen: { required: true },
			codsucursal: { required: true },
	     },
          messages:
	     {
               nomorigen:{ required: "Ingrese Nombre de Origen" },
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#saveorigen").serialize();
          var TipoUsuario = $('#tipousuario').val();
          var CodSucursal = $('#codsucursal').val();
          var Proceso = $('#proceso').val();
		
		$.ajax({
		type : 'POST',
		url  : 'origenes.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE ESTE NOMBRE DE ORIGEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		if(Proceso == 'update'){
		$('body').removeClass('modal-open');
		$('#myModalOrigen').modal('hide');
	     }
		$("#saveorigen")[0].reset();
          $("#proceso").val("save");
		$('#codorigen').val(""); 
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
          if(TipoUsuario == '1'){
          	$('#codsucursal').val(CodSucursal);
               $("#BotonBusqueda").trigger("click");
          } else {
			$('#origenes').html("");		
			$('#origenes').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
	          setTimeout(function() {
	               $('#origenes').load("consultas?CargaOrigenes=si");
	          }, 200);
          }							
						});
					}
				}
			});
			return false;
		}
	     /* form submit */	
     });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE ORIGENES */













/* FUNCION JQUERY PARA CARGA MASIVA DE CLIENTES */	 
$('document').ready(function()
{ 
     /* validation */
	$("#cargaclientes").validate({
          rules:
	     {
			sel_file: { required: false },
			codsucursal: { required: true },
	     },
          messages:
	     {
               sel_file:{ required: "Por favor Seleccione Archivo para Cargar" },
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#cargaclientes").serialize();
		var formData = new FormData($("#cargaclientes")[0]);
		var sel_file = $('#sel_file').val();

          if (sel_file == "") {
            
			swal("Oops", "POR FAVOR REALICE LA BUSQUEDA DEL ARCHIVO A CARGAR!", "error");
               return false;

          } else {
			
		$.ajax({
		type : 'POST',
		url  : 'clientes.php',
		async : false,
		data : formData,
		//necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
		beforeSend: function()
		{	
			$("#carga").fadeOut();
			$("#btn-cargar").html('<i class="fa fa-spin fa-spinner"></i> Cargando ....');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#carga").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar');
									
					});
				}  
				else if(data==2){
								
			$("#carga").fadeIn(1000, function(){
								
		var n = noty({
          text: "<span class='fa fa-warning'></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE CLIENTES, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar');
																			
					});
				}
				else{
									
			$("#carga").fadeIn(1000, function(){
									
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
          $('#myModalCargaMasiva').modal('hide');
		$("#cargaclientes")[0].reset();
		$('#divcliente').html("");
		$("#BotonBusqueda").trigger("click");
		$("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar');
		
						});
					}
				}
			});
			return false;
			}
		}
	   /* form submit */
    }); 
});
/*  FIN DE FUNCION PARA CARGA MASIVA DE CLIENTES */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CLIENTES */	  
$('document').ready(function()
{ 
    jQuery.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-zA-ZÒ—·ÈÌÛ˙¡…Õ”⁄,. ]+$/i.test(value);
    });

     /* validation */
	$("#savecliente").validate({
          rules:
	     {
			tipocliente: { required: true },
			documcliente: { required: false },
			dnicliente: { required: true,  digits : false, minlength: 7 },
			nomcliente: { required: true, lettersonly: true },
			razoncliente: { required: true },
			girocliente: { required: true },
			tlfcliente: { required: false },
			id_provincia: { required: false },
			id_departamento: { required: false },
			direccliente: { required: true },
			emailcliente: { required: false, email: true },
			limitecredito: { required: true, number : true},
			codsucursal: { required: true },
	     },
          messages:
	     {
			tipocliente: { required: "Seleccione Tipo de Cliente" },
			documcliente:{ required: "Seleccione Tipo de Documento" },
			dnicliente:{ required: "Ingrese N&deg; de Documento", digits: "Ingrese solo d&iacute;gitos", minlength: "Ingrese 7 d&iacute;gitos como m&iacute;nimo" },
               nomcliente:{ required: "Ingrese Nombre de Cliente", lettersonly: "Ingrese solo letras para Nombres" },
			razoncliente:{ required: "Ingrese Raz&oacute;n Social" },
			girocliente:{ required: "Ingrese Giro de Cliente" },
			tlfcliente: { required: "Ingrese N&deg; de Tel&eacute;fono" },
			id_provincia:{ required: "Seleccione Provincia" },
			id_departamento: { required: "Seleccione Departamento" },
			direccliente: { required: "Ingrese Direcci&oacute;n Domiciliaria" },
			emailcliente:{ required: "Ingrese Email de Cliente", email: "Ingrese un Email V&aacute;lido" },
			limitecredito:{ required: "Ingrese Limite de Cr&eacute;dito", number: "Ingrese solo digitos con 2 decimales" },
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savecliente").serialize();
		var formulario = $('#formulario').val();

	     var tipocliente = $('#tipocliente').val();
	     var dnicliente = $('#dnicliente').val();
	     var nomcliente = ($('#tipocliente').val() == "NATURAL") ? $('#nomcliente').val() : $('#razoncliente').val();
	     var nomcliente = ($('#nomcliente').val() == "") ? $('#razoncliente').val() : $('#nomcliente').val();
	     var limitecredito = $('#limitecredito').val();

	     if(formulario != "clientes"){
		     $("#codcliente").val("0");
		     $("#nrodocumento").val(dnicliente);
		     $("#busqueda").val(dnicliente +": "+ nomcliente);
	          $('#creditoinicial').val(limitecredito);
	          $('#montocredito').val(limitecredito);
	          $('#creditodisponible').val(limitecredito);
	          $('#TextCliente').text(nomcliente);
	          $('#TextCredito').text(limitecredito);
          }
		
		$.ajax({
		type : 'POST',
		url  : formulario+'.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-cliente").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');
								
				     });
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE UN CLIENTE CON ESTE N&deg; DE DOCUMENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
          $('#myModalCliente').modal('hide');
		$("#savecliente")[0].reset();
		$("#savecliente #nomcliente").val("").attr('disabled', true);
          $("#savecliente #razoncliente").val("").attr('disabled', true);
          $("#savecliente #girocliente").val("").attr('disabled', true);
		$('#id_departamento').html("<option value=''>-- SIN RESULTADOS --</option>");
		$("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');

          if(formulario == "clientes"){
          $("#savecliente #proceso").val("save");
		$('#savecliente #codcliente').val("");
		$("#BotonBusqueda").trigger("click");
          }
						
						});
					}
			    }
			});
			return false;
		}
	     /* form submit */	
    });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CLIENTES */


















/* FUNCION JQUERY PARA CARGA MASIVA DE PROVEEDORES */	 
$('document').ready(function()
{ 						
     /* validation */
	$("#cargaproveedores").validate({
          rules:
	     {
			sel_file: { required: false },
			codsucursal: { required: true },
	     },
          messages:
	     {
               sel_file:{ required: "Por favor Seleccione Archivo para Cargar" },
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#cargaproveedores").serialize();
		var formData = new FormData($("#cargaproveedores")[0]);
		var sel_file = $('#sel_file').val();
          var CodSucursal = $('#codsucursal').val();
          var TipoUsuario = $('#tipousuario').val();

          if (sel_file == "") {
            
			swal("Oops", "POR FAVOR REALICE LA BUSQUEDA DEL ARCHIVO A CARGAR!", "error");
               return false;

          } else {
		
		$.ajax({
		type : 'POST',
		url  : 'proveedores.php',
	     async : false,
		data : formData,
		//necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
		beforeSend: function()
		{	
			$("#carga").fadeOut();
			$("#btn-cargar").html('<i class="fa fa-spin fa-spinner"></i> Cargando ....');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#carga").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar');
								
					});
				}  
				else if(data==2){
							
			$("#carga").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE PROVEEDORES, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar');
																		
					});
				}
				else{
								
			$("#carga").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
          $('body').removeClass('modal-open');
          $('#myModalCargaMasiva').modal('hide');
		$("#cargaproveedores")[0].reset();
		$('#divproveedor').html("");
		$("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar');
		if(TipoUsuario == '1'){
          	$('#codsucursal').val(CodSucursal);
               $("#BotonBusqueda").trigger("click");
          } else {
			$('#proveedores').html("");
			$('#proveedores').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			setTimeout(function() {
			 	$('#proveedores').load("consultas?CargaProveedores=si");
			}, 200);
          }						
						});
					}
				}
			});
			return false;
		     }
		}
	    /* form submit */
     }); 
});
/*  FIN DE FUNCION PARA CARGA MASIVA DE PROVEEDORES */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PROVEEDORES */	  
$('document').ready(function()
{ 
    jQuery.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-zA-ZÒ—·ÈÌÛ˙¡…Õ”⁄,. ]+$/i.test(value);
    });

     /* validation */
	$("#saveproveedor").validate({
          rules:
	     {
			documproveedor: { required: false },
			cuitproveedor: { required: true,  digits : false, minlength: 7 },
			nomproveedor: { required: true, lettersonly: false },
			tlfproveedor: { required: true },
			id_provincia: { required: false },
			id_departamento: { required: false },
			direcproveedor: { required: true },
			emailproveedor: { required: true, email: true },
			vendedor: { required: true, lettersonly: true },
			tlfvendedor: { required: true },
			codsucursal: { required: true },
	     },
          messages:
	     {
			documproveedor:{ required: "Seleccione Tipo de Documento" },
			cuitproveedor:{ required: "Ingrese N&deg; de Documento", digits: "Ingrese solo d&iacute;gitos para N&deg; de Documento", minlength: "Ingrese 7 d&iacute;gitos como m&iacute;nimo" },
               nomproveedor:{ required: "Ingrese Nombre de Proveedor", lettersonly: "Ingrese solo letras para Nombres" },
			tlfproveedor: { required: "Ingrese N&deg; de Tel&eacute;fono" },
			id_provincia:{ required: "Seleccione Provincia" },
			id_departamento: { required: "Seleccione Departamento" },
			direcproveedor: { required: "Ingrese Direcci&oacute;n de Proveedor" },
			emailproveedor:{ required: "Ingrese Email de Proveedor", email: "Ingrese un Email V&aacute;lido" },
               vendedor:{ required: "Ingrese Nombre de Encargado", lettersonly: "Ingrese solo letras para Nombres" },
               tlfvendedor: { required: "Ingrese N&deg; de Tel&eacute;fono" },
			codsucursal:{ required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#saveproveedor").serialize();
		var formulario = $('#formulario').val();
          var CodSucursal = $('#codsucursal').val();
          var TipoUsuario = $('#tipousuario').val();
          var Proceso = $('#saveproveedor #proceso').val();
		
		$.ajax({
		type : 'POST',
		url  : formulario+'.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-proveedor").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-proveedor").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE UN PROVEEDOR CON ESTE N&deg; DE DOCUMENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-proveedor").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		if(formulario == "forcompra" || Proceso == 'update'){
		$('body').removeClass('modal-open');
		$('#myModalProveedor').modal('hide');
	     }
		$("#saveproveedor")[0].reset();
		$('#id_departamento').html("<option value=''>-- SIN RESULTADOS --</option>");
		$("#btn-proveedor").html('<span class="fa fa-save"></span> Guardar');
		
          if(TipoUsuario == '1' && formulario == "proveedores"){
          	$("#saveproveedor #proceso").val("save");
			$('#saveproveedor #codproveedor').val("");
          	$('#codsucursal').val(CodSucursal);
               $("#saveproveedor #BotonBusqueda").trigger("click");
          } else if(TipoUsuario == '2' && formulario == "proveedores"){
          	$("#saveproveedor #proceso").val("save");
			$('#saveproveedor #codproveedor').val("");
			$('#proveedores').html("");
			$('#proveedores').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			setTimeout(function() {
			 	$('#proveedores').load("consultas?CargaProveedores=si");
			}, 200);
          } else {
			$("#savecompras #codproveedor").load("funciones.php?BuscaProveedores=si");
          	$("#savecompras #codproveedor2").load("funciones.php?BuscaProveedores=si");
          }
						});
					}
				}
			});
			return false;
		}
	    /* form submit */	
     });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PROVEEDORES */


















/* FUNCION JQUERY PARA CARGA MASIVA DE PRODUCTOS */	 
$('document').ready(function()
{ 
								
     /* validation */
	$("#cargaproductos").validate({
          rules:
	     {
			sel_file: { required: false },
	     },
          messages:
	     {
               sel_file:{ required: "Por favor Seleccione Archivo para Cargar" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#cargaproductos").serialize();
		var formData = new FormData($("#cargaproductos")[0]);
		var sel_file = $('#sel_file').val();
          var TipoUsuario = $('#tipousuario').val();

          if (sel_file == "") {
            
			swal("Oops", "POR FAVOR REALICE LA BUSQUEDA DEL ARCHIVO A CARGAR!", "error");
               return false;

          } else {
		
		$.ajax({
		type : 'POST',
		url  : 'productos.php',
	     async : false,
		data : formData,
		//necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
		beforeSend: function()
		{	
			$("#carga").fadeOut();
			$("#btn-cargar").html('<i class="fa fa-spin fa-spinner"></i> Cargando ....');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#carga").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar');
								
					});
				}  
				else if(data==2){
							
			$("#carga").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar');
																		
					});
				}
				else{
								
			$("#carga").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
          $('body').removeClass('modal-open');
          $('#myModalCargaMasiva').modal('hide');
		$("#cargaproductos")[0].reset();
		$('#divproducto').html("");
		$("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar');
		if(TipoUsuario == '1'){
               $("#BotonBusqueda").trigger("click");
          } else {
			$('#productos').html("");
			$('#productos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			setTimeout(function() {
			 	$('#productos').load("consultas?CargaProductos=si");
			}, 200);
          }					
						});
					}
				}
			});
			return false;
			}
		}
	     /* form submit */
     }); 
});
/*  FIN DE FUNCION PARA CARGA MASIVA DE PRODUCTOS */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PRODUCTOS */	  
$('document').ready(function()
{ 
     /* validation */
	$("#saveproductos").validate({
	     rules:
	     {
			codproducto: { required: true },
			producto: { required: true },
			descripcion: { required: false },
			imei: { required: false },
			condicion: { required: true },
			fabricante: { required: false },
			codfamilia: { required: true },
			codsubfamilia: { required: false },
			codmarca: { required: true },
			codmodelo: { required: false },
			codpresentacion: { required: false },
			codcolor: { required: false },
			codorigen: { required: false },
			year: { required: false },
			nroparte: { required: false },
			lote: { required: false },
			peso: { required: false },
			preciocompra: { required: true, number : true},
			precioxmenor: { required: true, number : true},
			precioxmayor: { required: true, number : true},
			precioxpublico: { required: true, number : true},
			existencia: { required: true, number : true },
			stockoptimo: { required: true, number : true },
			stockmedio: { required: true, number : true },
			stockminimo: { required: true, number : true },
			ivaproducto: { required: true },
			descproducto: { required: true, number : true },
			codigobarra: { required: false },
			fechaelaboracion: { required: false },
			fechaoptimo: { required: false },
			fechamedio: { required: false },
			fechaminimo: { required: false },
			codproveedor: { required: true },
			codsucursal: { required: true },
	     },
          messages:
	     {
			codproducto: { required: "Ingrese C&oacute;digo de Producto" },
			producto:{ required: "Ingrese Nombre de Producto" },
			descripcion:{ required: "Ingrese Descripci&oacute;n de Producto" },
			imei:{ required: "Ingrese N&deg; de Imei" },
			condicion:{ required: "Ingrese Condici&oacute;n de Producto" },
			fabricante:{ required: "Ingrese Nombre de Fabricante" },
			codfamilia:{ required: "Seleccione Familia" },
			codsubfamilia:{ required: "Seleccione Subfamilia" },
			codmarca:{ required: "Seleccione Marca" },
			codmodelo:{ required: "Seleccione Modelo" },
			codpresentacion:{ required: "Seleccione Presentaci&oacute;n" },
			codcolor:{ required: "Seleccione Color" },
			codorigen:{ required: "Seleccione Origen" },
			year:{ required: "Ingrese A&ntilde;o de F&aacute;brica" },
			nroparte:{ required: "Ingrese N&deg; de Parte" },
			lote:{ required: "Ingrese N&deg; de Lote" },
			peso:{ required: "Ingrese Peso de Producto" },
			preciocompra:{ required: "Ingrese Precio Compra", number: "Ingrese solo digitos con 2 decimales" },
			precioxmenor:{ required: "Ingrese Precio Venta x Menor", number: "Ingrese solo digitos con 2 decimales" },
			precioxmayor:{ required: "Ingrese Precio Venta x Mayor", number: "Ingrese solo digitos con 2 decimales" },
			precioxpublico:{ required: "Ingrese Precio Venta x Publico", number: "Ingrese solo digitos con 2 decimales" },
			existencia:{ required: "Ingrese Existencia", number: "Ingrese solo digitos" },
               stockoptimo:{ required: "Ingrese Stock Optimo", number: "Ingrese solo digitos" },
               stockmedio:{ required: "Ingrese Stock Medio", number: "Ingrese solo digitos" },
			stockminimo:{ required: "Ingrese Stock Minimo", number: "Ingrese solo digitos" },
			ivaproducto:{ required: "Seleccione Impuesto" },
			descproducto:{ required: "Ingrese Descuento", number: "Ingrese solo digitos con 2 decimales" },
			codigobarra: { required: "Ingrese C&oacute;digo de Barra" },
			fechaelaboracion: { required: "Ingrese Fecha de Elaboraci&oacute;n" },
			fechaoptimo: { required: "Ingrese Fecha de Exp. Optimo" },
			fechamedio: { required: "Ingrese Fecha de Exp. Medio" },
			fechaminimo: { required: "Ingrese Fecha de Exp. Minimo" },
			codproveedor: { required: "Seleccione Proveedor" },
			codsucursal: { required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#saveproductos").serialize();
		var formData = new FormData($("#saveproductos")[0]);
		var formulario = $('#formulario').val();
          var TipoUsuario = $('#tipousuario').val();
          var CodSucursal = $('#codsucursal').val();

		var cant = $('#existencia').val();
		var compra = $('#preciocompra').val();
		var menor = $('#precioxmenor').val();
		var mayor = $('#precioxmayor').val();
		var publico = $('#precioxpublico').val();
		cantidad    = parseInt(cant);

          if (publico==0.00 || publico==0) {
            
			swal("Oops", "INGRESE UN COSTO VALIDO PARA EL PRECIO DE VENTA DE PRODUCTO!", "error");
               return false;

          } else if (parseFloat(compra) > parseFloat(publico)) {
            
			$("#preciocompra").focus();
			swal("Oops", "EL PRECIO DE COMPRA NO PUEDE SER MAYOR QUE EL PRECIO DE VENTA PUBLICO DEL PRODUCTO!", "error");
               return false;
 
          } else {
			
		$.ajax({
		type : 'POST',
	     url  : formulario+'.php',
	     async : false,
		data : formData,
		//necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-save").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-save").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE PRODUCTO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-save").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		$("#saveproductos")[0].reset();
		if(TipoUsuario == '1'){
          $('select#codsucursal').val(CodSucursal);
          }
		$('#codsubfamilia').html("<option value=''>-- SIN RESULTADOS --</option>");
		$('#codmodelo').html("<option value=''>-- SIN RESULTADOS --</option>");
		$("#btn-save").html('<span class="fa fa-save"></span> Guardar');	
							});
						}
					}
				});
				return false;
			}
		}
	     /* form submit */	
     });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PRODUCTOS */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PRODUCTOS EN COMPRA */	  
$('document').ready(function()
{ 
     /* validation */
	$("#nuevoproducto").validate({
	     rules:
	     {
			codproducto2: { required: true },
			producto2: { required: true },
			descripcion2: { required: false },
			imei2: { required: false },
			condicion2: { required: true },
			codfamilia2: { required: true },
			codmarca2: { required: true },
			codmodelo2: { required: false },
			codcolor2: { required: true },
			preciocompra2: { required: true, number : true},
			precioxpublico2: { required: true, number : true},
			existencia2: { required: true, number : true },
			ivaproducto2: { required: true },
			descproducto2: { required: true, number : true },
			codigobarra2: { required: false },
			codproveedor2: { required: false },
			codsucursal2: { required: true },
	     },
          messages:
	     {
			codproducto2: { required: "Ingrese C&oacute;digo de Producto" },
			producto2:{ required: "Ingrese Nombre de Producto" },
			descripcion2:{ required: "Ingrese Descripci&oacute;n de Producto" },
			imei2:{ required: "Ingrese N&deg; de Imei" },
			condicion2:{ required: "Ingrese Condici&oacute;n de Producto" },
			codfamilia2:{ required: "Seleccione Familia" },
			codmarca2:{ required: "Seleccione Marca" },
			codmodelo2:{ required: "Seleccione Modelo" },
			codcolor2:{ required: "Seleccione Color" },
			preciocompra2:{ required: "Ingrese Precio Compra", number: "Ingrese solo digitos con 2 decimales" },
			precioxpublico2:{ required: "Ingrese Precio Venta x Publico", number: "Ingrese solo digitos con 2 decimales" },
			existencia2:{ required: "Ingrese Existencia", number: "Ingrese solo digitos" },
			ivaproducto2:{ required: "Seleccione Impuesto" },
			descproducto2:{ required: "Ingrese Descuento", number: "Ingrese solo digitos con 2 decimales" },
			codigobarra2: { required: "Ingrese C&oacute;digo de Barra" },
			codproveedor2: { required: "Seleccione Proveedor" },
			codsucursal: { required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#nuevoproducto").serialize();
		var formData = new FormData($("#nuevoproducto")[0]);
		var formulario = $('#formulario').val();
		var modulo = $('#modulo').val();

	     var codproducto = $('#codproducto').val();
	     var codigobarra = $('#codigobarra').val();
	     var producto = $('#producto').val();
	     var codfamilia = $('#codfamilia').val();
	     var codmarca = $('#codmarca').val();
	     var ivaproducto = $('#ivaproducto').val();
	     var descproducto = $('#descproducto').val();
		var cant = $('#existencia').val();
		var compra = $('#preciocompra').val();
		var publico = $('#precioxpublico').val();
		cantidad    = parseInt(cant);

		/*$("#codcliente").val("0");
		$("#nrodocumento").val(dnicliente);
	     $("#busqueda").val(dnicliente +": "+ nomcliente);
          $('#creditoinicial').val(limitecredito);
          $('#montocredito').val(limitecredito);
          $('#creditodisponible').val(limitecredito);
          $('#TextCliente').text(nomcliente);
          $('#TextCredito').text(limitecredito);*/
			
		$.ajax({
		type : 'POST',
	     url  : formulario+'.php',
	     async : false,
		data : formData,
		//necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-save").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-save").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE PRODUCTO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-save").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		$("#nuevoproducto")[0].reset();
		$("#btn-save").html('<span class="fa fa-save"></span> Guardar');	
						});
					}
				}
			});
			return false;
		}
	    /* form submit */	
     });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PRODUCTOS EN COMPRA */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PRODUCTOS */	  
$('document').ready(function()
{ 
    /* validation */
	$("#updateproductos").validate({
	     rules:
	     {
			codproducto: { required: true },
			producto: { required: true },
			descripcion: { required: false },
			imei: { required: false },
			condicion: { required: true },
			fabricante: { required: false },
			codfamilia: { required: true },
			codsubfamilia: { required: false },
			codmarca: { required: true },
			codmodelo: { required: false },
			codpresentacion: { required: false },
			codcolor: { required: false },
			codorigen: { required: false },
			year: { required: false },
			nroparte: { required: false },
			lote: { required: false },
			peso: { required: false },
			preciocompra: { required: true, number : true},
			precioxmenor: { required: true, number : true},
			precioxmayor: { required: true, number : true},
			precioxpublico: { required: true, number : true},
			existencia: { required: true, number : true },
			stockoptimo: { required: true, number : true },
			stockmedio: { required: true, number : true },
			stockminimo: { required: true, number : true },
			ivaproducto: { required: true },
			descproducto: { required: true, number : true },
			codigobarra: { required: false },
			fechaelaboracion: { required: false },
			fechaoptimo: { required: false },
			fechamedio: { required: false },
			fechaminimo: { required: false },
			codproveedor: { required: true },
			codsucursal: { required: true },
	     },
          messages:
	     {
			codproducto: { required: "Ingrese C&oacute;digo de Producto" },
			producto:{ required: "Ingrese Nombre de Producto" },
			descripcion:{ required: "Ingrese Descripci&oacute;n de Producto" },
			imei:{ required: "Ingrese N&deg; de Imei" },
			condicion:{ required: "Ingrese Condici&oacute;n de Producto" },
			fabricante:{ required: "Ingrese Nombre de Fabricante" },
			codfamilia:{ required: "Seleccione Familia" },
			codsubfamilia:{ required: "Seleccione Subfamilia" },
			codmarca:{ required: "Seleccione Marca" },
			codmodelo:{ required: "Seleccione Modelo" },
			codpresentacion:{ required: "Seleccione Presentaci&oacute;n" },
			codcolor:{ required: "Seleccione Color" },
			codorigen:{ required: "Seleccione Origen" },
			year:{ required: "Ingrese A&ntilde;o de F&aacute;brica" },
			nroparte:{ required: "Ingrese N&deg; de Parte" },
			lote:{ required: "Ingrese N&deg; de Lote" },
			peso:{ required: "Ingrese Peso de Producto" },
			preciocompra:{ required: "Ingrese Precio Compra", number: "Ingrese solo digitos con 2 decimales" },
			precioxmenor:{ required: "Ingrese Precio Venta x Menor", number: "Ingrese solo digitos con 2 decimales" },
			precioxmayor:{ required: "Ingrese Precio Venta x Mayor", number: "Ingrese solo digitos con 2 decimales" },
			precioxpublico:{ required: "Ingrese Precio Venta x Publico", number: "Ingrese solo digitos con 2 decimales" },
			existencia:{ required: "Ingrese Existencia", number: "Ingrese solo digitos" },
               stockoptimo:{ required: "Ingrese Stock Optimo", number: "Ingrese solo digitos" },
               stockmedio:{ required: "Ingrese Stock Medio", number: "Ingrese solo digitos" },
			stockminimo:{ required: "Ingrese Stock Minimo", number: "Ingrese solo digitos" },
			ivaproducto:{ required: "Seleccione Impuesto" },
			descproducto:{ required: "Ingrese Descuento", number: "Ingrese solo digitos con 2 decimales" },
			codigobarra: { required: "Ingrese C&oacute;digo de Barra" },
			fechaelaboracion: { required: "Ingrese Fecha de Elaboraci&oacute;n" },
			fechaoptimo: { required: "Ingrese Fecha de Exp. Optimo" },
			fechamedio: { required: "Ingrese Fecha de Exp. Medio" },
			fechaminimo: { required: "Ingrese Fecha de Exp. Minimo" },
			codproveedor: { required: "Seleccione Proveedor" },
			codsucursal: { required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
	   			
	     var data = $("#updateproductos").serialize();
		var formData = new FormData($("#updateproductos")[0]);
		var id= $("#updateproductos").attr("data-id");
          var codproducto = id;

		var cant = $('#existencia').val();
		var compra = $('#preciocompra').val();
		var menor = $('#precioxmenor').val();
		var mayor = $('#precioxmayor').val();
		var publico = $('#precioxpublico').val();
		cantidad    = parseInt(cant);

          if (publico==0.00 || publico==0) {
            
			swal("Oops", "INGRESE UN COSTO VALIDO PARA EL PRECIO DE VENTA DE PRODUCTO!", "error");
               return false;

          } else if (parseFloat(compra) > parseFloat(publico)) {
            
			$("#preciocompra").focus();
			swal("Oops", "EL PRECIO DE COMPRA NO PUEDE SER MAYOR QUE EL PRECIO DE VENTA PUBLICO DEL PRODUCTO!", "error");
               return false;
 
          } else {
			
		$.ajax({
		type : 'POST',
		url  : 'forproducto.php?codproducto='+codproducto,
	     async : false,
		data : formData,
		//necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
								
					});
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE PRODUCTO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'success',
          timeout: 5000, });
		$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
		setTimeout("location.href='productos'", 5000);	
							
							});
						}
					}
				});
				return false;
			}
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE PRODUCTOS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE COMBOS */	  
$('document').ready(function()
{ 
    /* validation */
    $("#savecombo").validate({
	     rules:
	     {
			codcombo: { required: true, },
			nomcombo: { required: true,},
			codfamilia: { required: true },
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			existencia: { required: true, number : true },
			stockminimo: { required: true, number : true },
			stockmaximo: { required: true, number : true },
			ivacombo: { required: true, },
			desccombo: { required: true, number : true },
			codsucursal: { required: true },
	     },
          messages:
	     {
			codcombo: { required: "Ingrese C&oacute;digo" },
			codfamilia:{ required: "Seleccione Familia" },
			nomcombo:{ required: "Ingrese Nombre o Descripci&oacute;n" },
			preciocompra:{ required: "Ingrese Precio de Compra", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta", number: "Ingrese solo digitos con 2 decimales" },
			existencia:{ required: "Ingrese Cantidad o Existencia", number: "Ingrese solo digitos" },
               stockminimo:{ required: "Ingrese Stock Minimo", number: "Ingrese solo digitos" },
               stockmaximo:{ required: "Ingrese Stock Maximo", number: "Ingrese solo digitos" },
			ivacombo:{ required: "Seleccione Impuesto" },
			desccombo:{ required: "Ingrese Descuento", number: "Ingrese solo digitos con 2 decimales" },
			codsucursal: { required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
                     		
	   	var data = $("#savecombo").serialize();
	   	var formData = new FormData($("#savecombo")[0]);
          var TipoUsuario = $('#tipousuario').val();
          var CodSucursal = $('#codsucursal').val();
	   	var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=6><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
	   	var cant = $('#existencia').val();
	   	var compra = $('#preciocompra').val();
	   	var venta = $('#precioventa').val();
	   	cantidad    = parseInt(cant);
	
	     if (venta==0.00 || venta==0) {
	            
			$("#precioventa").focus();
			$('#precioventa').val("");
			$('#precioventa').css('border-color','#f0ad4e');
			swal("Oops", "INGRESE UN COSTO VALIDO PARA EL PRECIO DE VENTA DE PRODUCTO!", "error");
               return false;
          
          } else if (parseFloat(compra) > parseFloat(venta)) {
	            
			$("#precioventa").focus();
			$("#preciocompra").focus();
			$('#precioventa').css('border-color','#f0ad4e');
			$('#preciocompra').css('border-color','#f0ad4e');
			swal("Oops", "EL PRECIO DE COMPRA NO PUEDE SER MAYOR QUE EL PRECIO DE VENTA DEL PRODUCTO!", "error");
               return false;
	 
	     } else {
				
		$.ajax({
		type : 'POST',
		url  : 'forcombo.php',
	     async : false,
		data : formData,
		//necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
	     var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}    
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD DE PRODUCTOS ASIGNADOS NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}    
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> INGRESE UNA CANTIDAD VALIDA PARA PRODUCTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE COMBO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		$("#savecombo")[0].reset();
		if(TipoUsuario == '1'){
          $('select#codsucursal').val(CodSucursal);
          }
		$("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
							
							});
					     }
					}
			     });
			     return false;
			}
		}
	    /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE COMBOS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE COMBOS */	  
$('document').ready(function()
{ 
    /* validation */
	$("#updatecombo").validate({
	     rules:
	     {
			codcombo: { required: true, },
			nomcombo: { required: true,},
			codfamilia: { required: true,},
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			existencia: { required: true, number : true },
			stockminimo: { required: true, number : true },
			stockmaximo: { required: true, number : true },
			ivacombo: { required: true, },
			desccombo: { required: true, number : true },
			codsucursal: { required: true },
	     },
          messages:
	     {
			codcombo: { required: "Ingrese C&oacute;digo" },
			nomcombo:{ required: "Ingrese Nombre o Descripci&oacute;n" },
			codfamilia:{ required: "Seleccione Familia" },
			preciocompra:{ required: "Ingrese Precio de Compra", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta", number: "Ingrese solo digitos con 2 decimales" },
			existencia:{ required: "Ingrese Cantidad o Existencia", number: "Ingrese solo digitos" },
               stockminimo:{ required: "Ingrese Stock Minimo", number: "Ingrese solo digitos" },
               stockmaximo:{ required: "Ingrese Stock Maximo", number: "Ingrese solo digitos" },
			ivacombo:{ required: "Seleccione Impuesto" },
			desccombo:{ required: "Ingrese Descuento", number: "Ingrese solo digitos con 2 decimales" },
			codsucursal: { required: "Seleccione Sucursal" },
          },
	     submitHandler: function(form) {
                     		
   	     var data = $("#updatecombo").serialize();
		var formData = new FormData($("#updatecombo")[0]);
		var id= $("#updatecombo").attr("data-id");
		var combo = id;
		var codcombo = $('#codcombo').val();
		var cant = $('#existencia').val();
		var compra = $('#preciocompra').val();
		var venta = $('#precioventa').val();
		cantidad    = parseInt(cant);

          if (venta==0.00 || venta==0) {
            
			$("#precioventa").focus();
			$('#precioventa').val("");
			$('#precioventa').css('border-color','#f0ad4e');
			swal("Oops", "INGRESE UN COSTO VALIDO PARA EL PRECIO DE VENTA DE COMBO!", "error");
			return false;
 
          } else {
			
	     $.ajax({
	     type : 'POST',
	     url  : 'forcombo.php?codcombo='+combo,
	     async : false,
		data : formData,
		//necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
								
					});
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> INGRESE UNA CANTIDAD VALIDA PARA PRODUCTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'success',
          timeout: 5000, });
		$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
		setTimeout("location.href='combos'", 5000);	
							
							});
						}
					}
			     });
			return false;
			}
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE COMBOS */

/* FUNCION JQUERY PARA VALIDAR AGREGAR PRODUCTOS A COMBOS */	  
$('document').ready(function()
{ 
     /* validation */
	$("#agregaproductos").validate({
	     rules:
	     {
			codproducto: { required: true, },
	     },
          messages:
	     {
			codproducto: { required: "Ingrese C&oacute;digo" },
          },
	     submitHandler: function(form) {
                     		
	   	var data = $("#agregaproductos").serialize();
	     var formData = new FormData($("#agregaproductos")[0]);
	   	var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=6><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		var id= $("#agregaproductos").attr("data-id");
          var combo = id;
          var codcombo = $('#codcombo').val();
          var codsucursal = $('#codsucursal').val();
		
		$.ajax({
		type : 'POST',
		url  : 'foragregaproductos.php?codcombo='+codcombo+"&codsucursal="+codsucursal,
	     async : false,
		data : formData,
		//necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Agregar');
								
					});
				}
				else if(data==2){
						
		     $("#save").fadeIn(1000, function(){
						
	     var n = noty({
          text: "<span class='fa fa-warning'></span> INGRESE UNA CANTIDAD VALIDA PARA PRODUCTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#btn-submit").html('<span class="fa fa-save"></span> Agregar');
																	
					});
				}    
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD DE PRODUCTOS ASIGNADOS NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Agregar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'success',
          timeout: 5000, });
		$("#agregaproductos")[0].reset();
		$("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
          $("#productosxcombos").load("funciones.php?BuscaDetallesCombo=si&codcombo="+codcombo+"&codsucursal="+codsucursal);
		$("#btn-submit").html('<span class="fa fa-save"></span> Agregar');
						
						});
					}
				}
		     });
		     return false;
		}
	    /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR AGREGAR PRODUCTOS A COMBOS */


/* FUNCION JQUERY PARA VALIDAR SUMAR DE STOCK A PRODUCTO  */	 
$('document').ready(function()
{ 
    /* validation */
	$("#savestockcombo").validate({
          rules:
	     {
			cantidad: { required: true, number : true},
	     },
          messages:
	     {
			cantidad:{ required: "Ingrese Cantidad a Sumar", number: "Ingrese solo digitos con 2 decimales" },
          },
	     submitHandler: function(form) {
                     		
		var data = $("#savestockcombo").serialize();
		
		$.ajax({
		type : 'POST',
		url  : 'combos.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> DEBE DE INGRESAR UNA CANTIDAD VALIDA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
          $('#myModalStock').modal('hide');
		$("#savestockcombo")[0].reset();
		$('#combos').html("");
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
		$('#combos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
		setTimeout(function() {
		 	$('#combos').load("consultas?CargaCombos=si");
		}, 200);
								
						});
				     }
				}
			});
			return false;
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR SUMAR DE STOCK A COMBO */























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PEDIDOS */	 	 
$('document').ready(function()
{ 
     /* validation */
	$("#savepedidos").validate({
     rules:
	     {
			codpedido: { required: true },
			codproveedor: { required: false },
			observacionpedido: { required: true },
			fechapedido: { required: true },
	     },
          messages:
	     {
               codpedido:{ required: "Ingrese C&oacute;digo" },
               codproveedor:{ required: "Seleccione Proveedor" },
               observaciones:{ required: "Ingrese Observaciones" },
		     fechapedido:{ required: "Ingrese Fecha de Pedido" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savepedidos").serialize();
		var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		var total = $('#txtTotal').val();
		var proveedor = $('#codproveedor').val();
	
	     if (proveedor==0.00) {
	       
	         swal("Oops", "POR FAVOR SELECCIONE UN PROVEEDOR!", "error");
	         return false;

	     } else if (total==0.00) {
	            
	          $("#busquedaproductoc").focus();
               $('#busquedaproductoc').css('border-color','#ff7676');
	          swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON EL PEDIDO DE PRODUCTOS!", "error");
               return false;
	 
	     } else {

		$.ajax({
		type : 'POST',
		url  : 'forpedido.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
								
					});
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA PEDIDO DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		$("#savepedidos")[0].reset();
		$("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
		$("#lblsubtotal").text("0.00");
		$("#lblsubtotal2").text("0.00");
		$("#lbliva").text("0.00");
          $("#lbldescontado").text("0.00");
		$("#lbldescuento").text("0.00");
		$("#lbltotal").text("0.00");
		$("#txtsubtotal").val("0.00");
		$("#txtsubtotal2").val("0.00");
		$("#txtIva").val("0.00");
          $("#txtdescontado").val("0.00");
		$("#txtDescuento").val("0.00");
		$("#txtTotal").val("0.00");
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
								
						});
					}
				}
			});
			return false;
		     }
		}
	     /* form submit */	
     });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PEDIDOS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PEDIDOS */	 
$('document').ready(function()
{ 
     /* validation */
     $("#updatepedidos").validate({
     rules:
	     {
			codpedido: { required: true },
			codproveedor: { required: false },
			observacionpedido: { required: true },
			fechapedido: { required: true },
	     },
          messages:
	     {
               codpedido:{ required: "Ingrese C&oacute;digo" },
               codproveedor:{ required: "Seleccione Proveedor" },
               observaciones:{ required: "Ingrese Observaciones" },
		     fechapedido:{ required: "Ingrese Fecha de Pedido" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#updatepedidos").serialize();
          var id= $("#updatepedidos").attr("data-id");
          var codpedido = $('#codpedido').val();
          var codsucursal = $('#codsucursal').val();
          var proveedor = $('#codproveedor').val();
	
	     if (proveedor==0.00) {
	       
	         swal("Oops", "POR FAVOR SELECCIONE UN PROVEEDOR!", "error");
	         return false;

	     } else {
				
		$.ajax({
		type : 'POST',
		url  : 'forpedido.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_update").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
								
					});
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE PEDIDOS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		//$('#detallespedidosupdate').load("funciones.php?MuestraDetallesPedidosUpdate=si&codpedido="+codpedido+"&codsucursal="+codsucursal); 
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
		setTimeout("location.href='pedidos'", 5000);	
						
						});
					}
				}
			});
			return false;
		     }
		}
	    /* form submit */	
     });    
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE PEDIDOS */

/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A PEDIDOS */	 
$('document').ready(function()
{ 
     /* validation */
     $("#agregapedidos").validate({
     rules:
	     {
			codpedido: { required: true },
			codproveedor: { required: true },
			observacionpedido: { required: true },
			fechapedido: { required: true },
	     },
          messages:
	     {
               codpedido:{ required: "Ingrese C&oacute;digo" },
               codproveedor:{ required: "Seleccione Proveedor" },
               observaciones:{ required: "Ingrese Observaciones" },
		     fechapedido:{ required: "Ingrese Fecha de Pedido" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#agregapedidos").serialize();
          var id= $("#agregapedidos").attr("data-id");
          var codpedido = $('#codpedido').val();
          var codsucursal = $('#codsucursal').val();
          var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		
		$.ajax({
		type : 'POST',
		url  : 'forpedido.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_agregar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
								
					});
			     }  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA PEDIDO AL PROVEEDOR, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
					});
				}    
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE PEDIDOS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		$("#agregapedidos")[0].reset();
          $("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
		$("#lblsubtotal").text("0.00");
		$("#lblsubtotal2").text("0.00");
		$("#lbliva").text("0.00");
          $("#lbldescontado").text("0.00");
		$("#lbldescuento").text("0.00");
		$("#lbltotal").text("0.00");
		$("#txtsubtotal").val("0.00");
		$("#txtsubtotal2").val("0.00");
		$("#txtIva").val("0.00");
          $("#txtdescontado").val("0.00");
		$("#txtDescuento").val("0.00");
		$("#txtTotal").val("0.00");
		$('#detallespedidosagregar').load("funciones.php?MuestraDetallesPedidosAgregar=si&codpedido="+codpedido+"&codsucursal="+codsucursal); 
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
		setTimeout("location.href='pedidos'", 5000);	
						
						});
					}
				}
			});
			return false;
		}
	     /* form submit */
     }); 	   
});
/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A PEDIDOS */	 

/* FUNCION JQUERY PARA VALIDAR PROCESAR PEDIDOS A COMPRAS */	 	 
$('document').ready(function()
{ 
     /* validation */
	$("#procesarpedido").validate({
     rules:
	     {
			codfactura: { required: true },
			fechaemision: { required: true },
			fecharecepcion: { required: true },
			codproveedor: { required: true },
			codsucursal: { required: true },
			tipocompra: { required: true },
			formacompra: { required: true },
			gastoenvio: { required: true, number : true},
			fechavencecredito: { required: true },
	     },
          messages:
	     {
               codfactura:{ required: "Ingrese N&deg; de Factura" },
			fechaemision:{ required: "Ingrese Fecha de Emisi&oacute;n" },
			fecharecepcion:{ required: "Ingrese Fecha de Recepci&oacute;n" },
			codproveedor:{ required: "Seleccione Proveedor" },
			codsucursal:{ required: "Seleccione Sucursal" },
			tipocompra:{ required: "Seleccione Tipo Compra" },
			formacompra:{ required: "Seleccione Forma de Pago" },
			gastoenvio:{ required: "Ingrese Gasto de Envio", number: "Ingrese solo digitos con 2 decimales" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#procesarpedido").serialize();
		var total = $('#txtTotal').val();
	
	     if (total==0.00) {
	            
	          $("#busquedaproductoc").focus();
               $('#busquedaproductoc').css('border-color','#ff7676');
	          swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON EL REGISTRO DE COMPRAS DE PRODUCTOS!", "error");
               return false;
	 
	     } else {

		$.ajax({
		type : 'POST',
		url  : 'pedidos.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
								
					});
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA PEDIDO DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
																		
					});
				}  
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE COMPRA A CREDITO, NO PUEDE SER MENOR QUE LA FECHA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
																		
					});
				}  
				else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE NUMERO DE FACTURA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
          $('#myModalProcesar').modal('hide');
		$("#procesarpedido")[0].reset();
		$("#procesarpedido #muestra_detalles").html("");
		$('#pedidos').html("");
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
		$('#pedidos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			setTimeout(function() {
			$('#pedidos').load("consultas?CargaPedidos=si");
		}, 200);
								
						});
					}
				}
			});
			return false;
		     }
		}
	     /* form submit */	
     });    
});
/*  FIN DE FUNCION PARA VALIDAR PROCESAR PEDIDOS A COMPRAS */


























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TRASPASOS */	 	 
$('document').ready(function()
{ 
     /* validation */
	$("#savetraspaso").validate({
          rules:
	     {
			nombres_responsable: { required: false },
			sucursal_envia: { required: true },
			sucursal_recibe: { required: true },
			fechatraspaso: { required: true },
			observaciones: { required: false },
	     },
          messages:
	     {
               nombres_responsable:{ required: "Ingrese Nombre de Responsable" },
               sucursal_envia:{ required: "Seleccione Sucursal Remitente" },
               sucursal_recibe:{ required: "Seleccione Sucursal Destinatario" },
			fechatraspaso:{ required: "Ingrese Fecha de Traspaso" },
			observaciones:{ required: "Ingrese Observaciones" },
          },
	     submitHandler: function(form) {
	   			
	     var data = $("#savetraspaso").serialize();
		var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		var total = $('#txtTotal').val();
	
	     if (total==0.00) {
	            
	          $("#search_traspaso").focus();
               $('#search_traspaso').css('border-color','#ff7676');
               swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON EL TRASPASO DE PRODUCTOS!", "error");
               return false;
	 
	     } else {
				
		$.ajax({
		type : 'POST',
		url  : 'fortraspaso.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL TRASPASO DE PRODUCTOS NO PUEDE SER EN LA MISMA SUCURSAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
																		
					});
				} 
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA TRASPASO DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
																		
					});
				}
				else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
	  	text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		$("#savetraspaso")[0].reset();
		$("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
		$("#lblsubtotal").text("0.00");
		$("#lblsubtotal2").text("0.00");
		$("#lbliva").text("0.00");
		$("#lbldescuento").text("0.00");
		$("#lbltotal").text("0.00");
		$("#txtsubtotal").val("0.00");
		$("#txtsubtotal2").val("0.00");
		$("#txtIva").val("0.00");
		$("#txtDescuento").val("0.00");
		$("#txtTotal").val("0.00");
		$("#txtTotalCompra").val("0.00");
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');	
								
							});
						}
					 }
				});
				return false;
			}
		}
	    /* form submit */	
     });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE TRASPASOS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE TRASPASOS */	 
$('document').ready(function()
{ 
     /* validation */
     $("#updatetraspaso").validate({
          rules:
	     {
			nombres_responsable: { required: false },
			sucursal_envia: { required: true },
			sucursal_recibe: { required: true },
			fechatraspaso: { required: true },
			observaciones: { required: false },
	     },
          messages:
	     {
               nombres_responsable:{ required: "Ingrese Nombre de Responsable" },
               sucursal_envia:{ required: "Seleccione Sucursal Remitente" },
               sucursal_recibe:{ required: "Seleccione Sucursal Destinatario" },
			fechatraspaso:{ required: "Ingrese Fecha de Traspaso" },
			observaciones:{ required: "Ingrese Observaciones" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#updatetraspaso").serialize();
          var id= $("#updatetraspaso").attr("data-id");
          var codtraspaso = $('#codtraspaso').val();
          var codsucursal = $('#sucursal_envia').val();
			
		$.ajax({
		type : 'POST',
		url  : 'fortraspaso.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_update").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
								
					});
				}    
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE TRASPASOS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
					});
				}
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
					});
				} 
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		//$('#detallestraspasoupdate').load("funciones.php?MuestraDetallesTraspasoUpdate=si&codtraspaso="+codtraspaso+"&codsucursal="+codsucursal); 
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
		setTimeout("location.href='traspasos'", 5000);											
						
						});
					}
				}
			});
			return false;
		}
	     /* form submit */	
     });    
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE TRASPASOS */

/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A TRASPASOS */	 
$('document').ready(function()
{ 
     /* validation */
     $("#agregatraspaso").validate({
          rules:
	     {
			nombres_responsable: { required: false },
			sucursal_envia: { required: true },
			sucursal_recibe: { required: true },
			fechatraspaso: { required: true },
			observaciones: { required: false },
	     },
          messages:
	     {
               nombres_responsable:{ required: "Ingrese Nombre de Responsable" },
               sucursal_envia:{ required: "Seleccione Sucursal Remitente" },
               sucursal_recibe:{ required: "Seleccione Sucursal Destinatario" },
			fechatraspaso:{ required: "Ingrese Fecha de Traspaso" },
			observaciones:{ required: "Ingrese Observaciones" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#agregatraspaso").serialize();
          var id= $("#agregatraspaso").attr("data-id");
          var codtraspaso = $('#codtraspaso').val();
          var codsucursal = $('#sucursal_envia').val();
          var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
			
		$.ajax({
		type : 'POST',
		url  : 'fortraspaso.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_agregar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
								
					});
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA TRASPASOS DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
					});
				}    
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE TRAPASOS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
					});
				}
				else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		$("#agregatraspaso")[0].reset();
		$("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
		$("#lblsubtotal").text("0.00");
		$("#lblsubtotal2").text("0.00");
		$("#lbliva").text("0.00");
		$("#lbldescuento").text("0.00");
		$("#lbltotal").text("0.00");
		$("#txtsubtotal").val("0.00");
		$("#txtsubtotal2").val("0.00");
		$("#txtIva").val("0.00");
		$("#txtDescuento").val("0.00");
		$("#txtTotal").val("0.00");
		$("#txtTotalCompra").val("0.00");
	     $('#detallestraspasosagregar').load("funciones.php?MuestraDetallesTraspasoAgregar=si&codtraspaso="+codtraspaso+"&codsucursal="+codsucursal);  
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
		setTimeout("location.href='traspasos'", 5000);	
						
						});
					}
				}
			});
			return false;
		}
	     /* form submit */
     }); 	   
});
/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A TRASPASOS */	 

/* FUNCION JQUERY PARA VALIDAR PROCESAR TRASPASO */	 
$('document').ready(function()
{ 
     /* validation */
	$("#procesartraspaso").validate({
     rules:
	     {
			persona_recibe: { required: true },
			estado_traspaso: { required: true },
			observaciones_recibido: { required: false },
	     },
          messages:
	     {
               persona_recibe:{ required: "Seleccione Recibido por" },
               estado_traspaso:{ required: "Ingrese Estado" },
               observaciones_recibido:{ required: "Ingrese Observaciones" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#procesartraspaso").serialize();
		//var codsucursal = $('#').val();
		
		$.ajax({
		type : 'POST',
		url  : 'traspasos.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="submit" class="btn btn-danger"><span class="fa fa-refresh"></span> Verificando</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000 });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Procesar</button>');							
					
					});
				} 
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000 });
          $('#myModalProcesar').modal('hide');
		$("#procesartraspaso")[0].reset();
          $('#traspasos').load("consultas?CargaTraspasos=si");
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Procesar</button>');					});
				    }
			    }
			});
			return false;
		}
	     /* form submit */
     }); 	   
});
/* FUNCION PARA VALIDAR PROCESAR TRASPASO */















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE COMPRAS */	 	 
$('document').ready(function()
{ 
     /* validation */
	$("#savecompras").validate({
          rules:
	     {
			codfactura: { required: true },
			fechaemision: { required: true },
			fecharecepcion: { required: true },
			codproveedor: { required: false },
			codsucursal: { required: true },
			tipocompra: { required: true },
			formacompra: { required: true },
			gastoenvio: { required: true, number : true},
			fechavencecredito: { required: true },
	     },
          messages:
	     {
               codfactura:{ required: "Ingrese N&deg; de Factura" },
			fechaemision:{ required: "Ingrese Fecha de Emisi&oacute;n" },
			fecharecepcion:{ required: "Ingrese Fecha de Recepci&oacute;n" },
			codproveedor:{ required: "Seleccione Proveedor" },
			codsucursal:{ required: "Seleccione Sucursal" },
			tipocompra:{ required: "Seleccione Tipo Compra" },
			formacompra:{ required: "Seleccione Forma de Pago" },
			gastoenvio:{ required: "Ingrese Gasto de Envio", number: "Ingrese solo digitos con 2 decimales" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savecompras").serialize();
		var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		var proveedor = $('#codproveedor').val();
		var total = $('#txtTotal').val();
	
	     if (proveedor=="") {
	       
	         swal("Oops", "POR FAVOR SELECCIONE UN PROVEEDOR!", "error");
	         return false;

	     } else if (total==0.00) {
	       
	         $("#busquedaproductoc").focus();
	         $('#busquedaproductoc').css('border-color','#ff7676');
	         swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA COMPRA DE PRODUCTOS!", "error");
	         return false;

	     } else {
		
		$.ajax({
		type : 'POST',
		url  : 'forcompra.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
								
					});
				}
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA COMPRAS DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
																		
					});
				}  
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE COMPRA A CREDITO, NO PUEDE SER MENOR QUE LA FECHA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
																		
					});
				}  
				else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE NUMERO DE FACTURA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		$("#savecompras")[0].reset();
		$("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
		$("#lblsubtotal").text("0.00");
		$("#lblsubtotal2").text("0.00");
		$("#lbliva").text("0.00");
          $("#lbldescontado").text("0.00");
		$("#lbldescuento").text("0.00");
		$("#lbltotal").text("0.00");
		$("#txtsubtotal").val("0.00");
		$("#txtsubtotal2").val("0.00");
		$("#txtIva").val("0.00");
          $("#txtdescontado").val("0.00");
		$("#txtDescuento").val("0.00");
		$("#txtTotal").val("0.00");
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
								
							});
						}
					}
				});
				return false;
			}
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE COMPRAS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE COMPRAS */	 
$('document').ready(function()
{ 
     /* validation */
     $("#updatecompras").validate({
          rules:
	     {
			codfactura: { required: true },
			fechaemision: { required: true },
			fecharecepcion: { required: true },
			codproveedor: { required: false },
			codsucursal: { required: true },
			tipocompra: { required: true },
			formacompra: { required: true },
			fechavencecredito: { required: true },
	     },
          messages:
	     {
               codfactura:{ required: "Ingrese N&deg; de Factura" },
			fechaemision:{ required: "Ingrese Fecha de Emisi&oacute;n" },
			fecharecepcion:{ required: "Ingrese Fecha de Recepci&oacute;n" },
			codproveedor:{ required: "Seleccione Proveedor" },
			codsucursal:{ required: "Seleccione Sucursal" },
			tipocompra:{ required: "Seleccione Tipo Compra" },
			formacompra:{ required: "Seleccione Forma de Pago" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#updatecompras").serialize();
          var id= $("#updatecompras").attr("data-id");
          var codcompra = $('#codcompra').val();
          var codsucursal = $('#codsucursal').val();
          var status = $('#status').val();
          var proveedor = $('#codproveedor').val();
	
	     if (proveedor=="") {
	       
	         swal("Oops", "POR FAVOR SELECCIONE UN PROVEEDOR!", "error");
	         return false;

	     } else {

		$.ajax({
		type : 'POST',
		url  : 'forcompra.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_update").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
								
					});
				} 
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE COMPRAS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
					});
				}  
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE COMPRA A CREDITO, NO PUEDE SER MENOR QUE LA FECHA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
					});
				} 
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		//$('#detallescomprasupdate').load("funciones.php?MuestraDetallesComprasUpdate=si&codcompra="+codcompra+"&codsucursal="+codsucursal); 
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
		if (status=="P") {
		 	setTimeout("location.href='compras'", 5000);
		} else {
		 	setTimeout("location.href='cuentasxpagar'", 5000);
		}
						});
					}
				}
			});
			return false;
		     }
		}
	    /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE COMPRAS */


/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A COMPRAS */	 
$('document').ready(function()
{ 
     /* validation */
     $("#agregacompras").validate({
          rules:
	     {
			codfactura: { required: true },
			fechaemision: { required: true },
			fecharecepcion: { required: true },
			codproveedor: { required: false },
			codsucursal: { required: true },
			tipocompra: { required: true },
			formacompra: { required: true },
			gastoenvio: { required: true, number : true},
			fechavencecredito: { required: true },
	     },
          messages:
	     {
               codfactura:{ required: "Ingrese N&deg; de Factura" },
			fechaemision:{ required: "Ingrese Fecha de Emisi&oacute;n" },
			fecharecepcion:{ required: "Ingrese Fecha de Recepci&oacute;n" },
			codproveedor:{ required: "Seleccione Proveedor" },
			codsucursal:{ required: "Seleccione Sucursal" },
			tipocompra:{ required: "Seleccione Tipo Compra" },
			formacompra:{ required: "Seleccione Forma de Pago" },
			gastoenvio:{ required: "Ingrese Gasto de Envio", number: "Ingrese solo digitos con 2 decimales" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#agregacompras").serialize();
          var id= $("#agregacompras").attr("data-id");
          var codcompra = $('#codcompra').val();
          var codsucursal = $('#codsucursal').val();
          var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		var proveedor = $('#codproveedor').val();
	
	     if (proveedor==0.00) {
	       
	         swal("Oops", "POR FAVOR SELECCIONE UN PROVEEDOR!", "error");
	         return false;

	     } else {

		$.ajax({
		type : 'POST',
		url  : 'forcompra.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_agregar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
								
					});
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA COMPRAS DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
					});
				}    
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE COMPRAS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		$("#agregacompras")[0].reset();
          $("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
		$("#lblsubtotal").text("0.00");
		$("#lblsubtotal2").text("0.00");
		$("#lbliva").text("0.00");
          $("#lbldescontado").text("0.00");
		$("#lbldescuento").text("0.00");
		$("#lbltotal").text("0.00");
		$("#txtsubtotal").val("0.00");
		$("#txtsubtotal2").val("0.00");
		$("#txtIva").val("0.00");
          $("#txtdescontado").val("0.00");
		$("#txtDescuento").val("0.00");
		$("#txtTotal").val("0.00");
		$('#detallescomprasagregar').load("funciones.php?MuestraDetallesComprasAgregar=si&codcompra="+codcompra+"&codsucursal="+codsucursal);  
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
		setTimeout("location.href='compras'", 5000);	
									
						});
					}
				}
			});
			return false;
		     }
		}
	    /* form submit */	
     });    
});
/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A COMPRAS */	

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PAGOS A CREDITOS DE COMPRAS */	 	 
$('document').ready(function()
{ 
    /* validation */
	$("#savepagocompra").validate({
          rules:
	     {
			formaabono: { required: true },
			montoabono: { required: true, number : true},
			comprobante: { required: false },
			codbanco: { required: false },
	     },
          messages:
	     {
               formaabono:{ required: "Seleccione Forma Abono" },
			montoabono:{ required: "Ingrese Monto Abono", number: "Ingrese solo digitos con 2 decimales" },
               comprobante:{ required: "Ingrese N Comprobante" },
               codbanco:{ required: "Seleccione Banco" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savepagocompra").serialize();
		var formData = new FormData($("#savepagocompra")[0]);
		var formulario = $('#formulario').val();
		var codproveedor = $('#codproveedor').val();
		var montoabono = $('#montoabono').val();

		if (codcompra=='') {
	            
              swal("Oops", "POR FAVOR SELECCIONE LA FACTURA ABONAR CORRECTAMENTE!", "error");
              return false;
	 
	     } else if (montoabono==0.00 || montoabono=="") {
	            
	         $("#montoabono").focus();
              $('#montoabono').css('border-color','#ff7676');
              swal("Oops", "POR FAVOR INGRESE UN MONTO DE ABONO VALIDO!", "error");
              return false;
	 
	     } else {
				
		$.ajax({
		type : 'POST',
		url  : formulario+'.php',
		//url  : 'cuentasxpagar.php',
	     async : false,
		data : formData,
		//necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
																		
					});
				}    
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL MONTO ABONADO NO PUEDE SER MAYOR AL TOTAL DE FACTURA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
          $('#ModalAbonosCompra').modal('hide');
		$("#savepagocompra")[0].reset();
		$("#BotonBusqueda").trigger("click");
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
								
							});
						}
				     }
				});
				return false;
			}
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PAGOS A CREDITOS DE COMPRAS */




















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE COTIZACIONES */	 	 
$('document').ready(function()
{ 
     /* validation */
	$("#savecotizaciones").validate({
          rules:
	     {
			busqueda: { required: false },
			codcotizacion: { required: true },
			observaciones: { required: false },
			fechacotizacion: { required: true },
	     },
          messages:
	     {
               busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
               codcotizacion:{ required: "Ingrese C&oacute;digo de Cotizaci&oacute;n" },
			observaciones: { required: "Ingrese Observaciones" },
			fechacotizacion:{ required: "Ingrese Fecha de Pedido" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savecotizaciones").serialize();
		var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		var total = $('#txtTotal').val();
	
	     if (total==0.00) {
	            
	         $("#search_busqueda").focus();
              $('#search_busqueda').css('border-color','#ff7676');
              swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA COTIZACION DE PRODUCTOS!", "error");
              return false;
	 
	     } else {
				
		$.ajax({
		type : 'POST',
		url  : 'forcotizacion.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
								
					});
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA COTIZACIONES DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		$("#savecotizaciones")[0].reset();
		$("#muestra_input").html('<i class="fa fa-bars form-control-feedback"></i><select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class="form-control"><option value=""> -- SIN RESULTADOS -- </option></select>');
          $("#codcliente").val("0");
          $("#nrodocumento").val("0");
		$("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
	     $("#lblsubtotal").text("0.00");
		$("#lblsubtotal2").text("0.00");
		$("#lbliva").text("0.00");
          $("#lbldescontado").text("0.00");
		$("#lbldescuento").text("0.00");
		$("#lbltotal").text("0.00");
		$("#txtsubtotal").val("0.00");
		$("#txtsubtotal2").val("0.00");
		$("#txtIva").val("0.00");
          $("#txtdescontado").val("0.00");
	     $("#txtDescuento").val("0.00");
		$("#txtTotal").val("0.00");
		$("#txtTotalCompra").val("0.00");
          $("#loading").html(""); 
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
								
							});
						}
					}
				});
				return false;
			}
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE COTIZACIONES */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE COTIZACIONES */	 
$('document').ready(function()
{ 
     /* validation */
     $("#updatecotizaciones").validate({
          rules:
	     {
			busqueda: { required: false },
			codcotizacion: { required: true },
			observaciones: { required: false },
			fechacotizacion: { required: true },
	     },
          messages:
	     {
               busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
               codcotizacion:{ required: "Ingrese C&oacute;digo de Cotizaci&oacute;n" },
			observaciones: { required: "Ingrese Observaciones" },
			fechacotizacion:{ required: "Ingrese Fecha de Pedido" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#updatecotizaciones").serialize();
          var id= $("#updatecotizaciones").attr("data-id");
          var codcotizacion = $('#codcotizacion').val();
          var codsucursal = $('#codsucursal').val();
				
		$.ajax({
		type : 'POST',
		url  : 'forcotizacion.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_update").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
			     if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
								
					});
				}    
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE COTIZACIONES CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		//$('#detallescotizacionesupdate').load("funciones.php?MuestraDetallesCotizacionesUpdate=si&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal); 
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
		setTimeout("location.href='cotizaciones'", 5000);											
						
						});
					}
				}
			});
			return false;
		}
	    /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE COTIZACIONES */

/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A COTIZACIONES */	 
$('document').ready(function()
{ 
     /* validation */
     $("#agregacotizaciones").validate({
          rules:
	     {
			busqueda: { required: false },
			codcotizacion: { required: true },
			observaciones: { required: false },
			fechacotizacion: { required: true },
	     },
          messages:
	     {
               busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
               codcotizacion:{ required: "Ingrese C&oacute;digo de Cotizaci&oacute;n" },
			observaciones: { required: "Ingrese Observaciones" },
			fechacotizacion:{ required: "Ingrese Fecha de Pedido" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#agregacotizaciones").serialize();
          var id= $("#agregacotizaciones").attr("data-id");
          var codcotizacion = $('#codcotizacion').val();
          var codsucursal = $('#codsucursal').val();
          var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
				
		$.ajax({
		type : 'POST',
		url  : 'forcotizacion.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_agregar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
								
					});
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA COTIZACIONES AL CLIENTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
					});
				}    
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE COTIZACIONES CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		$("#agregacotizaciones")[0].reset();
		$("#muestra_input").html('<i class="fa fa-bars form-control-feedback"></i><select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class="form-control"><option value=""> -- SIN RESULTADOS -- </option></select>');
          $("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
		$("#lblsubtotal").text("0.00");
		$("#lblsubtotal2").text("0.00");
		$("#lbliva").text("0.00");
          $("#lbldescontado").text("0.00");
		$("#lbldescuento").text("0.00");
		$("#lbltotal").text("0.00");
		$("#txtsubtotal").val("0.00");
		$("#txtsubtotal2").val("0.00");
		$("#txtIva").val("0.00");
          $("#txtdescontado").val("0.00");
	     $("#txtDescuento").val("0.00");
		$("#txtTotal").val("0.00");
		$("#txtTotalCompra").val("0.00");
          $("#loading").html(""); 
		$('#detallescotizacionesagregar').load("funciones.php?MuestraDetallesCotizacionesAgregar=si&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal);  
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
		setTimeout("location.href='cotizaciones'", 5000);	
									
						});
					}
				}
			});
			return false;
		}
	    /* form submit */	
     });    
});
/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A COTIZACIONES */	 

/* FUNCION JQUERY PARA PROCESAR COTIZACION A VENTA */	 	 
$('document').ready(function()
{ 
     /* validation */
	$("#procesarcotizacion").validate({
          rules:
	     {
			busqueda: { required: false },
			tipodocumento: { required: true },
			tipopago: { required: true },
			codmediopago: { required: true },
			montopagado: { required: true },
			fechavencecredito: { required: true },
			formaabono: { required: false },
			montoabono: { required: true },
			observaciones: { required: false },
	     },
          messages:
	     {
               busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
			tipodocumento:{ required: "Seleccione Tipo de Documento" },
			tipopago:{ required: "Seleccione Condici&oacute;n de Pago" },
			codmediopago:{ required: "Seleccione Forma de Pago" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			formaabono:{ required: "Seleccione Forma de Abono" },
			montoabono:{ required: "Ingrese Monto Abono" },
			observaciones: { required: "Ingrese Observaciones" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#procesarcotizacion").serialize();
		var TotalPago = $('#txtTotal').val();
		//var MontoPagado = $('#montopagado').val();
		let sumaPagos = 0;
          $("#muestra_condiciones input").map((idx, el) => sumaPagos += +el.value);
          const MontoPagado = sumaPagos;
		var TotalAbono = $('#montoabono').val();
		var CreditoInicial = $('#creditoinicial').val();
		var CreditoDisponible = $('#creditodisponible').val();
		var TipoPago = $('input:radio[name=tipopago]:checked').val();

		if (TotalPago == 0.00) {
	            
               swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA VENTA DE PRODUCTOS!", "error");
               return false;
	 
	     } else if (TipoPago == "CREDITO" && CreditoInicial != "0.00" && parseFloat(TotalPago-TotalAbono) > parseFloat(CreditoDisponible)) {
	            
	         $("#TotalAbono").focus();
              $('#TotalAbono').css('border-color','#ff7676');
              swal("Oops", "SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS EN ESTA SUCURSAL, VERIFIQUE Y CANCELE SUS DEUDAS POR FAVOR!", "error");

              return false;
	 
	     } else if (TipoPago == "CREDITO" && parseFloat(TotalAbono) >= parseFloat(TotalPago)) {
	            
	         $("#TotalAbono").focus();
              $('#TotalAbono').css('border-color','#ff7676');
              swal("Oops", "EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

              return false;
	 
	     } else if (TipoPago == "CONTADO" &&  parseFloat(TotalPago) > parseFloat(MontoPagado.toFixed(2))) {
	            
	          $("#montoabono").focus();
               $('#montoabono').css('border-color','#ff7676');
               swal("Oops", "EL MONTO PAGADO NO PUEDE SER MENOR QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");
               return false;
	 
	     } else {
	 				
		$.ajax({
		type : 'POST',
		url  : 'cotizaciones.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA PROCESAR LA COTIZACION A VENTA, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				} 
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA COTIZACI”N DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}
				else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}  
				else if(data==5){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE COMBOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				} 
				else if(data==6){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HAY STOCK DE PRODUCTOS PARA ORDENAR COMBOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}  
				else if(data==7){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR ASIGNE UN CLIENTE A ESTA VENTA DE CREDITO PARA CONTROL DE ABONOS DEL MISMO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}  
				else if(data==8){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE CREDITO NO PUEDER SER MENOR QUE LA ACTUAL, VERIFIQUE SU CREDITO DISPONIBLE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				} 
				else if(data==9){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> SELECCIONE EL MEDIO DE ABONO A ESTA VENTA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}  
				else if(data==10){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS EN ESTA SUCURSAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}
				else if(data==11){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}
				else if(data==12){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR MONTOS RECIBIDOS EN CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}
				else if(data==13){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LAS FORMAS DE PAGOS NO PUEDEN SER IGUALES, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}
				else if(data==14){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL MONTO PAGADO NO PUEDE SER MAYOR QUE EL TOTAL DE FACTURA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}
				else if(data==15){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL MONTO PAGADO NO PUEDE SER MENOR QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
          $('#myModal').modal('hide');
		$("#procesarcotizacion")[0].reset();
          $("#codcliente").val("0");
          $("#nrodocumento").val("0");
          $("#limitecredito").val("0.00");
          $("#creditoinicial").val("0.00");
          $("#creditodisponible").val("0.00");
          $("#abonototal").val("0.00");
          $("#txtTotal").val("0.00");
          $("#txtPagado").val("0.00");
          $("#TextImporte").text("0.00");
          $("#TextPagado").text("0.00");
          $("#TextCambio").text("0.00");
          $('#TextCliente').text("CONSUMIDOR FINAL");
          $('#TextCredito').text("0.00");
          $("#BotonBusqueda").trigger("click");
          $("#muestra_condiciones").load("condiciones_pagos.php?BuscaCondicionesPagos=si&tipopago=CONTADO&txtTotal=0.00");
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
								
							});
					     }
					}
				});
				return false;
			}
		}
	    /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA PROCESAR COTIZACION A VENTA */





























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PREVENTAS */	 	 
$('document').ready(function()
{ 
     /* validation */
	$("#savepreventas").validate({
          rules:
	     {
			busqueda: { required: false },
			codpreventa: { required: true },
			observaciones: { required: false },
			fechapreventa: { required: true },
	     },
          messages:
	     {
               busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
               codpreventa:{ required: "Ingrese C&oacute;digo de Preventa" },
			observaciones: { required: "Ingrese Observaciones" },
			fechapreventa:{ required: "Ingrese Fecha de Preventa" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savepreventas").serialize();
	     var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
	     var total = $('#txtTotal').val();
	
	     if (total==0.00) {
	            
	          $("#search_busqueda").focus();
               $('#search_busqueda').css('border-color','#ff7676');
               swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA PREVENTA DE PRODUCTOS!", "error");
               return false;
	 
	     } else {
				
		$.ajax({
		type : 'POST',
		url  : 'forpreventa.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
								
					});
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA PREVENTAS DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
																		
					});
				}
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
																		
					});
				}
				else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE COMBOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
																		
					});
				}
				else if(data==5){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HAY STOCK DE PRODUCTOS PARA ORDENAR COMBOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		$("#savepreventas")[0].reset();
          $("#codcliente").val("0");
          $("#nrodocumento").val("0");
		$("#muestra_input").html('<i class="fa fa-bars form-control-feedback"></i><select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class="form-control"><option value=""> -- SIN RESULTADOS -- </option></select>');
          $("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
		$("#lblsubtotal").text("0.00");
		$("#lblsubtotal2").text("0.00");
		$("#lbliva").text("0.00");
          $("#lbldescontado").text("0.00");
		$("#lbldescuento").text("0.00");
		$("#lbltotal").text("0.00");
		$("#txtsubtotal").val("0.00");
		$("#txtsubtotal2").val("0.00");
		$("#txtIva").val("0.00");
          $("#txtdescontado").val("0.00");
		$("#txtDescuento").val("0.00");
		$("#txtTotal").val("0.00");
		$("#txtTotalCompra").val("0.00");
          $("#loading").html(""); 
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button>');
								
							});
						}
				     }
				});
				return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PREVENTAS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PREVENTAS */	 
$('document').ready(function()
{ 
    /* validation */
    $("#updatepreventas").validate({
         rules:
	     {
			busqueda: { required: false },
			codpreventa: { required: true },
			observaciones: { required: false },
			fechapreventa: { required: true },
	     },
          messages:
	     {
               busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
               codpreventa:{ required: "Ingrese C&oacute;digo de Preventa" },
			observaciones: { required: "Ingrese Observaciones" },
			fechapreventa:{ required: "Ingrese Fecha de Preventa" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#updatepreventas").serialize();
          var id= $("#updatepreventas").attr("data-id");
          var codpreventa = $('#codpreventa').val();
          var codsucursal = $('#codsucursal').val();
			
		$.ajax({
		type : 'POST',
		url  : 'forpreventa.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_update").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
								
					});
				}    
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE PREVENTAS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
					});
				}
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
					});
				} 
				else{
								
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		//$('#detallespreventasupdate').load("funciones.php?MuestraDetallesPreventasUpdate=si&codpreventa="+codpreventa+"&codsucursal="+codsucursal); 
		$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
		setTimeout("location.href='preventas'", 5000);											
						
						});
					}
				}
			});
			return false;
		}
	    /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE PREVENTAS */

/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A PREVENTAS */	 
$('document').ready(function()
{ 
    /* validation */
    $("#agregapreventas").validate({
          rules:
	     {
			busqueda: { required: false },
			codpreventa: { required: true },
			observaciones: { required: false },
			fechapreventa: { required: true },
	     },
          messages:
	     {
               busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
               codpreventa:{ required: "Ingrese C&oacute;digo de Preventa" },
			observaciones: { required: "Ingrese Observaciones" },
			fechapreventa:{ required: "Ingrese Fecha de Preventa" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#agregapreventas").serialize();
          var id= $("#agregapreventas").attr("data-id");
          var codpreventa = $('#codpreventa').val();
          var codsucursal = $('#codsucursal').val();
          var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
			
		$.ajax({
		type : 'POST',
		url  : 'forpreventa.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_agregar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
								
					});
				}  
		          else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA PREVENTAS AL CLIENTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
					});
				}   
		          else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
					});
				} 
		          else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE COMBOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
					});
				}  
		           else if(data==5){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HAY STOCK DE PRODUCTOS PARA ORDENAR COMBOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		$("#agregapreventas")[0].reset();
		$("#muestra_input").html('<i class="fa fa-bars form-control-feedback"></i><select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class="form-control"><option value=""> -- SIN RESULTADOS -- </option></select>');
          $("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
		$("#lblsubtotal").text("0.00");
		$("#lblsubtotal2").text("0.00");
		$("#lbliva").text("0.00");
          $("#lbldescontado").text("0.00");
		$("#lbldescuento").text("0.00");
		$("#lbltotal").text("0.00");
		$("#txtsubtotal").val("0.00");
		$("#txtsubtotal2").val("0.00");
		$("#txtIva").val("0.00");
          $("#txtdescontado").val("0.00");
		$("#txtDescuento").val("0.00");
		$("#txtTotal").val("0.00");
		$("#txtTotalCompra").val("0.00");
          $("#loading").html(""); 
		$('#detallespreventasagregar').load("funciones.php?MuestraDetallesPreventasAgregar=si&codpreventa="+codpreventa+"&codsucursal="+codsucursal);  
		$("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
		setTimeout("location.href='preventas'", 5000);	
						
						});
					}
				}
			});
			return false;
		}
	     /* form submit */	
     });    
});
/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A PREVENTAS */	 

/* FUNCION JQUERY PARA PROCESAR PREVENTA A VENTA */	 	 
$('document').ready(function()
{ 
     /* validation */
	 $("#procesarpreventa").validate({
          rules:
	     {
			busqueda: { required: false, },
			tipodocumento: { required: true, },
			tipopago: { required: true, },
			codmediopago: { required: true, },
			montopagado: { required: true, },
			fechavencecredito: { required: true, },
			formaabono: { required: false },
			montoabono: { required: true, },
			observaciones: { required: false, },
	     },
          messages:
	     {
               busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
			tipodocumento:{ required: "Seleccione Tipo de Documento" },
			tipopago:{ required: "Seleccione Condici&oacute;n de Pago" },
			codmediopago:{ required: "Seleccione Forma de Pago" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			formaabono:{ required: "Seleccione Forma de Abono" },
			montoabono:{ required: "Ingrese Monto Abono" },
			observaciones: { required: "Ingrese Observaciones" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#procesarpreventa").serialize();
	     var TotalPago = $('#txtTotal').val();
		let sumaPagos = 0;
          $("#muestra_condiciones input").map((idx, el) => sumaPagos += +el.value);
          const MontoPagado = sumaPagos;
		//var MontoPagado = $('#montopagado').val();
		var TotalAbono = $('#montoabono').val();
		var CreditoInicial = $('#creditoinicial').val();
		var CreditoDisponible = $('#creditodisponible').val();
		var TipoPago = $('input:radio[name=tipopago]:checked').val();

		if (TotalPago == 0.00) {
	            
              swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA VENTA DE PRODUCTOS!", "error");
              return false;
	 
	     } else if (TipoPago == "CREDITO" && CreditoInicial != "0.00" && parseFloat(TotalPago-TotalAbono) > parseFloat(CreditoDisponible)) {
	            
	         $("#TotalAbono").focus();
              $('#TotalAbono').css('border-color','#ff7676');
              swal("Oops", "SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS EN ESTA SUCURSAL, VERIFIQUE Y CANCELE SUS DEUDAS POR FAVOR!", "error");

              return false;
	 
	     } else if (TipoPago == "CREDITO" && parseFloat(TotalAbono) >= parseFloat(TotalPago)) {
	            
	         $("#TotalAbono").focus();
              $('#TotalAbono').css('border-color','#ff7676');
              swal("Oops", "EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

              return false;
	 
	     } else if (TipoPago == "CONTADO" &&  parseFloat(TotalPago) > parseFloat(MontoPagado.toFixed(2))) {
	            
	         $("#montoabono").focus();
              $('#montoabono').css('border-color','#ff7676');
              swal("Oops", "EL MONTO PAGADO NO PUEDE SER MENOR QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");
              return false;
	 
	     } else {
	 				
		$.ajax({
		type : 'POST',
		url  : 'preventas.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA PROCESAR LA PREVENTA A VENTA, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');

					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');

					});
				} 
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA VENTAS DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');

					});
				}
				else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR ASIGNE UN CLIENTE A ESTA VENTA DE CREDITO PARA CONTROL DE ABONOS DEL MISMO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');

					});
				}  
				else if(data==5){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE CREDITO NO PUEDER SER MENOR QUE LA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}   
				else if(data==6){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> SELECCIONE EL MEDIO DE ABONO A ESTA VENTA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				} 
				else if(data==7){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS EN ESTA SUCURSAL, VERIFIQUE SU CREDITO DISPONIBLE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}  
				else if(data==8){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}
				else if(data==9){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR MONTOS RECIBIDOS EN CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}
				else if(data==10){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LAS FORMAS DE PAGOS NO PUEDEN SER IGUALES, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}
				else if(data==11){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL MONTO PAGADO NO PUEDE SER MAYOR QUE EL TOTAL DE FACTURA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}
				else if(data==12){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL MONTO PAGADO NO PUEDE SER MENOR QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
          $('#myModal').modal('hide');
		$("#procesarpreventa")[0].reset();
          $("#codcliente").val("0");
          $("#nrodocumento").val("0");
          $("#limitecredito").val("0.00");
          $("#creditoinicial").val("0.00");
          $("#creditodisponible").val("0.00");
          $("#abonototal").val("0.00");
          $("#txtTotal").val("0.00");
          $("#txtPagado").val("0.00");
          $("#TextImporte").text("0.00");
          $("#TextPagado").text("0.00");
          $("#TextCambio").text("0.00");
          $('#TextCliente').text("CONSUMIDOR FINAL");
          $('#TextCredito').text("0.00");
	     $("#muestra_condiciones").load("condiciones_pagos.php?BuscaCondicionesPagos=si&tipopago=CONTADO&txtTotal=0.00");
		$('#preventas').load("consultas.php?CargaPreventas=si");
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');								
							});
						}
				     }
				});
				return false;
			}
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA PROCESAR PREVENTA A VENTA */



















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CAJAS PARA VENTAS */	 
$('document').ready(function()
{ 
     /* validation */
	$("#savecaja").validate({
          rules:
	     {
			codsucursal: { required: true },
			nrocaja: { required: true },
			nomcaja: { required: true },
			codigo: { required: true },
	     },
          messages:
	     {
               codsucursal:{ required: "Seleccione Sucursal" },
			nrocaja:{ required: "Ingrese N&deg; de Caja" },
               nomcaja:{ required: "Ingrese Nombre de Caja" },
			codigo:{ required: "Seleccione Responsable de Caja" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savecaja").serialize();
          var TipoUsuario = $('#tipousuario').val();
          var Proceso = $('#proceso').val();
		
		$.ajax({
		type : 'POST',
		url  : 'cajas.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
			     if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
					});
				} 
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE N&deg; DE CAJA YA SE ENCUENTRA ASIGNADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				} 
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE NOMBRE DE CAJA YA SE ENCUENTRA ASIGNADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE USUARIO YA TIENE UNA CAJA ASIGNADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		if(Proceso == 'update'){
		$('body').removeClass('modal-open');
		$('#myModalCaja').modal('hide');
	     }
		$("#savecaja")[0].reset();
          $("#proceso").val("save");
		$('#codcaja').val(""); 
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
          if(TipoUsuario == '1'){
               $("#BotonBusqueda").trigger("click");
          } else {
			$('#cajas').html("");		
			$('#cajas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
	          setTimeout(function() {
	               $('#cajas').load("consultas?CargaCajas=si");
	          }, 200);
          }						
						});
					}
				}
			});
			return false;
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CAJAS PARA VENTAS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE ARQUEO DE CAJAS */	 
$('document').ready(function()
{ 
    /* validation */
	$("#savearqueo").validate({
          rules:
	     {
			codsucursal: { required: true },
			codcaja: { required: true },
			fecharegistro: { required: true },
			montoinicial: { required: true, number : true},
	     },
          messages:
	     {
			codsucursal:{ required: "Seleccione Sucursal" },
			codcaja: { required: "Seleccione Caja para Arqueo" },
			fecharegistro:{ required: "Ingrese Hora de Apertura", number: "Ingrese solo digitos" },
			montoinicial:{ required: "Ingrese Monto Inicial", number: "Ingrese solo digitos" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savearqueo").serialize();
          var formulario = $('#formulario').val();
		
		$.ajax({
		type : 'POST',
		url  : formulario+'.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-arqueo").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
	     var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-arqueo").html('<span class="fa fa-save"></span> Guardar');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> YA EXISTE UN ARQUEO DE ESTA CAJA DE COBRO ACTUALMENTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-arqueo").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
          $('#myModalArqueo').modal('hide');
		$("#savearqueo")[0].reset();

		if(formulario == 'pos'){
			$('#muestra_mensaje').html("");
			$('#muestra_mensaje').removeClass('alert alert-danger text-center');
		} else { 
			$('#arqueos').html("");
			$("#btn-arqueo").html('<span class="fa fa-save"></span> Guardar');
			$('#arqueos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			setTimeout(function() {
			 	$('#arqueos').load("consultas?CargaArqueos=si");
			}, 200);
		}//fin else
								
						});
					}
				}
			});
			return false;
		}
	    /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE ARQUEO DE CAJAS */

/* FUNCION JQUERY PARA VALIDAR CERRAR ARQUEO DE CAJAS  */	 
$('document').ready(function()
{ 
     /* validation */
	$("#savecerrararqueo").validate({
          rules:
	     {
			fecharegistro: { required: true, },
			montoinicial: { required: true, number : true},
			dineroefectivo: { required: true, number : true},
			comentarios: { required: false, },
	     },
          messages:
	     {
			fecharegistro:{ required: "Ingrese Hora de Apertura", number: "Ingrese solo digitos" },
			montoinicial:{ required: "Ingrese Monto Inicial", number: "Ingrese solo digitos" },
			dineroefectivo:{ required: "Ingrese Monto en Efectivo", number: "Ingrese solo digitos" },
			comentarios: { required: "Ingrese Observaci&oacute;n de Cierre" },
          },
	     submitHandler: function(form) {
                     		
		var data = $("#savecerrararqueo").serialize();
		var formulario = $('#formulario').val();
		var dineroefectivo = $('#dineroefectivo').val();

          /*if (dineroefectivo==0.00 || dineroefectivo==0) {
            
			$("#dineroefectivo").focus();
			$('#dineroefectivo').val("");
			$('#dineroefectivo').css('border-color','#f0ad4e');
			swal("Oops", "POR FAVOR INGRESE UN MONTO VALIDO PARA EFECTIVO DISPONIBLE EN CAJA!", "error");
               return false;
 
          } else {*/
			
		$.ajax({
		type : 'POST',
		url  : formulario+'.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			var n = noty({
			text: "<span class='fa fa-refresh'></span> PROCESANDO INFORMACI&Oacute;N, POR FAVOR ESPERE......",
			theme: 'defaultTheme',
			layout: 'center',
			type: 'information',
			timeout: 1000, });
			$("#btn-submit").attr('disabled', true);
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").attr('disabled', false);
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR INGRESE UN MONTO VALIDO PARA EFECTIVO DISPONIBLE EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").attr('disabled', false);
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		$("#btn-submit").attr('disabled', false);
		if(formulario == "forcierre"){
		     //$("#btn-cierre").attr('disabled', true);
			setTimeout("location.href='arqueos'", 3000);
		} else {
			$('body').removeClass('modal-open');
			$('#myModalCerrarCaja').modal('hide');
			$("#savecerrararqueo")[0].reset();
			$('#arqueos').load("consultas?CargaArqueos=si");
		}
						
						});
					}
				}
			});
			return false;
			//}
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR CERRAR ARQUEO DE CAJAS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE MOVIMIENTOS EN CAJAS */	 
$('document').ready(function()
{ 
     /* validation */
	$("#savemovimiento").validate({
          rules:
	     {
			codarqueo: { required: true },
			tipomovimiento: { required: true },
			descripcionmovimiento: { required: true },
			montomovimiento: { required: true, number : true },
			codmediopago: { required: true },
	     },
          messages:
	     {
			codarqueo:{ required: "Seleccione Caja" },
               tipomovimiento:{ required: "Seleccione Tipo de Movimiento" },
			descripcionmovimiento:{ required: "Ingrese Descripci&oacute;n de Movimiento" },
			montomovimiento:{ required: "Ingrese Monto de Movimiento", number: "Ingrese solo digitos con 2 decimales" },
			codmediopago:{ required: "Seleccione M&eacute;todo de Pago" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savemovimiento").serialize();
		var monto = $('#montomovimiento').val();

          if (monto==0.00 || monto==0) {
            
			$("#montomovimiento").focus();
			$('#montomovimiento').val("");
			$('#montomovimiento').css('border-color','#ff7676');
			swal("Oops", "POR FAVOR INGRESE UN MONTO VALIDO PARA MOVIMIENTO EN CAJA!", "error");
               return false;

          } else {
			
		$.ajax({
		type : 'POST',
		url  : 'movimientos.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
					
					});
				}  
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR INGRESE UN MONTO VALIDO PARA MOVIMIENTO EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000 });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																		
					});
				}      
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO PUEDE REALIZAR CAMBIO EN EL TIPO Y MEDIO DE MOVIMIENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000 });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																					
					});
				}  
				else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTA CAJA NO SE ENCUENTRA ABIERTA PARA REALIZAR MOVIMIENTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000 });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																					
					});
				} 
				else if(data==5){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL MOVIMIENTO DE EGRESO DEBE DE SER SOLO EFECTIVO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000 });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																					
					});
				}  
				else if(data==6){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL MONTO A RETIRAR EN EFECTIVO NO EXISTE EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000 });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																					
					});
				}  
				else if(data==7){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> ESTE MOVIMIENTO NO PUEDE SER ACTUALIZADO, EL ARQUEO DE CAJA ASOCIADO SE ENCUENTRA CERRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000 });
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																					
					});
				}  
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
          $('#myModalMovimiento').modal('hide');
		$("#savemovimiento")[0].reset();
          $("#proceso").val("save");	
		$('#movimientos').html("");
		$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
		$('#movimientos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
		setTimeout(function() {
		 	$('#movimientos').load("consultas?CargaMovimientos=si");
		}, 200);
									
							});
						}
					}
				});
				return false;
			}		
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE MOVIMIENTOS EN CAJAS */





























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE VENTAS EN POS */	 	 
$('document').ready(function()
{ 
     /* validation */
	$("#savepos").validate({
     rules:
	     {
			busqueda: { required: false },
			tipodocumento: { required: true },
			tipopago: { required: true },
			codmediopago: { required: true },
			montopagado: { required: true },
			fechavencecredito: { required: true },
			formaabono: { required: false },
			montoabono: { required: true },
			observaciones: { required: false },
	     },
          messages:
	     {
               busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
			tipodocumento:{ required: "Seleccione Tipo de Documento" },
			tipopago:{ required: "Seleccione Condici&oacute;n de Pago" },
			codmediopago:{ required: "Seleccione Forma de Pago" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			formaabono:{ required: "Seleccione Forma de Abono" },
			montoabono:{ required: "Ingrese Monto Abono" },
			observaciones: { required: "Ingrese Observaciones" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savepos").serialize();
		var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		var TotalPago = $('#txtTotal').val();
		//var MontoPagado = $('#montopagado').val();
		let sumaPagos = 0;
          $("#muestra_condiciones input").map((idx, el) => sumaPagos += +el.value);
          const MontoPagado = sumaPagos;
		var TotalAbono = $('#montoabono').val();
		var CreditoInicial = $('#creditoinicial').val();
		var CreditoDisponible = $('#creditodisponible').val();
		var TipoPago = $('input:radio[name=tipopago]:checked').val();

		if (TotalPago == 0.00) {
	            
	         $("#search_producto").focus();
              $('#search_producto').css('border-color','#ff7676');
              swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA VENTA DE PRODUCTOS!", "error");

              return false;
	 
	     } else if (TipoPago == "CREDITO" && CreditoInicial > "0.00" && parseFloat(TotalPago-TotalAbono) > parseFloat(CreditoDisponible)) {
	            
	         $("#TotalAbono").focus();
              $('#TotalAbono').css('border-color','#ff7676');
              swal("Oops", "SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS EN ESTA SUCURSAL, VERIFIQUE Y CANCELE SUS DEUDAS POR FAVOR!", "error");

              return false;
	 
	     } else if (TipoPago == "CREDITO" && parseFloat(TotalAbono) >= parseFloat(TotalPago)) {
	            
	         $("#TotalAbono").focus();
              $('#TotalAbono').css('border-color','#ff7676');
              swal("Oops", "EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

              return false;
	 
	     } else if (TipoPago == "CONTADO" &&  parseFloat(TotalPago) > parseFloat(MontoPagado.toFixed(2))) {
	            
	         $("#montoabono").focus();
              $('#montoabono').css('border-color','#ff7676');
              swal("Oops", "EL MONTO PAGADO NO PUEDE SER MENOR QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

              return false;
	 
	     } else {
	 				
		$.ajax({
		type : 'POST',
		url  : 'pos.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA REALIZAR VENTAS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				} 
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA VENTAS DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
				else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				} 
				else if(data==5){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE COMBOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-info"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
				else if(data==6){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HAY STOCK DE PRODUCTOS PARA ORDENAR COMBOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-info"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}  
				else if(data==7){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR ASIGNE UN CLIENTE A ESTA VENTA DE CREDITO PARA CONTROL DE ABONOS DEL MISMO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				} 
				else if(data==8){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE CREDITO NO PUEDER SER MENOR QUE LA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				} 
				else if(data==9){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> SELECCIONE EL MEDIO DE ABONO A ESTA VENTA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}  
				else if(data==10){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS EN ESTA SUCURSAL, VERIFIQUE SU CREDITO DISPONIBLE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}  
				else if(data==11){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
				else if(data==12){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR MONTOS RECIBIDOS EN CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
				else if(data==13){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LAS FORMAS DE PAGOS NO PUEDEN SER IGUALES, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
				else if(data==14){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL MONTO PAGADO NO PUEDE SER MAYOR QUE EL TOTAL DE FACTURA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
				else if(data==15){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL MONTO PAGADO NO PUEDE SER MENOR QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
			     else{
								
			$("#save").fadeIn(1000, function(){
								
		/*$("#save").html('<center> &nbsp; '+data+' </center>');*/
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		$("#savepos")[0].reset();
          $("#codcliente").val("0");
          $("#nrodocumento").val("0");
          $("#busqueda").val("CONSUMIDOR FINAL");
          $('#myModalPago').modal('hide');
	     $("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
		$("#lblsubtotal").text("0.00");
		$("#lblsubtotal2").text("0.00");
		$("#lbliva").text("0.00");
          $("#lbldescontado").text("0.00");
		$("#lbldescuento").text("0.00");
		$("#lbltotal").text("0.00");
          $("#TextImporte").text("0.00");
          $("#TextPagado").text("0.00");
          $("#TextCambio").text("0.00");
          $('#TextCliente').text("CONSUMIDOR FINAL");
          $('#TextCredito').text("0.00");
		$("#txtsubtotal").val("0.00");
		$("#txtsubtotal2").val("0.00");
		$("#txtIva").val("0.00");
          $("#txtdescontado").val("0.00");
		$("#txtDescuento").val("0.00");
		$("#txtTotal").val("0.00");
          $("#txtPagado").val("0.00");
		$("#txtTotalCompra").val("0.00");	
		$("#buttonpago").attr('disabled', true);
          $("#muestra_condiciones").load("condiciones_pagos.php?BuscaCondicionesPagos=si&tipopago=CONTADO&txtTotal=0.00");
          $("#loading").html("");
          $('#loading').load("familias_productos?CargarProductos=si&url=pos"); 
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
								
							});
						}
					}
				});
				return false;
			}
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE VENTAS EN POS */



























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE VENTAS */	 	 
$('document').ready(function()
{ 
    /* validation */
	$("#saveventas").validate({
     rules:
	     {
			busqueda: { required: false },
			tipodocumento: { required: true },
			tipopago: { required: true },
			codmediopago: { required: true },
			montopagado: { required: true },
			fechavencecredito: { required: true },
			formaabono: { required: false },
			montoabono: { required: true },
			observaciones: { required: false },
	     },
          messages:
	     {
               busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
			tipodocumento:{ required: "Seleccione Tipo de Documento" },
			tipopago:{ required: "Seleccione Condici&oacute;n de Pago" },
			codmediopago:{ required: "Seleccione Forma de Pago" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			formaabono:{ required: "Seleccione Forma de Abono" },
			montoabono:{ required: "Ingrese Monto Abono" },
			observaciones: { required: "Ingrese Observaciones" },
          },
	     submitHandler: function(form) {
	   			
	     var data = $("#saveventas").serialize();
		var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		var TotalPago = $('#txtTotal').val();
		let sumaPagos = 0;
          $("#muestra_condiciones input").map((idx, el) => sumaPagos += +el.value);
          const MontoPagado = sumaPagos;
		//var MontoPagado = $('#montopagado').val();
		var TotalAbono = $('#montoabono').val();
		var CreditoInicial = $('#creditoinicial').val();
		var CreditoDisponible = $('#creditodisponible').val();
		var TipoPago = $('input:radio[name=tipopago]:checked').val();

		if (TotalPago == 0.00) {
	            
	          $("#search_producto").focus();
               $('#search_producto').css('border-color','#ff7676');
               swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA VENTA DE PRODUCTOS!", "error");

               return false;
	 
	     } else if (TipoPago == "CREDITO" && CreditoInicial != "0.00" && parseFloat(TotalPago-TotalAbono) > parseFloat(CreditoDisponible)) {
	            
	          $("#montoabono").focus();
               $('#montoabono').css('border-color','#ff7676');
               swal("Oops", "SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS EN ESTA SUCURSAL, VERIFIQUE Y CANCELE SUS DEUDAS POR FAVOR!", "error");

               return false;
	 
	     } else if (TipoPago == "CREDITO" && parseFloat(TotalAbono) >= parseFloat(TotalPago)) {
	            
	          $("#montoabono").focus();
               $('#montoabono').css('border-color','#ff7676');
               swal("Oops", "EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

               return false;
	 
	     } else if (TipoPago == "CONTADO" &&  parseFloat(TotalPago) > parseFloat(MontoPagado.toFixed(2))) {
	            
	          $("#montoabono").focus();
               $('#montoabono').css('border-color','#ff7676');
               swal("Oops", "EL MONTO PAGADO NO PUEDE SER MENOR QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

               return false;
	 
	     } else {
	 				
		$.ajax({
		type : 'POST',
		url  : 'forventa.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA REALIZAR VENTAS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
								
					});
				}   
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				} 
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA VENTAS DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
				else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
				else if(data==5){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE COMBOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				} 
				else if(data==6){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HAY STOCK DE PRODUCTOS PARA ORDENAR COMBOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}  
				else if(data==7){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR ASIGNE UN CLIENTE A ESTA VENTA DE CREDITO PARA CONTROL DE ABONOS DEL MISMO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				} 
				else if(data==8){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> SELECCIONE EL MEDIO DE ABONO A ESTA VENTA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
				else if(data==9){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE CREDITO NO PUEDER SER MENOR QUE LA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}  
				else if(data==10){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS EN ESTA SUCURSAL, VERIFIQUE SU CREDITO DISPONIBLE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}  
				else if(data==11){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
				else if(data==12){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR MONTOS RECIBIDOS EN CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
				else if(data==13){
						
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LAS FORMAS DE PAGOS NO PUEDEN SER IGUALES, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
				else if(data==14){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL MONTO PAGADO NO PUEDE SER MAYOR QUE EL TOTAL DE FACTURA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
				else if(data==15){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL MONTO PAGADO NO PUEDE SER MENOR QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		$("#saveventas")[0].reset();
          $("#codcliente").val("0");
          $("#nrodocumento").val("0");
          $("#busqueda").val("CONSUMIDOR FINAL");
          $("#muestra_input").html('<i class="fa fa-bars form-control-feedback"></i><select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class="form-control"><option value=""> -- SIN RESULTADOS -- </option></select>');
          $('#myModalPago').modal('hide');
		$("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
		$("#lblsubtotal").text("0.00");
	     $("#lblsubtotal2").text("0.00");
		$("#lbliva").text("0.00");
          $("#lbldescontado").text("0.00");
		$("#lbldescuento").text("0.00");
		$("#lbltotal").text("0.00");
          $("#TextImporte").text("0.00");
          $("#TextPagado").text("0.00");
          $("#TextCambio").text("0.00");
          $('#TextCliente').text("CONSUMIDOR FINAL");
          $('#TextCredito').text("0.00");
          $("#montopagado").val("0");
		$("#txtsubtotal").val("0.00");
		$("#txtsubtotal2").val("0.00");
		$("#txtIva").val("0.00");
          $("#txtdescontado").val("0.00");
		$("#txtDescuento").val("0.00");
		$("#txtTotal").val("0.00");
          $("#txtPagado").val("0.00");
		$("#txtTotalCompra").val("0.00");	
		$("#buttonpago").attr('disabled', true);
          $("#muestra_condiciones").load("condiciones_pagos.php?BuscaCondicionesPagos=si&tipopago=CONTADO&txtTotal=0.00");
          $("#loading").html("");
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>'); 
								
							});
						}
					}
				});
				return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE VENTAS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE VENTAS */	 
$('document').ready(function()
{ 
     /* validation */
     $("#updateventas").validate({
     rules:
	     {
			busqueda: { required: false },
			tipodocumento: { required: true },
			tipopago: { required: true },
			codmediopago: { required: true },
			montopagado: { required: false },
			fechavencecredito: { required: true },
			montoabono: { required: false },
	     },
          messages:
	     {
               busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
			tipodocumento:{ required: "Seleccione Tipo de Documento" },
			tipopago:{ required: "Seleccione Condici&oacute;n de Pago" },
			codmediopago:{ required: "Seleccione Forma de Pago" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			montoabono:{ required: "Ingrese Monto Abono" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#updateventas").serialize();
          var id= $("#updateventas").attr("data-id");
          var codventa = $('#codventa').val();
          var codsucursal = $('#codsucursal').val();
			
		$.ajax({
		type : 'POST',
		url  : 'forventa.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_update").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success :  function(data)
		{						
		if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA ACTUALIZAR VENTAS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
								
			});
		} 
		else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL ARQUEO DE CAJA ASOCIADO A ESTA VENTA, SE ENCUENTRA CERRADA, REALICE UNA NUEVA VENTA POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
			});
		}
		else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
			});
		}  
		else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE VENTAS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
			});
		}
		else if(data==5){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
			});
		} 
		else if(data==6){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE COMBOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
			});
		} 
		else if(data==7){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HAY STOCK DE PRODUCTOS PARA ORDENAR COMBOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
			});
		}
		else if(data==8){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS EN ESTA SUCURSAL, VERIFIQUE SU CREDITO DISPONIBLE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																		
			});
		}  
		else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		//$('#detallesventasupdate').load("funciones.php?MuestraDetallesVentasUpdate=si&codventa="+codventa+"&codsucursal="+codsucursal); 
          $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
		setTimeout("location.href='ventas'", 5000);

						});
					}
				}
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE VENTAS */


/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A VENTAS */	 
$('document').ready(function()
{ 
     /* validation */
     $("#agregaventas").validate({
     rules:
	     {
			busqueda: { required: false },
			tipodocumento: { required: true },
			tipopago: { required: true },
			codmediopago: { required: true },
			montopagado: { required: false },
			fechavencecredito: { required: true },
			montoabono: { required: false },
	     },
          messages:
	     {
            busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
			tipodocumento:{ required: "Seleccione Tipo de Documento" },
			tipopago:{ required: "Seleccione Condici&oacute;n de Pago" },
			codmediopago:{ required: "Seleccione Forma de Pago" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			montoabono:{ required: "Ingrese Monto Abono" },
          },
	     submitHandler: function(form) {
	   			
	     var data = $("#agregaventas").serialize();
          var nuevaFila ="<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
          var id= $("#agregaventas").attr("data-id");
          var codventa = $('#codventa').val();
          var codsucursal = $('#codsucursal').val();
	     var TotalPago = $('#txtTotal').val();
	     //var TotalAbono = $('#montoabono').val();
	     var CreditoInicial = $('#creditoinicial').val();
	     var CreditoDisponible = $('#creditodisponible').val();
	     var TipoPago = $('input:radio[name=tipopago]:checked').val();

		if (TotalPago==0.00) {
	            
	         $("#search_producto").focus();
              $('#search_producto').css('border-color','#ff7676');
              swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA VENTA DE PRODUCTOS!", "error");
              return false;
	 
	     } else if (TipoPago=="CREDITO" && CreditoInicial!="0.00" && parseFloat(TotalPago) > parseFloat(CreditoDisponible)) {
	            
	         $("#TotalAbono").focus();
              $('#TotalAbono').css('border-color','#ff7676');
              swal("Oops", "SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS EN ESTA SUCURSAL, VERIFIQUE Y CANCELE SUS DEUDAS POR FAVOR!", "error");
              return false;
	 
	     } else {
				
		$.ajax({
		type : 'POST',
		url  : 'forventa.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_agregar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success :  function(data)
		{						
		if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
          text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA AGREGAR DETALLES A VENTAS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
											
			});
		} 
          else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
          text: "<span class='fa fa-warning'></span> EL ARQUEO DE CAJA ASOCIADO A ESTA VENTA, SE ENCUENTRA CERRADA, REALICE UNA NUEVA VENTA POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
			});
		}
		else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
			});
		}
		else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA VENTAS AL CLIENTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
			});
		}  
		else if(data==5){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
			});
		}  
		else if(data==6){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE COMBOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
			});
		}  
		else if(data==7){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO HAY STOCK DE PRODUCTOS PARA ORDENAR COMBOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
			});
		}
		else if(data==8){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS EN ESTA SUCURSAL, VERIFIQUE SU CREDITO DISPONIBLE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
																		
			});
		}  
		else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 8000, });
		$("#agregaventas")[0].reset();
		$("#muestra_input").html('<i class="fa fa-bars form-control-feedback"></i><select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class="form-control"><option value=""> -- SIN RESULTADOS -- </option></select>');
          $("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
		$("#lblsubtotal").text("0.00");
		$("#lblsubtotal2").text("0.00");
		$("#lbliva").text("0.00");
          $("#lbldescontado").text("0.00");
		$("#lbldescuento").text("0.00");
		$("#lbltotal").text("0.00");
          $("#TextImporte").text("0.00");
          $("#TextPagado").text("0.00");
          $("#txtPagado").val("0.00");
          $("#TextCambio").text("0.00");
		$("#txtsubtotal").val("0.00");
		$("#txtsubtotal2").val("0.00");
		$("#txtIva").val("0.00");
          $("#txtdescontado").val("0.00");
		$("#txtDescuento").val("0.00");
		$("#txtTotal").val("0.00");
	     $("#txtTotalCompra").val("0.00");		 
		$('#detallesventasagregar').load("funciones.php?MuestraDetallesVentasAgregar=si&codventa="+codventa+"&codsucursal="+codsucursal);  
          $("#loading").html("");
          $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button>');
		setTimeout("location.href='ventas'", 5000);

							});
						}
					}
				});
				return false;
			}
		}
	     /* form submit */	
     });    
});
/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A VENTAS */	 





























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PAGOS A CREDITOS POR VENTAS */	 	 
$('document').ready(function()
{ 
    /* validation */
	$("#savepagoventa").validate({
          rules:
	     {
			codcliente: { required: false },
			formaabono: { required: true },
			montoabono: { required: true, number : true},
	     },
          messages:
	     {
               codcliente:{ required: "Por favor seleccione al Cliente correctamente" },
               formaabono:{ required: "Seleccione Forma de Abono" },
			montoabono:{ required: "Ingrese Monto Abono", number: "Ingrese solo digitos con 2 decimales" },
          },
	     submitHandler: function(form) {
	   			
		var data = $("#savepagoventa").serialize();
		var formData = new FormData($("#savepagoventa")[0]);
		var formulario = $('#formulario').val();
		var codcaja = $('#codcaja').val();
		var codcliente = $('#codcliente').val();
		var montoabono = $('#montoabono').val();

		if (codcaja=='') {
	            
             swal("Oops", "POR FAVOR DEBE DE REALIZAR EL ARQUEO DE SU CAJA PARA PROCESAR ABONOS DE CREDITOS!", "error");
             return false;
	 
	     } else if (codcliente=='') {
	            
             swal("Oops", "POR FAVOR SELECCIONE LA FACTURA ABONAR CORRECTAMENTE!", "error");
             return false;
	 
	     } else if (montoabono==0.00) {
	            
	        $("#montoabono").focus();
             $('#montoabono').css('border-color','#ff7676');
             swal("Oops", "POR FAVOR INGRESE UN MONTO DE ABONO VALIDO!", "error");
             return false;
	 
	     } else {
				
		$.ajax({
		type : 'POST',
		url  : formulario+'.php',
		//url  : 'cuentasxpagar.php',
	     async : false,
		data : formData,
		//necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA REALIZARAR COBRO DE CREDITOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
																		
					});
				}    
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
																		
					});
				}    
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> EL MONTO ABONADO NO PUEDE SER MAYOR AL TOTAL DE FACTURA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
          $('#myModalPago').modal('hide');
		$("#savepagoventa")[0].reset();
          $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
		if(formulario == "creditos"){
		    $('#creditos').html("");
	         $('#creditos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
		    setTimeout(function() {
		    $('#creditos').load("consultas?CargaCreditos=si");
		    }, 200);
		} else {
		    $("#BotonBusqueda").trigger("click");
		}
						   });
						}
				     }
				});
				return false;
			}
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PAGOS A CREDITOS DE VENTAS #1 */













































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE NOTA DE CREDITO */	 	 
$('document').ready(function()
{ 
     /* validation */
	$("#savenota").validate({
          rules:
	     {
			numfactura: { required: false },
			fechanota: { required: true },
			observaciones: { required: true},
	     },
          messages:
	     {
	   	     numfactura:{ required: "Ingrese Numero de Factura" },
               fechanota:{ required: "Ingrese Fecha de Nota" },
			observaciones:{ required: "Ingrese Motivo de Nota" },
          },
	     submitHandler: function(form) {
	   			
	     var data = $("#savenota").serialize();
		
		$.ajax({
		type : 'POST',
		url  : 'fornota.php',
	     async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success : function(data)
				{						
				if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA PROCESAR NOTA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}    
				else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}    
				else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> POR FAVOR INGRESE LA CANTIDAD PARA DEVOLUCION DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}      
				else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> NO EXISTE SALDO SUFICIENTE EN CAJA PARA PROCESAR LA NOTA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}  
				else if(data==5){
							
			$("#save").fadeIn(1000, function(){
							
		var n = noty({
          text: "<span class='fa fa-warning'></span> LA CANTIDAD DEVUELTA NO PUEDE SER MAYOR QUE LA CANTIDAD VENDIDA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
          theme: 'defaultTheme',
          layout: 'center',
          type: 'warning',
          timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
					});
				}
				else{
								
			$("#save").fadeIn(1000, function(){
								
		var n = noty({
		text: '<center> '+data+' </center>',
          theme: 'defaultTheme',
          layout: 'center',
          type: 'information',
          timeout: 5000, });
		$("#savenota")[0].reset();
		$("#codarqueo").attr('disabled', false);
          $('#idventa').val("");
          $('#codventa').val("");
          $('#codfactura').val("");
          $('#muestrafactura').html("");
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
										
						});
					}
				}
			});
			return false;
		}
	     /* form submit */
     }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE NOTA DE CREDITO */