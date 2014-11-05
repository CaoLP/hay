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
            $this->Form->inputDefaults (array (
                'div'=>array('class'=>'form-group'),
                'class'=>'form-control'
            ));
            echo $this->Form->input('title');
            echo $this->Form->input('image', array('type'=>'file'));
            ?>
            <div class="form-group">
                <em style="font-size: 11px">*Bỏ trống nếu bạn muốn dùng image của clip</em>
            </div>
            <?php
            echo $this->Form->input('youtube_clip');
            ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Đăng bài</button>
            </div>
            <?php echo $this->Form->end();?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->