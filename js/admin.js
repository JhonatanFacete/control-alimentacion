// JavaScript Document
$(document).ready(function(){
    setInterval(actulizarsesion,600000); //Cada 10 minutos
});

function actulizarsesion(){

	$.ajax({
		type:'POST',
		url:'../ajax/procesos.php',
		data:{action:'RefrescarSesion'},
		success:function(data){
			console.log('Sesion Actualizada');
		}
	});
}

function Cerrar(){

	

	$.ajax({

		type:'POST',

		url:'../ajax/procesos.php',

		data:{action:'Cerrar'},

		success:function(data){

			if(data==1){

				document.location="../";

			}

		},

		error:function(){

			console.log('Ocurrio un error');

		}

	});

	

}