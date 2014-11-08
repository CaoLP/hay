<?php
$note = array(
    'Website đang chạy thử nghiệm, mong nhận được sự đóng góp ý kiến từ các bạn: <a href="http://www.facebook.com/haytuyetcom">'.Configure::read('Site.title').'</a>',
    'Vừa xem clip, vừa kiếm tiền, xem chi tiết tại <a href="http://www.facebook.com/haytuyetcom">đây</a>',
    'Clip muốn được nhiều người xem phải mới và hấp dẫn.',
    'Lưu ý: Đây là SÂN CHƠI MIỄN PHÍ với môi trường trong sạch và lành mạnh cho các bạn trẻ. Hãy tham gia bằng sự HÀI HƯỚC trong phạm vi VĂN HOÁ và PHÁP LUẬT cho phép.'
);
$random_keys=array_rand($note,1);
?>
<div class="col-md-12">
    <div class="alert alert-warning note" role="alert"><strong>Mẹo:</strong> <?php echo $note[$random_keys];?>
    </div>
</div>