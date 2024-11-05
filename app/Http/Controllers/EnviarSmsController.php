<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnviarSmsController extends Controller
{
    //Criando função para enviar SMS
    public function enviarsms()
    {
        $usuario = "agcfernandes@yahoo.com.br";
        $senha = urlencode("@Agcf1970");
        $nome = "Cinthia Calixto";
        $celular = "21971435529";
        $mensagem = urlencode("$nome, seu marido está estudando e aprendendo a enviar SMS");

        $url_api = "https://api.iagentesms.com.br/webservices/http.php?metodo=envio&usuario=$usuario&senha=$senha&celular=$celular&mensagem={$mensagem}";
    
        // realiza a requisição http passando os parametros informados
        $api_http = file_get_contents($url_api);

        //Imprime o resultado da requisiçaõ
        echo($api_http); 

    }
}
