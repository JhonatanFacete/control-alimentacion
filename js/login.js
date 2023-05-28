

$(document).ready(function(){
	$(".close").click(function(){
		$(".alert-danger").fadeOut(1000);
	});
});

function Iniciar(){
	
	var user=$("#user");
	var pswd=$("#pswd");
	
	if(user.val()==''){
		Messenger().post({
			message: 'Por favor, escriba un usuario',
			type: 'error',
			showCloseButton: true
		});
		user.focus();
		return false;
	}	
	if(pswd.val()==''){
		Messenger().post({
			message: 'Por favor, escriba su contraseña',
			type: 'error',
			showCloseButton: true
		});
		pswd.focus();
		return false;
	}
	
	
	$(".load").fadeIn('slow');
	$.ajax({
		type:'POST',
		url:'ajax/procesos.php',
		data:{action:'Entrar',user:user.val(),pass:pswd.val()},
		beforeSend:function(){
			$(".alert-danger").hide();
			$(".load").show();
			$(".campo").attr('disabled',true);
		},
		success:function(data){
			$(data).each(function(){
				if(data.estado==1){
					if(data.datos=='OK'){
						document.location="pages/";
					}else{
						$("#mensaje").html(data.datos);
						$(".alert-danger").show();
						
					}
				}else{
					$("#mensaje").html(data.mensaje);
					$(".alert-danger").show();
					
				}
			});
			pswd.val('');
			$(".load").fadeOut(1000);
			$(".campo").attr('disabled',false);
		},
		error:function(){
			pswd.val('');
			$(".load").fadeOut(1000);
			$(".campo").attr('disabled',false);
			$("#mensaje").html('Ocurrió un error inesperado, inténtelo mas tarde.');
			$(".alert-danger").show();
			
		}
	});
	
	
};