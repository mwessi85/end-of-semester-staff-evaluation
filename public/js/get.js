$().ready(function() {
	$("#department_search").autocomplete("get/department.php", {
		width: '50%',
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#department_search").result(function(event, data, formatted) {
		$("#department").val(data[1]);
	});
});

$().ready(function() {
	$("#user_search").autocomplete("get/user.php", {
		width: '50%',
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#user_search").result(function(event, data, formatted) {
		$("#user").val(data[1]);
	});
});

$().ready(function() {
	$("#staff_search").autocomplete("get/staff.php", {
		width: '50%',
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#staff_search").result(function(event, data, formatted) {
		$("#staff").val(data[1]);
	});
});

$().ready(function() {
	$("#student_search").autocomplete("get/student.php", {
		width: '50%',
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#student_search").result(function(event, data, formatted) {
		$("#student").val(data[1]);
	});
});

$().ready(function() {
	$("#position_search").autocomplete("get/position.php", {
		width: '50%',
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#position_search").result(function(event, data, formatted) {
		$("#position").val(data[1]);
	});
});

$().ready(function() {
	$("#title_search").autocomplete("get/title.php", {
		width: '50%',
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#title_search").result(function(event, data, formatted) {
		$("#title_").val(data[1]);
	});
});

$().ready(function() {
	$("#publication_type_search").autocomplete("get/publication_type.php", {
		width: '50%',
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#publication_type_search").result(function(event, data, formatted) {
		$("#type").val(data[1]);
	});
});

$().ready(function() {
	$("#research_group_search").autocomplete("get/research_group.php", {
		width: '50%',
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#research_group_search").result(function(event, data, formatted) {
		$("#research_group").val(data[1]);
	});
});

$().ready(function() {
	$("#sub_department_search").autocomplete("get/sub_department.php", {
		width: '50%',
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#sub_department_search").result(function(event, data, formatted) {
		$("#sub_department").val(data[1]);
	});
});

$().ready(function() {
	$("#course_search").autocomplete("get/course.php", {
		width: '50%',
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#course_search").result(function(event, data, formatted) {
		$("#course").val(data[1]);
	});
});

$().ready(function() {
	$("#course_unit_search").autocomplete("get/course_unit.php", {
		width: '50%',
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#course_unit_search").result(function(event, data, formatted) {
		$("#course_unit").val(data[1]);
	});
});

/*$().ready(function() {
	$("#student_course_course_unit_search").autocomplete("get/student_course_unit.php", {
		width: '50%',
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#student_course_course_unit_search").result(function(event, data, formatted) {
		$("#student_course_course_unit").val(data[1]);
	});
});*/

$().ready(function() {
	$("#program_search").autocomplete("get/program.php", {
		width: '50%',
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#program_search").result(function(event, data, formatted) {
		$("#program").val(data[1]);
	});
});

$().ready(function() {
	$("#question_category_search").autocomplete("get/question_category.php", {
		width: '50%',
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#question_category_search").result(function(event, data, formatted) {
		$("#question_category").val(data[1]);
	});
});

var input = document.getElementById('first_name');
input.oninvalid = function(event) {
    event.target.setCustomValidity('First name should be your christian or Islam name and should not exceed 20 characters. e.g. john');
}

/*function areYouSure (msg) {
	var bool = window.confirm(msg);
	return bool;
}*/




function toggleMenu(currMenu)
{
	if(document.getElementById)
		{
			thisMenu = document.getElementById(currMenu).style;
			if(thisMenu.display == "block")
			{
				thisMenu.display = "none";
			}
			else
			{
				thisMenu.display = "block";
			}
			return false;
		}
	else
		{
			return true;
		}
}
