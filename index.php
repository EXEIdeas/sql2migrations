<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>SQL 2 Migration</title>
		<meta name="keyword" content="sql, migration, laravel, mysql, sql2migration, laravel migration" />
		<meta name="description" content="Convert your .sql dump database file (only structure) into Laravel Migration files seprate for each table with roolback options." />
		<meta name="author" content="Muhammad Hassan">
		<link rel='icon' href='logo.png' type='image/x-icon' sizes="16x16" />
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<style type="text/css">
		.output_div {height:300px;display:block;overflow-y:scroll;}
		</style>
	</head>
	<body class="bg-light">
		<div class="container">		
			<div class="my-5 text-center">
				<img class="d-block mx-auto mb-4" src="logo.png" alt="" width="100" height="100">
				<h2  class="display-4">SQL 2 Migration</h2>
				<p class="lead mt-5">When generating laravel migrations, it can sometimes be a bit confusing as to the correct way to add columns or fields to your tables. There are a large amount of methods to use within the Schema and Blueprint classes to wrap your heads around. Many times, you might even have a database in place, but you would like to move this instance to another host, or simply have a blueprint of the database in a set of laravel migration files. Wouldn’t it be great if we had a way to handle doing this for us automatically? In fact we do it now for you. Let’s see how to put this in action.😘</p>
			</div>			
			<div class="mb-3">
				<div class="row">
					<div class="col">
						<h4 class="mb-3">Step # 01</h4>
						<ul class="list-styled">
							<li>
								Choose your .SQL file.
								<ul>
									<li>.sql dump database file (only structure)</li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="col">
						<h4 class="mb-3">Step # 02</h4>
						<ul class="list-styled">
							<li>Click on "Generate Migrations".
								<ul>
									<li>Wait few sec...</li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="col">
						<h4 class="mb-3">Step # 03</h4>						
						<ul class="list-styled">
							<li>Download your Migration Files".
								<ul>
									<li>Download one by one or .zip at once</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<hr class="my-4">
			<div class="mb-5" style="margin-bottom:5rem!important;">
				<form class="login_member_form" onsubmit="return GenerateMigration(this)"  method="post" enctype="multipart/form-data">
					<label for="formFileLg" class="form-label"><b>Select your (.sql) File:</b></label>
					<input class="form-control form-control-lg" id="formFileLg" type="file" name="sqlFile">
					<br>
					<button class="w-100 btn btn-lg btn-primary" type="submit">Generate Migrations</button>
					<div class="d-flex justify-content-center my-3" id="loading" style="display:none!important;">
						<div class="spinner-grow text-primary" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
						<div class="spinner-grow mx-1 text-secondary" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
						<div class="spinner-grow mx-1 text-success" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
						<div class="spinner-grow mx-1 text-danger" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
						<div class="spinner-grow mx-1 text-warning" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
						<div class="spinner-grow mx-1 text-info" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
						<div class="spinner-grow mx-1 text-dark" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
					</div>
					<div id="showGeneralAjaxMsg"></div>
				</form>
			</div>
			<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-5 border-top">
				<div class="col-md-6 d-flex align-items-center">
					<a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
						<img class="bi" src="logo.png" width="30" height="24">
					</a>
					<span class="text-muted">© 2022, SQL 2 Migration | Developed with ❤️ by <a href="https://www.exeideas.net" title="Official Website" class="link-danger">EXEIdeas International</a></span>
				</div>
				<ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
					<li class="ms-3">
						Follow Us On
					</li>
					<li class="ms-3">
						<a class="text-muted" href="https://github.com/EXEIdeas" title="View us on GitHub">
							<svg class="bi" width="24" height="24">
								<use xlink:href="#github"></use>
							</svg>
						</a>
					</li>
					<li class="ms-3">
						<a class="text-muted" href="https://twitter.com/EXEIdeas/" title="Follow me on Twitter">
							<svg class="bi" width="24" height="24">
								<use xlink:href="#twitter"></use>
							</svg>
						</a>
					</li>
					<li class="ms-3">
						<a class="text-muted" href="https://www.facebook.com/EXEIdeas/" title="Follow me on Facebook">
							<svg class="bi" width="24" height="24">
								<use xlink:href="#facebook"></use>
							</svg>
						</a>
					</li>
					<li class="ms-3">
						<a class="text-muted" href="https://pk.linkedin.com/in/exeideas" title="Connect me on LinkedIn">
							<svg class="bi" width="24" height="24">
								<use xlink:href="#linkedin"></use>
							</svg>
						</a>
					</li>
				</ul>
			</footer>
		</div>
	</body>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
	<symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
		<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
	</symbol>
	<symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
		<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
	</symbol>
	<symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
		<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
	</symbol>
	<symbol  id="x-circle-fill" fill="currentColor" viewBox="0 0 16 16">
		<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
	</symbol>
</svg>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
	<symbol id="github" viewBox="0 0 16 16">
		<path fill="#464646" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path>
	</symbol>
	<symbol id="facebook" viewBox="0 0 16 16">
		<path fill="#464646" d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"></path>
	</symbol>
	<symbol id="twitter" viewBox="0 0 16 16">
		<path fill="#464646" d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"></path>
	</symbol>
	<symbol id="linkedin" viewBox="0 0 16 16">
		<path fill="#464646" d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
	</symbol>
</svg>
<script type="text/javascript">
/* --------------------------------------------------------------- */
/* Authorize The Session 
/* --------------------------------------------------------------- */
function GenerateMigration(incomingForm) {
	document.getElementById("loading").style.cssText = "display:flex!important;";	// Start The Loading Icons
	// Confirmation To Generate The Migrations
    var answer = confirm('Are You Sure Want To Generate The Migrations?');
    if (answer){
		var FD = new FormData(incomingForm); // Get FORM Element Object
		FD.append("Function", "GenerateMigration"); // Adding Extra Data In FORM Element Object
		var ajx = new XMLHttpRequest();
		ajx.onreadystatechange = function () {
			if (ajx.readyState == 4 && ajx.status == 200) {	
				//If Returning Value Is JSON
				/*if(IsJsonString(ajx.responseText)){
					var response = JSON.parse(ajx.responseText);
					if(response.message) {
						document.querySelector("#showGeneralAjaxMsg").insertAdjacentHTML('afterend', response.message); 
					}
				} else {
					
				}*/
				document.getElementById("showGeneralAjaxMsg").innerHTML = ajx.responseText;	// Return The Data
				document.getElementById("loading").style.cssText = "display:none!important;";	// Stop The Loading Icons
			}
		};
		ajx.open("POST", "function.php", true);
		ajx.send(FD);
		document.getElementById("showGeneralAjaxMsg").innerHTML = '<div class="alert alert-warning d-flex align-items-center" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg><div>Connecting to Server... <b>Please Wait...</b></div></div>';
	} else {
		document.getElementById("loading").style.cssText = "display:none!important;";	// Stop The Loading Icons
		document.getElementById("showGeneralAjaxMsg").innerHTML = "";	// Clear THe AJAX Messages
	}
	return false; // For Not To Reload Page
}
</script>
</html>