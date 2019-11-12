<div id="{{ $component->makeDomId('main-navigation-items', $component->getModel()->id) }}">
@if ($component->getModel()->hasContainee('items'))
    <ul class="navigation sortable vertical ajax-overlay" data-update-url="{{ $component->getModel()->getControllerRoute('reorder', [ 'relation' => 'items' ]) }}">
    @foreach ($component->getModel()->getContainees('items') as $item)
        {!! $item->getModelViewerComponent()->render('include.main-navigation-items', [ 'container' => $component->getModel() ]) !!}
    @endforeach
    </ul>
@endif
</div>