jQuery.noConflict();
(function ($) {
    var styleid = '';
    var childid = '';

    async function Oxi_Image_Admin_Shortcode(functionname, rawdata, styleid, childid, callback) {
        if (functionname === "") {
            alert('Confirm Function Name');
            return false;
        }
        let result;
        try {
            result = await $.ajax({
                url: ImageHoverUltimate.root + 'ImageHoverUltimate/v1/' + functionname,
                method: 'POST',
                dataType: "json",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', ImageHoverUltimate.nonce);
                },
                data: {
                    styleid: styleid,
                    childid: childid,
                    rawdata: rawdata
                }
            });
            console.log(result);
            return callback(result);

        } catch (error) {
            console.error(error);
        }
    }
    jQuery(".oxi-addons-style-clone").on("click", function () {
        $("#oxi-addons-style-modal-form")[0].reset();
        var dataid = jQuery(this).attr('oxiaddonsdataid');
        jQuery('#oxistyleid').val(dataid);
        jQuery("#oxi-addons-style-create-modal").modal("show");
    });
    jQuery("#oxi-import-style").on("click", function () {
        jQuery("#oxi-addons-style-import-modal").modal("show");
    });
    jQuery("#oxi-addons-style-modal-form").submit(function (e) {
        e.preventDefault();
        var rawdata = $('#addons-style-name').val();
        var styleid = $('#oxistyleid').val();
        var functionname = "create_new";
        $('.modal-footer').prepend('<span class="spinner sa-spinner-open-left"></span>');
        Oxi_Image_Admin_Shortcode(functionname, rawdata, styleid, childid, function (callback) {
            setTimeout(function () {
                document.location.href = callback;
            }, 1000);
        });
    });

    jQuery(".oxi-addons-style-delete").submit(function (e) {
        e.preventDefault();
        var $This = $(this);
        var rawdata = 'deleting';
        var styleid = $This.children('#oxideleteid').val();
        var functionname = "shortcode_delete";
        $(this).append('<span class="spinner sa-spinner-open"></span>');
        Oxi_Image_Admin_Shortcode(functionname, rawdata, styleid, childid, function (callback) {
            console.log(callback);
            setTimeout(function () {
                if (callback === "done") {
                    $This.parents('tr').remove();
                }
            }, 1000);
        });

    });
    jQuery(".OxiAddImportDatacontent").on("click", function () {
        jQuery("#OxiAddImportDatacontent").select();
        document.execCommand("copy");
        alert("Your Style Data Copied");
    });
    setTimeout(function () {
        if (jQuery(".table").hasClass("oxi_addons_table_data")) {
            jQuery(".oxi_addons_table_data").DataTable({
                "aLengthMenu": [[7, 25, 50, -1], [7, 25, 50, "All"]],
                "initComplete": function (settings, json) {
                    jQuery(".oxi-addons-row.table-responsive").css("opacity", "1").animate({height: jQuery(".oxi-addons-row.table-responsive").get(0).scrollHeight}, 1000);
                    ;
                }
            });
        }
    }, 500);
    jQuery(".oxi-addons-style-delete .btn.btn-danger").on("click", function () {
        var status = confirm("Do you want to Delete this Shortcode? Before delete kindly confirm that you don't use or already replaced this Shortcode. If deleted will never Restored.");
        if (status == false) {
            return false;
        } else {
            return true;
        }
    });
})(jQuery)