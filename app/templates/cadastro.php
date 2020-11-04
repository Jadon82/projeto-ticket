<h3>Cadastro de chamados</h3>
<a href="<?= BASE_URL ?>">Voltar</a>

<form method="POST" action="<?= BASE_URL ?>/ticket.php?action=create_ticket">
  <label class="label">Título do chamado</label>
  <input type="text" class="input" name="title" value="" placeholder="Tipo de chamado">
  <label class="label">Tipo</label>
  <select class="select" name="ticket_type">
    <option value="">Selecione</option>
    <?php foreach($ticket_types as $key => $ticket_type) { ?>
      <option value="<?= $key ?>"><?= $ticket_type ?></option>
    <?php } ?>
  </select>
  <label class="label">Descrição</label>
  <textarea name="description" class="textarea" placeholder="Descrição" rows="10" cols="80"></textarea>
  <label class="label">Reportado por</label>
  <input type="text" class="input" name="reported_by" value="" placeholder="Reportado por">
  <label class="label">Responsável</label>
  <input type="text" class="input" name="responsable" value="" placeholder="Responsável">
  <button type="submit">Cadastrar chamado</button>
</form>
