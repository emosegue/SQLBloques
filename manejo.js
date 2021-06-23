

function llamadaAjax() {
    $.ajax({
	url:'armado.php?tabla='+document.getElementById('tabla').value ,
	dataType:'json',
	complete: function(data){
	    console.log("fin procesamiento");
	},
	success : function(data) {
	    defBloque(data);
	},
	error : function(XMLHttpRequest, textStatus, errorThrown) {
	    console.log(textStatus);
	}
    });
}

function defBloque(data){
  var t=data.tabla;
  Blockly.Blocks["tabla"] = {
      init: function() {
        this.jsonInit(t);
      }
  };
  var cant=data.cant;
  var i;
  for(i=0;i<cant;i++){
    let d=data['a'+i]['datos'];
    Blockly.Blocks['a'+i] = {
	init: function() {
	  this.jsonInit(d);
        }
    };
  }
  var categ = document.getElementById('tab');
  var cadena="<block type='tabla'></block>";
  for(var i=0;i<cant;i++){
    let nombre='a'+i;
    cadena=cadena+"<block type="+nombre+"></block>";
  }
  categ.innerHTML= cadena;

  var menu = document.getElementById('toolbox');
  demoWorkspace.updateToolbox(menu);
  demoWorkspace.clear();
}

