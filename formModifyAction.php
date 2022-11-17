<?php
if (isset($_GET['m'])) {
    $id = (int)$_GET['m'];
    $sql = "SELECT note, priorite FROM blocnote WHERE id = :id";
    $request = $pdo->prepare($sql);
    $request->execute(array(
        'id' => $id
    ));
    $donnees = $request->fetch();
    $action = $donnees['note'];
    $priorite = (int)$donnees['priorite'];
    // echo "<h3>" . $priorite . "</h3>";
?>


    <form action="" method="POST" class="animate__animated animate__fadeIn">
        <div class="container pt-5">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8  bg-warning-light shadow">
                    <div class="form-group row mt-3">
                        <label for="note" class="col-3 col-form-label font-weight-bold h4">Action : </label>
                        <input type="text" name="modify_note" class="form-control-text shadow bg-light col-6 pl-2" placeholder="<?= $action ?>">
                    </div>
                    <div class="form-group row">
                        <label for="priorite" class="col-3 col-form-label font-weight-bold h4">Priorité : </label>
                        <div class="col-md-9">
                            <div class="form-check form-check-inline pt-2 pl-1 pr-1">
                                <input class="btn-check" type="radio" name="modify_priorite" value="1">
                                <label class="form-check-label h5 pl-1 <?= $priorite == 1 ? 'active' : '' ?>">1</label>
                            </div>
                            <div class=" form-check form-check-inline pl-1 pr-1">
                                <input class="btn-check" type="radio" name="modify_priorite" value="2">
                                <label class="form-check-label h5 pl-1 <?= $priorite == 2 ? 'active' : '' ?>">2</label>
                            </div>
                            <div class="form-check form-check-inline pl-1 pr-1">
                                <input class="btn-check" type="radio" name="modify_priorite" value="3">
                                <label class="form-check-label h5 pl-1 <?= $priorite == 3 ? 'active' : '' ?>">3</label>
                            </div>
                            <div class="form-check form-check-inline pl-1 pr-1">
                                <input class="btn-check" type="radio" name="modify_priorite" value="4">
                                <label class="form-check-label h5 pl-1 <?= $priorite == 4 ? 'active' : '' ?>">4</label>
                            </div>
                            <div class="form-check form-check-inline pl-1">
                                <input class="btn-check" type="radio" name="modify_priorite" value="5">
                                <label class="form-check-label h5 pl-1 <?= $priorite == 5 ? 'active' : '' ?>">5</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg col-sm-4 mb-2 mb-3 shadow">Modifier</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php
    if (isset($_POST['modify_note']) && isset($_POST['modify_priorite'])) {
        $modify_note = htmlspecialchars($_POST['modify_note']);
        $modify_priorite = htmlspecialchars($_POST['modify_priorite']);
        // echo "Les informations sont bien passées en paramètre et le formulaire fonctionne !";
        $sql2 = "UPDATE blocnote SET note = :note, priorite = :priorite WHERE id = " . (int)$_GET['m'];
        $request2 = $pdo->prepare($sql2);
        $request2->execute(array(
            'note' => $modify_note,
            'priorite' => $modify_priorite
        ));

        echo "<div class='container mt-3 animate__animated animate__fadeIn'>
                <div class='row'>
                    <div class='col-12 text-center'>
                        <div class='alert alert-success h3 animate__animated animate__fadeOut animate__delay-2s' role='alert'>
                            <i class='far fa-check-circle pr-3'></i>
                            La tâche a bien été modifiée !
                        </div>
                    </div>
                </div>
            </div>";

        echo "<script>
        setTimeout('redirection()', 3000);
        </script>";
    }
}
?>