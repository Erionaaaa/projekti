<?php
    class Lajmi {
        private $id;
        public $titulli;
        public $pershkrimi;
        public $autori;
        public $datetime;

        public function __construct($titulli, $pershkrimi, $autori, $datetime) {
            $this->titulli = $titulli;
            $this->pershkrimi = $pershkrimi;
            $this->autori = $autori;
            $this->datetime = $datetime;
        }

        public function htmlRepresentation() {
            return "<div class='lajmi'>" .
                "<h3>{$this->titulli}</h3>" .
                "<p>{$this->pershkrimi}</p>" .
                "<small>Postuar nga: {$this->autori} ne {$this->datetime}</small>" .
                "</div>";
        }
    }
