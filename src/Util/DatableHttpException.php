<?php
/**
 * Created by graphql-client.
 * User: Ruslan Evchev
 * Date: 26.11.16
 * Email: aion.planet.com@gmail.com
 */

namespace GraphQLClient\Util;

class DatableHttpException extends \Exception
{
    /**
     * Return response array according to context spec.
     *
     * @param int $success
     * @param mixed $msg
     * @param mixed $data
     * @return array
     */
    public function contextResponse($success, $msg, $data)
    {
        return [
            'success' => $success,
            'msg' => $msg,
            'data' => $data
        ];
    }
}