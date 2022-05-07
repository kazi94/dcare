<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DCare</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css') }}">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/signin.css') }}" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin">
        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            {{ csrf_field() }}
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong class="text-red">{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <img class="mb-4" src="{{ asset('img/logo_cabinet.jpg') }}" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Connectez vous Svp !</h1>

            <div class="form-floating">
                <input type="email" class="form-control  " name="email" required placeholder="Adresse email"
                    autocomplete="off">
                <label for="floatingInput">Adresse email</label>
            </div>
            <div class="form-floating ">
                <input type="password" class="form-control  " name="password" required
                    placeholder="Mots de passe" autocomplete="off">
                <label for="floatingPassword">Mots de passe</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary  " type="submit">Je me connecte</button>

            <p>Vous avez oublié vos identifiants?</p>
            <p>Contactez nous à l'adresse mail <b>kazi.sidou.94@gmail.com</b></p>

            <p class="mt-5 mb-3 text-muted">&copy; 2019–2021</p>
        </form>
    </main>



</body>

</html>
