<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');

    class DataSet implements Iterator {

        protected $data = null;
        protected $ordre = null;
        protected $direction = null;

        public function __construct($data, $ordre, $direction) {
            $this->data = $data;
            $this->ordre = $ordre;
            $this->direction = $direction;
        }

        public function current() {
            return current($this->data);
        }

        public function key() {
            return key($this->data);
        }

        public function next() {
            return next($this->data);
        }

        public function rewind() {
            return reset($this->data);
        }

        public function valid() {
            return key($this->data) !== null; 
        }

        public function getOrdre() {
            return $this->ordre;
        }

        public function getDirection() {
            return $this->direction;
        }
    }