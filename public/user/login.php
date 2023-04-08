<?php
include('../../init.php');
$param = $_POST ?? null;
$form['user'] = $param['username'] ?? null;
$form['pass'] = $param['password'] ?? null;
if ($param) {
  $Auth->setDataLogin($form['user'], $form['pass']);
  $Auth->AuthLogin();
}
$css['body'] = "body-login";
$css['body-bg'] = getBgBodyfromConfigFile();
$mTpl = new App\Core\TemplateGen(["css" => $css], ["showBottom"=>false], "sw", null, null);
$mTpl->renderHead();
?>
<link rel="stylesheet" type="text/css" href="<?php echo route['a'] . "css/signin.css" ?>">
<main class="form-signin w-100 m-auto bg-white border rounded text-center wow animate__animated animate__fadeInDown animate__fast">
  <div class="mb-3">
    <img src="<?php echo route['i'] . $_ENV['APP_LOGO'] ?>" alt="DAHP" class="img-fluid" style="width:80%">
  </div>
  <form method="post" action="">
    <h4 class="h4 mt-3 mb-3 fw-normal"><?php echo $_ENV['APP_NAME'] ?></h4>
    <div class="form-floating">
      <input name="username" type="text" class="form-control" id="floatingInput" placeholder="0000000000" required>
      <label for="floatingInput">Nombre usuario</label>
    </div>
    <div class="form-floating mb-3">
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="********" required>
      <label for="floatingPassword">Contraseña</label>
    </div>
    <div class="checkbox">
    </div>
    <button class="w-100 btn btn-lg btn-danger mt-3 wow animate__animated animate__fadeInDown" type="submit">Iniciar Sesión</button>
    <p class="mt-3 mb-3 text-muted">&copy; 2023</p>
  </form>
</main>
<?php $mTpl->renderFoot() ?>