<?php

require './Config.php';

class Producer extends Config {
    public function produce($message, $topic) {
        $kafka_producer_config = new RdKafka\Producer($this->conf);
        $kafka_producer = $kafka_producer_config->newTopic($topic);
        $kafka_producer->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        $kafka_producer->flush($this->timeout);
    }
}

$producer = new Producer();
$producer->produce('sample-message', 'sample-topic');
