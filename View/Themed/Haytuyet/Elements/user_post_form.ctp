<div class="modal fade" id="user-post-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo $this->Form->create('Node',array(
                'url'=>array('plugin'=>'nodes','controller'=>'nodes','action'=>'user_post'),
                'method'=>'post',
                'enctype'=>'multipart/form-data'
            ));?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Đăng bài</h4>
            </div>
            <div class="modal-body">
                <?php
                $this->Form->inputDefaults(array(
                    'div' => array('class' => 'form-group'),
                    'class' => 'form-control'
                ));
                echo $this->Form->input('title');
                ?>
                <div class="form-group">
                    <a href="javascript:;" class="pull-right" type="button" data-toggle="collapse" data-target="#demo"
                       aria-expanded="true" aria-controls="demo">
                        Ảnh thay thế
                    </a>
                </div>
                <div id="demo" class="collapse ">
                    <div class="form-group">
                        <em style="font-size: 11px">*Bỏ qua bước này nếu bạn muốn sử dụng hình ảnh mặc định của clip.<br>*Thêm link
                            hình ảnh vào "Đường dẫn hình ảnh" nếu bạn muốn dùng hình ảnh từ nơi khác hoặc Upload hình ảnh lên server
                            với đường dẫn bên dưới</em>
                    </div>
                    <?php
                    echo $this->Form->input('link_image', array('label' => array('text' => 'Đường dẫn hình ảnh')));
                    ?>
                    <?php
                    echo $this->Form->input('image', array('label' => array('text' => 'Upload'), 'type' => 'file'));
                    ?>
                    <div class="form-group">
                        <em style="font-size: 11px">*Giới hạn dung lượng 500kb</em>
                    </div>
                </div>
                <?php
                echo $this->Form->input('youtube_clip', array('label' => array('text' => 'Link Clip Youtube'), 'required' => 'required'));
                ?>
                <!--
                <div class="form-group">
                    <label>Mã bảo mật</label>
                    <?php
                   // $this->Captcha->render(array('model'=>'Node','clabel'=>'Mã bảo mật','reload_txt'=>'Mã số khác'));
                    ?>
                </div>
                -->
                <div class="form-group">
                    <h3>Nội quy đăng bài</h3>
                    <div class="well well-lg">
                        <p><em style="font-size: 11px"><i class="fa fa-bookmark"></i> Các bạn xem kỹ trước khi đăng bài nếu không bài đăng của bạn sẽ bị xóa.</em></p>
                        <p><em style="font-size: 11px"><i class="fa fa-bookmark"></i> Tiêu đề tiếng Việt cần phải có dấu. Bài viết tiêu đề
                                không dấu sẽ bị xóa.</em></p>
                        <p><em style="font-size: 11px"><i class="fa fa-bookmark"></i> Không đăng Video đã bị trùng. Hạn chế đăng clip LMHT, 1 ngày chỉ được đăng 3 clip LMHT </em></p>
                        <p><em style="font-size: 11px"><i class="fa fa-bookmark"></i> Không đăng video tự sướng, dìm hàng, phản động, đồi trụy, trái với thuần phong mỹ tục</em></p>
                        <p><em style="font-size: 11px"><i class="fa fa-bookmark"></i> Không đăng video liên quan đến các vấn đề chính trị,tôn giáo</em></p>
                        <p><em style="font-size: 11px"><i class="fa fa-bookmark"></i> Video của bạn phải đặc sắc, hấp dẫn hoặc hài hước và phải từ 360p trở lên</em></p>
                        <p><em style="font-size: 11px"><i class="fa fa-bookmark"></i> Hãy đặt tiêu đề một cách sáng tạo. Tránh đặt
                                kiểu như: "hay vãi", "chuẩn", ":))"...Không đặt tiêu đề câu like.</em></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Đăng bài</button>
            </div>
            <?php echo $this->Form->end();?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
$this->Html->scriptStart(array('inline' => false));
?>
    jQuery('.creload').on('click', function() {
    var mySrc = jQuery(this).prev().attr('src');
    var glue = '?';
    if(mySrc.indexOf('?')!=-1)  {
    glue = '&';
    }
    jQuery(this).prev().attr('src', mySrc + glue + new Date().getTime());
    return false;
    });
<?php
$this->Html->scriptEnd();
?>