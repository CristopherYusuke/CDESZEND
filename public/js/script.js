$(document).ready(function() {// on Load


    /*
     * 
     $("#btn_usuario_excluir").click(function(event) {
     event.preventDefault();
     if (window.confirm("Deseja excluir este usuario ?")) {
     $.ajax({
     type: 'POST',
     url: '/usuario/delete/idUsuario/' + $("#btn_usuario_excluir").attr("data-id"),
     dataType: 'text',
     success: function(data) {
     location.reload();
     alert("O usuario foi deletado");
     }
     });
     }
     });*/

    $(".datepicker").datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true,
        nextText: 'Próximo',
        prevText: 'Anterior'
    });


    $("select#UF").change(function() {
        var uf = $("select#UF option:selected").val();
        $.ajax({
            type: 'POST',
            url: '/cidade/cidadeuf/uf/' + uf,
            dataType: 'json',
            success: function(data) {
                var html = "";
                for (var i in data) {
                    html += "<option>" +"'"+ data[i].nome +"'"+ "</option>";
                }
                $("#cidade").html(html);
            }

        });
    });
    verificaTipoCliente();
    $('input:radio[name=tipo]').click(function() {
        verificaTipoCliente();
    });
});

function verificaTipoCliente() {
    var tipo = $('input:radio[name=tipo]:checked').val();
    if (tipo == "F") {
        $('#CPF_CNPJ').attr("placeholder", "CPF");
        $("label[for=CPF_CNPJ]").text("CPF");
    } else if (tipo == "J") {
        $('#CPF_CNPJ').attr("placeholder", "CNPJ");
        $("label[for=CPF_CNPJ]").text("CNPJ");
    }
}