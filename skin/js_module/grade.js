//var _$_6cb5=["\x65\x6D\x70\x6C\x6F\x79\x65\x65\x2F\x74\x72\x61\x76\x65\x6C\x73\x2F\x74\x72\x61\x76\x65\x6C\x5F\x6C\x69\x73\x74\x2F","\x47\x45\x54","\x74\x6F\x6F\x6C\x74\x69\x70","\x5B\x64\x61\x74\x61\x2D\x74\x6F\x67\x67\x6C\x65\x3D\x22\x74\x6F\x6F\x6C\x74\x69\x70\x22\x5D","\x64\x61\x74\x61\x54\x61\x62\x6C\x65","\x23\x78\x69\x6E\x5F\x74\x61\x62\x6C\x65","\x73\x68\x6F\x77\x2E\x62\x73\x2E\x6D\x6F\x64\x61\x6C","\x72\x65\x6C\x61\x74\x65\x64\x54\x61\x72\x67\x65\x74","\x74\x72\x61\x76\x65\x6C\x5F\x69\x64","\x64\x61\x74\x61","\x74\x72\x61\x76\x65\x6C\x2F\x72\x65\x61\x64\x2F","\x6A\x64\x3D\x31\x26\x69\x73\x5F\x61\x6A\x61\x78\x3D\x31\x26\x6D\x6F\x64\x65\x3D\x76\x69\x65\x77\x5F\x6D\x6F\x64\x61\x6C\x26\x64\x61\x74\x61\x3D\x76\x69\x65\x77\x5F\x74\x72\x61\x76\x65\x6C\x26\x74\x72\x61\x76\x65\x6C\x5F\x69\x64\x3D","\x68\x74\x6D\x6C","\x23\x61\x6A\x61\x78\x5F\x6D\x6F\x64\x61\x6C\x5F\x76\x69\x65\x77","\x61\x6A\x61\x78","\x6F\x6E","\x2E\x76\x69\x65\x77\x2D\x6D\x6F\x64\x61\x6C\x2D\x64\x61\x74\x61","\x72\x65\x61\x64\x79"];$(document)[_$_6cb5[17]](function(){var a=$(_$_6cb5[5])[_$_6cb5[4]]({"\x62\x44\x65\x73\x74\x72\x6F\x79":true,"\x61\x6A\x61\x78":{url:site_url+ _$_6cb5[0],type:_$_6cb5[1]},"\x66\x6E\x44\x72\x61\x77\x43\x61\x6C\x6C\x62\x61\x63\x6B":function(b){$(_$_6cb5[3])[_$_6cb5[2]]()}});$(_$_6cb5[16])[_$_6cb5[15]](_$_6cb5[6],function(d){var c=$(d[_$_6cb5[7]]);var f=c[_$_6cb5[9]](_$_6cb5[8]);var e=$(this);$[_$_6cb5[14]]({url:site_url+ _$_6cb5[10],type:_$_6cb5[1],data:_$_6cb5[11]+ f,success:function(g){if(g){$(_$_6cb5[13])[_$_6cb5[12]](g)}}})})})
	
$(document).ready(function() {
    var a = $("#xin_table")['dataTable']({
        "bDestroy": true,
        "ajax": {
            url: site_url + "grade/grade_list/",
            type: "GET"
        },
        "fnDrawCallback": function(b) {
            $('[data-toggle="tooltip"]')['tooltip']()
        }
    });
	
	
	$(".note-children-container")['hide']();
    $("#delete_record")['submit'](function(d) {
        d["preventDefault"]();
        var f = $(this),
            c = f['attr']("name");
        $["ajax"]({
            type: "POST",
            url: d["target"]["action"],
            data: f["serialize"]() + "&is_ajax=2&form=" + c,
            cache: false,
            success: function(g) {
                if (g["error"] != "") {
                    toastr["error"](g["error"])
                } else {
                    $(".delete-modal")["modal"]("toggle");
                    a["api"]()["ajax"]["reload"](function() {
                        toastr["success"](g["result"])
                    }, true)
                }
            }
        })
    });

    $(".edit-modal-data")["on"]("show.bs.modal", function(d) {
        var c = $(d["relatedTarget"]);
        var f = c["data"]("id");
        var e = $(this);
        $["ajax"]({
            url: base_url + "/read/",
            type: "GET",
            data: "jd=1&is_ajax=1&mode=modal&data=edit_grade&id=" + f,
            success: function(g) {
                if (g) {
                    $("#ajax_modal")["html"](g)
                }
            }
        })
    });
	
    $(".view-modal-data")["on"]("show.bs.modal", function(d) {		
        var c = $(d["relatedTarget"]);
		var f = c["data"]("id");
        var e = $(this);
        $["ajax"]({
            url: site_url + "Grade/read/",
            type: "GET",
            data: "jd=1&is_ajax=1&mode=view_modal&data=view_grade&id=" + f,
            success: function(g) {
                if (g) {
                    $("#ajax_modal_view")["html"](g)
                }
            }
        })
    })
	

    $('[data-plugin="select_hrm "]')['select2']($(this)["attr"]("data-options"));
    $('[data-plugin="select_hrm "]')['select2']({
        width: '100%'
    });


	$("#xin-form")["submit"](function(d) {
    var s = new FormData(this);
    var f = $(this);
    var c = f["attr"]("name");
    s["append"]("is_ajax", 1);
    s["append"]("add_type", "add_grade");
    s["append"]("form", c);
    d["preventDefault"]();
    $(".icon-spinner3")["show"]();
    $(".save")["prop"]("disabled", true);
    $["ajax"]({
        url: d["target"]["action"],
        type: "POST",
        data: s,
        contentType: false,
        cache: false,
        processData: false,
        success: function(g) {
            if (g["error"] != "") {
                toastr["error"](g["error"]);
                $(".save")["prop"]("disabled", false);
                $(".icon-spinner3")["hide"]();
            } else {
                a["api"]()["ajax"]["reload"](function() {
                    toastr["success"](g["result"]);
                }, true);
                $(".icon-spinner3")["hide"]();
                $(".add-form")["fadeOut"]("slow");
                $("#xin-form")[0]["reset"]();
                $(".save")["prop"]("disabled", false);
            }
        },
        error: function() {
            toastr["error"](JSON["error"]);
            $(".icon-spinner3")["hide"]();
            $(".save")["prop"]("disabled", false);
        }
    });
});

	

});


