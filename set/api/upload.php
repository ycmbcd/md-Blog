<?php
function base64EncodeImage ($image_file) {
    $base64_image = '';
    $image_info = getimagesize($image_file);
    $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
    $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
    return $base64_image;
}
if (isset($_FILES['qrImg'])) {
    $type = $_FILES['qrImg']['type'];
    $file_type = str_replace('image/', '.', $type);
    $file_path = '../../data/temp'.$file_type;
    move_uploaded_file($_FILES['qrImg']['tmp_name'], $file_path);
    echo base64EncodeImage($file_path);
} else {
    echo 'No File';
}