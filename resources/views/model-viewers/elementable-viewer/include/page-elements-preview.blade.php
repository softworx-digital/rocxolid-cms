<div id="{{ $component->getDomId('page-elements-preview', $component->getModel()->getKey()) }}">
    <div class="row">
        <iframe style="width: 100%; height: 1000px; padding: 0; margin: 0; border: 1px solid #ccc;" src="{{ $component->getModel()->getPreviewRoute() }}"></iframe>
    </div>
</div>