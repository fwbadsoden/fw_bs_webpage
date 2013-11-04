<?php
/**
 * User: zach
 * Date: 06/04/2013
 * Time: 13:33:19 pm
 */

namespace Elasticsearch\Endpoints\Indices\Alias;

use Elasticsearch\Common\Exceptions;

/**
 * Class Exists
 * @package Elasticsearch\Endpoints\Indices\Exists
 */
class Exists extends AbstractAliasEndpoint
{

    /**
     * @throws \Elasticsearch\Common\Exceptions\RuntimeException
     * @return string
     */
    protected function getURI()
    {

        if (isset($this->name) !== true) {
            throw new Exceptions\RuntimeException(
                'name is required for Get'
            );
        }

        $index = $this->index;
        $name  = $this->name;
        $uri   = "/_alias/$name";

        if (isset($index) === true) {
            $uri = "/$index/_alias/$name";
        }
        return $uri;
    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return array(
            'ignore_indices',
        );
    }

    /**
     * @return string
     */
    protected function getMethod()
    {
        return 'HEAD';
    }
}