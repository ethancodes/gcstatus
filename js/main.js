jQuery(document).ready(function($) {
  
  $('.filters select').on(
    'change',
    updateFilters
  );
  
});

function updateFilters() {
  
  var criteria = "";
  
  var filter_type = $('select[name="filter_type"]').val();
  var filter_room = $('select[name="filter_room"]').val();
  var filter_rest = $('select[name="filter_restroom"]').val();
  var filter_ac   = $('select[name="filter_ac"]').val();
  
  $('table tbody tr').show();
  if (
    filter_type == '' && 
    filter_room == '' && 
    filter_rest == '' &&
    filter_ac   == ''
  ) {
    // show everything
    
  } else {
    var class_type = '';
    if (filter_type) {
      class_type = '.' + filter_type;
    }
    var class_room = '';
    if (filter_room) {
      class_room = '.room-' + filter_room;
    }
    var class_rest = '';
    if (filter_rest) {
      class_rest = '.restroom-' + filter_rest;
    }
    var class_ac = '';
    if (filter_ac) {
      class_ac = '.ac';
    }
    
    
    var all_classes = class_type + class_room + class_rest + class_ac;
    console.log(all_classes);
    $('table tbody tr').not(all_classes.trim()).hide();
  }
  
}

