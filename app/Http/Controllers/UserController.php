<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\SUpport\Facades\Hash;
use Illuminate\SUpport\Str;

class UserController extends Controller
{
    //Listar os usuários
    public function index() {
        // Recuperar os registros de user
        $users = User::get(); 
       
        return view('users.index',['users'=>$users]);
    }

    public function import(Request $request)
    {
       $request->validate([
        'file' => 'required|mimes:csv,txt|max:2048',
       ],[
        'file.required' => 'O campo arquivo é obrigatório.',
        'file.mimes' => 'Arquivo inválido, necessário enviar arquivo csv',
        'file.max' => 'Tamanho do arquivo excede :max MB'   
        ]);
        
        //Criar array com as colunas do banco
        $headers = ['name','email','password'];

         //Receber o arquivo, ler os dados e converter a string em array
        $datafile = array_map('str_getcsv', file($request->file('file')));

        //Criar variavel para armazenar a quantidade de registros cadastrados
        $numberRegisteredRecords = 0;
        $emailAlreadyRegistered = false; 

        //Percorrer linhas do arquivo csv
        foreach ($datafile as $keyData => $row) {
            
            //Converter linha em array
            $values = explode(';',$row[0]);
       
            // percorrer as colunas do cabeçalho
            foreach ($headers as $key => $header) {
            
                // Atribuir o valor do elemento do array
                $arrayValues[$keyData][$header] = $values[$key];
                
                //verificar se a coluna é o email
                if ($header == "email"){

                    //verifica se o email ja esta cadastrado na base de dados
                    if (User::where('email',$arrayValues[$keyData]['email'])->first()){

                        // atribulir o email na lista de emails ja cadastrados
                        $emailAlreadyRegistered .= $arrayValues[$keyData]['email'].", ";
                    }
                }

                if ($header == "password"){

                   

                    //criptografar senha
                    //$arrayValues[$keyData][$header] = Hash::make($arrayValues[$keyData]['password'],
                    //['rounds'=>12]);
                    $arrayValues[$keyData][$header] = Hash::make(Str:random(7)['rounds'=>12]);
             }


            }
            //soma numero de registros importados
            $numberRegisteredRecords++;
          
        }
       
        if ($emailAlreadyRegistered) {
            //Redireciona usuario para a pagina anterior e envia mensagem de erro
            return back()->with('error','Dados não importados. Existem emails já cadastrados. <br> '.$emailAlreadyRegistered);
        }

        //dd( $numberRegisteredRecords);

        //Cadastrar registros no banco de dados
        User::insert($arrayValues);

        //Redirecionar o usuário para a página anterior e enviar mensagem de sucesso
        return back()->with('success','Dados importados com sucesso. <br> Quantidade: '.$numberRegisteredRecords);

    }
}
