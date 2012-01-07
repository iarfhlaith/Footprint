<?php
/**
 * The URL for the server.
 *
 * This is the location of server.php. For example:
 *
 * $server_url = 'http://example.com/~user/server.php';
 *
 * This must be a full URL.
 */
$server_url = "http://webstrong.footprintapp.local/app/inc/plugins/openID/examples/server/server.php";

/**
 * Initialize an OpenID store
 *
 * @return object $store an instance of OpenID store (see the
 * documentation for how to create one)
 */
function getOpenIDStore()
{
    require_once 'Auth/OpenID/MySQLStore.php';
    require_once 'MDB2.php';

    $dsn = array(
                 'phptype'  => 'mysql',
                 'username' => 'shortie_user',
                 'password' => 'synaptomax',
                 'hostspec' => '84.51.233.254'
                 );

    $db =& MDB2::connect($dsn);

    if (PEAR::isError($db)) {
        return null;
    }

    $db->query("USE shortie_db");
        
    $s =& new Auth_OpenID_MySQLStore($db);

    $s->createTables();

    return $s;
}

?>