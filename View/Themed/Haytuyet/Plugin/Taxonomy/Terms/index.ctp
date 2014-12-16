<?php
echo $this->Html->css(array('bootstrap-tagsinput'),array('inline'=>false));
echo $this->Html->script(array('typeahead.bundle','bootstrap-tagsinput','tags'),array('inline'=>false));
?>
<script>
    var tagsData = '<?php echo $this->request->here;?>';
</script>
<div class="col-md-7 content">
    <input type="text" id="test" />
<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/16/14
 * Time: 2:18 PM
 */
debug($terms);
?>

</div>
