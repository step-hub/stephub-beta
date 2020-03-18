<!doctype html>
<html lang="ua">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="style.css">
    <title>StepHUB</title>
  </head>
 <body>
		<nav class="navbar navbar-expand navbar-dark bg-dark">
  		<a class="navbar-brand" href="#">StepHUB</a>
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  		</button>

  		<div class="collapse navbar-collapse" id="navbarsExample02">
    		<ul class="navbar-nav mr-auto">
      		<li class="nav-item">
        		<a class="nav-link" href="#">Мій кабінет</a>
      		</li>
    		</ul>
    		<a class="btn btn-outline-primary" href="#">Вхід</a>
  		</div>
		</nav>
	<main role ="main" class="content">
			<?php
			for($i = 0; $i < 5; $i++):
			?>
 				<div class="card">
   				<div class="card-body">
     				<h5 class="card-title">Тема</h5>
     				<p class="card-text">Короткий опис що потрібно зробити.</p>
		 				<p class="card-text text-right text-muted">Виконати до: 20.04.2020</p>
   				</div>
	 					<div class="card-footer">
		 					<a href="#" class="btn btn-success">Відповісти</a>
   					</div>
 				</div>
			<?php endfor; ?>
		</main>
		<footer class="footer mt-auto py-5 bg-light">
   		<div class="container-fluid">
     		<p class="text-center">Про нас</p>
   		</div>
 		</footer>
 </body>
</html>
