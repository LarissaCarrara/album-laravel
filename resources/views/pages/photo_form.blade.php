@extends('/layouts/main')
@section('content')
@include('/partials/navbar')
<div class="container">

<!-- Bnt botão -->
  <div class="row">
    <div class="col-12 my-4">
      <a href="/"><i class="fas fa-arrow-left"></i> Voltar</a>
    </div>
  <!-- Coluna Card form -->
    <div class="col-12">
      <div class="card shadow bg-white rounded">
        <div class="card-header gradient text-white">
          <h2 class="card-title"><i class="fas fa-image"></i> {{ isset($photo) ? 'Alterar foto' : 'Nova foto'}}</h2>
        </div>

        <div class="card-body p-4">
        <!-- Form -->
        @if (isset($photo))
            <form action="/photos/{{$photo->id}}" method="POST">
            @method('PUT')
          @else
            <form action="/photos" method="POST">
          @endif
          @csrf
          <div class="p-md-3">




              <div class="row">
                <div class="col-lg-6">
                  <div class="d-flex flex-column h-100">
                    <div
                      class="miniatura img-thumbnail d-flex flex-column justify-content-center align-items-center h-100 mt-4">
                      <i class="far fa-image"></i>
                      <br>
                      <small>
                      </small>
                    </div>
                    <div class="form-group mt-2">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Nenhum arquivo selecionado</label>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Título -->
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="text">Título</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-image"></i>
                        </div>
                      </div>
                      <input id="title" name="title" type="text" class="form-control" required
                        placeholder="Digite o título da sua imagem" value=" {{$photo->title ?? null}}">
                    </div>
                  </div>

                  <!-- data -->
                  <div class="form-group">
                    <label for="text">Data</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="far fa-calendar-alt"></i>
                        </div>
                      </div>
                      <input id="date" name="date" type="date" class="form-control" required value="{{$photo->date ?? null}}">
                    </div>
                  </div>

                    <!-- descrição -->
                  <div class="form-group">
                    <label for="textarea">Descrição</label>
                    <textarea id="description" name="description" cols="40" rows="5" class="form-control" required
                      placeholder="Digite uma pequena descrição da imagem"> {{$photo->description ?? null}}</textarea>
                  </div>
                  <div class="form-group d-flex">
                    <button name="submit" type="submit" class="btn btn-laranja">Limpar</button>
                    <button name="submit" type="submit" class="btn btn-primary">Salvar</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
