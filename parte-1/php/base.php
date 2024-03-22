<?php
    include("session_start.php");
    include("conexao.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<link rel="stylesheet" href="../css/base.css">
<style>
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;}
.w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
.w3-half img:hover{opacity:1}
</style>
</head>

<body>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-blue w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Fechar Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Clinical<br>Here</b></h3>
  </div>
  <div class="w3-bar-block">
    <a href="../php/agenda_recepcionista.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Agenda</a> 
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Lista de Médicos</a> 
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Lista de Pacientes</a> 
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Cadastro de Médico</a> 
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Cadastro de Paciente</a> 
    <a href="../php/deslogar-se.php" class="w3-bar-item w3-button w3-hover-white">Sair</a>
  </div>
</nav>

<!-- Top menu on small screens -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
  <header class="w3-container w3-top w3-hide-large w3-blue w3-xlarge w3-padding">
    <a href="javascript:void(0)" class="w3-button w3-blue w3-margin-right" onclick="w3_open()">☰</a>
    <span>Clinical Here</span>
  </header>
</div>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

<script>
// Script to open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}
</script>

</body>
</html>
