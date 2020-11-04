<h3>Chamado #<?= $ticket->id_ticket ?> - <?= $ticket->title ?></h3>
<a href="<?= BASE_URL ?>">Voltar</a>
<dl class="pivot" style="width: 500px;">
  <dt>Id Chamado</dt>
  <dd>#<?= $ticket->id_ticket ?></dd>
  <dt>Título</dt>
  <dd><?= $ticket->title ?></dd>
  <dt>Criado em</dt>
  <dd><?= $ticket->created_at ?></dd>
  <dt>Status</dt>
  <dd><?= $ticket->status_text ?></dd>
  <dt>Descrição</dt>
  <dd><?= $ticket->description ?></dd>
  <dt>Reportado por</dt>
  <dd><?= $ticket->reported_by ?></dd>
  <dt>Responsável</dt>
  <dd><?= $ticket->responsable ?></dd>
</dl>

<table style="width: 500px">
  <thead>
    <tr>
      <th>Data</th>
      <th>Comentário</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($ticket->history as $history) { ?>
      <tr>
        <td><?= $history->created_at ?></td>
        <td><?= $history->description ?></td>
        <td><?= $history->status_text ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<form method="POST" action="<?= BASE_URL ?>/ticket.php?action=create_history">
  <input type="hidden" name="id_ticket" value="<?= $ticket->id_ticket ?>">
  <label class="label">Responsável</label>
  <input type="text" class="input" name="responsable" placeholder="Responsável" value="<?= $ticket->responsable ?>">
  <label class="label">Status</label>
  <select class="select" name="status">
    <option value="0" <?= $ticket->status == 0 ? 'selected' : '' ?>>Aberto</option>
    <option value="1" <?= $ticket->status == 1 ? 'selected' : '' ?>>Em andamento</option>
    <option value="2" <?= $ticket->status == 2 ? 'selected' : '' ?>>Fechado</option>
  </select>
  <label class="label">Comentários</label>
  <textarea type="text" class="textarea" name="comment" placeholder="Comentários"></textarea>
  <button type="submit">Atualizar</button>
</form>
