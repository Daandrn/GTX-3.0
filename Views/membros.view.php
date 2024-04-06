<?php include __DIR__.'/parts/top.php';?>

<main class="principal">
    <div>
        <table id="membros">
            <caption>MEMBROS</caption>
            <thead>
                <tr>
                    <th style="width: 220px;">Nome</th>
                    <th style="width: 143px;">Origin</th>
                    <th style="width: 108px;">Cargo</th>
                    <th style="width: 143px;">Nick stream</th>
                    <th style="width: 78px;">Plataforma</th>
                </tr>
            </thead>
            <?php if (!empty($items)): ?>
            <?php foreach ($items as $membro): ?>
            <tr id="lista">
                <td><?php echo $membro->nome;?></td>
                <td><?php echo $membro->nick;?></td>
                <td><?php echo $membro->cargo_membro;?></td>
                <td>
                    <a id="linkcanal" href="https://<?php echo $membro->link_canal;?>" target="_blank" title="Clique aqui para ir ao canal!"><?php echo $membro->nickstream;?></a>
                </td>
                <td><?php echo $membro->plataforma_game;?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr id="lista">
                    <td colspan="5">Nenhum membro encontrado!</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</main>

<?php include __DIR__.'/parts/footer.php';?>