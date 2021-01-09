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
    document.getElementById('translation_name').setAttribute('data-id-vocabulary', vocabulary.id)
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
        if (res.success) {
            let trans_li = `
                <li class="list-group-item" id="translation_${res.data.id}">
                    ${res.data.name}<span style="float:right"><i class="far fa-edit mr-1 cursor-pointer-fa"></i><i class="far fa-trash-alt cursor-pointer-fa" onclick="modalDeletTranslation(this,${res.data.id})"></i></span>
                </li>
            `
            console.log(trans_li)
            document.getElementById(`list-vocabulary-id${res.id}`).insertAdjacentHTML('beforeend',trans_li)

            Swal.fire({
                icon: 'success',
                title: res.success,
            })
            document.getElementById('translation_name').value = ''
            modalCreateList.hide()
        }
    });
}

function modalDeletTranslation(el, id) {
    console.log(el,id)
    let translationName = document.getElementById(`translation_${id}`).innerText
    document.getElementById('title_delete_vocabulary').innerText = 'Delete translation'
    document.getElementById('body_delete_vocabulary').innerText = `Delete translation ${translationName} ?`
    document.getElementById('delete_vocabulary_btn').setAttribute('onclick',`deleteTranslation(${id})`)
    modalDeleteVocabulary.show()
}

function deleteTranslation(id) {
    console.log(id)
    fetch(`/delete/translation/${id}`,{
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrf
        },
        method: 'delete',
    })
    .then(res => res.json())
    .then(res => {
        console.log(res)
        if (res.success) {
            document.getElementById(`translation_${res.id}`).remove()
            Swal.fire({
                icon: 'success',
                title: res.success,
            })
            modalDeleteVocabulary.hide()
        }
    })
}

document.getElementById('translation_name').addEventListener('keyup', (event) => {
    if (event.which == 13 || event.keyCode == 13) {
        let id = event.srcElement.getAttribute('data-id-vocabulary')
        createListTranslation(id)
    }
})
