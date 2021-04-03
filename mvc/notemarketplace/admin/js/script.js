/* show/hide password*/
function Toggle() {
	var temp = document.getElementById("exampleInputPassword1");
	if (temp.type === "password") {
		temp.type = "text";
	} else {
		temp.type = "password";
	}
}

function Toggle1() {
	var temp = document.getElementById("oldpassword");
	if (temp.type === "password") {
		temp.type = "text";
	} else {
		temp.type = "password";
	}
}

function Toggle2() {
	var temp = document.getElementById("newpassword");
	if (temp.type === "password") {
		temp.type = "text";
	} else {
		temp.type = "password";
	}
}

function Toggle3() {
	var temp = document.getElementById("confirmpassword");
	if (temp.type === "password") {
		temp.type = "text";
	} else {
		temp.type = "password";
	}
}

function Toggle4() {
	var temp = document.getElementById("spassword");
	if (temp.type === "password") {
		temp.type = "text";
	} else {
		temp.type = "password";
	}
}

function Toggle5() {
	var temp = document.getElementById("scpassword");
	if (temp.type === "password") {
		temp.type = "text";
	} else {
		temp.type = "password";
	}
}

function validatePassword() {
	var validator = $("#signup-form").validate({
		rules: {
			spassword: "required",
			scpassword: {
				equalTo: "#spassword"
			}
		},
		messages: {
			spassword: " Enter Password",
			scpassword: " Enter Confirm Password Same as Password"
		}
	});
	if (validator.form()) {
		alert('Sucess');
	}
}

function Delete() {
	if (confirm("are you sure, you want to delete this notes")) {
		txt = "You pressed OK!";
	} else {
		txt = "You pressed Cancel!";
	}
}

function Report() {
	if (confirm("Are you sure you want to mark this report as spam, you cannot update it later?")) {
		txt = "You pressed OK!";
	} else {
		txt = "You pressed Cancel!";
	}
}

function reject() {
	if (confirm("for reject popup")) {
		txt = "You pressed OK!";
	} else {
		txt = "You pressed Cancel!";
	}
}

function deactivate() {
	if (confirm("Are you sure you want to make this member inactive?")) {
		txt = "You pressed OK!";
	} else {
		txt = "You pressed Cancel!";
	}
}

function inreview() {
	if (confirm("Via marking the note In Review – System will let user know that review process has been initiated. Please press yes to continue.")) {
		txt = "You pressed OK!";
	} else {
		txt = "You pressed Cancel!";
	}
}

function approve() {
	if (confirm("If you approve the notes – System will publish the notes over portal. Please press yes to continue.")) {
		txt = "You pressed OK!";
	} else {
		txt = "You pressed Cancel!";
	}
}

var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
	coll[i].addEventListener("click", function () {
		this.classList.toggle("active");
		var content = this.nextElementSibling;

		if (content.style.maxHeight) {
			content.style.maxHeight = content.scrollHeight + "px";


		} else {
			content.style.maxHeight = null;
			if (content.style.display === "block") {
				content.style.display = "none";
				$(".faq").css("border-color", "#d1d1d1");


			} else {
				content.style.display = "block";
				$(".faq").css("border-color", "#d1d1d1");
				$(".collapsible").css("border-color", "none");
			}
		}
	});
}

/*========================================
        mobile menu
        =================================*/
$(function () {

	//show mobile nav
	$("#mobile-nav-open-btn").click(function () {
		$("#mobile-nav").css("height", "100%");
	});
	//hide mobile nav
	$("#mobile-nav-close-btn, #mobile-nav .nav-item").click(function () {
		$("#mobile-nav").css("height", "0%");
	});
});


$(function () {

	showHideNav();
	$(window).scroll(function () {
		showHideNav();
	});

	function showHideNav() {
		if ($(window).scrollTop() > 50) {
			//show white
			$("#home-nav").addClass("white-nav-top");
			//dark logo
			$(".navbar-home img").attr("src", "images/images/logo.png");
			$('.navbar-home-li li a').css("color", "#000");
			$('.button-nav-home p').css("color", "#fff").css("background-color", "#6255a5");
		} else {
			$("#home-nav").removeClass("white-nav-top").addClass("navbar");
                 
			$(".navbar-home img").attr("src", "images/images/top-logo.png");
			$('.navbar-home-li li a').css("color", "#fff");
			$('.button-nav-home p').css("color", "#6255a5").css("background-color", "#fff");


		}
	}
});

function faqcollpase(){

}


/*function MyFunction(){
	var r = confirm("You have to login/sign in first!");
    if (r == true) {
        location.href='login.html';
    }
	}
*/