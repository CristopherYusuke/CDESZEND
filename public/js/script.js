$(document).ready(function() {// on Load


    $('a.disabled').click(function(event) {
        event.preventDefault();
    });


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
                    html += "<option>" + "" + data[i].nome + "" + "</option>";
                }
                $("#cidade").html(html);
            }

        });
    });



    $('#valorPagar').blur(function() {
        var valor = $('#valor').val();
        var valorPagar = $('#valorPagar').val();
        var valorPago = $('#valorPago').val();
        if (valorPago == '') {
            valorPago = 0;
        }
        valorPago = parseFloat(valorPago);
        valorPago = valorPago.toFixed(2);
        valorPago = valorPago.replace(',', '.');
        valor = valor.replace(',', '.');
        valorPagar = valorPagar.replace(',', '.');
        console.log(valorPago + "\n" + valor + '\n' + valorPagar);
        var restante = ((valor - valorPago) - valorPagar);
        $('#restante').val(restante.toFixed(2));
    });














    $("form.compra  select#idProduto").change(function() {
        var id = $("select#idProduto option:selected").val();
        $.ajax({
            type: 'POST',
            url: '/produtos/getnomeproduto/idProduto/' + id,
            dataType: 'json',
            success: function(data) {
                var pc = 0;
                pc = parseFloat(data.precoCusto);
                $("#compraPreco").val(pc.toFixed(2).replace('.', ','));
            }

        });
    });


    $('form.compra #qtde').blur(function() {
        somaIntensProdutoCompra();
    });
    $('form.compra #compraPreco').blur(function() {
        somaIntensProdutoCompra();

    });








// Venda  comesso --------------------------------

    $("form.venda  select#idProduto").change(function() {
        var id = $("select#idProduto option:selected").val();
        $.ajax({
            type: 'POST',
            url: '/produtos/getnomeproduto/idProduto/' + id,
            dataType: 'json',
            success: function(data) {
                var pc = 0;
                var pv = 0;
                var es = 0;
                es = data.estoque;
                $('#estoque').val(es);
                if (es != 0) {
                    pc = parseFloat(data.precoCusto);
                    pv = parseFloat(data.precoVenda);
                    $('#estoque').val(es);
                    $("#precoCusto").val(pc.toFixed(2).replace('.', ','));
                    $("#vendaPreco").val(pv.toFixed(2).replace('.', ','));
                } else {
                    $("#DivMensagem").append('<div data-alert class="alert-box alert "> este produto não contem mais no estoque <a href="#" class="close">&times;</a></div>');
                }
            }

        });
    });


    $('form.venda #qtde').blur(function() {
        somaIntensProduto();
    });
    $('form.venda #vendaPreco').blur(function() {
        somaIntensProduto();

    });


// Venda Fim --------------------------------


    verificaTipoCliente();
    $('input:radio[name=tipo]').click(function() {
        verificaTipoCliente();
    });

    $('#addIten').click(function() {
        $('#qtde').blur();
    });
});

function somaIntensProduto() {
    var qtde = $('#qtde').val();
    var valor = parseFloat($('form.venda #vendaPreco').val().replace(',', '.'));
    var total = qtde * valor;
    $('form.venda #total').val(total.toFixed(2).replace('.', ','));
}

function somaIntensProdutoCompra() {
    var qtde = $('#qtde').val();
    var valor = parseFloat($('form.compra #compraPreco').val().replace(',', '.'));
    var total = qtde * valor;
    $('form.compra #total').val(total.toFixed(2).replace('.', ','));
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