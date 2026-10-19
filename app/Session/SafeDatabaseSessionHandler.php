<?php

namespace App\Session;

use Illuminate\Database\QueryException;
use Illuminate\Session\DatabaseSessionHandler as BaseDatabaseSessionHandler;

class SafeDatabaseSessionHandler extends BaseDatabaseSessionHandler
{
    /**
     * Perform an insert operation on the session ID.
     *
     * @param  string  $sessionId
     * @param  array<string, mixed>  $payload
     * @return bool|null
     */
    protected function performInsert($sessionId, $payload)
    {
        try {
            return parent::performInsert($sessionId, $payload);
        } catch (QueryException $e) {
            // Jika kolom user_id masih BIGINT dan menolak string ID pelanggan (seperti 'MS...')
            if (isset($payload['user_id']) && !is_numeric($payload['user_id'])) {
                $payload['user_id'] = null;
                return parent::performInsert($sessionId, $payload);
            }

            throw $e;
        }
    }

    /**
     * Perform an update operation on the session ID.
     *
     * @param  string  $sessionId
     * @param  array<string, mixed>  $payload
     * @return int
     */
    protected function performUpdate($sessionId, $payload)
    {
        try {
            return parent::performUpdate($sessionId, $payload);
        } catch (QueryException $e) {
            // Jika kolom user_id masih BIGINT dan menolak string ID pelanggan (seperti 'MS...')
            if (isset($payload['user_id']) && !is_numeric($payload['user_id'])) {
                $payload['user_id'] = null;
                return parent::performUpdate($sessionId, $payload);
            }

            throw $e;
        }
    }
}
