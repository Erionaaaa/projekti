<?php
    class Produkti {
        private $id;
        public $titulli;
        public $imazhi;
        public $pershkrimi;
        public $autori;
        public $datetime;

        public function __construct($titulli, $imazhi, $pershkrimi, $autori, $datetime) {
            $this->titulli = $titulli;
            $this->imazhi = $imazhi;
            $this->pershkrimi = $pershkrimi;
            $this->autori = $autori;
            $this->datetime = $datetime;
        }

        public function htmlRepresentation() {
            return "<div class='produkt'>" .
                "<img src='{$this->imazhi}' alt='{$this->titulli}' />" .
                "<h3>{$this->titulli}</h3>" .
                "<p>{$this->pershkrimi}</p>" .
                "<small>Postuar nga: {$this->autori} ne {$this->datetime}</small>" .
                "</div>";
        }
    }
