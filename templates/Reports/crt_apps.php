<div class="apps index">
    <h1>App Hub</h1>    
    <div class="app-list">
        <div class="app-card">
            <h3>Query Expander</h3>
            <p>Erweitern Sie Ihre Cognos Queries mit zusätzlichen Parametern</p>
            <?=  $this->Html->link(
                'Starten',
                ['controller' => 'Crtapps', 'action' => 'queryExpander'],
                ['class' => 'btn btn-primary']
            ) 
           
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