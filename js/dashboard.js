$(document).ready(function(){
    
    $('#select_organization').on('change', function(){
       $('.select_user').show(); 
       $('.select_organization').find('img').hide();
    });
    
    $('#select_user').on('change', function(){
       $('.select_phone').show(); 
       $('.select_user').find('img').hide()
    });
    
    $('#select_phone').on('change', function(){
       $('.select_phone').find('img').hide()
    });
        
});