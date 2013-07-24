$(document).ready(function(){
	$.ajax({
	  type: 'POST',
	  url: 'cidades.xml',
	  dataType: 'xml',
	  success: function(xml) {
	  	encheCBX(xml);
	 	
	  }
	});

}); 


function encheCBX(xml){
// verifiar METID SE FOR  IGAUL A 0 RETORNA MENSAGEM DE ERRO , SE PÁ COLOCA ERRO NO FILTRO 

	var cidades,cidade, estado , idestado,nomeEstado,nomeCidade,uf,idcidade

	cidades = $(xml).find('cidades');

	$(cidades).each(function() {
		cidade = $(this).find('cidade');
		estado = $(this).find('estado');
	});

	$(estado).each(function(cont) {
		estadoPK 	= $(this).find('cidade').text();
		nomeEstado 	= $(this).find('estado').text();
		uf 			= $(this).find('uf').text();

		$('select#cbx_UF').append('<option value="'+uf+'"">'+ uf +'</option>');
		

	});

	$(cidade).each(function() {
		cidade = $(this).find('cidade').text();
		nomeCidade = $(this).find('estado').text();
		estadoFK = $(this).find('uf').text();
	});
	

	
}