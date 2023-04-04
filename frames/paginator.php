<div class="well well-sm">
    <div class="row">
    	<div class="col-md-2"><span class="label label-default"><strong><?php echo $TR ?></strong> Resultados</span></div>
        <div class="col-md-6">
			<ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul>
    	</div>
        <div class="col-md-4"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
</div>