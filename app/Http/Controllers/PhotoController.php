<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $photos = Photo::all();
      return view('/pages/home',['photos'=>$photos]);
    }

    public function showAll(){
      $photos = Photo::all();
      return view('/pages/photo_list',['photos' => $photos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages/photo_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
  {
    //Criação de um um objeto do tipo Photo
    $photo = new Photo();

    //Alterando os atributos do objeto
    $photo->title = $request->title;
    $photo->date = $request->date;
    $photo->description = $request->description;

    //upload
    if($request->hasFile('photo') && $request->file('photo')->isValid()){

      //Salvando o caminho completo em uma variavel
      $upload = $this->uploadPhoto($request->photo);

      //Dividindo a string em um array
      $directoryArray = explode(DIRECTORY_SEPARATOR,$upload);

      //Adicionando o nome do arquivo ao atributo photo_url
      $photo->photos_url = end($directoryArray);
    }

    if (true){
      //Inserindo no banco de dados
      $photo->save();
    }

    //Redirecionar para a página inicial
    return redirect('/');
  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $photo = Photo::findOrFail($id);
        return view('pages/photo_form',['photo'=>$photo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $photo = Photo::FindOrFail($request->id);

        $photo->title = $request->title;
        $photo->date = $request->date;
        $photo->description = $request->description;

        if($request->hasFile('photo') && $request->file('photo')->isValid()){

          //excluir foto antiga
          $this->deletePhoto($photo->photos_url);

          //realizar o upload da nova foto
          //Salvando o caminho completo em uma variavel
          $upload = $this->uploadPhoto($request->photo);

          //Dividindo a string em um array
          $directoryArray = explode(DIRECTORY_SEPARATOR,$upload);

          //Adicionando o nome do arquivo ao atributo photo_url
          $photo->photos_url = end($directoryArray);


          //Se tudo deu certo, realiza o update
          if ($directoryArray){
            $photo->update();//Alterando no banco de dados
          }

          //Redirecionar Para pagina Inicial
          return redirect('/photos');
        }

      $photo->update();//Alterando no banco de dados

      //Redirecionar Para pagina Inicial
      return redirect('/photos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Retorna a foto do banco de dados
        $photo = Photo::findOrFail($id);

        //Excluir foto do armazenamento
        $this->deletePhoto($photo->photos_url);

        //excluir foto do banco de dados
        $photo->delete();

        //Rediricionar para a pagina de fotos
        return redirect('/photos');
    }

    public function uploadPhoto($photo){
      //Define um nome aleatório para a foto, com base na data e hora atual
      $nomeFoto = sha1(uniqid(date('HisYmd')));
      //Recupera a extensão do arquivo
      $extensao = $photo->extension();
      //Nome do arquivo com extensão
      $nomeArquivo = "{$nomeFoto}.{$extensao}";
      //upload
      $upload = $photo->move(public_path(DIRECTORY_SEPARATOR.'/storage/photos'),$nomeArquivo);
      //retorna o nome do arquivo
      return $upload;

    }

    public function deletePhoto($fileName){
      //Verifica se arquivo existe
      if(file_exists(public_path("storage".DIRECTORY_SEPARATOR."photos".DIRECTORY_SEPARATOR.$fileName))){

        //Excluir o Arquivo de imagem
        unlink(public_path("storage".DIRECTORY_SEPARATOR."photos".DIRECTORY_SEPARATOR.$fileName));


      }
    }

}//fim controller
