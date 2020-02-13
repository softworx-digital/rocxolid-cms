<div id="{{ $component->getDomId('row-navigation-items', $component->getModel()->getKey()) }}">
@if ($component->getModel()->hasContainee('items'))
    <ul class="navigation sortable vertical ajax-overlay" data-update-url="{{ $component->getModel()->getControllerRoute('reorder', [ 'relation' => 'items' ]) }}">
    @foreach ($component->getModel()->getContainees('items') as $item)
        {!! $item->getModelViewerComponent()->render('include.row-navigation-items', [ 'container' => $component->getModel() ]) !!}
    @endforeach
    </ul>
@endif
</div>