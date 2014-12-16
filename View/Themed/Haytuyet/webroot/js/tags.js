/**
 * Created by user on 12/16/14.
 */
$(function(){
    var tags = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '/taxonomy/terms/index/2',
        filter: function(list) {
            return $.map(list, function(tag) {
                return { name: tag }; });
        }
    });
    tags.initialize();

    var elt = $('#tag-input');
    elt.tagsinput({
        typeaheadjs: {
            name: 'citynames',
            displayKey: 'name',
            valueKey: 'name',
            source: tags.ttAdapter()
        }
    });
   $('#tag-save').on('click',function(){

   });
});