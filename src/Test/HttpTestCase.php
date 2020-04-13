<?php

namespace Anso\Framework\Http\Test;

use Anso\Framework\Base\Configuration;
use Anso\Framework\Base\Container;
use Anso\Framework\Base\Test\DB\DBTestCase;
use Anso\Framework\Base\Contract\Application;
use Anso\Framework\Http\HttpApp;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;

abstract class HttpTestCase extends TestCase
{
    protected Application $app;
    protected EntityManagerInterface $em;
    protected DBTestCase $db;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        if (!defined('BASE_PATH')) {
            define('BASE_PATH', __DIR__ . '/../../../../../');
        }

        $this->app = $this->createApp();

        $this->app->bind(EntityManagerInterface::class, function () {
            $config = include(BASE_PATH . '/config/db_test.php');
            $doctrineConfig = Setup::createAnnotationMetadataConfiguration($config['entity_paths'], $config['dev_mode']);

            return EntityManager::create($config['db_params'], $doctrineConfig);
        });

        $this->em = $this->app->make(EntityManagerInterface::class);
        $this->db = new DBTestCase($this->em);
    }

    private final function createApp(): Application
    {
        $configuration = new Configuration('/config/http');
        $container = new Container($configuration);
        $app = new HttpApp($container, $configuration);

        $container->addResolved(Application::class, $app);

        return $app;
    }



    protected function get(string $uri): array
    {
        $this->resetGlobals();
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = $uri;
        $_SERVER['QUERY_STRING'] = explode('?', $uri)[1] ?? '';
        $parameters = explode('&', $_SERVER['QUERY_STRING']);

        foreach ($parameters as $parameter) {
            $keyValue = explode('=', $parameter);

            if (isset($keyValue[0]) && $keyValue[0]) {
                $_GET[$keyValue[0]] = $keyValue[1] ?? null;
            }
        }

        $this->app->start();

        return json_decode(ob_get_contents(), true);
    }

    protected function post(string $uri, array $body): array
    {
        $this->resetGlobals();
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = $uri;
        $_POST = $body;
        $this->app->start();

        return json_decode(ob_get_contents(), true);
    }

    protected function resetGlobals(): self
    {
        $_SERVER = [];
        $_GET = [];
        $_POST = [];
        $_SERVER['REQUEST_TIME_FLOAT'] = microtime(true);

        return $this;
    }
}