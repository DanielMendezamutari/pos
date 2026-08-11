//FUNCION MOSTRAR CARCATERES DE PASSWORD
function MostrarPassword2222(){
    var cambio = document.getElementById("txtPassword");
    if(cambio.type == "password"){
      cambio.type = "text";
      $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }else{
      cambio.type = "password";
      $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    }
  } 
  
  $(document).ready(function () {
  //CheckBox mostrar contraseña
  $('#show_password').click(function () {
    $('#password').attr('type', $(this).is(':checked') ? 'text' : 'password');
  });
});


//FUNCION MOSTRAR CARCATERES DE PASSWORD
function RepitePassword2222(){
    var cambio = document.getElementById("txtPassword2");
    if(cambio.type == "password"){
      cambio.type = "text";
      $('.icon2').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }else{
      cambio.type = "password";
      $('.icon2').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    }
  } 
  
$(document).ready(function () {
  //CheckBox mostrar contraseña
  $('#show_password2').click(function () {
    $('#password2').attr('type', $(this).is(':checked') ? 'text' : 'password');
  });
});


//FUNCION MOSTRAR CARCATERES DE PASSWORD
function MostrarPassword(){
    var cambio = document.getElementById("txtPassword");
    if(cambio.type == "password"){
      cambio.type = "text";
      $('.icon').removeClass('mdi mdi-eye').addClass('mdi mdi-eye-off');
    }else{
      cambio.type = "password";
      $('.icon').removeClass('mdi mdi-eye-off').addClass('mdi mdi-eye');
    }
  } 
  
  $(document).ready(function () {
  //CheckBox mostrar contraseña
  $('#show_password').click(function () {
    $('#password').attr('type', $(this).is(':checked') ? 'text' : 'password');
  });
});


//FUNCION MOSTRAR CARCATERES DE PASSWORD
function RepitePassword(){
    var cambio = document.getElementById("txtPassword2");
    if(cambio.type == "password"){
      cambio.type = "text";
      $('.icon2').removeClass('mdi mdi-eye').addClass('mdi mdi-eye-off');
    }else{
      cambio.type = "password";
      $('.icon2').removeClass('mdi mdi-eye-off').addClass('mdi mdi-eye');
    }
  } 
  
$(document).ready(function () {
  //CheckBox mostrar contraseña
  $('#show_password2').click(function () {
    $('#password2').attr('type', $(this).is(':checked') ? 'text' : 'password');
  });
});
