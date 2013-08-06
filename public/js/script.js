$(document).ready(function() {// on Load

    $("#btn_usuario_excluir").click(function(event) {
        event.preventDefault();
        if (window.confirm("Deseja excluir este usuario ?")) {
            $.ajax({
                type: 'POST',
                url: '/usuario/delete/idUsuario/'+$("#btn_usuario_excluir").attr("data-id"),
                dataType: 'text',
                success: function(data) {
                    location.reload();
                    alert("O usuario foi deletado");
                }
            });
        }
    });
});