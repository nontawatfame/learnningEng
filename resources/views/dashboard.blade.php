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
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{$i}}" aria-expanded="false" aria-controls="flush-collapseOne">
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
                                            </div>
                                            <div class="pb-4 mr-8" style="float: right">
                                                <button class="btn btn-primary"><i class="far fa-edit mr-1"></i> edit</button>
                                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i> delete</button>
                                            </div>
                                        </div>
                                    </div>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
