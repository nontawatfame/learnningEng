<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="pt-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <form method="POST" action="/add_vocabulary">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Vocabulary</label>
                                <x-input id="vocabulary" class="block mt-1 w-full" type="text" name="vocabulary_name" :value="old('email')" required autofocus autocomplete="off"/>
                            </div>
                            <x-button>add vocabulary</x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        @php
                            $i = 1;
                        @endphp
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            @foreach($vocabularys as $vocabulary)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne{{$i}}">
                                            <button class="accordion-button collapsed" type="button" id="header_vocalbulary_id{{$vocabulary->id}}" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{$i}}" aria-expanded="false" aria-controls="flush-collapseOne">
                                            {{$vocabulary->vocabulary_name}}
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne{{$i}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne{{$i}}" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <input value="Cras justo odio" style="width: 80%"><span style="float:right"><i class="far fa-edit mr-1"></i><i class="far fa-trash-alt"></i></span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <input value="Dapibus ac facilisis in" style="width: 80%"><span style="float:right"><i class="far fa-edit mr-1"></i><i class="far fa-trash-alt"></i></span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <input value="Morbi leo risus" style="width: 80%"><span style="float:right"><i class="far fa-edit mr-1"></i><i class="far fa-trash-alt"></i></span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <input value="Porta ac consectetur ac" style="width: 80%"><span style="float:right"><i class="far fa-edit mr-1"></i><i class="far fa-trash-alt"></i></span>
                                                    </li>
                                                    <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-plus" style="font-size: 15px;color:#696969"></i></a>
                                                </ul>
                                                <div class="pb-4 mr-8 mt-3">
                                                    <button class="btn btn-primary" onclick="modalEditVocabulary({{$vocabulary->id}},{{$vocabulary}})"><i class="far fa-edit mr-1"></i> edit</button>
                                                    <button class="btn btn-danger" onclick="deleteVocabulary({{$vocabulary->id}})"><i class="far fa-trash-alt"></i> delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                        <div class="modal fade" id="edit_vocabulary" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Edit vocabulary</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">vocabulary_name</span>
                                        <input type="text" class="form-control" id="edit_vocabulary_id" hidden >
                                        <input type="text" class="form-control" id="edit_vocabulary_name" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                      </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary" onclick="submitEditVocabulary()">Save</button>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="modal fade" id="delete_vocabulary" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  ...
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
