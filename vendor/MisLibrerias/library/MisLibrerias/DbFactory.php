<?php
namespace MisLibrerias;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\DBAL\Connection;

/**
 * @author  Rafał Książek
 */
class DbFactory
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Create connection to database
     *
     * @param string $dbName
     * @return \Doctrine\DBAL\Connection
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function getConnectionToDatabase($dbName)
    {
        $config = $this->getConfig();

        if (empty($config['doctrine']['connection']['orm_default']['params'])) {
            throw new \InvalidArgumentException('There is insufficient data in the configuration file!');
        }

        $params           = $config['doctrine']['connection']['orm_default']['params'];
        $params['dbname'] = $dbName;
        $params['driver'] = 'pdo_pgsql';

        if (!($dbConnection = DriverManager::getConnection($params)))
            throw new \Exception('There was a problem with establish connection to client db');

        return $dbConnection;
    }

    /**
     *
     * @param \Doctrine\DBAL\Connection $dbConnection
     * @param \Doctrine\ORM\Configuration $config
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager(Connection $dbConnection, Configuration $config)
    {
        return EntityManager::create($dbConnection, $config);
    }

}