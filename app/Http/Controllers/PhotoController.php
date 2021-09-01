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
    if($request->hasFile('photo') && $request->file('photo')){
      //Define um nome aleatório para a foto, com base na data e hora atual
      $nomeFoto = uniqid(date('HisYmd'));
      //Recupera a extensão do arquivo
      $extensao = $request->photo->extension();
      //Nome do arquivo com extensão
      $nomeArquivo = "{$nomeFoto}.{$extensao}";
      //upload
      $upload = $request->photo->move(public_path('/storage/photos'),$nomeArquivo);
      $photo->photos_url = $nomeArquivo;
    }
    if($upload){
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
        $photo->photos_url = "teste";

        //Alterando no banco de dados
        $photo->update();

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

        //Verifica se arquivo existe
        if(file_exists(public_path("\storage\photos\$photo->photos_url"))){

          //Excluir o Arquivo de imagem
          unlink(public_path("/storage/photos/$photo->photos_url"));

        }

        //Excluir o registro do bd
        $photo->delete();

        //Rediricionar para a pagina de fotos
        return redirect('/photos');
    }
}
