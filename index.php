<?

function isTurtleDir($dirname) {
  return $dirname == "." || substr(basename($dirname), 0, strlen("dir-")) === "dir-";
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
$depth = $argv[2];
$setupPrefix = "../" . str_repeat("../", $depth) . "setup/";

$thisunit = false;
$thisturtle = true;
echo "1." . $relpath;
if (isUnitDir($relpath)) {
  echo "unit dir";
  $thisunit = true;
  $thisturtle = false;
}


$alldirs = [];
$turtledirs = [];
$unitdirs = [];

$jpegs = glob('*.resized.jpg');
if (sizeof($jpegs) == 0) {
  $warning = $warning . " (Warning) empty *.resized.jpg glob";
} elseif (sizeof($jpegs) > 1) {
  $warning = $warning . " (Warning) sizeof *.resized.jpg glob > 1";
  $headerJpgFilename = basename($jpegs[0]);
} else {
  $headerJpgFilename = basename($jpegs[0]);
}

#echo "1." . $thisunit;

if ($thisunit) {
  #$turtledirs = [];
  #$unitdirs = [];



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

  $alldirs = array_filter(glob('*'), 'is_dir');
  $turtledirs = array_filter($alldirs, "isTurtleDir");
  $unitdirs = array_filter($alldirs, "isUnitDir");
  echo "1. " . implode($alldirs);

  #echo "1. " . implode($alldirs);
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
  } else {
    echo "<a href='$headerJpgFilename'><img class='main-img' src='$headerJpgFilename'></a>";
  }
?>

        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">

<?
if ($thisunit) {

  //   $t = nl2br(htmlentities($textContents));

  //   $html = <<<EOT

  //           <div class="margin: auto; auto-text-div" style="width: 600;">
  //             Centered element
  //           </div>
  // EOT;
  //   echo $html;

} else {


  foreach ($turtledirs as &$tdir) {
    $basetdir = basename($tdir);
    $destination = $basetdir . "/index.html";
    $cssclass = "image-folder";

    $thisjpegs = glob($basetdir . '/*.resized.jpg');
    $thiswarnings = "";

    if (sizeof($thisjpegs) == 0) {
      $thiswarnings = $thiswarnings . " (Warning) empty *.resized.jpg glob for " . $basetdir;
    } elseif (sizeof($thisjpegs) > 1) {
      $thiswarnings = $thiswarnings . " (Warning) sizeof *.resized.jpg glob > 1 for " . $basetdir;
      $thisJpgFilename = basename($thisjpegs[0]);
    } else {
      $thisJpgFilename = basename($thisjpegs[0]);
    }

    $imgsrc = $basetdir . "/" . $thisJpgFilename;

    $html = <<<EOT
              <div class="row">
              <div class="col-md-4">
              </div>
              <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                  <a  href="$destination"><img class="card-img-top $cssclass" src="$imgsrc"></a>
                  <div class="card-body">
                    <p class="card-text">
                      <a href="$destination">$baseudir</a>

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


  foreach ($unitdirs as &$udir) {
    $baseudir = $udir; //basename($udir);
    $destination = $baseudir . "/index.html";
    $cssclass = "image-file";

    $thisjpegs = glob($baseudir . '/*.resized.jpg');
    $thiswarnings = "";

    if (sizeof($thisjpegs) == 0) {
      $thiswarnings = $thiswarnings . " (Warning) empty *.resized.jpg glob for " . $baseudir;
    } elseif (sizeof($thisjpegs) > 1) {
      $thiswarnings = $thiswarnings . " (Warning) sizeof *.resized.jpg glob > 1 for " . $baseudir;
      $thisJpgFilename = basename($thisjpegs[0]);
    } else {
      $thisJpgFilename = basename($thisjpegs[0]);
    }

    $imgsrc = $baseudir . "/" . $thisJpgFilename;

    $html = <<<EOT
              <div class="row">
              <div class="col-md-4">
              </div>
              <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                  <a  href="$destination"><img class="card-img-top $cssclass" src="$imgsrc"></a>
                  <div class="card-body">
                    <p class="card-text">
                      <a href="$destination">$baseudir</a>

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
