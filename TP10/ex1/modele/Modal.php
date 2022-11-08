<?php

//create class Modal
class Modal
{
    private $id;
    private $titre;
    private $message;
    private $lienRetour;

    public function __construct($id, $titre, $message, $lienRetour)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->message = $message;
        $this->lienRetour = $lienRetour;
    }

    public function afficherModal()
    {
        echo "<div class='modal fade' id='$this->id' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>$this->titre</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    $this->message
                </div>
                <div class='modal-footer'>
                    <a class='btn btn-primary' href='$this->lienRetour'>Retour</a>

                </div>
            </div>
        </div>
    </div>";
    }
}



