<!DOCTYPE html>
<html lang="ru">
<head>
  <title>Items</title>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <div class='d-flex row flex-row justify-content-center'>
        <div class="col-auto w-50">
            <form class="form-signin"
                    method="POST"
                    action='{{route('login')}}'>
                @csrf
                <h1 class="h3 mb-3 font-weight-normal">Вход на сайт</h1>
                @error('login')
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                @enderror

                <label for="inputName" class="sr-only">Имя</label>
                <input id="inputName" name='name' class="form-control" placeholder="введите имя" required="" autofocus="">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="inputPassword" class="sr-only">Пароль</label>
                <input type="password" name='password' id="inputPassword" class="form-control" placeholder="введите пароль" required="">
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
            </form>
        </div>
    </div>
</body>
</html>
