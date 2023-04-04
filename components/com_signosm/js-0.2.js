$( document ).ready(function() {
  $( "#hpeso" ).focus();
  $("#htalla,#hpeso").on('keyup',function (){       
      hpeso=$("#hpeso").val();
      htalla=$("#htalla").val();
      //console.log(hpeso+htalla);
      $("#vIMC").html('<span>Calculando...</span>');
      $.ajax({
        url : '_fnc-imc.php',// la URL para la petición
        data : { peso : hpeso, talla : htalla },// la información a enviar
        type : 'GET',// especifica si será una petición POST o GET
        dataType : 'json',// el tipo de información que se espera de respuesta
        success : function(json) {// código a ejecutar si la petición es satisfactoria;
            console.log(json.val)
            $("#vIMC").html(json.inf);
        },
        error : function(xhr, status) {// código a ejecutar si la petición falla;
            console.log('Disculpe, existió un problema');
        },
        complete : function(xhr, status) {// código a ejecutar sin importar si la petición falló o no
          console.log('Petición realizada');
        }
      });
  });
  
  $(".hpa").on('keyup',function (){       
      hpaS=$("#hpaS").val();
      hpaD=$("#hpaD").val();
      //console.log(hpeso+htalla);
      $("#vPA").html('<span>Calculando...</span>');
      $.ajax({
        url : '_fnc-pa.php',// la URL para la petición
        data : { paS : hpaS, paD : hpaD},// la información a enviar
        type : 'GET',// especifica si será una petición POST o GET
        dataType : 'json',// el tipo de información que se espera de respuesta
        success : function(json) {// código a ejecutar si la petición es satisfactoria;
            console.log("vPA Ret. "+json)
            $("#vPA").html(json.inf);
        },
        error : function(xhr, status) {// código a ejecutar si la petición falla;
            console.log('Disculpe, existió un problema');
        },
        complete : function(xhr, status) {// código a ejecutar sin importar si la petición falló o no
          console.log('Petición realizada');
        }
      });
  });
  function findBus(){
      value = $('#value').text();
      $.ajax({
          type: "GET",
          url: "_fnc-bus.php",
    dataType : 'json',
          success: function(data) {
      console.log(data);
      console.log(data.idp);
              if(data.est==1){
                  window.location.href = 'form.php?idp='+data.idp;
              }
              //$('#value').text(data);
          }
      });
  }
  setInterval(findBus, 10000);
});