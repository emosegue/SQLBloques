

function llamadaAjaxRespuesta() {
    $.ajax({
	url:'respuesta.php?consulta='+document.getElementById('consulta').value ,
	dataType:'json',
	complete: function(data){
	    console.log("fin procesamiento");
	},
	success : function(data) {
	    mostrarRes(data);
	},
	error : function(XMLHttpRequest, textStatus, errorThrown) {
	    console.log(textStatus);
	}
    });
}

function mostrarRes(data){
  var datos=data.salida;

  var modal = document.getElementById('modalrespuesta');
  modal.style.display = "block";

  document.getElementById('respuestasql').innerHTML = document.getElementById('consulta').value;
  document.getElementById('respuesta').innerHTML = datos;    

  var span = document.getElementsByClassName("close")[0];
  span.onclick = function() {
    modal.style.display = "none";
  }
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
}







