<script src="assets/js/Chart.js"></script>
<script src="assets/js/utils.js"></script>



<?php
include "connection.php";
include "connectionMilitares.php";
if (($usuario != "")) {
} else {
	include "protegerPagina.php";
	protegerPagina();
}

$check = $pdo->prepare("SELECT * FROM punidos");
$check->execute();
$row   = $check->rowCount();

$checkPunidosBC = $pdo->prepare("SELECT * FROM punidos WHERE su = 'BC'");
$checkPunidosBC->execute();
$rowPunidosBC   = $checkPunidosBC->rowCount();

$checkPunidos1 = $pdo->prepare("SELECT * FROM punidos WHERE su = '1ªBO'");
$checkPunidos1->execute();
$rowPunidos1   = $checkPunidos1->rowCount();

$checkPunidos2 = $pdo->prepare("SELECT * FROM punidos WHERE su = '2ªBO'");
$checkPunidos2->execute();
$rowPunidos2   = $checkPunidos2->rowCount();

$checkPunidos3 = $pdo->prepare("SELECT * FROM punidos WHERE su = '3ªBO'");
$checkPunidos3->execute();
$rowPunidos3   = $checkPunidos3->rowCount();

date_default_timezone_set('America/Sao_Paulo');
$data   = date('Y-m-d');
$check2 = $pdo->prepare("SELECT * FROM punidos where :dataAtual BETWEEN inicio and DATE_ADD(liberdade, INTERVAL -1 DAY)");
$check2->bindParam(':dataAtual', $data);
$check2->execute();
$row2   = $check2->rowCount();

$checkPunidosAtivosBC = $pdo->prepare("SELECT * FROM punidos WHERE su = 'BC' and (:dataAtual BETWEEN inicio and DATE_ADD(liberdade, INTERVAL -1 DAY))");
$checkPunidosAtivosBC->bindParam(':dataAtual', $data);
$checkPunidosAtivosBC->execute();
$rowPunidosAtivosBC   = $checkPunidosAtivosBC->rowCount();

$checkPunidosAtivos1 = $pdo->prepare("SELECT * FROM punidos WHERE su = '1ªBO' and (:dataAtual BETWEEN inicio and DATE_ADD(liberdade, INTERVAL -1 DAY))");
$checkPunidosAtivos1->bindParam(':dataAtual', $data);
$checkPunidosAtivos1->execute();
$rowPunidosAtivos1   = $checkPunidosAtivos1->rowCount();

$checkPunidosAtivos2 = $pdo->prepare("SELECT * FROM punidos WHERE su = '2ªBO' and (:dataAtual BETWEEN inicio and DATE_ADD(liberdade, INTERVAL -1 DAY))");
$checkPunidosAtivos2->bindParam(':dataAtual', $data);
$checkPunidosAtivos2->execute();
$rowPunidosAtivos2   = $checkPunidosAtivos2->rowCount();

$checkPunidosAtivos3 = $pdo->prepare("SELECT * FROM punidos WHERE su = '3ªBO' and (:dataAtual BETWEEN inicio and DATE_ADD(liberdade, INTERVAL -1 DAY))");
$checkPunidosAtivos3->bindParam(':dataAtual', $data);
$checkPunidosAtivos3->execute();
$rowPunidosAtivos3   = $checkPunidosAtivos3->rowCount();

$check3            = $pdo->prepare("SELECT * FROM punidos WHERE :dataAtual BETWEEN inicio and DATE_ADD(liberdade, INTERVAL -1 DAY)");
$check3->bindParam(':dataAtual', $data);
$check3->execute();
$row3              = $check3->rowCount();

$check4            = $pdo->prepare("SELECT * FROM usuarios WHERE user_nivel = '1' and status='ATIVADO'");
$check4->execute();
$row4              = $check4->rowCount();

$check5            = $pdo->prepare("SELECT * FROM usuarios WHERE user_nivel = '2' and status='ATIVADO'");
$check5->execute();
$row5              = $check5->rowCount();

$consultamilitares = $pdoMilitares->prepare("SELECT * FROM `militares` where status='ATIVADO' ORDER BY `militares`.`subUnidade`,`militares`.`numero`  asc");
$consultamilitares->execute();
$militares         = $consultamilitares->rowCount();

$consultatotalsobraseresiduos = $pdo->prepare("SELECT * FROM sobraseresiduos;");
$consultatotalsobraseresiduos->execute();
$totaldedias                  = $consultatotalsobraseresiduos->rowCount();

$consultasobra   = $pdo->prepare("SELECT SUM(sobra) FROM sobraseresiduos;");
$consultasobra->execute();

$consultaresiduo = $pdo->prepare("SELECT SUM(residuos) FROM sobraseresiduos;");
$consultaresiduo->execute();
$ano             = date("Y");
$mes             = date("m");
$semana          = date("w");
//echo $semana;
$consultasobraMes   = $pdo->prepare("SELECT SUM(sobra) FROM sobraseresiduos where YEAR(sobraseresiduos.data) = :ano AND MONTH(sobraseresiduos.data) = :mes;");
$consultasobraMes->bindParam(':mes', $mes);
$consultasobraMes->bindParam(':ano', $ano);
$consultasobraMes->execute();

$consultaresiduoMes = $pdo->prepare("SELECT SUM(residuos) FROM sobraseresiduos where YEAR(sobraseresiduos.data) = :ano AND MONTH(sobraseresiduos.data) = :mes;");
$consultaresiduoMes->bindParam(':mes', $mes);
$consultaresiduoMes->bindParam(':ano', $ano);
$consultaresiduoMes->execute();

$consultasobraSemana   = $pdo->prepare("SELECT SUM(sobra) FROM sobraseresiduos where WEEK(sobraseresiduos.data, 1) = :semana AND YEAR(sobraseresiduos.data) = :ano");
$consultasobraSemana->bindParam(':semana', $semana);
$consultasobraSemana->bindParam(':ano', $ano);
$consultasobraSemana->execute();

$consultaresiduoSemana = $pdo->prepare("SELECT SUM(residuos) FROM sobraseresiduos where WEEK(sobraseresiduos.data, 1) = :semana AND YEAR(sobraseresiduos.data) = :ano");
$consultaresiduoSemana->bindParam(':semana', $semana);
$consultaresiduoSemana->bindParam(':ano', $ano);
$consultaresiduoSemana->execute();

$rowsobras = $consultasobra->fetch(PDO::FETCH_ASSOC);
$sobra     = $rowsobras['SUM(sobra)'] ?? 0;

$rowres  = $consultaresiduo->fetch(PDO::FETCH_ASSOC);
$residuo = $rowres['SUM(residuos)'] ?? 0;

$rowsobrasMes = $consultasobraMes->fetch(PDO::FETCH_ASSOC);
$sobraMes     = $rowsobrasMes['SUM(sobra)'];

$rowresMes  = $consultaresiduoMes->fetch(PDO::FETCH_ASSOC);
$residuoMes = $rowresMes['SUM(residuos)'];

$rowsobrasSemana = $consultasobraSemana->fetch(PDO::FETCH_ASSOC);
$sobraSemana     = $rowsobrasSemana['SUM(sobra)'];

$rowresSemana  = $consultaresiduoSemana->fetch(PDO::FETCH_ASSOC);
$residuoSemana = $rowresSemana['SUM(residuos)'];

$mediasobra   = number_format((float) ($sobra ?? 1 / $totaldedias ?? 1), 2);
$mediaresiduo = number_format((float) ($residuo ?? 1 / $totaldedias ?? 1), 2);
?>

<script>
	var BC = "<?php echo $rowPunidosBC; ?>";
	var PRIMEIRA = "<?php echo $rowPunidos1; ?>";
	var SEGUNDA = "<?php echo $rowPunidos2; ?>";
	var TERCEIRA = "<?php echo $rowPunidos3; ?>";



	var config = {
		type: 'bar',
		data: {
			datasets: [{
				data: [
					BC,
					PRIMEIRA,
					SEGUNDA,
					TERCEIRA,

				],
				backgroundColor: [

					window.chartColors.green,
					window.chartColors.red,
					window.chartColors.purple,
					window.chartColors.blue,

				],
				label: "Punições",
			}],
			labels: [

				'BC',
				'1ª Bia O',
				'2ª Bia O',
				'3ª Bia O'
			]
		},
		options: {
			responsive: true,
			legend: {
				position: '',
			},
			title: {
				display: true,
				text: 'Mova o mouse até o gráfico para ver a quantidade'
			},
			animation: {
				animateScale: true,
				animateRotate: true
			}
		}
	};





	<?php if ($row2 != 0) { ?>

		var BCA = "<?php echo $rowPunidosAtivosBC; ?>";
		var PRIMEIRAA = "<?php echo $rowPunidosAtivos1; ?>";
		var SEGUNDAA = "<?php echo $rowPunidosAtivos2; ?>";
		var TERCEIRAA = "<?php echo $rowPunidosAtivos3; ?>";

		var configA = {
			type: 'bar',
			data: {
				datasets: [{
					data: [
						BCA,
						PRIMEIRAA,
						SEGUNDAA,
						TERCEIRAA,
					],
					backgroundColor: [
						window.chartColors.green,
						window.chartColors.red,
						window.chartColors.purple,
						window.chartColors.blue,
					],
					label: "Punições",
				}],
				labels: [

					'BC',
					'1ª Bia O',
					'2ª Bia O',
					'3ª Bia O'
				]
			},
			options: {
				responsive: true,
				legend: {
					position: '',
				},
				title: {
					display: true,
					text: 'Mova o mouse até o gráfico para ver a quantidade'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
		};
	<?php } ?>
	window.onload = function() {
		<?php if ($row2 != 0) { ?>
			var ctxA = document.getElementById('chart-area1').getContext('2d');
			window.myPieA = new Chart(ctxA, configA);
		<?php } ?>
		var ctx = document.getElementById('chart-area').getContext('2d');
		window.myDoughnut = new Chart(ctx, config);
	};
</script>


<?php
$consultafaltapassar = $pdo->prepare("SELECT * FROM aosubcmt Where passeiAo ='' or assinaturaOfDia = '' ORDER BY doDia ASC");
$consultafaltapassar->execute();

$consultanrdocaANO   = $pdo->prepare("SELECT COUNT(*) as TOTAL FROM aosubcmt where passeiAo ='' or assinaturaOfDia = '' ORDER BY doDia ASC");
$consultanrdocaANO->execute();
$numero              = $consultanrdocaANO->fetch(PDO::FETCH_ASSOC);
if ($numero["TOTAL"] >= 1) {

	echo "<big>ATENÇÃO! HÁ PENDÊNCIAS NO(S) SEGUINTE(S) SERVIÇO(S):<br>";
	while ($resu = $consultafaltapassar->fetch(PDO::FETCH_ASSOC)) {
		$adjuntoo = str_replace(".jpg", "", $resu['assinaturaAdj']);
		$adjuntoC = str_replace(".png", "", $adjuntoo);
?>
		<?php echo "<label class='label label-danger'>DIA DO SV: " . date("d-m-Y", strtotime($resu['doDia'])) . " - OF DIA: " . $resu['ofdia'] . " - ADJ: " . $adjuntoC . " <br></label><br>"; ?>
<?php }
}
?>
</big>
<div class="panel-group">
	<div class="row">
		<center>Clique <a href="painel.php?func=trocarSenha" role=""> AQUI </a> para alterar sua senha <span class="glyphicon glyphicon-lock"></span>.</center>
		<br>
		<div class="col-md-12">

			<a href="painel.php?func=Oficiais">
				<div class="update-nag">
					<div class="update-split"><i class="glyphicon glyphicon-user"></i></div>
					<div class="update-text"> <strong><span class="badge"><?php echo $row5; ?></span> Oficiais de Dia</strong> ativos.</div>
				</div>
			</a>




			<a href="painel.php?func=Adjuntos">
				<div class="update-nag">
					<div class="update-split"><i class="glyphicon glyphicon-user"></i></div>
					<div class="update-text"><strong><span class="badge"><?php echo $row4; ?></span> Adjuntos</strong> ativos.</div>
				</div>
			</a>

			<!--a href="painel.php?func=militares"><div class="update-nag">
            <div class="update-split"><i class="glyphicon glyphicon-user"></i></div>
            <div class="update-text"><strong><span class="badge"><?php echo $militares; ?></span> Militares</strong> no banco de dados.</div>
        </div></a-->
			<br>

		</div>


	</div>
</div>

<center>
	</div>
	<div class="col-lg-12">

		<a href="painel.php?func=listarPunidos" class="col-lg-5">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<center><i class="glyphicon glyphicon-edit"></i> Ocorreram <strong><span class="badge"><?php echo $row; ?></span> PUNIÇÕES</strong> até o dia de hoje</center>
				</div>

				<div class="panel-body">

					<center>


						<body>
							<div id="canvas-holder" style="width:100%">
								<canvas id="chart-area"></canvas>
							</div>
					</center>
				</div>

			</div>

		</a>

		<a href="painel.php?func=punicoesAtivas" class="col-lg-5">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<center><i class="glyphicon glyphicon-exclamation-sign"></i> Punições ATIVAS: <strong><span class="badge"><?php echo $row2; ?></span></strong></center>
				</div>
				<center>
					<div class="panel-body">

						<center>


							<?php if ($row2 != 0) { ?>
								<div id="canvas-holder1" style="width:100%">
									<canvas id="chart-area1"></canvas>
								</div>

							<?php } else {
								echo "Não há.";
							} ?>
							</body>


						</center>

					</div>
				</center>
			</div>
		</a>





	</div>
	<center>
		Clique nos icones para ver mais informações!!!
	</center>