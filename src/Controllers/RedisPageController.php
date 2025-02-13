<?php
namespace Shahbazi\RedisManager\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class RedisPageController extends Controller{

    const REDIS_STRING = 1;
    const REDIS_SET = 2;
    const REDIS_LIST = 3;
    const REDIS_ZSET = 4;
    const REDIS_HASH = 5;

    public function managePage(){
        $data = $this->getAllRedisData();
        return view('redis-manager::manage', compact('data'));
    }


    private function getAllRedisData()
    {
        $keys = Redis::keys('*');
        $data = [];
        $prefix = config('database.redis.options.prefix');
        foreach ($keys as $key) {
            $key = substr($key, strlen($prefix));

            $type = Redis::type($key);
            switch ($type) {  
                case self::REDIS_STRING:  
                    $data['STRING'][$key] = Redis::get($key);
                    break;  
                case self::REDIS_SET:  
                    $data['SET'][$key] = Redis::smembers($key);  
                    break;
                case self::REDIS_LIST:  
                    $data['LIST'][$key] = Redis::lrange($key, 0, -1);  
                    break;
                case self::REDIS_ZSET:  
                    $data['ZSET'][$key] = Redis::zrange($key, 0, -1);  
                    break;  
                case self::REDIS_HASH:  
                    $data['HASH'][$key] = Redis::hgetall($key);  
                    break;  
                default:  
                    $data[$key] = 'Unsupported type';  
                    break;  
            }
        }
    
        return $data;
    }

    public function delete()
    {
        Redis::del(request('key'));
        return redirect()->back();
    }
}
