<?php


function heuristic($a, $b) {
    return abs($a[0] - $b[0]) + abs($a[1] - $b[1]);
}

function lowestFScoreNode($openSet, $fScore) {
    $lowestNode = null;
    $lowestFScore = null;

    foreach ($openSet as $node) {
        if (isset($fScore[$node[0]][$node[1]]) && ($lowestFScore === null || $fScore[$node[0]][$node[1]] < $lowestFScore)) {
            $lowestNode = $node;
            $lowestFScore = $fScore[$node[0]][$node[1]];
        }
    }

    return $lowestNode;
}

function removeNode($array, $node) {
    $index = array_search($node, $array);
    if ($index !== false) {
        array_splice($array, $index, 1);
    }
    return $array;
}

function getNeighbors($maze, $node) {
    $neighbors = array();
    $rows = count($maze);
    $cols = count($maze[0]);

    $delta = array(
        array(-1, 0), // up
        array(0, 1),  // right
        array(1, 0),  // down
        array(0, -1)  // left
    );

    foreach ($delta as $d) {
        $row = $node[0] + $d[0];
        $col = $node[1] + $d[1];
        if ($row >= 0 && $row < $rows && $col >= 0 && $col < $cols && $maze[$row][$col] !== 0) {
            $neighbors[] = array($row, $col);
        }
    }

    return $neighbors;
}


function findShortestPath($maze, $start, $end) {
    $openSet = array($start);
    $closedSet = array();

    $gScore = array();
    $gScore[$start[0]][$start[1]] = 0;

    $fScore = array();
    $fScore[$start[0]][$start[1]] = heuristic($start, $end);

    // track the previous node that leads to each node in the shortest path
    $cameFrom = array();

    while (!empty($openSet)) {
        $currentNode = lowestFScoreNode($openSet, $fScore);
        if ($currentNode == $end) {
            // tracing back from the end node to the start node
            $path = array($end);
            while (isset($cameFrom[$path[0][0]][$path[0][1]])) {
                array_unshift($path, $cameFrom[$path[0][0]][$path[0][1]]);
            }
            return array(
                'distance' => $gScore[$end[0]][$end[1]],
                'path' => $path
            );
        }

        $openSet = removeNode($openSet, $currentNode);
        $closedSet[] = $currentNode;

        foreach (getNeighbors($maze, $currentNode) as $neighbor) {
            if (in_array($neighbor, $closedSet)) {
                continue;
            }

            $tentativeGScore = $gScore[$currentNode[0]][$currentNode[1]] + $maze[$neighbor[0]][$neighbor[1]];
            if (!in_array($neighbor, $openSet) || $tentativeGScore < $gScore[$neighbor[0]][$neighbor[1]]) {
                $gScore[$neighbor[0]][$neighbor[1]] = $tentativeGScore;
                $fScore[$neighbor[0]][$neighbor[1]] = $tentativeGScore + heuristic($neighbor, $end);

                // Update the previous node for this neighbor
                $cameFrom[$neighbor[0]][$neighbor[1]] = $currentNode;

                if (!in_array($neighbor, $openSet)) {
                    $openSet[] = $neighbor;
                }
            }
        }
    }

    return null;
}


    
$maze = array(
    array(1, 2, 3, 0),
    array(0, 4, 5, 0),
    array(0, 0, 6, 7),
    array(0, 8, 9, 10),
);

$start = array(0, 0);
$end = array(3, 3);

$result = findShortestPath($maze, $start, $end);

if ($result === null) {
    echo "\nNo path found";
} else {
    echo "\nShortest distance : " . $result['distance'];
    
    echo "\nShortest path : ";
    foreach ($result['path'] as $node) {
        echo "[" . $node[0] . "," . $node[1] . "]  ";
	}
}


