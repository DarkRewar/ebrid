<?php
Database::_init();

if(!is_null(Database::_lastError())){
    if(isset($_messages)){
        add_error($_messages, Database::_lastError()->getMessage());
    }
}

global $user;
$user = user_connected();

# Theme Active
$theme = new EbridTheme(THEME);