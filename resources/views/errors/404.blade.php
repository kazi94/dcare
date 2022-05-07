<!DOCTYPE html>

<html >
    
    {{-- head layouts --}}
    @include('layouts.head')
<body class="skin-blue " style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="min-height: 650px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        404 Error Page
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Ohlala! Page Introuvable.</h3>

          <p>
            Nous n'avons pas pu trouver la page que vous chercher
            Sinon, Vous pouvez <a href="/">retourner à la page d'acceuil</a>
          </p>

        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<footer class="main-footer">

    <!-- Default to the left -->
    <strong>  Copyright &copy; 2019 <a href="#">Universite Tlemcen</a>.</strong> Touts droits réservés.
  <a href="/bugs_report" class=" btn btn-primary pull-right btn-primary">Signaler un bug?</a >

</footer>

</div>
<!-- ./wrapper -->



</body>

</html>

