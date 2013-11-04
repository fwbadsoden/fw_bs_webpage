<?php
/**
 * User: zach
 * Date: 6/20/13
 * Time: 9:04 AM
 */

namespace Elasticsearch\Serializers;

/**
 * Class EverythingToJSONSerializer
 * @category Elasticsearch
 * @package Elasticsearch\Serializers
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class EverythingToJSONSerializer implements SerializerInterface
{

    /**
     * Serialize assoc array into JSON string
     *
     * @param string|array $data Assoc array to encode into JSON
     *
     * @return string
     */
    public function serialize($data)
    {
        return json_encode($data);
    }


    /**
     * Deserialize JSON into an assoc array
     *
     * @param string $data JSON encoded string
     *
     * @return array
     */
    public function deserialize($data)
    {
        return json_decode($data, true);

    }
}