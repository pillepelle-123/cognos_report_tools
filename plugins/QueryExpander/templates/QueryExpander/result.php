<?php
$modifiedXmlContent = $this->request->getSession()->read('QueryExpander.modifiedXmlContent');
$report = $this->request->getSession()->read('QueryExpander.report');

?>

<div class="query-expander result">
    <h1><?= $this->get('title') ?></h1>
    <div>  

        <?= $this->Form->create(null, [
            'url' => ['action' => 'resultDownload'],
            'type' => 'post',
            'id' => 'downloadForm'
        ]) ?>
        <?= $this->Form->button('XML herunterladen', [
            'class' => 'btn btn-success',
            'id' => 'downloadBtn'
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
    
    <div class="card mb-4">
        <div class="card-header">Modifizierte XML</div>
        <div class="card-body">
            <pre><?= h($modifiedXmlContent) ?></pre>
        </div>
    </div>
    
</div>
<script>
document.getElementById('downloadBtn').addEventListener('click', function(e) {
    // Formular absenden
    document.getElementById('downloadForm').submit();
    
    // Alternative: Direkter Download-Link
    // window.location.href = '<?= $this->Url->build(['action' => 'resultDownload']) ?>';
});
</script>