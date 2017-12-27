<?php

/**
 * Created by PhpStorm.
 * User: renwuxun
 * Date: 12-27 00027
 * Time: 16:32
 */

class Core_Helper_Shm {

    private $iShmid = 0;
    private $iKey;
    private $iSize;

    /**
     * @param $iKey int
     * @param $iSize int
     */
    public function __construct($iKey, $iSize) {
        $this->iKey = $iKey;
        $this->iSize = $iSize;
        $this->open();
    }

    private function open() {
        $this->iShmid = shmop_open($this->iKey, 'c', 0644, $this->iSize);
    }

    /**
     * @param $iAddr
     * @param $iLength
     * @return string
     */
    public function read($iAddr, $iLength) {
        return shmop_read($this->iShmid, $iAddr, $iLength);
    }

    /**
     * @param $sData
     * @param $iAddr
     * @return int
     */
    public function write($sData, $iAddr) {
        return shmop_write($this->iShmid, $sData, $iAddr);
    }

    private function close() {
        if (is_resource($this->iShmid)) {
            shmop_close($this->iShmid);
        }
    }

    /**
     * @return bool
     */
    public function delete() {
        return shmop_delete($this->iShmid);
    }

    public function __destruct() {
        $this->close();
    }

    /**
     * @return int
     */
    public function getKey() {
        return $this->iKey;
    }

    /**
     * @return int
     */
    public function getSize() {
        return $this->iSize;
    }

}
