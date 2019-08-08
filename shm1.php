<?php

class Block
{
    //系统ID
    protected $sid;
    //内存段ID
    protected $shmid;
    //权限
    protected $perms = 0644;

    public function __construct($id = null){
        if($id){
            $this->sid = $id;
        }else{
            $this->sid = $this->getSid();
        }
        if($this->exists($this->sid)) {
            $this->shmid = shmop_open($this->sid, "w", 0, 0);
        }
    }

    protected function exists($sid){
        return @shmop_open($sid, 'a', 0, 0);
    }

    public function write($data){
        $size = mb_strlen($data, 'UTF-8');
        if($this->exists($this->sid)){
            shmop_delete($this->shmid);
            shmop_close($this->shmid);
            $this->shmid = shmop_open($this->sid, 'c', $this->perms, $size);
            shmop_write($this->shmid, $data, 0);
        }else{
            $this->shmid = shmop_open($this->sid, 'c', $this->perms, $size);
            shmop_write($this->shmid, $data, 0);
        }
    }

    public function read(){
        $size = shmop_size($this->shmid);
        $data = shmop_read($this->shmid, 0, $size);
        return $data;
    }

    public function delete()
    {
        shmop_delete($this->shmid);
    }

    public function setPermissions($perms)
    {
        $this->perms = $perms;
    }

    protected function getSid(){
        return ftok(__FILE__, 'b');
    }

    public function __destruct()
    {
        shmop_close($this->shmid);
    }
}


