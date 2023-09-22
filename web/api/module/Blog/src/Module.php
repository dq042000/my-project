<?php

namespace Blog;

class Module
{
    public function getConfig() : array
    {
        /**
         * 設定檔可能會變得相當大，
         * 並且將所有內容都保留在getConfig()方法內並不是最佳選擇。
         * 為了幫助保持我們的專案井井有條，
         * 我們將把數組配置放在一個單獨的檔案中。
         */
        return include __DIR__ . '/../config/module.config.php'; 
    }
}