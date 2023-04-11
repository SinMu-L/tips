<?php

/**
 * 剪裁图片
 *
 * @return void
 * @param [type] $source 图片源文件
 * @param [type] $dst   图片等比缩放后的存放文件
 * @param float $percent 缩放比例
 */
function resize($source,$dst,$percent = 0.5){
    // 获取新的尺寸
    list($width, $height) = getimagesize($source);
    $new_width = $width * $percent;
    $new_height = $height * $percent;

    try {
        // 新建一个真彩色图像
        $image_p = imagecreatetruecolor($new_width, $new_height);
        // 获取图像标识符
        $image = imagecreatefrompng($source);
        // 重采样拷贝部分图像并调整大小
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        // 输出到 目标文件中
        imagepng($image_p, $dst, 9);
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}

$filename = __DIR__ . '/images/bg.png';
$dst = __DIR__ . '/hello.png';

$percent = 0.5;

resize($filename,$dst,$percent);
