<?php
/* ===========================================================================
 * Opis Project
 * http://opis.io
 * ===========================================================================
 * Copyright 2013 Marius Sarca
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================================ */

namespace Opis\Session\Storage;

use Opis\Session\SessionStorage;
use Opis\Session\SessionHandlerInterface;

class File extends SessionStorage implements SessionHandlerInterface
{
    /** @var string Path. */
    protected $path;
    
    /**
     * Constructor
     *
     * @access public
     * @param string $path Folder path.
     */
    
    public function __construct($path)
    {
        $this->path = $path;
    }
    
    /**
     * Destructor.
     *
     * @access  public
     */

    public function __destruct()
    {
        parent::__destruct();
        session_write_close();
        // Fixes issue with Debian and Ubuntu session garbage collection
        if(mt_rand(1, 100) === 100)
        {
            $this->sessionGarbageCollector(ini_get('session.gc_maxlifetime'));
        }
    }

    /**
     * Open session.
     *
     * @access  public
     * @param   string   $savePath     Save path
     * @param   string   $sessionName  Session name
     * @return  boolean
     */

    public function sessionOpen($savePath, $sessionName)
    {
        return true;
    }

    /**
     * Close session.
     *
     * @access  public
     * @return  boolean
     */

    public function sessionClose()
    {
        return true;
    }

    /**
     * Returns session data.
     *
     * @access  public
     * @param   string  $id  Session id
     * @return  string
     */

    public function sessionRead($id)
    {
        $data = '';
        if(file_exists($this->path . '/' . $id) && is_readable($this->path . '/' . $id))
        {
            $data = (string) file_get_contents($this->path . '/' . $id);
        }
        return $data;
    }

    /**
     * Writes data to the session.
     *
     * @access  public
     * @param   string  $id    Session id
     * @param   string  $data  Session data
     */

    public function sessionWrite($id, $data)
    {
        if(is_writable($this->path))
        {
            return file_put_contents($this->path . '/' . $id, $data) === false ? false : true;
        }
        return false;
    }

    /**
     * Destroys the session.
     *
     * @access  public
     * @param   string   $id  Session id
     * @return  boolean
     */

    public function sessionDestroy($id)
    {
        if(file_exists($this->path . '/' . $id) && is_writable($this->path . '/' . $id))
        {
            return unlink($this->path . '/' . $id);
        }
        return false;
    }

    /**
     * Garbage collector.
     *
     * @access  public
     * @param   int      $maxLifetime  Lifetime in secods
     * @return  boolean
     */

    public function sessionGarbageCollector($maxLifetime)
    {
        $files = glob($this->path . '/*');
        if(is_array($files))
        {
            foreach($files as $file)
            {
                if((filemtime($file) + $maxLifetime) < time() && is_writable($file))
                {
                    unlink($file);
                }
            }
        }
        return true;
    }
}