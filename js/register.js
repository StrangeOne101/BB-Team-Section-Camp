$(document).ready(function() {	
	$(".invalid").change(function() {
		$(this).removeClass("invalid");
	});
	
	$(".invalid-name").change(function() {
		$(this).removeClass("invalid-name");
	});
	
	$(".invalid-email").change(function() {
		$(this).removeClass("invalid-email");
	});
	
	$(".invalid-company").change(function() {
		$(this).removeClass("invalid-company");
	});
	
	$(".invalid-phone").change(function() {
		(".invalid-phone").removeClass("invalid-company");
	});
});

function submitForm() {
	removeHardenedState();

	setTimeout(function() {
		document.getElementById("register_form_form").submit();
	}, 50);	
	
	
}

function removeHardenedState() {
	$("#form-agentID").removeAttr("disabled");
	$("#form-agentID-button").attr("disabled", "disabled");
	
	console.log("Removed disabled agentID attribute!");
}

console.log("Made it here!")