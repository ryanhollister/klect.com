function run_tests_call(data)
{
	$.post(getBaseURL()+"admin_area/run_tests", {} , function(data){
		$("#results").html(data);
		});
	return false;
}
$(document).ready(function (){
$("#run_test").click(run_tests_call);
});