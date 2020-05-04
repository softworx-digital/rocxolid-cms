<div id="{{ $component->getDomId('page-elements', $component->getModel()->getKey()) }}" style="margin-top: -15px;">
    <ul class="list-unstyled timeline timeline-no-overflow sortable vertical vertical-bordered ajax-overlay" data-update-url="{{ $component->getModel()->getControllerRoute('updatePageElementsOrder') }}">
    @foreach ($component->getModel()->pageElements() as $page_element)
        {!! $page_element->getModelViewerComponentInside($component)->render('in-page-elementable', [ 'page_elementable' => $component->getModel() ]) !!}
    @endforeach
    </ul>
</div>