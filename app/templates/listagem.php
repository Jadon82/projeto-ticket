<h3>Listagem de chamados</h3>
<a href="?page=cadastro">Cadatrar chamado</a>
<table style="width: 100%;">
  <colgroup>
    <col style="width: 5%"> <!-- id chamado -->
    <col style="width: 15%"> <!-- titulo -->
    <col style="width: 10%"> <!-- tipo -->
    <col style="width: 10%"> <!-- status -->
    <col style="width: 20%"> <!-- descricao -->
    <col style="width: 10%"> <!-- criado em -->
    <col style="width: 10%"> <!-- reportado por -->
    <col style="width: 10%"> <!-- responsavel -->
    <col style="width: 10%"> <!-- acoes -->
  </colgroup>
  <thead>
    <tr>
      <th>#</th>
      <th>Título</th>
      <th>Tipo</th>
      <th>Status</th>
      <th>Descriçao</th>
      <th>Criado em</th>
      <th>Reportado por</th>
      <th>Responsável</th>
      <th class="actions">Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($tickets as $ticket) { ?>
    <tr>
      <td>#<?= $ticket->id_ticket ?></td>
      <td><?= $ticket->title ?></td>
      <td><?= $ticket->type_desc ?></td>
      <td><?= $ticket->status_text ?></td>
      <td><?= $ticket->description ?></td>
      <td><?= $ticket->created_at ?></td>
      <td><?= $ticket->reported_by ?></td>
      <td><?= $ticket->responsable ?></td>
      <td class="actions"><a href="/?page=detalhes_chamado&id_ticket=<?= $ticket->id_ticket?>">Ver</a>
    </tr>
    <?php } ?>
  </tbody>
</table>
