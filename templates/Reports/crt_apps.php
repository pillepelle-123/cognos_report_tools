<div class="apps index">
    <h1><?= $this->get('title') ?></h1>    
    <div class="app-list">
        <div class="app-card">
            <h3>Query Expander</h3>
            <p>Erweitern Sie Ihre Congos Queries mit zusätzlichen Parametern</p>
            <?= // $this->Html->link('Starten', ['controller' => 'Crtapps', 'action' => 'queryExpander'], ['class' => 'btn btn-primary'] ) 
            $this->Html->link('Starte "Query Expander"', [
                'plugin' => 'QueryExpander',
                'controller' => 'QueryExpander',
                'action' => 'queries'
            ]);
           
           ?>
            
        </div>
    </div>
</div>

<style>
.app-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}
.app-card {
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 5px;
    width: 300px;
}
</style>