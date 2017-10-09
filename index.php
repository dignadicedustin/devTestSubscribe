<?php
    require 'src/Network.php';
    $runScript = true;
    function setNodesFromCsv(){
        $node = array();
        $file = new SplFileObject("data/data.csv");
        $file->setFlags(SplFileObject::READ_CSV);
        $i = 0;
        foreach ($file as $row) {
          $node[$i]['from'] = $row[0];
          $node[$i]['to'] = $row[1];
          $node[$i]['lat'] = $row[2];
          $node[$i]['checked'] = 0;
          $i++;
        }
        return $node;
    }
    function execSearch($from, $to, $lat){
        $nodes = setNodesFromCsv();
        $network = new Network; 
        return $network->search($nodes, $from, $to, $lat);
    }
    while(true){
        fwrite(STDOUT, "Input:");
        $input = explode(' ', trim(fgets(STDIN, 1024)));
        if($input[0] == 'QUIT'){
            break;
        }
        $execSearch = execSearch($input[0], $input[1], $input[2]);
        echo "\nOutput: ", $execSearch, "\n";
    } 

?>