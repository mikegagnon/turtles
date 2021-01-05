<?

// $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
// $txt = "John Doe\n";
// fwrite($myfile, $txt);
// $txt = "Jane Doe\n";
// fwrite($myfile, $txt);
// fclose($myfile);

$json = new stdClass();

function isTurtleDir($dirname) {
  return true; //return $dirname == "." || substr(basename($dirname), 0, strlen("dir-")) === "dir-";
}

function isUnitDir($dirname) {
  return !isTurtleDir(basename($dirname));
}

# https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
function startsWith( $haystack, $needle ) {
     $length = strlen( $needle );
     return substr( $haystack, 0, $length ) === $needle;
}

# https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
}

$warning = "";
$headerJpgFilename = "missing.resized.jpg";
$textFilename = "";
$textContents = "";// "missing: *.resized.jpg.txt";

$cwd = basename(getcwd());

$relpath = $argv[1];

# TODO
$prettyrelpath = $relpath;
// if ($relpath == "./index.html") {
//   $prettyrelpath = "dir-main/";
// } else {
//   $prettyrelpath = "dir-main/" . $relpath;
// }


$depth = $argv[2];
#$setupPrefix = "../" . str_repeat("../", $depth) . "setup/";
$setupPrefix = str_repeat("../", $depth) . "setup/";




#$textFilename = "../" . str_repeat("../", $depth) . "setup/header.txt";
$textFilename = str_repeat("../", $depth) . "setup/header.txt";

$myfile = fopen($textFilename, "r") or die("Unable to open file!");
$headerText = fread($myfile,filesize($textFilename));


#$textFilename = "../" . str_repeat("../", $depth) . "setup/title.txt";
$textFilename = str_repeat("../", $depth) . "setup/title.txt";

$myfile = fopen($textFilename, "r") or die("Unable to open file!");
$titleText = fread($myfile,filesize($textFilename));







$thisunit = false;
$thisturtle = true;
if (isUnitDir($relpath)) {
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

$txts = glob('*.resized.jpg.txt');
$pdfs = glob('*.pdf');
$linktxt = glob('link.txt');

$linktextcontents = "";
if (sizeof($linktxt) > 0) {
  $linktextfilename = basename($linktxt[0]);
  $myfile = fopen($linktextfilename, "r") or die("Unable to open file!");
  if (filesize($linktextfilename) > 0) {
    $linktextcontents = fread($myfile,filesize($linktextfilename));
  }
  fclose($myfile);
}



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

if (ctype_space($textContents)) {
  $textContents = "";
}

if ($thisturtle) { 
  $alldirs = array_filter(glob('*'), 'is_dir');
  $turtledirs = array_filter($alldirs, "isTurtleDir");
  $unitdirs = array_filter($alldirs, "isUnitDir");
}







$json->titleText = $titleText;
$json->setupPrefix = $setupPrefix;
$json->prettyrelpath = $prettyrelpath;
$json->cwd = $cwd;

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<? echo $setupPrefix ?>img/favicon.png">

    <title><? echo $titleText?></title>

    <script src="<? echo $setupPrefix ?>js/qrcode.js"></script> 

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
        <div class="container d-flex ">
          <a class="navbar-brand d-flex align-items-center">
            <img src="<? echo $setupPrefix ?>img/favicon.png" width="20" height="20">
            <strong>&nbsp;<? echo $titleText ?></strong>
            &nbsp;&nbsp;&nbsp;
            <span style='font-family: "Courier New"'><? echo $prettyrelpath ?>/index.html</span>
        </a>

        <?
          if ($prettyrelpath != ".")  {
            echo '<a style=" text-decoration: underline; color: white; font-size: 250%;" href="../index.html">⬆️</a>';
          }

        ?>
        </div>
      </div>
    </header>

    <main role="main">



      <section class="text-center">
        <div class="container">
          <h3><b><? echo $cwd ?></b></h3>
        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">

<?
  $t = "";
  if (!empty($textContents)) {
    $t = nl2br(htmlentities($textContents));
  }

  //echo "<a href='$headerJpgFilename'><img class='main-img' src='$headerJpgFilename'></a>";

  //echo "<br><br>";


  $pdfhtml = "";
  foreach ($pdfs as &$p) {
    $pdfhtml = $pdfhtml . "<div style='text-align: left; font-size: 15pt;'>PDF: <a href='$p'>$p</a></div>";
  }





  

  /*foreach ($pdfs as &$p) {
    echo "<div style='text-align: left; font-size: 15pt;'>PDF: <a href='$p'>$p</a></div>";
  }*/


  // https://www.geeksforgeeks.org/php-startswith-and-endswith-functions/
// function startsWith ($string, $startString) { 
//     $len = strlen($startString); 
//     return (substr($string, 0, $len) === $startString); 
// }

  function getTurtleRef($link) {
    global $depth;


    if (ctype_space($link) || empty($link)) {
      return false;
    }

    if (startsWith($link, "http")) {
      return false;
    }

    $turtleref = str_repeat("../", $depth - 1) . $link;

    if (is_file($turtleref)) {
      return $turtleref; # . "/index.html";
    } else {
      return false;
    }

  }

  $turtlerefLinks = [];

  $linkhtml = "";

  $json->outputLink = [];

  echo("Bar " . $linktextcontents);

  function outputLink($link) {
      echo("Baz " . $link);
      global $linkhtml;
      global $turtledirs;
      $turrtlereflink = getTurtleRef($link);
      if (startsWith($link, "http")) {
          //echo "<b>Link</b>: <a href='$link'>$link</a><br>";
        $linkhtml = $linkhtml . "<b>External link</b>: <a href='$link'>$link</a><br>";
        array_push($json->outputLink, ["http", $link]);
      } else if ($turrtlereflink) {
        #echo "turrtlereflink " . $turrtlereflink;
        #array_push($turtlerefLinks, $turrtlereflink);
        //array_push($turtledirs, ":" . $turrtlereflink);
        $linkhtml = $linkhtml . "<b>Internal link</b>: <a href='$turrtlereflink'>$link</a><br>";
        array_push($json->outputLink, ["turrtlereflink", $link]);

      } else {
          //echo "<b>Link</b>: $link<br>";
        $linkhtml = $linkhtml . "<b>Link</b>: $link<br>";
        array_push($json->outputLink, ["else", $link]);
      }       
  }

  $youtubelinks = [];

  // https://stackoverflow.com/questions/1462720/iterate-over-each-line-in-a-string-in-php
  $separator = "\r\n";
  $line = strtok($linktextcontents, $separator);
  echo("line " . $line);
  $linkhtml = $linkhtml . "<div style='text-align: left;'>";
  if ($line != false) {
    //echo "<div style='text-align: left;'>";

      $oline = $line;
      
      preg_match('/^#/', $oline, $matches, PREG_OFFSET_CAPTURE);
      $istag = count($matches) === 1;

      preg_match_all('/^youtube:([^:]+):([^:]+)/', $oline, $ymatches, PREG_OFFSET_CAPTURE);
      $isyoutube = count($ymatches) >= 1;




    if ($isyoutube) {
      //preg_match('/^youtube:/', $oline, $ymatches, PREG_OFFSET_CAPTURE);
      //$isyoutube = count($ymatches) === 1;
      //print_r($ymatches);
      //echo($ymatches[1][0][0]);
      //echo($ymatches[2][0][0]);
      $linkname = $ymatches[1][0][0];
      $ycode = $ymatches[2][0][0];
      $yentry = [$linkname, $ycode];
      array_push($youtubelinks, $yentry);
    } else if (!ctype_space($line) && !$istag && !$isyoutube) {
      outputLink($line);
    } else {
      echo("Huh?" . $line);
    }
    while ($line !== false) {
      # do something with $line
      $line = strtok($separator);
      echo("liine " . $line);
      $oline = $line;
      preg_match('/^#/', $oline, $matches, PREG_OFFSET_CAPTURE);
      $istag = count($matches) === 1;

      preg_match_all('/^youtube:([^:]+):([^:]+)$/', $oline, $ymatches, PREG_OFFSET_CAPTURE);
      //$isyoutube = count($ymatches) >= 1;
      $isyoutube = preg_match('/^youtube:([^:]+):([^:]+)$/', $oline) ? true : false;

        echo("[asdf,".count($ymatches).",-". $isyoutube . "-" .  ctype_space($line) . "-" . empty($line) . "]");

      if ($isyoutube) {
        //preg_match('/^youtube:/', $oline, $ymatches, PREG_OFFSET_CAPTURE);
        //$isyoutube = count($ymatches) === 1;
        //print_r($ymatches);
        //echo($ymatches[1][0][0]);
        //echo($ymatches[2][0][0]);
        //exit("foo");

        $linkname = $ymatches[1][0][0];
        $ycode = $ymatches[2][0][0];
        $yentry = [$linkname, $ycode];
        echo("youtube-".$linkname."-".$ycode);
        array_push($youtubelinks, $yentry);
      } else if (!ctype_space($line) && !empty($line) && 
        //substr($oline, 0, 1) !== "#"
          //strcmp(substr($oline, 0, 1), "#") !== 0
        !$istag
        ) {
        outputLink($line);

        
      } else {
        echo("What link? " . $line);
      }
    }
    //cruft $linkhtml = $linkhtml .  "</div>";
    $linkhtml = $linkhtml . "<div style='text-align: left;'>#hashtags</div><span id='foohash'></div>";
  } else {
    $linkhtml = $linkhtml . "<div style='text-align: left;'>#hashtags</div><span id='foohash'></div>";
  }
  

  if (!empty($pdfs) || !empty($linkhtml)) { 
      $linkhtml = $linkhtml . "<br><br>";
  }

  $thtml = "";

  if (!empty($t)) {
    $thtml = "<div style='text-align: left;'>$t</div>";
  }

  $json->t = $t;









      $cssclass = "image-file";

      //$html = "";

      $card = "";
      if (!empty($pdfhtml) || !empty($linkhtml) || !empty($thtml)) {

        $card = <<<EOT
            <div class="card-body greydiv">
                      $pdfhtml
                      $linkhtml
                      $thtml
                    </div>
EOT;
      }


    $html = <<<EOT
              <div class="row greydiv">
              <div class="col-md-3">
              </div>
              <div class="col-md-6">
                <div class="card mb-4 box-shadow">
                  <a  href="$headerJpgFilename"><img class="card-img-top $cssclass" src="$headerJpgFilename"></a>
                  $card
                </div>
              </div>
              <div class="col-md-3">
              </div>
            </div>
EOT;
    echo $html;

    $json->headerJpgFilename = $headerJpgFilename;
    $json->cssclass = $cssclass;












?>



<?

// TODO: return prevtdir for adjacent youtube videos to work
function echoyoutubes($youtubelinks, $nextYoutubeIndex, $prevtdir, $basetdir) {
    $yloop = false;
    do {
      //echo("enter do<br>");
      if ($nextYoutubeIndex < count($youtubelinks))  {
        $yname = $youtubelinks[$nextYoutubeIndex][0];
        //echo("available link " . $yname . " " . $prevtdir . " " . $basetdir . "<br>");
        if ($yname > $prevtdir && $yname <= $basetdir) {
          //echo("right spot for link<br>");
          $ycode = $youtubelinks[$nextYoutubeIndex][1];
          //echo($yname . " " . $ycode);

    $html = <<<EOT
              <div class="row">
              <div class="col-md-12">
                 <center>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/$ycode" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                  </center>
                  <br>
              </div>
            </div>
EOT;
    echo $html;





          $nextYoutubeIndex += 1;
          $prevtdir = $yname;

          $yloop = true;
        }
        else {
          $yloop = false;
        }
      } else {
        $yloop = false;
      }

    } while ($yloop);
    return $nextYoutubeIndex;
}
if ($thisunit) {

  //   $t = nl2br(htmlentities($textContents));

  //   $html = <<<EOT

  //           <div class="margin: auto; auto-text-div" style="width: 600;">
  //             Centered element
  //           </div>
  // EOT;
  //   echo $html;

} else {

  $basetdir = "000000000000"; 
  $prevtdir = "000000000000";
  $nextYoutubeIndex = 0;

  $json->cards = [];

  foreach ($turtledirs as &$tdir) {



    if (startsWith($tdir, ":")) {
      $basetdir = ltrim($tdir, ':'); 
      $destination = $basetdir . "/index.html";
    } else {
      $basetdir = basename($tdir);
      $destination = $basetdir . "/index.html";
    }


    $nextYoutubeIndex = echoyoutubes($youtubelinks, $nextYoutubeIndex, $prevtdir, $basetdir);







    $alldirs = array_filter(glob($tdir . "/*"), 'is_dir');

    if (sizeof($alldirs) == 0 && sizeof($pdfs) == 0) {
      $cssclass = "image-file";
    } else {
      $cssclass = "image-folder";
    }
    #echo "dirs: " . implode($alldirs);






    
    //


    $thisjpegs = glob($basetdir . '/*.resized.jpg');
    $thiswarnings = "";

    $thisJpgFilename = "";
    
    if (sizeof($thisjpegs) == 0) {
      $thiswarnings = $thiswarnings . " (Warning) empty *.resized.jpg glob for " . $basetdir;
    } elseif (sizeof($thisjpegs) > 1) {
      $thiswarnings = $thiswarnings . " (Warning) sizeof *.resized.jpg glob > 1 for " . $basetdir;
      $thisJpgFilename = basename($thisjpegs[0]);
    } else {
      $thisJpgFilename = basename($thisjpegs[0]);
    }

    if (empty($thisJpgFilename)) {
      $imgsrc = $setupPrefix . "/img/no-image.png";
    } else {
      $imgsrc = $basetdir . "/" . $thisJpgFilename;
    }

    //  $imgsrc = $setupPrefix . "/img/no-image.png";
    


    #$imgsrc = $basetdir . "/" . $thisJpgFilename;

    $html = <<<EOT
              <div class="row">
              <div class="col-md-3">
              </div>
              <div class="col-md-6">
                <div class="card mb-4 box-shadow">
                  <a  href="$destination"><img class="card-img-top $cssclass" src="$imgsrc"></a>
                  <div class="card-body">
                    <p class="card-text">
                      <a href="$destination">$basetdir</a>

                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
              </div>
            </div>
EOT;
    echo $html;

    $card = new stdClass();
    $card->destination = $destination;
    $card->cssclass = $cssclass;
    $card->imgsrc = $imgsrc;
    $card->basetdir = $basetdir;

    array_push($json->cards, $card);



    $prevtdir = $basetdir;
  }

// echo("nextYoutubeIndex " . $nextYoutubeIndex);
// echo("prevtdir " . $prevtdir);
// echo("basetdir " . $basetdir);
  $nextYoutubeIndex = echoyoutubes($youtubelinks, $nextYoutubeIndex, $prevtdir, "zzzzzzzzzzzzzzz");



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
  
    if (empty($thisJpgFilename)) {
      $imgsrc = $setupPrefix . "/img/no-image.png";
    } else {
      $imgsrc = $baseudir . "/" . $thisJpgFilename;
    }


    $html = <<<EOT
              <div class="row">
              <div class="col-md-3">
              </div>
              <div class="col-md-6">
                <div class="card mb-4 box-shadow">
                  <a  href="$destination"><img class="card-img-top $cssclass" src="$imgsrc"></a>
                  <div class="card-body">
                    <p class="card-text">
                      <a href="$destination">$baseudir</a>

                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
              </div>
            </div>
EOT;
    echo $html;

    $prevtdir = $basetdir;

  }



}

$myfile = fopen("index.json", "w") or die("Unable to open file!");
$txt = json_encode($json, JSON_PRETTY_PRINT);
fwrite($myfile, $txt);
fclose($myfile);

?>


        </div>
      </div>
    </main>

    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <!--<a href="trilogy.html">🐇</a>-->
        </p>
        <center><div id="qrcode"></div></center><br><br>
        <script type="text/javascript">
          var qrcode = new QRCode("qrcode", {
              text: window.location.href,
              width: 300,
              height: 300,
              colorDark : "#000000",
              colorLight : "#ffffff",
              correctLevel : QRCode.CorrectLevel.H
          });
        </script>
        <p>Thanks <a href="https://getbootstrap.com/docs/4.0/examples/album/">Bootstrap</a>!</p>
      </div>
    </footer>
  </body>
</html>
