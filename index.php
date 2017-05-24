<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Welcome!</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>


        <div class="container">
            <div class="row">
                <form action="" method="post" enctype="multipart/form-data" id="formlol">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />

                  <div class="file-field input-field">
                    <div class="btn">
                      <span>File</span>
                      <input type="file" name="fichier[]" multiple id="fileinput">
                    </div>
                    <div class="file-path-wrapper">
                      <input class="file-path validate" type="text" placeholder="Upload un ou plusieurs">
                    </div>
                  </div>
                </form>
                <script>
                document.querySelector('#fileinput').addEventListener('change', function(){
                    document.getElementById('formlol').submit();
                });
                </script>

        <?php

        if (isset($_POST['img_del'])){

            unlink($_POST['img_del']);

        }



        if(isset($_FILES['fichier']))
        { 
            for ($i = 0 ; $i<count($_FILES['fichier']['name']) ; $i++)
            {


                $dossier = 'files/';
                $fichier = basename($_FILES['fichier']['name'][$i]);

                $extensions = array('.png', '.gif', '.jpg', '.jpeg');
                $extension = strrchr($_FILES['fichier']['name'][$i], '.'); 

                $erreur = "";
                //Début des vérifications de sécurité...
                if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
                {
                     $erreur = 'L\'extenstion est incorrecte </br>Vous devez uploader un fichier de type png, gif, jpg ou jpeg.';
                }
                if($_FILES['fichier']['error'][$i] == 2 || $_FILES['fichier']['error'][$i] == 1 )
                {
                     $erreur = 'Le fichier est trop gros, il ne doit dépasser 1Mo.';
                }
                if(empty($erreur)) //S'il n'y a pas d'erreur, on upload
                {
                     //On formate le nom du fichier ici...
                     $fichier = uniqid('image', false).$extension;

                     if(move_uploaded_file($_FILES['fichier']['tmp_name'][$i], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                     {
                          echo 'Upload effectué avec succès ! </br>';
                     }
                     else //Sinon (la fonction renvoie FALSE).
                     {
                          echo 'Echec de l\'upload ! </br>';
                     }
                }
                else
                {
                     echo $erreur;
                }
            }
        }
        
        ?>
            </div>

            <div class="row">
                <?php  
                    $it = new FilesystemIterator('files/');
                    $a_files = array();

                    foreach ($it as $fileinfo) {
                        $a_files[filemtime($fileinfo)] = $fileinfo;

                    }
                    ksort($a_files);
                    $a_files =  array_reverse($a_files);
                    foreach ($a_files as $fileinfo) { ?>

                        <div class="col s12 m3 l4">
                            <img class="images" src="<?php  echo $fileinfo ?>"></img>
                            <?php echo $fileinfo->getFilename(). "\n";?>

                            <form action="" method="post">
                                <input type="hidden" name="img_del" value="<?php echo $fileinfo ?>">
                                <button type="submit"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                            </form>
                        </div>

                    <?php } ?>

            </div>
        </div>



    </body>
    <script src="script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
</html>
