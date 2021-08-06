<?php

require './Config.php';

class Consumer extends Config {
    public function consume($topic, $group_id) {
        $this->conf->set('group.id', $group_id);
        $topic_config = new RdKafka\TopicConf();
        $topic_config->set('auto.commit.interval.ms', $this->autocommit_ms);
        $kafka_consumer_config = new RdKafka\Consumer($this->conf);
        $kafka_consumer = $kafka_consumer_config->newTopic($topic, $topic_config);
        $kafka_consumer->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);

        while (true) {
            $msg = $kafka_consumer->consume(0, $this->timeout);
            if ($msg === null || $msg->err === RD_KAFKA_RESP_ERR__PARTITION_EOF) {
                continue;
            } elseif ($msg->err) {
                echo 'Error: '. $msg->payload, "\n";
                break;
            } else {
                echo $msg->payload, "\n";
            }
        }
    }
}

$consumer = new Consumer();
$consumer->consume('log', 'my_group_id');