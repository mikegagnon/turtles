<?


$relpath = $argv[1];
$depth = $argv[2];
//echo $depth;
$prefix = "../" . str_repeat("../", $depth) . "setup/";
$cwd = basename(getcwd());
$dirs = array_filter(glob('*'), 'is_dir');
$jpegs = glob('*.jpg');
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<? echo $prefix ?>img/favicon.png">

    <title>Michael N. Gagnon</title>

    <link href="<? echo $prefix ?>css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<? echo $prefix ?>css/album.css" rel="stylesheet">
  </head>

  <body>

    <header>
      <div class="collapse bg-dark" id="navbarHeader">
        <div class="container">
          <div class="row">
            <div class="col-sm-8 col-md-7 py-4">
              <h4 class="text-white">.</h4>
              <p class="text-muted">.</p>
            </div>
            <div class="col-sm-4 offset-md-1 py-4">
              <h4 class="text-white">Contact</h4>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
          <a class="navbar-brand d-flex align-items-center">
            <img src="<? echo $prefix ?>img/favicon.png" width="20" height="20">
            <strong>&nbsp;Michael N. Gagnon:</strong>&nbsp;&nbsp;&nbsp;<span style='font-family: "Courier New"'><? echo $relpath ?>/index.html</span>
          </a>
        </div>
      </div>
    </header>

    <main role="main">



      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading"><b><? echo $cwd ?></b></h1>

          <a href="../<? echo $cwd ?>.jpg"><img class="main-img" src="../<? echo $cwd ?>.jpg"></a>
        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">

<? 
foreach ($jpegs as &$filename) {
  $without_extension = basename($filename, '.jpg');
  $isfolder = is_dir($without_extension);
  if ($isfolder) {
    $destination = $without_extension . "/index.html";
    $cssclass = "image-folder";
  } else {
    $destination = $filename;
    $cssclass = "image-file";
  }

  #$value = $value * 2;
  $html = <<<EOT
            <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <a  href="$destination"><img class="card-img-top $cssclass" src="$filename"></a>
                <div class="card-body">
                  <p class="card-text">
                    <a href="$destination">$destination</a>

                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
            </div>
          </div>
EOT;
  echo $html;
}

?>


        </div>
      </div>
    </main>

    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <!--<a href="trilogy.html">🐇</a>-->
        </p>
        <p>Thanks <a href="https://getbootstrap.com/docs/4.0/examples/album/">Bootstrap</a>!</p>
      </div>
    </footer>
  </body>
</html>
