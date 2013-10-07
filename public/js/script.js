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

    $('a.disabled').click(function(event) {
        event.preventDefault();
    });

    /*
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
     */

    $("select#UF").change(function() {
        var uf = $("select#UF option:selected").val();
        $.ajax({
            type: 'POST',
            url: '/cidade/cidadeuf/uf/' + uf,
            dataType: 'json',
            success: function(data) {
                var html = "";
                for (var i in data) {
                    html += "<option>" + "" + data[i].nome + "" + "</option>";
                }
                $("#cidade").html(html);
            }

        });
    });

    $("select#idProduto").change(function() {
        var id = $("select#idProduto option:selected").val();
        $.ajax({
            type: 'POST',
            url: '/produtos/getnomeproduto/idProduto/' + id,
            dataType: 'json',
            success: function(data) {

                $("#vendaPreco").val(data.toFixed(2).replace('.', ','));
            }

        });
    });


    verificaTipoCliente();
    $('input:radio[name=tipo]').click(function() {
        verificaTipoCliente();
    });




    $('#qtde').blur(function() {
        somaIntensProduto();
    });
    $('#vendaPreco').blur(function() {
        somaIntensProduto();
    });

   




});

function somaIntensProduto() {
    var qtde = $('#qtde').val();
    var valor = parseFloat($('#vendaPreco').val().replace(',', '.'));
    var total = qtde * valor;
    $('#total').val(total.toFixed(2).replace('.', ','));
}

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
function Moeda(numbers) {

    numbers = numbers.toFixed(2).replace('.', '');
    var valor = numbers.length;
    numbers = numbers.substring(0, valor - 2) + "," + numbers.substring(valor - 2, valor);
    valor = numbers.length;
    if (valor > 6) {
        numbers = numbers.substring(0, valor - 6) + "." + numbers.substring(valor - 6, valor);
        valor = numbers.length;
        if (valor > 10) {
            numbers = numbers.substring(0, valor - 10) + "." + numbers.substring(valor - 10, valor);
        }
    }
    return  numbers;
}