<?php 

$config = require BASE_PATH . 'config.php';

$db = new Database($config['database']);

$heading = 'My Notes';

$notes =$db->query("SELECT * FROM notes WHERE user_id = 1")->get();

require BASE_PATH . 'views/notes.view.php';

