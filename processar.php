<?php
include_once 'classes/Algoritmo.php';
include_once 'classes/FCFS.php';
include_once 'classes/Fila.php';
include_once 'classes/ListaProcessos.php';
include_once 'classes/Prioridade.php';
include_once 'classes/Processo.php';
include_once 'classes/RoundRobin.php';
include_once 'classes/SJF.php';

if (isset($_POST["algoritmo"])) {
    $listaProcessos = ListaProcessos::getListaProcessos();
    $qtdeProcessos = count($listaProcessos);

    switch ($_POST["algoritmo"]) {
        case "fcfs":
            $algoritmo = new FCFS();
            $algoritmo->executar($listaProcessos);
            break;
        case "sjf":
            $algoritmo = new SJF();
            $algoritmo->executar($listaProcessos);
            break;
        case "rr":
            $algoritmo = new RoundRobin();
            $algoritmo->executar($listaProcessos);
            break;
        case "p":
            $algoritmo = new Prioridade();
            $algoritmo->executar($listaProcessos);
            break;
        default:
            break;
    }
}
?>
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
                            <h2 style="text-align: center;">Escalonador de Processos - Resultado</h2>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="overflow-y: auto;">
                        <h1>CPU</h1>
                        <table class="table table-bordered table-condensed table-striped">
                            <tr>
                                <td>&nbsp;</td>
                                <?php
                                for ($time = 0; $time < $algoritmo->getTime(); $time++) {
                                    echo "<td>" . $time . "</td>";
                                }
                                ?>
                            </tr>
                            <?php
                            for ($i = 0; $i < $qtdeProcessos; $i++) {
                                echo "<tr>";
                                echo "<td>" . $i . "</td>";

                                for ($time = 0; $time < $algoritmo->getTime(); $time++) {
                                    if ($algoritmo->getTimeCPUProcess($time) === null) {
                                        echo "<td>&nbsp;</td>";
                                    } elseif ($algoritmo->getTimeCPUProcess($time) == $i) {
                                        echo "<td>X</td>";
                                    } else {
                                        echo "<td>&nbsp;</td>";
                                    }
                                }

                                echo "</tr>";
                            }
                            ?>
                        </table>
                        <hr/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="overflow-y: auto;">
                        <h1>E/S</h1>
                        <table class="table table-bordered table-condensed table-striped">
                            <tr>
                                <td>&nbsp;</td>
                                <?php
                                for ($time = 0; $time < $algoritmo->getTime(); $time++) {
                                    echo "<td>" . $time . "</td>";
                                }
                                ?>
                            </tr>
                            <?php
                            for ($i = 0; $i < $qtdeProcessos; $i++) {
                                echo "<tr>";
                                echo "<td>" . $i . "</td>";

                                for ($time = 0; $time < $algoritmo->getTime(); $time++) {
                                    if ($algoritmo->getTimeESProcess($time) === null) {
                                        echo "<td>&nbsp;</td>";
                                    } elseif ($algoritmo->getTimeESProcess($time) == $i) {
                                        echo "<td>X</td>";
                                    } else {
                                        echo "<td>&nbsp;</td>";
                                    }
                                }

                                echo "</tr>";
                            }
                            ?>
                        </table>
                        <hr/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <a href="index.php" class="btn btn-block btn-default">Voltar para a Home</a>
                    </div>
                </div>
            </div>
        </section>

        <footer style="padding: 25px 12px 1px 12px;">
            <div class="navbar navbar-default ">
                <div class="container-fluid margin">
                    <p class="navbar-text pull-left">&copy; 2017 - Alan Possamai &amp;
                        Eduardo Schenato, all rights reserved.</p>
                    <a href="https://github.com/eduardoschenato/escalonamento_processos"
                       target="_blank" class="navbar-btn btn pull-right"> <span class="glyphicon glyphicon-star"></span>Acess our github project
                    </a>
                </div>
            </div>
        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>