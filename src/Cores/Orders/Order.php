<?php

namespace Yan9\Orderforys\Cores\Orders;

class Order
{
    private const CLASS_NAME_DEFAULT =  'Yan9\Orderforys\Cores\Orders\OrderInfo';
    private $className;

    public function __construct($version = 0)
    {
        $this->className = $version == 0 ? self::CLASS_NAME_DEFAULT : self::CLASS_NAME_DEFAULT . $version;
    }

    public function __call($name, $arguments)
    {
        //跨类调用方法
        return call_user_func_array([(new $this->className),$name],$arguments);
    }
}
