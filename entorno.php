<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SQLBloques</title>
    <script src="blockly/blockly_compressed.js"></script>
    <script src="javascript_compressed.js"></script>
    <script src="blockly/blocks_compressed.js"></script>
    <script src="blockly/msg/js/en.js"></script>
    <script src="jquery-3.3.1.min.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css">
  </head>

  <body>
    <img src="sqlbloques2.png" style="float: right !important; width:16%;">

  <?php  
    session_start();
    $_SESSION["servidor"]="";
    $_SESSION["usuario"]="";
    $_SESSION["password"]="";
    $_SESSION["base"]="";

    if(isset($_POST["servidor"])){
      $servidor=$_POST["servidor"];
      $servidor2 = strip_tags($servidor);
      $usuario=$_POST["usuario"];
      $usuario2 = strip_tags($usuario);
      $pass=$_POST["password"];
      $pass2 = strip_tags($pass);
      $base=$_POST["base"];
      $base2 = strip_tags($base);

      $_SESSION["servidor"]=$servidor2;
      $_SESSION["usuario"]=$usuario2;
      $_SESSION["password"]=$pass2;
      $_SESSION["base"]=$base2;
    
      $conexion_db = mysqli_connect($servidor2,$usuario2,$pass2,$base2);
    }else{
      $conexion_db = mysqli_connect("localhost","root","root","club");
    }

    if(mysqli_connect_errno()){
 	    echo "<p>Se produjo un fallo en la conexión. Ingrese los parámetros nuevamente. </p>";
	    echo "<a href='parametros.php' class='boton;'>Volver</a>";
            echo "<br><br>";
    }else{

	    $restablas=mysqli_query($conexion_db,"SHOW TABLES");
	    echo "<div class='algo'>";
	    echo "<div>";
	    echo "<b>Seleccione una tabla:</b>";
	    echo "<form name='formselect'>";
	    echo "<select name='select' id='tabla' required>";
	    $tablas=array();
	    echo "<option value='' selected hidden>-- Elegir Tabla --</option>";
	    while ($col = mysqli_fetch_array( $restablas,MYSQLI_NUM )){
	      echo "<option value='".$col[0]."'>".$col[0]."</option>";
	      array_push($tablas,$col[0]);
	    }
	    echo "</select>";
	    echo "<input type='button' id='tabla' onclick='llamadaAjax()' value='Seleccionar'></input>";
	    echo "</form>";
	    echo "</div>";
    
  ?>

  <div class="traducir">
    <input class="btntraducir" type='button' id='trad' onclick='traducir()' value='Traducir'></input>
    <form name='formselect'>
      <input type='text' id='consulta' style="visibility:hidden; padding:0px;"></input>
    </form >
  </div>
  </div>
<?php  
  }
?>

  <div id="blocklyDiv" style="height: 580px; width: 100%;"></div>

  <xml id="toolbox" style="display: none">
    <category name="Instrucciones">
      <block type="select"></block>
      <block type="delete"></block>
      <block type="insert"></block>
      <block type="update"></block>
      <block type="ins"></block>
    </category>
    <category name="Tabla/Atributos" id="tab">
    </category>
    <category name="Condiciones">
      <block type="and"></block>
      <block type="or"></block>
      <block type="not"></block>
      <block type="igual"></block>
      <block type="menor"></block>
      <block type="mayor"></block>
    </category>
    <category name="Valores" id="valores">
      <block type="numero"></block>
      <block type="string"></block>
    </category>
  </xml>

  <div id="modalrespuesta" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <div class="center" id="respuestasql"></div>
	<br>
      <div class="tablecenter" id="respuesta"></div>
    </div>
  </div>

  <script src='manejoRespuesta.js'></script>
  <script src='manejo.js'></script>

  <script>

    Blockly.Blocks['delete'] = {
      init: function() {
	this.jsonInit({
	  "type": "delete",
	  "message0": "Borrar de %1 %2 donde %3 %4",
	  "args0": [
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "from",
	      "check": "Tabla"
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "where",
	      "check": "condicion"
	    }
	  ],
	  "inputsInline": true,
	  "colour": 10,
	  "tooltip": "",
	  "helpUrl": ""
	});
      }
    };
    Blockly.Blocks['select'] = {
      init: function() {
	this.jsonInit({
	  "type": "select",
	  "message0": "Seleccionar %1 %2 de %3 %4 donde %5 %6",
	  "args0": [
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "select",
	      "check": "atributo"
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "from",
	      "check": "Tabla"
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "where",
	      "check": "condicion"
	    }
	  ],
	  "inputsInline": true,
	  "colour": 35,
	  "tooltip": "",
	  "helpUrl": ""
	});
      }
    };

    Blockly.Blocks['update'] = {
      init: function() {
	this.jsonInit({
	  "type": "update",
  	  "message0": "Actualizar %1 %2 datos: %3 %4 donde %5 %6",
	  "args0": [
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "update",
	      "check": "Tabla"
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "a",
	      "check": "ins"
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "where",
	      "check": "condicion"
	    }
	  ],
	  "inputsInline": true,
	  "colour": 290,
	  "tooltip": "",
	  "helpUrl": ""
	});
      }
    };

/*    Blockly.Blocks['update'] = {
      init: function() {
	this.jsonInit({
	  "type": "update",
	  "message0": "Actualizar %1 %2 con %3 %4 = %5 %6 donde %7 %8",
	  "args0": [
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "update",
	      "check": "Tabla"
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "a",
	      "check": "atributo"
	    },
	    {
	      "type": "input_dummy",
	      "align": "RIGHT"
	    },
	    {
	      "type": "input_statement",
	      "name": "b",
	      "check": [
		"Number",
		"String"
	      ]
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "where",
	      "check": "condicion"
	    }
	  ],
	  "inputsInline": true,
	  "colour": 280,
	  "tooltip": "",
	  "helpUrl": ""
	});
      }
    };*/
    Blockly.Blocks['insert'] = {
      init: function() {
	this.jsonInit({
	  "type": "insert",
	  "message0": "Insertar en %1 %2 atributo/s: %3 %4  valor/es: %5 %6",
	  "args0": [
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "insert into",
	      "check": "Tabla"
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "atributos",
	      "check": "atributo"
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "valores",
	      "check": [
		"Number",
		"String"
	      ]
	    }
	  ],
	  "inputsInline": true,
	  "colour": 330,
	  "tooltip": "",
	  "helpUrl": ""
	});
      }
    };
    Blockly.Blocks['insert1'] = {
      init: function() {
	this.jsonInit({
	  "type": "insert",
	  "message0": "Insertar en %1 %2 ->atributo: %3 %4  valor: %5 %6",
	  "args0": [
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "insert into",
	      "check": "Tabla"
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "atributos",
	      "check": "atributo"
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "valores",
	      "check": [
		"Number",
		"String"
	      ]
	    }
	  ],
	  "inputsInline": true,
	  "nextStatement": "ins",
	  "colour": 330,
	  "tooltip": "",
	  "helpUrl": ""
	});
      }
    };
    Blockly.Blocks['ins'] = {
      init: function() {
	this.jsonInit({
	  "type": "ins",
	  "message0": "->atributo: %1 %2  valor: %3 %4",
	  "args0": [
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "atributos",
	      "check": "atributo"
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "valores",
	      "check": [
		"Number",
		"String"
	      ]
	    }
	  ],
	  "inputsInline": true,
	  "previousStatement": "ins",
	  "nextStatement": "ins",
	  "colour": 290,
	  "tooltip": "",
	  "helpUrl": ""
	});
      }
    };


    Blockly.Blocks['and'] = {
      init: function() {
	this.jsonInit({
	  "type": "condicion",
	  "message0": "( %1 %2 y %3 %4 )",
	  "args0": [    {      "type": "input_dummy"    },
	    {
	      "type": "input_statement",
	      "name": "a",
	      "check": "condicion"
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "b",
	      "check": "condicion"
	    }
	  ],
	  "inputsInline": false,
	  "previousStatement": "condicion",
	  "colour": 230,
	  "tooltip": "",
	  "helpUrl": ""
	});
      }
    };
    Blockly.Blocks['or'] = {
      init: function() {
	this.jsonInit({
	  "type": "condicion",
	  "message0": "( %1 %2 o %3 %4 )",
	  "args0": [
    {      "type": "input_dummy"    },	    {
	      "type": "input_statement",
	      "name": "a",
	      "check": "condicion"
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "b",
	      "check": "condicion"
	    }
	  ],
	  "inputsInline": false,
	  "previousStatement": "condicion",
	  "colour": 230,
	  "tooltip": "",
	  "helpUrl": ""
	});
      }
    };
    Blockly.Blocks['not'] = {
      init: function() {
	this.jsonInit({
	  "type": "condicion",
	  "message0": "no %1 %2",
	  "args0": [
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "a",
	      "check": "condicion"
	    }
	  ],
	  "previousStatement": "condicion",
	  "colour": 230,
	  "tooltip": "",
	  "helpUrl": ""
	});
      }
    };
    Blockly.Blocks['igual'] = {
      init: function() {
	this.jsonInit({
	"type": "condicion",
	  "message0": "( %1 %2 = %3 %4 )",
	  "args0": [    {      "type": "input_dummy"    },
	    {
	      "type": "input_statement",
	      "name": "a",
	      "check": [
		"atributo"	      ]
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "b",
	      "check": [
		"Number",
		"String"
	      ]
	    }
	  ],
	  "previousStatement": "condicion",
	  "colour": 230,
	  "tooltip": "",
	  "helpUrl": ""
	});
      }
    };
    Blockly.Blocks['menor'] = {
      init: function() {
	this.jsonInit({
	  "type": "condicion",
	  "message0": "( %1 %2 < %3 %4 )",
	  "args0": [    {      "type": "input_dummy"    },
	    {
	      "type": "input_statement",
	      "name": "a",
	      "check": [
		"atributo"
	      ]
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "b",
	      "check": [
		"Number",
		"String"
	      ]
	    }
	  ],
	  "inputsInline": false,
	  "previousStatement": "condicion",
	  "colour": 230,
	  "tooltip": "",
	  "helpUrl": ""
	});
      }
    };
    Blockly.Blocks['mayor'] = {
      init: function() {
	this.jsonInit({
	  "type": "condicion",
	  "message0": "( %1 %2 > %3 %4 )",
	  "args0": [    {      "type": "input_dummy"    },
	    {
	      "type": "input_statement",
	      "name": "a",
	      "check": [
		"atributo"
	      ]
	    },
	    {
	      "type": "input_dummy"
	    },
	    {
	      "type": "input_statement",
	      "name": "b",
	      "check": [
		"Number",
		"String"
	      ]
	    }
	  ],
	  "inputsInline": false,
	  "previousStatement": "condicion",
	  "colour": 230,
	  "tooltip": "",
	  "helpUrl": ""
	});
      }
    };

    Blockly.Blocks['numero'] = {
      init: function() {
	this.jsonInit({
	  "type": "numero",
	  "message0": "%1",
	  "args0": [
	    {
	      "type": "field_number",
	      "name": "a",
	      "value": 0
	    }
	  ],
	  "previousStatement": [
	    "Number",
	    "String"
	  ],
	  "nextStatement": [
	    "Number",
	    "String"
	  ],
	  "colour": 60,
	  "tooltip": "",
	  "helpUrl": ""
	});
      }
    };

    Blockly.Blocks['string'] = {
      init: function() {
	this.jsonInit({
          "type": "string",
          "message0": "%1",
          "args0": [
            {
              "type": "field_input",
              "name": "a",
              "text": "texto"
            }
          ],
          "previousStatement": [
            "String",
            "Number"
          ],
          "nextStatement": [
            "String",
            "Number"
          ],
          "colour": 60,
          "tooltip": "",
          "helpUrl": ""
        });
      }
    };

    var demoWorkspace = Blockly.inject('blocklyDiv',
        {media: 'blockly/media/',
	sounds: false,
//	maxInstances: {'select': 1},
//	maxInstances:
	//	{type1:"select",maxBlocksType1:2},
        toolbox: document.getElementById('toolbox')});


  function traducir(){
    var w=demoWorkspace.getAllBlocks(true);
    sel=demoWorkspace.getBlocksByType('select').length;
    ins=demoWorkspace.getBlocksByType('insert').length;
    del=demoWorkspace.getBlocksByType('delete').length;
    upd=demoWorkspace.getBlocksByType('update').length;
    if(sel+del+upd+ins==1){
      if(w[0].allInputsFilled()){
        var tex=w[0].getFieldValue();
        var salida="";
        switch(tex){
          case "Seleccionar":
            salida=select(w[0]);
            break;
          case "Borrar de":
            salida=delete_from(w[0]);
            break;
          case "Insertar en":
            salida=insert(w[0]);
            break;
          case "Actualizar":
            salida=update(w[0]);
            break;
          default:
            error=mensajeError(99995); 
            alert(error); 
            exit;
        }
        var cons = document.getElementById('consulta');
        cons.value=salida;
        llamadaAjaxRespuesta();
      }else{
        error=mensajeError(99994); 
    //e=demoWorkspace.remainingCapacityOfType('select',true);
        alert(error); 
        exit;
      }
    }else{
      if(sel+del+upd+ins>1){
        alert("Error: Sólo se admite una instrucción"); 
      } else {
        alert("Error: Debe elegirse una instrucción"); 
      }
    }
  }

function select(w){
  salida="SELECT ";
  var hijos=w.getChildren(true);
  var atr=hijos[0];
  salida=salida+atr.getFieldValue();
  while(atr.getNextBlock()!=null){
    atr=atr.getNextBlock();
    salida=salida+', '+atr.getFieldValue();
    }
  salida=salida+' FROM ';
  var tab=hijos[1];
  salida=salida+tab.getFieldValue();
  salida=salida+' WHERE ';
  var cond=hijos[2];
  salida=salida+condicion(cond);
  return salida;
} 

function condicion(cond){
  var hijos=cond.getChildren(true);
  var salida="";
  var sign="";
      switch (cond.type){
      case "menor":
      sign="<";

      break;      case "mayor":
      sign=">";
      break;
      case "igual":
      sign="=";
      break;
      case "or":
      sign="OR";
      break;
      case "and":
      sign="AND";
      break;
      }
      if(hijos[0].type!="and" & hijos[0].type!="or" & hijos[0].type!="not" & hijos[0].type!="igual" & hijos[0].type!="menor" & hijos[0].type!="mayor"){
    salida=salida+"("+hijos[0].getFieldValue();
    if(hijos[0].getNextBlock()!=null){
      error=mensajeError(99991); 
      alert(error); 
      exit;
    }

      salida=salida+" "+sign+" ";
    var comilla=(hijos[1].type=="string")? ("'") : ("");
    salida=salida+comilla+hijos[1].getField("a").getText()+comilla+")";
    if(hijos[1].getNextBlock()!=null){
      alert("Error: cantidad incorrecta de valores.");
      exit;
    }
  }else{
    if(hijos[1]==null){
      salida=salida+"NOT";
      salida=salida+condicion(hijos[0]);
    }else{
      salida=salida+"("+condicion(hijos[0]);
      
      salida=salida+" "+sign+" ";//and or
      salida=salida+condicion(hijos[1])+")";
    }
  }
  return salida;
}

function delete_from(w){
  salida="DELETE FROM ";
  var hijos=w.getChildren(true);
  var tab=hijos[0];
  salida=salida+tab.getFieldValue();
  salida=salida+' WHERE ';
  var cond=hijos[1];
  salida=salida+condicion(cond);
  return salida;
}

function insert(w){
  salida="INSERT INTO ";
  var hijos=w.getChildren(true);
  var tab=hijos[0].getFieldValue();
  salida=salida+tab+" ";
  var atr=hijos[1];
  salida=salida+"("+atr.getFieldValue();
  var cantA=1;
  while(atr.getNextBlock()!=null){
    atr=atr.getNextBlock();
    salida=salida+', '+atr.getFieldValue();
    cantA++;
  }
  var val=hijos[2];
  var comilla=(val.type=="string")? ("'") : ("");
  salida=salida+") VALUES ("+comilla+val.getField("a").getText()+comilla;
  var cantV=1;
  while(val.getNextBlock()!=null){
    val=val.getNextBlock();
    var comilla=(val.type=="string")? ("'") : ("");
    salida=salida+", "+comilla+val.getField("a").getText()+comilla;
    cantV++;
  }
  salida=salida+")";
  if(cantA!=cantV){
    error=mensajeError(99993); 
    alert(error); 
    exit;
  }
  return salida;
}

function ins(w){
  var serie=[];
  serie[0]="";	
  serie[1]="";
  while(w!=null){
    var hijos=w.getChildren(true);
    var atr=hijos[0].getFieldValue();
    serie[0]=serie[0]+","+atr;
    var val=hijos[1].getFieldValue();
    serie[1]=serie[1]+","+val;
    w=w.getNextBlock();
  }
  return serie;
}

function update(w){
  salida="UPDATE ";
  var hijos=w.getChildren(true);
  var tab=hijos[0].getFieldValue();
  salida=salida+tab+" set";
  salida=salida+upda(hijos[1]);
  salida=salida+' where ';
  var cond=hijos[2];
  salida=salida+condicion(cond);
  return salida;
}

function upda(w){
  var resultado="";
  while(w!=null){
    var hijos=w.getChildren(true);
    var atr=hijos[0].getFieldValue();
    if(hijos[0].getNextBlock()!=null){
      error=mensajeError(99991); 
      alert(error); 
      exit;
    }
    var comilla=(hijos[1].type=="string")? ("'") : ("");
    var val=comilla+hijos[1].getField("a").getText()+comilla;
    if(hijos[1].getNextBlock()!=null){
      alert("Error: cantidad incorrecta de valores.");
      exit;
    }
    resultado=resultado+" "+atr+"="+val;
    resultado=(w.getNextBlock()!=null)? (resultado+",") : (resultado);
    w=w.getNextBlock();
  }
  return resultado;
}


function mensajeError(codigo){
  switch(codigo){
    case 99991:
      salida="Error: cantidad incorrecta de atributos.";
      break;
    case 99992:
      $salida="Error: cantidad incorrecta de valores.";
      break;
    case 99993:
      salida="Error: la cantidad de atributos no coincide con la cantidad de valores";	
      break;
    case 99994:
      salida="Error: Faltan bloques";
      break;
    case 99995:
      salida="Error: Instrucción no válida";
      break;
  }
  return salida;
}

//function consultar(s){
  //var re = document.getElementById('consu');
//  re.innerHTML= s;
//console.log(<?php $cons="s"; $res=mysqli_query($conexion_db,$cons);  $im="";  while ($col = mysqli_fetch_array( $res,MYSQLI_NUM )){      $im=$im." ".$col[0]; } echo "'".$cons."'" ?>);
// console.log(<?php echo "'Errormessage: ".mysqli_error($res)."'" ?>);

//}
//    function onchange(event) {
//      document.getElementById('caja').textContent = "f";
//    }
//    demoWorkspace.addChangeListener(onchange);
//    onchange();

    </script>
  </body>
</html>
