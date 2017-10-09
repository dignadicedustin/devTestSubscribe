<?php
class Network{
    private $nodes = array();

    public function __construct()
    {
    }
    public function search($nodes, $from, $to, $ms){
        error_reporting(E_ALL);ini_set('display_errors', 1);
        ini_set('max_execution_time', 15);
        $currFrom = $from;
        $limitTo = $to;
        $limitMs = $ms;
        $currLat = 0;
        $path = "";
        $reverse = 0;
        $historyArr = [];
        $try = 1;
        for($a = 0; $a<count($nodes);$a++){
            if($reverse == 1){
                if($currFrom == $nodes[$a]['to'] && $nodes[$a]['checked'] == 0){
                    $historyArr[count($historyArr)] = $a;
                    $path .=  $currFrom."=>";
                    $currFrom = $nodes[$a]['from'];
                    $currLat += $nodes[$a]['lat'];
                    if($currFrom === $limitTo){
                        if($currLat > $limitMs){
                            foreach($historyArr as $hs){
                                $nodes[$hs]['checked'] = 1;
                            }
                        }else{
                            break;
                        }
                    }else{
                        if($currLat > $limitMs){
                            $nodes[$a]['checked'] = 1;
                        }
                        $a = -1;
                    }
                }
            }else{
                if($currFrom == $nodes[$a]['from'] && $nodes[$a]['checked'] == 0){
                    $historyArr[count($historyArr)] = $a;
                    $path .=  $currFrom."=>";
                    $currFrom = $nodes[$a]['to'];
                    $currLat += $nodes[$a]['lat'];
                    if($currFrom === $limitTo){
                        if($currLat > $limitMs){
                            foreach($historyArr as $hs){
                                $nodes[$hs]['checked'] = 1;
                            }
                        }else{
                            break;
                        }
                    }else{
                        if($currLat > $limitMs){
                            $nodes[$a]['checked'] = 1;
                        }
                        $a = -1;
                    }
    
                }
    
            }
            if($currLat > $limitMs){
                $currLat = 0;
                $path = "";
                $currFrom = $from;
                $a = -1;
            }
    
            if($a+1 == count($nodes)){
                if($try == 20){
                    break;
                }
                $currFrom = $from;
                $limitTo = $from;
                $currLat = 0;
                $path = "";
                $reverse = 1;
                $a = -1;
                foreach($nodes as $node){
                    $node['checked'] = 0;
                }
                $try++;
            }
    
        }
        $path = $path.$currFrom;
        if($currLat > $limitMs || $currLat == 0){
            return "Path Not Found!";
        }else{
            return $path. "=>".$currLat;
        }
        exit;
    }
    
}