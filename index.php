<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Algoritmo de Escalonamento</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="padding-top: 10px; font-family:verdana,arial">
	<header>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="jumbotron">
						<h2 style="text-align: center;">Escalonador de Processos</h2>
					</div>
				</div>
			</div>
		</div>
	</header>
	<section>
		<div class="container-fluid">
			<form action="processar.php" method="post">
				<div class="row">
					<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
						<div class="form-group">
							<label for="cpu1">Algoritmo</label> <select class="form-control"
								id="algoritmo" name="algoritmo">
								<option value="fcfs">FCFS</option>
								<option value="sjf">SJF</option>
								<option value="rr">Round Robin</option>
								<option value="p">Prioridade</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<label for="">&nbsp;</label>
						<button type="button" class="btn btn-block btn-danger"
							onclick="apagarTodosProcessos()">
							<i class="glyphicon glyphicon glyphicon-remove-sign"></i>
							&nbsp;Apagar Todos os Processos
						</button>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<label for="">&nbsp;</label>
						<button type="button" class="btn btn-block btn-primary"
							onclick="addProcesso()">
							<i class="glyphicon glyphicon glyphicon-plus-sign"></i>
							&nbsp;Adicionar Processo
						</button>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<label for="">&nbsp;</label>
						<button type="button" class="btn btn-block btn-success">
							<i class="glyphicon glyphicon glyphicon-ok-sign"></i>
							&nbsp;Processar
						</button>
					</div>
				</div>
				<div class="row row-before-processo">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<hr />
					</div>
				</div>
				<div id="container_processos">
					<div class="row row-processo" id="divProcesso1">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title-div">
							<hr
								style="height: 5px; margin-left: 1px; margin-bottom: 8px; background-image: -webkit-linear-gradient(top, rgba(189, 204, 189, .8), rgba(0, 0, 0, 0));" />
							<p class="lead">Processo 1</p>
							<hr />
						</div>
						<div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 col-inputs">
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="form-group">
										<label for="cpu1">CPU 1</label> <input type="number" min="0"
											class="form-control input-value" name="cpu1[]"
											placeholder="Tempo da CPU 1" />
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="form-group">
										<label for="es1">E/S 1</label> <input type="number" min="0"
											class="form-control input-value" name="es1[]"
											placeholder="Tempo de E/S 1" />
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="form-group">
										<label for="cpu2">CPU 2</label> <input type="number" min="0"
											class="form-control input-value" name="cpu2[]"
											placeholder="Tempo da CPU 2" />
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="form-group">
										<label for="es2">E/S 2</label> <input type="number" min="0"
											class="form-control input-value" name="es2[]"
											placeholder="Tempo da E/S 2" />
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
							<label for="">&nbsp;</label>
							<button type="button" class="btn btn-block btn-danger"
								onclick="apagarProcesso()">Apagar</button>
						</div>
					</div>
					<hr
						style="height: 5px; margin-left: 1px; margin-bottom: 8px; background-image: -webkit-linear-gradient(top, rgba(189, 204, 189, .8), rgba(0, 0, 0, 0));" />
				</div>
			</form>
		</div>
	</section>

	<footer style="padding: 25px 12px 1px 12px;">
		<div class="navbar navbar-default ">
			<div class="container-fluid margin">
				<p class="navbar-text pull-left">&copy; 2017 - Alan Possamai &amp;
					Eduardo Schenato, all rights reserved.</p>
				<a href="https://github.com/eduardoschenato/escalonamento_processos"
					target="_blank" class="navbar-btn btn pull-right"> <span
					class="glyphicon glyphicon-star"></span>Acess our github project
				</a>
			</div>
		</div>
	</footer>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
	<script>
            var contador = 1;

            function addProcesso() {
                contador++;
                var html = $("#container_processos .row-processo").first().clone();
                $(html).attr("id", "divProcesso" + contador);
              	$(html).find(".lead").text("Processo " + contador);
                $("#container_processos .row-processo").last().after(html);
                $("#divProcesso" + contador + " .input-value").val("");
            }

            function apagarProcesso() {
                if (confirm("Apagar processo?")) {
					if ( $("#container_processos .row-processo").length > 1 ) {
						$(event.target).parent().parent().remove();
					} else {
						console.log($(event.target).parent().parent());
						$(event.target).parent().parent().find(".input-value").val("");
					}
                }
            }

            function apagarTodosProcessos() {
                if (confirm("Apagar todos os processos?")) {
	            	contador = 1;
	            	$(".row-processo").each(function(){
	                	if ( $("#container_processos .row-processo").length > 1 ) {
							$(this).remove();
	                    } else {
	                    	$(this).find(".lead").text("Processo " + contador);
							$(this).find(".input-value").val("");
	                    }
	                });
                }
            }
        </script>

</body>
</html>
