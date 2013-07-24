function getdetails(){
	
	input_nome 		= 	$('#input_nome').val();
	input_login 	=	$('#input_login').val();
	input_senha 	=	$('#input_senha').val();
	cbx_tp_usuario	=	$('#cbx_tp_usuario').val();

	$.ajax({
		type: "POST",
		url: "usuario.php",
		data: {nome:input_nome, login:input_login, senha:input_senha, tp:cbx_tp_usuario}
		}).done(function( result ) {
			alert(result);
		});
}




// função para criar objeto XML
function cadastraUsuarioXML(){
	var input_nome,input_login,input_senha,cbx_tp_usuario;

	var xw = new XMLWriter('UTF-8');
	xw.writeStartDocument();
	xw.writeStartElement('XR');
		xw.writeStartElement('NOME');
			xw.writeString(input_nome);
		xw.writeEndElement();
		xw.writeStartElement('LOGIN');
			xw.writeString(input_login);
		xw.writeEndElement();
		xw.writeStartElement('SENHA');
			xw.writeString(input_senha);
		xw.writeEndElement();
		xw.writeStartElement('TPUSU');
			xw.writeString(cbx_tp_usuario);
		xw.writeEndElement();
	xw.writeEndElement();

	var rxml  = xw.flush(); 

	xw.close();
	return rxml;

	
}