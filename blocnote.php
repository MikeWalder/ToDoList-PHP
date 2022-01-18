<!DOCTYPE html>
<html lang="fr">

<head>
    <style>
        body {
            padding: 0;
            margin: 0;
            background: url('blocnote.jpg') no-repeat center fixed;
            -webkit-background-size: cover;
            /* pour anciens Chrome et Safari */
            background-size: cover;
            /* version standardisée */
        }

        h1,
        h2,
        h3 {
            text-align: center;
            font-weight: bold;
            letter-spacing: 4px;
            font-family: 'Girassol', cursive;
            text-decoration: underline;
        }

        .stars i {
            color: yellow;
            padding-left: 5px;
        }

        .fa-trash-alt,
        .fa-pencil-alt {
            transition: all 0.4s;
        }

        .fa-trash-alt:hover,
        .fa-pencil-alt:hover {
            transform: scale(1.4);
            color: blue;
        }

        .form-check input:checked+label {
            color: blue;
            font-weight: bold;
            transition: all 0.4s;
        }

        .opacitor {
            opacity: 08s;
        }
    </style>
    <!-- Google font styles -->
    <link href="https://fonts.googleapis.com/css2?family=Girassol&display=swap" rel="stylesheet">

    <!-- Links to use Font Awesome icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <title>To Do list </title>
</head>

<body>
    <h1>Bloc-note</h1>

    <?php
    require_once("databaseConnection.php");
    ?>

    <div class="container mb-3">
        <div class="row">

            <div class="col-md-1">
            </div>

            <div class="col-md-10 bg-light shadow-lg">
                <h3 class="pt-3 text-center">Ajouter une action</h3>

                <form action="" method="POST">
                    <div class="form-group row pt-5">
                        <label for="note" class="col-md-3 col-form-label font-weight-bold h4">Action : </label>
                        <div class="col-md-6">
                            <input type="text" name="note" class="form-control-plaintext shadow">
                        </div>
                    </div>
                    <div class="form-group row pt-5">
                        <label for="priorite" class="col-md-3 col-form-label font-weight-bold h4">Priorité : </label>
                        <div class="col-md-9">
                            <div class="form-check form-check-inline pl-3 pr-3">
                                <input class="btn-check" type="radio" name="priorite" value="1">
                                <label class="form-check-label h4 pl-3">1</label>
                            </div>
                            <div class="form-check form-check-inline pl-3 pr-3">
                                <input class="btn-check" type="radio" name="priorite" value="2">
                                <label class="form-check-label h4 pl-3">2</label>
                            </div>
                            <div class="form-check form-check-inline pl-3 pr-3">
                                <input class="btn-check" type="radio" name="priorite" value="3">
                                <label class="form-check-label h4 pl-3">3</label>
                            </div>
                            <div class="form-check form-check-inline pl-3 pr-3">
                                <input class="btn-check" type="radio" name="priorite" value="4">
                                <label class="form-check-label h4 pl-3">4</label>
                            </div>
                            <div class="form-check form-check-inline pl-3">
                                <input class="btn-check" type="radio" name="priorite" value="5">
                                <label class="form-check-label h4 pl-3">5</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg col-sm-4 mb-2 mb-3 shadow">Ajouter</button>
                    </div>
                </form>
            </div>

            <div class="col-md-1">
                <?php
                if (isset($_POST['note']) && isset($_POST['priorite'])) {
                    $note = htmlspecialchars($_POST['note']);
                    $priorite = (int)$_POST['priorite'];
                    //echo "La note est ".$note." et la priorité est ".$priorite."<br>";


                    //Ajouter les informations à notre table 
                    $request = $pdo->prepare('INSERT INTO blocnote (note, priorite) VALUES (:note, :priorite)');
                    $request->execute(array(
                        'note' => $note,
                        'priorite' => $priorite
                    ));
                    echo "<script>window.opener.location.reload();window.close();</script>";
                }

                ?>
            </div>
        </div>
    </div>

    <div class="container">
        <?php
        $answer = $pdo->query("SELECT note, priorite, id FROM blocnote order by priorite DESC");
        while ($q = $answer->fetch()) {
        ?>
            <div class="row">
                <div class="col-md-2">
                </div>

                <div class="col-md-8 bg-dark text-white p-2 shadow-lg mt-3">
                    <div class="row">
                        <?=
                        '<div class="col-md-6 pl-4 pt-2 font-weight-bold">' . $q['note'] . '</div>';
                        ?>
                        <div class="stars col-md-4">
                            <?php
                            for ($i = 1; $i <= $q['priorite']; $i++) {
                            ?>
                                <i class="fas fa-star fa-lg pt-2"></i>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-2">
                            <a href="blocnote.php?r=<?= $q['id'] ?>" class="btn btn-danger text-light mb-1 mr-2">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            <a href="blocnote.php?m=<?= $q['id'] ?>" class="btn btn-warning text-light mb-1" data-toggle="modal" data-target="#modalModification">
                                <i class="fas fa-pencil-alt"></i>
                            </a>

                            <!-- Modal -->
                            <div class="modal fade" id="modalModification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content opacitor">
                                        <div class="modal-header bg-secondary">
                                            <h5 class="modal-title text-center" id="exampleModalLabel">Modifier la tâche</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body bg-secondary">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <label for="note" class="col-3 col-form-label font-weight-bold h4">Action : </label>
                                                            <input type="text" name="note" class="form-control-plaintext shadow bg-light col-8">
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="priorite" class="col-3 col-form-label font-weight-bold h4">Priorité : </label>
                                                            <div class="col-md-9">
                                                                <div class="form-check form-check-inline pt-2 pl-1 pr-1">
                                                                    <input class="btn-check" type="radio" name="priorite" value="1">
                                                                    <label class="form-check-label h5 pl-1">1</label>
                                                                </div>
                                                                <div class=" form-check form-check-inline pl-1 pr-1">
                                                                    <input class="btn-check" type="radio" name="priorite" value="2">
                                                                    <label class="form-check-label h5 pl-1">2</label>
                                                                </div>
                                                                <div class="form-check form-check-inline pl-1 pr-1">
                                                                    <input class="btn-check" type="radio" name="priorite" value="3">
                                                                    <label class="form-check-label h5 pl-1">3</label>
                                                                </div>
                                                                <div class="form-check form-check-inline pl-1 pr-1">
                                                                    <input class="btn-check" type="radio" name="priorite" value="4">
                                                                    <label class="form-check-label h5 pl-1">4</label>
                                                                </div>
                                                                <div class="form-check form-check-inline pl-1">
                                                                    <input class="btn-check" type="radio" name="priorite" value="5">
                                                                    <label class="form-check-label h5 pl-1">5</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-secondary opacitor">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times-circle"></i>&nbsp;Fermer</button>
                                            <button type="button" class="btn btn-success"><i class="fas fa-pencil-alt"></i>&nbsp;Modifier</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                </div>
            </div>
        <?php
        }
        //header("Location: http://localhost/wf3/bdd/blocnote/blocnote.php");
        ?>
    </div>

    <?php
    if (isset($_GET['r']) && $_GET['r'] > 0) {
        $id = (int)$_GET['r'];

        $request = $pdo->prepare('DELETE FROM blocnote WHERE id = :id');
        $request->execute(array(
            'id' => $id
        ));

        echo "<div class='container mt-3'>";
        echo "<div class='row'>";
        echo "<div class='col-12 text-center'>";
        echo "<div class='alert alert-warning h3 animate__animated animate__fadeOut animate__delay-2s' role='alert'>";
        echo "<i class='far fa-check-circle pr-3'></i>";
        echo "La tâche a bien été supprimée !";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

        echo "<script>
        setTimeout('redirection()', 3000);
        </script>";
    }

    if (isset($_GET['m']) && $_GET['m'] > 0) {
        $id = (int)$_GET['m'];
    }
    ?>


    <!-- Optional JavaScript -->
    <script>
        function redirection() {
            window.location.href = 'http://localhost/wf3/bdd/blocnote/blocnote.php';
        }
    </script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>