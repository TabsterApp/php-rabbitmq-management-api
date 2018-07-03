<?php
/**
 * Created by PhpStorm.
 * User: Bouke Nederstigt
 * Date: 03/07/2018
 * Time: 11:07
 */

namespace Markup\RabbitMq\ManagementApi\Api;

/**
 * Shovel
 *
 * @package Markup\RabbitMq\ManagementApi\Api
 * @author Bouke Nederstigt
 */
class Shovel extends AbstractApi
{
    /**
     * A list of all shovels, or a list of all shovels in a given virtual host.
     *
     * @param string|null $vhost
     * @return array
     */
    public function all($vhost = null)
    {
        if ($vhost) {
            return $this->client->send(sprintf('/api/parameters/shovel/%s', urlencode($vhost)));
        } else {
            return $this->client->send('/api/parameters/shovel');
        }
    }

    /**
     * Get a single shovel
     *
     * @param $vhost
     * @param $name
     * @return array
     */
    public function get($vhost, $name)
    {
        return $this->client->send(sprintf('/api/parameters/shovel/%s/%s', urlencode($vhost), urlencode($name)));
    }

    /**
     * To create a new shovel, you will need a body sth like this:
     *
     *  {
     *      "value": {
     *          "src-uri": "amqp://",
     *          "src-queue": "test",
     *          "dest-uri": "amqp://",
     *          "dest-queue": "test123",
     *          "ack-mode": "on-confirm",
     *          "delete-after": "never"
     *      }
     *  }
     *
     * See https://www.rabbitmq.com/shovel-dynamic.html for more info
     *
     * @param $vhost
     * @param $name
     * @param array $shovel
     * @return array
     */
    public function create($vhost, $name, array $shovel)
    {
        return $this->client->send(sprintf('/api/parameters/shovel/%s/%s', urlencode($vhost), urlencode($name)), 'PUT',
            null,
            $shovel);
    }

    /**
     * Delete a shovel
     *
     * @param  string $vhost
     * @param  string $name
     * @return array
     */
    public function delete($vhost, $name)
    {
        return $this->client->send(sprintf('/api/parameters/shovel/%s/%s', urlencode($vhost), urlencode($name)),
            'DELETE');
    }
}