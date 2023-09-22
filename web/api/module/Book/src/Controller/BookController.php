<?php

namespace Book\Controller;

use Base\Controller\BaseController;

class BookController extends BaseController 
{
    // 給要暫存的資料一個名稱
    const ACL_CACHE_KEY = 'acl_service_cache_key';

    public function indexAction()
    {
        $cache = $this->getServiceManager()->get('cacheApc');
        // $cache->flush(); // 清除暫存
        echo "Flushed<br>";
        if ($cache->hasItem(self::ACL_CACHE_KEY)) {
            $acl = $cache->getItem(self::ACL_CACHE_KEY);
            echo $acl->format('Y-m-d H:i:s') . "-Cache<br>";
        } else {
            $acl = new \DateTime();
            $cache->setItem(self::ACL_CACHE_KEY, new \DateTime());
            echo $acl->format('Y-m-d H:i:s') . "-No cache<br>";
        }
        // $cache->removeItem(self::ACL_CACHE_KEY); // 移除暫存
        echo "Hello World!";
        exit;
    }
}