<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    @vite('resources/css/app.css')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>

<body class="antialiased" x-data="{ open: false }">

    <nav class="fixed z-10 top-0 flex justify-between items-center px-4 w-full h-14  border-gray-BD bg-blue-400   ">
        <div class="h-full flex items-center gap-4 text-xl">

            <div class="overflow-hidden h-5/6 border-2 rounded-full   ">
                <img class="w-full h-full" src="logo.png" alt="logo">

            </div>
            <div>
                {{ Auth::user()->name; }}
            </div>

        </div>
        <div class="flex gap-4 items-center text-center h-full">
            <button @click="open = true " class="bg-green-600 rounded-lg px-2 py-1 text-sm text-white ">Nueva Tarea</button>
         
            <a href="{{ route('logout') }}" class="h-full hover:bg-blue-200 p-5 flex items-center justify-center" >
                <span>Salir</span>
            </a>

           
           

        </div>
    </nav>

    <div class="w-screen h-screen grid grid-cols-3   pt-20 p-8 gap-6 ">
        <div class="bg-red-400 rounded-lg text-center p-3">
            <span class="text-lg font-extrabold ">Tareas por hacer</span>
            <div id="hacer" class="flex flex-col gap-2 mt-4">
                @foreach ($tareas as $tarea )
                @if($tarea['estado'] == 1)
                <div class="bg-white bg-opacity-75 rounded-lg group overflow-hidden transition duration-300 transform hover:scale-105" data-tarea-id="{{ $tarea['id'] }}">
                    <div class="relative flex items-center justify-center w-full bg-blue-300 font-semibold tarea">
                        <span>{{ $tarea['nombre'] }}</span>
                        <button data-boton="iz" onclick="moverTarea({{ $tarea['id'] }}, -1)" class="hidden absolute left-0 w-12 text-2xl">&#8592;</button>
                        <button data-boton="de" onclick="moverTarea({{ $tarea['id'] }}, 1)" class=" absolute right-1 w-12 text-2xl">&#8594;</button>
                    </div>
                    <p class="font-normal text-left p-2">{{ $tarea['descripcion'] }}</p>
                    <div class="flex justify-between p-2 items-center">
                        <button onclick="eliminar({{ $tarea['id'] }})" class="opacity-0 w-4 h-4 group-hover:opacity-100 transition-opacity duration-300 text-red-600   ">❌</button>
                        <p class="font-semibold text-right text-xs">{{ $tarea['created_at'] }}</p>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>

        <div class="bg-yellow-400 rounded-lg text-center p-3">
            <span class="text-lg font-extrabold ">En proceso</span>
            <div id="proceso" class="flex flex-col gap-2 mt-4">
                @foreach ($tareas as $tarea )
                @if($tarea['estado'] == 2)
                <div class="bg-white bg-opacity-75 rounded-lg group overflow-hidden transition duration-300 transform hover:scale-105" data-tarea-id="{{ $tarea['id'] }}">
                    <div class="relative flex items-center justify-center w-full bg-blue-300 font-semibold tarea">
                        <span>{{ $tarea['nombre'] }}</span>
                        <button data-boton="iz" onclick="moverTarea({{ $tarea['id'] }}, -1)" class="absolute left-0 w-12 text-2xl">&#8592;</button>
                        <button data-boton="de" onclick="moverTarea({{ $tarea['id'] }}, 1)" class=" absolute right-1 w-12 text-2xl">&#8594;</button>
                    </div>
                    <p class="font-normal text-left p-2">{{ $tarea['descripcion'] }}</p>
                    <div class="flex justify-between p-2 items-center">
                        <button onclick="eliminar({{ $tarea['id'] }})" class="opacity-0 w-4 h-4 group-hover:opacity-100 transition-opacity duration-300 text-red-600   ">❌</button>
                        <p class="font-semibold text-right text-xs">{{ $tarea['created_at'] }}</p>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>

        <div class="bg-green-400 rounded-lg text-center p-3">
            <span class="text-lg font-extrabold ">Finalizadas</span>
            <div id="finalizada" class="flex flex-col gap-2 mt-4">
                @foreach ($tareas as $tarea )
                @if($tarea['estado'] == 3)
                <div class="bg-white bg-opacity-75 rounded-lg group overflow-hidden transition duration-300 transform hover:scale-105" data-tarea-id="{{ $tarea['id'] }}">
                    <div class="relative flex items-center justify-center w-full bg-blue-300 font-semibold tarea">
                        <span>{{ $tarea['nombre'] }}</span>
                        <button data-boton="iz" onclick="moverTarea({{ $tarea['id'] }}, -1)" class="absolute left-0 w-12 text-2xl">&#8592;</button>
                        <button data-boton="de" onclick="moverTarea({{ $tarea['id'] }}, 1)" class="hidden absolute right-1 w-12 text-2xl">&#8594;</button>
                    </div>
                    <p class="font-normal text-left p-2">{{ $tarea['descripcion'] }}</p>
                    <div class="flex justify-between p-2 items-center">
                        <button onclick="eliminar({{ $tarea['id'] }})" class="opacity-0 w-4 h-4 group-hover:opacity-100 transition-opacity duration-300 text-red-600   ">❌</button>
                        <p class="font-semibold text-right text-xs">{{ $tarea['created_at'] }}</p>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>


    <div x-show="open" id="authentication-modal" class="fixed top-0 left-0 right-0 z-50 w-full  h-screen flex justify-center items-center bg-black bg-opacity-50">
        <div class="z-40 bg-white rounded-lg shadow dark:bg-gray-700 w-full md:max-w-md">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button @click="open = false" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                        Agregar Tarea
                    </h3>
                    <form class="" method="post" action="{{ route('crear.tarea') }}">

                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                        <label class="block text-sm font-medium text-gray-900 dark:text-white">
                            Titulo<br />
                            <input type="text" name="nombre" class=" border border-gray-300 text-gray-900 text-sm rounded-lgblock w-full p-2.5" placeholder="Titulo" required />
                        </label>

                        <label class="block text-sm font-medium text-gray-900 dark:text-white">
                            Descipcion<br />
                            <textarea required name="descripcion" cols="30" rows="5" class=" border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full p-2.5" placeholder="En que consiste la tarea"></textarea>
                        </label>


                        <button type="submit" class="w-full mt-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center">
                            Crear Tarea
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var message = "{{ session('message') }}";
        if (message.trim() !== "") {

            alert(message);
        }

        function moverTarea(tareaId, nuevoEstado) {
            const tarea = document.querySelector('[data-tarea-id="' + tareaId + '"]')
            $.ajax({
                type: 'put',
                url: 'api/tareas',
                data: {
                    tarea_id: tareaId,
                    nuevo_estado: nuevoEstado,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        if (response.estado === 1) {
                            tarea.querySelector('[data-boton="iz"]').classList.add("hidden")
                            document.querySelector('#hacer').appendChild(tarea);
                        } else if (response.estado === 2) {
                            tarea.querySelector('[data-boton="iz"]').classList.remove("hidden")
                            tarea.querySelector('[data-boton="de"]').classList.remove("hidden")
                            document.querySelector('#proceso').appendChild(tarea);
                        } else if (response.estado === 3) {
                            tarea.querySelector('[data-boton="de"]').classList.add("hidden")
                            document.querySelector('#finalizada').appendChild(tarea);
                        }
                    } else {
                        alert('Hubo un error al actualizar la tarea.');
                    }
                },
                error: function(response) {
                    console.log(response);
                    alert('Hubo un error en la solicitud.');
                }
            });
        }


        function eliminar(tareaId) {
            const tarea = document.querySelector('[data-tarea-id="' + tareaId + '"]')

            console.log(tareaId)
            $.ajax({
                type: 'delete',
                url: 'api/tareas/' + tareaId,
                data: {

                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                    tarea.remove();


                },
                error: function(response) {
                    console.log(response);
                    alert('Hubo un error en la solicitud.' + response);
                }
            });
        }
    </script>





</body>

</html>