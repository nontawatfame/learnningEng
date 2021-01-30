<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Random Eng') }}
        </h2>
    </x-slot>
    <div class="pt-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                            <div class="flex justify-between">
                                <div class="flex space-x-4 lgp:flex-col lgp:space-x-0 lgp:space-y-2">
                                    <x-button class="shadow-sm" onclick="randomEng()">Random vocabulary</x-button>
                                    <div class="flex">
                                        <span class="my-auto bg-gray-400 p-1 rounded-l-lg text-white px-2 cursor-pointer select-none" id="operator" onclick="switchType(this)" data-type="{{$setting->operator}}">Less than <i class="fas fa-angle-down"></i></span>
                                        <input type="text" id="valueGuess" maxlength="2" value="{{$setting->value}}" class="w-16 h-8 my-auto border-gray-200 rounded-none border-r-0 focus:ring-0 focus:border-gray-200" >
                                        <div class="flex flex-col my-auto">
                                            <button onclick="buttonIncrement()" id="buttonIncrement" class="w-5 h-4 border-gray-200 border-solid border-1 text-gray-400 rounded-tr-lg leading-3 focus:outline-none active:bg-gray-200 active:text-gray-100">+</button>
                                            <button onclick="buttonDecrement()" id="buttonDecrement" class="w-5 h-4 border-gray-200 border-solid border-1 text-gray-400 rounded-br-lg leading-3 focus:outline-none active:bg-gray-200 active:text-gray-100">-</button>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <span class="my-auto p-1 rounded-lg text-white px-2 cursor-pointer select-none w-28" id="typeGuess" onclick="switchTypeKnow(this)" data-type="{{$setting->type_guess}}">
                                            <div class="flex justify-between">Know <div class="pt-0.5"><i class="fas fa-angle-down"></i></div></div>
                                        </span>
                                    </div>
                                </div>
                                <span id="total_guess" class="w-16 text-white text-2xl bg-indigo-500 text-center p-2 rounded-2xl shadow-sm lgp:h-12">0/10</span>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-row space-x-1.5">
            <div class="bg-white p-6 overflow-hidden shadow-sm rounded-xl flex flex-col text-center">
                <p class="text-white text-2xl bg-yellow-400 p-2 rounded-xl" id="numAll">{{$numAll}}</p>
                <p class="text-yellow-700 text-base">Guess all day now</p>
            </div>
            <div class="bg-white p-6 overflow-hidden shadow-sm rounded-xl flex flex-col text-center">
                <p class="text-white text-2xl bg-green-400 p-2 rounded-xl" id="knowAll">{{$knowAll}}</p>
                <p class="text-green-700 text-base">Guess know day now</p>
            </div>
            <div class="bg-white p-6 overflow-hidden shadow-sm rounded-xl flex flex-col text-center">
                <p class="text-white text-2xl bg-red-400 p-2 rounded-xl" id="dontKnowAll">{{$dontKnowAll}}</p>
                <p class="text-red-700 text-base">Guess don't know day now</p>
            </div>
        </div>
    </div>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        @php
                            $i = 1;
                        @endphp
                        <div class="accordion accordion-flush" id="accordionFlushExample" onchange="console.log('ok')">
                                @foreach($vocabularys as $vocabulary)
                                        @php
                                        $our = $vocabulary->our()->where('user_id','=',Auth::user()->id)->first();
                                        @endphp
                                        <div class="accordion-item" id="accordion-item-{{$vocabulary->id}}">
                                            <h2 class="accordion-header" id="flush-headingOne{{$i}}">
                                                <button class="accordion-button collapsed" type="button" id="header_vocalbulary_id{{$vocabulary->id}}" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{$i}}" aria-expanded="false" aria-controls="flush-collapseOne">
                                                {{$vocabulary->vocabulary_name}}
                                                <span class="bg-green-400 rounded-3xl w-8 ml-2 p-1 text-white font-sans font-bold shadow-sm text-center">{{$our === null ? 0: $our->know}}</span>
                                                <span class="bg-red-400 rounded-3xl w-8 ml-1 p-1 text-white font-sans font-bold shadow-sm text-center">{{$our === null ? 0: $our->dont_know}}</span>
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne{{$i}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne{{$i}}" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <div id="list-vocabulary-id{{$vocabulary->id}}">
                                                        @if($vocabulary->translation->count() === 0)
                                                            <div id="hr" style="border-bottom: 1px solid #e8e7e7;"></div>
                                                        @else
                                                            @foreach($vocabulary->translation as $translation)
                                                                <li class="list-group-item" id="translation_{{$translation->id}}">
                                                                    {{$translation->name}}<span style="float:right"><i class="far fa-edit mr-1 cursor-pointer-fa" onclick="modalEditTranslation(this,{{$translation->id}})"></i><i class="far fa-trash-alt cursor-pointer-fa" onclick="modalDeletTranslation(this,{{$translation->id}})"></i></span>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <p class="list-group-item-add list-group-item-action" onclick="openModalCreateList({{$vocabulary}})" ><i class="fas fa-plus" style="font-size: 15px;color:#696969"></i></p>
                                                    <div class="pb-4 mt-3 flex justify-between">
                                                        <div>
                                                            <button type="button" class="btn bg-green-500 text-white hover:bg-green-600 focus:outline-none focus:ring-4 focus:ring-green-300" onclick="incrementKnow(`{{$vocabulary->id}}`)">Know</button>
                                                            <button type="button" class="btn bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-4 focus:ring-red-300" onclick="incrementDontKnow(`{{$vocabulary->id}}`)">Don't know</button>
                                                        </div>
                                                        <button type="button" class="btn bg-gray-100 text-blue-500 border-gray-200 border-2 hover:bg-gray-200 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-gray-300 shadow-sm" onclick="translateLike(`{{$vocabulary->vocabulary_name}}`)">Translate</button>
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
                                  <h5 class="modal-title" id="title_delete_vocabulary">Delete vocabulary</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="body_delete_vocabulary">
                                    Want to delete the vocabulary test?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button id="delete_vocabulary_btn" type="button" class="btn btn-danger">Delete</button>
                                </div>
                              </div>
                            </div>
                        </div>
                        <x-modal-create-list></x-modal-create-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($errors->any())
        @section('script')
            <script>
                let error = `{{($errors->get('vocabulary_name')[0])}}`;
                console.log(error)
                Swal.fire({
                    icon: 'error',
                    title: error,
                })
            </script>
        @endsection
    @endif
    <script src="{{asset('js/random.js')}}"></script>
</x-app-layout>
