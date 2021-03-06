<?php
	
	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 
	include_once "libs/maLibForms.php";

	// on sélectionne une rubrique différente du site dans le menu
	//$(".sr-only").html("(current)");


	if(valider("connecte","SESSION"))
		if(valider("isAdmin","SESSION"))
			$admin=1;
		else $admin=0;
	else {
		header("Location:index.php?view=connexion");
  		die("");
	}

?>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">

var admin=<?php echo $admin; ?>;
var jCompte = $('<div class="attente"></div>');
var jButtonOK = $('<input type="button" value="Accepter"/>').click(function() {
									var id=$(this).prop("id");
									if($("#admin").is(":checked"))
										var promouvoir="1";
									else var promouvoir="0";
									console.log(promouvoir);
				 					$.ajax({
                    					url: "libs/dataBdd.php?action=Accepter&idUser="+$(this).prop("id")+"&admin="+admin+"&promouvoir="+promouvoir,
                    					type : "PUT",
                    					success:function (oRep){
											console.log("Inscrit");
											console.log(oRep);
											$.ajax({
												url: "libs/dataBdd.php",
												data:{"action":"CompteAttente","admin":admin,"idUser":id},
												type : "GET",
												success:function (oRep){
											 		console.log(oRep);
											 		for (var i = 0; i <oRep.length; i++) {
											 			sendMail(oRep[i].mdp,oRep[i].mail);
											 		}

											 		$("#"+id).hide('slow', function() { 
															$(this).remove();
															$("#btn").remove();
														});

												},
												error : function(jqXHR, textStatus)
												{
													console.log("erreur");

												},
												dataType: "json"
											});//fin 2e requete
                						}//fin succes
                					});//fin 1er requete
                					$(this).parent().hide('slow', function() { 
                						$(this).remove();
                					});
				 				});

var jBox=$('<label for="admin ">admin </label><input type="checkbox" name="admin" id="admin"/>');

var jButtonNO = $('<input type="button" value="Refuser"/>').click(function() {
				 					$.ajax({
                    					url: "libs/dataBdd.php?action=Refuser&idUser="+$(this).prop("id")+"&admin="+admin,
                    					type : "DELETE",
                    					success:function (){
											console.log("refuser");
                						}//fin succes
                					});//fin 1er requete
                					$(this).parent().hide('slow', function() { 
                						$(this).remove();
                					});
				 				});

var jBtnAccepter=$('<input type="button" id="btn" value="Tout accepter"/>').click(function(){
	$(".attente").each(function () {
		var id=$(this).prop("id");
		$.ajax({
	                url: "libs/dataBdd.php?action=Accepter&idUser="+id+"&admin="+admin,
	                type : "PUT",
	                success:function (oRep){
	                	console.log(oRep);
	                	$.ajax({
			                url: "libs/dataBdd.php",
			                data:{"action":"CompteAttente","admin":admin,"idUser":id},
			                type : "GET",
			                success:function (oRep){
						 		console.log(oRep);
						 		for (var i = 0; i <oRep.length; i++) {
						 			sendMail(oRep[i].mdp,oRep[i].mail);
						 		}

						 		$("#"+id).hide('slow', function() { 
                						$(this).remove();
										$("#btn").remove();
                					});

							},
							error : function(jqXHR, textStatus)
							{
								console.log("erreur");

							},
							dataType: "json"
						});//fin 2e requete

				}//fin succes
				});//fin 1er requete 

	})//fin each
});//fin click

$.ajax({
                url: "libs/dataBdd.php",
                data:{"action":"CompteAttente","admin":admin,},
                type : "GET",
                success:function (oRep){
			 	console.log(oRep);
					$("#listeCompte").append($("<h4><b>Demandes de création de compte</b></h4></br>"));
				 	if(oRep.length != 0){
				 		for (var i = 0; i < oRep.length; i++) {
				 			$("#listeCompte").append(jCompte.clone(true).attr("id",oRep[i].id)
				 				.append($('<div class="demande">Demande de <b>'+oRep[i].prenom+' '+oRep[i].nom+'</b></div>'))
				 				.append(jButtonOK.clone(true).attr("id",oRep[i].id))
				 				.append(jButtonNO.clone(true).attr("id",oRep[i].id))
				 				.append(jBox.clone(true))
				 			);//fin append
							if ($("#btn").length == 0)
								$("h4").after(jBtnAccepter.clone(true));
				 		}
				 	}
					else
			 			$("#listeCompte").append($("<div>Aucune demande de création de compte n'a été envoyée</div></br>"));
			
			 },
			error : function(jqXHR, textStatus)
			{
				console.log("erreur");
				 
			},
			dataType: "json"
			});

function sendMail(mdp,mailD) {

	var email = "no-reply@decima.fr";
	var subject = "Mot de passe du compte ";

	var body = "Votre compte à été validé, votre mot de passe est : "+mdp+"\n votre login est : "+mailD +"\n pour vous connecter rendez-vous sur http://185.30.209.4/PINF/ pour vous connecter";

	$.ajax({
		url: 'PHPMailer/mail.php',
		method: 'POST',
		dataType: 'json',

		data: {
			name: "decima-ne-pas-repondre",
			email: email,
			subject: subject,
			body: body,
			mailD: mailD
		},

		success: function(response) {
			console.log(response);
		},

		error: function(response) {	
			console.log(response);
		}
	});

}

</script>

<body>
<div id="listeCompte"></div>
</br></br></br></br></br>
</body>

</html>
