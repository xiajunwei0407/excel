<?php

//导出excel调用实例， 本示例基于Thinkphp5开发，其中的获取数据方式请自行根据实际情况调整

function exportExcel()
{
    $list = $this->model
        ->alias('a')
        ->join('tb_admin b', 'a.user_id = b.id', 'left')
        ->field('a.*,b.username')
        ->order('a.id', 'desc')
        ->select();
    $list = collection($list)->toArray();
    $exportHead = [
        'A1' => '视频分类id',
        'B1' => '视频分类',
        'C1' => '关联标签',
        'D1' => '创建人',
        'E1' => '创建时间'
    ];
    $keyMap = [
        'A' => 'id',
        'B' => 'name',
        'C' => 'label_id_text',
        'D' => 'username',
        'E' => 'create_time_text',
    ];
    $exportData = $exportHead;
    $n = 2;
    end($keyMap);
    $lastKey = key($keyMap);
    foreach ($list as $key => $val) {
        for($i = 'A'; $i <= $lastKey; $i++){
            $index = $i . $n;
            $exportData[$index] = $val[$keyMap[$i]];
        }
        $n++;
    }
    $options = [
        // 所有单元格字体居中
        'alignCenter' => array_keys($exportData),
        // 第一行字体加粗
        'bold'        => array_keys($exportHead),
        // 第一行设置背景色
        'setARGB'     => array_keys($exportHead),
    ];
    Xjw\Excel::export($exportData, '', $options);
}