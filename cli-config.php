<?php
/**
 * The config file is responsible to make class loading work and initialize a
 * DocumentManagerHelper that contains the doctrine document manager with a
 * Session of your phcpr implementation.
 * The array $extraCommands can be used to inject implementation specific commands.
 * Add instances of commands for eventual implementation specific commands to this array.
 */

$extraCommands = array();
$extraCommands[] = new \Jackalope\Tools\Console\Command\InitDoctrineDbalCommand();

$params = array(
    'driver'    => 'pdo_mysql',
    'host'      => 'localhost',
    'user'      => 'root',
    'password'  => '',
    'dbname'    => 'dcms_routing_test',
);

$dbConn = \Doctrine\DBAL\DriverManager::getConnection($params);

$workspace = 'default';
$user = 'admin';
$pass = 'admin';

/* only create a session if this is not about the server control command */
if (isset($argv[1])
    && $argv[1] != 'jackalope:init:dbal'
    && $argv[1] != 'list'
    && $argv[1] != 'help'
) {
    $repository = \Jackalope\RepositoryFactoryDoctrineDBAL::getRepository(array('jackalope.doctrine_dbal_connection' => $dbConn));
    $credentials = new \PHPCR\SimpleCredentials(null, null);
    $session = $repository->login($credentials, $workspace);

    /* prepare the doctrine configuration */
    $config = new \Doctrine\ODM\PHPCR\Configuration();

    $dm = \Doctrine\ODM\PHPCR\DocumentManager::create($session, $config);

    $helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
        'dm' => new \Doctrine\ODM\PHPCR\Tools\Console\Helper\DocumentManagerHelper(null, $dm)
    ));
} else if (isset($argv[1]) && $argv[1] == 'jackalope:init:dbal') {
    // special case: the init command needs the db connection, but a session is impossible if the db is not yet initialized
    $helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
        'connection' => new \Jackalope\Tools\Console\Helper\DoctrineDbalHelper($dbConn)
    ));
}
