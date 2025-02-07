<?php

verificaPermissaoPagina(0);

$visitasOnline = DASH::listUsersOnline('tb_painel_admin.online');

$visitasHoje = DASH::listVisit('tb_painel_admin.visits');




// TODO: fazer a escolha na optional para puxar
?>


<main>
    <!-- criando página de estatísticas -->
    <div class="container">
        <div class="estatistica-box flex">
            <div class="center1 flex">
                <div class="stats-container flex">
                    <div class="list-stats flex">
                        <div class="list-stats-item">
                            <select class="dias" name="dias" id="dias" onchange="redirectToPage()">
                            <option value="" selected="">Visitas totais</option>
                                <option value="7">Visitas dos últimos 7 dias</option>
                                <option value="30">Visitas dos últimos 30 dias</option>
                            </select>



                        </div>
                    </div> <!-- list-stats -->
                    <div class="stats flex">
                        <div class="stats-box">
                            <p>N de visitas online</p>
                            <p><?php echo count($visitasOnline); ?></p>
                        </div><!-- stats-box -->
                        <div class="stats-box">

                            <p>Total de visitas hoje</p>
                            <p><?php echo $visitasHoje; ?></p>

                        </div><!-- stats-box -->
                        <div class="stats-box">
                            <?php
                            if (isset($_GET['dias'])) {
                                $diaInt = intval($_GET['dias']);
                                $visitasTotais = DASH::totalVisit('tb_painel_admin.visits', $diaInt);
                          
                            ?>
                                <p>Total de visitas </p>
                                <p><?php echo $visitasTotais; ?></p>
                            <?php } else {
                                 $visitasTotais = DASH::totalVisit('tb_painel_admin.visits');
                            ?>
                                <p>Total de visitas </p>
                                <p><?php echo $visitasTotais; ?></p>
                            <?php } ?>
                        </div><!-- stats-box -->
                    </div> <!-- stats -->
                </div> <!-- stats-container -->

                <div class="info-container flex">
                    <div class="info-acesso flex">
                        <div class="ip info-acesso-item">
                            <p>IP</p>
                        </div> <!-- ip -->
                        <div class="data info-acesso-item">
                            <p>data</p>
                        </div> <!-- data -->
                        <div class="acesso info-acesso-item">
                            <p>Última ação</p>
                        </div> <!-- acesso -->
                    </div> <!-- info-acesso -->

                    <div class="info-acesso flex">
                        <?php foreach ($visitasOnline as $key => $value) { ?>
                            <div class="ip info-acesso-item">
                                <?php echo $value['ip']; ?>
                            </div> <!-- ip -->
                            <div class="data info-acesso-item">
                                <?php
                                $dateBr = date('d/m/Y', strtotime($value['dia']));
                                echo $dateBr; ?>
                            </div> <!-- data -->
                            <div class="acesso info-acesso-item">
                                <?php echo $value['ultima_acao']; ?>
                            </div> <!-- acesso -->
                        <?php } ?>

                    </div> <!-- info-acesso -->
                </div> <!-- info-container -->
            </div> <!-- center1 -->
        </div> <!-- estatistica-box -->
    </div> <!-- container -->
    <!-- fim dapágina de estatistícas -->

    </div> <!-- main-container -->
</main>

<!-- VAI CORINTHIANS -->