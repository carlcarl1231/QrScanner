<?php

$config = require 'config.php';
$db = new Database($config['database']);

$body_header = "NOTE";

$body_header = 'Note';

$note = $db->query('SELECT * FROM notes WHERE ID = :id', ['id' => $_GET['id']])->find();

if(! $note) {
    abort();
}

require "views/note.view.php";