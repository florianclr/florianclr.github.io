<?php
	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 
	include_once "libs/maLibForms.php";
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- **** H E A D **** -->
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Decima</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">
   <script src="vendor/jquery/jquery.min.js"></script>

  <script type="text/javascript">
    
    var jMenu=$('<a class="list-group-item"></a>');
    $.ajax({
    url: "libs/dataBdd.php",
    data:{"action":"Categories"},
    type : "GET",
    success:function (oRep){
      console.log(oRep);
      for (var i=0 ;i<oRep.length;i++) {
        $(".list-group").append(jMenu.clone(true)
          .html(oRep[i].nomCategorie)
          .attr("href","index.php?view=articles&categorie="+oRep[i].nomCategorie)); 
      }
        
    },
    error : function(jqXHR, textStatus) {
      console.log("erreur");  
    },
    dataType: "json"
  });

  </script>

</head>
<!-- **** F I N **** H E A D **** -->

<!-- **** B O D Y **** -->
<body>

<!-- style inspiré de http://www.bootstrapzero.com/bootstrap-template/sticky-footer --> 

<!-- Wrap all page content here -->
<!-- Navigation -->
<div class="container">
  <div class="row">

        <div class="col-lg-3">

          <div class="list-group">
          </div>

        </div>
      </div>
</div>

</body>







