	
$(document)["ready"](function() {
    $(".edit-modal-data")["on"]("show.bs.modal", function(arrayOfSelects) {
        var $realtime = $(arrayOfSelects["relatedTarget"]);
        var showSliderNum = $realtime["data"]("field_id");
        var search = $realtime["data"]("field_type");
        if (search == "contact") {
            var m = "&data=emp_contact&type=emp_contact&";
        } else {
            if (search == "document") {
                m = "&data=emp_document&type=emp_document&";
            } else {
                if (search == "qualification") {
                    m = "&data=emp_qualification&type=emp_qualification&";
                } else {
                    if (search == "work_experience") {
                        m = "&data=emp_work_experience&type=emp_work_experience&";
                    } else {
                        if (search == "bank_account") {
                            m = "&data=emp_bank_account&type=emp_bank_account&";
                        } else {
                            if (search == "contract") {
                                m = "&data=emp_contract&type=emp_contract&";
                            } else {
                                if (search == "leave") {
                                    m = "&data=emp_leave&type=emp_leave&";
                                } else {
                                    if (search == "shift") {
                                        m = "&data=emp_shift&type=emp_shift&";
                                    } else {
                                        if (search == "location") {
                                            m = "&data=emp_location&type=emp_location&";
                                        } else {
                                            if (search == "imgdocument") {
                                                m = "&data=e_imgdocument&type=e_imgdocument&";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        var $gBCRBottom = $(this);
        $["ajax"]({
            url: site_url + "employees/dialog_" + search + "/",
            type: "GET",
            data: "jd=1" + m + "field_id=" + showSliderNum,
            success: function success(htmlExercise) {
                if (htmlExercise) {
                    $("#ajax_modal")["html"](htmlExercise);
                }
            }
        });
    });
    // $("#basic_info")["submit"](function(s) {
        // s["preventDefault"]();
        // var $realtime = $(this);
        // var showSliderNum = $realtime["attr"]("name");
        // $(".save")["prop"]("disabled", true);
        // $(".icon-spinner3")["show"]();
        // $["ajax"]({
            // type: "POST",
            // url: s["target"]["action"],
            // data: $realtime["serialize"]() + "&is_ajax=1&data=basic_info&type=basic_info&form=" + showSliderNum,
            // cache: false,
            // success: function success(retu_data) {
                // if (retu_data["error"] != "") {
                    // toastr["error"](retu_data["error"]);
                    // $(".icon-spinner3")["hide"]();
                    // $(".save")["prop"]("disabled", false);
                // } else {
                    // toastr["success"](retu_data["result"]);
                    // $(".icon-spinner3")["hide"]();
                    // $(".save")["prop"]("disabled", false);
                // }
            // }
        // });
    // });
	
		$("#basic_info").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'basic_info');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		$('.save').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(retu_data)
			{
				if (retu_data.error != '') {
					toastr.error(retu_data.error);
						$('.save').prop('disabled', false);
						$('.icon-spinner3').hide();
				} else {
					toastr.success(retu_data.result);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				}
			},
      
	   });
	});
	// $("#basic_info")["submit"](function(s) {
    // var z = new FormData(this);
    // var realtime = $(this);
    // var showSliderNum = realtime["attr"]("name");
    // z["append"]("is_ajax", 1);
    // z["append"]("type", "basic_info");
    // z["append"]("form", showSliderNum);
    // z["preventDefault"]();
    // $(".icon-spinner3")["show"]();
    // $(".save")["prop"]("disabled", true);
    // $["ajax"]({
        // url: s["target"]["action"],
        // type: "POST",
        // data: z,
        // contentType: false,
        // cache: false,
        // processData: false,
            // success: function success(retu_data) {
                // if (retu_data["error"] != "") {
                    // toastr["error"](retu_data["error"]);
                    // $(".icon-spinner3")["hide"]();
                    // $(".save")["prop"]("disabled", false);
                // } else {
                    // toastr["success"](retu_data["result"]);
                    // $(".icon-spinner3")["hide"]();
                    // $(".save")["prop"]("disabled", false);
                // }
            // },
        // error: function() {
            // toastr["error"](JSON["error"]);
            // $(".icon-spinner3")["hide"]();
            // $(".save")["prop"]("disabled", false);
        // }
    // });
// });

    $("#f_profile_picture")["submit"](function(s) {
        var formData = new FormData(this);
        var x = $("#user_id")["val"]();
        var _killcursors = $("#session_id")["val"]();
        $(".icon-spinner3")["show"]();
        var $realtime = $(this);
        var relationName = $realtime["attr"]("name");
        formData["append"]("is_ajax", 2);
        formData["append"]("type", "profile_picture");
        formData["append"]("data", "profile_picture");
        formData["append"]("form", relationName);
        s["preventDefault"]();
        $(".save")["prop"]("disabled", true);
        $["ajax"]({
            url: s["target"]["action"],
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function success(retu_data) {
                if (retu_data["error"] != "") {
                    toastr["error"](retu_data["error"]);
                    $(".save")["prop"]("disabled", false);
                    $(".icon-spinner3")["hide"]();
                } else {
                    toastr["success"](retu_data["result"]);
                    $(".icon-spinner3")["hide"]();
                    $("#remove_file")["show"]();
                    $("#remove_profile_picture")["attr"]("checked", false);
                    $("#u_file")["attr"]("src", retu_data["img"]);
                    if (x == _killcursors) {
                        $(".user_avatar")["attr"]("src", retu_data["img"]);
                    }
                    $(".save")["prop"]("disabled", false);
                }
            },
            error: function validateMandatoryFields() {
                toastr["error"](JSON["error"]);
                $(".icon-spinner3")["hide"]();
                $(".save")["prop"]("disabled", false);
            }
        });
    });
    $("#f_social_networking")["submit"](function(s) {
        s["preventDefault"]();
        var $realtime = $(this);
        var showSliderNum = $realtime["attr"]("name");
        $(".save")["prop"]("disabled", true);
        $(".icon-spinner3")["show"]();
        $["ajax"]({
            type: "POST",
            url: s["target"]["action"],
            data: $realtime["serialize"]() + "&is_ajax=3&data=social_info&type=social_info&form=" + showSliderNum,
            cache: false,
            success: function success(retu_data) {
                if (retu_data["error"] != "") {
                    toastr["error"](retu_data["error"]);
                    $(".icon-spinner3")["hide"]();
                    $(".save")["prop"]("disabled", false);
                } else {
                    toastr["success"](retu_data["result"]);
                    $(".icon-spinner3")["hide"]();
                    $(".save")["prop"]("disabled", false);
                }
            }
        });
    });
    jQuery("#aj_department")["change"](function() {
        jQuery["get"](site_url + "employees/designation/" + jQuery(this)["val"](), function(mmCoreSplitViewBlock, canCreateDiscussions) {
            jQuery("#designation_ajax")["html"](mmCoreSplitViewBlock);
        });
    });
    $(".nav-tabs-link")["click"](function() {
        var conid = $(this)["data"]("profile");
        var nodataid = $(this)["data"]("profile-block");
        $(".nav-item-link")["removeClass"]("active-link");
        $(".current-tab")["hide"]();
        $("#" + nodataid)["show"]();
        $("#user_details_" + conid)["addClass"]("active-link");
    });
    var b = $("#xin_table_contact")["dataTable"]({
        "bDestroy": true,
        "ajax": {
            url: site_url + "employees/contacts/" + $("#user_id")["val"](),
            type: "GET"
        },
        "fnDrawCallback": function fnDrawCallback(oSettings) {
            $('[data-toggle="tooltip"]')["tooltip"]();
        }
    });
    var e = $("#xin_table_imgdocument")["dataTable"]({
        "bDestroy": true,
        "ajax": {
            url: site_url + "employees/immigration/" + $("#user_id")["val"](),
            type: "GET"
        },
        "fnDrawCallback": function fnDrawCallback(oSettings) {
            $('[data-toggle="tooltip"]')["tooltip"]();
        }
    });
    var d = $("#xin_table_document")["dataTable"]({
        "bDestroy": true,
        "ajax": {
            url: site_url + "employees/documents/" + $("#user_id")["val"](),
            type: "GET"
        },
        "fnDrawCallback": function fnDrawCallback(oSettings) {
            $('[data-toggle="tooltip"]')["tooltip"]();
        }
    });
    var h = $("#xin_table_qualification")["dataTable"]({
        "bDestroy": true,
        "ajax": {
            url: site_url + "employees/qualification/" + $("#user_id")["val"](),
            type: "GET"
        },
        "fnDrawCallback": function fnDrawCallback(oSettings) {
            $('[data-toggle="tooltip"]')["tooltip"]();
        }
    });
    var j = $("#xin_table_work_experience")["dataTable"]({
        "bDestroy": true,
        "ajax": {
            url: site_url + "employees/experience/" + $("#user_id")["val"](),
            type: "GET"
        },
        "fnDrawCallback": function fnDrawCallback(oSettings) {
            $('[data-toggle="tooltip"]')["tooltip"]();
        }
    });
    var a = $("#xin_table_bank_account")["dataTable"]({
        "bDestroy": true,
        "ajax": {
            url: site_url + "employees/bank_account/" + $("#user_id")["val"](),
            type: "GET"
        },
        "fnDrawCallback": function fnDrawCallback(oSettings) {
            $('[data-toggle="tooltip"]')["tooltip"]();
        }
    });
    var c = $("#xin_table_contract")["dataTable"]({
        "bDestroy": true,
        "ajax": {
            url: site_url + "employees/contract/" + $("#user_id")["val"](),
            type: "GET"
        },
        "fnDrawCallback": function fnDrawCallback(oSettings) {
            $('[data-toggle="tooltip"]')["tooltip"]();
        }
    });
    var f = $("#xin_table_leave")["dataTable"]({
        "bDestroy": true,
        "ajax": {
            url: site_url + "employees/leave/" + $("#user_id")["val"](),
            type: "GET"
        },
        "fnDrawCallback": function fnDrawCallback(oSettings) {
            $('[data-toggle="tooltip"]')["tooltip"]();
        }
    });
    var i = $("#xin_table_shift")["dataTable"]({
        "bDestroy": true,
        "ajax": {
            url: site_url + "employees/shift/" + $("#user_id")["val"](),
            type: "GET"
        },
        "fnDrawCallback": function fnDrawCallback(oSettings) {
            $('[data-toggle="tooltip"]')["tooltip"]();
        }
    });
    var g = $("#xin_table_location")["dataTable"]({
        "bDestroy": true,
        "ajax": {
            url: site_url + "employees/location/" + $("#user_id")["val"](),
            type: "GET"
        },
        "fnDrawCallback": function fnDrawCallback(oSettings) {
            $('[data-toggle="tooltip"]')["tooltip"]();
        }
    });
    jQuery("#contact_info")["submit"](function(s) {
        s["preventDefault"]();
        var answersContainer = jQuery(this);
        var showSliderNum = answersContainer["attr"]("name");
        jQuery(".save")["prop"]("disabled", true);
        jQuery["ajax"]({
            type: "POST",
            url: s["target"]["action"],
            data: answersContainer["serialize"]() + "&is_ajax=4&data=contact_info&type=contact_info&form=" + showSliderNum,
            cache: false,
            success: function showLargeImage(mode) {
                if (mode["error"] != "") {
                    toastr["error"](mode["error"]);
                    jQuery(".save")["prop"]("disabled", false);
                } else {
                    b["api"]()["ajax"]["reload"](function() {
                        toastr["success"](mode["result"]);
                    }, true);
                    jQuery("#contact_info")[0]["reset"]();
                    jQuery(".save")["prop"]("disabled", false);
                }
            }
        });
    });
    jQuery("#contact_info2")["submit"](function(s) {
        s["preventDefault"]();
        var answersContainer = jQuery(this);
        var showSliderNum = answersContainer["attr"]("name");
        jQuery(".save2")["prop"]("disabled", true);
        $(".icon-spinner33")["show"]();
        jQuery["ajax"]({
            type: "POST",
            url: s["target"]["action"],
            data: answersContainer["serialize"]() + "&is_ajax=4&data=contact_info&type=contact_info&form=" + showSliderNum,
            cache: false,
            success: function preloadImgs(canCreateDiscussions) {
                if (canCreateDiscussions["error"] != "") {
                    toastr["error"](canCreateDiscussions["error"]);
                    $(".icon-spinner33")["hide"]();
                    jQuery(".save2")["prop"]("disabled", false);
                } else {
                    toastr["success"](canCreateDiscussions["result"]);
                    $(".icon-spinner33")["hide"]();
                    jQuery(".save2")["prop"]("disabled", false);
                }
            }
        });
    });
    $("#document_info")["submit"](function(s) {
        var formData = new FormData(this);
        var $realtime = $(this);
        var relationName = $realtime["attr"]("name");
        formData["append"]("is_ajax", 7);
        formData["append"]("type", "document_info");
        formData["append"]("data", "document_info");
        formData["append"]("form", relationName);
        s["preventDefault"]();
        $(".icon-spinner3")["show"]();
        $(".save")["prop"]("disabled", true);
        $["ajax"]({
            url: s["target"]["action"],
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function preloadImgs(canCreateDiscussions) {
                if (canCreateDiscussions["error"] != "") {
                    toastr["error"](canCreateDiscussions["error"]);
                    $(".save")["prop"]("disabled", false);
                    $(".icon-spinner3")["hide"]();
                } else {
                    d["api"]()["ajax"]["reload"](function() {
                        toastr["success"](canCreateDiscussions["result"]);
                    }, true);
                    $(".icon-spinner3")["hide"]();
                    jQuery("#document_info")[0]["reset"]();
                    $(".save")["prop"]("disabled", false);
                }
            },
            error: function validateMandatoryFields() {
                toastr["error"](JSON["error"]);
                $(".save")["prop"]("disabled", false);
            }
        });
    });
    $("#immigration_info")["submit"](function(s) {
        var formData = new FormData(this);
        var $realtime = $(this);
        var relationName = $realtime["attr"]("name");
        formData["append"]("is_ajax", 7);
        formData["append"]("type", "immigration_info");
        formData["append"]("data", "immigration_info");
        formData["append"]("form", relationName);
        s["preventDefault"]();
        $(".icon-spinner3")["show"]();
        $(".save")["prop"]("disabled", true);
        $["ajax"]({
            url: s["target"]["action"],
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function preloadImgs(canCreateDiscussions) {
                if (canCreateDiscussions["error"] != "") {
                    toastr["error"](canCreateDiscussions["error"]);
                    $(".save")["prop"]("disabled", false);
                    $(".icon-spinner3")["hide"]();
                } else {
                    e["api"]()["ajax"]["reload"](function() {
                        toastr["success"](canCreateDiscussions["result"]);
                    }, true);
                    $(".icon-spinner3")["hide"]();
                    jQuery("#document_info")[0]["reset"]();
                    $(".save")["prop"]("disabled", false);
                }
            },
            error: function validateMandatoryFields() {
                toastr["error"](JSON["error"]);
                $(".save")["prop"]("disabled", false);
            }
        });
    });
    jQuery("#qualification_info")["submit"](function(s) {
        s["preventDefault"]();
        var answersContainer = jQuery(this);
        var showSliderNum = answersContainer["attr"]("name");
        jQuery(".save")["prop"]("disabled", true);
        $(".icon-spinner3")["show"]();
        jQuery["ajax"]({
            type: "POST",
            url: s["target"]["action"],
            data: answersContainer["serialize"]() + "&is_ajax=10&data=qualification_info&type=qualification_info&form=" + showSliderNum,
            cache: false,
            success: function preloadImgs(canCreateDiscussions) {
                if (canCreateDiscussions["error"] != "") {
                    toastr["error"](canCreateDiscussions["error"]);
                    jQuery(".save")["prop"]("disabled", false);
                    $(".icon-spinner3")["hide"]();
                } else {
                    h["api"]()["ajax"]["reload"](function() {
                        toastr["success"](canCreateDiscussions["result"]);
                    }, true);
                    jQuery("#qualification_info")[0]["reset"]();
                    $(".icon-spinner3")["hide"]();
                    jQuery(".save")["prop"]("disabled", false);
                }
            }
        });
    });
    jQuery("#work_experience_info")["submit"](function(s) {
        s["preventDefault"]();
        var answersContainer = jQuery(this);
        var showSliderNum = answersContainer["attr"]("name");
        jQuery(".save")["prop"]("disabled", true);
        $(".icon-spinner3")["show"]();
        jQuery["ajax"]({
            type: "POST",
            url: s["target"]["action"],
            data: answersContainer["serialize"]() + "&is_ajax=13&data=work_experience_info&type=work_experience_info&form=" + showSliderNum,
            cache: false,
            success: function preloadImgs(canCreateDiscussions) {
                if (canCreateDiscussions["error"] != "") {
                    toastr["error"](canCreateDiscussions["error"]);
                    jQuery(".save")["prop"]("disabled", false);
                    $(".icon-spinner3")["hide"]();
                } else {
                    j["api"]()["ajax"]["reload"](function() {
                        toastr["success"](canCreateDiscussions["result"]);
                    }, true);
                    $(".icon-spinner3")["hide"]();
                    jQuery("#work_experience_info")[0]["reset"]();
                    jQuery(".save")["prop"]("disabled", false);
                }
            }
        });
    });
    jQuery("#bank_account_info")["submit"](function(s) {
        s["preventDefault"]();
        var answersContainer = jQuery(this);
        var showSliderNum = answersContainer["attr"]("name");
        jQuery(".save")["prop"]("disabled", true);
        $(".icon-spinner3")["show"]();
        jQuery["ajax"]({
            type: "POST",
            url: s["target"]["action"],
            data: answersContainer["serialize"]() + "&is_ajax=16&data=bank_account_info&type=bank_account_info&form=" + showSliderNum,
            cache: false,
            success: function preloadImgs(canCreateDiscussions) {
                if (canCreateDiscussions["error"] != "") {
                    toastr["error"](canCreateDiscussions["error"]);
                    $(".icon-spinner3")["hide"]();
                    jQuery(".save")["prop"]("disabled", false);
                } else {
                    a["api"]()["ajax"]["reload"](function() {
                        toastr["success"](canCreateDiscussions["result"]);
                    }, true);
                    $(".icon-spinner3")["hide"]();
                    jQuery("#bank_account_info")[0]["reset"]();
                    jQuery(".save")["prop"]("disabled", false);
                }
            }
        });
    });
    jQuery("#contract_info")["submit"](function(s) {
        s["preventDefault"]();
        var answersContainer = jQuery(this);
        var showSliderNum = answersContainer["attr"]("name");
        jQuery(".save")["prop"]("disabled", true);
        jQuery["ajax"]({
            type: "POST",
            url: s["target"]["action"],
            data: answersContainer["serialize"]() + "&is_ajax=19&data=contract_info&type=contract_info&form=" + showSliderNum,
            cache: false,
            success: function showLargeImage(mode) {
                if (mode["error"] != "") {
                    toastr["error"](mode["error"]);
                    jQuery(".save")["prop"]("disabled", false);
                } else {
                    c["api"]()["ajax"]["reload"](function() {
                        toastr["success"](mode["result"]);
                    }, true);
                    jQuery("#contract_info")[0]["reset"]();
                    jQuery(".save")["prop"]("disabled", false);
                }
            }
        });
    });
    jQuery("#leave_info")["submit"](function(s) {
        s["preventDefault"]();
        var answersContainer = jQuery(this);
        var showSliderNum = answersContainer["attr"]("name");
        jQuery(".save")["prop"]("disabled", true);
        jQuery["ajax"]({
            type: "POST",
            url: s["target"]["action"],
            data: answersContainer["serialize"]() + "&is_ajax=22&data=leave_info&type=leave_info&form=" + showSliderNum,
            cache: false,
            success: function showLargeImage(mode) {
                if (mode["error"] != "") {
                    toastr["error"](mode["error"]);
                    jQuery(".save")["prop"]("disabled", false);
                } else {
                    f["api"]()["ajax"]["reload"](function() {
                        toastr["success"](mode["result"]);
                    }, true);
                    jQuery("#leave_info")[0]["reset"]();
                    jQuery(".save")["prop"]("disabled", false);
                }
            }
        });
    });
    jQuery("#shift_info")["submit"](function(s) {
        s["preventDefault"]();
        var answersContainer = jQuery(this);
        var showSliderNum = answersContainer["attr"]("name");
        jQuery(".save")["prop"]("disabled", true);
        jQuery["ajax"]({
            type: "POST",
            url: s["target"]["action"],
            data: answersContainer["serialize"]() + "&is_ajax=25&data=shift_info&type=shift_info&form=" + showSliderNum,
            cache: false,
            success: function showLargeImage(mode) {
                if (mode["error"] != "") {
                    toastr["error"](mode["error"]);
                    jQuery(".save")["prop"]("disabled", false);
                } else {
                    i["api"]()["ajax"]["reload"](function() {
                        toastr["success"](mode["result"]);
                    }, true);
                    jQuery("#shift_info")[0]["reset"]();
                    jQuery(".save")["prop"]("disabled", false);
                }
            }
        });
    });
    jQuery("#location_info")["submit"](function(s) {
        s["preventDefault"]();
        var answersContainer = jQuery(this);
        var showSliderNum = answersContainer["attr"]("name");
        jQuery(".save")["prop"]("disabled", true);
        jQuery["ajax"]({
            type: "POST",
            url: s["target"]["action"],
            data: answersContainer["serialize"]() + "&is_ajax=28&data=location_info&type=location_info&form=" + showSliderNum,
            cache: false,
            success: function showLargeImage(mode) {
                if (mode["error"] != "") {
                    toastr["error"](mode["error"]);
                    jQuery(".save")["prop"]("disabled", false);
                } else {
                    g["api"]()["ajax"]["reload"](function() {
                        toastr["success"](mode["result"]);
                    }, true);
                    jQuery("#location_info")[0]["reset"]();
                    jQuery(".save")["prop"]("disabled", false);
                }
            }
        });
    });
    jQuery("#e_change_password")["submit"](function(s) {
        s["preventDefault"]();
        var answersContainer = jQuery(this);
        var showSliderNum = answersContainer["attr"]("name");
        jQuery(".save")["prop"]("disabled", true);
        $(".icon-spinner3")["show"]();
        jQuery["ajax"]({
            type: "POST",
            url: s["target"]["action"],
            data: answersContainer["serialize"]() + "&is_ajax=31&data=e_change_password&type=change_password&form=" + showSliderNum,
            cache: false,
            success: function preloadImgs(canCreateDiscussions) {
                if (canCreateDiscussions["error"] != "") {
                    toastr["error"](canCreateDiscussions["error"]);
                    jQuery(".save")["prop"]("disabled", false);
                    $(".icon-spinner3")["hide"]();
                } else {
                    toastr["success"](canCreateDiscussions["result"]);
                    $(".icon-spinner3")["hide"]();
                    jQuery("#e_change_password")[0]["reset"]();
                    jQuery(".save")["prop"]("disabled", false);
                }
            }
        });
    });
    $("#delete_record")["submit"](function(s) {
        var mh = $("#token_type")["val"]();
        if (mh == "contact") {
            var m = "&is_ajax=6&data=delete_record&type=delete_contact&";
            var h = "xin_table_" + mh;
        } else {
            if (mh == "document") {
                m = "&is_ajax=8&data=delete_record&type=delete_document&";
                h = "xin_table_" + mh;
            } else {
                if (mh == "qualification") {
                    m = "&is_ajax=12&data=delete_record&type=delete_qualification&";
                    h = "xin_table_" + mh;
                } else {
                    if (mh == "work_experience") {
                        m = "&is_ajax=15&data=delete_record&type=delete_work_experience&";
                        h = "xin_table_" + mh;
                    } else {
                        if (mh == "bank_account") {
                            m = "&is_ajax=18&data=delete_record&type=delete_bank_account&";
                            h = "xin_table_" + mh;
                        } else {
                            if (mh == "contract") {
                                m = "&is_ajax=21&data=delete_record&type=delete_contract&";
                                h = "xin_table_" + mh;
                            } else {
                                if (mh == "leave") {
                                    m = "&is_ajax=24&data=delete_record&type=delete_leave&";
                                    h = "xin_table_" + mh;
                                } else {
                                    if (mh == "shift") {
                                        m = "&is_ajax=27&data=delete_record&type=delete_shift&";
                                        h = "xin_table_" + mh;
                                    } else {
                                        if (mh == "location") {
                                            m = "&is_ajax=30&data=delete_record&type=delete_location&";
                                            h = "xin_table_" + mh;
                                        } else {
                                            if (mh == "imgdocument") {
                                                m = "&is_ajax=30&data=delete_record&type=delete_imgdocument&";
                                                h = "xin_table_" + mh;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        s["preventDefault"]();
        var $realtime = $(this);
        var showSliderNum = $realtime["attr"]("name");
        $["ajax"]({
            url: s["target"]["action"],
            type: "post",
            data: "?" + $realtime["serialize"]() + m + "form=" + showSliderNum,
            success: function wrap_list_input(list_input) {
                if (list_input["error"] != "") {
                    toastr["error"](list_input["error"]);
                } else {
                    $(".delete-modal")["modal"]("toggle");
                    $("#" + h)["dataTable"]()["api"]()["ajax"]["reload"](function() {
                        toastr["success"](list_input["result"]);
                    }, true);
                }
            }
        });
    });
    $(document)["on"]("click", ".delete", function() {
        $("input[name=_token]")["val"]($(this)["data"]("record-id"));
        $("input[name=token_type]")["val"]($(this)["data"]("token_type"));
        $("#delete_record")["attr"]("action", site_url + "employees/delete_" + $(this)["data"]("token_type") + "/" + $(this)["data"]("record-id"));
    });
});
$(document)["ready"](function() {
    $('[data-plugin="select_hrm"]')["select2"]($(this)["attr"]("data-options"));
    $('[data-plugin="select_hrm"]')["select2"]({
        width: "100%"
    });
    $(".cont_date")["datepicker"]({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        yearRange: "1990:" + ((new Date)["getFullYear"]() + 10)
    });
});