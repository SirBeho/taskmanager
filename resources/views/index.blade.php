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

<body class="antialiased">
    <div class="flex justify-center items-center min-h-screen  font-['Open_Sans'] ">
       
            <div class=" ">
               
                <div class="flex flex-col items-center w-full overflow-hidden py-8 border-gray-BD bg-blue-400 rounded-3xl text-gray-33  ">

                    <div class="overflow-hidden w-20 border-2 rounded-full  ">
                        <img class="w-full" src="logo.png" alt="logo">
                    </div>

                    <h3 class="font-semibold text-xl leading-snug text-center mb-4 px-12">Bienvenido</h3>

                    <form action="{{ route('form.login') }}" method="post" class="flex flex-col gap-4 px-12 pb-8 relative text-gray-500 dark:text-white ">
                         @csrf
                        <label class="flex items-center bg-white dark:bg-blue-900 gap-3 border-2 border-gray-BD rounded-lg p-3 ps-4 focus-within:border-blue-300">
                            <div class="w-4"><img src="email.svg" alt="logo"></div>
                            <input class="outline-none w-full bg-transparent " type="email" name="email" autocomplete="off" placeholder="Email" value="{{ old('email') }}" required>
                        </label>
                       
                        <label class="flex items-center bg-white dark:bg-blue-900 gap-3 border-2 border-gray-BD rounded-lg p-3 ps-4 focus-within:border-blue-300">
                            <div class="w-4"><img src="password.svg" alt="logo"></div>
                            <input class="outline-none w-full bg-transparent" type="password" name="password" autocomplete="off" placeholder="Password" required>
                        </label>

                        @if(@isset($error))
                            <h1 id="msj" class="text-red-600 text-xl absolute w-full max-w-xl transform duration-500 ease-in-out text-center bottom-10 mb-20">{{ $error }}</h1>
                        @endif

                        @if ($errors->has('email'))
                            <p>{{ $errors->first('email') }}</p>
                        @endif

                        <button class="w-full p-2 mt-2 rounded-lg text-sm leading-normal font-semibold bg-blue-500  dark:bg-blue-900 text-white dark:text-white hover:bg-blue-700 dark:hover:bg-blue-800" type="submit">Ingresar</button>
                    </form>


                </div>
            </div>
      

    </div>
</body>

</html>