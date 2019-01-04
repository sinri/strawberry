<?php
/**
 * Created by PhpStorm.
 * User: sinri
 * Date: 2019-01-04
 * Time: 21:42
 */

namespace sinri\strawberry;


use sinri\ark\database\pdo\ArkPDO;
use sinri\ark\database\pdo\ArkPDOConfig;

class Strawberry
{
    /**
     * @var ArkPDO
     */
    protected $pdo;

    protected $warnTime;

    protected $storeDir;

    /**
     * Strawberry constructor.
     * @param $pdoConfigFile
     * @param $warnTime
     * @param $storeDir
     * @throws \Exception
     */
    public function __construct($pdoConfigFile, $warnTime, $storeDir)
    {
        $this->warnTime = $warnTime;
        $this->storeDir = $storeDir;

        self::ensureDir($storeDir);

        $this->loadDatabaseConfig($pdoConfigFile);
    }

    /**
     * @param $dir
     * @throws \Exception
     */
    protected static function ensureDir($dir)
    {
        if (!file_exists($dir)) {
            if (!mkdir($dir, 0777, true)) {
                throw new \Exception("Store Directory Could Not Be Ensured");
            }
        } else {
            if (!is_dir($dir)) {
                throw new \Exception("Directory Existed As File");
            }
        }
    }

    /**
     * @param $pdoConfigFile
     * @throws \Exception
     */
    public function loadDatabaseConfig($pdoConfigFile)
    {
        $config = [];

        require $pdoConfigFile;

        $this->pdo = new ArkPDO(new ArkPDOConfig($config));
        $this->pdo->connect();
    }

    /**
     * @throws \Exception
     */
    public function checkFullProcessList()
    {
        $result = $this->pdo->getAll("show full processlist");
        //var_export($result);

        if (empty($result)) return;
        foreach ($result as $item) {
            if ($item['Command'] != 'Sleep' && $item['Time'] > $this->warnTime) {
                $sql = $item['Info'];

                $hash = md5($sql);

                $target_dir = $this->storeDir . '/' . date('Ymd');
                self::ensureDir($target_dir);
                $target_file = $target_dir . '/' . $hash . '.sql';

                $content = "-- " . date('Y-m-d H:i:s') . " Recorded From: " . $item['Host'] . ' Schema: ' . $item['db'] . " User: " . $item['User'] . PHP_EOL . '-- Least Time: ' . $item['Time'] . PHP_EOL . $sql . PHP_EOL;
                file_put_contents($target_file, $content);
            }
        }
    }
}