
$(document)["ready"](function() {
    var a = $("#xin_table")["dataTable"]({
        "bDestroy": true,
        "ajax": {
            url: base_url + "/employees_list/",
            type: "GET"
        },
        "fnDrawCallback": function fnDrawCallback(oSettings) {
            $('[data-toggle="tooltip"]')["tooltip"]();
        }
    });
    $('[data-plugin="select_hrm"]')["select2"]($(this)["attr"]("data-options"));
    $('[data-plugin="select_hrm"]')["select2"]({
        width: "100%"
    });
    $(".date_of_birth")["datepicker"]({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        yearRange: "1960:" + (new Date)["getFullYear"]()
    });
    $(".date_of_joining")["datepicker"]({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        yearRange: "1990:" + ":" + (new Date)["getFullYear"]()
    });
    $("#delete_record")["submit"](function(canCreateDiscussions) {
        canCreateDiscussions["preventDefault"]();
        var $realtime = $(this);
        var showSliderNum = $realtime["attr"]("name");
        $["ajax"]({
            type: "POST",
            url: canCreateDiscussions["target"]["action"],
            data: $realtime["serialize"]() + "&is_ajax=2&form=" + showSliderNum,
            cache: false,
            success: function wrap_list_input(list_input) {
                if (list_input["error"] != "") {
                    toastr["error"](list_input["error"]);
                } else {
                    $(".delete-modal")["modal"]("toggle");
                    a["api"]()["ajax"]["reload"](function() {
                        toastr["success"](list_input["result"]);
                    }, true);
                }
            }
        });
    });
    $(".edit-modal-data")["on"]("show.bs.modal", function(i) {
        var $realtime = $(i["relatedTarget"]);
        var showSliderNum = $realtime["data"]("warning_id");
        var $gBCRBottom = $(this);
        $["ajax"]({
            url: base_url + "/read/",
            type: "GET",
            data: "jd=1&is_ajax=1&mode=modal&data=warning&warning_id=" + showSliderNum,
            success: function success(htmlExercise) {
                if (htmlExercise) {
                    $("#ajax_modal")["html"](htmlExercise);
                }
            }
        });
    });
    jQuery("#aj_department")["change"](function() {
        jQuery["get"](base_url + "/designation/" + jQuery(this)["val"](), function(mmCoreSplitViewBlock, n) {
            jQuery("#designation_ajax")["html"](mmCoreSplitViewBlock);
        });
    });
    // $("#xin-form")["submit"](function(canCreateDiscussions) {
        // canCreateDiscussions["preventDefault"]();
        // var $realtime = $(this);
        // var showSliderNum = $realtime["attr"]("name");
        // $(".save")["prop"]("disabled", true);
        // $["ajax"]({
            // type: "POST",
            // url: canCreateDiscussions["target"]["action"],
            // data: $realtime["serialize"]() + "&is_ajax=1&add_type=employee&form=" + showSliderNum,
            // cache: false,
            // success: function wrap_list_input(list_input) {
                // if (list_input["error"] != "") {
                    // toastr["error"](list_input["error"]);
                    // $(".save")["prop"]("disabled", false);
                // } else {
                    // a["api"]()["ajax"]["reload"](function() {
                        // toastr["success"](list_input["result"]);
                    // }, true);
                    // $(".add-form")["fadeOut"]("slow");
                    // $("#xin-form")["/employees_list/"]["reset"]();
                    // $(".save")["prop"]("disabled", false);
                // }
            // }
        // });
    // });
	
		$("#xin-form")["submit"](function(canCreateDiscussions) {
    var s = new FormData(this);
    var realtime = $(this);
    var showSliderNum = realtime["attr"]("name");
   // var r = $("#description")["code"]();
  //  var n = $("#remark")["code"]();
    s["append"]("is_ajax", 1);
    s["append"]("add_type", "employee");
   // s["append"]("description", r);
   // s["append"]("remark", n);
    s["append"]("form", showSliderNum);
    canCreateDiscussions["preventDefault"]();
    $(".icon-spinner3")["show"]();
    $(".save")["prop"]("disabled", true);
    $["ajax"]({
        url: canCreateDiscussions["target"]["action"],
        type: "POST",
        data: s,
        contentType: false,
        cache: false,
        processData: false,
        success: function wrap_list_input(list_input) {
            if (list_input["error"] != "") {
                toastr["error"](list_input["error"]);
                $(".save")["prop"]("disabled", false);
                $(".icon-spinner3")["hide"]();
            } else {
                a["api"]()["ajax"]["reload"](function() {
                    toastr["success"](list_input["result"]);
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

$(document)["on"]("click", ".delete", function() {
    $("input[name=_token]")["val"]($(this)["data"]("record-id"));
    $("#delete_record")["attr"]("action", base_url + "/delete/" + $(this)["data"]("record-id"));
});
