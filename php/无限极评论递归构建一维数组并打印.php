<?php


$comments = [
    [
        'id' => 1,
        'pid' => 0,
        'content' => 'hello'
    ],
    [
        'id' => 2,
        'pid' => 0,
        'content' => 'hello'
    ],
    [
        'id' => 3,
        'pid' => 0,
        'content' => 'hello'
    ],
    [
        'id' => 4,
        'pid' => 1,
        'content' => 'hello'
    ],
    [
        'id' => 5,
        'pid' => 4,
        'content' => 'hello'
    ],
    [
        'id' => 6,
        'pid' => 2,
        'content' => 'hello'
    ],
    [
        'id' => 7,
        'pid' => 3,
        'content' => 'hello'
    ],
    [
        'id' => 8,
        'pid' => 7,
        'content' => 'hello'
    ],
    [
        'id' => 9,
        'pid' => 8,
        'content' => 'hello'
    ],
];

function getTree($array, $pid =0, $level = 0){

    //声明静态数组,避免递归调用时,多次声明导致数组覆盖
    static $list = [];
    foreach ($array as $key => $value){
        //第一次遍历,找到父节点为根节点的节点 也就是pid=0的节点
        if ($value['pid'] == $pid){
            //父节点为根节点的节点,级别为0，也就是第一级
            $value['level'] = $level;
            //把数组放到list中
            $list[] = $value;
            //把这个节点从数组中移除,减少后续递归消耗
            unset($array[$key]);
            //开始递归,查找父ID为该节点ID的节点,级别则为原级别+1
            getTree($array, $value['id'], $level+1);

        }
    }
    return $list;
}


echo microtime(true) ;
echo "<hr>";

/*
 * 获得递归完的数据,遍历生成分类
 */
$array = getTree($comments);

// echo json_encode($array);

foreach($array as $value){
   echo str_repeat('--', $value['level']), $value['content'].'<br />';
}


echo "<hr>";
echo microtime(true);
