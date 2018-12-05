if(window.location.href.indexOf('?') != -1 && window.location.href.indexOf("?page") === -1){
	$("#filtro_avancado").removeClass("collapse");
	$("#filtro_avancado").attr("aria-expanded", true);
	$('#collapseTwo').removeClass('collapse');
	$('#collapseTwo').addClass('collapse show in');
    $("#collapseTwo").attr("aria-expanded", true);
	$('#collapseTwo').trigger('click');
}