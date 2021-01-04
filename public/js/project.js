var modalEditVocabularyBoot = new bootstrap.Modal(document.getElementById('edit_vocabulary'), {
    keyboard: false
})

var modalDeleteVocabulary = new bootstrap.Modal(document.getElementById('delete_vocabulary'), {
    keyboard: false
})

var modalCreateList = new bootstrap.Modal(document.getElementById('modal_create_list'), {
    keyboard: false
})

let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

function modalEditVocabulary(id, data) {

    document.getElementById('edit_vocabulary_id').value = id
    document.getElementById('edit_vocabulary_name').value = data.vocabulary_name
    modalEditVocabularyBoot.show()
}

function submitEditVocabulary() {
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
        document.getElementById(`header_vocalbulary_id${id}`).innerText = result.vocabulary_name
        Swal.fire({
            icon: 'success',
            title: 'Save success',
        })
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: error,
        })
    });
}

function deleteVocabulary(vocabulary) {
    console.log(vocabulary)
    modalDeleteVocabulary.show()
    document.getElementById('body_delete_vocabulary').innerText = `Want to delete the ${vocabulary.vocabulary_name}?`
    document.getElementById('delete_vocabulary_btn').setAttribute('onclick',`deleteVocabularyId(${vocabulary.id})`)
}

function deleteVocabularyId(id) {
    fetch(`/delete/vocabulary/${id}`,{
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrf
          },
        method: 'delete',
    })
    .then(res => res.json())
    .then(res => {
        console.log(res)
        console.log(res.id)
        modalDeleteVocabulary.hide()
        Swal.fire({
            icon: 'success',
            title: res.success,
        })
        document.getElementById(`accordion-item-${res.id}`).remove()
    });
}

function openModalCreateList(vocabulary) {
    console.log('ok')
    document.getElementById('create_list_translation').setAttribute('onclick',`createListTranslation(${vocabulary.id})`)
    modalCreateList.show()


}

function createListTranslation(id) {
    console.log('ok', id)
    let translation = document.getElementById('translation_name').value
    console.log(translation)
    fetch('/create_translation',{
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrf
          },
        method: 'post',
        body:
            JSON.stringify({
                'id': id,
                'translation': translation
            })
    })
    .then(res => res.json())
    .then(res => {
        console.log(res)
        // console.log(res.id)
        // modalDeleteVocabulary.hide()
        // Swal.fire({
        //     icon: 'success',
        //     title: res.success,
        // })
        // document.getElementById(`accordion-item-${res.id}`).remove()
    });
}
