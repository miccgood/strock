/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    $("#field-MATERIAL_ID").change(function(){
        var $materialId = $(this).val();
        var url = base_url + "borrow/getCountMaterialById";
        var dataToBeSent = {materialId: $materialId};

        $.post(url, dataToBeSent, function(data) {
            $("#MATERIAL_BALANCE_input_box").html(data['material_balance']);
         }, "json")
        .done(function(data) {
            $("#MATERIAL_BALANCE_input_box").html(data['material_balance']);
        })
        .fail(function() {
//            $("#report-error").fadeIn(1000).delay(3000).fadeOut(1000);
        })
        .always(function() {
//            console.log( "complete" );
        });

    });
});
