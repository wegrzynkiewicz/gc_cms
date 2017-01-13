<?php

namespace GC;

use GC\Logger;
use GC\Model\Session;
use SessionHandlerInterface;

class SessionHandler implements SessionHandlerInterface
{
    public function open($savePath, $sessionName)
    {
        return true;
    }

    public function close()
    {
        return true;
    }

    public function read($id)
    {
        Container::get('logger')->session($id);

        return Session::select()
            ->fields(['data'])
            ->equals('session_id', $id)
            ->fetch()
            ['data'];
    }

    public function write($id, $data)
    {
        Session::replace([
            'session_id' => $id,
            'update_datetime' => sqldate(),
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        Session::delete()
            ->equals('session_id', $id)
            ->limit(1)
            ->execute();
    }

    public function gc($maxlifetime)
    {
        Session::delete()
            ->condition('`update_datetime` <= ?', sqldate(time() - $maxlifetime))
            ->execute();
    }
}
