
  //variavel que recebe o elemento html(modal)
  var confirmationModal = document.getElementById('confirmationModal')

  //adiciona um evento, toda vez que o modal for aberto
  confirmationModal.addEventListener('show.bs.modal', function (event) {

    //variavel que recebe o botão que acionou o modal
    var button = event.relatedTarget

    //variavel que recebe o formulário do modal
    var form = document.getElementById('formDeletePhoto')

    //alterando o Action(rota) do formulário
    form.action = "/photos/"+button.getAttribute('data-photo-id')

  })

