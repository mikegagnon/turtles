<?

function isTurtleDir($dirname) {
  return substr(basename($dirname), 0, strlen("dir-")) === "dir-";
}

function isUnitDir($dirname) {
  return !isTurtleDir(basename($dirname));
}

$warning = "";
$headerJpgFilename = "missing.resized.jpg";
$textFilename = "";
$textContents = "missing: *.resized.jpg.txt";

$cwd = basename(getcwd());

$relpath = $argv[1];
echo $relpath;
$depth = $argv[2];
$setupPrefix = "../" . str_repeat("../", $depth) . "setup/";

$thisunit = false;
$thisturtle = true;
if (isUnitDir($relpath)) {
  $thisunit = true;
  $thisturtle = false;
}

//echo $relpath;

if ($thisunit) {
  $turtledirs = [];
  $unitdirs = [];

  #$dirs = array_filter(glob('*'), 'is_dir');
  $jpegs = glob('*.resized.jpg');
  if (sizeof($jpegs) == 0) {
    $warning = $warning . " (Warning) empty *.resized.jpg glob";
  } elseif (sizeof($jpegs) > 1) {
    $warning = $warning . " (Warning) sizeof *.resized.jpg glob > 1";
    $headerJpgFilename = basename($jpegs[0]);
  } else {
    $headerJpgFilename = basename($jpegs[0]);
  }

  $txts = glob('*.resized.jpg.txt');

  if (sizeof($txts) == 0) {
    $warning = $warning . " (Warning) empty *.resized.jpg.txt glob";
  } elseif (sizeof($txts) > 1) {
    $warning = $warning . " (Warning) sizeof *.resized.jpg.txt glob > 1";
    $textFilename = basename($txts[0]);
    $myfile = fopen($textFilename, "r") or die("Unable to open file!");
    $textContents = fread($myfile,filesize($textFilename));
    fclose($myfile);
  } else {
    $textFilename = basename($txts[0]);
    $myfile = fopen($textFilename, "r") or die("Unable to open file!");
    $textContents = fread($myfile,filesize($textFilename));
    fclose($myfile);
  }

} else { 

  // TODO

  // //echo $depth;
  // $prefix = "../" . str_repeat("../", $depth) . "setup/";
  // $cwd = basename(getcwd());
  // $alldirs = array_filter(glob('*'), 'is_dir');

  // $turtledirs = array_filter($alldirs, "isTurtleDir");
  // $unitdirs = array_filter($alldirs, "isUnitDir");

  // echo implode($turtledirs);
  // echo implode($unitdirs);


  // #$dirs = array_filter(glob('*'), 'is_dir');
  // $jpegs = glob('*.jpg');

}






?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<? echo $setupPrefix ?>img/favicon.png">

    <title>Michael N. Gagnon</title>

    <link href="<? echo $setupPrefix ?>css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<? echo $setupPrefix ?>css/album.css" rel="stylesheet">
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
            <img src="<? echo $setupPrefix ?>img/favicon.png" width="20" height="20">
            <strong>&nbsp;Michael N. Gagnon:</strong>&nbsp;&nbsp;&nbsp;<span style='font-family: "Courier New"'><? echo $relpath ?>/index.html</span>
          </a>
        </div>
      </div>
    </header>

    <main role="main">



      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading"><b><? echo $cwd ?></b></h1>

<?
  if ($thisunit) {
        $t = nl2br(htmlentities($textContents));

    echo "<a href='$headerJpgFilename'><img class='main-img' src='$headerJpgFilename'></a><div style='text-align: left;'><br><br>$t</div>";
    //echo "<div class='auto-text-div'>" . nl2br(htmlentities($textContents)) . "</div>";
  }
?>

        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">

<?
if ($thisunit) {

    $t = nl2br(htmlentities($textContents));

    $html = <<<EOT

            <div class="margin: auto; auto-text-div" style="width: 600;">
              Centered element
            </div>
  EOT;
    echo $html;

} else {
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
