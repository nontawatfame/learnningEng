function modalEditVocabulary(id, data) {
    var modalEditVocabulary = new bootstrap.Modal(document.getElementById('edit_vocabulary'), {
        keyboard: false
    })
    document.getElementById('edit_vocabulary_name').value = data.vocabulary_name
    modalEditVocabulary.show()
}
