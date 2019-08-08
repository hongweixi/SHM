# SHM

使用 PHP 直接在共享内存中存储数据集

## 参考文章

https://www.ibm.com/developerworks/cn/opensource/os-php-shared-memory/

https://www.php.net/manual/zh/book.shmop.php

## 例子
```
//创建内存段，随机ID
$memory = new Block;
$memory->write('Sample');
echo $memory->read();

//指定ID，创建和读取内存段
$new = new Block(897);
$new->write('Sample');
echo $new->read();

//读取已存在的内存段
$existing = new Block(42);
echo $existing->read();
```