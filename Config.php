<?php

require './Constants.php';

class Config {
    protected $conf, $timeout, $autocommit_ms;
    public function __construct() {
        $server = Constants::BOOTSTRAP_SERVER_VALUE;
        $this->autocommit_ms = Constants::AUTOCOMMIT_VALUE_MS;
        $this->timeout = Constants::TIMEOUT_MS;
        $this->conf = new RdKafka\Conf();
        $this->conf->set('bootstrap.servers', $server);
    }
}