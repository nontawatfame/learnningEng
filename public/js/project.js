var modalEditVocabularyBoot = new bootstrap.Modal(document.getElementById('edit_vocabulary'), {
    keyboard: false
})
function modalEditVocabulary(id, data) {

    document.getElementById('edit_vocabulary_id').value = id
    document.getElementById('edit_vocabulary_name').value = data.vocabulary_name
    modalEditVocabularyBoot.show()
}

function submitEditVocabulary() {
    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    let id = document.getElementById('edit_vocabulary_id').value
    let vocabularyName =  document.getElementById('edit_vocabulary_name').value
    fetch('/edit/vocabulary', {
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrf
          },
        method: 'put',
        body:
            JSON.stringify({
                'id': id,
                'vocabulary_name': vocabularyName
            })
    })
    .then(response => response.json())
    .then(result => {
        console.log('Success:', result);
        modalEditVocabularyBoot.hide()
        document.getElementById(`header_vocalbulary_id${id}`).innerText = vocabularyName
        Swal.fire({
            icon: 'success',
            title: 'Save success',
        })
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function deleteVocabulary(id) {
    console.log(id)
}

