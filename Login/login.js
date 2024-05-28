function doLogin() {
    let usuario = $('#usuario').val();
    let senha = $('#senha').val();
    let dados = {
        usu: usuario,
        sem: senha,
    };

    console.log("Enviando dados:", dados); 

    $.ajax({
        url: 'login.php',
        type: 'POST',
        data: dados,
        success: function(response) {
            console.log("Resposta do servidor:", response); 
            $('#msg').html(response);
        },
        error: function(xhr, status, error) {
            $('#msg').html("Erro: " + xhr.status + " - " + error);
        }
    });
}
