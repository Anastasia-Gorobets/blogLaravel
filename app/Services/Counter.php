<?php
namespace App\Services;

use App\Contracts\CounterContract;
use Illuminate\Contracts\Cache\Factory as Cache;
use Illuminate\Contracts\Session\Session as Session;

class Counter implements CounterContract {

    private $timeout;
    private $cache;
    private $session;
    private $supoortTags;

   public function __construct(Cache $cache, Session $session, int $timeout)
   {
       $this->timeout = $timeout;
       $this->cache = $cache;
       $this->session = $session;
       $this->supoortTags = method_exists($cache, 'tags');
   }

    public function increment(string $key, array  $tags = null):int{

        $sessionId = $this->session->getId();
        $counterKey = "$key-counter";
        $userKey = "$key-users";

        $cache  = $this->supoortTags  && $tags !== null ? $this->cache->tags($tags) : $this->cache;

        $users = $cache->get($userKey,[]);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach ($users as $session=>$lastVisit){
            if($now->diffInMinutes($lastVisit) >= $this->timeout){
                $difference--;
            }else{
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(!array_key_exists($sessionId,$users) || $now->diffInMinutes($users[$sessionId]) >= $this->timeout){
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;

        $cache->forever($userKey,$usersUpdate);

        if(!$cache->has($counterKey)){
            $cache->forever($counterKey, 1);
        }else{
            $cache->increment($counterKey, $difference);
        }

        return $cache->get($counterKey);

    }

}
